<?PHP
/**-- Created By Bhavik Desai
 * 18th Septmber 2018
 * -- */
/**
 * Begin Document
 */
class APNS {
	private $db;
	private $clientId;
	private $apnsData;
	private $showErrors = true;
	private $logErrors = false;
	private $logPath = 'application/third_party/apns/error_log';
	private $logMaxSize = 1048576; // max log size before it is truncated
	private $serverPath = ''; //CON_APP_STORAGE_PATH	
	//Production
	private $certificate = '';
	private $ssl = 'ssl://gateway.push.apple.com:2195';
	private $feedback = 'ssl://feedback.push.apple.com:2196';
	
	//Development
	private $sandboxCertificate = '';
	private $sandboxSsl = 'ssl://gateway.sandbox.push.apple.com:2195';
	private $sandboxFeedback = 'ssl://feedback.sandbox.push.apple.com:2196';
	
	
	private $message;
	private $deliverd_by_cron = "Yes";
	public $isContentAvailable = 'NO';
	
	public $fk_msg_master_id = '';
	
	function __construct($db, $clientId) {
		$this->db = $db;
		$this->clientId = $clientId;
		$this->_loadCertificate();
	}
	
	private function _loadCertificate(){
		// $qry="SELECT * FROM `tbl_application` WHERE `appIdentifier`='{$this->clientId}' AND `status`='active'";
		// $result=$this->db->query($qry);
		// if($result){
		// 	$details=$result->fetch_array(MYSQLI_ASSOC);
			
		// }
		$certificate=CON_UPLOAD_CERTIFICATE_PATH.PROD_CERTIFICATE;
		$sandboxCertificate=CON_UPLOAD_CERTIFICATE_PATH.DEV_CERTIFICATE;
		if (! empty ( $certificate ) && file_exists ( $certificate )) {
			$this->certificate = $certificate;
		}else{
			$this->_triggerError("Production Certificate not exists.");
		}
		
		if (! empty ( $sandboxCertificate ) && file_exists ( $sandboxCertificate )) {
			$this->sandboxCertificate = $sandboxCertificate;
		}else{
			$this->_triggerError("Sandbox Certificate not exists.");
		}
		
		
		$this->apnsData = array (
				'production' => array (
						'certificate' => $this->certificate,
						'ssl' => $this->ssl,
						'feedback' => $this->feedback
				),
				'sandbox' => array (
						'certificate' => $this->sandboxCertificate,
						'ssl' => $this->sandboxSsl,
						'feedback' => $this->sandboxFeedback
				)
		);
	}
	
	public function pushMessage($message, $token, $development) {
		$certificatePath = $this->apnsData [$development] ['certificate'];
		$retValue = "failed";
		$ctx = stream_context_create ();
		stream_context_set_option ( $ctx, 'ssl', 'local_cert', $certificatePath );
		$fp = stream_socket_client ( $this->apnsData [$development] ['ssl'], $error, $errorString, 60, (STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT), $ctx );
	
		if (! $fp) {
			$retValue = "failed";
			// $this->_triggerError("pushMessage: Fail to connect to socket client");
		} else {
			$msg = chr ( 0 ) . pack ( "n", 32 ) . pack ( 'H*', $token ) . pack ( "n", strlen ( $message ) ) . $message;
				
			$fwrite = fwrite ( $fp, $msg, strlen ( $msg ) );
			if (! $fwrite) {
				$retValue = "failed";
				// $this->_triggerError("pushMessage: Fail to write");
			}else{
				$retValue = "delivered";
				//$this->_triggerError("_pushMessage: Deliverd Success");
			}
		}
		if ($fp) {
			fclose ( $fp );
		}
		//Check FeedBack
		$this->_checkFeedback($development);
		return $retValue;
	}
	
	private function _checkFeedback($development) {
		$ctx = stream_context_create ();
		stream_context_set_option ( $ctx, 'ssl', 'local_cert', $this->apnsData [$development] ['certificate'] );
		stream_context_set_option ( $ctx, 'ssl', 'verify_peer', false );
		$fp = stream_socket_client ( $this->apnsData [$development] ['feedback'], $error, $errorString, 60, (STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT), $ctx );
					
		if (! $fp)
			//$this->_triggerError("Failed to connect to device: {$error} {$errorString}.");
		while ( $devcon = fread ( $fp, 38 ) ) {
			$arr = unpack ( "H*", $devcon );
			$rawhex = trim ( implode ( "", $arr ) );
			$token = substr ( $rawhex, 12, 64 );
			if (! empty ( $token )) {
				$this->_unregisterDevice ( $token );
				//$this->_triggerError("Unregistering Device Token: {$token}.");
			}
		}
		fclose ( $fp );
	}
	
	private function _unregisterDevice($token) {
		$sql = "UPDATE `apns_devices` SET `status`='uninstalled' WHERE `device_token`='{$token}' AND `client_id`='{$this->clientId}';";
		//$this->_triggerError("Update Query: {$sql}.");
		$this->db->query ( $sql );
	}
	
	private function _triggerError($error, $type = E_USER_NOTICE) {
		
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
