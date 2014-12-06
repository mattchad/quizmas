$(function ()
{
	//FUNCTIONS
	
		function connectToSocket()
		{
			conn = new WebSocket('ws://' + getWsServerIP() + ':8080');
		}
				
	//INITIATE
	
		//Initiate the connection variable
		var conn;
		
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
							$('<li>').attr('id', 'player_' + message.available_players[i].id).append(
								$('<a>').data('player_id', message.available_players[i].id).attr('href', '#').html(message.available_players[i].last_name)
							)
						);
					}
					
					break;
				}
				case 'show_buzzer':
				{
    				//Quizmas is telling us that we're now a player.
    				$('.screen').hide();
    				$('#password').blur();
                    $('#buzzer').show();
                    
    				break;
				}
				case 'show_quizmaster':
				{
    				//Quizmas is telling us that we're the quizmaster
    				$('.screen').hide();
                    $('#quizmaster').show();
                    
    				break;
				}
				case 'password_incorrect':
				{
    				//We've received notification that the password we entered was incorrect.
    				$('#password').val('');
    				break;
				}
				case 'unlocked_round':
				{
    				//The password we entered was correct, we've been notified that the round is unlocked.
    				$('#quizmaster .password').hide();
    				$('#quizmaster .next').show();
    				break;
				}
				case 'show_next_question':
				{
    				//The next question is about to show.
    				$('#next').hide();
                    $('#waiting').show();
                    break;
				}
				case 'player_buzzed':
				{
    				//A player has buzzed. We need to show correct/incorrect options
    				
    				//We only do this if we're currently on the waiting screen.
    				if($('#waiting:visible').length)
    				{
        				$('#waiting').hide();
        				$('#correct').show();
        				$('#incorrect').show();
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
    				//Someone has buzzed, so we need to lock the buzzer and change the text
					$('#buzzer').addClass('buzzer_locked').html('Locked');
					break;
				}
				case 'unlock_buzzer':
				{
    				//We're unlocking and unfreezing buzzers and changing the text
					$('#buzzer').removeClass('buzzer_frozen').removeClass('buzzer_locked').html('Buzz');
					break;
				}
				case 'frozen_buzzer':
				{
    				//This buzzer is frozen. Mark it as such and change the text.
					$('#buzzer').addClass('buzzer_frozen').html('Frozen');
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
			
	//JQUERY EVENTS
			
			//Tell the server what player we want to be. 
			$(document).on('click', '#choose_player a', function(e)
			{
				conn.send(JSON.stringify({ type: 'player_choice', player_id: $(this).data('player_id') }));
				
				return false;
			});
			
			$(document).on('touchstart click', '#buzzer', function(e)
			{
				e.stopPropagation();
				
				conn.send(JSON.stringify({ type: 'buzzer' }));
				return false;
			});
			
			$(document).on('touchstart click', '#unlock_round', function(e)
			{
				e.stopPropagation();
				
				var password = $('#password').blur().val();
				
				conn.send(JSON.stringify({ type: 'unlock_round', 'password': password }));
				return false;
			});
			
			$(document).on('touchstart click', '#next', function(e)
			{
				e.stopPropagation();
				
				conn.send(JSON.stringify({ type: 'next_question' }));
				return false;
			});
			
			$(document).on('touchstart click', '#incorrect', function(e)
			{
				e.stopPropagation();
				
				conn.send(JSON.stringify({ type: 'incorrect_answer' }));
				
				$('#waiting').show();
				$('#correct').hide();
				$('#incorrect').hide();
				return false;
			});
			
			$(document).on('touchstart click', '#correct', function(e)
			{
				e.stopPropagation();
				
				conn.send(JSON.stringify({ type: 'correct_answer' }));
				
				$('#next').show();
				$('#correct').hide();
				$('#incorrect').hide();
				return false;
			});
});
	