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
	echo'					<li><b>Frage löschen</b></li>';
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
	echo'					<li><a href="lecture_modify.php">Vorlesung bearbeiten</a></li>';
	echo'				</ul>';
	echo'				<li><a href="statistics.php">Statistiken</a></li>';
	echo'				<li><a href="settings.php">Einstellungen</a></li>';
	echo'				<li><a href="../logout.php">Abmelden</a></li>';
	echo'			</ul>';
	echo'		</div>';
	echo'		<div id="cFrame">';
	echo'			<h1>Frage löschen - Administrator</h1>';


	if(isset($_POST['cmdSelectLecture'])) {

		// Vorlesung gewählt -> Kapitel wählen
		echo'<form action="question_delete.php" method="POST">
			<select name="cbChapterQuestionDelete" size=1>';
		echo getAllChaptersOfLecture($_POST['cbLectureQuestionDelete']);
		$_SESSION['cbLectureQuestionDelete'] = $_POST['cbLectureQuestionDelete'];
		echo '</select>
				<input type="submit" name="cmdSelectChapter" value="Kapitel bestätigen">
			</form>';

		echo'<br /><br /><a href="question_delete.php">Zurück</a>';

	} else if (isset($_POST['cmdSelectChapter'])) {

		// Kapitel gewählt -> Frage wählen
		echo'<form action="question_delete.php" method="POST">
			<select name="cbQuestionQuestionDelete" size=1>';

		echo getAllQuestionsOfChapter($_SESSION['cbLectureQuestionDelete'],$_POST['cbChapterQuestionDelete']);
		$_SESSION['cbChapterQuestionDelete'] = $_POST['cbChapterQuestionDelete'];
		echo '</select>
				<input type="submit" name="cmdSelectQuestion" value="Frage bestätigen">
			</form>';

		echo'<br /><br /><a href="question_delete.php">Zurück</a>';

	} else if (isset($_POST['cmdSelectQuestion'])) {

		// Frage gewählt -> Frage löschen
		deleteQuestion($_SESSION['chapterIDtoDelete'], $_POST['cbQuestionQuestionDelete']);
		echo'<br /><br /><a href="question_delete.php">Zurück</a>';

	} else {

		// Vorlesung wählen
		echo'<form action="question_delete.php" method="POST">
					<select name="cbLectureQuestionDelete" size=1>';
		echo getAllLectures();
		echo '</select>
				<input type="submit" name="cmdSelectLecture" value="Vorlesung bestätigen">
			</form>';
	}

	echo'		</div>';
	echo'		<br class="clear" />';
	echo'	</div>';
?>
</body>
</html>
