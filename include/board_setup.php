<?php
    $table = $_GET["table"];
    $scale = 4;	// 글 목록보기에서 한 화면에 표시되는 글 수

    switch($table) {
        case "_notice" : $board_title = "공지사항";
                break;
        case "_youtube" : $board_title = "유튜브 동영상";
                break;
        case "_qna": $board_title = "묻고답하기";
                break;                      
    }
?>