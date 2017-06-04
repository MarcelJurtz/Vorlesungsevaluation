<?php

  function fbExisting($fb) {
    $conn = getDBConnection();
    $result = mysqli_query($conn,"SELECT * FROM " . FRAGEBOGEN . " WHERE " . FRAGEBOGEN_FbBezeichnung . " = '$fb'");
    mysqli_close($conn);
    return mysqli_num_rows($result) != 0;
  }

  function createFb($fb, $lecture, $chapter) {
    $conn = getDBConnection();

    $chapterID = getChapterId($lecture, $chapter);
    $fb = mysqli_real_escape_string($conn,$fb);

    $query = "INSERT INTO " . FRAGEBOGEN . "(" . FRAGEBOGEN_FbBezeichnung . "," . FRAGEBOGEN_Kapitel . ") VALUES('$fb',$chapterID);";
    if(mysqli_query($conn,$query)) {
      echo "Fragebogen erfolgreich angelegt!<br /><br />";
    } else {
      echo "Fehler beim Anlegen des Fragebogens.";
    }

    mysqli_close($conn);
  }

  // TODO: Überarbeiten $fb wird nicht benötigt
  function saveQuestionToFb($fb, $question) {
    // Eintrag für FB erstellen, wenn nicht vorhanden
    $conn = getDBConnection();

    // Fragen einfügen
    $query = "SELECT MAX(". FRAGEBOGEN_FbID .") AS MAXIMUM FROM " . FRAGEBOGEN;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $fbID = $row['MAXIMUM'];

    $query = "INSERT INTO " . FR_IN_FB . " VALUES($fbID, '" . $question . "');";

    if(mysqli_query($conn,$query)) {
      echo "Frage '$question' erfolgreich zum Fragebogen hinzugefügt.<br />";
    } else {
      // TODO
    }
    mysqli_close($conn);
  }

  function deleteSurveyQuestions($fb) {
    $conn = getDBConnection();

    $fb = mysqli_real_escape_string($conn,$fb);
    $fbID = getSurveyID($fb);
    $query = "DELETE FROM " . FR_IN_FB . " WHERE " . FR_IN_FB_FBID . " = '$fbID';";
    if(mysqli_query($conn,$query)) {
      echo "Fragebogen erfolgreich zurückgesetzt.<br />";
    } else {
      echo "Fehler beim Zurücksetzen des Fragebogens.<br />";
    }

    mysqli_close($conn);
  }

  function saveQuestionToFbV2($fb, $question) {
    // Eintrag für FB erstellen, wenn nicht vorhanden
    $conn = getDBConnection();

    // Fragen einfügen
    $fb = mysqli_real_escape_string($conn,$fb);
    $question = mysqli_real_escape_string($conn,$question);

    $fbID = getSurveyID($fb);

    $query = "INSERT INTO " . FR_IN_FB . " VALUES($fbID, '" . $question . "');";

    if(mysqli_query($conn,$query)) {
      echo "Frage '$question' erfolgreich zum Fragebogen hinzugefügt.<br />";
    } else {
      // TODO
    }
    mysqli_close($conn);
  }

  function getAllSurveys() {
    $conn = getDBConnection();
    $query = "SELECT " . FRAGEBOGEN_FbBezeichnung . " FROM " . FRAGEBOGEN . ";";

    $surveys = array();

    $rows = mysqli_query($conn,$query);
    while($entry = mysqli_fetch_assoc($rows))
    {
      $surveys[] = $entry[FRAGEBOGEN_FbBezeichnung];
    }

    mysqli_close($conn);
    return $surveys;
  }

  function deleteSurvey($surveyName) {
    $conn = getDBConnection();
    $id = getSurveyID($surveyName);
    if($id > -1) {
      // -1 ist standardwert, fehler bei DB-Abfrage
      // FrageInFragebogen löschen
      $queryFr = "DELETE FROM " . FR_IN_FB . " WHERE " . FR_IN_FB_FBID . " = $id;";
      $queryFb = "DELETE FROM " . FRAGEBOGEN . " WHERE " . FRAGEBOGEN_FbID . " = $id;";
      if(mysqli_query($conn,$queryFr) && mysqli_query($conn,$queryFb)) {
        echo "Fragebogen erfolgreich gelöscht.";
      } else {
        echo "Fehler beim Löschen des Fragebogens.";
        // TODO: Wiederherstellung?
      }
    } else {
      echo "Ungültige Auswahl.";
    }
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

  function enableSurvey($survey, $class) {
    $conn = getDBConnection();
    $class = getClassIdFromCbString($class);
    $class = mysqli_real_escape_string($conn,$class);
    $surveyID = getSurveyID($survey);

    $query = "INSERT INTO " . FBFREIGABE . " VALUES('$class',$surveyID);";
    if(mysqli_query($conn,$query)) {
      echo "Fragebogen '$survey' erfolgreich für Kurs '$class' freigegeben!";
    } else {
      echo "Die Freigabe des Fragebogens '$survey' besteht bereits für Kurs '$class'.";
    }
    mysqli_close($conn);
  }

  // Rückgabe aller freigegebenen Fragebögen
  // Format: Kurs - Fragebogen
  function getEnabledSurveys() {
    $conn = getDBConnection();

    $surveys = array();

    $query = "SELECT " . FBFREIGABE_KUID . ", " . FRAGEBOGEN_FbBezeichnung . " FROM " . FBFREIGABE . " FF, " . FRAGEBOGEN . " FB WHERE FB.".FRAGEBOGEN_FbID . " = FF." . FBFREIGABE_FBID;
    $result = mysqli_query($conn,$query);
    while($entry = mysqli_fetch_assoc($result))
    {
      $surveys[] = $entry[FBFREIGABE_KUID] . " - " . $entry[FRAGEBOGEN_FbBezeichnung];
    }

    mysqli_close($conn);
    return $surveys;
  }

  function getSurveyChapterID($survey) {
    $conn = getDBConnection();
    $chapterID = -1;
    $survey = mysqli_real_escape_string($conn,$survey);

    $query = "SELECT " . FRAGEBOGEN_Kapitel . " FROM " . FRAGEBOGEN . " WHERE " . FRAGEBOGEN_FbBezeichnung . " = '$survey';";

    $result = mysqli_query($conn,$query);
    if ($result) {
      $row = mysqli_fetch_assoc($result);
      $chapterID = $row[FRAGEBOGEN_Kapitel];
    }

    mysqli_close($conn);
    return $chapterID;
  }

  function getSurveyQuestions($survey) {
    $conn = getDBConnection();
    $questions = array();
    $surveyID = getSurveyID($survey);

    $query = "SELECT " . FR_IN_FB_FRBEZ . " FROM " . FR_IN_FB . " WHERE " . FR_IN_FB_FBID . " = '$surveyID';";
    $result = mysqli_query($conn,$query);
    while($entry = mysqli_fetch_assoc($result))
    {
      $questions[] = $entry[FR_IN_FB_FRBEZ];
    }
    mysqli_close($conn);
    return $questions;
  }


  // Anzahl aller Studenten eines Kurses, die einen Fragebogen abgegeben haben
  function getSubmittedStudents($surveyID, $classID) {
    $conn = getDBConnection();

    $surveyID = mysqli_real_escape_string($conn,$surveyID);
    $classID = mysqli_real_escape_string($conn,$classID);

    $query = "SELECT count(*) as count".
                  " FROM " . STUDENT . " stud, " . FBABGABE . " abgb".
                  " WHERE stud." . STUDENT_BENUTZERNAME . " = abgb." . FBABGABE_STUD .
                  " AND stud." . STUDENT_KUID . " = '" . $classID . "'" .
                  " AND abgb." . FBABGABE_FBID . " = " . $surveyID;

    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    if(!$result) {
      mysqli_close($conn);
      return null;
    } else {
      mysqli_close($conn);
      return $result['count'];
    }
  }

  // Anzahl aller Studenten eines Kurses
  function getTotalStudents($surveyID, $classID) {
    $conn = getDBConnection();

    $surveyID = mysqli_real_escape_string($conn,$surveyID);
    $classID = mysqli_real_escape_string($conn,$classID);

    $query = "SELECT count(*) as count".
                  " FROM " . STUDENT . " stud ".
                  " WHERE stud." . STUDENT_KUID . " = '" . $classID . "';";

    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    if(!$result) {
      mysqli_close($conn);
      return null;
    } else {
      mysqli_close($conn);
      return $result['count'];
    }
  }

  // Rückgabe der Anzahl von Beantwortungen
  // Nur Fragen beachtet, die bereits abgegeben wurden!
  function GetAmountOfVotes($questionName, $surveyName) {
    $conn = getDBConnection();
    $surveyID = mysqli_real_escape_string($conn,$surveyName);
    $surveyID = getSurveyID($surveyID);

    $votes = array();

    $question = new question($questionName);
    $qid = $question->GetID();
    $answers = $question->GetQuestionAnswers();

    /*
    $query = "SELECT SUM(CASE WHEN " . BEANTWORTET_AWTEXT . " > 0 THEN 1 ELSE 0 END) as sum, " . BEANTWORTET_AWID .
                  " FROM " . BEANTWORTET . " be, " . FBABGABE . " ab" .
                  " WHERE be." . BEANTWORTET_FBID . " = $surveyID " .
                  " AND ab." . FBABGABE_FBID . " = $surveyID" .
                  " AND be." . BEANTWORTET_FRID . " = $qid GROUP BY be." . BEANTWORTET_AWID .
                  *
                  " AND EXISTS (SELECT *"
                                  " FROM " . FBABGABE .
                                  " WHERE " . FBABGABE_FBID . " = $surveyID)"
                  *
                  " AND be." . BEANTWORTET_STUD . " = ab." . FBABGABE_STUD .
                  " ORDER BY be." . BEANTWORTET_AWID . ";";
*/
      $query = "SELECT SUM(CASE WHEN " . BEANTWORTET_AWTEXT . " > 0 THEN 1 ELSE 0 END) as sum, " . BEANTWORTET_AWID .
                " FROM " . BEANTWORTET . " be INNER JOIN " . FBABGABE . " ab ON be. " . BEANTWORTET_STUD . " = ab." . FBABGABE_STUD . " AND be.".BEANTWORTET_FBID." = ab." . FBABGABE_FBID .
                " WHERE be." . BEANTWORTET_FBID . " = $surveyID " .
                " AND ab." . FBABGABE_FBID . " = $surveyID" .
                " AND be." . BEANTWORTET_FRID . " = $qid GROUP BY be." . BEANTWORTET_AWID;

    $rows = mysqli_query($conn,$query);

    while($entry = mysqli_fetch_assoc($rows)) {
      $votes[] = $entry['sum'];
    }

    return $votes;
  }
?>
