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
	printAdminMenu(MENU_SURVEY_ENABLE);

	echo'<h1>Fragebogen freigeben</h1>';

	if(isset($_POST['cmdEnableSurvey'])) {
		enableSurvey($_POST['cbSurveys'], $_POST['cbClasses']);
		echo'<br /><br /><a href="survey_enable.php">Zurück</a>';
	} else {

		$surveys = getAllSurveys();
		$classes = getAllClasses();
		if(count($surveys) > 0 && count($classes) > 0) {
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
							for($i = 0; $i < count($classes); $i++) {
								echo "<option>$classes[$i]</option>";
							}
						echo '</select>';
					echo '</td>';
				echo '</tr>';
			echo '</table>';

			echo '<br />';
			echo '<input type="submit" value="Freigeben" name="cmdEnableSurvey" />';
			echo '</form>';
		} else {
			echo '<p>Keine Einträge vorhanden. Zur Freigabe wird mindestens ein Kurs, sowie ein Fragebogen benötigt!</p>';
		}

		// Liste aller freigegebenen Fragebögen
		echo '<h2>Freigegebene Fragebögen:</h2>';

		$enabledSurveys = getEnabledSurveys();
		if(count($enabledSurveys) > 0) {
			echo '<ul class="paddingList">';

			sort($enabledSurveys);
			for($i = 0; $i < count($enabledSurveys); $i++) {
				echo '<li>' . $enabledSurveys[$i] . '</li>';
			}

			echo '</ul>';
		} else {
			echo '<p>Keine freigegebenen Fragebögen vorhanden!</p>';
		}
	}

	printAdminMenuBottom();
?>
</body>
</html>
