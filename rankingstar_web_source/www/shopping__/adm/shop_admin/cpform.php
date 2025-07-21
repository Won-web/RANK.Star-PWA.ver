<?php
$sub_menu = '700100';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$cp_id = preg_replace('/[^0-9]/', '', $cp_id);

$html_title = '배너';
$g5['title'] = $html_title.'관리';

if ($w=="u")
{
    $html_title .= ' 수정';
    $sql = " select * from g5_shop_cp where cp_id = '$cp_id' ";
    $cp = sql_fetch($sql);
}
else
{
    $html_title .= ' 입력';
    $cp['bn_url']        = "http://";
    $cp['bn_begin_time'] = date("Y-m-d 00:00:00", time());
    $cp['bn_end_time']   = date("Y-m-d 00:00:00", time()+(60*60*24*31));
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="fcp" action="./cpformupdate.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="cp_id" value="<?php echo $cp_id; ?>">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="cp_number">쿠폰번호</label></th>
        <td>
            <input type="text" name="cp_number" value="<?php echo get_text($cp['cp_number']); ?>" id="cp_number" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="cp_point">포인트</label></th>
        <td>
            <input type="text" name="cp_point" size="10" value="<?php echo get_sanitize_input($cp['cp_point']); ?>" id="cp_point" class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="cp_mb_id">사용한 유저</label></th>
        <td>
            <input type="text" name="cp_mb_id" size="10" value="<?php echo get_sanitize_input($cp['cp_mb_id']); ?>" id="cp_mb_id" class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="cp_using">사용유무</label></th>
        <td>
            <input type="radio" name="cp_using" value="0" id="cp_using_0" <?php echo $cp['cp_using'] == 0 ? 'checked="checked"':''?>><label for="cp_using_0">미사용</label>
            <input type="radio" name="cp_using" value="1" id="cp_using_1" <?php echo $cp['cp_using'] == 1 ? 'checked="checked"':''?>><label for="cp_using_1">사용</label>
        </td>
    </tr>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./cplist.php" class="btn_02 btn">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
