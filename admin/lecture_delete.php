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
	printAdminMenu(MENU_LECTURE_DELETE);

	echo'<h1>Vorlesung löschen</h1>';

	if(!isset($_POST['cmdDeleteLecture'])) {

		$lectures = getAllLectures();
		if(count($lectures) > 0) {
			echo'
				<form action="lecture_delete.php" method="POST">
				<select name="cbLectureToDelete" size=1>';
			for($i = 0; $i < count($lectures); $i++) {
				echo "<option>$lectures[$i]</option>";
			}
			echo '</select>
					<input type="submit" name="cmdDeleteLecture" value="Löschen">
				</form>';
		} else {
			echo "<p>Keine Einträge vorhanden.</p>";
		}
	} else {
		// Button wurde gedrückt - Kurs löschen
		deleteLecture($_POST['cbLectureToDelete']);
		echo '</br/><br /><a href="lecture_delete.php">Zurück</a>';
	}

	printAdminMenuBottom();
?>
</body>
</html>
