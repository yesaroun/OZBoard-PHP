<?php
   include "../include/db_connect.php";

   $num = $_GET["num"];

   $sql = "delete from _mem where num = $num";
   mysqli_query($con, $sql);

   mysqli_close($con);

   echo "
	   <script>
	    location.href = 'admin.php';
	   </script>
	";
?>

