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

	if(isset($_POST['cmdSurveySubmit'])) {
		$conn = getDBConnection();

		$survey = new survey($_SESSION['currentSurveyName']);
		$id = $survey->GetID();
		$query = "INSERT INTO " . FBABGABE . " VALUES('".GetSessionUsername()."',$id)";
		if(!mysqli_query($conn,$query)) {
			echo "Fehler beim Abgeben des Fragebogens.";
		} else {
			echo "Fragebogen erfolgreich abgegeben.";
		}

		mysqli_close($conn);
	}

	// Bearbeitung eines neuen Fragebogens: Auswahl, nächstes oder letztes
	else if(isset($_POST['cmdEditSurveyNew']) || isset($_POST['cmdSurveyNewPrevious']) || isset($_POST['cmdSurveyNewNext']) || isset($_POST['cmdEditSurveyEdited'])) {


		// true bei letzter Frage
		$currentQuestionIsMax = false;

		// Button "VORWÄRTS"

		if(isset($_POST['cmdSurveyNewNext'])) {
			$_SESSION['currentSurveyIndex']++;

			// Maximum
			$survey = new survey($_SESSION['currentSurveyName']);
			if($_SESSION['currentSurveyIndex'] >= $survey->GetQuestionCount()) {
				$_SESSION['currentSurveyIndex'] = $survey->GetQuestionCount();
				$currentQuestionIsMax = true;
			}

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

					/* Alternative REPLACE INTO
					$query = "SELECT COUNT(*) as CT FROM " . BEANTWORTET .
										" WHERE " . BEANTWORTET_STUD . " = '$stud'" .
										" AND " . BEANTWORTET_FBID . " = " . $survey->GetID() .
										" AND " . BEANTWORTET_AWID . " = $i" .
										" AND " . BEANTWORTET_FRID . " = $id";
					echo "Selecting from beantwortet: " . $query . "<br /><br />";

					$getCount = mysqli_fetch_assoc(mysqli_query($conn, $query));
					$count = $getCount['CT'];

					echo "Beantwortet gefunden: " . $count . "<br /><br />";

					$saveQuestionQuery = "";

					if($count == 1) {
						// Eintrag vorhanden -> Update
						$saveQuestionQuery = "UPDATE " . BEANTWORTET .
											" SET " . BEANTWORTET_AWTEXT . " = '$truth'" .
											" WHERE " . BEANTWORTET_STUD . " = '$stud'" .
											" AND " . BEANTWORTET_FBID . " = " . $survey->GetID() .
											" AND " . BEANTWORTET_AWID . " = $i" .
											" AND " . BEANTWORTET_FRID . " = $id";
						echo "Updatequery: $saveQuestionQuery";
					} else {
						// Kein Eintrag vorhanden -> Insert
						$saveQuestionQuery = "INSERT INTO " . BEANTWORTET . " VALUES ('$stud',$id,$i,'$truth', ".$survey->GetID().");";
						echo "InsertQuery: " . $saveQuestionQuery . "<br /><br />";
					}
					*/

					if(!mysqli_query($conn,$query)) {
						echo "Fehler beim Speichern der Antwort. <br /><br />";
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
			$_SESSION['currentSurveyName'] = $_POST['cbSurveysToEdit'];
		}

		echo '<form action="survey_edit.php" method="POST">';

		EditSurvey();

		echo '<br /><br />';
		echo '<input type="submit" name="cmdSurveyNewPrevious" value="Zurück"/>';

		if($currentQuestionIsMax) {
			echo '<input type="submit" name="cmdSurveyNewNext" value="Speichern"/><br />';
			echo '<input type="submit" name="cmdSurveySubmit" value="Fragebogen abgeben"/>';
		} else {
			echo '<input type="submit" name="cmdSurveyNewNext" value="Weiter"/>';
		}

		echo '</form>';
	} else if(isset($_POST['cmdViewSurveysCompleted'])){
		$conn = getDBConnection();

		$surveyName = mysqli_real_escape_string($conn,$_POST['cbSurveysCompleted']);
		$survey = new survey($surveyName);

		for($i = 0; $i < $survey->GetQuestionCount(); $i++) {

			$question = $survey->GetQuestionAt($i);

			$ownSolution = GetOwnSolution($survey->GetID(), $question->GetID(),GetSessionUsername());
			$type = "(Multiple Choice)";
			if($question->GetType() == FRAGENTYP_TEXTFRAGE_DB) $type = "(Textfrage)";

			echo '<h2>'.$question->GetName()." ".$type.'</h2>';
			echo '<p><b>Fragetext:</b><br /><br />'.$question->GetText().'</p>';
			echo '<p>';
			if($question->GetType() == FRAGENTYP_MULTIPLE_CHOICE_DB) {

					$sol = $question->GetQuestionAnswersWithTruths();
					echo array_search('1', $sol);
					echo '<table>
									<thead>
									<tr>
										<td>
											Antwort
										</td>
										<td>
											Musterlösung
										</td>
										<td>
											Eigene Lösung
										</td>
										</tr>
									</thead>
									<tbody>';
					foreach($sol as $k => $v) {
						$text = $question->GetAnswerText($k);

						// Lösung
						$result = "";
						if(implode("",$v) == SHORT_TRUE) $result = "X";

						// Student
						$solution = "";
						if(GetMCQuestionAnswer($survey->GetID(), $question->GetID(),$k) == SHORT_TRUE) $solution = "X";

						echo '<tr><td>'.$text.'</td><td>'.$result.'</td><td>'.$solution.'</td></tr>';
					}
					echo '</tbody></table>';

			} else {
				foreach($ownSolution as $k => $v) {
  				echo "<b>Ihre Lösung:</b><br /><br />" . implode("",$v) . '</p>';
				}

				echo '<p><b>Musterlösung:</b><br /><br />';
				echo GetTextQuestionSolution($question->GetID());
				echo '</p>';
			}
		}

		mysqli_close($conn);
	}

  printSidebarMenuEnd();
?>
</body>
</html>
