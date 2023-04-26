<?php
session_start();
if (isset($_SESSION["userid"]))
	$userid = $_SESSION["userid"];
else
	$userid = "";

if (isset($_SESSION["username"]))
	$username = $_SESSION["username"];
else
	$username = "";

$cat = $_POST["cat"];
$content = $_POST["content"];

if (!$userid) {
	echo("
	   <script>
	     window.alert('로그인 후 이용하세요.')
	     history.go(-1)
	   </script>
		");
	exit;
}
if (!$cat) {
	echo("
	   <script>
	     window.alert('카테고리를 선택하세요.')
	     history.go(-1)
	   </script>
		");
	exit;
}
if (!$content) {
	echo("
	   <script>
	     window.alert('내용을 입력하세요.')
	     history.go(-1)
	   </script>
		");
	exit;
}

$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

include "../include/db_connect.php";       // dconn.php 파일을 불러옴

$sql = "insert into blog (id, nick_name, cat, content, regist_day) ";
$sql .= "values('$userid', '$username', '$cat', '$content', '$regist_day')";

//echo $sql;
//exit;

mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행

mysqli_close($con);                // DB 연결 끊기

echo "
	   <script>
	    location.href = 'index.php?cat=$cat';
	   </script>
	";
?>

  
