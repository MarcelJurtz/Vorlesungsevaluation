<?php
function registerStudent($username, $class) {
  $conn = getDBConnection();

  $username = mysqli_real_escape_string($conn,$username);
  $class = mysqli_real_escape_string($conn,$class);

  $query = "INSERT INTO " . STUDENT . " VALUES ('" . $username . "','" . $class . "');";

  if(mysqli_query($conn,$query)) {
    SetSessionUsername($username);
    header("Location: ./student.php");
  } else {
    $_SESSION['toaster'] = TOAST_DUPLICATE_USER;
    header("Location: ./index.php");
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

// Part 1 der Menüleiste
function printSidebarMenuBegin($entry) {
  echo'<div id="cWrapper">';
  echo'		<div id="cMenu">';
  echo'     <h1>&nbsp;</h1>';
  echo'			<ul id="lMenu">';

  if($entry == "overview") {
    echo'				<li><b>Übersicht</b></li>';
    echo'				<li><a href="survey_main.php">Fragebogen beantworten</a></li>';
  } else {
    echo'				<li><a href="student.php">Übersicht</a></li>';
    echo'				<li><b>Fragebogen beantworten</b></li>';
  }
  echo'         <li><a href="../functions/logout.php">Abmelden</a></li>';
  echo'			</ul>';
  echo'		</div>';
  echo'		<div id="cFrame">';
}

// Part 2 der Menüleiste
function printSidebarMenuEnd() {
  echo'		</div>';
}
?>
