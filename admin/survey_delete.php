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
	printAdminMenu(MENU_SURVEY_DELETE);

	echo'<h1>Fragebogen löschen</h1>';

	if(isset($_POST['cmdDeleteSurvey'])) {
		deleteSurvey($_POST['cbSurveys']);
		echo'<br /><br /><a href="survey_delete.php">Zurück</a>';
	} else {

		// Parameter true -> Nur Fragebögen, die noch nicht bearbeitet wurden
		$surveys = getAllSurveys(true);
		if(count($surveys) > 0) {
			echo '<form action="survey_delete.php" method="POST">';
			echo 'Fragebogen auswählen: ';
			echo '<select name="cbSurveys">';
			for($i = 0; $i < count($surveys); $i++) {
				echo "<option>$surveys[$i]</option>";
			}
			echo '</select>';
			echo '<br /><br />';
			echo '<input type="submit" value="Löschen" name="cmdDeleteSurvey" />';
			echo '</form>';
		} else {
			echo '<p>Keine Fragebögen vorhanden, die nicht bereits bearbeitet wurden!</p>';
		}
	}

	printAdminMenuBottom();
?>
</body>
</html>
