<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
include '../db/db_connect.php';

	$id=trim(intval($_POST["id"]));
	$id=filter_var($id, FILTER_VALIDATE_INT);

	$cat=htmlspecialchars(strip_tags($_POST["category"]), ENT_QUOTES, 'UTF-8');
	$lang=htmlspecialchars(strip_tags($_POST["language"]), ENT_QUOTES, 'UTF-8');
	$pro_bar=filter_var($_POST["progress_bar"], FILTER_VALIDATE_INT);

	$stmt=$conn->prepare("SELECT * FROM expertise WHERE category=? AND id=?");
	$stmt->bind_param("si", $cat, $id);
	$stmt->execute();

	$result=$stmt->get_result();
	if ($result->num_rows>0) {
	
		$stmt=$conn->prepare("UPDATE expertise SET progress=?, language=? WHERE category=? AND id=?");
		$stmt->bind_param("issi", $pro_bar, $lang, $cat, $id);

	}else {

		$stmt=$conn->prepare("INSERT INTO expertise(id, category, language, progress)VALUE(?, ?, ?, ?)");
		$stmt->bind_param("issi", $id, $cat, $lang, $pro_bar);
	}

	$result=$stmt->execute();

	if ($result) {
		echo "<script>
				alert('Expertise updated');
				window.location = document.referrer;
			</script>";
	}else{
		echo "unable to update";
	}

}else{
	die('Invalide Request');
}
?>