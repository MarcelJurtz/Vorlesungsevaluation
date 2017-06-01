<?php
// Funktionen zur Verwaltung von Kapiteln

// Rückgabe der eindeutigen KapitelID
function getChapterId($lectureDescription, $chapterDescription) {
 $conn = getDBConnection();

 $query = "SELECT " . KAPITEL_KAID
        . " FROM " . KAPITEL . " kap INNER JOIN " . VORLESUNG . " vor ON kap." .KAPITEL_VOID . " = vor." . VORLESUNG_VOID
        . " WHERE " . VORLESUNG_VOBEZEICHNUNG . " = '$lectureDescription' AND " . KAPITEL_KABEZEICHNUNG . " = '$chapterDescription';";

  $getID = mysqli_fetch_assoc(mysqli_query($conn, $query));

  mysqli_close($conn);

  return $getID[KAPITEL_KAID];
}

// Gibt alle Kapitel einer Vorlesung zurück
// Zur Verwendung in ComboBoxen
// Muster: <option>Bezeichnung</option>
function getAllChaptersOfLecture($lectureDescription) {
  $conn = getDBConnection();

  $lectureDescription = mysqli_real_escape_string($conn,$lectureDescription);

  $query = "SELECT " . KAPITEL_KABEZEICHNUNG . " FROM " . KAPITEL . " kap INNER JOIN " . VORLESUNG . " vor ON kap." .KAPITEL_VOID . " = vor." . VORLESUNG_VOID . " WHERE " . VORLESUNG_VOBEZEICHNUNG . " = '$lectureDescription';";
  $rows = mysqli_query($conn, $query);
  $returnString = '';
  while($entry = mysqli_fetch_assoc($rows))
  {
    $returnString .= "<option>" . $entry[KAPITEL_KABEZEICHNUNG] . "</option>";
  }
  mysqli_close($conn);
  return $returnString;
}

// Vorlesungskapitel hinzufügen
function addLectureChapter($lectureDescription, $chapterDescription) {
  $conn = getDBConnection();

  $lectureDescription = mysqli_real_escape_string($conn,$lectureDescription);
  $chapterDescription = mysqli_real_escape_string($conn,$chapterDescription);

  $query = "SELECT " . VORLESUNG_VOID . " FROM " . VORLESUNG . " WHERE " . VORLESUNG_VOBEZEICHNUNG . " = '$lectureDescription';";

  $getID = mysqli_fetch_assoc(mysqli_query($conn, $query));
  $VoID = $getID[VORLESUNG_VOID];

  // Check, ob Kapitel bereits existiert
  $chapterExisting = false;
  $query = "SELECT * FROM " . KAPITEL . " WHERE " . KAPITEL_KABEZEICHNUNG . " = '$chapterDescription' AND " . KAPITEL_VOID . " = $VoID;";
  $results = mysqli_query($conn, $query);
  if($results) {
    if($results->num_rows !== 0) {
      echo "Ein Kapitel mit der Bezeichnung '$chapterDescription' existiert bereits in der Vorlesung '$lectureDescription'!";
      $chapterExisting = true;
    }
  }
  if(!$chapterExisting) {

    $query = "INSERT INTO " . KAPITEL . "(" . KAPITEL_KABEZEICHNUNG . ", " . KAPITEL_VOID . ") VALUES ('$chapterDescription', $VoID);";
    if(mysqli_query($conn,$query)) {
      // Fragepool für neues Kapitel anlegen
      //$query = "SELECT " . KAPITEL_KAID . " FROM " . KAPITEL . " WHERE " . KAPITEL_KABEZEICHNUNG . " = '$chapterDescription';";
      $query = "SELECT MAX(" . KAPITEL_KAID . ") as MAX_KAP FROM " . KAPITEL . ";";

      $getID = mysqli_fetch_assoc(mysqli_query($conn, $query));
      // PK von Kapitel in DB als AUTO_INCREMENT angelegt
      $KaID = $getID['MAX_KAP'];

      // Fragepool einfügen
      // Null erforderlich für AUTO_INCREMENT Primary Key
      $query = "INSERT INTO " . FRAGEPOOL . " VALUES (NULL, $KaID);";

      if(mysqli_query($conn,$query)) {
        echo "Kapitel '$chapterDescription' erfolgreich zur Vorlesung '$lectureDescription' hinzugefügt!";
      } else {
        // Kapitel löschen wenn Fragepool nicht erstellt wurde
        $query = "DELETE FROM " . KAPITEL . " WHERE " . KAPITEL_VOID . " =  $VoID AND " . KAPITEL_KAID . " = $KaID;";
        if(mysqli_query($conn, $query)) {
          echo "Fehler beim Erstellen des Fragepools,das Kapitel wurde gelöscht.";
        } else {
          echo "Fehler beim Erstellen des Fragepools, das Kapitel konnte nicht gelöscht werden.";
        }
      }
    } else {
      echo "Fehler beim hinzufügen des Kapitels '$chapterDescription' zur Vorlesung '$lectureDescription'!";
    }
  }
  mysqli_close($conn);
}


?>
