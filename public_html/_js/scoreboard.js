$(function ()
{
	//FUNCTIONS
	
		function connectToSocket()
		{
			conn = new WebSocket('ws://192.168.0.109:8080');
		}
		
	//INITIATE
	
		//Initiate the connection variable
		var conn
		
		//Connect to the server
		connectToSocket();
	
	//SOCKET EVENTS
		
		conn.onopen = function(e)
		{
			//We've opened a new socket connection to the server.
		};
		
		conn.onmessage = function(e)
		{
			//Choose what to do with this message from the server.
			var message = $.parseJSON(e.data);
			
			switch(message.type)
			{
				case 'new_player':
				{
					//We've been told that a player has joined the game, add them to the current player list. 
					$('#player_' + message.player.id).find('.connected').html('Yes');
					
					break;
				}
				case 'player_disconnected':
				{
					//We've been told that a player has left the game, remove them to the current player list. 
					$('#player_' + message.player.id).find('.connected').html('No');
					break;
				}
				case 'player_buzzed':
				{
					//We've been told that a player has left the game, remove them to the current player list. 
					$('#player_' + message.player.id).addClass('buzzed');
					break;
				}
				case 'unlock_buzzer':
				{
					//We've been told that a player has left the game, remove them to the current player list. 
					$('#buzzer a').removeClass('locked');
					$('.player').removeClass('buzzed');
					break;
				}
				default:
				{
					//$('body').append($('<p/>').html(message.players[0]));
					break;
				}
			}	
		};
	
	//MAINTENANCE
		
		setInterval(function()
		{
			if(conn.readyState >= 3)
			{
				//The connection is closing or closed. Start it up again. 
				//connectToSocket()
				
				//Unfortunately with an iphone it's not as easy as just restarting the connection, we're then unable to receive messages
				//location.reload(true);
			}
		}, 1000);
	
	//JQUERY EVENTS
			
		$(document).on('click', '#unlock', function(e)
		{
			conn.send(JSON.stringify({ type: 'unlock_buzzer' }));
			return false;
		});
});
	