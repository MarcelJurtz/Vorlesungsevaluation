<?php
// Funktionen zur Verwaltung von Kursen

// Kurs zur Registrierung freigeben
function toggleClassRegistration($classID, $regStatus) {
  $conn = getDBConnection();

  $classID = mysqli_real_escape_string($conn,$classID);
  $query = "UPDATE " . KURS . " SET " . KURS_KUFREIGESCHALTET . " = $regStatus WHERE " . KURS_KUID . " = '$classID';";

  $feedbackTextSuccess = "<p>Kurs '$classID' erfolgreich zur Registrierung freigegeben!</p>";
  $feedbackTextError = "<p>Fehler bei der Freigabe des Kurses '$classID'!</p>";

  if($regStatus == REGFREIGABE_FALSE) {
    $feedbackTextSuccess = "<p>Freigabe des Kurses '$classID' erfolgreich widerrufen!</p>";
    $feedbackTextError = "<p>Fehler beim Widerrufen der Freigabe von Kurs '$classID'!</p>";
  }

  if(mysqli_query($conn,$query)) {
    echo $feedbackTextSuccess;
  } else {
    echo $feedbackTextError;
  }
  mysqli_close($conn);
}


// Kurs anlegen
// kDescription: "Wirtschaftsinformatik 2014 / 2"
// kShort: WI214
function createClass($kDescription, $kShort) {
  $dbConn = getDBConnection();

  try {
    $dbConn = getDBConnection();
    $kShort = mysqli_real_escape_string($dbConn,$kShort);
    $kDescription = mysqli_real_escape_string($dbConn,$kDescription);

    // Prüfung auf Existenz des Kurses
    $existsQuery = "SELECT * FROM kurs WHERE KuID='$kShort';";
    $existsResult = mysqli_query($dbConn, $existsQuery);
    if(mysqli_num_rows($existsResult) > 0){
      // Kürzel bereits vergeben
      echo '<p>Ein Kurs mit diesem Kürzel existiert bereits.</p>';
    }else{
      // Einfügen des Kurses
      $insertQuery = "INSERT INTO kurs VALUES('$kShort','$kDescription', 0);";
      $result = mysqli_query($dbConn, $insertQuery);
      if(!$result) {
        echo '<p>Fehler beim Eintrag in die Datenbank: <br />
          Kürzel: ' . $kShort . ',<br />
          Beschreibung: ' . $kDescription . '</p>';
      } else {
        echo '<p>Der Kurs '."'$kDescription'".' wurde erfolgreich angelegt.</p>';
      }
    }
  } catch (Exception $e) {
    echo '<p>Fehler beim Eintrag in die Datenbank: <br />
      Kürzel: ' . $kShort . ',<br />
      Beschreibung: ' . $kDescription . '</p>';
  } finally {
    mysqli_close($dbConn);
  }
echo'<a href="class_create.php">Zurück</a>';
}

// Kurs anhand des Kürzels löschen
function deleteClass($classID) {
  $conn = getDBConnection();
  $query = "DELETE FROM " . KURS . " WHERE " . KURS_KUID . " = '$classID';";
  if (mysqli_query($conn, $query)) {
    echo "<p>Kurs $classID erfolgreich gelöscht!</p>";
  } else {
    echo "<p>Fehler beim Löschen des Kurses $classID.</p>";
  }
  mysqli_close($conn);
}

// Rückgabe aller Kurse, die für eine Vorlesung freigeschaltet sind
function getClassesForSurvey($surveyID) {
  $conn = getDBConnection();

  // Muster der Zeichenketten: KuID - KuBezeichnung
  $query = "SELECT " . KURS_KUID . " , " . KURS_KUBEZEICHNUNG . " FROM " . KURS . " WHERE " . KURS_KUID . " IN ".
    "(SELECT " . KURS_KUID . " FROM " . FBFREIGABE . " WHERE " . FBFREIGABE_FBID . " = $surveyID);";
  $rows = mysqli_query($conn, $query);
  $classes = array();
  while($entry = mysqli_fetch_assoc($rows))
  {
    $classes[] = $entry[KURS_KUID] . " - " . $entry[KURS_KUBEZEICHNUNG];
  }
  mysqli_close($conn);
  return $classes;
}
?>
