<?php
session_start();

function getDBConnection() {
  return(mysqli_connect("localhost","root","password","veva"));
}

function logout() {
  session_start();
  session_destroy();
  header('Location: index.html');
}

// includes
include "functions-login.inc.php";
include "functions-class.inc.php";
include "functions-survey.inc.php";
include "functions-info.inc.php";

include "survey.php";

require_once("../constants.inc.php");

?>