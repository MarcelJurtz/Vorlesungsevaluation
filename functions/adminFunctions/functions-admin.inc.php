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
        echo '<p>Mindestens eine der Eingaben fehlt. Bitte überpüfen Sie diese.</p>';
  } else if($newPassword != $newPasswordConfirmed) {
        echo '<p>Die Passwörter stimmen nicht überein.</p>';
  } else {

    $query = "SELECT " . ADMINISTRATOR_AKennwort . " FROM " . ADMINISTRATOR . " WHERE " . ADMINISTRATOR_AName . " = '" . ADMIN_DEFAULT_USERNAME . "';";
    $getAdminPW = mysqli_fetch_assoc(mysqli_query($conn,$query));
    $adminPW = $getAdminPW[ADMINISTRATOR_AKennwort];

    if($adminPW == $oldPassword) {
      $query = "UPDATE " . ADMINISTRATOR . " SET " . ADMINISTRATOR_AKennwort . " = '$newPassword' WHERE " . ADMINISTRATOR_AName . " = '" . ADMIN_DEFAULT_USERNAME . "';";

      if(mysqli_query($conn,$query)) {
        echo '<p>Änderung erfolgreich durchgeführt.</p>';
      } else {
        echo '<p>Fehler beim Speichern der neuen Anmeldedaten.</p>';
      }
    } else {
      echo '<p>Falsches Passwort.</p>';
    }

    mysqli_close($conn);
  }
}
?>
