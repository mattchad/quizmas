$(function ()
{
	//FUNCTIONS
	
		function connectToSocket()
		{
			conn = new WebSocket('ws://' + server_ip_address + ':8080');
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
				case 'lock_buzzer':
				{
					$('#unlock_buzzers').html('Unlock Buzzers');
					break;
				}
				case 'unlock_buzzer':
				{
					$('#unlock_buzzers').html('Buzzers Active');
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
			
		$(document).on('touchstart click', '#unlock_buzzers', function(e)
		{
			e.stopPropagation();
			
			conn.send(JSON.stringify({ type: 'unlock_buzzer' }));
			return false;
		});
		
		$(document).on('touchstart click', '.player .add', function(e)
		{
			e.stopPropagation();
			
			var player = $(this).closest('.player');
			conn.send(JSON.stringify({ type: 'add_point', player_id: $(player).data('id') }));
			return false;
		});
		
		$(document).on('touchstart click', '.player .subtract', function(e)
		{
			e.stopPropagation();
			
			var player = $(this).closest('.player');
			conn.send(JSON.stringify({ type: 'subtract_point', player_id: $(player).data('id') }));
			return false;
		});
});
	