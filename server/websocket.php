<?php
//////ignore_user_abort(TRUE);
set_time_limit(0);
session_start();
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
require_once 'C:\wamp64\www\chatsystem-php-js\vendor\autoload.php';

class Chat implements MessageComponentInterface {
	protected $clients;
	protected $users;

	public function __construct() {
		$this->clients = new \SplObjectStorage;

	}

	public function onOpen(ConnectionInterface $conn) {
		//adding each websocket connection to $client
		$this->clients->attach($conn);
		// $this->users[$conn->resourceId] = $conn;
	}
	

	public function onClose(ConnectionInterface $conn) {
		$this->clients->detach($conn);
		// unset($this->users[$conn->resourceId]);
	}

	public function onMessage(ConnectionInterface $from,  $data) {
		$from_id = $from->resourceId;
		$data = json_decode($data);
		$type = $data->type;

		switch ($type) {
			case 'chat':
				$user_id = $data->user_id;
				$chat_msg = $data->chat_msg;
						
				//response(message) format to yourself
				$response_from = "<strong >You:</strong>" . $chat_msg. "<br><br>";

				//response(message) format to the rest of the clients
				$response_to = "<a href='profile.php?name=". $user_id. "' target='_blank'>".$user_id."</a>: ".$chat_msg."<br><br>"; 
				
				// Chat Output to all clients/members in the chatroom
				if($user_id=='')
				{
					$response_from="<b>🚨-You joined the chatroom-🚨</b><br><br>";
										
				}	
				
				//sending response to you
				$from->send(json_encode(array("type"=>$type,"msg"=>$response_from)));
				
				//sending response to rest of the clients
				foreach($this->clients as $client)
				{
					if($from!=$client)
					{
						$client->send(json_encode(array("type"=>$type,"msg"=>$response_to)));
					}
				}
				break;
				
				
		}
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		$conn->close();
	}
	
}
$server = IoServer::factory(
	new HttpServer(new WsServer(new Chat())),
	8000
);
$server->run();
/////ob_flush();
/////flush();
/////str_repeat("", 1500);
/////sleep(2);
?>