<!DOCTYPE HTML>
<html>
	<head>
		<meta lang="DE">
		<meta charset="UTF-8">
		<title>Login Vorlesungsevaluation</title>
		<link href="../global.css" type="text/css" rel="stylesheet">
	</head>
	<body>
		<form action="admin.php" name="admin_login" method="POST">
			<div class="reg">
				<h2 class="noSpace">Administrator</h2><br />
				<input type="password" name="txtAdminPassword" class="textbox"><br /><br />
				<input type="submit" name="cmdLoginAdmin" value="Absenden" class="submit">
			</div>
		</form>
		<div id="toast">NO CONTENT</div>
		<?php
			include "adminFunctions.inc.php";
			if(isset($_SESSION['toaster']) && $_SESSION['toaster'] != "") {
				if($_SESSION['toaster'] == TOAST_WRONG_PASSWORD) {
					wrongPasswordToast();
				} else if($_SESSION['toaster'] == TOAST_NO_PERMISSION) {
					noPermissionToast();
				}
				session_destroy();
			}
		?>
	</body>
</html>
