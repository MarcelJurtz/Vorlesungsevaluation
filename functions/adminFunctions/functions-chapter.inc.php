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
  echo "Call to deprecated function'getAllChaptersOfLecture' - Replaced by: getAllChapersOfLectureArray";
}


function getAllChaptersOfLectureArray($lectureDescription) {
  $conn = getDBConnection();

  $lectureDescription = mysqli_real_escape_string($conn,$lectureDescription);

  $query = "SELECT " . KAPITEL_KABEZEICHNUNG . " FROM " . KAPITEL . " kap INNER JOIN " . VORLESUNG . " vor ON kap." .KAPITEL_VOID . " = vor." . VORLESUNG_VOID . " WHERE " . VORLESUNG_VOBEZEICHNUNG . " = '$lectureDescription';";
  $rows = mysqli_query($conn, $query);
  $chapters = array();
  while($entry = mysqli_fetch_assoc($rows))
  {
	$chapters[] = $entry[KAPITEL_KABEZEICHNUNG];
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
      echo "<p>Ein Kapitel mit der Bezeichnung '$chapterDescription' existiert bereits in der Vorlesung '$lectureDescription'!</p>";
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
        echo "<p>Kapitel '$chapterDescription' erfolgreich zur Vorlesung '$lectureDescription' hinzugefügt!</p>";
      } else {
        // Kapitel löschen wenn Fragepool nicht erstellt wurde
        $query = "DELETE FROM " . KAPITEL . " WHERE " . KAPITEL_VOID . " =  $VoID AND " . KAPITEL_KAID . " = $KaID;";
        if(mysqli_query($conn, $query)) {
          echo "<p>Fehler beim Erstellen des Fragepools,das Kapitel wurde gelöscht.</p>";
        } else {
          echo "<p>Fehler beim Erstellen des Fragepools, das Kapitel konnte nicht gelöscht werden.</p>";
        }
      }
    } else {
      echo "<p>Fehler beim hinzufügen des Kapitels '$chapterDescription' zur Vorlesung '$lectureDescription'!</p>";
    }
  }
  mysqli_close($conn);
}


?>
