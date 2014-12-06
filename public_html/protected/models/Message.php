<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Message extends CActiveRecord implements MessageComponentInterface 
{
    
	private $clients;
	private $buzzers_locked = 0;
	private $available_players = array();
	private $current_players = array();
	private $password = null;

	public function __construct()
	{
        // Create a collection of clients
        $this->clients = new \SplObjectStorage;
        
        //Create an array of all the players, only containing the fields we need. 
        foreach(User::model()->findAll() as $Player)
        {
        	$temp_player = new stdClass();
        	$temp_player->id = $Player->id;
        	$temp_player->first_name = $Player->first_name;
        	$temp_player->last_name = $Player->last_name;
        	$temp_player->points = $Player->points;
        	$temp_player->resource_id = null;
        	$this->available_players[$Player->id] = $temp_player;
        }
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        
        // New connection, send it the current set of matches
      	$conn->send(json_encode(array('type' => 'choose_player', 'available_players'=>$this->available_players)));
      	
      	if($this->buzzers_locked)
      	{
      		$conn->send(json_encode(array('type' => 'lock_buzzer')));
      	}
      	
      	//Add the current players that have joined before we arrived. 
      	foreach($this->current_players as $Player)
      	{
      		$conn->send(json_encode(array('type' => 'new_player', 'player'=>$Player)));
      	}
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        
        $message = json_decode($msg);
        
        switch($message->type)
        {
        	case 'player_choice':
        	{
        		//#################################################################
        		//NEED SOMETHING HERE TO PREVENT THE SAME PLAYER BEING CHOSEN TWICE
        		//#################################################################
        		
        		//Locate the player we have chosen in the available players list
        		$player_chosen = $this->available_players[$message->player_id];
        		
        		//Link the player to the resource ID for this connection
        		$player_chosen->resource_id = $from->resourceId;
        		
        		//Move the player into the current players list
        		$this->current_players[$message->player_id] = $player_chosen;
        		
        		//Remove this player from the list of players available
        		unset($this->available_players[$message->player_id]);
        		
        		//Post a message on the server. 
        		echo $player_chosen->first_name . ' has joined the game';
        		
        		//Notify other players that someone else has joined the game.
        		$this->sendToAll(json_encode(array('type'=>'new_player', 'player' => $player_chosen)));
        		
        		$nextQuestion = Question::nextQuestion();
        	
                if(!is_null($nextQuestion) && $nextQuestion->user_id == $message->player_id)
                {
            		//Notify the player that it's not their round, so show the buzzer
            		$from->send(json_encode(array('type' => 'show_quizmaster')));
            		
            		//Post a message on the server. 
            		echo ' as the quizmaster';
                }
                else
                {
            		//Notify the player that it's not their round, so show the buzzer
            		$from->send(json_encode(array('type' => 'show_buzzer')));
            		
            		//Post a message on the server. 
            		echo ' as a player';
        		}
        		
        		break;
        	}
        	case 'buzzer':
        	{
        		//A player pressed their buzzer
        		$Player = $this->resourceIdToPlayer($from->resourceId);
        		
        		if(!$this->buzzers_locked)
        		{
	        		//Post a message on the server
	        		echo $Player->first_name . " Buzzed! - Locking Buzzers";

        			$this->buzzers_locked = microtime(true);
	        		$this->sendToAll(json_encode(array('type'=>'player_buzzed', 'player'=>$Player)));
	        		$this->sendToAll(json_encode(array('type'=>'lock_buzzer')));
        		}
        		else
        		{
        			$delay = number_format((microtime(true) - $this->buzzers_locked), 3);
	        		$this->sendToAll(json_encode(array('type'=>'player_buzzed_late', 'player'=>$Player, 'time'=> $delay)));
	        		echo $Player->first_name . " buzzed " . $delay . " seconds late";
        		}
        		
        		//$this->sendToAll(json_encode(array('type'=>'unlock_buzzer')));
        		//echo "Unlocking Buzzers \n";
        		break;
        	}
        	case 'unlock_round':
        	{
            	//We've received a request to unlock the round from a quizmaster. 
            	
            	$nextQuestion = Question::nextQuestion();
        	
                if(!is_null($nextQuestion))
                {
                    $Quizmaster = $nextQuestion->user;
                    
                    if(Hash::validate_password($message->password, $Quizmaster->password))
                    {
                        echo 'Request to unlock the round - password correct';
                        
                        //Notify the quizmaster that that password was wrong
                        $from->send(json_encode(array('type' => 'unlocked_round')));
                        
                        //Store the password for later use - displaying the questions. 
                        $this->password = $message->password;
                    }
                    else
                    {
                        echo 'Request to unlock the round - password incorrect';
                        
                        //Notify the quizmaster that that password was wrong
                        $from->send(json_encode(array('type' => 'password_incorrect')));
                    }
                }
            	break;
        	}
        	case 'next_question':
        	{
            	//We've been told that the Quizmaster wants to show the next question.
            	
            	//Go get the next incomplete question
            	$nextQuestion = Question::nextQuestion($this->password);
        	
                if(!is_null($nextQuestion))
                {
                    $this->sendToAll(json_encode(array('type'=>'show_next_question', 'question_text'=>$nextQuestion->text, 'question_value'=>$nextQuestion->value, 'question_number'=>$nextQuestion->list_order)));
                }
            	break;
        	}
        	/* case 'unlock_buzzer':
        	{
        		$this->buzzers_locked = 0;
        		$this->sendToAll(json_encode(array('type'=>'unlock_buzzer')));
        		echo "Unlocking Buzzers";
        		break;
        	}
        	case 'add_point':
        	{
        		$Player = User::model()->findByPk($message->player_id);
        		if($Player !== null)
        		{
        			$Player->points++; 
        			$Player->save(false);
        			
        			$this->sendToAll(json_encode(array('type'=>'add_point', 'player_id' => $message->player_id)));
        			echo "Adding a point to " . $Player->first_name . '\'s score';
        		}
        		break;
        	}
        	case 'subtract_point':
        	{
        		$Player = User::model()->findByPk($message->player_id);
        		if($Player !== null)
        		{
        			$Player->points--; 
        			$Player->save(false);
        			
        			$this->sendToAll(json_encode(array('type'=>'subtract_point', 'player_id' => $message->player_id)));
        			echo "Removing a point from " . $Player->first_name . '\'s score';
        		}
        		break;
        	} */
        	default:
        	{
        		break;
        	}
        }

        echo ' (' . $from->resourceId .  ")\n";

    }

    public function onClose(ConnectionInterface $conn)
    {
    	$alert = '';
    	
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        
        $Player = $this->resourceIdToPlayer($conn->resourceId);
        
        if($Player !== null)
        {
	        //Let all the other users know that we have one less player. 
			$this->sendToAll(json_encode(array('type'=>'player_disconnected', 'player' => $Player)));
			
			//Detatch the player from the resourse ID for that connection
			$Player->resource_id = null;
			
			//Post a message on the server
			$alert = $Player->first_name . ' has left the game';
			
			//Move the player back into the available players list.
			$this->available_players[$Player->id] = $Player;
			unset($this->current_players[$Player->id]);
		}
        
        if(!strlen(trim($alert)))
        {
        	$alert = 'Disconnected without choosing a player';
        }

        echo $alert . " (" . $conn->resourceId . ")\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
    
    
    // Custom function to message all connections the same message. 
    private function sendToAll($msg)
    {
    	foreach ($this->clients as $client)
        {
            $client->send($msg);
        }
    }
    
    private function resourceIdToPlayer($resource_id)
    {
    	foreach($this->current_players as &$Player)
        {
        	if($Player->resource_id == $resource_id)
        	{
        		return $Player;
        	}
        }
        return null;
    }


}