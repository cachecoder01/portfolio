<?php
$conn=mysqli_connect("localhost", "root", "", "portfolio");
if (!$conn) {
	die("connect failed:" .mysqli_connect_error());
}
?>