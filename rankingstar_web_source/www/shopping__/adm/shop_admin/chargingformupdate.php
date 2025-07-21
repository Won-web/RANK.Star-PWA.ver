<?php
$sub_menu = '500501';
include_once('./_common.php');

check_demo();

if ($W == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

check_admin_token();

@mkdir(G5_DATA_PATH."/charging", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/charging", G5_DIR_PERMISSION);

$bn_bimg      = $_FILES['bn_bimg']['tmp_name'];
$bn_bimg_name = $_FILES['bn_bimg']['name'];

$bn_id = (int) $bn_id;

if ($bn_bimg_del)  @unlink(G5_DATA_PATH."/charging/$bn_id");

//파일이 이미지인지 체크합니다.
if( $bn_bimg || $bn_bimg_name ){

    if( !preg_match('/\.(gif|jpe?g|bmp|png)$/i', $bn_bimg_name) ){
        alert("이미지 파일만 업로드 할수 있습니다.");
    }

    $timg = @getimagesize($bn_bimg);
    if ($timg['2'] < 1 || $timg['2'] > 16){
        alert("이미지 파일만 업로드 할수 있습니다.");
    }
}

$bn_url = strip_tags(clean_xss_attributes($bn_url));
$bn_alt = strip_tags(clean_xss_attributes($bn_alt));

$bn_company = strip_tags(clean_xss_attributes($bn_company));
$bn_subject = strip_tags(clean_xss_attributes($bn_subject));
$bn_desc = strip_tags(clean_xss_attributes($bn_desc));

if ($w=="")
{
    if (!$bn_bimg_name) alert('배너 이미지를 업로드 하세요.');

    sql_query(" alter table {$g5['g5_shop_charging_table']} auto_increment=1 ");

    $sql = " insert into {$g5['g5_shop_charging_table']}
                set bn_subject        = '$bn_subject',
                	bn_desc        = '$bn_desc',
                	bn_company        = '$bn_company',
                	bn_point        = '$bn_point',
                    bn_url        = '$bn_url',
                    bn_device     = '$bn_device',
                    bn_position   = '$bn_position',
                    bn_border     = '$bn_border',
                    bn_new_win    = '$bn_new_win',
                    bn_begin_time = '$bn_begin_time',
                    bn_end_time   = '$bn_end_time',
                    bn_time       = '$now',
                    bn_hit        = '0',
                    bn_order      = '$bn_order' ";
    sql_query($sql);

    $bn_id = sql_insert_id();
}
else if ($w=="u")
{
    $sql = " update {$g5['g5_shop_charging_table']}
                set bn_subject        = '$bn_subject',
                	bn_desc        = '$bn_desc',
                	bn_company        = '$bn_company',
                	bn_point        = '$bn_point',
                    bn_url        = '$bn_url',
                    bn_device     = '$bn_device',
                    bn_position   = '$bn_position',
                    bn_border     = '$bn_border',
                    bn_new_win    = '$bn_new_win',
                    bn_begin_time = '$bn_begin_time',
                    bn_end_time   = '$bn_end_time',
                    bn_order      = '$bn_order'
              where bn_id = '$bn_id' ";
    sql_query($sql);
}
else if ($w=="d")
{
    @unlink(G5_DATA_PATH."/charging/$bn_id");

    $sql = " delete from {$g5['g5_shop_charging_table']} where bn_id = $bn_id ";
    $result = sql_query($sql);
}


if ($w == "" || $w == "u")
{
    if ($_FILES['bn_bimg']['name']) upload_file($_FILES['bn_bimg']['tmp_name'], $bn_id, G5_DATA_PATH."/charging");

    goto_url("./chargingform.php?w=u&amp;bn_id=$bn_id");
} else {
    goto_url("./charginglist.php");
}
?>
