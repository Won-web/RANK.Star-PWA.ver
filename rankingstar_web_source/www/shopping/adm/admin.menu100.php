<?php
	
$menu['menu100'] = array (
    array('100000', '환경설정', G5_ADMIN_URL.'/config_form.php',   'config'),
    array('100100', '기본환경설정', G5_ADMIN_URL.'/config_form.php',   'cf_basic'),
    array('100200', '관리권한설정', G5_ADMIN_URL.'/auth_list.php',     'cf_auth'),
    array('100300', '메일 테스트', G5_ADMIN_URL.'/sendmail_test.php', 'cf_mailtest'),
	
	array('100800', '세션파일 일괄삭제',G5_ADMIN_URL.'/session_file_delete.php', 'cf_session', 1),
    array('100900', '캐시파일 일괄삭제',G5_ADMIN_URL.'/cache_file_delete.php',   'cf_cache', 1),
    //array('100910', '캡챠파일 일괄삭제',G5_ADMIN_URL.'/captcha_file_delete.php',   'cf_captcha', 1),
    
);


if(version_compare(phpversion(), '5.3.0', '>=') && defined('G5_BROWSCAP_USE') && G5_BROWSCAP_USE) {
    //$menu['menu100'][] = array('100510', 'Browscap 업데이트', G5_ADMIN_URL.'/browscap.php', 'cf_browscap');
    //$menu['menu100'][] = array('100520', '접속로그 변환', G5_ADMIN_URL.'/browscap_convert.php', 'cf_visit_cnvrt');
}

//$menu['menu100'][] = array('100410', 'DB업그레이드', G5_ADMIN_URL.'/dbupgrade.php', 'db_upgrade');
//$menu['menu100'][] = array('100400', '부가서비스', G5_ADMIN_URL.'/service.php', 'cf_service');
?>