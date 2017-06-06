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
	printAdminMenu(MENU_QUESTION_CREATE);

	echo'<h1>Frage anlegen - Administrator</h1>';

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

	printAdminMenuBottom();
?>
</body>
</html>
