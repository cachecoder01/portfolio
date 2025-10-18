<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	
include 'db/db_connect.php';

$name=trim($_POST["name"]);
$name=htmlspecialchars(strip_tags($name), ENT_QUOTES, 'UTF-8');

$email=trim($_POST["email"]);
$email=filter_var($email, FILTER_SANITIZE_EMAIL);
$email=filter_var($email, FILTER_VALIDATE_EMAIL);

$b_name=trim($_POST["brand_name"]);
$b_name=htmlspecialchars(strip_tags($b_name), ENT_QUOTES, 'UTF-8');

$sms=trim($_POST["message"]);
$sms=htmlspecialchars(strip_tags($sms), ENT_QUOTES, 'UTF-8');

$img="";
if (isset($_FILES["img"]) && $_FILES["img"]["error"] === 0) {
	$img=$_FILES["img"]["name"];
}

if (isset($_FILES["img"]) && $_FILES["img"]["error"] === 0) {
	$target_Dir="./assets/images/clients/";
	if (!is_dir($target_Dir)) {
		mkdir($target_Dir, 0777, true);
	}
	$imageName = time() . "_" . basename((string)$_FILES["img"]["name"]);
	$targetFile = $target_Dir . $imageName;

	$check = getimagesize($_FILES["img"]["tmp_name"]);
	if ($check !== false) {
		if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile)) {
			$imagePath = (string)$targetFile;
			$img = $imageName;
		}
	}else {
		echo "upload error code: " .$_FILES["img"]["error"];
		exit();
	}

	$allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
	if(!in_array($check['mime'], $allowed_types)) {
		die("Only JPG, PNG, AND webP images are allowed.");
	}

}elseif ($_FILES["img"]["error"] !== 4) {
	echo "upload error code: " .$_FILES["img"]["error"];
		exit();
}

$stmt=$conn->prepare("INSERT INTO testimonial(name, email, brand_name, brand_img, testimonial)VALUE(?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $b_name, $img, $sms);
$result=$stmt->execute();

if ($result) {
	echo "<script>
			alert('Submitted Successfully');
			window.location = document.referrer;
		  </script>";

}else{
	echo "<script>
			alert('Unable to submit');
			window.location = document.referrer;
		  </script>";
}
}else {
	echo "Invalid Request";
}
?>