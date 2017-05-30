<?php
function logoutAdmin() {
    session_start();
    session_destroy();
    header('Location: index.php');
  }
?>