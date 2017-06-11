<?php
  function duplicateUserToast() {
    echo "<script>
      var toastContainer = document.getElementById('toast');
      toastContainer.className = 'show';
      toastContainer.innerHTML = 'Benutzername bereits vergeben';
      setTimeout(function(){ toastContainer.className = toastContainer.className.replace('show', ''); }, 3000);
    </script>";
  }

  function illegalCourseToast() {
    echo "<script>
      var toastContainer = document.getElementById('toast');
      toastContainer.className = 'show';
      toastContainer.innerHTML = 'Ungültiger Kurs';
      setTimeout(function(){ toastContainer.className = toastContainer.className.replace('show', ''); }, 3000);
    </script>";
  }

  function unknownUserToast() {
    echo "<script>
      var toastContainer = document.getElementById('toast');
      toastContainer.className = 'show';
      toastContainer.innerHTML = 'Ungültiger Benutzername';
      setTimeout(function(){ toastContainer.className = toastContainer.className.replace('show', ''); }, 3000);
    </script>";
  }
?>
