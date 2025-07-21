<?php 
	header('Content-Type: text/html; charset=UTF-8');

	function send_notification ($tokens, $data)
	{
		

		/*  서버키는 FCM에서 발급받은 키입니다. */
		$url = 'https://fcm.googleapis.com/fcm/send';	
		// $serverKey = 'AAAADz4fpdg:APA91bHwetQ2xa75ZVHn-N21yybtcWdq1ZOvHP2F8bYazARQkoqN5nVF44zXyP7o9FTRJqctIhcRU49FtDVuLea6CxzWZMTpCGZN4TAxKt_b1APC5G9482zySZH4yowK93J0dRoftoiv';

		// $serverKey = 'AAAApi0Xw-g:APA91bHf8wZO68jbWHBqeuUHy2qdJGY9i25GtrAH6GMAaxefw7uFupILzd-5FqQQ5J0q_JolSycDAhThnPD4wRP1_AZWwg3SG9XLRy3hKQSVZuRLuOvQwP62tJH-fZV0-HRWKj777Qw0';

		$serverKey = 'AAAAzhRisjU:APA91bFzwNbiaGoEvHyzsjJfL-OOBv9A8pO-7F7pSh57DkxEm9-KlQF6BWVTLpdSb4505vQbb4Mi0BX1go7HM_MHHShteMQdnA2ArOZFhapxXNG3g_VUZGU6ekT2s7lGfgrGAHpCmrib';

		$notification_str = array(
			// 'alert'	=> $data["title"],
			'title'	=> $data["title"],
			'body' 	=> $data["body"],
			'sound' => "default"
        );

		$data_str = array(
			'title'	=> $data["title"],
			'body' 	=> $data["body"],
          );
		
        
		$aps = array(
			'content-available'	=> 1
         );	


		if (is_array($tokens)) {
			$fields['registration_ids'] = $tokens;
		}else{
			$fields['to'] = $tokens;

		}

		$fields['content_available'] = true;
		$fields['priority'] = "high";		
		$fields['notification'] = $notification_str;
		$fields['data'] = $data_str;
		$fields['aps'] = $aps;


		$headers = array('Authorization:key='.$serverKey,'Content-Type: application/json');
	   echo json_encode($fields);
	   

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
	}
	

	/***개별메세지 전송시 디바이스토큰을 배열로 저장한다****/
	// $token = "cSyNaRYiIXk:APA91bGE5Mz8ywcOFeFTjw1U7hG_YVKzpaZEV1MRsfBm0wqLysUUfE_fE4PskrALt3pn0KOgStTYEzEwDRb3YhWWSF7esGr2P3Mc0q_TMPcX6Et_CYonsTH-ulEVORQhKrbX6iO5HlQ5";


	/*여러명에게 단체로 보내낼 때 배열에 넣어서 */
	$tokens = array(


					'e0Jj24U71Wg:APA91bFCesnwKHxpicNPHuxhJhhYCvbRRZPNI0mYNNA9rU0tzpLHzSNCbbZBm9TR0v4W5ixcM3M1eXyEyr0Yj-k_xqXqofuGdP2sKr7UfqV4Grypy-IILTIpI2w2I3rM5IlcBikPwgpC'


					



					);
	
	/*  특정그룹에게 발송할때 아래와 같이 작성 - 0101이 그룹 */
	// $grounp = "/topics/0101";


	/*  전체에게 발송할때 아래와 같이 작성  */
	//$all = "/topics/ios_test";
	//$arr_topic = array(
					// "/topics/all",
					// "/topics/0101"
					// );


	

	$mTitle = "부정 사용자 알림" ;
    $mMessage = "귀하께서는 현재 부정한 방법으로 반복적으로 아이디를 생성한 것으로 확인되었습니다.랭킹스타는 공정한 투표기회 부여를 위해 하나의 기기에 하나의 아이디만 허용됩니다.이러한 방법으로 투표한 것은 모두 무효처리되며 참가자에게 불리하게 작용할수 있음을 알려드립니다.또한,귀하께서는 전화번호 무단 도용등의 법적 문제도 야기하고 있습니다. 우리는 귀하가 만든 모든 아이디를 파악하고 이미 파악하였고 이를 조직위원회에 보고할 예정입니다. 이의가 있으시다면 전화주십시요. 010-2017-6564 ";

    // $mTitle = "title" ;
    // $mMessage = "message";
   

	$inputData = array("title" => $mTitle, "body" => $mMessage);
	$result = send_notification($tokens , $inputData);
	
	echo "<br><br><br>".$result;



 ?>

