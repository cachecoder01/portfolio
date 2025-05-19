<?php
$conn=mysqli_connect("localhost", "root", "", "presence");
if (!$conn) {
	die("connect failed:" .mysqli_connect_error());
}
?>