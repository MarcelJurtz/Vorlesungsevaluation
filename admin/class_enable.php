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
	printAdminMenu(MENU_CLASS_ENABLE);

	echo'			<h1>Kursfreigabe verwalten</h1>';

	if(!isset($_POST['cmdEnableClassRegistration']) && !isset($_POST['cmdDisableClassRegistration'])) {
		// Combobox aller nicht-freigegebenen Kurse zur Freigabe
		echo'<h2>Kurs zur Registrierung freigeben</h2>';
		if(count(getAllRegEnabledClasses(SHORT_FALSE)) > 0) {
			echo '<form action="class_enable.php" method="POST">
					<select name="cbClassToEnable" size=1>';
			$classes = getAllRegEnabledClasses(SHORT_FALSE);
			for($i = 0; $i < count($classes); $i++) {
				echo "<option>$classes[$i]</option>";
			}
			echo '</select>
					<input type="submit" name="cmdEnableClassRegistration" value="Freischalten">
				</form>';
		} else {
			echo "<p>Keine Kurse zur Freigabe verfügbar!</p>";
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
			echo '<br /><input type="submit" name="cmdDisableClassRegistration" value="Freigabe der markierten Kurse widerrufen" />';
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
			echo '<p>Es wurden keine Kurse zur Aufhebung der Freigabe ausgewählt!</p>';
		}

		echo '</br/><br /><a href="class_enable.php">Zurück</a>';
	}

	printAdminMenuBottom();
?>
</body>
</html>
