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

  printSidebarMenuBegin("survey");

	if(isset($_POST['cmdSurveySubmit'])) {

		echo '<h1>' . $_SESSION['currentSurveyName'] . '</h1>';
		$conn = getDBConnection();

		$survey = new survey($_SESSION['currentSurveyName']);
		$id = $survey->GetID();
		$query = "INSERT INTO " . FBABGABE . " VALUES('".GetSessionUsername()."',$id)";
		if(!mysqli_query($conn,$query)) {
			echo "<p>Fehler beim Abgeben des Fragebogens.</p>";
		} else {
			echo "<p>Fragebogen erfolgreich abgegeben.</p>";
		}

		mysqli_close($conn);
	}

	// Bearbeitung eines neuen Fragebogens: Auswahl, nächstes oder letztes
	else if(isset($_POST['cmdEditSurveyNew']) || isset($_POST['cmdSurveyNewPrevious']) || isset($_POST['cmdSurveyNewNext']) || isset($_POST['cmdEditSurveyEdited'])) {

		$heading = "";
		if(isset($_POST['cb'])) $heading = $_POST['cbSurveysNew'];
		else if(isset($_SESSION['currentSurveyName'])) $heading = $_SESSION['currentSurveyName'];
		echo '<h1>' . $heading . '</h1>';

		// Steuerung der Weiter / Zurück / Abgeben Buttons
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
				$query = "SELECT COUNT(".ANTWORT_AwID.") as CT_ANSWERS FROM " . ANTWORT . " WHERE " . ANTWORT_FrID . " = $id";

				$getCount = mysqli_fetch_assoc(mysqli_query($conn,$query));
				$count = $getCount['CT_ANSWERS'];

				for($i = 0; $i < $count; $i++) {
					$truth = SHORT_FALSE;
					if(isset($_POST["chkAnswer$i"]) && $_POST["chkAnswer$i"] == "on") {
						$truth = SHORT_TRUE;
					}

					$query = "REPLACE INTO " . BEANTWORTET . " VALUES ('$stud',$id,$i,'$truth', ".$survey->GetID().");";

					if(!mysqli_query($conn,$query)) {
						echo "<p>Fehler beim Speichern der Antwort.</p><br />";
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
						echo "<p>Fehler beim Speichern der Antwort.</p>";
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

			// Neu
			if(isset($_POST['cmdEditSurveyNew'])) {
				$_SESSION['currentSurveyName'] = $_POST['cbSurveysNew'];
			// Bearbeitete
			} else if(isset($_POST['cmdEditSurveyEdited'])) {
				$_SESSION['currentSurveyName'] = $_POST['cbSurveysToEdit'];
			}
		}

		echo '<form action="survey_edit.php" method="POST">';

		EditSurvey();

		echo '<br /><br />';
		echo '<input type="submit" name="cmdSurveyNewPrevious" value="Zurück"/>';


		if($currentQuestionIsMax) {
			echo '<input type="submit" name="cmdSurveyNewNext" value="Speichern"/><br /><br />';
			echo '<input type="submit" name="cmdSurveySubmit" value="Fragebogen abgeben"/>';
		} else {
			echo '<input type="submit" name="cmdSurveyNewNext" value="Weiter"/>';
		}

		echo '</form>';
	} else if(isset($_POST['cmdViewSurveysCompleted'])){

		echo '<h1>Musterlösung - ' . $_POST['cbSurveysCompleted'] . '</h1>';
		$conn = getDBConnection();

		$surveyName = mysqli_real_escape_string($conn,$_POST['cbSurveysCompleted']);
		$survey = new survey($surveyName);

		for($i = 0; $i < $survey->GetQuestionCount(); $i++) {

			$question = $survey->GetQuestionAt($i);

			$ownSolution = GetOwnSolution($survey->GetID(), $question->GetID(),GetSessionUsername());
			$type = "(Multiple Choice)";
			if($question->GetType() == FRAGENTYP_TEXTFRAGE_DB) $type = "(Textfrage)";

			echo '<h2>'. ($i +1) . ". " .$question->GetName()." ".$type.'</h2>';
			echo '<div class="studAnswerContainer">';
			echo '<p><b>Fragetext:</b><br /><br />'.$question->GetText().'</p>';
			echo '<p>';
			if($question->GetType() == FRAGENTYP_MULTIPLE_CHOICE_DB) {

					$sol = $question->GetQuestionAnswersWithTruths();
					echo array_search('1', $sol);
					echo '<table class="review">
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
			echo '</div>';
		}

		mysqli_close($conn);

		echo "<br /><br /><a href='survey_main.php'>Zurück</a><br /><br />";
	}

  printSidebarMenuEnd();
?>
</body>
</html>
