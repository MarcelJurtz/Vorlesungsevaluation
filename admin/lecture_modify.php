<!DOCTYPE html>
<html>
<head>
	<link href="../global.css" rel="stylesheet" type="text/css">
	<title>Admin - Übersicht</title>
	<meta charset="UTF-8">
</head>
<body>
<?php
	include '../functions.inc.php';
	session_start();

	if(!isset($_SESSION['adminName'])) {
		header("Location: ./login.html");
	}

	// Aufbau Website
	echo'<div id="cWrapper">';
	echo'		<div id="cMenu">';
	echo'			<ul id="lMenu">';
	echo'				<li><a href="admin.php">Übersicht</a></li>';
	echo'				<li>Kurse</li>';
	echo'				<ul class="lSubMenu">';
	echo'					<li><a href="class_create.php">Kurs anlegen</a></li>';
	echo'					<li><a href="class_delete.php">Kurs löschen</a></li>';
	echo'					<li><a href="class_enable.php">Kursfreigabe verwalten</a></li>';
	echo'				</ul>';
	echo'				<li>Fragen</li>';
	echo'				<ul class="lSubMenu">';
	echo'					<li><a href="question_create.php">Frage anlegen</a></li>';
	echo'					<li><a href="question_delete.php">Frage löschen</a></li>';
	echo'					<li><a href="question_modify.php">Frage bearbeiten</a></li>';
	echo'				</ul>';
	echo'				<li>Fragebögen</li>';
	echo'				<ul class="lSubMenu">';
	echo'					<li><a href="survey_create.php">Fragebogen anlegen</a></li>';
	echo'					<li><a href="survey_delete.php">Fragebogen löschen</a></li>';
	echo'					<li><a href="survey_modify.php">Fragebogen bearbeiten</a></li>';
	echo'					<li><a href="survey_enable.php">Fragebogen freigeben</a></li>';
	echo'				</ul>';
	echo'				<li>Vorlesungen</li>';
	echo'				<ul class="lSubMenu">';
	echo'					<li><a href="lecture_create.php">Vorlesung anlegen</b></li>';
	echo'					<li><a href="lecture_delete.php">Vorlesung löschen</a></li>';
	echo'					<li><b>Vorlesung bearbeiten</b></li>';
	echo'				</ul>';
	echo'				<li><a href="statistics.php">Statistiken</a></li>';
	echo'				<li><a href="../logout.php">Abmelden</a></li>';
	echo'			</ul>';
	echo'		</div>';
	echo'		<div id="cFrame">';
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

	echo'		</div>';
	echo'		<br class="clear" />';
	echo'	</div>';
?>
</body>
</html>
