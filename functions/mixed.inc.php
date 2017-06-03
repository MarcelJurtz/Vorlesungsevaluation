<?php
 /* CONTAINS FUNCTIONS THAT ARE NEEDED BY ADMIN AND STUDENTS */


// Liste aller Kurse als <option>-Liste für ComboBoxen
// Parameter zur Angabe, ob nur Kurse angezeigt werden sollen, die nicht freigegeben sind oder nicht
// subsetOnly -> Suche nur eine Teilmenge (Nur die (nicht) freigeschaltenen)
// subsetIndicator  -> Verwendung der Konstanten zur Angabe des Status freigeschaltet / nicht freigeschaltet
function getAllClasses($subsetOnly = false, $subsetIndicator = -1) {
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

function getAllClassesArray() {
  $conn = getDBConnection();
  // Muster der Zeichenketten: KuID - KuBezeichnung
  $query = "SELECT " . KURS_KUID . " , " . KURS_KUBEZEICHNUNG . " FROM " . KURS . ";";
  $rows = mysqli_query($conn, $query);
  $classes = array();
  while($entry = mysqli_fetch_assoc($rows))
  {
    $classes[] = $entry[KURS_KUID] . " - " . $entry[KURS_KUBEZEICHNUNG];
  }
  mysqli_close($conn);
  return $classes;
}

// Alle freigegebenen Fragebögen zur Validation der Berechtigung
function GetClassSurveys($class) {
  $conn = getDBConnection();
  $class = mysqli_real_escape_string($conn,$class);

  $surveys = array();

  $query = "SELECT " . FRAGEBOGEN_FbBezeichnung .
            " FROM " . FRAGEBOGEN . " fb, " . FBFREIGABE . " ff".
            " WHERE fb.".FRAGEBOGEN_FbID . " = ff.".FBFREIGABE_FBID .
            " AND ff." . FBFREIGABE_KUID . " = '$class'";

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

 // Array aller freigegebenen Kurse
function getAllRegEnabledClasses() {
  $cString = getAllClasses(true,REGFREIGABE_TRUE);
  $cString = str_replace("<option>" , "" , $cString);
  $arr = explode("</option>",$cString);
  array_pop($arr);
  return $arr;
}

// Rückgabe der Kurs ID anhand der Combobox-Schreibweise
function getClassIdFromCbString($cbString) {
  return explode(" - ", $cbString)[0];
}

?>
