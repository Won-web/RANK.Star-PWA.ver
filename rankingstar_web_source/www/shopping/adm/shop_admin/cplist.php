<?php
$sub_menu = '700100';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$bn_position = (isset($_GET['bn_position']) && in_array($_GET['bn_position'], array('메인', '왼쪽'))) ? $_GET['bn_position'] : '';
$bn_device = (isset($_GET['bn_device']) && in_array($_GET['bn_device'], array('pc', 'mobile'))) ? $_GET['bn_device'] : 'both';
$bn_time = (isset($_GET['bn_time']) && in_array($_GET['bn_time'], array('ing', 'end'))) ? $_GET['bn_time'] : '';

$where = ' where ';
$sql_search = '';

if ( $bn_position ){
    $sql_search .= " $where bn_position = '$bn_position' ";
    $where = ' and ';
    $qstr .= "&amp;bn_position=$bn_position";
}

if ( $bn_device && $bn_device !== 'both' ){
    $sql_search .= " $where bn_device = '$bn_device' ";
    $where = ' and ';
    $qstr .= "&amp;bn_device=$bn_device";
}

if ( $bn_time ){
    $sql_search .= ($bn_time === 'ing') ? " $where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time " : " $where bn_end_time < '".G5_TIME_YMDHIS."' ";
    $where = ' and ';
    $qstr .= "&amp;bn_time=$bn_time";
}

$g5['title'] = '쿠폰리스트';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_common = " from g5_shop_cp ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 100;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
?>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt"> <?php echo ($sql_search) ? '검색' : '등록'; ?>된 쿠폰 </span><span class="ov_num"> <?php echo $total_count; ?>개</span></span>
	
	<!--
    <form name="flist" class="local_sch01 local_sch">
    <input type="hidden" name="page" value="<?php echo $page; ?>">

    <label for="bn_position" class="sound_only">검색</label>
    <select name="bn_position" id="bn_position">
        <option value=""<?php echo get_selected($bn_position, '', true); ?>>위치 전체</option>
        <option value="메인"<?php echo get_selected($bn_position, '메인', true); ?>>메인</option>
        <option value="왼쪽"<?php echo get_selected($bn_position, '왼쪽', true); ?>>왼쪽</option>
    </select>

    <select name="bn_device" id="bn_device">
        <option value="both"<?php echo get_selected($bn_device, 'both', true); ?>>PC와 모바일</option>
        <option value="pc"<?php echo get_selected($bn_device, 'pc'); ?>>PC</option>
        <option value="mobile"<?php echo get_selected($bn_device, 'mobile'); ?>>모바일</option>
    </select>

    <select name="bn_time" id="bn_time">
        <option value=""<?php echo get_selected($bn_time, '', true); ?>>배너 시간 전체</option>
        <option value="ing"<?php echo get_selected($bn_time, 'ing'); ?>>진행중인 배너</option>
        <option value="end"<?php echo get_selected($bn_time, 'end'); ?>>종료된 배너</option>
    </select>

    <input type="submit" value="검색" class="btn_submit">

    </form>-->
    
    <div id="cpm">
    <form name="fcp" action="./cpformupdate.php" method="post" enctype="multipart/form-data" onsubmit="return show_alert(this);">
	    <input type="hidden" name="auto" value="1">
	    
	    <div><label for="cpm_qty">수량</label> <input type="text" name="cpm_qty" id="cpm_qty" class="frm_input" style="width:50px"></div>
	    <div><label for="cpm_point">포인트</label> <input type="text" name="cpm_point" id="cpm_point" class="frm_input" style="width:100px;"></div>
	    <input type="submit" value="쿠폰자동생성" class="btn btn_02">
    </form>
    </div>
    
    <style>
	    #cpm{padding:20px 0;clear:both;float:right}
	    #cpm div{padding-left:10px;display:inline-block}
	    #cpm input[type="text"]{border-radius:5px;height:30px;padding:5px;line-height:1;text-align:center;font-weight:bold}
   </style>
   
   <script>
	   function show_alert() {
		  return confirm('정말로 쿠폰을 생성 하시겠습니까?');
		}
   </script>

</div>

<div class="btn_fixed_top">
    <a href="./cpform.php" class="btn_01 btn">추가</a>
    <a href="./cpexcel_down.php" onclick="return excel_down(f);" class="btn_02 btn">엑셀다운로드</a>
</div>

<form name="fcouponlist" id="fcouponlist" method="post" action="./cplist_delete.php" onsubmit="return fcouponlist_submit(this);">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="token" value="">
<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <colgroup>
	    <col width="5%">
    	<col width="6%">
    	<col width="">
    	<col width="10%">
    	<col width="10%">
    	<col width="">
    	<col width="20%">
    	<col width="20%">
    </colgroup>
    <thead>
    <tr>
	    <th scope="col">
            <label for="chkall" class="sound_only">쿠폰 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col"  id="th_id">번호</th>
        <th scope="col" id="th_loc">쿠폰번호</th>
        <th scope="col" id="th_st">포인트</th>
        <th scope="col" id="th_end">사용자</th>
        <th scope="col" id="th_status">상태</th>
        <th scope="col" id="th_date">생성일</th>
        <th scope="col" id="th_date2">사용일</th>
        <th scope="col" id="th_mng">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = " select * from g5_shop_cp $sql_search
          order by cp_id desc
          limit $from_record, $rows  ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        // 테두리 있는지
        $bn_border  = $row['bn_border'];
        // 새창 띄우기인지
        $bn_new_win = ($row['bn_new_win']) ? 'target="_blank"' : '';

        $bimg = G5_DATA_PATH.'/charging/'.$row['cp_id'];
        if(file_exists($bimg)) {
            $size = @getimagesize($bimg);
            if($size[0] && $size[0] > 800)
                $width = 800;
            else
                $width = $size[0];

            $bn_img = "";
           
            $bn_img .= '<img src="'.G5_DATA_URL.'/charging/'.$row['cp_id'].'" height="60" alt="'.get_text($row['bn_alt']).'">';
        }

        switch($row['bn_device']) {
            case 'pc':
                $bn_device = 'PC';
                break;
            case 'mobile':
                $bn_device = '모바일';
                break;
            default:
                $bn_device = 'PC와 모바일';
                break;
        }

        $bn_begin_time = substr($row['bn_begin_time'], 2, 14);
        $bn_end_time   = substr($row['bn_end_time'], 2, 14);

        $bg = 'bg'.($i%2);
        
        $res = sql_fetch("select count(0) as cnt from g5_shop_charging_check where cp_id = '{$row['cp_id']}'"); 
    ?>

    <tr class="<?php echo $bg; ?>">
	    <td class="td_chk">
            <input type="hidden" id="cp_id_<?php echo $i; ?>" name="cp_id[<?php echo $i; ?>]" value="<?php echo $row['cp_id']; ?>">
            <input type="checkbox" id="chk_<?php echo $i; ?>" name="chk[]" value="<?php echo $i; ?>" title="내역선택">
        </td>
        <td headers="th_id" class="td_num"><?php echo $row['cp_id']; ?></td>
        
        <td headers="th_loc">
	        <?php if ($row['cp_using'] == 1):?>
		        <strike><?php echo $row['cp_number']; ?></strike>
	        <?php else:?>
		        <?php echo $row['cp_number']; ?>
	        <?php endif?>
	    </td>
	    <td headers="th_loc">
	        <?php echo number_format($row['cp_point']); ?>p
	    </td>
        <td headers="th_hit" class="td_num">
	        <?php echo $row['cp_mb_id'] ? $row['cp_mb_id']:'' ?><br>
	        <?php
		        $cp_name_sql = "select * from g5_member where mb_id='{$row['cp_mb_id']}' limit 0,1";
		        $cp_name_result = sql_fetch($cp_name_sql);
		    ?>
	        (<?php echo $cp_name_result['mb_name']?>)
	    </td>
	    <td>
	        <?php echo $row['cp_using'] == 0 ? '미사용':'<span style="color:red">사용</span>'?>
        </td>
        <td>
	        <?php echo $row['cp_datetime']?>
        </td>
        <td>
	        <?php echo $row['cp_use_date'] ? $row['cp_use_date']:''?>
        </td>
        <td headers="th_mng" class="td_mng td_mns_m">
            <a href="./cpform.php?w=u&amp;cp_id=<?php echo $row['cp_id']; ?>" class="btn btn_03">수정</a>
            <a href="./cpformupdate.php?w=d&amp;cp_id=<?php echo $row['cp_id']; ?>" onclick="return delete_confirm(this);" class="btn btn_02">삭제</a>
        </td>
    </tr>

    <?php
    }
    if ($i == 0) {
    echo '<tr><td colspan="8" class="empty_table">등록된 쿠폰이 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>

</div>

<input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>


<script>
function fcouponlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>
<script>
function excel_down(f){ // 회원 엑셀 다운로드를 위하여 추가
	f.action = "./cpexcel_down.php";
	f.submit();
	f.action = "";
}
</script>
<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
