<?php
/*-- Created By Bhavik Desai
 * 18th Septmber 2018
 * -- */
class Android {
	
	private $db;
	private $clientId;
	private $GOOGLE_API_KEY = "";
	private $logErrors = false;
	private $logPath = 'application/third_party/apns/error_log';
	private $logMaxSize = 1048576; // max log size before it is truncated
	
	public function __construct($db, $clientId){
		$this->db = $db;
		$this->clientId = $clientId;
		$this->_loadAPIKey();
	}
	
	private function _loadAPIKey() {
		$this->GOOGLE_API_KEY = ANDROID_API_KEY;
		// $qry="SELECT `APIKey` FROM `tbl_application` WHERE `appIdentifier`='{$this->clientId}' AND `status`='active'";
		// $result=$this->db->query($qry);
		// if($result){
		// 	$details=$result->fetch_array(MYSQLI_ASSOC);
		// 	$this->GOOGLE_API_KEY=$details['APIKey'];
		// }
	}
	
	// send FCM message
	public function pushFCMMessage($token, $message) {
		$url = 'https://fcm.googleapis.com/fcm/send';
		$registatoinIds = array (
				$token 
		);
		$fields = array (
				'registration_ids' => $registatoinIds,
				'data' => $message 
		);
		
		$headers = array (
				'Authorization: key=' . $this->GOOGLE_API_KEY,
				'Content-Type: application/json' 
		);
		
		// Open connection
		$ch = curl_init ();
		
		// Set the url, number of POST vars, POST data
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		
		// Disabling SSL Certificate support temporarly
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode ( $fields ) );
		
		// Execute post
		$result = curl_exec ( $ch );
		$resultArr=json_decode($result,TRUE);
		if(!empty($resultArr)){
			if($resultArr['success']==1){
				$retValue = "delivered";
			}else{
				//$this->_triggerError("pushFCMMessage: ".json_encode($resultArr));
				$retValue = "failed";
				$resultErr=$resultArr['results'];
				foreach ($resultErr as $err){
					if (array_key_exists('error', $err)) {
						if($err['error']=='NotRegistered'){
							$this->_unregisterDevice($token);
						}
					}
				}
				/* if($resultArr['results'][0]['error']=='NotRegistered'){
					$this->_unregisterDevice($token);
				} */
			}
		}else{
			$retValue = "failed";
		}
		
		// Close connection
		curl_close ( $ch );
		return $retValue;
	}
	
	// send GCM message
	public function pushGCMMessage($token, $message) {
		$url = 'https://android.googleapis.com/gcm/send';
		$retValue = "delivered";
		$registatoinIds = array (
				$token 
		);
		
		$fields = array (
				'registration_ids' => $registatoinIds,
				'data' => $message 
		);
		
		$headers = array (
				'Authorization: key=' . $this->GOOGLE_API_KEY,
				'Content-Type: application/json' 
		);
		
		// Open connection
		$ch = curl_init ();
		
		// Set the url, number of POST vars, POST data
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		
		// Disabling SSL Certificate support temporarly
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode ( $fields ) );
		
		// Execute post
		$result = curl_exec ( $ch );
		
		if (! json_decode ( $result )) {
			$retValue = "failed";
		}
		
		// Close connection
		curl_close ( $ch );
		return $retValue;
	}
	
	private function _unregisterDevice($token) {
		$sql = "UPDATE `apns_devices` SET `status`='uninstalled' WHERE `device_token`='{$token}' AND `client_id`='{$this->clientId}';";
		//$this->_triggerError("Update Query: {$sql}.");
		$this->db->query ( $sql );
	}
	
	private function _triggerError($error, $type = E_USER_NOTICE) {
		// $backtrace = debug_backtrace ();
	
		// $backtrace = array_reverse ( $backtrace );
	
		// $error .= "\n";
		// $i = 1;
		// foreach ( $backtrace as $errorcode ) {
	
		// 	$file = ($errorcode ['file'] != '') ? "-> File: " . basename ( $errorcode ['file'] ) . " (line " . $errorcode ['line'] . ")" : "";
		// 	$error .= "\n\t" . $i . ") " . $errorcode ['function'] . " {$file}";
		// 	$i ++;
		// }
	
		$error .= "\n\n";
		if ($this->logErrors && file_exists ( $this->logPath )) {
			if (filesize ( $this->logPath ) > $this->logMaxSize)
				$fh = fopen ( $this->logPath, 'w' );
			else
				$fh = fopen ( $this->logPath, 'a' );
			fwrite ( $fh, $error );
			fclose ( $fh );
		}
	}

}
?>