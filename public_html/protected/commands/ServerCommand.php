<?php 
	use Ratchet\Server\IoServer;
	use Ratchet\WebSocket\WsServer;
	
	require dirname(__DIR__) . '/vendor/autoload.php';

	class ServerCommand extends CConsoleCommand
	{
		public function run($args)
		{
			$server = IoServer::factory(
			    new WsServer(
			        new Message()
			    )
			    , 8080
			);
			
			$server->run();
		}
	}
?>