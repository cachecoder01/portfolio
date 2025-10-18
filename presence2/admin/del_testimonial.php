<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
	include '../db/db_connect.php';
	
	$id = intval($_POST['id']);

	$getTestImage = mysqli_query($conn, "SELECT brand_img FROM testimonial WHERE id='$id'");
	$imgPath="";
	if ($getTestImage && mysqli_num_rows($getTestImage)>0) {
		$row = mysqli_fetch_assoc($getTestImage);
		$img = $row["brand_img"];
		

		if (empty($img)) {

			$imgPath="";
		}else{

			$imgPath="../assets/images/clients/" . $img;
			if (!file_exists($imgPath)) {
				unlink($imgPath);
			}
		}
		
	}
	
	$sql="DELETE FROM testimonial WHERE id= ?";
	$stmt=mysqli_prepare($conn, $sql);
	
	if (!$stmt) {
		die("mysqli_error($conn)");
	}
	
	mysqli_stmt_bind_param($stmt, "i", $id);
	$result=mysqli_stmt_execute($stmt);
	
	if ($result) {
		echo "<script>
				alert('Testimonial deleted');
				window.location = document.referrer;
			  </script>";
	}else {
		die("Execute failed: " .mysqli_stmt_error($stmt));
		}
	
	mysqli_stmt_close($stmt);

}else {
	echo "Invalid request.";
}
?>