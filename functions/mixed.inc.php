<?php

function getAllClasses($deletable = false) {
  $conn = getDBConnection();
  // Muster der Zeichenketten: KuID - KuBezeichnung
  $query = "SELECT " . KURS_KUID . " , " . KURS_KUBEZEICHNUNG . " FROM " . KURS . ";";

  if($deletable) {
    $query = "SELECT " . KURS_KUID . " , " . KURS_KUBEZEICHNUNG . " FROM " . KURS . " WHERE " . KURS_KUID . " NOT IN (SELECT DISTINCT " . STUDENT_KUID . " FROM " . STUDENT . ");";
  }

  $rows = mysqli_query($conn, $query);
  $classes = array();
  while($entry = mysqli_fetch_assoc($rows))
  {
    $classes[] = $entry[KURS_KUID] . " - " . $entry[KURS_KUBEZEICHNUNG];
  }
  mysqli_close($conn);
  return $classes;
}

// Array aller freigegebenen Kurse
function getAllRegEnabledClasses($enabled = SHORT_TRUE) {
  $conn = getDBConnection();
  // Muster der Zeichenketten: KuID - KuBezeichnung
  $query = "SELECT " . KURS_KUID . " , " . KURS_KUBEZEICHNUNG . " FROM " . KURS . " WHERE " . KURS_KUFREIGESCHALTET . " = " . $enabled . ";";
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

// Rückgabe der Kurs ID anhand der Combobox-Schreibweise
function getClassIdFromCbString($cbString) {
  return explode(" - ", $cbString)[0];
}

function logout() {
    session_start();
    session_destroy();
    header('Location: ../index.php');
  }

?>
