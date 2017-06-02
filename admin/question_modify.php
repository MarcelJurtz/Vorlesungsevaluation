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
	echo'					<li><b>Frage bearbeiten</b></li>';
	echo'				</ul>';
	echo'				<li>Fragebögen</li>';
	echo'				<ul class="lSubMenu">';
	echo'					<li><a href="survey_create.php">Fragebogen anlegen</a></li>';
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
	echo'			<h1>Frage bearbeiten - Administrator</h1>';

	if(isset($_POST['cmdSelectLecture'])) {

		// Vorlesung gewählt -> Kapitel wählen
		echo'<form action="question_modify.php" method="POST">
			<select name="cbChapterQuestionModify" size=1>';
		echo getAllChaptersOfLecture($_POST['cbLectureQuestionModify']);
		$_SESSION['cbLectureQuestionModify'] = $_POST['cbLectureQuestionModify'];
		echo '</select>
				<input type="submit" name="cmdSelectChapter" value="Kapitel bestätigen">
			</form>';

		echo'<br /><br /><a href="question_modify.php">Zurück</a>';

	} else if (isset($_POST['cmdSelectChapter'])) {

		// Kapitel gewählt -> Frage wählen
		echo'<form action="question_modify.php" method="POST">';
			//<select name="cbQuestionQuestionModify" size=1>';

		//echo getAllQuestionsOfChapter($_SESSION['cbLectureQuestionModify'],$_POST['cbChapterQuestionModify']);
		$unusedOnly = true;
		$questions = getAllQuestions(getChapterId($_SESSION['cbLectureQuestionModify'],$_POST['cbChapterQuestionModify']), $unusedOnly);

		echo '<select name="cbQuestionQuestionModify">';
		for($i = 0; $i < count($questions); $i++) {
			echo '<option>'.$questions[$i].'</option>';
		}
		echo '</select>';

		$_SESSION['cbChapterQuestionModify'] = $_POST['cbChapterQuestionModify'];
		//echo '</select>
			echo '<input type="submit" name="cmdSelectQuestion" value="Frage bestätigen">
		</form>';

		echo'<br /><br /><a href="question_modify.php">Zurück</a>';

	} else if (isset($_POST['cmdSelectQuestion'])) {

		include "./../functions/studentFunctions/survey.php";
		$question = new question($_POST['cbQuestionQuestionModify']);
		if($question != null) {
			echo '<form action="question_modify.php" method="POST">';
				$_SESSION['MODIFY_QUESTION'] = $question->GetName();
				echo 'Fragebezeichnung:<br/><input type="text" name="txtQuestionName" value="'.$question->GetName().'" />';
				echo '<br/><br/>';
				echo 'Fragebetext:<br/><textarea name="txtQuestionText" rows="5" cols="30">'.$question->GetText().'</textarea>';
				echo '<br/><br/>';
				if($question->GetType() == FRAGENTYP_MULTIPLE_CHOICE_DB) {
					$_SESSION['MODIFY_QUESTION_TYPE'] = FRAGENTYP_MULTIPLE_CHOICE_DB;
					echo "Typ: Multiple Choice<br/>";
					$answers = $question->GetQuestionAnswersWithTruths();
					$iterator = 0;
					foreach($answers as $answer => $truth) {
  					echo 'Antwort: <input type="text" name="txtAnswer'.$iterator.'" value="'.$answer.'" /> ';
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
			echo "Ungültige Auswahl der Frage '" . $_POST['cbQuestionQuestionModify'] . "'.";
		}

		echo'<br /><br /><a href="question_modify.php">Zurück</a>';

	} else if (isset($_POST['cmdSubmitModifications'])) {

		include "./../functions/studentFunctions/survey.php";
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
				echo "Fehler beim Update von Antwort '$answer'<br />";
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
			echo "Fehler beim Update von Frage '" . $_SESSION['MODIFY_QUESTION'] . "'<br />";
		}

		$res = $res && $result;

		if ($res) {
			$conn -> commit();
			echo "Speichern der Änderungen erfolgreich abgeschlossen.<br /><br /><a href='question_modify.php'>Zurück</a>";
		} else {
			$conn -> rollback();
		}

		mysqli_close($conn);
	} else {

		// Vorlesung wählen
		echo'<form action="question_modify.php" method="POST">
					<select name="cbLectureQuestionModify" size=1>';
		echo getAllLectures();
		echo '</select>
				<input type="submit" name="cmdSelectLecture" value="Vorlesung bestätigen">
			</form>';
	}

	echo'		</div>';
	echo'		<br class="clear" />';
	echo'	</div>';
?>
</body>
</html>
