<?php
	// _common.php,common.php 를 인클루드한다(정확한 경로 입력)
	include_once('./shopping/_common.php');
	include_once('./shopping/common.php');

/*
 파라메터    	상세 내용 
 seq_id	 포인트 지급에 대한 고유한 ID 값이다. URL이 반복적으로 호출되더라도 이 값을 사용하여 중복지급여부를 확인할 수 있다.
 pay_pnt	 사용자에게 지급되어야 할 포인트 값이다. 
 md_user_nm	 게시앱에서 사용자 식별을 하기 위하여 전달되는 값이다. 이 값을 받기 위해서는 매체앱내에서 setUserName() API를 사용하여 사용자 식별 값을 설정하여야 한다. 
 md_chk	 전달된 값이 유효한지 여부를 판단하기 위하여 제공된다. 이 값은 app_key + md_user_nm + seq_id 의 MD5 Hash 값이다. app_key 값은 앱 등록시 부여된 값으로 Tnk 사이트에서 확인할 수 있다.
 app_id	 사용자가 참여한 광고앱의 고유 ID 값이다. 
 pay_dt	 포인트 지급시각이다. (System milliseconds)  예) 1577343412017
 app_nm	 참여한 광고명 이다.
*/

// 해당 사용자에게 지급되는 포인트
$payPoint =  $_REQUEST["pay_pnt"];

// tnk 내부에서 생성한 고유 번호로 이 거래에 대한 Id이다.
$seqId =  $_REQUEST["seq_id"];

// 전달된 파라메터가 유효한지 여부를 판단하기 위하여 사용한다. (아래 코딩 참고)
$checkCode =  $_REQUEST["md_chk"];

// 게시앱에서 사용자 구분을 위하여 사용하는 값(전화번호나 로그인 ID 등)을 앱에서 TnkSession.setUserName()으로 설정한 후 받도록한다.
$mdUserName =  $_REQUEST["md_user_nm"];


// 앱 등록시 부여된 app_key (tnk 사이트에서 확인가능)
$appKey =  "0f3eb56e16de9c76631850cf04e2d112";


// 	 사용자가 참여한 광고앱의 고유 ID 값이다. 
$appId =  $_REQUEST["app_id"];

// 유효성을 검증하기 위하여 아래와 같이 verifyCode를 생성한다. DigestUtils는 Apache의 commons-codec.jar 이 필요하다. 다른 md5 해시함수가 있다면 그것을 사용해도 무방하다.
// DigestUtils.md5Hex(appKey + mdUserName + seqId);
$verifyCode =  md5($appKey.$mdUserName.$seqId);


// 생성한 verifyCode와 chk_cd 파라메터 값이 일치하지 않으면 잘못된 요청이다.
// 

if(!isset($checkCode) || $checkCode != $verifyCode) {

	echo "checkCode : ".$checkCode."<br>"."verifyCode : ".$verifyCode."<br>실패<br>" ;

	echo ($appKey. " + " .$mdUserName. " + " .$seqId);

}else{

	insert_callback_point($mdUserName, $payPoint, '광고리워드','','','','','광고리워드','free','');
	echo "200" ;

}

?>
