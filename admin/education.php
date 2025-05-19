<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
	
include '../db/db_connect.php';

	$id=intval($_POST['id']);
	$id=filter_var($id, FILTER_VALIDATE_INT);

	$from=trim($_POST["from"]);
	$from=filter_var($from, FILTER_VALIDATE_INT);

	$to=trim($_POST["to"]);
	$to=filter_var($to, FILTER_VALIDATE_INT);

	$degree=htmlspecialchars(strip_tags($_POST["degree"]), ENT_QUOTES, 'UTF-8');
	$school=htmlspecialchars(strip_tags($_POST["school"]), ENT_QUOTES, 'UTF-8');

	$current="";
	if (isset($_POST["status"])) {
		$current=$_POST["status"];
	}else {
		$current="ended";
	}

	$cert="";
	if (isset($_FILES["certificate"]) && $_FILES["certificate"]["error"] === 0) {
		$cert = $_FILES["certificate"]["name"];
	};

	$desc=is_array($_POST["description"]) ? implode(", ", $_POST["description"]) : $_POST["description"];
	$location=is_array($_POST["location"]) ? implode(", ", $_POST["location"]) : $_POST["location"];

	$desc=htmlspecialchars(strip_tags($desc), ENT_QUOTES, 'UTF-8');
	$location=htmlspecialchars(strip_tags($location), ENT_QUOTES, 'UTF-8');

$imagePath = "";
if (isset($_FILES["certificate"]) && $_FILES['certificate']['error'] === 0) {
	
	$target_Dir="../assets/images/certificate/";
	if (!is_dir($target_Dir)) {
		mkdir($target_Dir, 0777, true);
	}
	$imageName = time() . "_" . basename((string)$_FILES["certificate"]["name"]);
	$targetFile = $target_Dir . $imageName;

	//file validation
	$check = getimagesize($_FILES["certificate"]["tmp_name"]);
	if ($check !== false) {
		if (move_uploaded_file($_FILES["certificate"]["tmp_name"], $targetFile)) {
			$imagePath = (string)$targetFile;
			$cert = $imageName;
		}
	}else {
		echo "upload error code: " .$_FILES["certificate"]["error"];
		exit();
	}
	$allowed_img = ['image/jpeg', 'image/png', 'image/webp'];
	if (!in_array($check['mime'], $allowed_img)) {
		die('Only JPG, PNG, AND webP images are allowed.');
	}

}elseif ($_FILES["certificate"]["error"] !== 4) {
	echo "upload error code: " .$_FILES["certificate"]["error"];
		exit();
}

$stmt=$conn->prepare("SELECT * FROM education WHERE id=?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result=$stmt->get_result();
if ($result->num_rows>0) {
	while ($row = $result->fetch_assoc()) {
		
		$stmt=$conn->prepare("UPDATE education 
		SET start_date=?,
		 	finish_date=?, 
		 	degree=?, 
		 	school=?, 
		 	location=?, 
		 	description=?, 
		 	certification=?,
		 	status=? WHERE id=?");
		$stmt->bind_param("iissssssi", $from, $to, $degree, $school, $location, $desc, $cert, $current, $id);
	}

	}else{
		$stmt=$conn->prepare("INSERT INTO education(start_date, finish_date, degree, school, location, description, certification, status)VALUE(?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("iissssss", $from, $to, $degree, $school, $location, $desc, $cert, $current);
	}

	$result=$stmt->execute();

	if ($result) {
		echo "<script>
				alert('Education updated');
				window.location = document.referrer;
			</script>";
	}else{
		die("insert failed");
		}
	$stmt->close();

}else {
	echo "Invalid Request";
}
?>