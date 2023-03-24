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
                $loginStmt = $dbConn->prepare("SELECT passhash FROM userLogin WHERE username=:username");
                $loginStmt->execute([':username' => $username]);
                if($loginStmt->rowCount() < 1 or $loginStmt->rowCount() > 1){
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
        return "";
        }

        $stmt = $conn->prepare("INSERT INTO userLogin (username, passhash) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $passhash);
        $stmt->execute();



        echo "User added successfully";
        $stmt->close();
        $conn->close();


}



function sendSearch($query) {
    $client = new rabbitMQClient("rabbitMQ_api.ini","testServer");
    $rabbitRequest = array();
    $rabbitRequest['type'] = 'booksearch';
    $rabbitRequest['query'] = $query;
    $response = $client->send_request($rabbitRequest);
    if($response['returnCode'] == '202') {
	    $books = $response['data'];
  
	    foreach($books as $book)
	    {	var_dump($book);
            addBook($book["bookName"],$book["publishedBy"],$book["publishedDate"],$book["description"], $book["image"],$book["pageCount"],$book["authors"],$book["ID"],$book["language"],$book["publishedCountry"],$book["printType"],$book["category"],$book["price"],$book["link"]);
        }
        return true;
    } else {
        return false;
        //log failure in finding books
    }

}

function searchBooks($bookQuery, $firstRun = TRUE) {

	global $dbUser, $dbPass, $serverName, $loginDBName;

	$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

    if ($conn->connect_error){
        return "";
    }

    $stmt = $conn->prepare("SELECT bookName, image, authors, publishedBy, price, link, id FROM books WHERE bookName LIKE '%".$bookQuery."%' LIMIT 10");
    
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows >= 10 or !$firstRun) {
        $returnJSON = "[";
        while($row = $result->fetch_array()) {
            $returnJSON .= '{"bookName":"'.$row['bookName'].'","img":"'.$row['image'].'","authors":"'.$row['authors'].'","publisher":"'.$row['publishedBy'].'","price":"'.$row['price'].'","buyLink":"'.$row['link'].'","id":"'.$row['id'].'"},';
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
	return "";
    return "";
	}
		var_dump($bookName);
	$stmt = $conn->prepare("INSERT INTO books (bookName, publishedBy, description, image, pageCount, authors, id, language, publishedCountry, printType, category, price, link, publishedDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssissssssdss", $bookName, $publishedBy, $description, $image, $pageCount, json_encode($authors), $id, $language, $publishedCountry, $printType, json_encode($category), $price, $link, $publishedDate);
	$stmt->execute();

    $result = $stmt->get_result();

	echo "Book added successfully";
	$stmt->close();
	$conn->close();
    return "success";




}


function getBook($id){

	global $dbUser, $dbPass, $serverName, $loginDBName;

	$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
                return "";
        }

        $sql = "SELECT bookname, publishedBy, publishedDate, description, image, pageCount, authors, id, language, publishedCountry, printType, category, price, link FROM books WHERE id = $id LIMIT 1";
        $result = $conn->query($sql);

    if ($result->num_rows == 1){
	
	    $book = $result->fetch_row();
	    var_dump($book);

        $conn->close();
        $output= '{"bookName":"'.$book[0].'","img":"'.$book[4].'","authors":"'.$book[6].'", "publisher":"'.$book[1].'","PublishDate":"'.$book[2].'","Categories":"'.$book[11].'","price":"'.$book[12].'","buyLink":"'.$book[13].'","pageCount":"'.$book[5].'","Language":"'.$book[8].'","Description":"'.$book[3].'"}';

	
	var_dump($output);
	return $output;
    } elseif($result->num_rows > 1) {
        //error
	echo "num_rows > 1";
        $conn->close();
        return "";
    } else {

        $conn->close();
	echo "less then 1";
        return "";
    }

                $conn->close();




}



function addDiscussionPost($bookID, $post_content, $post_owner){

	global $dbUser, $dbPass, $serverName, $loginDBName;

	$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
        return "";
        return "";
        }

        $stmt = $conn->prepare("INSERT INTO forum_posts (post_id, topic_id, post_content, post_owner) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisis", $post_id, $bookID, $post_content, $post_owner);
        $stmt->execute();



        echo "Forum added successfully";
        $stmt->close();
        $conn->close();

    return "success";



}	


function getDiscussionPosts($topic_id){
	
	global $dbUser, $dbPass, $serverName, $loginDBName;

	$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
                return "";
        }

        $sql = "SELECT post_id, topic_id, post_content, post_owner FROM forum_posts WHERE topic_id = $topic_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0){
            $posts = "{reviews:[";
                while($row = $result->fetch_assoc()) {
                    $posts .= '"{username":'.$row['post_owner'].',"text":"'.$row['post_content'].'"},';
                  }
                  $posts = substr($posts,0,-1);
                $posts.="]}";
                $conn->close();
                return $posts;
        } else {

            $conn->close();
            return "{}";
        }
}



function getReadbook($bookID, $username){

global $dbUser, $dbPass, $serverName, $loginDBName;

$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
                return "";
        }
try {
    $sql = "SELECT * FROM readBook WHERE bookID = '$bookID' AND username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $conn->close();
        return '{"readBool":"true"}';
    } elseif ($result->num_rows > 1) {
        //error

        $conn->close();
        return '{"readBool":"false"}';
    } else {

        $conn->close();

        return '{"readBool":"false"}';
    }
} catch(Exception $e) {
    return '{"readBool":"false"}';
}

		$conn->close;

}




function setReadbook($bookID, $username){


global $dbUser, $dbPass, $serverName, $loginDBName;



   $conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){

            return "";
        }

        $stmt = $conn->prepare("INSERT INTO readBook(bookID, username) VALUES (?, ?)");
        $stmt->bind_param("ss", $bookID, $username);
        $stmt->execute();



        echo "Readbook added successfully";
        $stmt->close();
	$conn->close();

    return "success";




}




function addReview($bookName, $reviewerName, $rating){


	global $dbUser, $dbPass, $serverName, $loginDBName;
	$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
        return "";
        }
        $ratingString = intval(floatval($rating)*10);
        $bookName = strval($bookName);
        $reviewerName = strval($reviewerName);

        $stmt = $conn->prepare("INSERT INTO book_reviews (bookName, reviewerName, rating) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $bookName, $reviewerName,  $ratingString);
        $stmt->execute();



        echo "Review added successfully";
        $stmt->close();
        $conn->close();





}





function getReview($bookid, $reviewerName){

        global $serverName, $dbUser, $dbPass, $loginDBName;
$conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

        if ($conn->connect_error){
                return "";
        }
        echo "Getting rating";
try {
    $sql = "SELECT * FROM book_reviews WHERE bookName = '$bookid' AND reviewerName = '$reviewerName'";
    echo $sql;
    $result = $conn->query($sql);
    echo $result;

    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {

            $conn->close();

            return '{"rating":"' . $result->fetch_row()['rating'] . '"}';
        }
    } elseif ($result->num_rows > 1) {
        //error

        $conn->close();
        return "{}";
    } else {

        $conn->close();

        return "{}";
    }
} catch(Exception $e) {
    echo $e->getMessage();
    echo $e->getTraceAsString();
    return "{}";
}

                $conn->close();




}

function doRegister($username,$passHash)
{
        try{
                global $dbUser, $dbPass, $serverName, $loginDBName;
                $dbConn = new PDO("mysql:host=$serverName;dbname=$loginDBName", $dbUser, $dbPass);
                $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $loginStmt = $dbConn->prepare("INSERT INTO userLogin (username, passhash) VALUES (:username, :passhash) ");
		$loginStmt->execute([':username' => $username, ':passHash' => $passHash]);
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





function getSmallBook($bookID) {
            try{
                global $dbUser, $dbPass, $serverName, $loginDBName;
                $dbConn = new PDO("mysql:host=$serverName;dbname=$loginDBName", $dbUser, $dbPass);
                $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $searchStmt = $dbConn->prepare("SELECT bookName, image, authors, publishedBy, id FROM books WHERE bookID = :bookID ");
                $searchStmt->execute([':bookID' => $bookID]);
                if ($searchStmt->rowCount() == 1) {
                    foreach($searchStmt->fetch() as $book) {
                        return '{"bookName":'.$book['bookName'].",'img':".$book['image'].",'authors':".$book['authors'].", 'publisher':".$book['publishedBy'].",'id':".$book['id']."}";
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


function getReadBooks($username) {
            global $serverName, $dbUser, $dbPass, $loginDBName;

    $conn = new mysqli($serverName, $dbUser, $dbPass, $loginDBName);

    if ($conn->connect_error){
        return "";
    }

    $sql = "SELECT bookID, username FROM readBook WHERE username = $username";
    $result = $conn->query($sql);

    if ($result->num_rows > 0){

        $returnJson = "[";

        while($row = $result->fetch_assoc()) {
            $returnJson .= getSmallBook($row["bookID"]).',';
        }
        $returnJson = substr($returnJson,0,-1);
        $conn->close();
        return $returnJson;
        } else {
            $conn->close();
            return '"books":"[]"';
        }

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
          echo "Got results\n";
          echo $result;
          if($result == ""){
            //ERROR
          } else {
            return array("returnCode" => '202', 'books'=> $result);
          }
          break;
      case 'getbook':
          $bookID = $request['bookID'];
	  $result = getBook($bookID);
	  echo "\n";
	  var_dump($result);
          if($result == "") {
              //ERROR
	  } else {
		  echo "              ";
		  var_dump($result);
		  $ret=array("returnCode" => '202', 'data'=> " $result");
		  var_dump($ret);
		  return $ret;
          }
          break;
      case 'getreadbook':
          $username = $request['username'];
          $bookID = $request['bookID'];
          $result = getReadBook($bookID,$username);
          if($result == "") {
              //ERROR
          } else {
              return array("returnCode" => '202', 'data'=> $result);
          }
          break;
      case 'setreadbook':
          $username = $request['username'];
          $bookID = $request['bookID'];
          $result = setReadBook($bookID,$username);
          if($result == "") {
              //ERROR
          } else {
              return array("returnCode" => '202');
          }
          break;
      case 'getreadbooks':
          $username = $request['username'];
          $result = getReadBooks($username);
          if($result == "") {
              //ERROR
          } else {
              return array("returnCode" => '202', 'books'=> $result);
          }
          break;
      case 'getdiscussionposts':
          $bookID = $request['bookID'];
          $result = getDiscussionPosts($bookID);
          if($result == "") {
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
          if($result == "") {
              //ERROR
          } else {
              return array("returnCode" => '202');
          }
          break;
      case 'getrating':
          $username = $request['username'];
          $bookID = $request['bookID'];
          $result = getReview($bookID,$username);
          if($result == "") {
              //ERROR
          } else {
              return array("returnCode" => '202', 'data'=> $result);
          }
          break;
      case 'setrating':
          $username = $request['username'];
          $bookID = $request['bookID'];
          $rating = $request['rating'];
          $result = addReview($bookID,$username,$rating);
          if($result == "") {
              //ERROR
          } else {
              return array("returnCode" => '202');
          }
          break;
  }
  return array("returnCode" => '0', 'message'=>"Error! Server recieved unknown request!");
  //log error
}

$server = new rabbitMQServer("rabbitMQ_db.ini","testServer");



echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();

?>

