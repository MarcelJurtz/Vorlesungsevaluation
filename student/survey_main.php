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

  printSidebarMenuBegin("survey");
	echo "<h1>Fragebögen für Kurs " . GetClassFromStudent(GetSessionUsername()) . "</h1>";
	echo '<form action="survey_edit.php" method="POST">';

  // Neue Fragebögen

	echo '<h2>Neue Fragebögen</h2>';
	$surveys = GetNewSurveys(GetClassFromStudent(GetSessionUsername()));
	if(count($surveys) > 0) {
		echo '<select name="cbSurveysNew">';
		for($i = 0; $i < count($surveys); $i++) {
			echo '<option>' . $surveys[$i] . '</option>';
		}
		echo '</select>';
		echo '<input type="submit" name="cmdEditSurveyNew" value="Bearbeiten" />';
	} else {
		echo '<p>Keine freigegebenen Fragebögen vorhanden!</p>';
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
		echo '<p>Keine angefangenen Fragebögen vorhanden!</p>';
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
		echo '<input type="submit" name="cmdViewSurveysCompleted" value="Musterlösung anzeigen"/>';
	} else {
		echo '<p>Keine abgeschlossenen Fragebögen vorhanden!</p>';
	}
	echo '</form>';

	printSidebarMenuEnd();
}

?>
</body>
</html>
