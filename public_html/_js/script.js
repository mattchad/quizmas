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
				//The server is telling us to choose a player from the list provided. 
				case 'choose_player':
				{
					//Show just the choose player screen
					$('.screen').hide();
					$('#choose_player').html('').show();
					
					for(var i in message.available_players)
					{
						//Display all players that are available
						$('#choose_player').append(
							$('<p>').append(
								$('<a>').addClass('player').data('player_id', message.available_players[i].id).attr('href', '#').html(message.available_players[i].first_name)
							)
						);
					}
					
					break;
				}
				case 'add_player':
				{
					//We've been told that a player has joined the game, add them to the current player list. 
					$('#current_players').append(
						$('<p>').addClass('player').html(message.player.first_name).data('player_id', message.player.id).attr('id', 'current_player_' + message.player.id)
					);
					
					break;
				}
				case 'remove_player':
				{
					//We've been told that a player has left the game, remove them to the current player list. 
					$('#current_player_' + message.player.id).remove();
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
				window.location.replace("/");
			}
		}, 1000);
	
	//JQUERY EVENTS
			
			//Tell the server what player we want to be. 
			$(document).on('click', '#choose_player a', function(e)
			{
				conn.send(JSON.stringify({ type: 'player_choice', player_id: $(this).data('player_id') }));
				
				$('.screen').hide();
				$('#current_players').show();
	
				return false;
			});
});
	