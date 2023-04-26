<?php
if (isset($_GET["mode"])) $mode = $_GET["mode"];
else $mode = "";

if (isset($_POST["select"])) $select = $_POST["select"];
else $select = "";

if (isset($_POST["keyword"])) $keyword = $_POST["keyword"];
else $keyword = "";

include "../include/header.php";
?>

<h3 style="margin-top: 20px;"> 회원관리</h3>
<form action="admin.php?mode=search" method="post">
	<select name="select">
		<option value="id">아이디</option>
		<option value="name">이름</option>
	</select>
	<input type="text" name="keyword">
	<button type="submit">찾기</button>
	<br><br>
</form>
<!-- 제목 표시 시작 -->
<table border="1">
	<tr>
		<th>번호</th>
		<th>아이디</th>
		<th>이름</th>
		<th>이메일</th>
		<th>가입일</th>
		<th>레벨</th>
		<th>포인트</th>
		<th>수정</th>
		<th>삭제</th>
	</tr>
	<?php
	include "../include/db_connect.php";

	$sql = "select * from _mem";

	if ($mode == "search") {
		$sql = "select * from _mem where $select='$keyword'";
	}

	$result = mysqli_query($con, $sql);
	$number = 1;
	while ($row = mysqli_fetch_assoc($result)) {
		$num = $row["num"];
		$id = $row["id"];
		$name = $row["name"];
		$email = $row["email"];
		$regist_day = $row["regist_day"];
		$level = $row["level"];
		$point = $row["point"];
		?>
		<form action="admin_modify.php?num=<?= $num ?>" method="post">
			<tr>
				<td class="number"><?= $number ?></td>
				<td class="id"><?= $id ?></td>
				<td class="name"><input type="text" name="name" value="<?= $name ?>"></td>
				<td class="email"><input type="text" name="email" value="<?= $email ?>"></td>
				<td class="regist_day"><?= $regist_day ?></td>
				<td class="level"><input type="text" name="level" value="<?= $level ?>"></td>
				<td class="point"><input type="text" name="point" value="<?= $point ?>"></td>
				<td>
					<button type="submit">수정</button>
				</td>
		</form>
		<td>
			<button onClick="location.href='admin_delete.php?num=<?= $num ?>'">삭제</button>
		</td>
		</tr>

		<?php
		$number++;
	}

	mysqli_close($con);
	?>
</table>

