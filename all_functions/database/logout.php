<?php
      session_start();
      session_destroy();
      header("Location: ../../../all_functions/login_function/index.php");
?>