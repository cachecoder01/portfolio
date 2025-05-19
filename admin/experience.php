<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
include '../db/db_connect.php';

	$id=trim(intval($_POST["id"]));
	$id=filter_var($id, FILTER_VALIDATE_INT);

	$from=filter_var($_POST["from"], FILTER_VALIDATE_INT);
	$to=strip_tags($_POST["to"]);

	$program=htmlspecialchars(strip_tags($_POST["program"]), ENT_QUOTES, 'UTF-8');
	$org=htmlspecialchars(strip_tags($_POST["org"]), ENT_QUOTES, 'UTF-8');
	$location=htmlspecialchars(strip_tags($_POST["location"]), ENT_QUOTES, 'UTF-8');
	$desc=htmlspecialchars(strip_tags($_POST["description"]), ENT_QUOTES, 'UTF-8');

	$current="";
	if (isset($_POST["status"])) {
		$current=$_POST["status"];
	}else {
		$current="ended";
	}

	$cert="";
	if (isset($_FILES["cert"]) && $_FILES["cert"]["error"] === 0) {
		$cert = $_FILES["cert"]["name"];
	}
$imagePath="";
if (isset($_FILES["cert"]) && $_FILES["cert"]["error"] === 0) {

	$target_Dir = "../assets/images/certificate/";
	if (!is_dir($target_Dir)) {
		mkdir($target_Dir, 0777, true);
	}
	$imageName = time() . "_" . basename((string)$_FILES["cert"]["name"]);
	$targetFile = $target_Dir . $imageName;

	$check = getimagesize($_FILES["cert"]["tmp_name"]);
	if ($check !== false) {
		if (move_uploaded_file($_FILES["cert"]["tmp_name"], $targetFile)) {
			$imagePath = (string)$targetFile;
			$cert = $imageName;
		}
	}else {
		echo "upload error code: " .$_FILES["cert"]["error"];
		exit();
	}
	$allowed_images = ['image/jpeg', 'image/png', 'image/webp'];
	if (!in_array($check['mime'], $allowed_images)) {
		die('Only JPG, PNG, AND webP images are allowed.');
	}
	

}elseif ($_FILES["cert"]["error"] !== 4) {
	echo "upload error code: " .$_FILES["cert"]["error"];
		exit();
}

$stmt=$conn->prepare("SELECT * FROM experience WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result=$stmt->get_result();
if ($result->num_rows>0) {
	while ($row = $result->fetch_assoc()) {

		$stmt=$conn->prepare("UPDATE experience SET start_date=?, finish_date=?, program=?, organisation=?, location=?, description=?, certification=?, status=? WHERE id=?");
		$stmt->bind_param("iissssssi", $from, $to, $program, $org, $location, $desc, $cert, $current, $id);
	}

}else {

	$stmt=$conn->prepare("INSERT INTO experience(start_date, finish_date, program, organisation, location, description, certification)VALUE(?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("iisssss", $from, $to, $program, $org, $location, $desc, $cert);
}

	$result=$stmt->execute();

if ($result) {
	echo "<script>
			alert('Experience updated');
			window.location = document.referrer;
		</script>";
}else{
	die("insert failed");
}

}else{
	die("Invalide Request");
}
?>