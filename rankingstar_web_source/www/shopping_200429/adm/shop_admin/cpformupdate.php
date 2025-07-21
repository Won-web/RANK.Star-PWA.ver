<?php
$sub_menu = '700100';
include_once('./_common.php');

check_demo();

if ($W == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

check_admin_token();

@mkdir(G5_DATA_PATH."/cp", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/cp", G5_DIR_PERMISSION);

$cp_bimg      = $_FILES['cp_bimg']['tmp_name'];
$cp_bimg_name = $_FILES['cp_bimg']['name'];

$cp_id = (int) $cp_id;

if ($cp_bimg_del)  @unlink(G5_DATA_PATH."/cp/$cp_id");

//파일이 이미지인지 체크합니다.
if( $cp_bimg || $cp_bimg_name ){

    if( !preg_match('/\.(gif|jpe?g|bmp|png)$/i', $cp_bimg_name) ){
        alert("이미지 파일만 업로드 할수 있습니다.");
    }

    $timg = @getimagesize($cp_bimg);
    if ($timg['2'] < 1 || $timg['2'] > 16){
        alert("이미지 파일만 업로드 할수 있습니다.");
    }
}

$cp_url = strip_tags(clean_xss_attributes($cp_url));
$cp_alt = strip_tags(clean_xss_attributes($cp_alt));

$cp_company = strip_tags(clean_xss_attributes($cp_company));
$cp_subject = strip_tags(clean_xss_attributes($cp_subject));
$cp_desc = strip_tags(clean_xss_attributes($cp_desc));

if ($w=="")
{
    //if (!$bn_bimg_name) alert('배너 이미지를 업로드 하세요.');

    
    
    if($auto == 1){ //쿠폰 자동생성
	    	    
	    sql_query(" alter table g5_shop_cp auto_increment=1 ");
	    
	    for ($i=0;$i < $cpm_qty;$i++){
		    
		    $j = 0;
		    do {
		        $cp_number = get_coupon_id();
		
		        $sql3 = " select count(*) as cnt from g5_shop_cp where cp_number = '$cp_number' ";
		        $row3 = sql_fetch($sql3);
		
		        if(!$row3['cnt'])
		            break;
		        else {
		            if($j > 20)
		                die('Coupon ID Error');
		        }
		
		        $j++;
		
		    } while(1);
		    
		    $sql = " insert into g5_shop_cp
		                set cp_number        = '$cp_number',
		                	cp_datetime = '".G5_TIME_YMDHIS."',
		                	cp_point        = '$cpm_point'";
		    sql_query($sql);
		    $cp_id = sql_insert_id();
	    }
	    
    } else {
	    sql_query(" alter table g5_shop_cp auto_increment=1 ");
	    $sql = " insert into g5_shop_cp
	                set cp_number        = '$cp_number',
	                	cp_point        = '$cp_point'";
	    sql_query($sql);
	    $cp_id = sql_insert_id();
    }
}
else if ($w=="u")
{
    $sql = " update g5_shop_cp
                set cp_mb_id        = '$cp_mb_id',
	                cp_point        = '$cp_point',
	                cp_using        = '$cp_using'
                
              where cp_id = '$cp_id' ";
    sql_query($sql);
}
else if ($w=="d")
{
    @unlink(G5_DATA_PATH."/cp/$cp_id");

    $sql = " delete from g5_shop_cp where cp_id = $cp_id ";
    $result = sql_query($sql);
}


if ($w == "" || $w == "u")
{
    if ($_FILES['cp_bimg']['name']) upload_file($_FILES['cp_bimg']['tmp_name'], $cp_id, G5_DATA_PATH."/cp");
	
	if($auto = 1){
		goto_url("./cplist.php");
	} else {
		goto_url("./cpform.php?w=u&amp;cp_id=$cp_id");
	}
} else {
    goto_url("./cplist.php");
}
?>
