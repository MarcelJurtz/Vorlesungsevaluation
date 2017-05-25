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

			// Letzte Frage speichern
			if($_SESSION['lastQuestionType'] == FRAGENTYP_MULTIPLE_CHOICE_DB) {
				$id = $_SESSION['lastQuestionID'];

				$stud = GetSessionUsername();

				$conn = getDBConnection();

				$iterator = 0;
				$query = "SELECT COUNT(".ANTWORT_AwID.") as CT_ANWERS FROM " . ANTWORT . " WHERE " . ANTWORT_FrID . " = $id";

				$getCount = mysqli_fetch_assoc(mysqli_query($conn,$query));
				$count = $getCount['CT_ANWERS'];

				for($i = 0; $i < $count; $i++) {
					$truth = SHORT_FALSE;
					if(isset($_POST["chkAnswer$i"]) && $_POST["chkAnswer$i"] == "on") {
						$truth = SHORT_TRUE;
					}

					$query = "REPLACE INTO " . BEANTWORTET . " VALUES ('$stud',$id,$i,'$truth', ".$survey->GetID().");";

					if(!mysqli_query($conn,$query)) {
						echo "Fehler beim Speichern der Antwort.";
					}
				}

				mysqli_close($conn);

			} else if($_SESSION['lastQuestionType'] == FRAGENTYP_TEXTFRAGE_DB) {
				$id = $_SESSION['lastQuestionID'];

				$stud = GetSessionUsername();
				$answer = $_POST['txtAnswerInput'];

				if($answer != null && $answer != "") {
					$conn = getDBConnection();

					$answer = mysqli_real_escape_string($conn,$answer);

					// awID bei Textfragen immer 0
					// REPLACE bei mySQL entspricht INSERT OR UPDATE
					$query = "REPLACE INTO " . BEANTWORTET . " VALUES ('$stud',$id,0,'$answer', ".$survey->GetID().");";

					if(!mysqli_query($conn,$query)) {
						echo "Fehler beim Speichern der Antwort.";
					}
					mysqli_close($conn);
				}
			}

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
