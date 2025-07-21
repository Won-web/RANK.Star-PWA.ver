
<?php
include_once('./_common.php');
define("_INDEX_", TRUE);
include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
$device = $_GET["device"];
// echo "device ::: ".$device;

?>

<style>
#header{background:#fff;position:fixed;left:0;top:0;width:100%;padding:10px;text-align:center;z-index:9999}
#header img{height:25px}
#header-close{position:absolute;right:20px;top:15px;}
#header-close img{height:20px;}
#mainBody{padding-top:50px;}
</style>
<input type="hidden" id="os" value="<?php echo $device?>">
<script>
	function nativeClose(dev) {
		
   		if(dev == "iOS") { // iOS     
     		window.webkit.messageHandlers.callbackHandler.postMessage('msg'); 
   		} else {

      		Android.showToast('msg'); // Android
   		}
	}
</script>

<!-- 무료충전소에서 만 사용 할 상단 바 -->
<header id="header">
	<img src="<?php echo G5_IMG_URL?>/logo-white@2x.png">
	<a href="#none" id="header-close" onclick="nativeClose('<?=$device?>');"><img src="<?php echo G5_IMG_URL?>/close@2x.png" alt=""></a>
</header>


<!--
<script>
	
function update_form(bn_id){
  $.ajax({
    url: "/shop/free_charging_go.php",
    type: "GET",
    dataType: "html",
    data: {'bn_id':bn_id},
    success: function(data){
	  
		alert(data);  
	  
    },
    
    error: function (request, status, error){        
        var msg = "ERROR : " + request.status + "<br>"
      msg +=  + "내용 : " + request.responseText + "<br>" + error;
      console.log(msg);              
    }
  });
}

</script>-->

<?php
	$result = sql_query("select * from g5_shop_charging order by bn_id desc");
	$row = sql_query($result);
	
	//회원정보 구하기
	$m_sql = "select * from g5_member where mb_id='{$member['mb_id']}'";
	$m_row = sql_fetch($m_sql);
	
	//오늘날짜 구하기
	$today = date("y-m-d H:i:s");
?>
<div id="mainBody">
<?php 
	for ($i=0; $row=sql_fetch_array($result); $i++) {
	$bimg = G5_DATA_PATH.'/charging/'.$row['bn_id'];
	
	$res = sql_fetch("SELECT COUNT(*) AS cnt FROM g5_shop_charging_check WHERE mb_id = '{$member['mb_id']}' and bn_id='{$row['bn_id']}' AND datetime BETWEEN DATE_FORMAT(CURRENT_TIMESTAMP(), '%Y-%m-%d 00:00:00') AND DATE_FORMAT(CURRENT_TIMESTAMP(), '%Y-%m-%d 23:59:59')"); 
	
	if(file_exists($bimg)) {
        $size = @getimagesize($bimg);
        if($size[0] && $size[0] > 800)
            $width = 800;
        else
            $width = $size[0];

        $bn_img = "";
       
        $bn_img .= G5_DATA_URL.'/charging/'.$row['bn_id'];
    }
?>


<?php if(date('y-m-d') < substr($row['bn_end_time'], 2, 14)):?>
<div class="item-bn">
	<div class="item__head">
		<span class="item-badge"><img src="<?php echo G5_THEME_IMG_URL?>/star-wb.png"> <?php echo $row['bn_point']?></span>
		<?php if($res['cnt'] == 0):?>
		<a href="/shopping/shop/free_charging_go.php?bn_id=<?php echo $row['bn_id']?>&device=<?php echo $device?>" ><img src="<?php echo $bn_img?>"></a>
		<?php else:?>
		<a href="#none" onclick="alert('1일 1회만 참여 가능합니다.');"><img src="<?php echo $bn_img?>"></a>
		<?php endif?>
	</div>
	<div class="item__body">
		<strong class="item-title"><?php echo $row['bn_subject']?></strong>
		<p class="item-desc"><?php echo $row['bn_desc']?></p>
	</div>
</div>
<?php endif?>

<?php } ?>


</div>

<?php
include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
?>

