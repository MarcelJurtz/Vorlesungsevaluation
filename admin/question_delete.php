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
	printAdminMenu(MENU_QUESTION_DELETE);

	echo'<h1>Frage löschen - Administrator</h1>';


	if(isset($_POST['cmdSelectLecture'])) {

		// Vorlesung gewählt -> Kapitel wählen
		echo'<form action="question_delete.php" method="POST">
			<select name="cbChapterQuestionDelete" size=1>';
		echo getAllChaptersOfLecture($_POST['cbLectureQuestionDelete']);
		$_SESSION['cbLectureQuestionDelete'] = $_POST['cbLectureQuestionDelete'];
		echo '</select>
				<input type="submit" name="cmdSelectChapter" value="Kapitel bestätigen">
			</form>';

		echo'<br /><br /><a href="question_delete.php">Zurück</a>';

	} else if (isset($_POST['cmdSelectChapter'])) {

		// Kapitel gewählt -> Frage wählen
		echo'<form action="question_delete.php" method="POST">
			<select name="cbQuestionQuestionDelete" size=1>';

		echo getAllQuestionsOfChapter($_SESSION['cbLectureQuestionDelete'],$_POST['cbChapterQuestionDelete']);
		$_SESSION['cbChapterQuestionDelete'] = $_POST['cbChapterQuestionDelete'];
		echo '</select>
				<input type="submit" name="cmdSelectQuestion" value="Frage bestätigen">
			</form>';

		echo'<br /><br /><a href="question_delete.php">Zurück</a>';

	} else if (isset($_POST['cmdSelectQuestion'])) {

		// Frage gewählt -> Frage löschen
		deleteQuestion($_SESSION['chapterIDtoDelete'], $_POST['cbQuestionQuestionDelete']);
		echo'<br /><br /><a href="question_delete.php">Zurück</a>';

	} else {

		// Vorlesung wählen
		echo'<form action="question_delete.php" method="POST">
					<select name="cbLectureQuestionDelete" size=1>';
		echo getAllLectures();
		echo '</select>
				<input type="submit" name="cmdSelectLecture" value="Vorlesung bestätigen">
			</form>';
	}

	printAdminMenuBottom();
?>
</body>
</html>
