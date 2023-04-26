<?php
   include "../include/db_connect.php";

   $num = $_GET["num"];

   $sql = "delete from blog where num = $num";
   mysqli_query($con, $sql);

   mysqli_close($con);

   echo "
	   <script>
	    location.href = 'index.php';
	   </script>
	";
?>

