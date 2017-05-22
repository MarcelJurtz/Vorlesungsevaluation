<?php
  function GetClassFromStudent($username) {
    $conn = getDBConnection();
    $username = mysqli_real_escape_string($conn,$username);

    $query = "SELECT " . STUDENT_KUID . " FROM " . STUDENT . " WHERE " . STUDENT_BENUTZERNAME . " = '" . $username . "';";

    $getID = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $classID = $getID[STUDENT_KUID];

    mysqli_close($conn);
    return $classID;
  }
?>
