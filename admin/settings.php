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
		printAdminMenu(MENU_SETTINGS);

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

  	printAdminMenuBottom();
  ?>
  </body>
  </html>
