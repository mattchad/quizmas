<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Message extends CActiveRecord implements MessageComponentInterface 
{
    
	private $clients;
	private $buzzers_locked = 0;
	private $first_buzzed = null;
	private $frozen_buzzer = null;
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
        	$temp_player->connection = null;
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

        		//Save the connection to this player, incase we need to send them a private message
        		$player_chosen->connection = $from;
        		
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
        		
        		//Is the buzzer frozen?
        		if($this->frozen_buzzer === $Player->id)
        		{
	        		//Post a message on the server
	        		echo $Player->first_name . " Buzzed! - Frozen Buzzer";
        		}
        		else if(!$this->buzzers_locked)
        		{
	        		//Post a message on the server
	        		echo $Player->first_name . " Buzzed! - Locking Buzzers";

        			$this->buzzers_locked = microtime(true);
	        		$this->sendToAll(json_encode(array('type'=>'player_buzzed', 'player'=>$Player)));
	        		$this->sendToAll(json_encode(array('type'=>'lock_buzzer')));
	        		
	        		//Save this player, we're going to need to know who it is when the quizmaster responds
	        		$this->first_buzzed = $Player;
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
        	case 'incorrect_answer':
        	{
            	//The quizmaster has notified us that the answer is incorrect. 
            	
            	//Check if we still know who buzzed
            	if(!is_null($this->first_buzzed))
            	{
                	//Save the details of the player that is now frozen.
                	$this->frozen_buzzer = $this->first_buzzed->id;
            	}
            	
            	//Relay this message onto everyone else.
                $this->sendToAll(json_encode(array('type'=>'incorrect_answer')));
            	
            	//We also need to make sure that the buzzers get unlocked
                $this->unlockBuzzers();
            	
            	break;
        	}
        	case 'correct_answer':
        	{
            	//The quizmaster has notified us that the answer is correct. 
            	//We don't unlock the buzzers here, that's done when we click "next" 
            	
            	$Question = Question::nextQuestion($this->password);
            	$Player = User::model()->findByPk($this->first_buzzed->id);
        	
                if(!is_null($Question) && !is_null($Player))
                {
                    //Update the player's score
        			$Player->points = (int)$Player->points + (int)$Question->value; 
        			$Player->round_points = (int)$Player->round_points + (int)$Question->value; 
        			$Player->save(false, array('points', 'round_points'));
        			
        			//Mark the question as complete
        			$Question->complete = 1;
        			$Question->save(false, array('complete'));
        			
        			$this->sendToAll(json_encode(array('type'=>'update_points', 'player_id' => $Player->id, 'score'=>$Player->points, 'round_score'=>$Player->round_points)));
        			echo "Updating " . $Player->first_name . '\'s score (+' . (int)$Question->value . ')';
        			
        			//Relay this message onto everyone else.
                    $this->sendToAll(json_encode(array('type'=>'correct_answer')));
        		}     
            	            	
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
            	
            	//If there was a frozen buzzer, lets forget about it. 
            	$this->frozen_buzzer = null;
            	
            	//Get the details of the current Quizmaster
            	$Quizmaster = $this->resourceIdToPlayer($from->resourceId);
            	
            	//Go get the next incomplete question
            	$nextQuestion = Question::nextQuestion($this->password);
        	
                if(!is_null($nextQuestion))
                {
                    //Does the next question belong to this quizmaster?
                    if((int)$Quizmaster->id === (int)$nextQuestion->user_id)
                    {
                        $this->sendToAll(json_encode(array('type'=>'show_next_question', 'question_text'=>$nextQuestion->text, 'question_value'=>$nextQuestion->value, 'question_number'=>$nextQuestion->list_order)));
                        
                        //We also need to make sure that the buzzers get unlocked
                        $this->unlockBuzzers();
                    }
                    else
                    {
                        //Is the next Quizmaster connected to the game?
                        if(isset($this->current_players[$nextQuestion->user_id]))
                        {
                            //Locate the details of the new Quizmaster
                            $newQuizmaster = $this->current_players[$nextQuestion->user_id];
                            
                            //Notify the player that they're now the quizmaster
                    		$newQuizmaster->connection->send(json_encode(array('type' => 'show_quizmaster')));
                    		
                            //Post a message on the server. 
                            echo $newQuizmaster->first_name . " is now the quizmaster \n";
                		}
                		else
                		{
                    		//The next quizmaster isn't in the game
                            echo "The next quizmaster is not connected to the game. \n";
                		}
                		
                		//Set everyone's round score back to zero - this is a new round.
                		User::model()->updateAll(array('round_points'=>0));
                		
                		//Tell everyone that the round scores have been reset
                        $this->sendToAll(json_encode(array('type'=>'reset_round_scores')));
                		
                		//Notify the player that it's not their round, so show the buzzer
                		$from->send(json_encode(array('type' => 'show_buzzer')));
                		
                		//Post a message on the server. 
                		echo $Quizmaster->first_name . ' is now a player';
                    }
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
			
			//Detatch the player from the resourse ID and connection
			$Player->resource_id = null;
			$Player->connection = null;
			
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
    
    public function unlockBuzzers()
    {
        $this->buzzers_locked = 0;
        $this->sendToAll(json_encode(array('type'=>'unlock_buzzer')));
        echo "Next Question - Unlocking Buzzers";
        $this->first_buzzed = null;
        
        //Is there a frozen buzzer?
        if(!is_null($this->frozen_buzzer))
        {
            //Notify the player that they're now frozen
    		$this->current_players[$this->frozen_buzzer]->connection->send(json_encode(array('type' => 'frozen_buzzer')));
        }
    }


}