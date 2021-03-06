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
	printAdminMenu(MENU_LECTURE_MODIFY);

	echo'<h1>Vorlesung bearbeiten</h1>';

	if(!isset($_POST['cmdModifyLecture']) && !isset($_POST['cmdAddChapter']) && !isset($_POST['cmdLectureChapDel']) && !isset($_POST['cmdChapterChapDel'])) {

		$lectures = getAllLectures();
		// Vorlesung umbenennen
		if(count($lectures) > 0) {
			echo'
				<h2>Vorlesung umbenennen</h2>
				<form action="lecture_modify.php" method="POST">
					<table>
						<tr>
							<td>
								Alte Bezeichnung:
							</td>
							<td>
								<select name="cbLectureToDelete" size=1 class="fullwidth">';
									for($i = 0; $i < count($lectures); $i++) {
										echo "<option>$lectures[$i]</option>";
									}
								echo '</select>
							</td>
						</tr>
						<tr>
							<td>
								Neue Bezeichnung:
							</td>
							<td>
								<input type="text" name="txtLectureNewDescription" class="fullwidth" required />
							</td>
						</tr>
					</table>
					<br />
					<input type="submit" name="cmdModifyLecture" value="Ändern">
				</form>';

			// Kapitel hinzufügen
			echo'
				<h2>Kapitel zur Vorlesung hinzufügen</h2>
				<form action="lecture_modify.php" method="POST">
				<table>
					<tr>
						<td>
							Vorlesung:
						</td>
						<td>
							<select name="cbLectureToAddChapter" size=1 class="fullwidth">';
								for($i = 0; $i < count($lectures); $i++) {
									echo "<option>$lectures[$i]</option>";
								}
							echo '</select>
						</td>
					</tr>
					<tr>
						<td>
							Kapitelbezeichnung:
						</td>
						<td>
							<input type="text" name="txtChapterNewDescription" class="fullwidth" required />
						</td>
					</tr>
				</table>
				<br />
				<input type="submit" name="cmdAddChapter" value="Speichern">
			</form>';

			// Kapitel löschen
			echo '<h2>Kapitel löschen</h2>';
			echo '<form action="lecture_modify.php" method="POST">
							<select name="cbLectureChapDel">';
								for($i = 0; $i < count($lectures); $i++) {
									echo "<option>$lectures[$i]</option>";
								}
							echo '</select>
							<input type="submit" name="cmdLectureChapDel" value="Vorlesung bestätigen">
						</form>';
		} else {
			echo "<p>Keine Einträge vorhanden!</p>";
		}

	} else if(isset($_POST['cmdModifyLecture'])) {
		renameLecture($_POST['cbLectureToDelete'],$_POST['txtLectureNewDescription']);
		echo '</br/><br /><a href="lecture_modify.php">Zurück</a>';
	} else if(isset($_POST['cmdAddChapter'])) {
		addLectureChapter($_POST['cbLectureToAddChapter'], $_POST['txtChapterNewDescription']);
		echo '</br/><br /><a href="lecture_modify.php">Zurück</a>';
	} else if(isset($_POST['cmdLectureChapDel'])) {

		$chapters = getAllChaptersOfLecture($_POST['cbLectureChapDel'],true);
		$_SESSION['cbLectureChapDel'] = $_POST['cbLectureChapDel'];
		echo '<form action="lecture_modify.php" method="POST">
						<select name="cbChapterChapDel">';
							for($i = 0; $i < count($chapters); $i++) {
								echo "<option>$chapters[$i]</option>";
							}
						echo '</select>
						<input type="submit" name="cmdChapterChapDel" value="Kapitel bestätigen">
					</form>';

		echo '<br /></br /><a href="lecture_modify.php">Zurück</a>';
	} else if(isset($_POST['cmdChapterChapDel'])) {
		deleteChapter($_SESSION['cbLectureChapDel'], $_POST['cbChapterChapDel']);
		$_SESSION['cbLectureChapDel'] = "";
		echo '<br /></br /><a href="lecture_modify.php">Zurück</a>';
	}

	printAdminMenuBottom();
?>
</body>
</html>
