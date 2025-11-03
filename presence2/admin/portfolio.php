<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="shortcut icon" href="../assets/images/app-images/brand-logo.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/mobile.css">

    <title>CacheCodeR | Admin</title>
</head>
<body>
	<?php
session_start();
if (! isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
	header('location: index.html');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
include '../db/db_connect.php';

	$title = trim($_POST["title"]);
	$title = htmlspecialchars(strip_tags($title), ENT_QUOTES, 'UTF-8');

	$desc = trim($_POST["discription"]);
	$desc = htmlspecialchars(strip_tags($desc), ENT_QUOTES, 'UTF-8');

	$url = trim($_POST["link"]);
	$url=htmlspecialchars(strip_tags($url), ENT_QUOTES, 'UTF-8');

	$img="";
	if (isset($_FILES["img"]) && $_FILES["img"]["error"] === 0) {
		$img=$_FILES["img"]["name"];
	}

$imgPath="";
if (isset($_FILES["img"]) && $_FILES["img"]["error"] === 0) {
	$target_Dir = "../assets/images/portfolio/";
	if (!is_dir($target_Dir)) {
		mkdir($target_Dir, 0777, true);
	}
	$imgName= time() . "_" . basename((string)$_FILES["img"]["name"]);
	$targetFile = $target_Dir . $imgName;

	$check = getimagesize($_FILES["img"]["tmp_name"]);
	if ($check !== false) {
		if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile)) {
			$imgPath=(string)$targetFile;
			$img=$imgName;
		}
	}else {
		echo "upload error code: " .$_FILES["img"]["error"];
		exit();
	}
	$allowed_img=['image/jpeg', 'image/png', 'image/webp'];
	if (!in_array($check['mime'], $allowed_img)) {
		die('Only JPJ, PNG, and WebP iamages are allowed');
	}

}elseif ($_FILES["img"]["error"] !== 4) {
	echo "upload error code: " .$_FILES["img"]["error"];
		exit();
};

		$stmt=$conn->prepare("INSERT INTO portfolio(title, description, image, link)VALUE(?, ?, ?, ?)");
		$stmt->bind_param("ssss", $title, $desc, $img, $url);
	
		$result=$stmt->execute();
	
		if ($result) {
			echo "<div class='form_message'>
        			<div class='green'>Submitted</div>
        			<div>Project list updated successfully 💪</div>
        			<div><a href='pannel.php'>OK</a></div>
    			</div>";
		}else{
			die("insert failed: " . mysqli_error($conn));
		}

	$stmt -> close();
}else{
	die("Invalid Request");
}
?>
</body>
</html>