<!DOCTYPE html>
<html>
<head>
	<link href="../global.css" rel="stylesheet" type="text/css">

	<script src="../functions/js/Chart.bundle.min.js"></script>
	<script src="../functions/js/chartFunctions.js"></script>

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
	printAdminMenu(MENU_STATISTICS);

	echo'<h1>Statistiken</h1>';

	if(isset($_POST['cmdSelectSurvey'])) {

		// Fragebögen Statistiken laden
		$survey = new survey($_POST['cbStatisticsSurvey']);
		$studTotal = getTotalStudents($survey->GetID(),$_SESSION['STAT_CLASS']);
		$studSubmitted =  getSubmittedStudents($survey->GetID(),$_SESSION['STAT_CLASS']);

		echo "<p>$studSubmitted von $studTotal Studenten haben diesen Fragebogen bereits abgegeben.</p>";

		echo "<h2>Auswertung der Multiple Choice Fragen</h2>";

		for($i = 0; $i < $survey->GetQuestionCount(); $i++) {
			if($survey->GetQuestionAt($i)->GetType() == FRAGENTYP_MULTIPLE_CHOICE_DB) {
				echo '<h3>Frage '.($i+1).'</h3>';
				echo '<p>' . $survey->GetQuestionAt($i)->GetText() . '</p>';

				echo '<canvas id="chartQ'.$i.'"></canvas>';

				$data = GetAmountOfVotes($survey->GetQuestionAt($i)->GetName(),$_POST['cbStatisticsSurvey']);
				$fields = $survey->GetQuestionAt($i)->GetQuestionAnswers();
				$trueCol = COLOR_TRUE;
				$falseCol = COLOR_FALSE;
				$trueColBorder = COLOR_TRUE_BORDER;
				$falseColBorder = COLOR_FALSE_BORDER;

				$colors = array();
				$borderColors = array();

				$answers = $survey->GetQuestionAt($i)->GetQuestionAnswersWithTruths();
				foreach($answers as $k => $v) {
					  if(implode("-",$v) == SHORT_TRUE) {
							$colors[] = COLOR_TRUE;
							$borderColors[] = COLOR_TRUE_BORDER;
						} else {
							$colors[] = COLOR_FALSE;
							$borderColors[] = COLOR_FALSE_BORDER;
						}
				}
				echo '<script>DrawChart("chartQ' . $i . '",' . json_encode($fields) .','.json_encode($data).','.json_encode($colors).','.json_encode($borderColors).')</script>';

			}
		}
		echo'<br /><br /><a href="statistics.php">Zurück</a>';


	}	else if(isset($_POST['cmdSelectClass'])) {
		// Auswahl Fragebogen
		echo '<form action="statistics.php" method="POST">';

		$_SESSION['STAT_CLASS'] = getClassIdFromCbString($_POST['cbStatisticsClass']);

		$surveys = GetClassSurveys(getClassIdFromCbString($_POST['cbStatisticsClass']));
		if(count($surveys) > 0) {
			echo '<select name="cbStatisticsSurvey">';
			for($i = 0; $i < count($surveys); $i++) {
				echo '<option>'.$surveys[$i].'</option>';
			}
			echo '</select>';
			echo '<input type="submit" name="cmdSelectSurvey" value="Bestätigen" />';
		} else {
			echo 'Keine Fragebögen verfügbar.';
			echo'<br /><br /><a href="statistics.php">Zurück</a>';
		}


		echo '</form>';
	} else {

		echo '<h2>Ergebnisse eines Kurses einsehen</h2>';

		// Auswahl Kurs
		echo '<form action="statistics.php" method="POST">';

		$classes = getAllClassesArray();
		if(count($classes) > 0) {
			echo '<select name="cbStatisticsClass">';
			for($i = 0; $i < count($classes); $i++) {
				echo '<option>'.$classes[$i].'</option>';
			}
			echo '</select>';
			echo '<input type="submit" name="cmdSelectClass" value="Bestätigen" />';
		} else {
			echo 'Keine Kurse verfügbar.';
		}


		echo '</form>';

		echo '<h2>Kurse vergleichen</h2>';

		// Auswahl Fragebogen
		echo '<form action="statistics.php" method="POST">';

		$surveys = getComparableSurveys();
		if(count($surveys) > 0) {
			echo '<select name="cbStatisticsSurvey_Comparison">';
			for($i = 0; $i < count($surveys); $i++) {
				echo '<option>'.$surveys[$i].'</option>';
			}
			echo '</select>';
			echo '<input type="submit" name="cmdSelectSurvey_Comparison" value="Bestätigen" />';
		} else {
			echo 'Keine Fragebögen wurden für mehr als einen Kurs freigegeben.';
		}

		echo '</form>';
	}

	printAdminMenuBottom();
?>
</body>
</html>
