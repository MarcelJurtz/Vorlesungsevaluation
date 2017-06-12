<!DOCTYPE HTML>
<html>
	<head>
		<meta lang="DE">
		<meta charset="UTF-8">
		<title>Login Vorlesungsevaluation</title>
		<link href="stylesheet.css" type="text/css" rel="stylesheet" />
		<link href="../global.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<form action="registerStudent.php" name="stud_login" method="POST">
<table class="reg">
<tr>
	<td>
	</td>
	<td> <h2>Anmelden</h2>
	</td>
</tr>
<tr>
	<td>
		Benutzername:
	</td>
	<td>
		<input type="text" name="txtStUserLogin" class="textbox">
	</td>
</tr>
<tr>
	<td>

	</td>
	<td>
		<input type="submit" name="cmdStUserLogin" value="Anmelden" class="submit">
	</td>
</tr>

<tr>
	<td>

	</td>
	<td>
		<h2>Registrieren</h2>
	</td>
</tr>
<tr>
	<td>
		Kurs:
	</td>
	<td>
		<input type="text" name="txtStudentClass" class="textbox">
	</td>
</tr>
<tr>
	<td>
		Benutzername:
	</td>
	<td>
		<input type="text" name="txtStudentUsername" class="textbox">
	</td>
</tr>
<tr>
	<td>

	</td>
	<td>
			<input type="submit" name="cmdRegisterStudent" value="Registrieren" class="submit" />
	</td>
</tr>
</table>
</form>
<div id="toast">NO CONTENT</div>
<?php
	include "studFunctions.inc.php";
	if(isset($_SESSION['toaster']) && $_SESSION['toaster'] != "") {
		if($_SESSION['toaster'] == TOAST_DUPLICATE_USER) {
			duplicateUserToast();
		} else if($_SESSION['toaster'] == TOAST_ILLEGAL_COURSE) {
			illegalCourseToast();
		} else if($_SESSION['toaster'] == TOAST_UNKNOWN_USERNAME) {
			unknownUserToast();
		}
		session_destroy();
	}
?>
	</body>
</html>
