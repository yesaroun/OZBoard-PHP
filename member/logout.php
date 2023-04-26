<?php
  session_start();
  unset($_SESSION["userid"]);
  unset($_SESSION["username"]);
  unset($_SESSION["userlevel"]);
  
  echo "
       <script>
          location.href = '../home/index.php';
         </script>
       ";
?>