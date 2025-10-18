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

	$cert=htmlspecialchars(strip_tags($_POST["cert"]), ENT_QUOTES, 'UTF-8');

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