<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('event_logger.php');

if (!isset($_POST))

{
	$msg = "NO POST MESSAGE SET, POLITELY FUCK OFF";
	echo json_encode($msg);
	exit(0);
}
$request = $_POST;
$response = "";




$client = new rabbitMQClient("testRabbitMQ.ini","testServer"); //CHANGE TO CORRECT SERVER!!


switch ($request["type"])
{
	case "login":
		event_logger('error', 'Something went wrong!');
		$response = "login, yeah we can do that";
        	$rabbitRequest = array();
        	$rabbitRequest['type'] = "Login";
        	$rabbitRequest['username'] = $request['username'];
        	$rabbitRequest['password'] = $request['password'];
        	$rabbitRequest['message'] = "test WILL BE A KEY";
        	$response = $client->send_request($rabbitRequest);
        
	break;
	case "registration":
		$rabbitRequest = array();
		$rabbitRequest['type'] = "registration";
		$rabbitRequest['username'] = $request['username'];
		$rabbitRequest['password'] = $request['password'];
		$rabbitRequest['message'] = "test WILL BE A KEY";
		$response = $client->send_request($rabbitRequest);
		break;
}
echo json_encode($response);
exit(0);



?>
