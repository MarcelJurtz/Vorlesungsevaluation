<!DOCTYPE html>
<html>
<head>
	<link href="../global.css" rel="stylesheet" type="text/css">
	<title>Admin - Übersicht</title>
	<meta charset="UTF-8">
</head>
<body>
<?php

  include "studFunctions.inc.php";


  if(!ValidateUsername(GetSessionUsername())) {
   logout();
 } else {

 }

  printSidebarMenuBegin();



		printClassTitle();

		echo '<form action="survey_edit.php" method="POST">';

  	// Neue Fragebögen

		echo '<h2>Neue Fragebögen</h2>';
		$surveys = GetNewSurveys(GetClassFromStudent(GetSessionUsername()));
		if(count($surveys) > 0) {
			echo '<select name="cbSurveysToEdit">';
			for($i = 0; $i < count($surveys); $i++) {
				echo '<option>' . $surveys[$i] . '</option>';
			}
			echo '</select>';
			echo '<input type="submit" name="cmdEditSurveyNew" value="Bearbeiten" />';
		} else {
			echo 'Keine freigegebenen Fragebögen vorhanden!';
		}

		// Angefangene Fragebögen

		echo '<h2>Angefangene Fragebögen</h2>';
		$surveys = GetEditedSurveys(GetClassFromStudent(GetSessionUsername()));
		if(count($surveys) > 0) {
			echo '<select name="cbSurveysToEdit">';
			for($i = 0; $i < count($surveys); $i++) {
				echo '<option>' . $surveys[$i] . '</option>';
			}
			echo '</select>';
			echo '<input type="submit" name="cmdEditSurveyEdited" value="Bearbeiten" />';
		} else {
			echo 'Keine freigegebenen Fragebögen vorhanden!';
		}

		// Abgeschlossene Fragebögen

		echo '<h2>Abgeschlossene Fragebögen</h2>';
		$surveys = GetCompletedSurveys(GetSessionUsername());
		if(count($surveys) > 0) {
			echo '<select name="cbSurveysCompleted">';
			for($i = 0; $i < count($surveys); $i++) {
				echo '<option>' . $surveys[$i] . '</option>';
			}
			echo '</select>';
		} else {
			echo 'Keine abgeschlossenen Fragebögen vorhanden!';
		}

		echo '</form>';

  printSidebarMenuEnd();
?>
</body>
</html>
