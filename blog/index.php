<?php
if (isset($_GET["cat"]))
	$cat = $_GET["cat"];
else
	$cat = "";

$scale = 5;      // 한 화면에 표시되는 글 수
include "../include/db_connect.php";

if ($cat)
	$sql = "select * from blog where cat='$cat' order by num desc";
else
	$sql = "select * from blog order by num desc";

$result = mysqli_query($con, $sql);

$total_record = mysqli_num_rows($result); // 전체 글 수

// 전체 페이지 수($total_page) 계산
if ($total_record % $scale == 0)
	$total_page = floor($total_record / $scale);
else
	$total_page = floor($total_record / $scale) + 1;

if (isset($_GET["page"])) $page = $_GET["page"];
else $page = 1;

// 표시할 페이지($page)에 따라 $start 계산
$start = ($page - 1) * $scale;
$number = $total_record - $start;

include "../include/header.php";
include "../include/blog_setup.php";
?>
<link rel="stylesheet" href="../css/blog.css">
<div class="main">
	<section id="content">
		<ul id="menu">
			<li><a href="index.php">전체글</a></li>
			<li>|</li>
			<li><a href="index.php?cat=food">음식</a></li>
			<li><a href="index.php?cat=computer">컴퓨터</a></li>
			<li><a href="index.php?cat=book">도서</a></li>
			<li><a href="index.php?cat=talk">이모저모</a></li>
			<li><a href="index.php?cat=notice">공지사항</a></li>
		</ul>
		<div id="blog_write">
			<form name="blog_form" method="post" action="insert.php">
				<input type="hidden" name="userid" value="<?= $userid ?>">
				<input type="hidden" name="name" value="<?= $name ?>">
				<div id="cat">
					카테고리 : <select name="cat">
						<option value="">선택</option>
						<option value="food">음식</option>
						<option value="computer">컴퓨터</option>
						<option value="book">도서</option>
						<option value="talk">이모저모</option>
						<option value="notice">공지사항</option>
					</select>
				</div>
				<div class="textarea"><textarea name="content"></textarea></div>
				<div class="button">
					<button type="submit">글쓰기</button>
				</div>
			</form>
		</div>
		<div class="clear"></div>

		<h1 id="blog_title"><?= $blog_title ?></h1>
		<?php
		for ($i = $start; $i < $start + $scale && $i < $total_record; $i++) {
			mysqli_data_seek($result, $i);
			$row = mysqli_fetch_assoc($result);
			$num = $row["num"];
			$id = $row["id"];
			$name = $row["nick_name"];
			$regist_day = $row["regist_day"];
			$content = str_replace("\n", "<br>", $row["content"]);
			$content = str_replace(" ", "&nbsp;", $content);
			?>
			<div id="blog_content">
				<ul id="writer_info">
					<li><?= $number ?></li>
					<li><?= $name ?></li>
					<li><?= $regist_day ?></li>
					<li><a href="delete.php?num=<?= $num ?>">[삭제]</a></li>
				</ul>
				<div><?= $content ?></div>
			</div>
			<div id="ripple">
				<p><b>[덧글보기]</b></p>
				<?php
				$sql = "select * from blog_ripple where parent='$num'";
				$ripple_result = mysqli_query($con, $sql);

				while ($row_ripple = mysqli_fetch_assoc($ripple_result)) {
					$ripple_num = $row_ripple["num"];
					$ripple_id = $row_ripple["id"];
					$ripple_nick = $row_ripple["nick_name"];
					$ripple_content = str_replace("\n", "<br>", $row_ripple["content"]);
					$ripple_content = str_replace(" ", "&nbsp;", $ripple_content);
					$ripple_day = $row_ripple["regist_day"];
					?>
					<div id="ripple_title">
						<ul>
							<li><?= $ripple_nick ?> &nbsp;&nbsp;&nbsp; <?= $ripple_day ?></li>
							<li>
								<?php
								echo "<a href='delete_ripple.php?num=$ripple_num'>덧글 삭제</a>";
								?>
							</li>
						</ul>
					</div>
					<div id="ripple_content"> <?= $ripple_content ?></div>
					<?php
				}
				?>
				<form name="ripple_form" method="post" action="insert_ripple.php">
					<input type="hidden" name="num" value="<?= $num ?>">
					<input type="hidden" name="id" value="<?= $userid ?>">
					<input type="hidden" name="nick_name" value="<?= $username ?>">
					<div id="ripple_insert">
						<div id="ripple_textarea">
							<textarea name="content"></textarea>
						</div>
						<div id="ripple_button">
							<button type="submit">덧글달기</button>
						</div>
					</div>
					<div class="clear"></div>
				</form>

			</div> <!-- end of ripple -->
			<?php
			$number--;
		}
		mysqli_close($con);
		?>

		<div id="page_num">
			<?php
			if ($page > 1) {
				$pre_page = $page - 1;
				echo "<a href='index.php?page=$pre_page'>◀ 이전 &nbsp;&nbsp;&nbsp;&nbsp;</a>";
			}

			// 게시판 목록 하단에 페이지 링크 번호 출력
			for ($i = 1; $i <= $total_page; $i++) {
				if ($page == $i)     // 현재 페이지 번호 링크 안함
				{
					echo " <b> $i </b> ";
				} else {
					echo " <a href='index.php?page=$i'> $i </a> ";
				}
			}
			if ($page < $total_page) {
				$next_page = $page + 1;
				echo "<a href='index.php?page=$next_page'>&nbsp;&nbsp;&nbsp;&nbsp;다음 ▶</a>";
			}
			?>
	</section> <!-- end of content -->
</div>
</body>
</html>
