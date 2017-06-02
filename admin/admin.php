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
	echo'<div id="cWrapper">';
	echo'		<div id="cMenu">';
	echo'			<ul id="lMenu">';
	echo'				<li><b>Übersicht</b></li>';
	echo'				<li>Kurse</li>';
	echo'				<ul class="lSubMenu">';
	echo'					<li><a href="class_create.php">Kurs anlegen</a></li>';
	echo'					<li><a href="class_delete.php">Kurs löschen</a></li>';
	echo'					<li><a href="class_enable.php">Kursfreigabe verwalten</a></li>';
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
	echo'					<li><a href="survey_create.php">Fragebogen bearbeiten</a></li>';
	echo'					<li><a href="survey_delete.php">Fragebogen freigeben</a></li>';
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
	echo'			<h1>Übersicht - Administrator</h1>';
	echo'			<p>Wählen Sie einen Menüpunkt zur Bearbeitung</p>';
	echo'		</div>';
	echo'		<br class="clear" />';
	echo'	</div>';
?>
</body>
</html>
