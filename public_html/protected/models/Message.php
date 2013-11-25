<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Message extends CActiveRecord implements MessageComponentInterface 
{
    
	private $clients;
	private $buzzers_locked = false;
	private $available_players = array();
	private $current_players = array();

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

        			$this->buzzers_locked = true;
	        		$this->sendToAll(json_encode(array('type'=>'player_buzzed', 'player'=>$Player)));
	        		$this->sendToAll(json_encode(array('type'=>'lock_buzzer')));
        		}
        		else
        		{
	        		echo $Player->first_name . " while buzzers locked";
        		}
        		
        		//$this->sendToAll(json_encode(array('type'=>'unlock_buzzer')));
        		//echo "Unlocking Buzzers \n";
        		break;
        	}
        	case 'unlock_buzzer':
        	{
        		$this->buzzers_locked = false;
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
        	}
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