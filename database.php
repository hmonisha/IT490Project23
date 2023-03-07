<?php



$con=mysqli_connect("www.sample.com", "steve","password","Google");


if(mysqli_connect_errno(%con)){
	echo "MySQL database connection failed: " . mysqli_connect_error();
}


if(isset($_POST["submitBtn"]) && $_POST["submitBTn"]!=""){

	$name=$_POST["name"];
	$email=$_POST["email"];
	$message=$_POST["message"];
	
	if(mysqli_query("INSERT INTO contact users (name, email, message)
		VALUES ($name,$email,$message)"){

		echo "Record inserted successfully";
		}}
?>

