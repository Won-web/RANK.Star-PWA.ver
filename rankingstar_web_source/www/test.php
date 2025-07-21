<?php
	// _common.php,common.php 를 인클루드한다(정확한 경로 입력)
	include_once('./shopping/_common.php');
	include_once('./shopping/common.php');
	
	//무료충전소 포인트지급 및 어플db insert
	//설명 : insert_point(회원아이디(int),적립포인트(int),'무료충전포인트 지급','','','','','무료충전소 적립','free');
	insert_point(103, 300, "광고리워드",'','','','','광고리워드','free');

	echo "포인트 지급성공";
?>