<?php

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

include '../db/db_connect.php';
	
	$email=trim($_POST["email"]);
	$email=filter_var($email, FILTER_VALIDATE_EMAIL);

	$pass=trim($_POST["pass"]);
	$pass=htmlspecialchars(strip_tags($pass), ENT_QUOTES, 'UTF-8');

	$stmt=$conn->prepare("SELECT * FROM reginfo");
	$stmt->execute();

	$result=$stmt->get_result();
	if ($result->num_rows>0) {
		while ($row = $result->fetch_assoc()) {
			$storedHash=$row["password"];

			if (password_verify($pass, $storedHash)) {

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
		}
	}else{
		echo "Account not found";
	}

}else{
	die("Invalid Request");
}
?>