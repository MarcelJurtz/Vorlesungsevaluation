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
	printAdminMenu(MENU_QUESTION_DELETE);

	echo'<h1>Frage löschen</h1>';


	if(isset($_POST['cmdSelectLecture'])) {

		$_SESSION['cbLectureQuestionDelete'] = $_POST['cbLectureQuestionDelete'];
		$chapters = getAllChaptersOfLecture($_POST['cbLectureQuestionDelete']);

		// Vorlesung gewählt -> Kapitel wählen
		echo'<form action="question_delete.php" method="POST">
			<select name="cbChapterQuestionDelete" size=1>';
		for($i = 0; $i < count($chapters); $i++) {
			echo "<option>" . $chapters[$i] . "</option>";
		}
		echo '</select>
				<input type="submit" name="cmdSelectChapter" value="Kapitel bestätigen">
			</form>';

		echo'<br /><br /><a href="question_delete.php">Zurück</a>';

	} else if (isset($_POST['cmdSelectChapter'])) {

		$questions = getAllQuestionsOfChapter(getChapterId($_SESSION['cbLectureQuestionDelete'],$_POST['cbChapterQuestionDelete']));
		$_SESSION['chapterIDtoDelete'] = getChapterId($_SESSION['cbLectureQuestionDelete'],$_POST['cbChapterQuestionDelete']);

		// Kapitel gewählt -> Frage wählen
		echo'<form action="question_delete.php" method="POST">
			<select name="cbQuestionQuestionDelete" size=1>';
		for($i = 0; $i < count($questions); $i++) {
			echo "<option>" . $questions[$i] . "</option>";
		}
		echo '</select>
				<input type="submit" name="cmdSelectQuestion" value="Frage bestätigen">
			</form>';

		echo'<br /><br /><a href="question_delete.php">Zurück</a>';

	} else if (isset($_POST['cmdSelectQuestion'])) {

		// Frage gewählt -> Frage löschen
		deleteQuestion($_SESSION['chapterIDtoDelete'], $_POST['cbQuestionQuestionDelete']);
		echo'<br /><br /><a href="question_delete.php">Zurück</a>';

	} else {
		$lectures = getAllLectures();
		// Vorlesung wählen
		echo'<form action="question_delete.php" method="POST">
					<select name="cbLectureQuestionDelete" size=1>';
		for($i = 0; $i < count($lectures); $i++) {
			echo "<option>" . $lectures[$i] . "</option>";
		}
		echo '</select>
				<input type="submit" name="cmdSelectLecture" value="Vorlesung bestätigen">
			</form>';
	}

	printAdminMenuBottom();
?>
</body>
</html>
