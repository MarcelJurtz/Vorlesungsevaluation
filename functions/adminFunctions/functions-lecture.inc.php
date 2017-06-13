<?php
// Funktionen zur Verwaltung von Vorlesungen


function getAllLectures($deletable = false) {
  $conn = getDBConnection();
  // Muster der Zeichenketten: KuID - KuBezeichnung
  $query = "SELECT " . VORLESUNG_VOBEZEICHNUNG . " FROM " . VORLESUNG . ";";

  if($deletable) {
    $query = "SELECT " . VORLESUNG_VOBEZEICHNUNG .
                " FROM " . VORLESUNG .
                " WHERE " . VORLESUNG_VOBEZEICHNUNG ." NOT IN (
                  SELECT DISTINCT vo." . VORLESUNG_VOBEZEICHNUNG .
                  " FROM " . VORLESUNG ." vo
                  INNER JOIN " . KAPITEL . " ka ON vo." . VORLESUNG_VOID . " = ka." . KAPITEL_VOID .
                  " INNER JOIN " . FRAGEBOGEN . " fb ON ka." . KAPITEL_KAID . " = fb." . FRAGEBOGEN_Kapitel .
                  " INNER JOIN " . BEANTWORTET . " be ON fb." . FRAGEBOGEN_FbID . " = be." . BEANTWORTET_FBID .
                ");";
  }

  $rows = mysqli_query($conn, $query);
  $lectures = array();
  while($entry = mysqli_fetch_assoc($rows))
  {
    $lectures[] = $entry[VORLESUNG_VOBEZEICHNUNG];
  }
  mysqli_close($conn);
  return $lectures;
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
      echo "<p>Eine Vorlesung mit der Bezeichnung '$description' existiert bereits!</p>";
      $lectureExisting = true;
    }
  }
  if(!$lectureExisting) {
    $query = "INSERT INTO " . VORLESUNG . "(" . VORLESUNG_VOBEZEICHNUNG . ") VALUES ('$description');";

    if(mysqli_query($conn,$query)) {
      echo "<p>Vorlesung '$description' erfolgreich angelegt!</p>";
    } else {
      echo "<p>Eine Vorlesung mit der Bezeichnung $description existiert bereits!</p>";
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
    echo "<p>Vorlesungsbezeichnung erfolgreich von '$lectureDescriptionOld' zu '$lectureDescriptionNew' geändert!</p>";
  } else {
    echo "<p>Fehler beim Ändern der Vorlesungsbezeichnung on '$lectureDescriptionOld' zu '$lectureDescriptionNew'!</p>";
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
    echo "<p>Vorlesung $lectureDescription erfolgreich gelöscht!</p>";
  } else {
    echo "<p>Fehler beim Löschen der Vorlesung '$lectureDescription.'</p>";
  }

  // TODO: Zusammenhängede Datenbankeinträge (Fragebögen) löschen?
  mysqli_close($conn);
}


?>
