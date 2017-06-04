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

			echo '<table>';
				echo '<tr>';
					echo '<td>';
						echo 'Fragebogen: ';
					echo '</td>';
					echo '<td>';
						echo '<select name="cbSurveys" class="fullwidth">';
						for($i = 0; $i < count($surveys); $i++) {
							echo "<option>$surveys[$i]</option>";
						}
					echo '</select>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo 'Kurs: ';
					echo '</td>';
					echo '<td>';
						echo '<select name="cbClasses" class="fullwidth">';
							echo getAllClasses();
						echo '</select>';
					echo '</td>';
				echo '</tr>';
			echo '</table>';

			echo '<br />';
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
