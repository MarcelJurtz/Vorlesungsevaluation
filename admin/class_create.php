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
	printAdminMenu(MENU_CLASS_CREATE);

	echo'			<h1>Kurs anlegen</h1>';

	if(!isset($_POST['cmdSubmitClass'])) {
		echo'
			<form action="class_create.php" method="POST">
				<table>
					<tr>
						<td>
							Kürzel:
						</td>
						<td>
							<input type="text" name="txtClassShort" required maxlength="5">
						</td>
					</tr>
					<tr>
						<td>
							Beschreibung:
						</td>
						<td>
							<input type="text" name="txtClassDescription" required>
						</td>
					</tr>
				</table>
				<br/>
				<input type="submit" name="cmdSubmitClass" value="Speichern">
			</form>
		';
	} else {
		$kShort = $_POST['txtClassShort'];
		$kDescription = $_POST['txtClassDescription'];

		if(!isset($kShort) || !isset($kDescription) || strlen($kShort) > 5) {
			// fehlende Werte bei der Eingabe
			echo '<p>Bitte überprüfen Sie Ihre Eingaben: <br />
					Kürzel: ' . $kShort . ',<br />
					Beschreibung: ' . $kDescription . '<br />Beachten Sie, dass das Kürzel eine Länge von fünf Zeichen erfordert.</p>';
		} else {
			createClass($kDescription, $kShort);
		}
	}

	printAdminMenuBottom();
?>
</body>
</html>
