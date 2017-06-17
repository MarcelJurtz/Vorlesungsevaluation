<?php



  // Nur Fragebögen, die noch nicht bearbeitet wurden
  function GetNewSurveys($class) {
    $conn = getDBConnection();
    $class = mysqli_real_escape_string($conn,$class);

    $surveys = array();

    // Rückgabe aller freigegebenen Fragebögen, die noch keinen Eintrag in "bearbeitet" haben
    $query = "SELECT " . FRAGEBOGEN_FbBezeichnung .
              " FROM " . FRAGEBOGEN . " fb, " . FBFREIGABE . " ff".
              " WHERE fb.".FRAGEBOGEN_FbID . " = ff.".FBFREIGABE_FBID .
              " AND ff." . FBFREIGABE_KUID . " = '$class'".
              " AND fb.".FRAGEBOGEN_FbID . " NOT IN (
                SELECT DISTINCT " . BEANTWORTET_FBID . " FROM " . BEANTWORTET .
                " WHERE " . BEANTWORTET_STUD . " = '" . GetSessionUsername() . "'
                )";

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

  function GetEditedSurveys($class) {
    $conn = getDBConnection();
    $class = mysqli_real_escape_string($conn,$class);

    $surveys = array();

    // Rückgabe aller freigegebenen Fragebögen, die noch keinen Eintrag in "bearbeitet" haben
    $query = "SELECT " . FRAGEBOGEN_FbBezeichnung .
              " FROM " . FRAGEBOGEN . " fb, " . FBFREIGABE . " ff".
              " WHERE fb.".FRAGEBOGEN_FbID . " = ff.".FBFREIGABE_FBID .
              " AND ff." . FBFREIGABE_KUID . " = '$class'".
              " AND fb.".FRAGEBOGEN_FbID . " IN (
                SELECT DISTINCT " . BEANTWORTET_FBID .
                " FROM " . BEANTWORTET .
                " WHERE " . BEANTWORTET_STUD . " = '" . GetSessionUsername() . "'
                ) AND fb.".FRAGEBOGEN_FbID . " NOT IN (
                  SELECT " . FBABGABE_FBID .
                  " FROM " . FBABGABE .
                  " WHERE " . FBABGABE_STUD . " = '" . GetSessionUsername() . "'
                  )";

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
    $conn = getDBConnection();
    $student = mysqli_real_escape_string($conn,$student);

    $surveys = array();
    $query = "SELECT " . FRAGEBOGEN_FbBezeichnung
                  . " FROM " . FRAGEBOGEN . " fb, " . FBABGABE . " fa"
                  . " WHERE fb.".FRAGEBOGEN_FbID . " = fa." . FBABGABE_FBID
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
      echo "<p>Keine Berechtigung zur Bearbeitung des Fragebogens '".$surveyName."'</p>";
    } else {
      $conn = getDBConnection();

      // Frage laden
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
        $answers = $currentQuestion->GetQuestionAnswers();
        for($i = 0; $i < count($answers); $i++) {

          // Prüfe Existenz einer Antwort
          $answer = "";
          $query = "SELECT " . BEANTWORTET_AWTEXT .
                    " FROM " . BEANTWORTET .
                    " WHERE " . BEANTWORTET_STUD . " = '".GetSessionUsername() .
                    "' AND " . BEANTWORTET_FRID . " = " . $currentQuestion->GetID() .
                    " AND " . BEANTWORTET_AWID . " = $i" .
                    " AND " . BEANTWORTET_FBID . " = " . $survey->GetID();

          $getAnswer = mysqli_fetch_assoc(mysqli_query($conn,$query));
          $answer = $getAnswer[BEANTWORTET_AWTEXT];

          // Darstellung für Antwortmöglichkeiten mit < / >, sonst Wertung als HTML-Tag
          $answers[$i] = str_replace("<","&lt;",$answers[$i]);
          $answers[$i] = str_replace(">","&gt;",$answers[$i]);

          if($answer == SHORT_TRUE) {
            echo '<input type="checkbox" name="chkAnswer'.$i.'" checked/>' . $answers[$i] . '<br />';
          } else {
            echo '<input type="checkbox" name="chkAnswer'.$i.'"/>' . $answers[$i] . '<br />';
          }


        }
        $_SESSION['lastQuestionType'] = FRAGENTYP_MULTIPLE_CHOICE_DB;
        $_SESSION['lastQuestionID'] = $currentQuestion->GetID();

      // Antwortmöglichkeiten bei Textfragen
      } else if ($currentQuestion->GetType() == FRAGENTYP_TEXTFRAGE_DB) {

        // Prüfe Existenz einer Antwort
        $answer = "";
        $query = "SELECT " . BEANTWORTET_AWTEXT .
                  " FROM " . BEANTWORTET .
                  " WHERE " . BEANTWORTET_STUD . " = '".GetSessionUsername() .
                  "' AND " . BEANTWORTET_FRID . " = " . $currentQuestion->GetID() .
                  " AND " . BEANTWORTET_AWID . " = 0" .
                  " AND " . BEANTWORTET_FBID . " = " . $survey->GetID();

        $getAnswer = mysqli_fetch_assoc(mysqli_query($conn,$query));
        $answer = $getAnswer[BEANTWORTET_AWTEXT];

        echo '<textarea name="txtAnswerInput" rows="5" cols="60">' . $answer . '</textarea>';

        // Sessionvariablen zum Speichern von Eingaben nach Drücken des Weiter-Buttons
        $_SESSION['lastQuestionType'] = FRAGENTYP_TEXTFRAGE_DB;
        $_SESSION['lastQuestionID'] = $currentQuestion->GetID();
      } else {
        echo "<p>Ungültiger Fragentyp: ".$currentQuestion->GetType() . "</p>";
      }

      mysqli_close($conn);
    }
  }

function GetOwnSolution($surveyID, $questionID, $studName) {
  $conn = getDBConnection();

  $surveyID = mysqli_real_escape_string($conn, $surveyID);
  $questionID = mysqli_real_escape_string($conn, $questionID);
  $studName = mysqli_real_escape_string($conn, $studName);

  $query = "SELECT " . BEANTWORTET_AWID . ", " . BEANTWORTET_AWTEXT .
              " FROM " . BEANTWORTET .
              " WHERE " . BEANTWORTET_FBID . " = $surveyID" .
              " AND " . BEANTWORTET_STUD . " = '$studName'" .
              " AND " . BEANTWORTET_FRID . " = $questionID";

  $solution = array();
  $rows = mysqli_query($conn,$query);

  while($entry = mysqli_fetch_assoc($rows)) {
    $solution[] = array($entry[BEANTWORTET_AWID] => $entry[BEANTWORTET_AWTEXT]);
  }
  mysqli_close($conn);
  return $solution;
}

function GetTextQuestionSolution($questionID) {
  $conn = getDBConnection();

  $questionID = mysqli_real_escape_string($conn, $questionID);

  $query = "SELECT " . ANTWORT_AWTEXT . " FROM " . ANTWORT . " WHERE " . ANTWORT_FrID . " = " . $questionID;

  $getSolution = mysqli_fetch_assoc(mysqli_query($conn,$query));
  $solution = $getSolution[ANTWORT_AWTEXT];

  mysqli_close($conn);
  return $solution;
}

function GetMCQuestionAnswer($fbID, $questionID, $answerID) {
  $conn = getDBConnection();

  $questionID = mysqli_real_escape_string($conn, $questionID);

  $query = "SELECT " . BEANTWORTET_AWTEXT .
              " FROM " . BEANTWORTET .
              " WHERE " . BEANTWORTET_FRID . " = " . $questionID .
              " AND " . BEANTWORTET_AWID . " = $answerID" .
              " AND " . BEANTWORTET_FBID . " = $fbID";

  $getSolution = mysqli_fetch_assoc(mysqli_query($conn,$query));
  $solution = $getSolution[BEANTWORTET_AWTEXT];

  mysqli_close($conn);
  return $solution;
}
?>
