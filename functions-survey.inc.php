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
?>
