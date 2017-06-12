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
		$_SESSION['toaster'] = TOAST_NO_PERMISSION;
		header("Location: ./index.php");
	}

	// Aufbau Website
	printAdminMenu(MENU_STATISTICS);

	echo'<h1>Statistiken</h1>';

	if(isset($_POST['cmdSelectSurvey'])) {

		// Fragebögen Statistiken laden
		$survey = new survey($_POST['cbStatisticsSurvey']);
		$studTotal = getTotalStudents($survey->GetID(),$_SESSION['STAT_CLASS']);
		$studSubmitted =  getSubmittedStudents($survey->GetID(),$_SESSION['STAT_CLASS']);

		if($studSubmitted == 0) {
			echo '<p>Von mindestens einem der Kurse wurde dieser Fragebogen noch nicht beantwortet.</p>';
		} else {
			echo "<p>$studSubmitted von $studTotal Studenten des Kurses " . $_SESSION['STAT_CLASS'] ." haben den Fragebogen '" . $_POST['cbStatisticsSurvey'] . "' bereits abgegeben.</p>";

			echo "<h2>Auswertung der Multiple Choice Fragen</h2>";

			for($i = 0; $i < $survey->GetQuestionCount(); $i++) {
				if($survey->GetQuestionAt($i)->GetType() == FRAGENTYP_MULTIPLE_CHOICE_DB) {
					echo '<h3>Frage '.($i+1).'</h3>';
					echo '<p>' . $survey->GetQuestionAt($i)->GetText() . '</p>';

					echo '<canvas id="chartQ'.$i.'"></canvas>';

					$data = GetAmountOfVotes($survey->GetQuestionAt($i)->GetName(),$_POST['cbStatisticsSurvey'], $_SESSION['STAT_CLASS']);
					$fields = $survey->GetQuestionAt($i)->GetQuestionAnswers();

					$colors = array();
					$borderColors = array();

					$answers = $survey->GetQuestionAt($i)->GetQuestionAnswersWithTruths();
					foreach($answers as $k => $v) {
						  if(implode("-",$v) == SHORT_TRUE) {
								$colors[] = COLOR_TRUE_A;
								$borderColors[] = COLOR_TRUE_BORDER_A;
							} else {
								$colors[] = COLOR_FALSE_A;
								$borderColors[] = COLOR_FALSE_BORDER_A;
							}
					}
					echo '<script>DrawChart("chartQ' . $i . '",' . json_encode($fields) .','.json_encode($data).','.json_encode($colors).','.json_encode($borderColors).')</script>';

				}
			}
		}
		echo'<br /><br /><a href="statistics.php">Zurück</a><br /><br />';

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
	} else if (isset($_POST['cmdSelectSurvey_Comparison'])) {

		echo '<h2>Kurse vergleichen</h2>';

		echo '<form action="statistics.php" method="POST">';

		$classes = getClassesForSurvey(getSurveyID($_POST['cbStatisticsSurvey_Comparison']));
		if(count($classes) > 0) {
			echo '<table>';
				echo '<tr>';
					echo '<td>';
						echo 'Fragebogen:';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" name="txtStatisticsComparisonSurvey" readonly class="invisibleBorder" value="'.$_POST['cbStatisticsSurvey_Comparison'].'"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>Erster Kurs:</td>';
					echo '<td><select name="cbStatisticsClass_Comparison1">';
						for($i = 0; $i < count($classes); $i++) {
							echo '<option>'.$classes[$i].'</option>';
						}
					echo '</select></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>Zweiter Kurs:</td>';
					echo '<td><select name="cbStatisticsClass_Comparison2">';
						for($i = 0; $i < count($classes); $i++) {
							echo '<option>'.$classes[$i].'</option>';
						}
					echo '</select></td>';
				echo '</tr>';
			echo '<table>';
			echo '<br />';
			echo '<input type="submit" name="cmdSelectClass_Comparison" value="Bestätigen" />';
		} else {
			echo 'Keine Kurse verfügbar.';
		}

		echo '</form>';
		echo'<br /><br /><a href="statistics.php">Zurück</a>';

	} else if(isset($_POST['cmdSelectClass_Comparison'])) {
		$conn = getDBConnection();

		$class1 = getClassIdFromCbString(mysqli_real_escape_string($conn,$_POST['cbStatisticsClass_Comparison1']));
		$class2 = getClassIdFromCbString(mysqli_real_escape_string($conn,$_POST['cbStatisticsClass_Comparison2']));

		if($class1 == $class2) {
			echo '<p>Ungültige Kursauswahl!</p>';
		} else {
			echo '<h2>Vergleiche Kurse: ' . $class1 . ' mit ' . $class2 . '.</h2>';

			// Fragebögen Statistiken laden
			$survey = new survey($_POST['txtStatisticsComparisonSurvey']);

			$studTotal1 = getTotalStudents($survey->GetID(),$class1);
			$studSubmitted1 =  getSubmittedStudents($survey->GetID(),$class1);

			$studTotal2 = getTotalStudents($survey->GetID(),$class2);
			$studSubmitted2 =  getSubmittedStudents($survey->GetID(),$class2);

			if($studSubmitted1 == 0 || $studSubmitted2 == 0) {
				echo '<p>Von mindestens einem der Kurse wurde dieser Fragebogen noch nicht beantwortet.</p>';
			} else {
				echo "<p>$class1: $studSubmitted1 von $studTotal1 Studenten des Kurses " . $class1 . " haben den Fragebogen '" . $_POST['txtStatisticsComparisonSurvey'] . "' bereits abgegeben.<br />";
				echo "$class2: $studSubmitted2 von $studTotal2 Studenten des Kurses " . $class2 . " haben den Fragebogen '" . $_POST['txtStatisticsComparisonSurvey'] . "' bereits abgegeben.</p>";

				echo "<h2>Auswertung der Multiple Choice Fragen</h2>";

				for($i = 0; $i < $survey->GetQuestionCount(); $i++) {
					if($survey->GetQuestionAt($i)->GetType() == FRAGENTYP_MULTIPLE_CHOICE_DB) {
						echo '<h3>Frage '.($i+1).'</h3>';
						echo '<p>' . $survey->GetQuestionAt($i)->GetText() . '</p>';

						echo '<canvas id="chartQ'.$i.'"></canvas>';

						$data = array();
						$data['class1'] = GetAmountOfVotes($survey->GetQuestionAt($i)->GetName(),$_POST['txtStatisticsComparisonSurvey'], $class1);
						$data['class2'] = GetAmountOfVotes($survey->GetQuestionAt($i)->GetName(),$_POST['txtStatisticsComparisonSurvey'], $class2);

						$labels = array();
						$labels['class1'] = $class1;
						$labels['class2'] = $class2;

						$fields = $survey->GetQuestionAt($i)->GetQuestionAnswers();

						$colors = array();
						$borderColors = array();

						$answers = $survey->GetQuestionAt($i)->GetQuestionAnswersWithTruths();
						foreach($answers as $k => $v) {
							  if(implode("-",$v) == SHORT_TRUE) {
									$colors['class1'][] = COLOR_TRUE_A;
									$colors['class2'][] = COLOR_TRUE_B;
									$borderColors['class1'][] = COLOR_TRUE_BORDER_A;
									$borderColors['class2'][] = COLOR_TRUE_BORDER_B;
								} else {
									$colors['class1'][] = COLOR_FALSE_A;
									$colors['class2'][] = COLOR_FALSE_B;
									$borderColors['class1'][] = COLOR_FALSE_BORDER_A;
									$borderColors['class2'][] = COLOR_FALSE_BORDER_B;
								}
						}
						echo '<script>DrawComparisonChart("chartQ' . $i . '",' . json_encode($fields) .','.json_encode($data) .','.json_encode($colors).','.json_encode($borderColors).','.json_encode($labels).')</script>';
					}
				}
			}
			echo'<br /><br /><a href="statistics.php">Zurück</a><br /><br />';
		}

		mysqli_close($conn);

	} else {

		echo '<h2>Ergebnisse eines Kurses einsehen</h2>';

		// Auswahl Kurs
		echo '<form action="statistics.php" method="POST">';

		$classes = getAllClasses();
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
