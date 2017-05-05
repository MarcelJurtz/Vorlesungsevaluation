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
	include_once("../constants.inc.php");
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
	echo'					<li><b>Frage anlegen</b></li>';
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
	echo'					<li><a href="lecture_modify.php">Vorlesung bearbeiten</a></li>';
	echo'				</ul>';
	echo'				<li><a href="statistics.php">Statistiken</a></li>';
	echo'				<li><a href="settings.php">Einstellungen</a></li>';
	echo'				<li><a href="../logout.php">Abmelden</a></li>';
	echo'			</ul>';
	echo'		</div>';
	echo'		<div id="cFrame">';
	echo'			<h1>Frage anlegen - Administrator</h1>';

	// Start: Auswahl Vorlesung
	// !Vorlesung und !Kapitel und !Speicherbutton
	if(!isset($_POST['cmdSelectLecture']) && !isset($_POST['cmdSelectChapter']) && !isset($_POST['cmdSaveQuestion']))
	{
		echo'
			<form action="question_create.php" method="POST">
			<select name="cbLectureToModify" size=1>';
			echo getAllLectures();
			echo '</select>
				<input type="submit" name="cmdSelectLecture" value="Vorlesung bestätigen">
			</form>';

	// Auswahl Kapitel
	// !Kapitel und Vorlesung
} else if(isset($_POST['cmdSelectLecture']) && !isset($_POST['cmdSelectChapter'])) {
		echo'
			<form action="question_create.php" method="POST">
			<select name="cbChapterToModify" size=1>';
		echo getAllChaptersOfLecture($_POST['cbLectureToModify']);
		$lecture = $_POST['cbLectureToModify'];
		echo '</select>
				<input type="hidden" name="cbLectureToModify" value="'.$lecture.'" />
				<input type="submit" name="cmdSelectChapter" value="Kapitel bestätigen">
			</form>';

			echo'<br /><br /><a href="question_create.php">Zurück</a>';

		// Frage Speichern nach Betätigen der Schaltfläche
		// SpeicherButton
	} else if(isset($_POST['cmdSaveQuestion'])){
		$FrTyp = FRAGENTYP_TEXTFRAGE;
		if($_POST['rbQuestionType'] == FRAGENTYP_MULTIPLE_CHOICE) {
			$FrTyp = FRAGENTYP_MULTIPLE_CHOICE;
		}

		saveQuestion($FrTyp);

		echo'<br /><br /><a href="question_create.php">Zurück</a>';

		// Sonst: Fragen-Eingabeansicht
	} else {
		echo "<h2>Neue Frage für Kapitel '" . $_POST['cbChapterToModify'] . "' der Vorlesung '". $_POST['cbLectureToModify'] ."'</h2>";
		$_SESSION['lectureToAddQuestion'] = $_POST['cbLectureToModify'];
		$_SESSION['chapterToAddQuestion'] = $_POST['cbChapterToModify'];

		addQuestionContainer();

		echo'<br /><br /><a href="question_create.php">Zurück</a>';
	}

	echo'		</div>';
	echo'		<br class="clear" />';
	echo'	</div>';
?>
</body>
</html>
