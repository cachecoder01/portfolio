<?php

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

include '../db/db_connect.php';

	$email=trim($_POST["email"]);
	$pass=trim($_POST["pass"]);
	$pass=htmlspecialchars(strip_tags($pass), ENT_QUOTES, 'UTF-8');
	
	$storedHash='$2y$10$hM09X/zmAOJksA12KjxP5ezx2At6aou989gHkXDVswEMtUWNvJ.H.';
	
	if (password_verify($pass, $storedHash)) {

		$_SESSION['admin_logged_in'] = true;
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