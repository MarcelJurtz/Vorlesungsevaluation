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
	printAdminMenu(MENU_SURVEY_CREATE);

	echo'<h1>Fragebogen anlegen - Administrator</h1>';

	// Start: Auswahl Vorlesung
	// !Vorlesung und !Kapitel und !Speicherbutton
	if(!isset($_POST['cmdSelectLecture']) && !isset($_POST['cmdSelectChapter']) && !isset($_POST['cmdSaveSurvey']))
	{
		echo'
			<form action="survey_create.php" method="POST">
			Vorlesung auswählen: <select name="cbLectureToAddSurvey" size=1>';
			echo getAllLectures();
			echo '</select>
				<br /><br />
				<input type="submit" name="cmdSelectLecture" value="Vorlesung bestätigen">
			</form>';

	// Auswahl Kapitel
	// !Kapitel und Vorlesung
	} else if(isset($_POST['cmdSelectLecture']) && !isset($_POST['cmdSelectChapter']) && !isset($_POST['cmdSaveSurvey'])) {

		$_SESSION['lectureToAddSurvey'] = $_POST['cbLectureToAddSurvey'];

		echo'
			<form action="survey_create.php" method="POST">
			Kapitel auswählen: <select name="cbChapterToAddSurvey" size=1>';
		echo getAllChaptersOfLecture($_POST['cbLectureToAddSurvey']);
		$lecture = $_POST['cbLectureToAddSurvey'];
		echo '</select>
				<br /><br />
				<input type="hidden" name="cbLectureToAddSurvey" value="'.$lecture.'" />
				<input type="submit" name="cmdSelectChapter" value="Kapitel bestätigen">
			</form>';

			echo'<br /><br /><a href="survey_create.php">Zurück</a>';

		// Frage Speichern nach Betätigen der Schaltfläche
		// SpeicherButton
	} else if(isset($_POST['cmdSelectChapter'])){

		$_SESSION['chapterToAddSurvey'] = $_POST['cbChapterToAddSurvey'];

		// Ausgabe aller Fragen mit Checkboxen des Kapitels
		// fr1txt fr1chk
		//$questions = explode ( "-" , getAllQuestionsOfChapter($_POST['cbLectureToAddSurvey'], $_POST['cbChapterToAddSurvey'], false));
		$questions = getAllQuestionsOfChapterArray(getChapterId($_POST['cbLectureToAddSurvey'], $_POST['cbChapterToAddSurvey']));
		$iterator = 0;

		echo '<form action="survey_create.php" method="POST">';

		echo 'Bezeichnung des Fragebogens: <input type="text" name="txtFbName" required /><br /><br />Enthaltene Fragen: <br />';

		while(true) {
			if(!isset($questions[$iterator])) {
				break;
			}

			$chkName = "chk$iterator";
			$txtName = "txt$iterator";
			$txtContent = "$questions[$iterator]";
			echo '<input type="checkbox" name="' . $chkName . '" />';
			echo '<input type="text" name="' . $txtName . '" value="' . $txtContent . '" readonly class="invisibleBorder"/><br />';
			// echo " $txtContent<br/>";

			$iterator++;
		}

		echo '<br /><input type="submit" name="cmdSaveSurvey" value="Fragebogen speichern" />';
		echo '</form>';

		echo'<br /><br /><a href="survey_create.php">Zurück</a>';
	} else if (isset($_POST['cmdSaveSurvey']) && isset($_POST['txtFbName'])) {

		$iterator = 0;
		$existenceChecked = false;
		$fbCreated = false;


		// Prüfen, ob Fragen markiert wurden
		$questionsSelected = false;
		while(true) {
			// Schleife beenden, wenn keine Fragen mehr übrig
			if(!isset($_POST["txt$iterator"])) break;

			// Schleife beenden, wenn Frage markiert
			if(isset($_POST["chk$iterator"])) {
				$questionsSelected = true;
				break;
			}
			$iterator++;
		}

		if(!$questionsSelected) {
			echo "<p>Es wurden keine Fragen ausgewählt.</p>";
		} else {

			$iterator = 0;
			$surveyAlreadyExisting = false;

			// Fragebogen prüfen / erstellen
			if(!fbExisting($_POST['txtFbName'])) {
				createFb($_POST['txtFbName'], $_SESSION['lectureToAddSurvey'], $_SESSION['chapterToAddSurvey']);
			} else {
				$surveyAlreadyExisting = true;
			}

			while(!$surveyAlreadyExisting) {

				if(!isset($_POST["txt$iterator"])) break;

				if(isset($_POST["chk$iterator"])) {
					$q = $_POST["txt$iterator"];
					saveQuestionToFb($_POST['txtFbName'], $q);
				}
				$iterator++;
			}
		}

		echo'<br /><br /><a href="survey_create.php">Zurück</a>';
	} else {
		echo "<p>Es wurde keine Bezeichnung festgelegt.</p>";
		echo'<br /><br /><a href="survey_create.php">Zurück</a>';
	}

	printAdminMenuBottom();
?>
</body>
</html>
