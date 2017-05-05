<?php

include "../functions.inc.php";

if(!isset($_POST['cmdRegisterStudent']) && !isset($_POST['cmdLoginStudent'])) {
  header("Location: ./index.html");
} elseif(isset($_POST['cmdRegisterStudent'])) {
  // Student registrieren
  $enabledClasses = getAllRegEnabledClasses();

  for($i = 0; $i < count($enabledClasses); $i++) {
    if(getClassIdFromCbString($enabledClasses[$i]) == $_POST['txtStudentClass']) {
      registerStudent($_POST['txtStudentUsername'], $_POST['txtStudentClass']);
      break;
    }
    echo "Es wurde kein Kurs mit dem Kürzel '" . $_POST['txtStudentClass'] . "' gefunden!";
  }
} elseif(isset($_POST['cmdLoginStudent'])) {
  // Student anmelden
  // TODO
}




echo '</br/><br /><a href="index.html">Zurück</a>'

?>
