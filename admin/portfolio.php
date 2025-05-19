<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
include '../db/db_connect.php';

	$id=trim(intval($_POST["id"]));
	$id=filter_var($id, FILTER_VALIDATE_INT);
	$title=htmlspecialchars(strip_tags($_POST["title"]), ENT_QUOTES, 'UTF-8');
	$desc=htmlspecialchars(strip_tags($_POST["discription"]), ENT_QUOTES, 'UTF-8');
	$url=htmlspecialchars(strip_tags($_POST["link"]), ENT_QUOTES, 'UTF-8');

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

	$stmt=$conn->prepare("SELECT * FROM portfolio WHERE id=?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	
	$result=$stmt->get_result();
	if ($result->num_rows>0) {
		while ($row = $result->fetch_assoc()) {
			
			$stmt=$conn->prepare("UPDATE portfolio SET title=?, description=?, img=?, url=? WHERE id=?");
			$stmt->bind_param("ssssi", $title, $desc, $img, $url, $id);
		}
	
	}else {
		$stmt=$conn->prepare("INSERT INTO portfolio(title, description, img, url)VALUE(?, ?, ?, ?)");
		$stmt->bind_param("ssss", $title, $desc, $img, $url);
	}
	
	$result=$stmt->execute();
	
	if ($result) {
	echo "<script>
			alert('portfolio updated');
			window.location = document.referrer;
		</script>";
	}else{
		die("insert failed: " . mysqli_error($conn));
	}

}else{
	die("Invalid Request");
}
?>