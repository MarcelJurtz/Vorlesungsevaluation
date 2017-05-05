<!DOCTYPE html>
<html>
<head>
	<link href="../global.css" rel="stylesheet" type="text/css">
	<title>Admin - Übersicht</title>
	<meta charset="UTF-8">
</head>
<body>
  <?php
  	include '../functions.inc.php';
  	include_once("../constants.inc.php");
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
    echo'				<li><b>Einstellungen</b></li>';
  	echo'				<li><a href="../logout.php">Abmelden</a></li>';
  	echo'			</ul>';
  	echo'		</div>';
  	echo'		<div id="cFrame">';
  	echo'			<h1>Einstellungen - Administrator</h1>';

    if(isset($_POST['cmdSubmitNewPassword'])) {

      changePassword($_POST['txtPassword'], $_POST['txtPasswordNew'], $_POST['txtPasswordConfirm']);
      echo'<br /><br /><a href="settings.php">Zurück</a>';

    } else {
      echo '<form action="settings.php" method="POST">
        Altes Passwort: <input type="password" name="txtPassword" /><br />
        Neues Passwort:<input type="password" name="txtPasswordNew" /><br />
        Neues Passwort bestätigen<input type="password" name="txtPasswordConfirm" /><br />
        <input type="submit" name="cmdSubmitNewPassword" value="Passwort ändern"/>
      </form>';
    }

  	echo'		</div>';
  	echo'		<br class="clear" />';
  	echo'	</div>';
  ?>
  </body>
  </html>
