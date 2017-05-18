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
?>
