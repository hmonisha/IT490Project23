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


function addUser($username,$passhash){

	$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO userLogin (username, passhash) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $passhash);
        $stmt->execute();



        echo "User added successfully";
        $stmt->close();
        $conn->close();


}



function getPassHash($username){

	$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

	if ($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT username FROM userLogin WHERE username=$username";
	$result = $conn->query($sql);

	if ($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
		 echo "username: " . $row["username"]. "<br>";

		} else {

		  echo "0 results";
		}

		$conn->close();
	


}


function addBook($bookName, $publishedBy, $publishedDate, $description, $image, $pageCount, $authors, $id, $language, $publishedCountry, $printType, $category, $price){

	$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

	if ($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
	}

	$stmt = $conn->prepare("INSERT INTO books (bookName, publishedBy, description, image, pageCount, authors, id, language, publishedCountry, printType, category, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssisbisissssd", $bookName, $publishedBy, $decription, $image, $pageCount, $authors, $id, $language, $publishedCountry, $printType, $category, $price);
	$stmt->execute();



	echo "Book added successfully";
	$stmt->close();
	$conn->close();




}


function getBook($bookName, $publishedBy, $publishedDate, $description, $image, $pageCount, $authors, $id, $language, $publishedCountry, $printType, $category, $price){

$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT bookname, publishedBy, publishedDate, description, image, pageCount, authors, id, language, publishedCountry, printType, category, price FROM books WHERE bookname = $bookName";
        $result = $conn->query($sql);

        if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                 echo "bookName: " . $row["bookName"]. "publishedBy: " . $row["publishedBy"]. "publishedDate: " . $row["publishedDate"]. "description: " . $row["description"]. "image: " . $row["image"]. "pageCount: " . $row["pageCount"]. "authors: " . $row["authors"]. "id: " . $row["id"]. "language: " . $row["language"]. "publishedCountry: " . $row["publishedCountry"]. "printType: " . $row["printType"]. "category: " . $row["category"]. "price: " . $row["price"]. "<br>";

                } else {

                  echo "0 results";
                }

                $conn->close();




}



function addForum($post_id, $topic_id, $post_content, $post_date, $post_owner){

$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO forum_posts (post_id, topic_id, post_content, post_date, post_owner) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisis", $post_id, $topic_id, $post_content, $post_date, $post_owner);
        $stmt->execute();



        echo "Forum added successfully";
        $stmt->close();
        $conn->close();



}	


function getForum($post_id, $topic_id, $post_content, $post_date, $post_owner){
	
	$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT post_id, topic_id, post_content, post_date, post_owner FROM forum_posts WHERE post_id = $post_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                 echo "post_id: " . $row["post_id"]. "topic_id: " . $row["topic_id"]. "post_content: " . $row["post_content"]. "post_owner: " . $row["post_owner"]. "<br>";

                } else {

                  echo "0 results";
                }

                $conn->close();





}




function addReviews($id, $bookName, $reviewerName, $reviewDate, $rating, $review_text){

	$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO book_reviews (id, bookName, reviewerName, reviewDate, rating, review_text) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issiis", $id, $bookName, $reviewerName, $reviewDate, $rating, $review_text);
        $stmt->execute();



        echo "Review added successfully";
        $stmt->close();
        $conn->close();





}


function getReviews($id, $bookName, $reviewerName, $reviewDate, $rating, $review_text){

$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, bookName, reviewerName, reviewDate, rating, review_text FROM book_reviews WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                 echo "id: " . $row["id"]. "bookName: " . $row["bookName"]. "reviewerName: " . $row["reviewerName"]. "reviewDate: " . $row["reviewDate"]. "rating: " . $row["rating"]. "review_text: " . $row["review_text"]. "<br>";

                } else {

                  echo "0 results";
                }

                $conn->close();




}

function doRegister($username,$password)
{
        try{
                global $dbUser, $dbPass, $serverName, $loginDBName;
                $dbConn = new PDO("mysql:host=$serverName;dbname=$loginDBName", $dbUser, $dbPass);
                $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $loginStmt = $dbConn->prepare("INSERT INTO userLogin (username, passhash) VALUES (:username, :passhash) ");
                $loginStmt->execute([':username' => $username], ':passhash' => $passHash);
                if ($loginStmt->rowCount() == 1) {
                    return true; 
                } else {
                    return false; 
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

function getbookdata($data){


$books = json_decode($data)

$output = array();


foreach($books->data as $books){
	$bookJsonArr = array(
		$name->title, 
		$publisher->publishedBy,
		$date->publishedDate,
		$description->description,
		$image->image,
		$pageCount->pageCount,
		$authors->authors,
		$isbn->ID,
		$lang->language,
		$country->publishedCountry,
		$printType->printType,
		$category->category,
		$isAvailable==NULL?"False":$isAvailable->isAvailable,
		$price==NULL?0:$price->price,
		$link->link
		);




return $output;


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
  $register = "";
  switch (strtolower($request['type']))
  {
  case "login":
          $pwd = hash('sha256',$request['password']);
          $login = doRegister($request['username'],$pwd);
          if($login){
                return array("returnCode" => '202', 'message'=>"Server received request and approved the login request.");

          }
          else {
                  return array("returnCode" => '401', 'message'=>"Server received request and denied the login request.");

          }
          break;
    case "registration";
        $pwd = hash('sha256',$request['password']);
        $register = doRegister($request['username'],$pwd);
        if($register){
            return array("returnCode" => '202', 'message'=>"Server received request and approved the user registration request.");

        }
        else {
                return array("returnCode" => '401', 'message'=>"Server received request and denied the registration request.");

        }
        break;
  }
  $loginStr = $login ? 'True' : 'False';
  return array("returnCode" => '0', 'message'=>"Server received request and processed and replied with $loginStr");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");



echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();

?>

