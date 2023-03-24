<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

if (!isset($_POST))

{
    $msg = "NO POST MESSAGE SET, POLITELY FUCK OFF";
    echo json_encode($msg);//log
    exit(0);
}
$request = $_POST;
$response = "unsupported request type, politely FUCK OFF";


$client = new rabbitMQClient("testRabbitMQ.ini","testServer"); //CHANGE TO CORRECT SERVER!!

switch (strtolower($request["type"]))
{
    case "searchbooks":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "searchBooks";
        $rabbitRequest['searchQuery'] = $request['searchQuery'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);

        break;
    case "getbook":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "getBook";
        $rabbitRequest['bookID'] = $request['bookID'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
	$response = $client->send_request($rabbitRequest);
	echo $response;
        break;
    case "getreadbook":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "getReadBook";
        $rabbitRequest['username'] = $request['username'];
        $rabbitRequest['bookID'] = $request['bookID'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);
        break;
    case "getreadbooks":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "getReadBooks";
        $rabbitRequest['username'] = $request['username'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);
        break;
    case "setreadbook":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "setReadBook";
        $rabbitRequest['username'] = $request['username'];
        $rabbitRequest['bookID'] = $request['bookID'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);
        break;
    case "getdiscussionposts":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "getDiscussionPosts";
        $rabbitRequest['bookID'] = $request['bookID'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);
        break;
    case "adddiscussionpost":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "addDiscussionPost";
        $rabbitRequest['username'] = $request['username'];
        $rabbitRequest['bookID'] = $request['bookID'];
        $rabbitRequest['post'] = $request['post'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);
        break;
    case "getrating":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "getRating";
        $rabbitRequest['username'] = $request['username'];
        $rabbitRequest['bookID'] = $request['bookID'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);
        break;
    case "setrating":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "setRating";
        $rabbitRequest['username'] = $request['username'];
        $rabbitRequest['bookID'] = $request['bookID'];
        $rabbitRequest['rating'] = $request['rating'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);
        break;
}
echo json_encode($response);
exit(0);



?>
