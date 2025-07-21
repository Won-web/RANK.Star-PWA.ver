
<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/mobile/shop/_shop.setup.php');

//오늘날짜 구하기
$today = date("y-m-d H:i:s");

//디바이스 체크
$device = $_GET["device"];

//무료충전광고의 bn_id값을 구한다
$row2 = sql_fetch("select * from g5_shop_charging where bn_id = '{$bn_id}'");

//접속한 회원의 광고시청여부
$res = sql_fetch("SELECT COUNT(*) AS cnt FROM g5_shop_charging_check WHERE mb_id = '{$member['mb_id']}' and bn_id='{$row2['bn_id']}' AND datetime BETWEEN DATE_FORMAT(CURRENT_TIMESTAMP(), '%Y-%m-%d 00:00:00') AND DATE_FORMAT(CURRENT_TIMESTAMP(), '%Y-%m-%d 23:59:59')"); 

if ($res['cnt'] == 0){
	// 무료충전 로그남김	
	sql_query("insert into g5_shop_charging_check set bn_id='{$bn_id}',mb_id = '{$member[mb_id]}',datetime = '{$today}'");
	
	//포인트 적립
	insert_point($member['mb_id'], $row2['bn_point'], "무료충전({$row2['bn_subject']}) 포인트 지급",'','','','','무료 충전소 적립');
} else {
	
	//이미 참여 했을 경우 (1일 1회)
	alert("이미 참여 하셨습니다.", '/shopping/shop/free_charging.php');
}

?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">
		<meta name="HandheldFriendly" content="true">
		<meta name="format-detection" content="telephone=no">
		<style>
			*{margin:0;padding:0;}
			html,body{width:100%;height:100%;}
			body{overflow-y:auto}
			iframe{width:100%;height:100%;border:0;}
			#wrap{width:100%;margin:0 auto;}
			
			#controller{position:fixed;width:100%;bottom:20px;border-radius:10px;padding:10px;text-align:center;background:#fff;}
			#controller div{display:inline-block;}
			#controller #close{background-color:#4d4d4d;color:#fff;border-radius:10px;text-align:center;padding:5px 10px;border:0;cursor:pointer;}
			#controller #close.active{background-color:red;}
		</style>
	</head>
<body>
	
<!-- 인도측에서 받은 코드 :: 디바이스 체크 - 실제체킹코드를 넣어야함 -->
<input type="hidden" id="os" value="<?php echo $device?>">
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script>
$(function(){ 
	var count = <?php echo $setup['bn_count']?>;
    setInterval(function() {
        if (count == 0){
            
            $("#close").addClass("active");
            $("#msg").text("이제 광고를 닫아도 됩니다.");
            
            $("#close.active").click(function(){
			   //parent.history.back();
			   alert('<?php echo $row2['bn_point']?>개의 스타가 적립되었습니다.');
			   window.location.href = '/shopping/shop/free_charging.php?device=<?php echo $device?>';
		    });
		    
        }
        count -= 1;  // 1씩 감소
        if (count == 0){
            count = "0";  // 9->09로
        }
        $("#output").text(count);  // 카운트값 바꾸기
    }, 1000); // 1000ms(1초)마다 함수 실행 - 카운트다운 
});

</script>
<div id="wrap">
	
	<!-- 브라우저 하단 콘트롤러 -->
	<div id="controller">
		<div id="msg"><span id="output"><?php echo $setup['bn_count']?></span> 초 후 닫기 가능</div>
		<div><button id="close">닫기</button></div>
	</div>
	
	<!-- 광고페이지가 로딩 되는 iFrame -->
	<iframe width="100%" height="100%" src="<?php echo $row2['bn_url']?>"  frameborder="0"></iframe>
</div>
</body>
</html>
