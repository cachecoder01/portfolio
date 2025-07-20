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

	$desc=is_array($_POST["description"]) ? implode(", ", $_POST["description"]) : $_POST["description"];
	$location=is_array($_POST["location"]) ? implode(", ", $_POST["location"]) : $_POST["location"];

	$desc=htmlspecialchars(strip_tags($desc), ENT_QUOTES, 'UTF-8');
	$location=htmlspecialchars(strip_tags($location), ENT_QUOTES, 'UTF-8');


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
		 	description=?
		 	status=? WHERE id=?");
		$stmt->bind_param("iisssssi", $from, $to, $degree, $school, $location, $desc, $current, $id);
	}

	}else{
		$stmt=$conn->prepare("INSERT INTO education(start_date, finish_date, degree, school, location, description, status)VALUE(?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("iisssss", $from, $to, $degree, $school, $location, $desc, $current);
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