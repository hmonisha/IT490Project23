#!/usr/bin/php
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

///Extract this information out
$dbUser = "admin";
$dbPass = "IT490password";
$serverName = "localhost";
$loginDBName = "IT490";

function doLogin($username,$password)
{
        try{
                global $dbUser, $dbPass, $serverName, $loginDBName;
                $dbConn = new PDO("mysql:host=$serverName;dbname=$loginDBName", $dbUser, $dbPass);
                $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $loginStmt = $dbConn->prepare("INSERT INTO userLogin (username, passhash) VALUES (:username, :passhash) ");
                $loginStmt->execute([':username' => $username]);
                if($loginStmt->rowCount() < 0 or $loginStmt->rowCount() > 1){
                        echo "Error: Found incorrect information for user $username";
                        return False;
                } else {
                        $passHash = $loginStmt->fetch()[0];
                        if ($password == $passHash) {
                                return True;
                        }
                        return False;
                }
                return False;
        }catch(PDOExcept $v) {
                echo "Error: " . $e.getMessage();
                return False;
        }
    // lookup username in databas
    // check password
    return false;
    //return false if not valid
}

function getForum()
{

 $post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);
 $topic_id = filter_input(INPUT_POST, 'topic_id', FILTER_SANITIZE_NUMBER_INT);
 $post_content = filter_input(INPUT_POST, 'post_content', FILTER_SANITIZE_STRING);
 $post_owner = filter_input(INPUT_POST, 'post_owner', FILTER_SANITIZE_STRING);


 	try{
 
		$dbh = new PDO("mysql:host=$serverName;dbname=$loginDBName", $dbuser, $dbPass);
		$dbh =setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $dbh->prepare("INSERT INTO forum_posts (post_id, topic_id, post_content, post_owner) VALUES (:post_id, :topic_id, :post_content, :post_owner)");		$stmt = bindParam(':post_id', $post_id);
		$stmt = bindParam(':topic_id', $topic_id);
		$stmt = bindParam(':post_content', $post_content);
		$stmt = bindParam(':post_owner', $post_owner);	
 		
		$stmt->execute();
		echo "Message posted successfully";
	   } catch(PDOException $e) {
		   echo "Error posting message: " . $e->getMessage();
 		}
 
 		$dbh = null;


}


function getReviews()
{

	$bookName = filter_input(INPUT_POST, 'bookName', FILTER_SANITIZE_NUMBER_STRING);
 $reviewerName = filter_input(INPUT_POST, 'reviewerName', FILTER_SANITIZE_NUMBER_STRING);
 $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_INT);
 $review_text = filter_input(INPUT_POST, 'review_text', FILTER_SANITIZE_STRING);


        try{

                $dbh = new PDO("mysql:host=$serverName;dbname=$loginDBName", $dbuser, $dbPass);
                $dbh =setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $dbh->prepare("INSERT INTO book_reviews (bookName, reviewerName, rating, review_text) VALUES (:bookName, :reviewerName, :rating, :review_text)");               $stmt = bindParam(':bookName', $bookName);
                $stmt = bindParam(':reviewerName', $reviewerName);
                $stmt = bindParam(':rating', $rating);
                $stmt = bindParam(':review_text', $review_text);

                $stmt->execute();
                echo "Review posted successfully";
           } catch(PDOException $e) {
                   echo "Error posting review: " . $e->getMessage();
                }

                $dbh = null;



}











function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  $login = "";
  switch (strtolower($request['type']))
  {
  case "login":
          $pwd = hash('sha256',$request['password']);
          $login = doLogin($request['username'],$pwd);
          if($login){
                return array("returnCode" => '202', 'message'=>"Server received request and approved the login request.");

          }
          else {
                  return array("returnCode" => '401', 'message'=>"Server received request and denied the login request.");

          }
          break;
    case "validate_session":
      return doValidate($request['sessionId']);
  }
  $loginStr = $login ? 'True' : 'False';
  return array("returnCode" => '0', 'message'=>"Server received request and processed and replied with $loginStr");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");





function getResquest($request){


	$books = json_decode($bookInfo);

	$output = array();


	foreach($books->items as $book){
		$volume = $book->volumeInfo;
		$sale = $book->saleInfo;
		$name = $volume->title;
		$date = $volume->publisher;
		$publisher = $volume->publisher;
		$description = $volume->description;
		$image = 'https://covers.openlibrary.org/b/isbn/'.$volume->industryIdentifiers[0]->identifier.'-L.jpg';
		$isbn = $volume->industryIdentifiers[0]->identifier;
		$lang = $volume->language;
		$country = $sale->country;
		$printType = $volume->printType;
		$category = $volume->categories;
		$isAvailable = $sale->saleability=='FOR_SALE'?'True':'False';

	



}




echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();

?>

