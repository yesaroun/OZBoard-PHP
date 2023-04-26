<?php   
   $num = $_POST["num"];
   $id = $_POST["id"];
   $nick_name = $_POST["nick_name"];
   $content = $_POST["content"];

   if(!$content) {
     echo("
	   <script>
	     window.alert('덧글 내용을 입력하세요.')
	     history.go(-1)
	   </script>
	 ");
	 exit;
   }
   
   include "../include/db_connect.php";       // dconn.php 파일을 불러옴

   $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

   // 레코드 삽입 명령
   $sql = "insert into blog_ripple (parent, id, nick_name, content, regist_day) ";
   $sql .= "values($num, '$id', '$nick_name', '$content', '$regist_day')";    
   
   mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행

   mysqli_close($con);                // DB 연결 끊기
   
   echo "
	   <script>
	    location.href = 'index.php';
	   </script>
	";
?>

   
