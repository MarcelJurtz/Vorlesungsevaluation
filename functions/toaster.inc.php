<?php
  function makeToast($text) {
    echo "<script>
      var toastContainer = document.getElementById('toast');
      toastContainer.className = 'show';
      toastContainer.innerHTML = '" . $text . "';
      setTimeout(function(){ toastContainer.className = toastContainer.className.replace('show', ''); }, 3000);
    </script>";
  }
?>
