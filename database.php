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

	global $dbUser, $dbPass, $serverName, $loginDBName;



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


	global $dbUser, $dbPass, $serverName, $loginDBName;

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

function sendSearch($query) {
    $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
    $rabbitRequest = array();
    $rabbitRequest['type'] = 'booksearch';
    $rabbitRequest['query'] = $query;
    $response = $client->send_request($rabbitRequest);
    if($response['returnCode'] == '202') {
        $bookJson = $response['bookJson'];
        $books = json_decode($bookJson);
        foreach($books as $book){
            addBook($book->bookName,$book->publishedBy,$book->publishedDate,$book->description, $book->image,$book->pageCount,$book->authors,$book->ID,$book->language,$book->publishedCountry,$book->printType,$book->category,$book->price,$book->link);
        }
        return true;
    } else {
        return false;
        //log failure in finding books
    }

}

function searchBooks($bookQuery, $firstRun = TRUE) {

    $conn = new mysqli($serverName, $dbUser, $dpPass, $loginDBName);

    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT bookName, image, authors, publishedBy,price,link, id FROM books WHERE bookName LIKE %?% LIMIT 10");
    $stmt->bind_param("s",$bookQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows >= 10 or !$firstRun) {
        $returnJSON = "[";
        while($row = $result->fetch_array()) {
            $returnJSON .= "{'bookName':$row['bookName'],'img':$row['image'],'authors':$row['authors'],'publisher':$row['publishedBy'],'price':$row['price'],''buyLink:$row['link'],'id':$row['ID']},";
        }
        $returnJSON = substr($returnJSON, 0, -1) . "]";
        return $returnJSON;
    } else {
        if(sendSearch($bookQuery)){
            searchBooks($bookQuery, false);
        } else {
            return "";
        }
    }
}


function addBook($bookName, $publishedBy, $publishedDate, $description, $image, $pageCount, $authors, $id, $language, $publishedCountry, $printType, $category, $price, $link){

	global $dbUser, $dbPass, $serverName, $loginDBName;

	$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

	if ($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
	}

	$stmt = $conn->prepare("INSERT INTO books (bookName, publishedBy, description, image, pageCount, authors, id, language, publishedCountry, printType, category, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssisbisissssdb", $bookName, $publishedBy, $decription, $image, $pageCount, $authors, $id, $language, $publishedCountry, $printType, $category, $price, $link);
	$stmt->execute();



	echo "Book added successfully";
	$stmt->close();
	$conn->close();




}


function getBook($bookName, $publishedBy, $publishedDate, $description, $image, $pageCount, $authors, $id, $language, $publishedCountry, $printType, $category, $price, $link){

	global $dbUser, $dbPass, $serverName, $loginDBName;

	$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT bookname, publishedBy, publishedDate, description, image, pageCount, authors, id, language, publishedCountry, printType, category, price, link FROM books WHERE bookname = $bookName";
        $result = $conn->query($sql);

        if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                 echo "bookName: " . $row["bookName"]. "publishedBy: " . $row["publishedBy"]. "publishedDate: " . $row["publishedDate"]. "description: " . $row["description"]. "image: " . $row["image"]. "pageCount: " . $row["pageCount"]. "authors: " . $row["authors"]. "id: " . $row["id"]. "language: " . $row["language"]. "publishedCountry: " . $row["publishedCountry"]. "printType: " . $row["printType"]. "category: " . $row["category"]. "price: " . $row["price"]. "link:" . $row["link"]. "<br>";

                } else {

                  echo "0 results";
                }

                $conn->close();




}



function addDiscussionPost($bookID, $post_content, $post_owner){

	global $dbUser, $dbPass, $serverName, $loginDBName;

	$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO forum_posts (post_id, topic_id, post_content, post_owner) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisis", $post_id, $bookID, $post_content, $post_owner);
        $stmt->execute();



        echo "Forum added successfully";
        $stmt->close();
        $conn->close();



}	


function getDiscussionPosts($bookID){
	
	global $dbUser, $dbPass, $serverName, $loginDBName;

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



function getReadbook($bookID, $username){

global $dbUser, $dbPass, $serverName, $loginDBName;

conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM readBook bookID, username WHERE bookID = $bookID";	$result= $conn->query($sql);

	if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
			echo "BookID: " . $row["bookID"]. "Username: " . $row["username"]. "<br>";

		} else {

			echo "0 results";
		}

		$conn->close;



}




function setReadbook($bookID, $username){


global $dbUser, $dbPass, $serverName, $loginDBName;



   $conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO bookID, username) VALUES (?, ?)");
        $stmt->bind_param("is", $bookID, $username);
        $stmt->execute();



        echo "Readbook added successfully";
        $stmt->close();
	$conn->close();




}




function addReview($bookName, $reviewerName, $rating){


	global $dbUser, $dbPass, $serverName, $loginDBName;
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





function getReview($bookid, $reviewerName){

        global $serverName, $dbUser, $dbPass, $loginDBName
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


$books = json_decode($data);

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



        function getSmallBook($bookID) {
            try{
                global $dbUser, $dbPass, $serverName, $loginDBName;
                $dbConn = new PDO("mysql:host=$serverName;dbname=$loginDBName", $dbUser, $dbPass);
                $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $searchStmt = $dbConn->prepare("SELECT bookName, image, authors, publishedBy, id FROM books WHERE bookID = :bookID ");
                $searchStmt->execute([':bookID' => $bookID]);
                if ($searchStmt->rowCount() == 1) {
                    foreach($searchStmt->fetch() as $book) {
                        return "{'bookName':".$book['bookName'].",'img':".$book['image'].",'authors':".$book['authors'.", 'publisher':".$book['publishedBy'].",'id'".$book['id'."}";
                    }
                } else {
                    //error
                    return '';
                }
                return '';
        }catch(PDOExcept $v) {
                echo "Error: " . $e.getMessage();
                return '';
                //error
            }
        }
        }
}


function getReadBooks($username) {
            global $serverName, $dbUser, $dbPass, $loginDBName;

    $conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT bookID,username FROM readBook WHERE username = $username";
    $result = $conn->query($sql);

    if ($result->num_rows > 0){

        $returnJson = "["

        while($row = $result->fetch_assoc()) {
            $returnJson .= getSmallBook($row['bookID']).',';
        }
        $returnJson = substr($returnJson,0,-1);
        $conn->close();
        return $returnJson;
        } else {
            $conn->close();
            return "'books':''";
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
          $login = doLogin($request['username'],$pwd);
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
      case 'searchbooks':
          $query = $request['searchQuery'];
          $result = searchBooks($query);
          if($result = "") {
            //ERROR
          } else {
            return array("returnCode" => '202', 'books'=> $result);
          }
          break;
      case 'getbook':
          $bookID = $request['bookID'];
          $result = getBook($bookID);
          if($result = "") {
              //ERROR
          } else {
              return array("returnCode" => '202', 'data'=> $result);
          }
          break;
      case 'getreadbook':
          $username = $request['username'];
          $bookID = $request['bookID'];
          $result = getReadBook($bookID,$username);
          if($result = "") {
              //ERROR
          } else {
              return array("returnCode" => '202', 'data'=> $result);
          }
          break;
      case 'setreadbook':
          $username = $request['username'];
          $bookID = $request['bookID'];
          $result = setReadBook($bookID,$username);
          if($result = "") {
              //ERROR
          } else {
              return array("returnCode" => '202');
          }
          break;
      case 'getreadbooks':
          $username = $request['username'];
          $result = getReadBooks($username);
          if($result = "") {
              //ERROR
          } else {
              return array("returnCode" => '202', 'books'=> $result);
          }
          break;
      case 'getdiscussionposts':
          $bookID = $request['bookID'];
          $result = getDiscussionPosts($bookID);
          if($result = "") {
              //ERROR
          } else {
              return array("returnCode" => '202', 'data'=> $result);
          }
          break;
      case 'adddiscussionpost':
          $username = $request['username'];
          $bookID = $request['bookID'];
          $postText = $request['post'];
          $result = addDiscussionPost($bookID,$postText,$username);
          if($result = "") {
              //ERROR
          } else {
              return array("returnCode" => '202');
          }
          break;
      case 'getrating':
          $username = $request['username'];
          $bookID = $request['bookID'];
          $result = getReview($bookID,$username);
          if($result = "") {
              //ERROR
          } else {
              return array("returnCode" => '202', 'data'=> $result);
          }
          break;
      case 'setrating':
          $username = $request['username'];
          $bookID = $request['bookID'];
          $rating = $request['rating'];
          $result = addReview($bookID,$rating,$username);
          if($result = "") {
              //ERROR
          } else {
              return array("returnCode" => '202');
          }
          break;
  }
  return array("returnCode" => '0', 'message'=>"Error! Server recieved unknown request!");
  //log error
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");



echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();

?>

