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
	printAdminMenu(MENU_LECTURE_MODIFY);

	echo'			<h1>Vorlesung bearbeiten - Administrator</h1>';

	if(!isset($_POST['cmdModifyLecture']) && !isset($_POST['cmdAddChapter'])) {
		// Vorlesung umbenennen
		echo'
			<h2>Vorlesung umbenennen</h2>
			<form action="lecture_modify.php" method="POST">
			Alte Bezeichnung: <select name="cbLectureToDelete" size=1>';
		echo getAllLectures();
		echo '</select>
				Neue Bezeichnung: <input type="text" name="txtLectureNewDescription" />
				<input type="submit" name="cmdModifyLecture" value="Ändern">
			</form>';

		// Kapitel hinzufügen
		echo'
			<h2>Kapitel zur Vorlesung hinzufügen</h2>
			<form action="lecture_modify.php" method="POST">
			<select name="cbLectureToAddChapter" size=1>';
		echo getAllLectures();
		echo '</select>
				Kapitelbezeichnung: <input type="text" name="txtChapterNewDescription" />
				<input type="submit" name="cmdAddChapter" value="Speichern">
			</form>';

	} elseif(isset($_POST['cmdModifyLecture'])) {
		renameLecture($_POST['cbLectureToDelete'],$_POST['txtLectureNewDescription']);
		echo '</br/><br /><a href="lecture_modify.php">Zurück</a>';
	} elseif(isset($_POST['cmdAddChapter'])) {
		addLectureChapter($_POST['cbLectureToAddChapter'], $_POST['txtChapterNewDescription']);
		echo '</br/><br /><a href="lecture_modify.php">Zurück</a>';
	}

	printAdminMenuBottom();
?>
</body>
</html>
