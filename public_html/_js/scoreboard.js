$(function ()
{
	//FUNCTIONS
	
		function connectToSocket()
		{
			conn = new WebSocket('ws://192.168.0.109:8080');
		}
		
		function resizePlayers()
		{
			$('#scoreboard .player').each(function(i,e)
			{
				$(e).height($(window).height()/2);
			});
		}
		
	//INITIATE
	
		//Initiate the connection variable
		var conn
		
		//Connect to the server
		connectToSocket();
		
		resizePlayers();
	
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
					$('#player_' + message.player.id + ' .board').addClass('buzzed');

					document.getElementById('player_' + message.player.id + '_sound').play();
					break;
				}
				case 'unlock_buzzer':
				{
					$('#buzzer a').removeClass('locked');
					$('.player .buzzed').removeClass('buzzed');
					break;
				}
				case 'add_point':
				{
					var points = parseInt( $('#player_' + message.player_id).find('.score').html() );
					$('#player_' + message.player_id).find('.score').html(points+1);
					
					//Can't do $('#add').play() for some reason. 
					var audio = document.getElementById('add');
					audio.currentTime = 0;
					audio.play();
					break;
				}
				case 'subtract_point':
				{
					var points = parseInt( $('#player_' + message.player_id).find('.score').html() );
					$('#player_' + message.player_id).find('.score').html(points-1);
	
					//Can't do $('#subtract').play() for some reason. 
					var audio = document.getElementById('subtract');
					audio.currentTime = 0;
					audio.play();
					
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
			resizePlayers();
		});
	
	//JQUERY EVENTS
	
});
	