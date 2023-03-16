<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('event_logger.php');

if (!isset($_POST))

{
    $msg = "NO POST MESSAGE SET, POLITELY FUCK OFF";
    echo json_encode($msg);//log
    exit(0);
}
$request = $_POST;
$response = "unsupported request type, politely FUCK OFF";


$client = new rabbitMQClient("testRabbitMQ.ini","testServer"); //CHANGE TO CORRECT SERVER!!

switch ($request["type"])
{
    case "searchBooks":
        $response = "login, yeah we can do that";
        echo $response;
        $rabbitRequest = array();
        $rabbitRequest['type'] = "searchBooks";
        $rabbitRequest['searchQuery'] = $request['searchQuery'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);

        break;
    case "getBook":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "getBook";
        $rabbitRequest['bookID'] = $request['bookID'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);
        break;
    case "readBook":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "readBook";
        $rabbitRequest['username'] = $request['username'];
        $rabbitRequest['bookID'] = $request['bookID'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);
        break;
    case "getReviews":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "getReviews";
        $rabbitRequest['bookID'] = $request['bookID'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);
        break;
    case "addReview":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "addReview";
        $rabbitRequest['username'] = $request['addReview'];
        $rabbitRequest['bookID'] = $request['bookID'];
        $rabbitRequest['review'] = $request['review'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);
        break;
    case "getRating":
        $rabbitRequest = array();
        $rabbitRequest['type'] = "getRating";
        $rabbitRequest['username'] = $request['getRating'];
        $rabbitRequest['bookID'] = $request['bookID'];
        $rabbitRequest['message'] = "test WILL BE A KEY";
        $response = $client->send_request($rabbitRequest);
        break;
    case "setRating":
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
