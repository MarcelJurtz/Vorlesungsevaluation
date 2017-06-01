<?php
// Funktionen zur Verwaltung von Vorlesungen


// Liste aller Vorlesungen als Array
function getAllLectures() {
  $conn = getDBConnection();
  // Muster der Zeichenketten: KuID - KuBezeichnung
  $query = "SELECT " . VORLESUNG_VOBEZEICHNUNG . " FROM " . VORLESUNG . ";";
  $rows = mysqli_query($conn, $query);
  $returnString = '';
  while($entry = mysqli_fetch_assoc($rows))
  {
    $returnString .= "<option>" . $entry[VORLESUNG_VOBEZEICHNUNG] . "</option>";
  }
  mysqli_close($conn);
  return $returnString;
}

// Vorlesung anlegen
// TODO: RENAME TO LECTURE
function createLecture($description) {
  $conn = getDBConnection();
  $description = mysqli_real_escape_string($conn,$description);
  $lectureExisting = false;

  // Check, ob Vorlesung bereits existiert
  $query = "SELECT * FROM " . VORLESUNG . " WHERE " . VORLESUNG_VOBEZEICHNUNG . " = '$description';";
  $results = mysqli_query($conn, $query);
  if($results) {
    if($results->num_rows !== 0) {
      echo "Eine Vorlesung mit der Bezeichnung '$description' existiert bereits!";
      $lectureExisting = true;
    }
  }
  if(!$lectureExisting) {
    $query = "INSERT INTO " . VORLESUNG . "(" . VORLESUNG_VOBEZEICHNUNG . ") VALUES ('$description');";

    if(mysqli_query($conn,$query)) {
      echo "Vorlesung $description erfolgreich angelegt!";
    } else {
      echo "Eine Vorlesung mit der Bezeichnung $description existiert bereits!";
    }
    mysqli_close($conn);
  }
}

// Vorlesung umbenennen
function renameLecture($lectureDescriptionOld, $lectureDescriptionNew) {
  $conn = getDBConnection();
  $lectureDescriptionOld = mysqli_real_escape_string($conn,$lectureDescriptionOld);
  $lectureDescriptionNew = mysqli_real_escape_string($conn,$lectureDescriptionNew);
  $query = "UPDATE ". VORLESUNG . " SET " . VORLESUNG_VOBEZEICHNUNG . " = '$lectureDescriptionNew' WHERE " . VORLESUNG_VOBEZEICHNUNG . " = '$lectureDescriptionOld';";
  if (mysqli_query($conn, $query)) {
    echo "Vorlesungsbezeichnung erfolgreich von '$lectureDescriptionOld' zu '$lectureDescriptionNew' geändert!";
  } else {
    echo "Fehler beim Ändern der Vorlesungsbezeichnung on '$lectureDescriptionOld' zu '$lectureDescriptionNew'!";
  }

  // TODO: Zusammenhängede Datenbankeinträge (Fragebögen) löschen?
  mysqli_close($conn);
}

// Vorlesung anhand des Namens löschen
function deleteLecture($lectureDescription) {
  // TODO: Löschen deaktivieren, wenn bereits beantwortet
  $conn = getDBConnection();
  $lectureDescription = mysqli_real_escape_string($conn,$lectureDescription);
  $query = "DELETE FROM " . VORLESUNG . " WHERE " . VORLESUNG_VOBEZEICHNUNG . " = '$lectureDescription';";
  if (mysqli_query($conn, $query)) {
    echo "Vorlesung $lectureDescription erfolgreich gelöscht!";
  } else {
    echo "Fehler beim Löschen der Vorlesung '$lectureDescription.'";
  }

  // TODO: Zusammenhängede Datenbankeinträge (Fragebögen) löschen?
  mysqli_close($conn);
}


?>
