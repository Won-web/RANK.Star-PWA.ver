<?php
	// _common.php,common.php 를 인클루드한다(정확한 경로 입력)
	include_once('./shopping/_common.php');
	include_once('./shopping/common.php');
	include_once('./shopping/theme/basic/mobile/shop/shop.head.php');

	$mdUserName = $_REQUEST['uid'];
	$payPoint = 1;
	
	insert_point($mdUserName, $payPoint, '광고리워드test','','','','','광고리워드test','free','');



?>
