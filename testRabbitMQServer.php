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
		$loginStmt = $dbConn->prepare("SELECT passhash FROM userLogin WHERE username = :user");
		$loginStmt->execute([':user' => $username]);
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
    return true;
    //return false if not valid
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
	  $pwd = hash('sha256',$request['[passwprd']);
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

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>

