<?php
$sub_menu = '700200';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$bn_id = preg_replace('/[^0-9]/', '', $bn_id);

$html_title = '배너';
$g5['title'] = $html_title.'관리';

if ($w=="u")
{
    $html_title .= ' 수정';
    $sql = " select * from {$g5['g5_shop_charging_table']} where bn_id = '$bn_id' ";
    $bn = sql_fetch($sql);
}
else
{
    $html_title .= ' 입력';
    $bn['bn_url']        = "http://";
    $bn['bn_begin_time'] = date("Y-m-d 00:00:00", time());
    $bn['bn_end_time']   = date("Y-m-d 00:00:00", time()+(60*60*24*31));
}

// 접속기기 필드 추가
if(!sql_query(" select bn_device from {$g5['g5_shop_charging_table']} limit 0, 1 ")) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_charging_table']}`
                    ADD `bn_device` varchar(10) not null default '' AFTER `bn_url` ", true);
    sql_query(" update {$g5['g5_shop_charging_table']} set bn_device = 'pc' ", true);
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="fcharging" action="./chargingformupdate.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="bn_id" value="<?php echo $bn_id; ?>">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row">이미지</th>
        <td>
            <input type="file" name="bn_bimg">
            <?php
            $bimg_str = "";
            $bimg = G5_DATA_PATH."/charging/{$bn['bn_id']}";
            if (file_exists($bimg) && $bn['bn_id']) {
                $size = @getimagesize($bimg);
                if($size[0] && $size[0] > 750)
                    $width = 750;
                else
                    $width = $size[0];

                echo '<input type="checkbox" name="bn_bimg_del" value="1" id="bn_bimg_del"> <label for="bn_bimg_del">삭제</label>';
                $bimg_str = '<img src="'.G5_DATA_URL.'/charging/'.$bn['bn_id'].'" width="'.$width.'">';
            }
            if ($bimg_str) {
                echo '<div class="charging_or_img">';
                echo $bimg_str;
                echo '</div>';
            }
            ?>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_company">제휴업체명</label></th>
        <td>
            <?php echo help("제휴업체명을 입력 하세요 ex)(주)랭킹스타"); ?>
            <input type="text" name="bn_company" value="<?php echo get_text($bn['bn_company']); ?>" id="bn_company" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_subject">제목</label></th>
        <td>
            <?php echo help("제목을 입력 하세요"); ?>
            <input type="text" name="bn_subject" value="<?php echo get_text($bn['bn_subject']); ?>" id="bn_subject" class="frm_input" size="80">
        </td>
    </tr>
     <tr>
        <th scope="row"><label for="bn_desc">한줄내용</label></th>
        <td>
            <?php echo help("한줄내용을 입력 하세요"); ?>
            <input type="text" name="bn_desc" value="<?php echo get_text($bn['bn_desc']); ?>" id="bn_desc" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_url">링크</label></th>
        <td>
            <?php echo help("배너클릭시 이동하는 주소입니다."); ?>
            <input type="text" name="bn_url" size="80" value="<?php echo get_sanitize_input($bn['bn_url']); ?>" id="bn_url" class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_point">적립포인트</label></th>
        <td>
            <?php echo help("적립포인트"); ?>
            <input type="text" name="bn_point" size="10" value="<?php echo get_sanitize_input($bn['bn_point']); ?>" id="bn_point" class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_begin_time">시작일시</label></th>
        <td>
            <?php echo help("배너 게시 시작일시를 설정합니다."); ?>
            <input type="text" name="bn_begin_time" value="<?php echo $bn['bn_begin_time']; ?>" id="bn_begin_time" class="frm_input"  size="21" maxlength="19">
            <input type="checkbox" name="bn_begin_chk" value="<?php echo date("Y-m-d 00:00:00", time()); ?>" id="bn_begin_chk" onclick="if (this.checked == true) this.form.bn_begin_time.value=this.form.bn_begin_chk.value; else this.form.bn_begin_time.value = this.form.bn_begin_time.defaultValue;">
            <label for="bn_begin_chk">오늘</label>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_end_time">종료일시</label></th>
        <td>
            <?php echo help("배너 게시 종료일시를 설정합니다."); ?>
            <input type="text" name="bn_end_time" value="<?php echo $bn['bn_end_time']; ?>" id="bn_end_time" class="frm_input" size=21 maxlength=19>
            <input type="checkbox" name="bn_end_chk" value="<?php echo date("Y-m-d 23:59:59", time()+60*60*24*31); ?>" id="bn_end_chk" onclick="if (this.checked == true) this.form.bn_end_time.value=this.form.bn_end_chk.value; else this.form.bn_end_time.value = this.form.bn_end_time.defaultValue;">
            <label for="bn_end_chk">오늘+31일</label>
        </td>
    </tr>
    <!--
    <tr>
        <th scope="row"><label for="bn_order">출력 순서</label></th>
        <td>
           <?php echo help("배너를 출력할 때 순서를 정합니다. 숫자가 작을수록 먼저 출력됩니다."); ?>
           <?php echo order_select("bn_order", $bn['bn_order']); ?>
        </td>
    </tr>-->
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./charginglist.php" class="btn_02 btn">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
