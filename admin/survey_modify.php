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
	echo'					<li><a href="survey_create.php">Fragebogen anlegen</a></li>';
	echo'					<li><a href="survey_delete.php">Fragebogen löschen</a></li>';
	echo'					<li><b>Fragebogen bearbeiten</b></li>';
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
	echo'			<h1>Fragebogen bearbeiten - Administrator</h1>';


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

		$questionsInChapter = getAllQuestionsOfChapterArray(getSurveyChapterID($_POST['cbSurveys']));
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

			echo '<input type="text" name="txt'.$i.'" readonly value="'.$questionsInChapter[$i].'" />';
			echo '<br />';
		}

		echo '<br /><input type="submit" name="cmdSaveSurveyModifications" value="Speichern" />';
		echo '</form>';

		echo'<br /><br /><a href="survey_modify.php">Zurück</a>';
	} else {

		$surveys = getAllSurveys();
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
			echo 'Keine Fragebögen vorhanden!';
		}
	}

	echo'		</div>';
	echo'		<br class="clear" />';
	echo'	</div>';
?>
</body>
</html>
