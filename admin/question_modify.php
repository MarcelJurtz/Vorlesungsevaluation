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
	printAdminMenu(MENU_QUESTION_MODIFY);

	echo'<h1>Frage bearbeiten</h1>';

	// Vorlesung gewählt -> Kapitel wählen
	if(isset($_POST['cmdSelectLecture'])) {

		$chapters = getAllChaptersOfLecture($_POST['cbLectureQuestionModify']);
		$_SESSION['cbLectureQuestionModify'] = $_POST['cbLectureQuestionModify'];

		if(count($chapters) > 0) {
			echo'<form action="question_modify.php" method="POST">
				<select name="cbChapterQuestionModify" size=1>';
				for($i = 0; $i < count($chapters); $i++) {
					echo "<option>" . $chapters[$i] . "</option>";
				}
			echo '</select>
					<input type="submit" name="cmdSelectChapter" value="Kapitel bestätigen">
				</form>';
		} else {
			echo '<p>Keine Einträge vorhanden.</p>';
		}

		echo'<br /><br /><a href="question_modify.php">Zurück</a>';

	} else if (isset($_POST['cmdSelectChapter'])) {

		// Kapitel gewählt -> Frage wählen

		// Parameter true -> Nur Bezug von Fragen, die bisher nicht verwendet wurden
		$questions = getAllQuestionsOfChapter(getChapterId($_SESSION['cbLectureQuestionModify'],$_POST['cbChapterQuestionModify']), true);

		if(count($questions) > 0) {
			$_SESSION['cbChapterQuestionModify'] = $_POST['cbChapterQuestionModify'];

			echo'<form action="question_modify.php" method="POST">';
			echo '<select name="cbQuestionQuestionModify">';
			for($i = 0; $i < count($questions); $i++) {
				echo '<option>'.$questions[$i].'</option>';
			}
			echo '</select>';
			echo '<input type="submit" name="cmdSelectQuestion" value="Frage bestätigen">
			</form>';
		} else {
			echo "<p>In diesem Kapitel sind keine Fragen vorhanden, die nicht bereits in einem Fragebogen verwendet werden.</p>";
		}



		echo'<br /><br /><a href="question_modify.php">Zurück</a>';

	} else if (isset($_POST['cmdSelectQuestion'])) {

		$question = new question($_POST['cbQuestionQuestionModify']);
		if($question != null) {
			echo '<form action="question_modify.php" method="POST">';
				$_SESSION['MODIFY_QUESTION'] = $question->GetName();
				echo 'Fragebezeichnung:<br/><input type="text" name="txtQuestionName" value="'.$question->GetName().'" required />';
				echo '<br/><br/>';
				echo 'Fragebetext:<br/><textarea name="txtQuestionText" rows="5" cols="30">'.$question->GetText().'</textarea>';
				echo '<br/><br/>';
				if($question->GetType() == FRAGENTYP_MULTIPLE_CHOICE_DB) {
					$_SESSION['MODIFY_QUESTION_TYPE'] = FRAGENTYP_MULTIPLE_CHOICE_DB;
					echo "Typ: Multiple Choice<br/>";
					$answers = $question->GetQuestionAnswersWithTruths();
					$iterator = 0;
					foreach($answers as $answer => $truth) {
  					echo 'Antwort: <input type="text" name="txtAnswer'.$iterator.'" value="'.$answer.'" required /> ';
						if(implode("",$truth) == SHORT_TRUE) {
							echo 'Korrekt: <input type="checkbox" name="chk'.$iterator.'" checked />';
						} else {
							echo 'Korrekt: <input type="checkbox" name="chk'.$iterator.'"/>';
						}
						echo '<br/>';
						$iterator++;
					}
				} else {
					$_SESSION['MODIFY_QUESTION_TYPE'] = FRAGENTYP_TEXTFRAGE_DB;
					echo "Typ: Textfrage<br/>";
					$answers = $question->GetQuestionAnswers();
					echo '<textarea name="txtAnswer0" rows=5 cols=50>' . $answers[0] . '</textarea>';
				}
			echo '<input type="submit" name="cmdSubmitModifications" value="Speichern" />';
			echo '</form>';
		} else {
			echo "<p>Ungültige Auswahl der Frage '" . $_POST['cbQuestionQuestionModify'] . "'.</p>";
		}

		echo'<br /><br /><a href="question_modify.php">Zurück</a>';

	} else if (isset($_POST['cmdSubmitModifications'])) {

		$question = new question($_SESSION['MODIFY_QUESTION']);

		// Änderungen der Antworten speichern
		$iterator = 0;
		$res = true;

		while(true && ($question != null)) {
			if(!isset($_POST['txtAnswer'.$iterator]) || ($iterator > 0 && $question->GetType() == FRAGENTYP_TEXTFRAGE_DB)) break;

			$answer = $_POST['txtAnswer'.$iterator];
			$truth = SHORT_FALSE;
			if($_SESSION['MODIFY_QUESTION_TYPE'] == FRAGENTYP_TEXTFRAGE_DB) $truth = true;

			if(isset($_POST['chk'.$iterator])) $truth = SHORT_TRUE;

			$conn = getDBConnection();
			$conn -> autocommit(FALSE);

			$result = mysqli_query($conn,"UPDATE " . ANTWORT .
										" SET " . ANTWORT_AWTEXT . " = '$answer', " . ANTWORT_AwWahrheit . " = $truth " .
										" WHERE " . ANTWORT_FrID . " = " .
										$question->GetID() . " AND " .
										ANTWORT_AwID . " = $iterator;");

			if(!$result) {
				echo "<p>Fehler beim Update von Antwort '$answer'.</p>";
			}

			if(!$result) $res = false;
			$iterator++;
		}

		// Änderungen an der Frage speichern
		$title = mysqli_real_escape_string($conn,$_POST['txtQuestionName']);
		$text = mysqli_real_escape_string($conn,$_POST['txtQuestionText']);


		$result = mysqli_query($conn,"UPDATE " . FRAGE .
										" SET " . FRAGE_FrBezeichnung . " = '$title', " . FRAGE_FrText . " = '$text'" .
										" WHERE " . FRAGE_FrBezeichnung . " = '". $_SESSION['MODIFY_QUESTION'] . "';");

		if(!$result) {
			echo "<p>Fehler beim Update von Frage '" . $_SESSION['MODIFY_QUESTION'] . "'.</p>";
		}

		if ($res && $result) {
			mysqli_commit($conn);
			echo "<p>Speichern der Änderungen erfolgreich abgeschlossen.</p><br /><a href='question_modify.php'>Zurück</a>";
		} else {
			mysqli_rollback($conn);
		}

		mysqli_close($conn);
	} else {

		$lectures = getAllLectures();

		if(count($lectures) > 0) {
			// Vorlesung wählen
			echo'<form action="question_modify.php" method="POST">
						<select name="cbLectureQuestionModify" size=1>';
					for($i = 0; $i < count($lectures); $i++) {
				echo "<option>" . $lectures[$i] . "</option>";
			}
			echo '</select>
					<input type="submit" name="cmdSelectLecture" value="Vorlesung bestätigen">
				</form>';
		} else {
			echo "<p>Keine Einträge vorhanden.</p>";
		}
	}

	echo'		</div>';
	echo'		<br class="clear" />';
	echo'	</div>';
?>
</body>
</html>
