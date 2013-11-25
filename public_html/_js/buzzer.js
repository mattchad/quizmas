$(function ()
{
	//FUNCTIONS
	
		function connectToSocket()
		{
			conn = new WebSocket('ws://192.168.0.109:8080');
		}
		
		function resizeBuzzer()
		{
			var height = $(window).height();
			$('#buzzer a').height(height).css('line-height', height + 'px');
		}
		
	//INITIATE
	
		//Initiate the connection variable
		var conn
		
		//Connect to the server
		connectToSocket();
		
		resizeBuzzer();
	
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
							$('<li>').attr('id', 'player_' + message.available_players[i].id).append(
								$('<a>').data('player_id', message.available_players[i].id).attr('href', '#').html(message.available_players[i].last_name)
							)
						);
					}
					
					break;
				}
				case 'new_player':
				{
					//We've been told that a player has joined the game, remove them to the choose player screen. 
					$('#player_' + message.player.id).remove();
					break;
				}
				case 'player_disconnected':
				{
					//We've been told that a player has left the game, add them to the choose player screen. 
					$('#choose_player').append(
						$('<li>').attr('id', 'player_' + message.player.id).append(
							$('<a>').data('player_id', message.player.id).attr('href', '#').html(message.player.last_name)
						)
					);
					break;
				}
				case 'lock_buzzer':
				{
					$('#buzzer a').addClass('locked').html('');
					break;
				}
				case 'unlock_buzzer':
				{
					$('#buzzer a').removeClass('locked').html('Press me');
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
				location.reload(true);
			}
		}, 1000);
		
		$(window).resize(function()
		{
			resizeBuzzer();
		});
	
	//JQUERY EVENTS
			
			//Tell the server what player we want to be. 
			$(document).on('click', '#choose_player a', function(e)
			{
				conn.send(JSON.stringify({ type: 'player_choice', player_id: $(this).data('player_id') }));
				
				$('.screen').hide();
				$('#buzzer').show();
	
				return false;
			});
			
			$(document).on('touchstart click', '#buzzer a', function(e)
			{
				e.stopPropagation();
				
				conn.send(JSON.stringify({ type: 'buzzer' }));
				return false;
			});
});
	