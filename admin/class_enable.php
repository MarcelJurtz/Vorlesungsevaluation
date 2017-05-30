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
	session_start();

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
	echo'					<li><b>Kursfreigabe verwalten</b></li>';
	echo'				</ul>';
	echo'				<li>Fragen</li>';
	echo'				<ul class="lSubMenu">';
	echo'					<li><a href="question_create.php">Frage anlegen</a></li>';
	echo'					<li><a href="question_delete.php">Frage löschen</a></li>';
	echo'					<li><a href="question_modify.php">Frage bearbeiten</a></li>';
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
	echo'			<h1>Kursfreigabe verwalten - Administrator</h1>';

	if(!isset($_POST['cmdEnableClassRegistration']) && !isset($_POST['cmdDisableClassRegistration'])) {
		// Combobox aller nicht-freigegebenen Kurse zur Freigabe
		echo'<h2>Kurs zur Registrierung freigeben</h2>';
		if(getAlLClasses(true,REGFREIGABE_FALSE) != "") {
			echo '<form action="class_enable.php" method="POST">
					<select name="cbClassToEnable" size=1>';
			echo getAllClasses(true,REGFREIGABE_FALSE);
			echo '</select>
					<input type="submit" name="cmdEnableClassRegistration" value="Freischalten">
				</form>';
		} else {
			echo "Keine Kurse zur Freigabe verfügbar!";
		}
		
			echo '
			<h2>Kursfreigabe aufheben</h2>
			<form action="class_enable.php" method="POST">';
			// Aktuelle Freigaben auflisten
			$enabledClasses = getAllRegEnabledClasses();
			for($i = 0; $i < count($enabledClasses); $i++) {
				echo '<input type="checkbox" name="chkToDisable[]" value="' . getClassIdFromCbString($enabledClasses[$i]) . '">' . $enabledClasses[$i] . '</option>';
				echo '<br />';
			}
			echo '<input type="submit" name="cmdDisableClassRegistration" value="Freigabe der markierten Kurse widerrufen" />';
			echo '</form>';

	} elseif(isset($_POST['cmdEnableClassRegistration'])) {
		// Neue Freigabe erstellen
		toggleClassRegistration(getClassIdFromCbString($_POST['cbClassToEnable']), REGFREIGABE_TRUE);
		echo '</br/><br /><a href="class_enable.php">Zurück</a>';

	} elseif(isset($_POST['cmdDisableClassRegistration'])) {
		// Freigaben aufheben
		if(!empty($_POST['chkToDisable'])) {
			foreach($_POST['chkToDisable'] as $check) {
						toggleClassRegistration($check,REGFREIGABE_FALSE);
						echo '<br />';
    	}
		} else {
			echo 'Es wurden keine Kurse zur Aufhebung der Freigabe ausgewählt!';
		}

		echo '</br/><br /><a href="class_enable.php">Zurück</a>';
	}

	echo'		</div>';
	echo'		<br class="clear" />';
	echo'	</div>';
?>
</body>
</html>
