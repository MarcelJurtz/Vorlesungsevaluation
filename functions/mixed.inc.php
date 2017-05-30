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