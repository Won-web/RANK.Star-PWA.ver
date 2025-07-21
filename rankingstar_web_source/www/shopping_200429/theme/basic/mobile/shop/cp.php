
<?php
include_once('./_common.php');
define("_INDEX_", TRUE);
include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
?>


<script>
$(document).on("keyup", "#cp_number", function() { //쿠폰 입력시 자동으로 하이픈을 넣어준다.
	$(this).val( $(this).val().replace(/[^a-zA-Z0-9]/g, "").replace(/([a-zA-Z0-9]{4})+([a-zA-Z0-9]{2})+([a-zA-Z0-9]{4})/,"$1-$2-$3").replace("--", "-").toUpperCase()); 
});
function check(){ //쿠폰 번호를 입력 하지 않았다면.
	if(formField.cp_number.value == ''){
		alert("쿠폰번호를 입력 하세요");
		return false;
    }
}
</script>
<style>
#cp-wrap{text-align:center;display:flex;align-items:center;flex-direction:column;height:100%;padding:100px 0}
#cp-wrap h2{margin-bottom:5px;font-size:18px;}
#cp-wrap form{display:block;padding:20px;width:100%;text-align:center;}
#cp-wrap input[type="text"]{background-color:#fff;border:0;padding:10px;width:100%;display:block;text-align:center;font-size:1.5rem;text-transform:uppercase}
#cp-wrap input[type="submit"]{display:block;text-align:center;color:#fff;background-color:#dd2c8b;font-weight:bold;position:fixed;bottom:0;left:0;width:100%;padding:20px;font-size:16px;line-height:1;border:0}
#cp-wrap .mbox{color:#404553;line-height:1.6;margin-top:20px;}
</style>

<div id="cp-wrap">
	<h2>쿠폰번호를 입력해주세요</h2>	
	<form id="formField" name="formField" action="<?php echo G5_SHOP_URL?>/cp_using.php" onsubmit="return check(this)" method="post">
		<input type="hidden" name="uid" value="<?php echo $_REQUEST['uid']?>">
		<input type="text" name="cp_number" id="cp_number">
		<input type="submit" value="확인">
	</form>
	<div class="mbox">
		- 쿠폰은 구매 상품이 아닙니다.<br>
		- 이벤트 참가를 통해 발급 받은 쿠폰번호를 입력하세요.<br>
		- 한번 사용한 쿠폰번호는 재사용이 불가능합니다.<br>
	</div>
</div>

<?php  
	//goto_url(G5_BBS_URL."/login.php?url=/shop/cp.php");
?>

<?php
include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
?>
