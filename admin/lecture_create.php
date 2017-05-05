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
	echo'					<li><b>Vorlesung anlegen</b></li>';
	echo'					<li><a href="lecture_delete.php">Vorlesung löschen</a></li>';
	echo'					<li><a href="lecture_modify.php">Vorlesung bearbeiten</a></li>';
	echo'				</ul>';
	echo'				<li><a href="statistics.php">Statistiken</a></li>';
	echo'				<li><a href="../logout.php">Abmelden</a></li>';
	echo'			</ul>';
	echo'		</div>';
	echo'		<div id="cFrame">';
	echo'			<h1>Vorlesung anlegen - Administrator</h1>';

	if(!isset($_POST['cmdCreateLecture'])) {
		echo'
			<form action="lecture_create.php" method="POST">
				Bezeichnung: <input type="text" name="txtLectureDescription">
				<input type="submit" name="cmdCreateLecture" value="Speichern">
			</form>
		';
	} else {
		createLecture($_POST['txtLectureDescription']);
		echo'<br /><br /><a href="lecture_create.php">Zurück</a>';
	}

	echo'		</div>';
	echo'		<br class="clear" />';
	echo'	</div>';
?>
</body>
</html>
