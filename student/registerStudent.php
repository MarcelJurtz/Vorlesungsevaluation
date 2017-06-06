<?php

include "studFunctions.inc.php";

if(!isset($_POST['cmdRegisterStudent']) && !isset($_POST['cmdStUserLogin'])) {
  echo "<script>console.log('Kein BUtton gesetzt registerStudent.php')</script>";
  header("Location: ./index.html");
} elseif(isset($_POST['cmdRegisterStudent'])) {
  // Student registrieren
  $enabledClasses = getAllRegEnabledClasses();

  for($i = 0; $i < count($enabledClasses); $i++) {
    if(getClassIdFromCbString($enabledClasses[$i]) == $_POST['txtStudentClass']) {
      registerStudent($_POST['txtStudentUsername'], $_POST['txtStudentClass']);
      break;
    }
    // TODO: Loop verhindern
    echo "<p>Es wurde kein Kurs mit dem Kürzel '" . $_POST['txtStudentClass'] . "' gefunden!</p>";
  }
} elseif(isset($_POST['cmdStUserLogin'])) {
  echo "<p>Validiere User " . $_POST['txtStUserLogin'] ."</p>";
  if(ValidateUsername($_POST['txtStUserLogin'])) {
    SetSessionUsername($_POST['txtStUserLogin']);
    header("Location: ./student.php");
  }
    // TODO: Fehlermeldung
}




echo '</br/><br /><a href="index.html">Zurück</a>'

?>
