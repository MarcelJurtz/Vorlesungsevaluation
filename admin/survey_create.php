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
	echo'					<li><b>Fragebogen anlegen</b></li>';
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
	echo'			<h1>Fragebogen anlegen - Administrator</h1>';

	// Start: Auswahl Vorlesung
	// !Vorlesung und !Kapitel und !Speicherbutton
	if(!isset($_POST['cmdSelectLecture']) && !isset($_POST['cmdSelectChapter']) && !isset($_POST['cmdSaveSurvey']))
	{
		echo'
			<form action="survey_create.php" method="POST">
			<select name="cbLectureToAddSurvey" size=1>';
			echo getAllLectures();
			echo '</select>
				<input type="submit" name="cmdSelectLecture" value="Vorlesung bestätigen">
			</form>';

	// Auswahl Kapitel
	// !Kapitel und Vorlesung
	} else if(isset($_POST['cmdSelectLecture']) && !isset($_POST['cmdSelectChapter']) && !isset($_POST['cmdSaveSurvey'])) {

		$_SESSION['lectureToAddSurvey'] = $_POST['cbLectureToAddSurvey'];

		echo'
			<form action="survey_create.php" method="POST">
			<select name="cbChapterToAddSurvey" size=1>';
		echo getAllChaptersOfLecture($_POST['cbLectureToAddSurvey']);
		$lecture = $_POST['cbLectureToAddSurvey'];
		echo '</select>
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

		echo 'Bezeichnung des Fragebogens: <input type="text" name="txtFbName" /><br />';

		while(true) {
			if(!isset($questions[$iterator])) {
				break;
			}

			$chkName = "chk$iterator";
			$txtName = "txt$iterator";
			$txtContent = "$questions[$iterator]";
			echo '<input type="checkbox" name="' . $chkName . '" />';
			echo '<input type="text" name="' . $txtName . '" value="' . $txtContent . '" readonly /><br />';
			// echo " $txtContent<br/>";

			$iterator++;
		}

		echo '<input type="submit" name="cmdSaveSurvey" value="Fragebogen speichern" />';
		echo '</form>';

		echo'<br /><br /><a href="survey_create.php">Zurück</a>';
	} else if (isset($_POST['cmdSaveSurvey']) && isset($_POST['txtFbName'])) {

		$iterator = 0;
		$existenceChecked = false;
		$fbCreated = false;
		if(!isset($_POST['chk0'])) {
			echo "Es wurden keine Fragen ausgewählt.";
		} else {

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
		echo "Es wurde keine Bezeichnung festgelegt.";
		echo'<br /><br /><a href="survey_create.php">Zurück</a>';
	}

	echo'		</div>';
	echo'		<br class="clear" />';
	echo'	</div>';
?>
</body>
</html>
