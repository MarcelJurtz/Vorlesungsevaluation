<?php
// Enthält Funktionen zur Verwaltung von Studenten

// Student registrieren
function registerStudent($username, $class) {
  include_once("constants.inc.php");
  $conn = getDBConnection();

  $username = mysqli_real_escape_string($conn,$username);
  $class = mysqli_real_escape_string($conn,$class);

  $query = "INSERT INTO " . STUDENT . " VALUES ('" . $username . "','" . $class . "');";

  if(mysqli_query($conn,$query)) {
    echo "Benutzername '$username' erfolgreich registriert!";
  } else {
    echo "Der Benutzername '$username' ist bereits vergeben!";
  }

  mysqli_close($conn);
}
?>
