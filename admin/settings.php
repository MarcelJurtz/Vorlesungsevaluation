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
		printAdminMenu(MENU_SETTINGS);

  	echo'<h1>Einstellungen</h1>';

    if(isset($_POST['cmdSubmitNewPassword'])) {

      changePassword($_POST['txtPassword'], $_POST['txtPasswordNew'], $_POST['txtPasswordConfirm']);
      echo'<br /><br /><a href="settings.php">Zurück</a>';

    } else {
      echo '<form action="settings.php" method="POST">
							<table>
								<tr>
									<td>
										Altes Passwort:
									</td>
									<td>
										<input type="password" name="txtPassword" />
									</td>
								</tr>
								<tr>
									<td>
										Neues Passwort:
									</td>
									<td>
										<input type="password" name="txtPasswordNew" />
									</td>
								</tr>
								<tr>
									<td>
										Neues Passwort bestätigen:
									</td>
									<td>
										<input type="password" name="txtPasswordConfirm" />
									</td>
								</tr>
							</table>
         <br />
        <input type="submit" name="cmdSubmitNewPassword" value="Passwort ändern"/>
      </form>';
    }

  	printAdminMenuBottom();
  ?>
  </body>
  </html>
