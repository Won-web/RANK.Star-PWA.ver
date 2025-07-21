<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $message = "";
    public function __construct() {
        parent::__construct();
		// Load helper
        $this->load->library ( ["session"] );		
    }

    public function sendResponse($res_param = array(),$type = 'json'){
		if($type === 'json')
		{
			header('Content-Type: application/json');
			header('HTTP/1.0 200 OK');
            $updateResponse = $this->validateUpdate();
            $response = array_merge($res_param,$updateResponse);
			echo json_encode($response);
			exit();
		}
    }
    
    public function validateUpdate() {
        $update_button_title = lang('upgrade_btn_update');
        $skip_button_title = lang('upgrade_btn_skip');

        $os = $this->input->post('os');
        $version = $this->input->post('app_version');
        
        $iosForceUpdate = $androidForceUpdate = 'no';
        $iosVerDifferent = $androidVerDifferent ='no';
        $iosMsg = $androidMsg = lang('upgrade_upto_date_msg');

        if(!empty($os)){
            //Check iOS Update
            if(version_compare($version, IOS_APP_VERSION, '<') && strtolower($os) == 'ios'){
                $iosVerDifferent='yes';
                $iosMsg = lang('upgrade_not_upto_date_msg');
                //Check Force Update
                if(version_compare($version, FORCE_UPDATE_IOS_VERSION, '<')){
                    $iosForceUpdate = 'yes';
                }
            }

            //Check Android Update
            if(version_compare($version, ANDROID_APP_VERSION, '<') && strtolower($os) == 'android') {
                $androidVerDifferent='yes';
                $androidMsg = lang('upgrade_not_upto_date_msg');
                //Check Force Update
                if(version_compare($version, FORCE_UPDATE_ANDROID_VERSION, '<')){
                    $androidForceUpdate = 'yes';
                }
            }
        }
    
        $responseObj['upgrade'] = array (
            "iOS" => array (
                "isVersionDifferent" => $iosVerDifferent,
                "forceUpdateApp" => $iosForceUpdate,
                "MessageType" => $iosMsg,
                "URL" => IOS_URL,
                "update_button_title" =>$update_button_title,
                "skip_button_title" =>$skip_button_title
            ),
            "Android" => array (
                "isVersionDifferent" => $androidVerDifferent,
                "forceUpdateApp" => $androidForceUpdate,
                "MessageType" => $androidMsg,
                "URL" => ANDROID_URL,
                "update_button_title" => $update_button_title,
                "skip_button_title" => $skip_button_title
            )
        );
        return $responseObj;
    }

    public function setWebLanguage()
	{
		$site_lang = CON_DEFAULT_SITE_LANGUAGE;
		if($this->session->userdata('site_language'))
		{
			$site_lang = $this->session->userdata('site_language');
		}
		else
		{
			$this->session->set_userdata('site_language',CON_DEFAULT_SITE_LANGUAGE);
		}
		$this->load->language ( 'message', $site_lang );
		$this->config->set_item('language', $site_lang);
    }
    
    public function setLanguage($lang = '')
	{
		$site_lang = CON_DEFAULT_SITE_LANGUAGE;
		if(!empty($lang))
		{
			$site_lang = $lang;
		}
		$this->load->language ( 'message', $site_lang );
		$this->config->set_item('language', $site_lang);
    }

	protected function sendingMail($mail_to, $mail_subject, $mail_content) {
        $config = Array(
            'mailtype' => 'html',
            'protocol' => 'smtp',
            'smtp_host' => CON_SMTP_HOST,
            'smtp_port' => CON_SMTP_PORT,
            'smtp_user' => CON_SMTP_USERNAME,
            'smtp_pass' => CON_SMTP_PASSWORD,
            'smtp_crypto' => CON_SMTP_CRYPTO,
            'newline' => "\r\n"
        );

        $this->load->library('email', $config);
        // $this->email->set_header('MIME-Version','1.0');
        // $this->email->set_header('Content-type','text/html; charset=iso-8859-1');
        $this->email->from(CON_SMTP_FROM_MAIL_ADDRESS, CON_SMTP_FROM_NAME);
        $this->email->to($mail_to);
        $this->email->subject($mail_subject);
        $this->email->message($mail_content);
        //Send mail 
        if($this->email->send()) {
            return true;
        }
        else {
            echo $this->email->print_debugger();
            return false;
        }
    }
}
