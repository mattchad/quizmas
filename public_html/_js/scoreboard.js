$(document).ready(function()
{
	//FUNCTIONS
	
		function connectToSocket()
		{
			conn = new WebSocket('ws://' + server_ip_address + ':8080');
		}
		
		function resizePlayers()
		{
			$('#scoreboard').height($(window).height()).width($(window).width());
			
			$('#scoreboard .player').each(function(i,e)
			{
				$(e).height(Math.floor($(window).height()/2)).width(Math.floor($(window).width()/5));
			});
			
			$('#scoreboard').isotope( 'reLayout' );
		}
		
		function reorderPlayers()
		{
			$('#scoreboard').isotope( 'reloadItems' );
			
			$('#scoreboard').isotope({ sortBy : 'number' });
			
			$('#scoreboard').isotope( 'reLayout' );
		}
		
	//INITIATE
	
		//Initiate the connection variable
		var conn
		
		//Connect to the server
		connectToSocket();
		
		resizePlayers();
		
		$('#scoreboard').isotope({
			masonry:
			{
				itemSelector: '.player',
			},
			getSortData:
			{
				number : function ( elem )
				{
					return parseInt( $(elem).find('.score').text() );
				},
				name : function ( elem )
				{
					return $(elem).find('.name').text();
				},
			},
			sortBy: 'number',
			sortAscending: false
		});
		
	
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
					$('#player_' + message.player.id).addClass('buzzed');

					document.getElementById('player_' + message.player.id + '_sound').play();
					break;
				}
				case 'unlock_buzzer':
				{
					$('#buzzer a').removeClass('locked');
					$('.buzzed').removeClass('buzzed');
					$('.player .time').html('');
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
					
					reorderPlayers();
					
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
					
					reorderPlayers();
					
					break;
				}
				case 'player_buzzed_late':
				{
					var player = $('#player_' + message.player.id);
					
					if(!$(player).hasClass('buzzed'))
					{
						var time = $('#player_' + message.player.id).find('.time');
						if(!$(time).html().length)
						{
							$(time).html(' + ' + message.time + ' s');
						}
					}
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
	
	$(document).on('click', 'div', function()
	{
		/* var player_1 = $('#scoreboard .player:eq(2)').clone();;
			$('#scoreboard').masonry('remove', $('#scoreboard .player:eq(2)'));
		
		$('#scoreboard').prepend($(player_1));
		$('#scoreboard').masonry('prepended', $(player_1));*/
	});
});
	