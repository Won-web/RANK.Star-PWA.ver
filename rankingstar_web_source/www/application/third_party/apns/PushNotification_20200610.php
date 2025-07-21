<?php
require_once(dirname(__FILE__) . "/classes/class_DbConnect.php");
require_once(dirname(__FILE__) . "/classes/class_APNS.php");
require_once(dirname(__FILE__) . "/classes/class_Android.php");

class PushNotification{
	private $db;
	private $cronlimit=200;
	private $sendByCron = 'No';
	private $sound = 'default';	
	
	public function __construct() {
		$this->db = new DbConnect ( CON_DB_HOSTNAME, CON_DB_USER, CON_DB_PASSWORD, CON_DB_NAME );
		$this->db->show_errors ();
	}
	
	
	//Register Device 
	public function registerDevice($args) {
			
		$currentDateTime=date('Y-m-d H:i:s');
		$this->db->query ( "SET NAMES 'utf8';" );
		//Check If Device Already Register Than Update It Else Create It
		$sql = "SELECT * FROM apns_devices WHERE `client_id` = ".$this->_allowNullChar($args['client_id'])." AND `user_id` = ".$this->_allowNullChar($args['user_id'])." AND `device_token`= ".$this->_allowNullChar($args['device_token']);
		$deviceResult=$this->db->query($sql);
		if($deviceResult->num_rows > 0){
			//Update
			$updateQry = "UPDATE apns_devices SET 
            `device_uid` = ".$this->_allowNullChar($args['device_uid']).",
			`app_name`= ".$this->_allowNullChar($args['app_name']).",
			`app_version`= ".$this->_allowNullChar($args['app_version']).",
			`os`= ".$this->_allowNullChar($args['os']).",
			`device_name`= ".$this->_allowNullChar($args['device_name']).",
			`device_model`= ".$this->_allowNullChar($args['device_model']).",
			`device_version`= ".$this->_allowNullChar($args['device_version']).",
			`push_badge`= ".$this->_allowNullChar($args['push_badge']).",
			`push_alert`= ".$this->_allowNullChar($args['push_alert']).",
			`push_sound`= ".$this->_allowNullChar($args['push_sound']).",
			`push_vibrate`= ".$this->_allowNullChar($args['push_vibrate']).",
			`environment`= ".$this->_allowNullChar($args['environment']).",
			`status`='active',
			`updated_date`= '{$currentDateTime}',
			`language`= ".$this->_allowNullChar($args['language'])." 
			WHERE `client_id` = ".$this->_allowNullChar($args['client_id'])." AND `user_id` = ".$this->_allowNullChar($args['user_id'])." AND `device_token`= ".$this->_allowNullChar($args['device_token']);
			$this->db->query ( $updateQry );
		}else{
			//Insert
			$insertQry = "INSERT INTO `apns_devices`(`client_id`,`user_id`,`device_uid`,`device_token`,`app_name`,`app_version`,`os`,`device_name`,`device_model`,`device_version`,`push_badge`,`push_alert`,`push_sound`,`push_vibrate`,`environment`,`status`,`created_date`,`updated_date`,`badge_count`,`language`) 
			VALUES (
			".$this->_allowNullChar($args['client_id']).",
			".$this->_allowNullChar($args['user_id']).",
			".$this->_allowNullChar($args['device_uid']).",
			".$this->_allowNullChar($args['device_token']).",
			".$this->_allowNullChar($args['app_name']).",
			".$this->_allowNullChar($args['app_version']).",
			".$this->_allowNullChar($args['os']).",
			".$this->_allowNullChar($args['device_name']).",
			".$this->_allowNullChar($args['device_model']).",				
			".$this->_allowNullChar($args['device_version']).",
			".$this->_allowNullChar($args['push_badge']).",
			".$this->_allowNullChar($args['push_alert']).",
			".$this->_allowNullChar($args['push_sound']).",
			".$this->_allowNullChar($args['push_vibrate']).",
			".$this->_allowNullChar($args['environment']).",
			'active',
			'{$currentDateTime}',
			'{$currentDateTime}',
			0,
			".$this->_allowNullChar($args['language']).")";
			$this->db->query ( $insertQry );
		}
	}

	private function _allowNullInt($val) {
		if (trim ( $val ) != "")
			$ret = $val;
		else
			$ret = 0;
	
		return $ret;
	}
	private function _allowNullChar($val) {
		if (trim ( $val ) != "") {
			$search_arr = array ("\\","'");
			$replace_arr = array ("","''");
			$ret = "'" . str_replace ( $search_arr, $replace_arr, $val ) . "'";
		} else
			$ret = "NULL";
	
		return $ret;
	}
	
	/* Send Push Message */
	public function sendPushMessage($messageTitle, $message , $messageType , $senderId , $receiverId = NULL, $customData = array(),$deliver_by_cron = 'No'){
		// Add Message to APNS Master table
		$currentDateTime = date('Y-m-d H:i:s');
		$push_type= 'Normal';
		if(!empty($customData['push_type'])){
			$push_type = 'Admin';
		}
		
		// print_r($deliver_by_cron);exit();
		$this->db->query ( "SET NAMES 'utf8';" );
		$insertQuery = "INSERT INTO `apns_master` VALUES (NULL,'{$messageTitle}','{$message}','{$messageType}', {$senderId},'{$push_type}','{$currentDateTime}','{$currentDateTime}')";
		$this->db->query($insertQuery);
		$apns_master_id = $this->db->insert_id;
		
		// Fetch User List to whome push will be sent
		if(!empty($receiverId)) {
            if(is_array($receiverId)) {
				$receiverIds = implode(',', $receiverId);
				
                $sql = "SELECT * FROM apns_devices WHERE user_id IN ({$receiverIds}) AND push_alert = 'enabled' AND status='active'";
            } else {
                $sql = "SELECT * FROM apns_devices WHERE user_id = {$receiverId} AND push_alert = 'enabled' AND status='active'";
            }
		} else {
			$sql = "SELECT * FROM apns_devices WHERE push_alert = 'enabled' AND status='active'";
		}
		$deviceResult = $this->db->query($sql);
		
		//Prepare message for android and iOS based on device result
		$messageIds = array();
		if($deviceResult->num_rows > 0) {
			while($device = $deviceResult->fetch_array(MYSQLI_ASSOC)) {
				$customParam = array();
				if(!empty($customData)){
					$customParam = array_merge($customParam,$customData);
				}
				
				if(strtolower($device['os'])==='android'){
					// Create Message for Android
					$customParam['clientid']=$device['client_id'];
					$customParam['messageTitle']=$messageTitle;
					$customParam['messageType']=$messageType;
					$customParam['receiverId'] = $device['user_id'];
					if($device['push_vibrate']=='enabled'){
						$customParam ['vibrate'] = ( string ) $device['push_vibrate'];
					}

					$messageArr = array ();
					$messageArr ['message'] = $message;
					if($device['push_badge']=='enabled'){
						$messageArr ['badge'] = ( int ) 1;
					}
					if($device['push_sound']=='enabled'){
						$messageArr ['sound'] = ( string ) $this->sound;
					}
					if(!empty($customParam)){
						$messageArr ['customParam'] = $customParam;
					}

					//Queue Message For Android and Return Message ID
					$messageIds[] = $this->_queueMessages($apns_master_id, $device, $messageArr,$deliver_by_cron, 'Android');
					
				}else if(strtolower($device['os'])==='ios'){
					//Create Message for iOS
					$customParam ['clientid'] = $device['client_id'];
					$customParam ['messageTitle'] = $messageTitle;
					$customParam ['messageType'] = $messageType;
					$customParam ['receiverId'] = $device['user_id'];
					if($device['push_vibrate']=='enabled'){
						$customParam ['vibrate'] = ( string ) $device['push_vibrate'];
					}

					$messageArr = array ();
					$messageArr ['aps'] = array ();
					$messageArr ['aps'] ['alert'] = $message;
					if($device['push_badge']=='enabled'){
						$messageArr ['aps'] ['badge'] = ( int ) 1;
					}
					if($device['push_sound']=='enabled'){
						$messageArr ['aps'] ['sound'] = ( string ) $this->sound;
					}
					if(!empty($customParam)){
						$messageArr ['customParam'] = $customParam;
					}

					//Queue Message For iOS and Return Message ID
					$messageIds[] = $this->_queueMessages($apns_master_id, $device, $messageArr,$deliver_by_cron, 'iOS');
				}
			}
		}
	
		//Send Message to User Device
		if(!empty($messageIds) && $deliver_by_cron == 'No'){
			$this->_sendPushMessage($messageIds);
		}
	
		return true;
	}

	//Queue Push Messages for delivery
	private function _queueMessages($apns_master_id, $deviceDetails, $message ,$deliver_by_cron, $os){
		// print_r($deliver_by_cron);exit();
		$this->db->query("SET NAMES 'utf8';");
		$currentDateTime=date('Y-m-d H:i:s');
		$message = json_encode($message, JSON_UNESCAPED_UNICODE);
		$sql = "INSERT INTO `apns_messages` VALUES ( NULL, {$apns_master_id}, {$deviceDetails['device_id']}, '{$deviceDetails['client_id']}', '{$message}','queued','{$os}','{$currentDateTime}','{$currentDateTime}','{$deliver_by_cron}');";
		$this->db->query($sql);
		return $this->db->insert_id;		
	}

	//Send Push Message to Device
	private function _sendPushMessage($messageIdArr){
		$messagesIds = implode(',', $messageIdArr);
		$this->db->query("SET NAMES 'utf8';");
		$sql = "SELECT am.message_id, am.formated_message, am.os, ad.device_token, am.device_id, ad.environment, ad.client_id
				FROM `apns_messages` am 
				INNER JOIN apns_devices ad ON am.device_id = ad.device_id 
				WHERE am.message_id IN (".$messagesIds.")";
		$messageResult = $this->db->query($sql);

		if($messageResult->num_rows > 0){
			$deliverdIds = array();
			$failedIds = array();
			while($message = $messageResult->fetch_array(MYSQLI_ASSOC)) {
				$message_id = $message['message_id'];
				$messageText = $message['formated_message'];
				$token = $message['device_token'];
				$retValue = "failed";
				if(strtolower($message['os'])==='android'){
					//Send Push Message to Android
					$androdAPNS = new Android ( $this->db, $message['client_id'] );
					$retValue = $androdAPNS->pushFCMMessage($token, json_decode($messageText));

				}elseif(strtolower($message['os'])==='ios'){
					//Send Push Message to iOS
					$iOSAPNS = new APNS ( $this->db, $message['client_id'] );
					$retValue = $iOSAPNS->pushMessage($messageText, $token, $message['environment']);
				}

				if($retValue == "delivered"){
					$deliverdIds[] = $message_id;
				}
				else if($retValue == "failed"){
					$failedIds[] = $message_id;
				}
			}
			//Update Message Status
			$this->_udpateMessageStatus($deliverdIds, $failedIds);
		}
	}

	// Update Message Status
	private function _udpateMessageStatus($deliverdIdsArr = array(), $failedIdsArr = array()){
		$currentDateTime=date('Y-m-d H:i:s');	
		if(!empty($deliverdIdsArr)) {
			$deliverdIds = implode(',', $deliverdIdsArr);
			$updateQuryDelivered = "UPDATE apns_messages SET `status` = 'delivered',`updated_date` = '{$currentDateTime}'
									WHERE `status` = 'queued' AND `message_id` IN (".$deliverdIds.") ";
			$this->db->query($updateQuryDelivered);
		}
	
		if(!empty($failedIdsArr)) {
			$failedIds = implode(',', $failedIdsArr);
			$updateQuryFailed = "UPDATE apns_messages SET `status` = 'failed',`updated_date` = '{$currentDateTime}'
									WHERE `status` = 'queued' AND `message_id` IN (".$failedIds.") ";
			$this->db->query($updateQuryFailed);
		}
	}


	//Send Push Notification Using Cron 
	public function sendNotificationByCron(){		
		$sql = "SELECT am.device_id, am.formated_message, ad.device_token,ad.environment,am.os,am.client_id FROM apns_messages am
		 INNER JOIN apns_devices ad ON am.device_id = ad.device_id WHERE am.delivered_by_cron='Yes'
		  AND ad.status='active' AND am.status='queued' ORDER BY am.clientid LIMIT {$this->cronlimit}";
		$result = $this->db->query($sql);
		
		$deliverdIds = "";
		$failedIds = "";
		if($result->num_rows > 0){
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$pid = $row['device_id'];
				$message = $row['formated_message'];
				$token = $row['device_token'];
				$development=$row['environment'];
				$os= $row['os'];
				$clientId=$row['client_id'];
			
				if(strtolower($os) == 'android'){
					//Create Object of Android Push Class.
					$androdAPNS = new Android ( $this->db, $clientId );
					$retValue = $androdAPNS->pushFCMMessage($token, json_decode($message));
					
					if($retValue == "delivered"){
						$this->_udpateMessageStatus($pid, '');
					}else if($retValue == "failed"){
						$this->_udpateMessageStatus('',$pid);
					}
				}else if(strtolower($os) == 'ios'){
					//Create Object of iOS Push Class.
					$iOSAPNS = new APNS ( $this->db, $clientId );
					$retValue = $iOSAPNS->pushMessage($message,$token,$development);
					
					if($retValue == "delivered"){
						$this->_udpateMessageStatus($pid, '');
					}else if($retValue == "failed"){
						$this->_udpateMessageStatus('',$pid);
					}
				}				
			}
		}
	}
	
	

	/*
	//Send Push Notification
	public function sendNotification($message,$os,$clientIds,$senderId,$byCron='no',$sound = NULL,$customParam = NULL,$message_title = ''){
		
		if(!$sound){
			$sound='default';
		}
		$flag=false;
		
		//Insert records in apns master
		$insertQuery="INSERT INTO `apns_master` VALUES (NULL,'{$message_title}','{$message}',{$senderId},'".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')";
		$this->db->query($insertQuery);
		$apns_master_id=$this->db->insert_id;
		
		if(strtolower($os)==='android'){ //Send Push Message To Android Only
			if($this->_prepareMessageForAndroid($message,$apns_master_id,$clientIds,$senderId,$byCron,$sound,$customParam, $message_title)){
				$flag= true;
			}
		}else if(strtolower($os)==='ios'){ //Send Push Message to iOS Only
			if($this->_prepareMessageForiOS($message,$apns_master_id,$clientIds,$senderId,$byCron,$sound,$customParam,$message_title)){
				$flag= true;
			}
		}else if(strtolower($os)==='both'){ //Send Push Message to Both
			if($this->_prepareMessageForAndroid($message,$apns_master_id,$clientIds,$senderId,$byCron,$sound,$customParam,$message_title)){
				$flag= true;
			}
			if($this->_prepareMessageForiOS($message,$apns_master_id,$clientIds,$senderId,$byCron,$sound,$customParam,$message_title)){
				$flag= true;
			}
		}
		
		return $flag;
	}
	
	public function sendNotificationCustom($message,$os,$clientIds,$deviceTokens,$byCron='no',$sound = NULL,$customParam = NULL){
	
		if(!$sound){
			$sound='default';
		}
		$flag=false;
	
		//Insert records in apns master
		$insertQuery="INSERT INTO `apns_master` VALUES (NULL,'','{$message}',1,'".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')";
		$this->db->query($insertQuery);
		$apns_master_id=$this->db->insert_id;
	
		if(strtolower($os)==='android'){ //Send Push Message To Android Only
			if($this->_prepareMessageForAndroid($message,$apns_master_id,$clientIds,1,$byCron,$sound,$customParam,$deviceTokens)){
				$flag= true;
			}
		}else if(strtolower($os)==='ios'){ //Send Push Message to iOS Only
			if($this->_prepareMessageForiOS($message,$apns_master_id,$clientIds,1,$byCron,$sound,$customParam,$deviceTokens)){
				$flag= true;
			}
		}else if(strtolower($os)==='both'){ //Send Push Message to Both
			if($this->_prepareMessageForAndroid($message,$apns_master_id,$clientIds,1,$byCron,$sound,$customParam,$deviceTokens)){
				$flag= true;
			}
			if($this->_prepareMessageForiOS($message,$apns_master_id,$clientIds,1,$byCron,$sound,$customParam,$deviceTokens)){
				$flag= true;
			}
		}
	
		return $flag;
	}
	
	//Send Push Notification Using Cron 
	public function sendNotificationByCron(){		
		$sql = "SELECT am.pid, am.message, ad.devicetoken,ad.development,am.os,am.clientid FROM apns_messages am LEFT JOIN apns_devices ad ON am.fk_device = ad.pid WHERE am.delivered_by_cron='Yes' AND ad.status='active' AND am.status='queued' ORDER BY am.clientid LIMIT {$this->cronlimit}";
		$result = $this->db->query($sql);
		
		$deliverdIds = "";
		$failedIds = "";
		if($result->num_rows > 0){
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$pid = $row['pid'];
				$message = $row['message'];
				$token = $row['devicetoken'];
				$development=$row['development'];
				$os= $row['os'];
				$clientId=$row['clientid'];
			
				if(strtolower($os) == 'android'){
					//Create Object of Android Push Class.
					$androdAPNS = new Android ( $this->db, $clientId );
					$retValue = $androdAPNS->pushFCMMessage($token, json_decode($message));
					
					if($retValue == "delivered"){
						$this->_udpateMessageStatus($pid, '',$os);
					}else if($retValue == "failed"){
						$this->_udpateMessageStatus('',$pid,$os);
					}
				}else if(strtolower($os) == 'ios'){
					//Create Object of iOS Push Class.
					$iOSAPNS = new APNS ( $this->db, $clientId );
					$retValue = $iOSAPNS->pushMessage($message,$token,$development);
					
					if($retValue == "delivered"){
						$this->_udpateMessageStatus($pid, '',$os);
					}else if($retValue == "failed"){
						$this->_udpateMessageStatus('',$pid,$os);
					}
				}				
			}
		}
	}
	
	
	private function _prepareMessageForAndroid($message,$apns_master_id,$clientIds,$senderId,$byCron,$sound,$customParam,$deviceTokens=null, $messageTitle = ''){
		
		//Explode All Client Id
		$clientIdsArr=explode(',',$clientIds);
		
		foreach ($clientIdsArr as $clientId){
			//Insert Message in Master Table
			$this->db->query ( "SET NAMES 'utf8';" );	
			
			$sql = "SELECT * FROM apns_devices WHERE `os`='Android' AND `clientid` = '{$clientId}' AND `status`='active' AND `pushalert`='enabled'";
			if($deviceTokens != NULL){
				$sql .= " AND devicetoken = '$deviceTokens'";
			}
			
			$deviceResult=$this->db->query($sql);
			if($deviceResult->num_rows > 0){
				$pidArr=array();
				$userMessagesArr=array();
				while($deviceDetails=$deviceResult->fetch_array(MYSQLI_ASSOC)){
					$pid = $deviceDetails['pid'];
					$badgeCount = 	$deviceDetails['badge_count'];
					$pushBadge = $deviceDetails['pushbadge'];
					$pushSound = $deviceDetails['pushsound'];
					$pushVibrate = $deviceDetails['pushvibrate'];

					//Create Message for Android
					$customParam['clientid']=$clientId;
					$customParam['messageTitle']=$messageTitle;
					$messageArr = array ();
					$messageArr ['message'] = $message;
					if($pushBadge=='enabled'){
						$messageArr ['badge'] = ( int ) $badgeCount;
					}
					if($pushSound=='enabled'){
						$messageArr ['sound'] = ( string ) $sound;
					}
					if($pushVibrate=='enabled'){
						$messageArr ['vibrate'] = $pushVibrate;
					}
					if($customParam != NULL){
						$messageArr ['customParam'] = $customParam;
					}
						
					$pidArr[]=$pid;
					$userMessagesArr[$pid]=$messageArr;
				}
				
				//Queue Message to send Push Notification
				$messagesIdsArr=$this->_queueMessages($pidArr,$userMessagesArr,$byCron,$apns_master_id,'Android',$clientId);
				
				//If Delivery By Cron False than send push Message instantly
				if(strtolower($byCron)=='no'){
						
					//Create Object of Android Push Class.
					$androdAPNS = new Android ( $this->db, $clientId );
						
					$messagesIds = implode(',', $messagesIdsArr);
						
					$sql = "SELECT am.pid, am.message, ad.devicetoken FROM `apns_messages` am LEFT JOIN apns_devices ad ON am.fk_device = ad.pid WHERE am.pid IN (".$messagesIds.")";
					$result = $this->db->query($sql);
						
					$deliverdIds = "";
					$failedIds = "";
					while($row = $result->fetch_array(MYSQLI_ASSOC)) {
						$pid = $row['pid'];
						$messageText = json_decode($row['message']);
						$token = $row['devicetoken'];
							
						$retValue = $androdAPNS->pushFCMMessage($token, $messageText);
				
						if($retValue == "delivered"){
							$deliverdIds .=  $pid.",";
						}
						else if($retValue == "failed"){
							$failedIds .=  $pid.",";
						}
					}
					$deliverdIds = substr($deliverdIds, 0, -1);
					$failedIds = substr($failedIds, 0, -1);
						
					//Update Message Status
					$this->_udpateMessageStatus($deliverdIds, $failedIds,'Android');
				}
			}
		}
		return true;		
	}
	
	
	private function _prepareMessageForiOS($message,$apns_master_id,$clientIds,$senderId,$byCron,$sound,$customParam,$deviceTokens=null,$messageTitle = ''){
		//Explode All Client Id
		$clientIdsArr=explode(',',$clientIds);
	
		foreach ($clientIdsArr as $clientId){
			//Insert Message in Master Table
			$this->db->query ( "SET NAMES 'utf8';" );
							
			$sql = "SELECT * FROM apns_devices WHERE `os`='iOS' AND `clientid` = '{$clientId}' AND `status`='active' AND `pushalert`='enabled'";
			if($deviceTokens != NULL){
				$sql .= " AND devicetoken = '$deviceTokens'";
			}
			
			$deviceResult=$this->db->query($sql);
			if($deviceResult->num_rows > 0){
				$pidArr=array();
				$userMessagesArr=array();
				while($deviceDetails=$deviceResult->fetch_array(MYSQLI_ASSOC)){
					$pid = $deviceDetails['pid'];
					$badgeCount = 	$deviceDetails['badge_count'];
					$pushBadge = $deviceDetails['pushbadge'];
					$pushSound = $deviceDetails['pushsound'];
					$pushVibrate = $deviceDetails['pushvibrate'];
					$applicationMode = $deviceDetails['development'];
						
					//Create Message for Ios
					$messageArr = array ();
					$messageArr ['aps'] = array ();
					$messageArr ['aps'] ['clientid'] = $clientId;
					$messageArr ['aps'] ['messageTitle'] = $messageTitle;
					$messageArr ['aps'] ['alert'] = ( string ) $message;
					if($pushBadge=='enabled'){
						$messageArr ['aps'] ['badge'] = ( int ) $badgeCount;
					}
					if($pushSound=='enabled'){
						$messageArr ['aps'] ['sound'] = ( string ) $sound;
					}
					if($pushVibrate=='enabled'){
						$messageArr ['aps'] ['vibrate'] = $pushVibrate;
					}
					if($customParam != NULL){
						$messageArr ['customParam'] = $customParam;
					}
						
					$pidArr[]=$pid;
					$userMessagesArr[$pid]=$messageArr;
				}
	
				//Queue Message to send Push Notification
				$messagesIdsArr=$this->_queueMessages($pidArr,$userMessagesArr,$byCron,$apns_master_id,'iOS',$clientId);
	
				//If Delivery By Cron False than send push Message instantly
				if(strtolower($byCron)=='no'){
	
					//Create Object of iOS Push Class.
					$iOSAPNS = new APNS ( $this->db, $clientId );
	
					$messagesIds = implode(',', $messagesIdsArr);
	
					$sql = "SELECT am.pid, am.message, ad.devicetoken,ad.development FROM `apns_messages` am LEFT JOIN apns_devices ad ON am.fk_device = ad.pid WHERE am.pid IN (".$messagesIds.")";
					$result = $this->db->query($sql);
	
					$deliverdIds = "";
					$failedIds = "";
					while($row = $result->fetch_array(MYSQLI_ASSOC)) {
						$pid = $row['pid'];
						$messageText = $row['message'];
						$token = $row['devicetoken'];
						$development=$row['development'];
							
						$retValue = $iOSAPNS->pushMessage($messageText,$token,$development);
	
						if($retValue == "delivered"){
							$deliverdIds .=  $pid.",";
						}
						else if($retValue == "failed"){
							$failedIds .=  $pid.",";
						}
					}
					$deliverdIds = substr($deliverdIds, 0, -1);
					$failedIds = substr($failedIds, 0, -1);
	
					//Update Message Status
					$this->_udpateMessageStatus($deliverdIds, $failedIds,'iOS');
				}
			}
		}
		return true;
	}
	
	
	//Queue Push Messages for delivery
	private function _queueMessages1($deviceIdsArr, $messageArr, $byCron,$apns_master_id,$os,$clientid){
		
		//$deviceIdsArr=explode(',',$deviceIds);
		//$message = $this->db->prepare(json_encode($message));
		$this->db->query("SET NAMES 'utf8';");
	
		$msg_ids = array();
		$currentDateTime=date('Y-m-d H:i:s');
		for($i=0; $i<count($deviceIdsArr); $i++){
			$device = $deviceIdsArr[$i];
			$message = $this->db->prepare(json_encode($messageArr[$device]));
			$sql = "INSERT INTO `apns_messages`
			VALUES (
			NULL,
			'{$clientid}',
			'{$device}',
			'{$message}',
			'{$apns_master_id}',
			'{$currentDateTime}',
			'queued',
			'{$os}',
			'{$currentDateTime}',
			'{$currentDateTime}',
			'{$byCron}');";
			
			$this->db->query($sql);
			$msg_ids[] = $this->db->insert_id;
		}
		return $msg_ids;
	}
	
	// Update Message Status
	private function _udpateMessageStatus($deliverdIds, $failedIds,$os){	
		if(strlen($deliverdIds)) {
			$updateQuryDelivered = "UPDATE apns_messages SET `status` = 'delivered',`delivery` = '".date('Y-m-d H:i:s')."'
									WHERE `os` = '{$os}'
									AND `status` = 'queued'
									AND `pid` IN (".$deliverdIds.") ";
			$this->db->query($updateQuryDelivered);
		}
	
		if(strlen($failedIds)) {
			$updateQuryFailed = "UPDATE apns_messages SET `status` = 'failed',`delivery` = '".date('Y-m-d H:i:s')."'
									WHERE `os` = '{$os}'
									AND `status` = 'queued'
									AND `pid` IN (".$failedIds.") ";
		
			$this->db->query($updateQuryFailed);
		}
	}
	*/
}
?>