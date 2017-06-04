<?php
function getDBConnection() {
	$conn = mysqli_connect("localhost","root","password","veva");
	mysqli_set_charset($conn,"utf8");
	return $conn;
	//return(mysqli_connect("localhost","root","password","veva"));
}
?>
