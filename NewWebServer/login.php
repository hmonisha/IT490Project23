<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('even_logger.php');
if (!isset($_POST))

{
	$msg = "NO POST MESSAGE SET, POLITELY FUCK OFF";
	echo json_encode($msg);
	exit(0);
}
$request = $_POST;
$response = "unsupported request type, politely FUCK OFF";


$client = new rabbitMQClient("testRabbitMQ.ini","testServer"); //CHANGE TO CORRECT SERVER!!

switch ($request["type"])
{
	case "login":
		$response = "login, yeah we can do that";
		echo $response;
        	$rabbitRequest = array();
        	$rabbitRequest['type'] = "Login";
        	$rabbitRequest['username'] = $request['username'];
        	$rabbitRequest['password'] = $request['password'];
        	$rabbitRequest['message'] = "test WILL BE A KEY";
        	$response = $client->send_request($rabbitRequest);
        
	break;
	case "register":
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
