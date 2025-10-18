<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
include 'db/db_connect.php';

	$name=trim($_POST["name"]);
	$name=htmlspecialchars(strip_tags($name), ENT_QUOTES, 'UTF-8');
	
	$email=trim($_POST["email"]);
	$email=filter_var($email, FILTER_SANITIZE_EMAIL);
	$email=filter_var($email, FILTER_VALIDATE_EMAIL);
	
	$subject=trim($_POST["subject"]);
	$subject=htmlspecialchars(strip_tags($subject), ENT_QUOTES, 'UTF-8');
	
	$message=trim($_POST["message"]);
	$message=htmlspecialchars(strip_tags($message), ENT_QUOTES, 'UTF-8');

	$to="cachecoder212@gmail.com";
	$body="From: $name\nEmail: $email\nSubject: $subject\n\n$message";
	$headers="From: $email\r\n";

	mail($to, $subject, $body, $headers);

	$stmt=$conn->prepare("INSERT INTO contact_form(name, email, subject, message)VALUE(?, ?, ?, ?)");
	$stmt->bind_param("ssss", $name, $email, $subject, $message);
	$stmt->execute();

	if ($stmt->execute()) {
		echo "<script>
				alert('Submitted successfully');
				window.location = document.referrer;
			</script>";
	}else{
		echo "unable to submit";
	}

}else {
	echo "Invalid Request";
}
?>