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

	// Bearbeitung eines neuen Fragebogens: Auswahl, nächstes oder letztes
	if(isset($_POST['cmdEditSurveyNew']) || isset($_POST['cmdSurveyNewPrevious']) || isset($_POST['cmdSurveyNewNext'])) {

		// Button "VORWÄRTS"

		if(isset($_POST['cmdSurveyNewNext'])) {
			$_SESSION['currentSurveyIndex']++;

			// Maximum
			$survey = new survey($_SESSION['currentSurveyName']);
			if($_SESSION['currentSurveyIndex'] > $survey->GetQuestionCount())
				$_SESSION['currentSurveyIndex'] = $survey->GetQuestionCount();

		// Button "ZURÜCK"
		} else if(isset($_POST['cmdSurveyNewPrevious'])) {
			$_SESSION['currentSurveyIndex']--;

			// Minimum
			if($_SESSION['currentSurveyIndex'] < 1)
				$_SESSION['currentSurveyIndex'] = 1;
		} else {
			$_SESSION['currentSurveyIndex'] = 1;
			$_SESSION['currentSurveyName'] = $_POST['cbSurveysNew'];
		}

		echo '<form action="survey_edit.php" method="POST">';

		EditSurvey();

		echo '<br /><br />';
		echo '<input type="submit" name="cmdSurveyNewPrevious" value="Zurück"/>';
		echo '<input type="submit" name="cmdSurveyNewNext" value="Weiter"/>';
		echo '</form>';
	} else {

	}

  printSidebarMenuEnd();
?>
</body>
</html>
