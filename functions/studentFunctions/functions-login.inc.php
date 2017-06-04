<?php
function registerStudent($username, $class) {
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

function ValidateUsername($username) {
  $conn = getDBConnection();

  $username = mysqli_real_escape_string($conn,$username);

  if($username == '' || $username == null) {
    return false;
  }

  $queryRes = mysqli_query($conn, "SELECT * FROM " .STUDENT . " WHERE " . STUDENT_BENUTZERNAME . "='$username'");
  $amount = mysqli_num_rows($queryRes);
  mysqli_close($conn);
  return $amount > 0;
}

function SetSessionUsername($username) {
  $_SESSION['username'] = $username;
}

function GetSessionUsername() {
  return $_SESSION['username'];
}

// Ausgabe: Fragebögen für Kurs WI214
function printClassTitle() {
  echo "<h1> Fragebögen für Kurs " . GetClassFromStudent(GetSessionUsername()) . "</h1>";
}


// Part 1 der Menüleiste
function printSidebarMenuBegin() {
  echo'<div id="cWrapper">';
  echo'		<div id="cMenu">';
  echo'			<ul id="lMenu">';
  echo'				<li><a href="student.php">Übersicht</a></li>';
  echo'				<li><a href="survey_main.php">Fragebogen beantworten</a></li>';
  echo'			</ul>';
  echo'		</div>';
  echo'		<div id="cFrame">';
}

// Part 2 der Menüleiste
function printSidebarMenuEnd() {
  echo'		</div>';
}
?>
