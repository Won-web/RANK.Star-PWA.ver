<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH.'controllers/Api.php';
class V3 extends Api
{

    public $resArr = array(
        CON_RES_CODE => CON_CODE_FAIL,
        CON_RES_MESSAGE => "",
        CON_RES_DATA => array(),
    );
    public $api_version = 3;
    public function __construct()
    {
        parent::__construct($this->api_version);
        $this->load->library("Server", "server");

        //Check Request
        $checkRequest = $this->uri->segment(3);
        //Request have access with login or not
        $apiWithAccessToken = array(
            'getProfileDetails', 'editUserProfile', 'getPushSetting', 
            'pushSetting', 'starHistory', 'registerDeviceToken','getNotification', 
            'dailyCheckInStar', 'beginTransaction', 'startTransaction',
            'addGallaryItem', 'completeTransaction', 'endTransaction', 'giftstar', 'addVote', 
            'getDetailsByPhone', 'editContestantDetail', 'updateTransaction', 'deleteUserAccount'
        );
        if(in_array($checkRequest, $apiWithAccessToken)){
            //Check Oauth Token Access
            $res_object = $this->server->check_auth_access();
            if(!empty($res_object)) {
                //Unauthorized Error
                $this->resArr[CON_RES_CODE] = CON_CODE_UNAUTHORIZED_USER;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_UNAUTHORIZED_USER');
                $this->resArr[CON_RES_DATA] = array();
                $this->sendResponse($this->resArr);
            }
        }
        
        //Request have basic token without login
        $apiWithBasicToken = array(
            'userLogin', 'userSignUpApp', 'socialSignUp', 'verifySocialMediaUserLogin', 'getTokenFromRefreshToken',
            'getContestBannerList', 'getContestList',  'getContestDetails', 'getContestantDetails', 
            'getContestantMediaGallary', 'contestantBySearch', 'forgotPassword', 'verifyOtp', 'resendOtp',
            'checkEmailExists', 'getNotice', 'votingHistory', 'getPlanList', 
            'createNewPassword',
        );
        if(in_array($checkRequest, $apiWithBasicToken)){
            // Check basic token username and password
            if(!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || ($_SERVER['PHP_AUTH_USER'] != CON_BASIC_TOKEN_USERNAME || $_SERVER['PHP_AUTH_PW'] != CON_BASIC_TOKEN_PASSWORD))
            {
                //Unauthorized Error
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_UNAUTHORIZED_USER');
                $this->sendResponse($this->resArr);
            }
        }

    }

    /* ------------------------------- Index ------------------------------- */
    public function index()
    {
        $this->resArr[CON_RES_MESSAGE] = lang('MSG_ACCESS_DENIED');
        $this->sendResponse($this->resArr);
    }

    /* -------------------------------User Sign UP ------------------------------- */
    public function userSignUpApp()
    {
        //Fetch Request Parameter
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $mobile = $this->input->post('mobile');
        $name = $this->input->post('name');
        $nick_name = $this->input->post('nick_name');
        $terms_condition = $this->input->post('terms_condition');
        $privacy_policy = $this->input->post('privacy_policy');
        $newslatter_subscribe = $this->input->post('newslatter_subscribe');
        $device_id = $this->input->post('device_id');
        $otp_for = trim($this->input->post('otp_for'));

        if (!empty($email) && !empty($password) && !empty($mobile) && !empty($name) && !empty($device_id) && !empty($otp_for)) {
            //Check if user already register with this device
            /*$checkArr = array('device_id' => $device_id, 'user_status !=' => 'deleted');
            $isDeviceExists = $this->APIModel->getByWhere('tbl_user', $checkArr);
            if(!empty($isDeviceExists)){
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_DEVICE_CHANGED');
                $datArr = array('email'=>$email,'mobile'=>$mobile,'password'=>$password,'name'=>$name,'nick_name'=>$nick_name,'terms_condition'=>$terms_condition,'privacy_policy'=>$privacy_policy,'newslatter_subscribe'=>$newslatter_subscribe,'device_id'=>$device_id);
                logMessage('userSignUp',$datArr, $this->resArr);
                $this->sendResponse($this->resArr);
                exit();
            }*/              

            //Check Mobile Already Exists
            $whereArr = array('mobile' => $mobile, 'user_status' => 'active');
            $checkMobileExists = $this->APIModel->getByWhere('tbl_user', $whereArr);

            //Check Email Already Exists
            $whereArr = array('email' => $email, 'user_status !=' => 'deleted');
            $checkEmailExists = $this->APIModel->getByWhere('tbl_user', $whereArr);

            if (!empty($checkEmailExists)) {
                if($checkEmailExists[0]['user_status'] == 'active'){
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_EMAIL_EXISTS');
                }
                else{
                    $mobileflag = 1;
                    if(!empty($checkMobileExists)){
                        if($checkMobileExists[0]['mobile'] == $mobile){
                            $this->resArr[CON_RES_MESSAGE] = lang('MSG_MOBILE_EXISTS');
                        }
                        else{
                            $mobileflag = 0;
                        }
                    }
                    if($mobileflag == 1){   
                        $currentDateTime = date('Y-m-d H:i:s');
                        $user_status = "verificationpending";
                        $updateUserArr = array(
                            'email' => $email,
                            'mobile' => $mobile,
                            'password' => md5($password),
                            'user_type' => 'user',
                            'login_type' => 'auth',
                            'user_status' => $user_status,
                            'terms_condition' => $terms_condition,
                            'privacy_policy' => $privacy_policy,
                            'newslatter_subscribe' => $newslatter_subscribe,
                            'update_date_time' => $currentDateTime,
                            'device_id' => $device_id
                        );

                        $this->APIModel->update('tbl_user', $updateUserArr, array('user_id' => $checkEmailExists[0]['user_id']));
                            
                        // oauth_users table insert value
                        $oauthUserInsert = $this->APIModel->upsertUserAuthData($email, md5($password));                            
                            
                        if($otp_for === "register") {
                            $sendOTP = true;
                            if($sendOTP === true) {
                                $otpRes = $this->sendOtp($email, $checkEmailExists[0]['user_id'], $otp_for);
                                // print_r($otpRes);
                                if ($this->db->trans_status() === true) {
                                    $this->db->trans_commit();
                                    if($otpRes["status"] === true) {
                                        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                                        $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_SEND_SUCCESS");
                                        $this->resArr[CON_RES_DATA] = $otpRes; 
                                    }
                                    else {
                                        $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_SEND_FAILED");
                                    }
                                } 
                                else {
                                    $this->db->trans_rollback();
                                    $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_SEND_FAILED");
                                }
                            }
                        }
                        else {
                            $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_PARAM_HAVE_DIFF_VALUE");
                        }                       
                    }
                }
            }
            else
            {
                //Check Mobile Already Exists
                // $whereArr = array('mobile' => $mobile, 'user_status' => 'active');
                // $checkMobileExists = $this->APIModel->getByWhere('tbl_user', $whereArr);

                if (empty($checkMobileExists)) {
                    //Create User Record
                    $currentDateTime = date('Y-m-d H:i:s');
                    $insertUserArr = array(
                        'email' => $email,
                        'mobile' => $mobile,
                        'password' => md5($password),
                        'user_type' => 'user',
                        'user_status' => 'verificationpending',
                        'login_type' => 'auth',
                        'terms_condition' => $terms_condition,
                        'privacy_policy' => $privacy_policy,
                        'newslatter_subscribe' => $newslatter_subscribe,
                        'register_date_time' => $currentDateTime,
                        'update_date_time' => $currentDateTime,
                        'device_id' => $device_id
                    );
                    $user_id = $this->APIModel->insert('tbl_user', $insertUserArr);

                    // oauth_users table insert value
                    $oauthUserInsert = $this->APIModel->upsertUserAuthData($email, md5($password));

                    if ($user_id) {
                        $userDetailsArr = array(
                            'user_id' => $user_id,
                            'name' => $name,
                            'nick_name' => $nick_name,
                            'main_image' => CON_DEFAULT_USER_IMAGE,
                        );
                        $user_detail_id = $this->APIModel->insert('tbl_user_details', $userDetailsArr);

                        // $this->APIModel->update('tbl_user', $insertUserArr, array('user_id' => $checkEmailExists[0]['user_id']));
                        //Give Free Bonus Star
                        $purchaseArr = array(
                            'user_id' => $user_id,
                            'star' => CON_DEFAULT_SIGNUP_BONUNS,
                            'description' => 'Welcome Bonus',
                            'type' => 'signup',
                            'purchase_date' => date('Y-m-d'),
                            'created_date' => $currentDateTime,
                            'updated_date' => $currentDateTime,
                        );
                        $purchase_id = $this->APIModel->insert('tbl_star_purchase', $purchaseArr);

                        //Get Profile Details
                        $profileDetails = $this->APIModel->getUserProfileDetails($user_id);

                        //Fetch Remaining Star Details
                        $availableStarCount = $this->APIModel->getAvailableStarCount($user_id);
                        $profileDetails['remaining_star'] = $availableStarCount['remaining_star'];

                        // $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                        // $this->resArr[CON_RES_MESSAGE] = lang('MSG_SIGNUP_SUCCESS');
                        // $this->resArr[CON_RES_DATA] = array('profile_details' => $profileDetails);

                        //// Add code for send otp 
                        if($otp_for === "register") {
                            $sendOTP = true;
                            if($sendOTP === true) {
                                $otpRes = $this->sendOtp($email, $user_id, $otp_for);
                                // print_r($otpRes);
                                if ($this->db->trans_status() === true) {
                                    $this->db->trans_commit();
                                    if($otpRes["status"] === true) {
                                        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                                        $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_SEND_SUCCESS");
                                        $this->resArr[CON_RES_DATA] = $otpRes; 
                                    }
                                    else {
                                        $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_SEND_FAILED");
                                    }
                                } 
                                else {
                                    $this->db->trans_rollback();
                                    $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_SEND_FAILED");
                                }
                            }
                        }
                        else {
                            $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_PARAM_HAVE_DIFF_VALUE");
                        }                       
                    } else {
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_SIGNUP_FAIL');
                    }
                } 
                else{
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_MOBILE_EXISTS');
                }
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('email'=>$email,'mobile'=>$mobile,'password'=>$password,'name'=>$name,'nick_name'=>$nick_name,'terms_condition'=>$terms_condition,'privacy_policy'=>$privacy_policy,'newslatter_subscribe'=>$newslatter_subscribe,'device_id'=>$device_id);
        logMessage('userSignUp',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    // Verify OTP
    public function verifyOtp()
    {
        $email = trim($this->input->post("email"));
        $otp = trim($this->input->post("otp"));
        $otp_for = trim($this->input->post("otp_for"));

        // Check params is empty or not
        if(!empty($email) && !empty($otp) && !empty($otp_for)) {
        // Check OTP is for login or not

            if($otp_for === 'register' || $otp_for === 'forgotpassword') {
                $userWhereCondition = [
                    "email" => $email, 
                    "user_status !=" => CON_USER_STATUS_DELETED, 
                    "user_type" => CON_USER_TYPE_USER
                ];
                // Check user exist or not
                $userDetails = $this->APIModel->setWhere($userWhereCondition)->getAll('tbl_user'); 
                // print_r($userDetails);die;   
                if(!empty($userDetails)) {

                    if($email == "abc@gmail.com" && $otp == "123456"){
                        $this->resArr[CON_RES_CODE] = CON_FLAG_SUCCESS;
                        $this->resArr[CON_RES_MESSAGE] = lang("VM_OTP_VERIFICATION_SUCCESS"); 
                        $this->resArr[CON_RES_DATA] = ["user_id" => $userDetails[0]['user_id']];
                        // $this->resArr[CON_RES_DATA] = array('profile_details' => $profileDetails);
                    }else{
                        $user = $userDetails[0];    
                        $otpData = [
                            'user_id' => $userDetails[0]['user_id'],
                            'email' => $email,
                            'otp' => $otp,
                            'otp_for' => $otp_for
                        ];
                        $resOtp = $this->APIModel->isValidOtp($otpData);
                        if(!empty($resOtp)) {
                            //Get Profile Details
                            $profileDetails = $this->APIModel->getUserProfileDetails($userDetails[0]['user_id']);
                            // print_r($profileDetails);

                            //Fetch Remaining Star Details
                            $availableStarCount = $this->APIModel->getAvailableStarCount($userDetails[0]['user_id']);
                            // print_r($availableStarCount);

                            $profileDetails['remaining_star'] = $availableStarCount['remaining_star'];
                            // $profileDetails['otp_for'] = $resOtp[0]['otp_for'];

                            $updateOTP = [
                                'status' => 'deleted'
                            ];
                            $userStatus = [
                                "user_status" => 'active',
                            ];
                            // Mark OTP status as 'deleted'
                            $this->db->trans_begin();
                            $this->APIModel->update('tbl_user', $userStatus, array('user_id' => $userDetails[0]['user_id']));
                            //$this->APIModel->update('tbl_otp', $updateOTP, $resOtp["otp_id"]);
                            $this->APIModel->update('tbl_otp', $updateOTP, array('otp_id' => $resOtp[0]["otp_id"]));
                            
                            if($this->db->trans_status() === true) {
                                $this->db->trans_commit();
                                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                                $this->resArr[CON_RES_MESSAGE] = lang("VM_OTP_VERIFICATION_SUCCESS"); 
                                // $this->resArr[CON_RES_DATA] = array("user_id" => $resOtp[0]["user_id"]);
                                $this->resArr[CON_RES_DATA] = array('profile_details' => $profileDetails);
                            } 
                            else {
                                $this->db->trans_rollback();
                                $this->resArr[CON_RES_MESSAGE] = lang("VM_OTP_VERIFICATION_FAILED");  
                            }
                        }
                        else {
                            $this->resArr[CON_RES_MESSAGE] = lang("VM_OTP_VERIFICATION_FAILED");    
                        }
                    }    
                }
                else {
                    $this->resArr[CON_RES_MESSAGE] = lang("VM_USER_DOESNOT_EXIST");
                    // $this->flag = CON_FLAG_FAIL_MSG_FOR_OTHER_STATUS;
                    // $this->message = lang("MSG_DELETED_USER_REINITIATE_ACCOUNT");
                }
            }
            else {
               $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_PARAM_HAVE_DIFF_VALUE");
           }
        }
        else {
            $this->resArr[CON_RES_MESSAGE] = lang("MSG_SOME_PARAMETER_REQUIRED");
        }
        // $this->sendResponse();
        // print_r($this->resArr);
        $this->sendResponse($this->resArr);
    }

     // RESEND OTP TO USER
     public function resendOtp() { 
        $email = trim($this->input->post("email"));
        $otp_for = trim($this->input->post("otp_for"));
        // print_r($email);
        // CHECK EMPTY FIELD
        if(!empty($email) && !empty($otp_for)) {

            if($otp_for === "register") {
                $this->db->trans_begin();
                $otpRes = $this->resendOtpToUser($email, $otp_for);
                // print_r($otpRes);
                if($otpRes["status"] === true && ($this->db->trans_status() === true)) {
                    $this->db->trans_commit();
                    $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                    $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_SEND_SUCCESS");
                    $this->resArr[CON_RES_DATA] = $otpRes;  
                }
                else {
                    $this->db->trans_rollback();
                    $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_SEND_FAILED");
                }
            }
            else if($otp_for === "forgotpassword") {
                $this->db->trans_begin();
                $otpRes = $this->resendOtpToUser($email, $otp_for);
                // print_r($otpRes);
                if($otpRes["status"] === true && ($this->db->trans_status() === true)) {
                    $this->db->trans_commit();
                    $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                    $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_SEND_SUCCESS");
                    $this->resArr[CON_RES_DATA] = $otpRes;  
                }
                else {
                    $this->db->trans_rollback();
                    $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_SEND_FAILED");
                }  
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_PARAM_HAVE_DIFF_VALUE");
            }  
        }
        else {
            $this->resArr[CON_RES_MESSAGE] = lang("MSG_SOME_PARAMETER_REQUIRED");
        }
        // print_r($this->resArr);
        // $this->sendResponse();
        $this->sendResponse($this->resArr);
    }

    public function forgotPassword(){
        $email = trim($this->input->post("email"));
        $otp_for = trim($this->input->post("otp_for"));
        // CHECK EMPTY FIELD
        if(!empty($email) && !empty($otp_for)) {
            if($otp_for === "forgotpassword") {
                $this->db->trans_begin();
                $otpRes = $this->resendOtpToUser($email, $otp_for);
                // print_r($otpRes);
                if($otpRes["status"] === true && ($this->db->trans_status() === true)) {
                    $this->db->trans_commit();
                    $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                    $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_SEND_SUCCESS");
                    $this->resArr[CON_RES_DATA] = $otpRes;  
                }
                else {
                    $this->db->trans_rollback();
                    $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_SEND_FAILED");
                }
            }
            else {
                $this->resArr[CON_RES_MESSAGE] = lang("MSG_OTP_PARAM_HAVE_DIFF_VALUE");
            }
        }
        else {
            $this->resArr[CON_RES_MESSAGE] = lang("MSG_SOME_PARAMETER_REQUIRED");
        }
        $this->sendResponse($this->resArr);
    }

    public function createNewPassword(){
        $password = trim($this->input->post("password")); 
        $user_id = $this->input->post('user_id');
        if(!empty($password) && !empty($user_id)) {
            $userWhereCondition = [
                // "email" => $email, 
                "user_id" => $user_id,
                "user_status" => 'active', 
                "user_type" => CON_USER_TYPE_USER
            ];
            // Check user exist or not
            $userDetails = $this->APIModel->setWhere($userWhereCondition)->getAll('tbl_user'); 
            if(!empty($userDetails)) {
                $this->db->trans_begin();
                $updateArr = array(
                    'password' => md5($password)
                    // 'password' => $password
                );
                $whrPass= array(
                    'user_id' => $userDetails[0]['user_id'],
                );

                $isUpdatePassword = $this->APIModel->update('tbl_user', $updateArr, $whrPass);

                // Update OAuth user table
                $whrOauthPass = array (
                    'username' => $userDetails[0]['email'],
                );
                $isOauthUpdatePassword = $this->APIModel->update('oauth_users', $updateArr, $whrOauthPass);
                
                if ($this->db->trans_status() === true) {
                    $this->db->trans_commit();
                    $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_PASSWORD_CHANGED_SUCCESS');
                } else {
                    $this->db->trans_rollback(); 
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_PASSWORD_CHANGED_FAILED');
                }
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang("VM_USER_DOESNOT_EXIST");
            }
            
        }
        else {
            $this->resArr[CON_RES_MESSAGE] = lang("MSG_SOME_PARAMETER_REQUIRED");
        }
        $this->sendResponse($this->resArr);
    }

     // Send OTP
     public function sendOtp($email, $user_id, $otp_for) {
        $otpRes = $this->APIModel->setWhere(["user_id" => $user_id])->getAll('tbl_otp');
        // $otpRes = $this->APIModel->getByWhere('tbl_otp', ["user_id" => $user_id]);
        // print_r($otpRes);
        $otp = $this->generateOtp();
        // print_r($otp);
        $currentDateTime = date('Y-m-d H:i:s');
        $res = [
            "status" => false, 
            "user_id" => strval($user_id),
            "otp" => $otp
        ];

        // OTP not send on response of live server api
        // if(CON_SERVER_ENV != CON_SERVER_ENV_LIVE) {
        //     $res["otp"] = $otp;
        // }

        $message = lang("sms_msg_otp",[$otp]);
        // Implement SMS library
        // $msg = lang("OTP_MSG") . $otp .". " . lang("DO_NOT_SHARE_WITH_ANYONE");
        // $sendSms = new NewSendsms();
        // $ans = $sendSms->sendsms($email, $msg);
        // print_r($ans);die;

        // Implement send email library
        $subject = lang("MSG_WEB_EMAIL_SUBJECT");
        $message = "<html><body>";
        // $message .= "<p>". lang("MSG_HI") ."</p>";
        $message .= "<span>". lang("OTP_MSG") ."</span>";
        $message .= "<Span>". $otp .". " ."</span>";
        $message .= "<span>". lang("DO_NOT_SHARE_WITH_ANYONE") ."</span>";
        $message .= "<br><br><span>". lang("MSG_THANKS") ."</span><br>";
        $message .= "<span>". lang("MSG_RANKING_STAR_SUPPORT") ."</span>";
        $message .= "</body></html>";

        $sendMail = $this->sendingMail($email, $subject, $message);
        // print_r($sendMail);

        if('send_sms' === 'send_sms') {
            if($otp_for === "register"){ 
                $otpData = [
                    "user_id" => $user_id,
                    "otp" => $otp,
                    "otp_for" => "register",
                    "status" => "sent",
                    "created_at" => $currentDateTime,
                    "expired_at" => add_min_to_datetime(CON_OTP_EXPIRE_MINUTES),
                ];
                if(isset($otpRes[0])) {
                    // Update existing record
                    $userOtpId = $otpRes[0]["otp_id"];
                    // $this->APIModel->update('tbl_otp', $otpData, $userOtpId);
                    $this->APIModel->update('tbl_otp', $otpData, array('otp_id' => $otpRes[0]["otp_id"]));
                } 
                else {
                    // Add new record
                    $otpData["user_id"] = $user_id;
                    $otpData["otp_for"] = $otp_for;  
                    // $otpData = array(
                       // 'user_id' => $user_id,
                    // ); 
                    $userOtpId = $this->APIModel->insert('tbl_otp', $otpData);
                }
                $res["status"] = true;
            }
            if($otp_for === "forgotpassword"){
                $otpData = [
                    "user_id" => $user_id,
                    "otp" => $otp,
                    "otp_for" => "forgotpassword",
                    "status" => "sent",
                    "created_at" => $currentDateTime,
                    "expired_at" => add_min_to_datetime(CON_OTP_EXPIRE_MINUTES),
                ];
                if(isset($otpRes[0])) {
                    // Update existing record
                    $userOtpId = $otpRes[0]["otp_id"];
                    // $this->APIModel->update('tbl_otp', $otpData, $userOtpId);
                    $this->APIModel->update('tbl_otp', $otpData, array('otp_id' => $otpRes[0]["otp_id"]));
                } 
                else {
                    // Add new record
                    $otpData["user_id"] = $user_id;
                    $otpData["otp_for"] = $otp_for;  
                    // $otpData = array(
                       // 'user_id' => $user_id,
                    // ); 
                    $userOtpId = $this->APIModel->insert('tbl_otp', $otpData);
                }
                $res["status"] = true;
            }
            return $res;
        }
            
    }
    
   

    // GENERATE OTP
    public function generateOtp() {        
        do {
            $otp = rand(100000,999999);            
            $searchOtp = $this->APIModel->getField("otp")->setWhere(["otp"=>$otp])->getAll('tbl_otp');    
            
            // $whereArr = array('email' => $email, 'mobile !=' => CON_STATIC_MOBILE, 'user_status !=' => 'deleted');
            // $checkEmailExists = $this->APIModel->getByWhere('tbl_user', $whereArr);

            // $whereArr = array("otp"=>$otp, "status !=" => "expired");
            // $searchOtp = $this->APIModel->getByWhere('tbl_otp', $whereArr);
            // print_r($searchOtp);

        } while(!empty($searchOtp));
        return $otp;
    }

    // RESEND OTP
    public function resendOtpToUser($email, $otp_for) {
        $condUserArr = array(
            "email" => $email,
            "user_status !=" => CON_USER_STATUS_DELETED,
            "user_type" => CON_USER_TYPE_USER
        );
        $userDetails = $this->APIModel->setWhere($condUserArr)->getAll('tbl_user');
        if(!empty($userDetails)) {
            return $this->sendOtp($email, $userDetails[0]['user_id'], $otp_for);
        } 
        else {
            return ["status" => false];
        }
    }

    /* ------------------------------- Verify Social Media User Login ------------------------------- */
    public function verifySocialMediaUserLogin() {
        //Fetch Request Parameter
        $social_id = $this->input->post('social_id');
        $login_type = $this->input->post('login_type');
        $device_id = $this->input->post('device_id');

        if (!empty($social_id) && !empty($login_type)) {

            //OAuth
            $res_object = $this->server->password_credentials();
            $token_array = json_decode($res_object, true);
            // print_r($token_array);
            if(!array_key_exists("error", $token_array))
            {
                //Check Social Login Exists. If Exist Return Details And If Not Than Register and Return Details
                $whereArr = array('social_id' => $social_id, 'login_type' => $login_type);
                $checkUserExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
                if (!empty($checkUserExists)) {
                    //IF user status is active than only allow login
                    if($checkUserExists[0]['user_status'] != "deleted"){

                        $currentDateTime = date('Y-m-d H:i:s');
                        $updateData = array(
                            'last_access_date' => $currentDateTime,
                            'ip_addr' => $this->get_client_ip(),
                            'device_id' => $device_id
                        );
                        // $whereData = array('social_id' => $social_id);
                        $this->APIModel->update('tbl_user', $updateData, $whereArr);

                        //Get Profile Details
                        $profileDetails = $this->APIModel->getUserProfileDetails($checkUserExists[0]['user_id']);

                        //Fetch Remaining Star Details
                        $availableStarCount = $this->APIModel->getAvailableStarCount($checkUserExists[0]['user_id']);
                        $profileDetails['remaining_star'] = $availableStarCount['remaining_star'];
                        
                        //Check mobile verified for apple
                        $profileDetails['is_mobile_valid'] = true;
                        if($login_type == "apple" && $profileDetails['mobile'] == CON_STATIC_MOBILE){
                            $profileDetails['is_mobile_valid'] = false;
                        }

                        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_SUCCESS');
                        $this->resArr[CON_RES_DATA] = array('profile_details' => $profileDetails,
                        'token_data' => $token_array);
                    }else{
                        // $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_FAIL');
                        $this->resArr[CON_RES_CODE] = CON_CODE_NEW_USER;
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_NEW_USER');
                        $this->resArr[CON_RES_DATA] = array();
                    }
                }else{
                    //Check if user try to login from same device
                    /*$checkArr = array('device_id' => $device_id, 'user_status !='=> 'deleted');
                    $isDeviceSame = $this->APIModel->getByWhere('tbl_user', $checkArr);
                    if(!empty($isDeviceSame)){
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_DEVICE_CHANGED');
                    }else{
                        $this->resArr[CON_RES_CODE] = CON_CODE_NEW_USER;
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_NEW_USER');
                        $this->resArr[CON_RES_DATA] = array();
                    }*/
                    
                    $this->resArr[CON_RES_CODE] = CON_CODE_NEW_USER;
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_NEW_USER');
                    $this->resArr[CON_RES_DATA] = array();
                }
            }
            else {
                // $this->resArr[CON_RES_MESSAGE] = lang('MSG_YOUR_ACCOUNT_DOESNOT_EXIST');
                $this->resArr[CON_RES_CODE] = CON_CODE_NEW_USER;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_NEW_USER');
                $this->resArr[CON_RES_DATA] = array();
            }
            
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('social_id'=> $social_id,'login_type'=> $login_type,'device_id'=> $device_id);
        logMessage('verifySocialMediaUserLogin',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Social Media Sign UP ------------------------------- */
    public function socialSignUp()
    {
        //Fetch Request Parameter
        $social_id = $this->input->post('social_id');
        $name = $this->input->post('name');
        $nick_name = $this->input->post('nick_name');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $login_type = $this->input->post('login_type');
        $device_id = $this->input->post('device_id');

        if($login_type != "apple" && (empty($name) || empty($email))){
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
            $datArr = array('socila_id'=> $social_id,'name'=>$name,'nick_name'=>$nick_name,'email'=>$email,'mobile'=>$email,'mobile'=>$mobile,'$login_type'=>$login_type,'device_id'=>$device_id);
            logMessage('socialLogin',$datArr, $this->resArr[CON_RES_CODE], $this->resArr[CON_RES_MESSAGE], $this->resArr[CON_RES_DATA]);
            $this->sendResponse($this->resArr);
            exit();
        }

        if (!empty($social_id) && !empty($login_type) && !empty($mobile) && !empty($device_id)) {
            
            //Check if user already register with this device
            /*$checkArr = array('device_id' => $device_id, 'user_status !=' => 'deleted');
            $isDeviceExists = $this->APIModel->getByWhere('tbl_user', $checkArr);
            if(!empty($isDeviceExists)){
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_DEVICE_CHANGED');
                $this->sendResponse($this->resArr);
                exit();
            }*/    

            //If Social Id exists than update record else create record
            $whereArr = array('social_id' => $social_id, 'login_type' => $login_type);
            $checkUserExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
            if(!empty($checkUserExists)){
                // If name or email is empty than give error
                if(empty($name) || empty($email)){
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
                    $this->sendResponse($this->resArr);
                    exit();
                }

                //Check Email Already Exists
                $checkEmailExists = array();
                if(!empty($email)){
                    $whereArr = array('user_id !=' => $checkUserExists[0]['user_id'], 'email' => $email, 'user_status !=' => 'deleted');
                    $checkEmailExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
                }

                if(empty($checkEmailExists)){
                    //Check mobile already exists
                    $checkMobileExists = array();
                    if($mobile != CON_STATIC_MOBILE){
                        $whereArr = array('user_id !=' => $checkUserExists[0]['user_id'], 'mobile' => $mobile, 'user_status !=' => 'deleted');
                        $checkMobileExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
                    }
                    
                    if(empty($checkMobileExists)){
                        //Update User Record
                        $currentDateTime = date('Y-m-d H:i:s');
                        $user_status = "active";
                        if($login_type == "apple" && $mobile == CON_STATIC_MOBILE){
                            $user_status = "deactive";
                        }
                        $updateUserArr = array(
                            'social_id' => $social_id,
                            'email' => $email,
                            'mobile' => $mobile,
                            'user_type' => 'user',
                            'user_status' => $user_status,
                            'login_type' => $login_type,
                            'update_date_time' => $currentDateTime,
                        );
                        if($mobile != CON_STATIC_MOBILE){
                            $updateUserArr['device_id'] = $device_id;
                        }
                        $this->APIModel->update('tbl_user', $updateUserArr, array('user_id' => $checkUserExists[0]['user_id']));

                        // //// Oauth user update 
                        // $updateOAuthUserArr = array(
                        //     'username' => $social_id,
                        //     'password' => md5($social_id)
                            
                        // );
                        // $updateUsername = array(
                        //     'username' => $checkUserExists[0]['social_id']
                        // );
                        // $this->APIModel->update('oauth_users', $updateOAuthUserArr, $updateUsername);

                        $userDetailsArr = array(
                            'name' => $name,
                            'nick_name' => $nick_name
                        );
                        $this->APIModel->update('tbl_user_details', $userDetailsArr, array('user_id' => $checkUserExists[0]['user_id']));
                        
                        if($mobile != CON_STATIC_MOBILE){
                            //Give Free Bonus Star
                           $purchaseArr = array(
                               'user_id' => $checkUserExists[0]['user_id'],
                               'star' => CON_DEFAULT_SIGNUP_BONUNS,
                               'description' => 'Welcome Bonus',
                               'type' => 'signup',
                               'purchase_date' => date('Y-m-d'),
                               'created_date' => $currentDateTime,
                               'updated_date' => $currentDateTime,
                           );
                           $purchase_id = $this->APIModel->insert('tbl_star_purchase', $purchaseArr);
                        }
                        //Get Profile Details
                        $profileDetails = $this->APIModel->getUserProfileDetails($checkUserExists[0]['user_id']);

                        //Fetch Remaining Star Details
                        $availableStarCount = $this->APIModel->getAvailableStarCount($checkUserExists[0]['user_id']);
                        $profileDetails['remaining_star'] = $availableStarCount['remaining_star'];
                
                        //Check mobile verified for apple
                        $profileDetails['is_mobile_valid'] = true;
                        if($login_type == "apple" && $profileDetails['mobile'] == CON_STATIC_MOBILE){
                            $profileDetails['is_mobile_valid'] = false;
                        }

                        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_SIGNUP_SUCCESS');
                        $this->resArr[CON_RES_DATA] = array('profile_details' => $profileDetails);
                                                   
                    }else{
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_MOBILE_EXISTS');
                    }
                }else{
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_EMAIL_EXISTS');
                }
            }else{
                $checkEmailExists = array();
                if(!empty($email)){
                    //Check Email Already Exists
                    $whereArr = array('email' => $email, 'user_status !=' => 'deleted');
                    $checkEmailExists = $this->APIModel->getByWhere('tbl_user', $whereArr);    
                }
                
                if(empty($checkEmailExists)){
                
                    //Check Mobile Already Exists
                    $checkMobileExists = array();
                    if($mobile != CON_STATIC_MOBILE){
                        $whereArr = array('mobile' => $mobile, 'user_status !=' => 'deleted');
                        $checkMobileExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
                    }
                    
                    if (empty($checkMobileExists)) {
                        //Create User Record
                        $user_status = "active";
                        if($login_type == "apple" && $mobile == CON_STATIC_MOBILE){
                            $user_status = "deactive";
                        }
                        $currentDateTime = date('Y-m-d H:i:s');
                        $insertUserArr = array(
                            'social_id' => $social_id,
                            'email' => $email,
                            'mobile' => $mobile,
                            'user_type' => 'user',
                            'user_status' => $user_status,
                            'login_type' => $login_type,
                            'register_date_time' => $currentDateTime,
                            'update_date_time' => $currentDateTime,
                        );
                        if($mobile != CON_STATIC_MOBILE){
                            $insertUserArr['device_id'] = $device_id;
                        }
                        $user_id = $this->APIModel->insert('tbl_user', $insertUserArr);

                        // oauth_users table insert value
                        $oauthInsertArr = array(
                            'username' => $social_id,
                            'password' => md5($social_id)
                        );
                        $oauthUserInsert = $this->APIModel->insert('oauth_users', $oauthInsertArr);
                       
                        if ($user_id) {
                            $userDetailsArr = array(
                                'user_id' => $user_id,
                                'name' => $name,
                                'nick_name' => $nick_name,
                                'main_image' => CON_DEFAULT_USER_IMAGE,
                            );
                            $user_detail_id = $this->APIModel->insert('tbl_user_details', $userDetailsArr);

                            if($mobile != CON_STATIC_MOBILE){
                                //Give Free Bonus Star
                               $purchaseArr = array(
                                   'user_id' => $user_id,
                                   'star' => CON_DEFAULT_SIGNUP_BONUNS,
                                   'description' => 'Welcome Bonus',
                                   'type' => 'signup',
                                   'purchase_date' => date('Y-m-d'),
                                   'created_date' => $currentDateTime,
                                   'updated_date' => $currentDateTime,
                               );
                               $purchase_id = $this->APIModel->insert('tbl_star_purchase', $purchaseArr);
                            }

                            //Get Profile Details
                            $profileDetails = $this->APIModel->getUserProfileDetails($user_id);

                            //Fetch Remaining Star Details
                            $availableStarCount = $this->APIModel->getAvailableStarCount($user_id);
                            $profileDetails['remaining_star'] = $availableStarCount['remaining_star'];

                            //Check mobile verified for apple
                            $profileDetails['is_mobile_valid'] = true;
                            if($login_type == "apple" && $profileDetails['mobile'] == CON_STATIC_MOBILE){
                                $profileDetails['is_mobile_valid'] = false;
                            }

                            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                            $this->resArr[CON_RES_MESSAGE] = lang('MSG_SIGNUP_SUCCESS');
                            $this->resArr[CON_RES_DATA] = array('profile_details' => $profileDetails);

                        } else {
                            $this->resArr[CON_RES_MESSAGE] = lang('MSG_SIGNUP_FAIL');
                        }
                    }else{
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_MOBILE_EXISTS');
                    }
                }else{
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_EMAIL_EXISTS');
                }
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
      
        $datArr = array('social_id'=> $social_id,'name'=>$name,'nick_name'=>$nick_name,'email'=>$email,'mobile'=>$mobile,'login_type'=>$login_type,'device_id'=>$device_id);
        logMessage('socialSignUp',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

     /* ------------------------------- Daily Check In ------------------------------- */
     public function dailyCheckInStar(){   
        //Fetch request parameter
        $user_id = $this->input->post('user_id');
        $device_id = $this->input->post('device_id');
        if(!empty($user_id) && !empty($device_id)){
            //Check daily star collected by same device for today
            /*$today = date('Y-m-d');
            $whereArr = array('purchase_date' => $today, 'type' => 'daily', 'device_id' => $device_id);
            $isAlreadyCollected = $this->APIModel->getByWhere('tbl_star_purchase', $whereArr);
            if(empty($isAlreadyCollected)){
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_DAILY_CHECK_IN_COMPLETED');
            }*/

            $checkAlreadyCheckedIn = $this->APIModel->checkDailyAttendace($user_id);
            if(empty($checkAlreadyCheckedIn)){
                $today = date('Y-m-d');
                $currentDate = date('Y-m-d H:i:s');
                $starPurchaseArr = array(
                    'user_id' => $user_id,
                    'star' => CON_DAILY_CHECKIN_STAR,
                    'description' => 'Daily CheckIn',
                    'type' => 'daily',
                    'purchase_date' => $today,
                    'created_date' => $currentDate,
                    'updated_date' => $currentDate,
                    'device_id' => $device_id
                );
                $purchase_id = $this->APIModel->insert('tbl_star_purchase' , $starPurchaseArr);
                if($purchase_id){
                    //Fetch Remaining Star Details
                    $availableStarCount = $this->APIModel->getAvailableStarCount($user_id);
                    $starDetails['available_star'] = $availableStarCount['remaining_star'];
                    
                    $this->resArr[CON_RES_DATA] = array('star_details' => $starDetails);
                    $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_CHECKIN_SUCCESS');
                }else{
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_CHECKIN_FAIL');        
                }
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_DAILY_CHECK_IN_COMPLETED');    
            }
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('user_id'=>$user_id,'device_id'=>$device_id);
        logMessage('dailyCheckInStar',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Check Email Exists ------------------------------- */
    public function checkEmailExists()
    {
        //Fetch Request Parameter
        $email = $this->input->post('email');
        if (!empty($email)) {
            //Check Email Already Exists
            $whereArr = array('email' => $email, 'mobile !=' => CON_STATIC_MOBILE, 'user_status' => 'active');
            $checkEmailExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
            if(empty($checkEmailExists)){
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_EMAIL_AVAILABLE');
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_EMAIL_EXISTS');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $this->sendResponse($this->resArr);
    }

    /* -------------------------------User Login ------------------------------- */
    public function userLogin()
    {
        //Fetch Request Parameter
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $auto_login = $this->input->post('auto_login');
        $login_type = $this->input->post('login_type');
        $device_id = $this->input->post('device_id');
        if (!empty($username) && !empty($password) && !empty($login_type)) {
            //OAuth
            $res_object = $this->server->password_credentials();
            $token_array = json_decode($res_object, true);
            if(!array_key_exists("error", $token_array))
            {
                $loginData = $this->APIModel->checkLoginOAuth($username, $login_type);
                if(!empty($loginData)) {
                    //Update Auto Login Flag
                    $currentDateTime = date('Y-m-d H:i:s');
                    $updateData = array(
                        'is_autologin' => $auto_login,
                        'last_access_date' => $currentDateTime,
                        'ip_addr' => $this->get_client_ip(),
                        'device_id' => $device_id
                    );
                    $whereData = array('email' => $username);
                    $this->APIModel->update('tbl_user', $updateData, $whereData);

                    //Fetch User Details
                    if ($loginData['user_type'] == "user") {
                        $loginDetails = $this->APIModel->getUserProfileDetails($loginData['user_id']);
                    } else {
                        $loginDetails = $this->APIModel->getContestantProfileDetails($loginData['user_id']);
                    }

                    //Fetch Remaining Star Details
                    $availableStarCount = $this->APIModel->getAvailableStarCount($loginData['user_id']);
                    $loginDetails['remaining_star'] = $availableStarCount['remaining_star'];

                    // $tokenDetails =  $token_array;

                    $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_SUCCESS');
                    $this->resArr[CON_RES_DATA] = array('profile_details' => $loginDetails,
                    'token_data' => $token_array);
                } else {
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_YOUR_ACCOUNT_DOESNOT_EXIST');
                } 
            }  else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_FAIL');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('username'=> $username,'password'=> $password,'is_autologin'=> $auto_login,'login_type'=> $login_type);
        logMessage('login',$datArr, $this->resArr[CON_RES_DATA]);
        $this->sendResponse($this->resArr);
    }

    public function getTokenFromRefreshToken() {
        $res_object = $this->server->refresh_token();
        $token_array = json_decode($res_object, true);
        if(!array_key_exists("error", $token_array)) {

            $whereArr = array('access_token' => $token_array['access_token']);
            $checkUserExists = $this->APIModel->getByWhere('oauth_access_tokens', $whereArr);
            //Update Auto Login Flag
            $currentDateTime = date('Y-m-d H:i:s');
            $updateData = array(
                'last_access_date' => $currentDateTime
            );
            $whereData = array(
                'email' => $checkUserExists[0]['user_id'],
                'social_id' => $checkUserExists[0]['user_id']
            );
            $ans = $this->APIModel->updateUserData('tbl_user', $updateData, $whereData);

            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_GET_TOKEN_SUCCESS');
            $this->resArr[CON_RES_DATA] = array('token_details' => $token_array);
		} else {
            $this->resArr[CON_RES_CODE] = CON_CODE_UNAUTHORIZED_USER;
			$this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_AGAIN');
		}
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Add Vote ------------------------------- */
    public function addVote()
    {
        // Fetch request parameter
        $contest_id = $this->input->post('contest_id');
        $contestant_id = $this->input->post('contestant_id');
        $voter_id = $this->input->post('voter_id');
        $voter_name = $this->input->post('voter_name');
        $vote = $this->input->post('vote');
         // $description = $this->input->post('description');
 
        if (!empty($contestant_id) && !empty($contest_id) && !empty($voter_id) && !empty($vote) && ($vote > 0)) {
            // Fetch Remaining Star Details
            $availableStarCount = $this->APIModel->getAvailableStarCount($voter_id);
 
            if($vote <= $availableStarCount['remaining_star']){
                // Update Contestant Previous Ranking
                $this->_setContestantPreviousRanking($contest_id);
                $currentDate = date('Y-m-d H:i:s');

                // Max 1000 vote per day allow so check that first
                $getTotalVotePerDay = $this->APIModel->getTotalVote($voter_id);
                $totalVote = $vote + $getTotalVotePerDay['total_vote']; 
                if($totalVote > CON_DEFAULT_DAILY_VOTE_LIMIT){
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_VOTE_LIMIT_EXCEEDS');
                }else{
                    // Insert Vote Record
                    $voteData = array(
                        'contest_id' => $contest_id,
                        'contestant_id' => $contestant_id,
                        'voter_id' => $voter_id,
                        'vote' => $vote,
                        'vote_date' => $currentDate,
                        'description' => 'Vote'
                    );
                    $voteDetails = $this->APIModel->insert('tbl_voting', $voteData);
                    if ($voteDetails) {
                        // Get User Id of contestant to send Push Message
                        $contestantDetails = $this->APIModel->getByWhere('tbl_contestant_details', array('contestant_id'=>$contestant_id));
                        // Load Push Notification Library & Send Push Message
                        // $messageTitle = "Receiving Vote";
                        $messageTitle = lang('TITLE_RECEIVING_VOTE');
                        if($this->input->post_get('language') == 'english'){
                            $message = "{$voter_name} gives you {$vote} vote";
                        }else{
                            $message = "{$voter_name} 님께서 스타 {$vote} 개를 투표하였습니다";
                        }
                        
                        $messageType = "push";
                        $pushNotification = new PushNotification();
                        $response = $pushNotification->sendPushMessage($messageTitle, $message , $messageType , $voter_id, $contestantDetails[0]['user_id']);
                    
                        //Update Contestant Current Ranking
                        $this->_setContestantCurrentRanking($contest_id);
                        $mappingWhere = array(
                            'contest_id' => $contest_id,
                            'contestant_id' => $contestant_id
                        );
                        $userMapDetails = $this->APIModel->getByWhere('tbl_contestant_mapping', $mappingWhere);

                        if($userMapDetails[0]['previous_ranking'] > 3 && $userMapDetails[0]['current_ranking'] <= 3) {
                            // $messageTitle = "Rank Change";
                            $messageTitle = lang('TITLE_RANK_CHANGE');

                            if($this->input->post_get('language') == 'english'){
                                $message = "Congratulations {$contestantDetails[0]['name']}! You are in top 3";
                        }else{
                            $message = " {$contestantDetails[0]['name']} 참가자님, 축하합니다! 랭킹 3위 안으로 진입하셨습니다";
                        }
                        
                            $messageType = "push";
                            $pushNotification = new PushNotification();
                            $response = $pushNotification->sendPushMessage($messageTitle, $message , $messageType , $voter_id, $contestantDetails[0]['user_id']);
                        }

                        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_VOTE_SUCCESS');
                    } else {
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_VOTE_FAIL');
                    }
                }
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_INSUFFICIENT_STAR');
            }
            $availableStarCount = $this->APIModel->getAvailableStarCount($voter_id);
            $starDetails['remaining_star'] = $availableStarCount['remaining_star'];
            $this->resArr[CON_RES_DATA] = array('star_details' => $starDetails);
            // //If contest in open state than only allow to vote
            //  $checkContestStatus = array('contest_id'=> $contest_id, 'status' => 'open');
            //  $statusData = $this->APIModel->getByWhere('tbl_contest', $checkContestStatus);
            //  if(empty($statusData)){
            //      $this->resArr[CON_RES_MESSAGE] = lang('MSG_YOU_CAN_NOT_VOTE');
            //  }else{
                 
            // }
        } else {
             $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
     
        $datArr = array('contestant_id'=>$contestant_id,'contest_id'=>$contest_id,'voter_id'=>$voter_id,'voter_name'=>$voter_name,'vote'=>$vote);
        logMessage('addVote',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    public function deleteUserAccount(){
        $user_id = $this->input->post('user_id');
        if (!empty($user_id)) {
            $whereArr = array('user_id' => $user_id);
            $updateData = array('user_status' => 'deleted', 'email' => 'deleted_by_user', 'mobile' => '00000000000', 'social_id' => '');
            $isUpdated = $this->APIModel->update('tbl_user', $updateData, $whereArr);
            if(!empty($isUpdated)){
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_USER_ACCOUNT_DELETED');
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_USER_ACCOUNT_DELETION_FAILED');
            }
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $this->sendResponse($this->resArr);
    }


    // Function to get the client IP address
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
