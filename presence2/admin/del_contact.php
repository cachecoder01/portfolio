<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
	include '../db/db_connect.php';

	$id=intval($_POST['id']);
	$id=filter_var($id, FILTER_VALIDATE_INT);

	$stmt=$conn->prepare("DELETE FROM contact_form WHERE id=?");
	$stmt->bind_param("i", $id);
	$stmt->execute();

	if ($stmt->execute()) {
		echo "<script>
				alert('Testimonial deleted');
				window.location = document.referrer;
			  </script>";
	}else {
		die("Execution Failed :" . $stmt->error());
	}

	$stmt->close();
	
}else {
	echo "Invalid request.";
}
?>