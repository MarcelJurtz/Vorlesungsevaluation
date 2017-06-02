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
	printAdminMenu(MENU_SURVEY_ENABLE);

	echo'			<h1>Fragebogen freigeben - Administrator</h1>';

	if(isset($_POST['cmdEnableSurvey'])) {
		enableSurvey($_POST['cbSurveys'], $_POST['cbClasses']);
		echo'<br /><br /><a href="survey_enable.php">Zurück</a>';
	} else {

		$surveys = getAllSurveys();
		if(count($surveys) > 0) {
			echo '<form action="survey_enable.php" method="POST">';

			// Fragebogen
			echo 'Fragebogen auswählen: ';
			echo '<select name="cbSurveys">';
			for($i = 0; $i < count($surveys); $i++) {
				echo "<option>$surveys[$i]</option>";
			}
			echo '</select>';
			echo '<br />';

			// Kurs
			echo 'Kurs auswählen: ';
			echo '<select name="cbClasses">';
			echo getAllClasses();
			echo '</select>';

			echo '<br />';
			echo '<input type="submit" value="Freigeben" name="cmdEnableSurvey" />';
			echo '</form>';
		} else {
			echo 'Keine Fragebögen vorhanden!';
		}

		// Liste aller freigegebenen Fragebögen
		echo '<h2>Freigegebene Fragebögen:</h2>';

		$enabledSurveys = getEnabledSurveys();
		if(count($enabledSurveys) > 0) {
			echo '<ul>';

			sort($enabledSurveys);
			for($i = 0; $i < count($enabledSurveys); $i++) {
				echo '<li>' . $enabledSurveys[$i] . '</li>';
			}

			echo '</ul>';
		} else {
			echo 'Keine freigegebenen Fragebögen vorhanden!';
		}
	}

	printAdminMenuBottom();
?>
</body>
</html>
