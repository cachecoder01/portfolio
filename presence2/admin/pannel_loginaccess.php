<?php

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

include '../db/db_connect.php';
	
	$email=trim($_POST["email"]);
	$email=filter_var($email, FILTER_VALIDATE_EMAIL);

	$pass=trim($_POST["pass"]);
	$pass=htmlspecialchars(strip_tags($pass), ENT_QUOTES, 'UTF-8');

	$pass_hash = '$2y$10$QWPHZlcDHucTjTAc/KbQj.gwOyp8pFJhfjVBstJzgoBK49NBLNSDG';
	
	$saved_email = 'cachecoder212@gmail.com';

	if (password_verify($pass, $pass_hash) AND $email == $saved_email) {

				$_SESSION['admin_logged_in'] = true;
				$_SESSION['email']=$email;
				header('location: pannel.php');
				exit();
		
	}else {
		echo "<script>
				alert('Invalid Login');
				window.location = document.referrer;
			</script>";
	}
	
}else{
	die("Invalid Request");
}
?>