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

	if(isset($_POST['cmdLoginAdmin'])) {
		$dbConn = getDBConnection();
		//$pw = md5(mysqli_real_escape_string($dbConn, $_POST['txtAdminPassword']));
		$pw = hash('sha256', mysqli_real_escape_string($dbConn, $_POST['txtAdminPassword']));

		if(!$dbConn) {
			echo '<h1>Verbindung fehlgeschlagen</h1>';
		}
		$sql = "SELECT " . ADMINISTRATOR_AName . ", " . ADMINISTRATOR_AKennwort . " FROM administrator WHERE AKennwort = '".$pw."';";


		$result = mysqli_query($dbConn, $sql);
		$adminName = mysqli_fetch_assoc($result);

		$_SESSION['adminName'] = $adminName[ADMINISTRATOR_AName];

		if($adminName[ADMINISTRATOR_AKennwort] != $pw) {
			// Falsches Passwort
			header("Location: ./login.html");
		}
	} else if (!isset($_SESSION['adminName'])){
		header("Location: ./login.html");
	}

	// Aufbau Website

	printAdminMenu(MENU_OVERVIEW);

	echo'			<h1>Übersicht - Administrator</h1>';
	echo'			<p>Wählen Sie einen Menüpunkt zur Bearbeitung</p>';

	printAdminMenuBottom();

?>
</body>
</html>
