<?php
function changePassword($oldPassword, $newPassword, $newPasswordConfirmed) {
  $conn = getDBConnection();

  //$oldPassword = md5(mysqli_real_escape_string($conn,$oldPassword));
  //$newPassword = md5(mysqli_real_escape_string($conn,$newPassword));
  //$newPasswordConfirmed = md5(mysqli_real_escape_string($conn,$newPasswordConfirmed));

  $oldPassword = hash('sha256', mysqli_real_escape_string($conn,$oldPassword));
  $newPassword = hash('sha256', mysqli_real_escape_string($conn,$newPassword));
  $newPasswordConfirmed = hash('sha256', mysqli_real_escape_string($conn,$newPasswordConfirmed));

  if($oldPassword == NULL || $oldPassword == '' ||
      $newPasswordConfirmed == NULL || $newPasswordConfirmed == '' ||
      $newPassword == NULL || $newPassword == '') {
        echo 'Mindestens eine der Eingaben fehlt. Bitte überpüfen Sie diese.';
  } else if($newPassword != $newPasswordConfirmed) {
        echo 'Die Passwörter stimmen nicht überein.';
  } else {

    $query = "SELECT " . ADMINISTRATOR_AKennwort . " FROM " . ADMINISTRATOR . " WHERE " . ADMINISTRATOR_AName . " = '" . ADMIN_DEFAULT_USERNAME . "';";
    $getAdminPW = mysqli_fetch_assoc(mysqli_query($conn,$query));
    $adminPW = $getAdminPW[ADMINISTRATOR_AKennwort];

    if($adminPW == $oldPassword) {
      $query = "UPDATE " . ADMINISTRATOR . " SET " . ADMINISTRATOR_AKennwort . " = '$newPassword' WHERE " . ADMINISTRATOR_AName . " = '" . ADMIN_DEFAULT_USERNAME . "';";
      echo $query;
      if(mysqli_query($conn,$query)) {
        echo 'Änderung erfolgreich durchgeführt.';
      } else {
        echo 'Fehler beim Speichern der neuen Anmeldedaten.';
      }
    } else {
      echo 'Falsches Passwort.';
    }

    mysqli_close($conn);
  }
}
?>
