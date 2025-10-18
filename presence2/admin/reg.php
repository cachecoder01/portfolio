<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

include '../db/db_connect.php';
	
	$email=trim($_POST["email"]);
	$email=filter_var($email, FILTER_VALIDATE_EMAIL);

	$pass=trim($_POST["pass"]);
	$pass=htmlspecialchars(strip_tags($pass), ENT_QUOTES, 'UTF-8');
	$pass=password_hash($pass, PASSWORD_DEFAULT);

	$stmt=$conn->prepare("INSERT INTO reginfo(email, password)VALUES(?, ?)");
	$stmt->bind_param('ss', $email, $pass);
	$result=$stmt->execute();
	
	if ($result) {

		header('location: index.html');

	}else {
		echo "unable to login";
		}

}else{
	die("Invalid Request");
}
?>