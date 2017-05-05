<?php
// Funktionen zur Verwaltung von Kursen

// Kurs zur Registrierung freigeben
function toggleClassRegistration($classID, $regStatus) {
  include_once("constants.inc.php");
  $conn = getDBConnection();

  $classID = mysqli_real_escape_string($conn,$classID);
  $query = "UPDATE " . KURS . " SET " . KURS_KUFREIGESCHALTET . " = $regStatus WHERE " . KURS_KUID . " = '$classID';";

  $feedbackTextSuccess = "Kurs '$classID' erfolgreich zur Registrierung freigegeben!";
  $feedbackTextError = "Fehler bei der Freigabe des Kurses '$classID'!";

  if($regStatus == REGFREIGABE_FALSE) {
    $feedbackTextSuccess = "Freigabe des Kurses '$classID' erfolgreich widerrufen!";
    $feedbackTextError = "Fehler beim Widerrufen der Freigabe von Kurs '$classID'!";
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
  include_once("constants.inc.php");
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
      echo '<p>Ein Kurs mit diesem Kürzel existiert bereits: <br />
        Kürzel: ' . $kShort . ',<br />
        Beschreibung: ' . $kDescription . '</p>';
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
  include_once("constants.inc.php");
  $conn = getDBConnection();
  $query = "DELETE FROM " . KURS . " WHERE " . KURS_KUID . " = '$classID';";
  if (mysqli_query($conn, $query)) {
    echo "Kurs $classID erfolgreich gelöscht!";
  } else {
    echo "Fehler beim Löschen des Kurses $classID";
  }

  // TODO: Zusammenhängede Datenbankeinträge (Fragebögen) löschen?
  mysqli_close($conn);
}

// Rückgabe der Kurs ID anhand der Combobox-Schreibweise
function getClassIdFromCbString($cbString) {
  return explode(" - ", $cbString)[0];
}

// Array aller freigegebenen Kurse
function getAllRegEnabledClasses() {
  include_once("constants.inc.php");
  $cString = getAllClasses(true,REGFREIGABE_TRUE);
  //echo '<script>console.log("' . $cString . '")</script>';
  //echo $cString;
  $cString = str_replace("<option>" , "" , $cString);
  echo '<script>console.log("' . $cString . '")</script>';
  // TODO: Sauberere Lösung, Abschneiden des letzten <options>
  //$arr = explode("</option>",substr($cString,strlen($cString) - strlen("</option>")));
  $arr = explode("</option>",$cString);
  array_pop($arr);
  return $arr;
}

// Liste aller Kurse als <option>-Liste für ComboBoxen
// Parameter zur Angabe, ob nur Kurse angezeigt werden sollen, die nicht freigegeben sind oder nicht
// subsetOnly -> Suche nur eine Teilmenge (Nur die (nicht) freigeschaltenen)
// subsetIndicator  -> Verwendung der Konstanten zur Angabe des Status freigeschaltet / nicht freigeschaltet
function getAllClasses($subsetOnly = false, $subsetIndicator = -1) {
  include_once("constants.inc.php");
  $conn = getDBConnection();
  // Muster der Zeichenketten: KuID - KuBezeichnung
  $query = "SELECT " . KURS_KUID . " , " . KURS_KUBEZEICHNUNG . " FROM " . KURS . ";";
  if($subsetOnly) {
    $query = "SELECT " . KURS_KUID . " , " . KURS_KUBEZEICHNUNG . " FROM " . KURS . " WHERE " . KURS_KUFREIGESCHALTET ." = $subsetIndicator;";
  }
  $rows = mysqli_query($conn, $query);
  $returnString = '';
  while($entry = mysqli_fetch_assoc($rows))
  {
    $returnString .= "<option>" . $entry[KURS_KUID] . " - " . $entry[KURS_KUBEZEICHNUNG] . "</option>";
  }
  mysqli_close($conn);
  return $returnString;
}
?>
