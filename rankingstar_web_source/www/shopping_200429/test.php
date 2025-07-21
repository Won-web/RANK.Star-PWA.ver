<?php
	include_once('./_common.php');
	
	//어플에 포인트 넘기기
    $sql_shopping = " insert into tbl_star_purchase
                        set user_id = '{$mb_id}',
	                        star = '{$point}',
	                        description = '쇼핑몰',
	                        type = 'paid',
	                        amount = '1000',
	                        purchase_date = '".G5_TIME_YMD."',
	                        created_date = '".G5_TIME_YMDHIS."',
	                        updated_date = '".G5_TIME_YMDHIS."'
                        
               ";
    sql_query($sql_shopping);
?>