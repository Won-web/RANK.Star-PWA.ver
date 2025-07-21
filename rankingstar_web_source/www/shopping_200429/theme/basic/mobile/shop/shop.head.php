<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_THEME_PATH.'/mobile/shop/_shop.setup.php');

$mb_id = trim($_GET['uid']);

if ($_GET['uname']){
	$mb_name = trim($_GET['uname']);
} else {
	$mb_name = trim($_GET['uid']);
}

if ($_GET['uphone']){
	$mb_phone = trim($_GET['uphone']);
}
if ($_GET['uemail']){
	$mb_email = trim($_GET['uemail']);
}
if($_GET['uid'] && !$_GET['od_id']){ // od_id는 쇼핑몰 주문 완료시 uid겹쳐서 오류가 나기 때문에 아닐 때만 실행

	
	if($m_res['cnt'] > 0){ //회원 아이디 있다면 바로 로그인 gogo

	$m_sql = "select count(*) as cnt from g5_member where mb_id='{$mb_id}' limit 0,1";
	$m_res = sql_fetch($m_sql);
	
	session_unset(); // 모든 세션변수를 언레지스터 시켜줌
	set_session('ss_mb_id', $mb_id); //세션에 회원아이디 값을 담음
		
		
	} else {
		
		//접근회원 로그아웃 이벤트
		run_event('member_logout', $link);
		
		//넘어온 회원의 아이디가 없다면 회원가입 시킨다
		$sqlvvv = " insert into {$g5['member_table']}
                set mb_id = '{$mb_id}',
                     mb_password = '".get_encrypt_string('test123')."',
                     mb_name = '{$mb_name}',
                     mb_nick = '{$mb_name}',
                     mb_nick_date = '".G5_TIME_YMD."',
                     mb_email = '{$mb_email}',
                     mb_homepage = '{$mb_homepage}',
                     mb_tel = '{$mb_phone}',
                     mb_hp = '{$mb_phone}',
                     mb_zip1 = '{$mb_zip1}',
                     mb_zip2 = '{$mb_zip2}',
                     mb_addr1 = '{$mb_addr1}',
                     mb_addr2 = '{$mb_addr2}',
                     mb_addr3 = '{$mb_addr3}',
                     mb_addr_jibeon = '{$mb_addr_jibeon}',
                     mb_signature = '{$mb_signature}',
                     mb_profile = '{$mb_profile}',
                     mb_today_login = '".G5_TIME_YMDHIS."',
                     mb_datetime = '".G5_TIME_YMDHIS."',
                     mb_ip = '{$_SERVER['REMOTE_ADDR']}',
                     mb_level = '{$config['cf_register_level']}',
                     mb_recommend = '{$mb_recommend}',
                     mb_login_ip = '{$_SERVER['REMOTE_ADDR']}',
                     mb_mailling = '{$mb_mailling}',
                     mb_sms = '{$mb_sms}',
                     mb_open = '{$mb_open}',
                     mb_open_date = '".G5_TIME_YMD."',
                     mb_1 = '{$mb_1}',
                     mb_2 = '{$mb_2}',
                     mb_3 = '{$mb_3}',
                     mb_4 = '{$mb_4}',
                     mb_5 = '{$mb_5}',
                     mb_6 = '{$mb_6}',
                     mb_7 = '{$mb_7}',
                     mb_8 = '{$mb_8}',
                     mb_9 = '{$mb_9}',
                     mb_10 = '{$mb_10}'
                     {$sql_certify} ";
                     
            sql_query($sqlvvv);
         		
         	//가입이 완료되면 로그인 처리
            $mb = get_member($mb_id);
			run_event('member_login_check', $mb, $link, $is_social_login);
			set_session('ss_mb_id', $mb['mb_id']);
	}
	
	$http_host = $_SERVER['HTTP_HOST'];
	$request_uri = $_SERVER['REQUEST_URI'];
	$url = 'http://' . $http_host . $request_uri;

}	
?>


<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

<!-- 어플에서 넘어온 회원 로그인 처리 -->
<?php if(!$is_member && $_GET['uid']):?>
<script>
$(document).ready(function(){
	document.flogin.submit();
});
</script>
<form name="flogin" action="http://ranking-star.com/shopping_200429/bbs/login_check.php"  method="post" id="flogin" style="display:none">
	<input type="hidden" name="url" value="<?= $request_uri ?>">
	<input type="text" name="mb_id" id="login_id" placeholder="아이디" required="" class="frm_input required" maxlength="20" value="<?php echo $_REQUEST['uid']?>">
	<input type="password" name="mb_password" id="login_pw" placeholder="비밀번호" required="" class="frm_input required" maxlength="20" value="test123">
</form>
<?php endif?>

<?php if ($it_id || $ca_id || $_REQUEST['sw_direct']):?>
<style>
#shop-wrapper{padding-bottom:100px!important}
</style>
<?php endif?>


<div id="shop-wrapper">
	
<div id="container" class="<?php echo implode(' ', $container_class); ?>"><!-- container Start -->
    <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><h1 id="container_title"><a href="javascript:history.back()" class="btn_back"><i class="fa fa-chevron-left" aria-hidden="true"></i><span class="sound_only">뒤로</span></a> <?php echo $g5['title'] ?></h1><?php } ?>
