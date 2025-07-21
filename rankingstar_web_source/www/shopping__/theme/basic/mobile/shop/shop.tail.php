<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$admin = get_admin("super");

?>
</div><!-- container End -->

<?php if($ca_id || $it_id || $_REQUEST['sw_direct'] || $od_id):?>
<div id="ft">
    <h2><?php echo $config['cf_title']; ?> 정보</h2>
    <div id="ft_logo" style="display:none"><a href="<?php echo G5_SHOP_URL; ?>/"><img src="<?php echo G5_DATA_URL; ?>/common/mobile_logo_img2" alt="<?php echo $config['cf_title']; ?> 메인"></a></div>
    
	<p style="padding:5px;background-color:#333;color:#fff;font-size:.6rem">해당 홈페이지 내 반품, 환불, 민원에 대한 책임은 뷰티한국주식회사에서 지고 있음을 알려드립니다. 담당자 : 허성훈  (010-2017-6564)</p>
    <p>
        <span><b>회사명</b> <?php echo $default['de_admin_company_name']; ?></span>
        <span><b>주소</b> <?php echo $default['de_admin_company_addr']; ?></span><br>
        <span><b>사업자 등록번호</b> <?php echo $default['de_admin_company_saupja_no']; ?></span><br>
        <span><b>대표이메일</b> <?php echo $default['de_admin_info_email']; ?></span><br>
        <span><b>대표</b> <?php echo $default['de_admin_company_owner']; ?></span>
        <span><b>전화</b> <?php echo $default['de_admin_company_tel']; ?></span>
        <span><b>팩스</b> <?php echo $default['de_admin_company_fax']; ?></span><br>
        <span><b>통신판매업신고번호</b> <?php echo $default['de_admin_tongsin_no']; ?></span><br>
        <span><b>개인정보 보호책임자</b> <?php echo $default['de_admin_info_name']; ?> (<?php echo $default['de_admin_info_email']; ?>)</span>
        <?php if ($default['de_admin_buga_no']) echo '<span><b>부가통신사업신고번호</b> '.$default['de_admin_buga_no'].'</span>'; ?><br>
        Copyright &copy; <?php echo $default['de_admin_company_name']; ?>. All Rights Reserved.
    </p>
</div>
<?php endif?>

</div>

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>
