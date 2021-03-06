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
		$_SESSION['toaster'] = TOAST_NO_PERMISSION;
		header("Location: ./index.php");
	}

	// Aufbau Website
	printAdminMenu(MENU_SURVEY_MODIFY);

	echo'<h1>Fragebogen bearbeiten</h1>';


	if(isset($_POST['cmdSaveSurveyModifications'])) {
		//saveQuestionToFbV2()
		$_SESSION['surveyToModify'];
		deleteSurveyQuestions($_SESSION['surveyToModify']);
		$i = 0;
		while(true) {
			if(isset($_POST['txt'.$i])) {
				if(isset($_POST['chk'.$i])) {
					// Frage wieder hinzufügen
					saveQuestionToFbV2($_SESSION['surveyToModify'],$_POST['txt'.$i]);
				}
				$i++;
			} else {
				break;
			}
		}
		echo'<br /><br /><a href="survey_modify.php">Zurück</a>';
	}
	// Auflistung aller Fragen des Kapitels, markierte sind bereits in Fragebogen enthalten
	else if(isset($_POST['cmdModifySurvey'])) {
		echo '<form action="survey_modify.php" method="POST">';

		$questionsInChapter = getAllQuestionsOfChapter(getSurveyChapterID($_POST['cbSurveys']));
		$questionsInSurvey = getSurveyQuestions($_POST['cbSurveys']);
		$_SESSION['surveyToModify'] = $_POST['cbSurveys'];

		for($i = 0; $i < count($questionsInChapter); $i++) {
			$questionInSurvey = false;
			for($j = 0; $j < count($questionsInSurvey); $j++) {
				if($questionsInChapter[$i] === $questionsInSurvey[$j]) {
					$questionInSurvey = true;
					continue;
				}
			}
			if($questionInSurvey) {
				echo '<input type="checkbox" name="chk'.$i.'" checked />';
			} else {
				echo '<input type="checkbox" name="chk'.$i.'" />';
			}

			echo '<input type="text" name="txt'.$i.'" readonly value="'.$questionsInChapter[$i].'" class="invisibleBorder"/>';
			echo '<br />';
		}

		echo '<br /><input type="submit" name="cmdSaveSurveyModifications" value="Speichern" />';
		echo '</form>';

		echo'<br /><br /><a href="survey_modify.php">Zurück</a>';
	} else {

		// Parameter true -> Nur Fragebögen bearbeitbar, die nicht bereits bearbeitet wurden
		$surveys = getAllSurveys(true);
		if(count($surveys) > 0) {
			echo '<form action="survey_modify.php" method="POST">';
			echo 'Fragebogen auswählen: ';
			echo '<select name="cbSurveys">';
			for($i = 0; $i < count($surveys); $i++) {
				echo "<option>$surveys[$i]</option>";
			}
			echo '</select>';
			echo '<br /><br />';
			echo '<input type="submit" value="Bearbeiten" name="cmdModifySurvey" />';
			echo '</form>';
		} else {
			echo '<p>Keine Fragebögen vorhanden, die nicht bereits bearbeitet wurden!</p>';
		}
	}

	printAdminMenuBottom();
?>
</body>
</html>
