<!DOCTYPE html>
<html>
<head>
	<link href="../global.css" rel="stylesheet" type="text/css">
	<title>Admin - Übersicht</title>
	<meta charset="UTF-8">
</head>
<body>
<?php
	include 'adminFunctions.inc.php';

	if(!isset($_SESSION['adminName'])) {
		header("Location: ./login.html");
	}

	// Aufbau Website
	printAdminMenu(MENU_LECTURE_CREATE);

	echo'<h1>Vorlesung anlegen</h1>';

	if(!isset($_POST['cmdCreateLecture'])) {
		echo'
			<form action="lecture_create.php" method="POST">
				Bezeichnung: <input type="text" name="txtLectureDescription" required>
				<input type="submit" name="cmdCreateLecture" value="Speichern">
			</form>
		';
	} else {
		createLecture($_POST['txtLectureDescription']);
		echo'<br /><br /><a href="lecture_create.php">Zurück</a>';
	}

	printAdminMenuBottom();
?>
</body>
</html>
