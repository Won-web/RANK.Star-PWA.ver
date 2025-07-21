<?php
include_once('./_common.php');
define("_INDEX_", TRUE);
include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
?>

<?php
	
		$sql = "select * from g5_shop_cp where cp_number = '$cp_number' ";
		$result = sql_fetch($sql);
		
		//등록된 쿠폰과 일치 한다면
		if ($result['cp_number'] && $result['cp_using'] != 1){
			
			$udate = G5_TIME_YMDHIS; //쿠폰 사용 날짜
			
			//1. 해당 쿠폰을 사용 처리 한다
			sql_query("update g5_shop_cp set cp_mb_id = '{$member['mb_id']}' , cp_using = '1', cp_use_date = '{$udate}' where cp_number='{$result['cp_number']}' ");
			
			//2. 그 후 해당회원아이디로 적립한다
			insert_point($member['mb_id'], $result['cp_point'], $result['cp_number'].' - 쿠폰사용', '', '', '','','쿠폰 충전','coupon');
			alert('정상적으로 사용 되었습니다.');
		
		//쿠폰 번호가 일치 하지 않을 때	
		} elseif(!$result['cp_number']){
			alert('유효하지 않은 쿠폰입니다.');
		
		//사용한 쿠폰일 때	
		} else {
			alert('이미 사용한 쿠폰입니다.');
		}
	
?>

<?php
include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
?>