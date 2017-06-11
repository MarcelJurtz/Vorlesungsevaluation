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
	printAdminMenu(MENU_CLASS_DELETE);

	echo'			<h1>Kurs löschen - Administrator</h1>';

	if(!isset($_POST['cmdDeleteClass'])) {
		echo'
			<form action="class_delete.php" method="POST">
			<select name="cbClassToDelete" size=1>';
		$classes = getAllClasses();
		for($i = 0; $i < count($classes); $i++) {
			echo "<option>" . $classes[$i] . "</option>";
		}
		echo '</select>
				<input type="submit" name="cmdDeleteClass" value="Löschen">
			</form>';
	} else {
		// Button wurde gedrückt - Kurs löschen
		// WI214 - Wirtschaftsinformatik 2014 / 2 -> Nur Kürzel wird benötigt
		deleteClass(getClassIdFromCbString($_POST['cbClassToDelete']));
		echo '</br/><br /><a href="class_delete.php">Zurück</a>';
	}

	printAdminMenuBottom();
?>
</body>
</html>
