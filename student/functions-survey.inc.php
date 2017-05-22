<?php
  function GetClassSurveys($class) {
    $conn = getDBConnection();
    $class = mysqli_real_escape_string($conn,$class);

    $surveys = array();
    $query = "SELECT " . FRAGEBOGEN_FbBezeichnung . " FROM " . FRAGEBOGEN . " fb, " . FBFREIGABE . " ff WHERE fb.".FRAGEBOGEN_FbID . " = ff.".FBFREIGABE_FBID . " AND ff." . FBFREIGABE_KUID . " = '$class'";

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

  function GetCompletedSurveys($student) {
  // TODO: prüfen
    $conn = getDBConnection();
    $student = mysqli_real_escape_string($conn,$student);

    $surveys = array();
    $query = "SELECT " . FRAGEBOGEN_FbBezeichnung
                  . " FROM " . FRAGEBOGEN . " fb, " . FBAGBABE . " fa"
                  . " WHERE fb.".FRAGEBOGEN_FbID . " = fa." . FBAGBABE_FBID
                  . " AND fa." . FBABGABE_STUD . " = '$student'";

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
?>
