<?php

include "studFunctions.inc.php";

if(isset($_POST['cmdRegisterStudent'])) {
  // Student registrieren
  $enabledClasses = getAllRegEnabledClasses();

  $classExists = false;

  for($i = 0; $i < count($enabledClasses); $i++) {
    if(getClassIdFromCbString($enabledClasses[$i]) == $_POST['txtStudentClass']) {
      registerStudent($_POST['txtStudentUsername'], $_POST['txtStudentClass']);
      $classExists = true;
      break;
    }
  }
  if(!$classExists) {
    $_SESSION['toaster'] = TOAST_ILLEGAL_COURSE;
    header("Location: ./index.php");
  }
} elseif(isset($_POST['cmdStUserLogin'])) {
  if(ValidateUsername($_POST['txtStUserLogin'])) {
    SetSessionUsername($_POST['txtStUserLogin']);
    header("Location: ./student.php");
  } else {
    $_SESSION['toaster'] = TOAST_UNKNOWN_USERNAME;
    header("Location: ./index.php");
  }
}

?>
