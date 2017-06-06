<?php
function getDBConnection() {
	$conn = mysqli_connect("localhost","root","password","veva");
	mysqli_set_charset($conn,"utf8");
	if($conn) {
		return $conn;
	} else {
		// TODO: Weiterleitung
	}
	//return(mysqli_connect("localhost","root","password","veva"));
}
?>
