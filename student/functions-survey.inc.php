<?php
  function GetClassSurveys($class) {
    $conn = getDBConnection();
    $class = mysqli_real_escape_string($conn,$class);

    $surveys = array();
    $query = "SELECT " . FRAGEBOGEN_FbBezeichnung . " FROM " . FRAGEBOGEN . " fb, " . FBFREIGABE . " ff WHERE fb.".FRAGEBOGEN_FbID . " = ff.".FBFREIGABE_FBID . " AND ff." . FBFREIGABE_KUID . " = '$class'";

    if(!(mysqli_num_rows(mysqli_query($conn,$query)) > 0)) {
      return $surveys;
    }

    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) {
      $surveys[] = $row[FRAGEBOGEN_FbBezeichnung];
    }

    mysqli_close($conn);
    return $surveys;
  }

  function GetCompletedSurveys($student) {
  // TODO: prüfen
    $conn = getDBConnection();
    $student = mysqli_real_escape_string($conn,$student);

    $surveys = array();
    $query = "SELECT " . FRAGEBOGEN_FbBezeichnung
                  . " FROM " . FRAGEBOGEN . " fb, " . FBAGBABE . " fa"
                  . " WHERE fb.".FRAGEBOGEN_FbID . " = fa." . FBAGBABE_FBID
                  . " AND fa." . FBABGABE_STUD . " = '$student'";

    if(!(mysqli_num_rows(mysqli_query($conn,$query)) > 0)) {
      return $surveys;
    }

    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) {
      $surveys[] = $row[FRAGEBOGEN_FbBezeichnung];
    }

    mysqli_close($conn);
    return $surveys;
  }

  // Prüfung, ob Nutzer zur Bearbeitung eines Fragebogens berechtigt ist
  // Kurs muss hierzu freigegeben sein
  function ValidateUserSurveyEdit($student,$survey) {
    $class = GetClassFromStudent($student);
    $surveys = GetClassSurveys($class);
    return in_array($survey,$surveys);
  }


  // TODO getSurveyID und getSurveyQuestions werden auch von Admin gebraucht -> Zusammenlegen?

  function getSurveyID($surveyName) {
    $conn = getDBConnection();
    $surveyName = mysqli_real_escape_string($conn,$surveyName);
    $query = "SELECT " . FRAGEBOGEN_FbID . " FROM " . FRAGEBOGEN . " WHERE " . FRAGEBOGEN_FbBezeichnung . " = '$surveyName';";
    $id = -1;
    $result = mysqli_query($conn,$query);
    if ($result) {
      $row = mysqli_fetch_assoc($result);
      $id = $row[FRAGEBOGEN_FbID];
    }

    mysqli_close($conn);
    return $id;
  }

  // Bearbeiten einer Umfrage
  function EditSurvey() {

    $surveyName = $_SESSION['currentSurveyName'];

    if(!ValidateUserSurveyEdit(GetSessionUsername(),$surveyName)) {
      echo "Keine Berechtigung zur Bearbeitung des Fragebogens '".$surveyName."'";
    } else {
      $conn = getDBConnection();

      // Frage laden
      // TODO Achtung beim Speichern! Keine Reihenfolge, Text-Vergleich notwendig

      if(!isset($_SESSION['currentSurveyIndex'])) $_SESSION['currentSurveyIndex'] = 0;

      // Frage X / Y
      echo "Frage " . $_SESSION['currentSurveyIndex'];
      $survey = new survey($surveyName);
      echo " / " . $survey->GetQuestionCount();

      $currentQuestion = $survey->GetQuestionAt($_SESSION['currentSurveyIndex']-1);

      // Bezeichnung
      echo "<h3>" . $currentQuestion->GetName() . "</h3>";

      // Text
      echo $currentQuestion->GetText();
      echo "<br /><br />";

      // Antwortmöglichkeiten bei Multiple Choice
      if($currentQuestion->GetType() == FRAGENTYP_MULTIPLE_CHOICE_DB) {
        $answers = $currentQuestion->GetQuesionAnswers();
        for($i = 0; $i < count($answers); $i++) {
          echo '<input type="checkbox" name="chk'.$i.'"/>' . $answers[$i] . '<br />';
        }
      } else if ($currentQuestion->GetType() == FRAGENTYP_TEXTFRAGE_DB) {
      } else {
        echo "TYPE ERROR: ".$currentQuestion->GetType();
      }

      mysqli_close($conn);
    }
  }
?>
