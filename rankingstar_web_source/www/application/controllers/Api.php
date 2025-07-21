<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends MY_Controller
{

    public $resArr = array(
        CON_RES_CODE => CON_CODE_FAIL,
        CON_RES_MESSAGE => "",
        CON_RES_DATA => array(),
    );

    public $api_version = 1;
    public function __construct($api_version = 1)
    {
        parent::__construct();
        $this->setLanguage($this->input->post_get('language'));
        /*if($this->api_version == 1){
            $this->resArr[CON_RES_MESSAGE] = lang('upgrade_not_upto_date_msg');
            $this->sendResponse($this->resArr);
        }*/
        require_once APPPATH . "/third_party/apns/PushNotification.php";
        $this->load->model('Api_Model', 'APIModel');
    }

    /* ------------------------------- Index ------------------------------- */
    public function index()
    {
        $this->resArr[CON_RES_MESSAGE] = lang('MSG_ACCESS_DENIED');
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Under Construction ------------------------------- */
    public function underConstruction()
    {
        $this->load->view('under_construction');
    }


    /* ------------------------------- Terms & condition for sign up ------------------------------- */
    public function termsAndCondSignUp()
    {
        $this->load->view('terms_and_conditions_sign_up');
    }

    /* ------------------------------- Privacy policy for sign up ------------------------------- */
    public function privacyPolicyForSignUp()
    {
        $this->load->view('privacy_policy_for_sign_up');
    }

    /* ------------------------------- Under Construction ------------------------------- */
    public function contestWebView()
    {
        $contest_id = $this->input->get('contest_id');
        $data['contestDetails'] = $this->APIModel->getContestDetailsById($contest_id);
        $this->load->view('home_page_preview', $data);
    }

    /* ------------------------------- Home banner preview ------------------------------- */
    // public function homePagePreview()
    // {
    //     $contest_id = $this->input->get('contest_id');
    //     $data['contestDetails'] = $this->APIModel->getContestDetailsById($contest_id);
    //     $this->load->view('home_page_preview', $data);
    // }

    /* ------------------------------- Login ------------------------------- */
    public function login()
    {
        // $this->resArr[CON_RES_MESSAGE] = lang('MSG_UPDATE_APP');
        // $this->sendResponse($this->resArr);
        // exit();
        // $myfile = "newfile.txt";
        // if (file_exists($myfile)) {
        //     $fh = fopen($myfile, 'a');
        // } else {
        //     $fh = fopen($myfile, 'w');
        // }
        // $server_data = json_encode($_SERVER); 
        // fwrite($fh, $server_data."\n");
        // $request_data = json_encode($_REQUEST);
        // fwrite($fh, $request_data."\n\n\n");
        // fclose($fh);
        
        //Fetch Request Parameter
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $auto_login = $this->input->post('auto_login');
        $login_type = $this->input->post('login_type');
        // log_message('info','email:'.$email.'password:'.$password.'');
        if (!empty($email) && !empty($password) && !empty($login_type)) {
            
            //Check Login
            $loginData = $this->APIModel->checkLogin($email, $password, $login_type);
            if (!empty($loginData)) {
                //Update Auto Login Flag
                $updateData = array('is_autologin' => $auto_login);
                $whereData = array('email' => $email);
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
                
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_SUCCESS');
                $this->resArr[CON_RES_DATA] = array('profile_details' => $loginDetails);
                
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_FAIL');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('email'=> $email,'password'=> $password,'is_autologin'=> $auto_login,'login_type'=> $login_type);
        logMessage('login',$datArr,$this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* -------------------------------User Login ------------------------------- */
    public function userLogin()
    {
        //Fetch Request Parameter
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $auto_login = $this->input->post('auto_login');
        $login_type = $this->input->post('login_type');
        if (!empty($email) && !empty($password) && !empty($login_type)) {
            //Check Login
            $loginData = $this->APIModel->checkLogin($email, $password, $login_type);
            if (!empty($loginData)) {
                //Update Auto Login Flag
                $updateData = array('is_autologin' => $auto_login);
                $whereData = array('email' => $email);
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

                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_SUCCESS');
                $this->resArr[CON_RES_DATA] = array('profile_details' => $loginDetails);

            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_FAIL');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('email'=> $email,'password'=> $password,'is_autologin'=> $auto_login,'login_type'=> $login_type);
        logMessage('login',$datArr, $this->resArr[CON_RES_DATA]);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- User Login ------------------------------- */
    /*public function userLogin()
    {
        //Fetch Request Parameter
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $auto_login = $this->input->post('auto_login');
        $login_type = $this->input->post('login_type');
        $device_id = $this->input->post('device_id');

        if (!empty($email) && !empty($password) && !empty($login_type) && !empty($device_id)) {
            //Check if user try to login from same device
            $checkArr = array('email'=>$email, 'device_id' => $device_id);
            $isDeviceSame = $this->APIModel->getByWhere('tbl_user', $checkArr);
            if(!empty($isDeviceSame)){
                //Check Login
                $loginData = $this->APIModel->checkLogin($email, $password, $login_type);
                if (!empty($loginData)) {
                    //Update Auto Login Flag
                    $updateData = array('is_autologin' => $auto_login);
                    $whereData = array('email' => $email);
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

                    $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_SUCCESS');
                    $this->resArr[CON_RES_DATA] = array('profile_details' => $loginDetails);

                } else {
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_FAIL');
                }
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_DEVICE_CHANGED');
            }

        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $this->sendResponse($this->resArr);
    }*/

    /* ------------------------------- Get Profile Details ------------------------------- */
    public function getProfileDetails()
    {
        //Fetch Request Parameter
        $user_id = $this->input->post('user_id');
        $user_type = $this->input->post('user_type');
        if (!empty($user_id) && !empty($user_type)) {
            //Fetch User Details
            if ($user_type == "user") {
                $loginDetails = $this->APIModel->getUserProfileDetails($user_id);
            } else {
                $loginDetails = $this->APIModel->getContestantProfileDetails($user_id);
            }
            //Fetch Remaining Star Details
            $availableStarCount = $this->APIModel->getAvailableStarCount($user_id);
            $loginDetails['remaining_star'] = $availableStarCount['remaining_star'];

            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_SUCCESS');
            $this->resArr[CON_RES_DATA] = array('profile_details' => $loginDetails);
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('user_id'=> $user_id,'user_type'=> $user_type);
        logMessage('getProfileDetails',$datArr,$this->resArr[CON_RES_DATA]);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Check Email Exists ------------------------------- */
    public function checkEmailExists()
    {
        //Fetch Request Parameter
        $email = $this->input->post('email');
        if (!empty($email)) {
            //Check Email Already Exists
            $whereArr = array('email' => $email, 'mobile !=' => CON_STATIC_MOBILE, 'user_status !=' => 'deleted');
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

    /* ------------------------------- Verify Social Media Login ------------------------------- */
    public function verifySocialMediaLogin() {
        // $this->resArr[CON_RES_MESSAGE] = lang('MSG_UPDATE_APP');
        // $this->sendResponse($this->resArr);
        // exit();
        //Fetch Request Parameter
        $social_id = $this->input->post('social_id');
        $login_type = $this->input->post('login_type');

        if (!empty($social_id) && !empty($login_type)) {
            //Check Social Login Exists. If Exist Return Details And If Not Than Register and Return Details
            $whereArr = array('social_id' => $social_id, 'login_type' => $login_type);
            $checkUserExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
            if (!empty($checkUserExists)) {
                //IF user status is active than only allow login
                if($checkUserExists[0]['user_status'] != "deleted"){
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
                    $this->resArr[CON_RES_DATA] = array('profile_details' => $profileDetails);
                }else{
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_FAIL');
                }
            }else{
                $this->resArr[CON_RES_CODE] = CON_CODE_NEW_USER;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_NEW_USER');
                $this->resArr[CON_RES_DATA] = array();
            }
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('social_id'=> $social_id,'login_type'=> $login_type);
        logMessage('verifySocialMediaLogin',$datArr, $this->resArr);

        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Verify Social Media User Login ------------------------------- */
    public function verifySocialMediaUserLogin() {
        //Fetch Request Parameter
        $social_id = $this->input->post('social_id');
        $login_type = $this->input->post('login_type');
        $device_id = $this->input->post('device_id');

        if (!empty($social_id) && !empty($login_type)) {
            //Check Social Login Exists. If Exist Return Details And If Not Than Register and Return Details
            $whereArr = array('social_id' => $social_id, 'login_type' => $login_type);
            $checkUserExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
            if (!empty($checkUserExists)) {
                //IF user status is active than only allow login
                if($checkUserExists[0]['user_status'] != "deleted"){
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
                    $this->resArr[CON_RES_DATA] = array('profile_details' => $profileDetails);
                }else{
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_FAIL');
                }
            }else{
                //Check if user try to login from same device
                $checkArr = array('device_id' => $device_id, 'user_status !='=> 'deleted');
                $isDeviceSame = $this->APIModel->getByWhere('tbl_user', $checkArr);
                if(!empty($isDeviceSame)){
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_DEVICE_CHANGED');
                }else{
                    $this->resArr[CON_RES_CODE] = CON_CODE_NEW_USER;
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_NEW_USER');
                    $this->resArr[CON_RES_DATA] = array();
                }    
            }
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('social_id'=> $social_id,'login_type'=> $login_type,'device_id'=> $device_id);
        logMessage('verifySocialMediaUserLogin',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }
    /* ------------------------------- Verify Social Media User Login ------------------------------- */
    /*public function verifySocialMediaUserLogin() {
        //Fetch Request Parameter
        $social_id = $this->input->post('social_id');
        $login_type = $this->input->post('login_type');
        $device_id = $this->input->post('device_id');

        if (!empty($social_id) && !empty($login_type) && !empty($device_id)) {

             //Check Social Login Exists. If Exist Return Details And If Not Than Register and Return Details
             $whereArr = array('social_id' => $social_id, 'login_type' => $login_type);
             $checkUserExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
             if (!empty($checkUserExists)) {
                if($checkUserExists[0]['device_id'] == $device_id){
                    //IF user status is active than only allow login
                    if($checkUserExists[0]['user_status'] != "deleted"){
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
                        $this->resArr[CON_RES_DATA] = array('profile_details' => $profileDetails);
                    }else{
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_LOGIN_FAIL');
                    }
                }else{
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_DEVICE_CHANGED');
                }
             }else{
                //Check if user try to login from same device
                $checkArr = array('device_id' => $device_id, 'user_status !='=> 'deleted');
                $isDeviceSame = $this->APIModel->getByWhere('tbl_user', $checkArr);
                if(!empty($isDeviceSame)){
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_DEVICE_CHANGED');
                }else{
                    $this->resArr[CON_RES_CODE] = CON_CODE_NEW_USER;
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_NEW_USER');
                    $this->resArr[CON_RES_DATA] = array();
                }                
             }
           
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $this->sendResponse($this->resArr);
    }*/

    /* ------------------------------- Delete Social Media User ------------------------------- */
    public function deleteSocialMediaUser() {
        //Fetch Request Parameter
        $user_id = $this->input->post('user_id');
        
        $this->APIModel->delete('tbl_user_details', array('user_id'=>$user_id));
        $this->APIModel->delete('tbl_user', array('user_id'=>$user_id));

        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
        $this->resArr[CON_RES_MESSAGE] = "Social Login Deleted";
        $this->resArr[CON_RES_DATA] = array();
        $datArr = array('user_id'=> $user_id);
        logMessage('deleteSocialMediaUser',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Social Media Sign UP ------------------------------- */
    public function socialLogin()
    {
        // $this->resArr[CON_RES_MESSAGE] = lang('MSG_UPDATE_APP');
        // $this->sendResponse($this->resArr);
        // exit();
        //Fetch Request Parameter
        $social_id = $this->input->post('social_id');
        $name = $this->input->post('name');
        $nick_name = $this->input->post('nick_name');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $login_type = $this->input->post('login_type');

        if($login_type != "apple" && (empty($name) || empty($email))){
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
            $this->sendResponse($this->resArr);
            exit();
        }

        if (!empty($social_id) && !empty($login_type) && !empty($mobile)) {
            
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
                        $whereArr = array('user_id !=' => $checkUserExists[0]['user_id'], 'mobile' => $mobile , 'user_status !=' => 'deleted');
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
                        $this->APIModel->update('tbl_user', $updateUserArr, array('user_id' => $checkUserExists[0]['user_id']));

                        $userDetailsArr = array(
                            'name' => $name,
                            'nick_name' => $nick_name
                        );
                        $this->APIModel->update('tbl_user_details', $userDetailsArr, array('user_id' => $checkUserExists[0]['user_id']));

                        // if($mobile != CON_STATIC_MOBILE){
                        //      //Give Free Bonus Star
                        //     $purchaseArr = array(
                        //         'user_id' => $checkUserExists[0]['user_id'],
                        //         'star' => CON_DEFAULT_SIGNUP_BONUNS,
                        //         'description' => 'Welcome Bonus',
                        //         'type' => 'signup',
                        //         'purchase_date' => date('Y-m-d'),
                        //         'created_date' => $currentDateTime,
                        //         'updated_date' => $currentDateTime,
                        //     );
                        //     $purchase_id = $this->APIModel->insert('tbl_star_purchase', $purchaseArr);
                        // }
                       

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
                        $user_id = $this->APIModel->insert('tbl_user', $insertUserArr);
                        if ($user_id) {
                            $userDetailsArr = array(
                                'user_id' => $user_id,
                                'name' => $name,
                                'nick_name' => $nick_name,
                                'main_image' => CON_DEFAULT_USER_IMAGE,
                            );
                            $user_detail_id = $this->APIModel->insert('tbl_user_details', $userDetailsArr);

                            // if($mobile != CON_STATIC_MOBILE){
                            //     //Give Free Bonus Star
                            //     $purchaseArr = array(
                            //         'user_id' => $user_id,
                            //         'star' => CON_DEFAULT_SIGNUP_BONUNS,
                            //         'description' => 'Welcome Bonus',
                            //         'type' => 'signup',
                            //         'purchase_date' => date('Y-m-d'),
                            //         'created_date' => $currentDateTime,
                            //         'updated_date' => $currentDateTime,
                            //     );
                            //     $purchase_id = $this->APIModel->insert('tbl_star_purchase', $purchaseArr);
                            // }
                            

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
        $datArr = array('user_id'=> $user_id);
        logMessage('socialLogin',$datArr, $this->resArr);

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
            $checkArr = array('device_id' => $device_id, 'user_status !=' => 'deleted');
            $isDeviceExists = $this->APIModel->getByWhere('tbl_user', $checkArr);
            if(!empty($isDeviceExists)){
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_DEVICE_CHANGED');
                $this->sendResponse($this->resArr);
                exit();
            }    

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

    /* ------------------------------- Sign UP ------------------------------- */
    public function signup()
    {
        // $this->resArr[CON_RES_MESSAGE] = lang('MSG_UPDATE_APP');
        // $this->sendResponse($this->resArr);
        // exit();
        //Fetch Request Parameter
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $mobile = $this->input->post('mobile');
        $name = $this->input->post('name');
        $nick_name = $this->input->post('nick_name');
        $terms_condition = $this->input->post('terms_condition');
        $privacy_policy = $this->input->post('privacy_policy');
        $newslatter_subscribe = $this->input->post('newslatter_subscribe');

        if (!empty($email) && !empty($password) && !empty($mobile) && !empty($name)) {
            //Check Email Already Exists
            $whereArr = array('email' => $email , 'user_status !=' => 'deleted');
            $checkEmailExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
            if (empty($checkEmailExists)) {

                //Check Mobile Already Exists
                $whereArr = array('mobile' => $mobile , 'user_status !=' => 'deleted');
                $checkMobileExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
                if (empty($checkMobileExists)) {
                    //Create User Record
                    $currentDateTime = date('Y-m-d H:i:s');
                    $insertUserArr = array(
                        'email' => $email,
                        'mobile' => $mobile,
                        'password' => md5($password),
                        'user_type' => 'user',
                        'user_status' => 'active',
                        'login_type' => 'auth',
                        'terms_condition' => $terms_condition,
                        'privacy_policy' => $privacy_policy,
                        'newslatter_subscribe' => $newslatter_subscribe,
                        'register_date_time' => $currentDateTime,
                        'update_date_time' => $currentDateTime,
                    );
                    $user_id = $this->APIModel->insert('tbl_user', $insertUserArr);
                    if ($user_id) {
                        $userDetailsArr = array(
                            'user_id' => $user_id,
                            'name' => $name,
                            'nick_name' => $nick_name,
                            'main_image' => CON_DEFAULT_USER_IMAGE,
                        );
                        $user_detail_id = $this->APIModel->insert('tbl_user_details', $userDetailsArr);

                        // //Give Free Bonus Star
                        // $purchaseArr = array(
                        //     'user_id' => $user_id,
                        //     'star' => CON_DEFAULT_SIGNUP_BONUNS,
                        //     'description' => 'Welcome Bonus',
                        //     'type' => 'signup',
                        //     'purchase_date' => date('Y-m-d'),
                        //     'created_date' => $currentDateTime,
                        //     'updated_date' => $currentDateTime,
                        // );
                        // $purchase_id = $this->APIModel->insert('tbl_star_purchase', $purchaseArr);

                        //Get Profile Details
                        $profileDetails = $this->APIModel->getUserProfileDetails($user_id);

                        //Fetch Remaining Star Details
                        $availableStarCount = $this->APIModel->getAvailableStarCount($user_id);
                        $profileDetails['remaining_star'] = $availableStarCount['remaining_star'];

                        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_SIGNUP_SUCCESS');
                        $this->resArr[CON_RES_DATA] = array('profile_details' => $profileDetails);

                    } else {
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_SIGNUP_FAIL');
                    }
                }else{
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_MOBILE_EXISTS');
                }
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_EMAIL_EXISTS');
            }

        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
     
        $datArr = array('email'=>$email,'mobile'=>$mobile,'password'=>$password,'name'=>$name,'nick_name'=>$nick_name,'terms_condition'=>$terms_condition,'privacy_policy'=>$privacy_policy,'newslatter_subscribe'=>$newslatter_subscribe);
        logMessage('signup',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* -------------------------------User Sign UP ------------------------------- */
    public function userSignUp()
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

        if (!empty($email) && !empty($password) && !empty($mobile) && !empty($name) && !empty($device_id)) {
            //Check if user already register with this device
            $checkArr = array('device_id' => $device_id, 'user_status !=' => 'deleted');
            $isDeviceExists = $this->APIModel->getByWhere('tbl_user', $checkArr);
            if(!empty($isDeviceExists)){
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_DEVICE_CHANGED');
                $datArr = array('email'=>$email,'mobile'=>$mobile,'password'=>$password,'name'=>$name,'nick_name'=>$nick_name,'terms_condition'=>$terms_condition,'privacy_policy'=>$privacy_policy,'newslatter_subscribe'=>$newslatter_subscribe,'device_id'=>$device_id);
                logMessage('userSignUp',$datArr, $this->resArr);
                $this->sendResponse($this->resArr);
                exit();
            }              

            //Check Email Already Exists
            $whereArr = array('email' => $email, 'user_status !=' => 'deleted');
            $checkEmailExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
            if (empty($checkEmailExists)) {

                //Check Mobile Already Exists
                $whereArr = array('mobile' => $mobile, 'user_status !=' => 'deleted');
                $checkMobileExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
                if (empty($checkMobileExists)) {
                    //Create User Record
                    $currentDateTime = date('Y-m-d H:i:s');
                    $insertUserArr = array(
                        'email' => $email,
                        'mobile' => $mobile,
                        'password' => md5($password),
                        'user_type' => 'user',
                        'user_status' => 'active',
                        'login_type' => 'auth',
                        'terms_condition' => $terms_condition,
                        'privacy_policy' => $privacy_policy,
                        'newslatter_subscribe' => $newslatter_subscribe,
                        'register_date_time' => $currentDateTime,
                        'update_date_time' => $currentDateTime,
                        'device_id' => $device_id
                    );
                    $user_id = $this->APIModel->insert('tbl_user', $insertUserArr);
                    if ($user_id) {
                        $userDetailsArr = array(
                            'user_id' => $user_id,
                            'name' => $name,
                            'nick_name' => $nick_name,
                            'main_image' => CON_DEFAULT_USER_IMAGE,
                        );
                        $user_detail_id = $this->APIModel->insert('tbl_user_details', $userDetailsArr);

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

                        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_SIGNUP_SUCCESS');
                        $this->resArr[CON_RES_DATA] = array('profile_details' => $profileDetails);

                    } else {
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_SIGNUP_FAIL');
                    }
                }else{
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_MOBILE_EXISTS');
                }
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_EMAIL_EXISTS');
            }

        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('email'=>$email,'mobile'=>$mobile,'password'=>$password,'name'=>$name,'nick_name'=>$nick_name,'terms_condition'=>$terms_condition,'privacy_policy'=>$privacy_policy,'newslatter_subscribe'=>$newslatter_subscribe,'device_id'=>$device_id);
        logMessage('userSignUp',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Edit User Profile ------------------------------- */
    public function editUserProfile()
    {
        //Fetch Request Parameter
        $user_id = $this->input->post('user_id');
        $user_type = $this->input->post('user_type');
        $name = $this->input->post('name');
        $nick_name = $this->input->post('nick_name');
        $mobile = $this->input->post('mobile');
        $email = $this->input->post('email');
        $current_password = $this->input->post('current_password');
        $password = $this->input->post('password');
    
        if (!empty($user_id) && !empty($user_type)) {
            //Check Email Already Exists
            $checkEmailExists = array();
            if(!empty($email)){
                $whereArr = array('user_id !=' => $user_id, 'email' => $email, 'user_status !=' => 'deleted');
                $checkEmailExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
            }
            
            if (empty($checkEmailExists)) {
                //Check Mobile Already Exists
                $checkMobileExists = array();
                if(!empty($mobile)){
                    $whereArr = array('user_id !=' => $user_id, 'mobile' => $mobile, 'user_status !=' => 'deleted');
                    $checkMobileExists = $this->APIModel->getByWhere('tbl_user', $whereArr);
                }
                if (empty($checkMobileExists)) {
                     //Check Old Password is correct
                    $checkPasswordValid = array('is_valid' => true);
                    if(!empty($current_password)){
                        $whereArr = array('password' => md5($current_password), 'user_id' => $user_id);
                        $checkPasswordValid = $this->APIModel->getByWhere('tbl_user', $whereArr);
                    }
                    if(!empty($checkPasswordValid)){
                        //Update User Table Data
                        $userDataUpdate = array();
                        if (!empty($password)) {
                            $userDataUpdate['password'] = md5($password);
                        }
                        if (!empty($mobile)) {
                            $userDataUpdate['mobile'] = $mobile;
                        }
                        if (!empty($email)) {
                            $userDataUpdate['email'] = $email;
                        }
                        if (!empty($userDataUpdate)) {
                            $this->APIModel->update('tbl_user', $userDataUpdate, array('user_id' => $user_id));
                        }
                        
                        //// Oauth user update 
                        $updateOAuthUserArr = array(
                            'username' => $email,
                            'password' => md5($password)
                            
                        );
                        $updateUsername = array(
                            'username' => $checkPasswordValid[0]['email']
                        );
                        $this->APIModel->update('oauth_users', $updateOAuthUserArr, $updateUsername);
                        
                        //Update User Details / Contestant Details Table
                        $userDetailsData = array();
                        if (!empty($nick_name)) {
                            $userDetailsData['nick_name'] = $nick_name;
                        }
                        if (!empty($name)) {
                            $userDetailsData['name'] = $name;
                        }
                        if (!empty($userDetailsData)) {
                            if ($user_type == "user") {
                                $this->APIModel->update('tbl_user_details', $userDetailsData, array('user_id' => $user_id));
                            } else {
                                $this->APIModel->update('tbl_contestant_details', $userDetailsData, array('user_id' => $user_id));
                            }
                        }

                        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_PROFILE_EDIT_SUCCESS');
                        $this->resArr[CON_RES_DATA] = array();
                    }else{
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_PASSWORD_MISMATCH');
                    }
                }else{
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_MOBILE_EXISTS');
                }
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_EMAIL_EXISTS');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
       

        $datArr = array('user_id'=>$user_id,'user_type'=>$user_type,'password'=>$password,'name'=>$name,'nick_name'=>$nick_name,'email'=>$email,'mobile'=>$mobile,'current_password'=>$current_password,'password'=>$password);
        logMessage('editUserProfile',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Push Setting ------------------------------- */
    public function pushSetting()
    {
        //Fetch Request Parameter
        $user_id = $this->input->post('user_id');
        $push_alert = $this->input->post('push_alert');
        $push_sound = $this->input->post('push_sound');
        $push_vibrate = $this->input->post('push_vibrate');

        if (!empty($user_id)) {
            //Update Push Alert
            $pushUpdateData = array();
            if (!empty($push_alert)) {
                $pushUpdateData['push_alert'] = $push_alert;
            }
            if (!empty($push_sound)) {
                $pushUpdateData['push_sound'] = $push_sound;
            }
            if (!empty($push_vibrate)) {
                $pushUpdateData['push_vibrate'] = $push_vibrate;
            }
            
            if (!empty($pushUpdateData)) {
                $this->APIModel->update('apns_devices', $pushUpdateData, array('user_id' => $user_id));
            }

            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_SETTING_SAVE_SUCCESS');
            $this->resArr[CON_RES_DATA] = array();
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('user_id'=>$user_id,'push_alert'=>$push_alert,'push_sound'=>$push_sound,'push_vibrate'>$push_vibrate);
        logMessage('pushSetting',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Push Setting ------------------------------- */
    public function getPushSetting()
    {
        //Fetch Request Parameter
        $user_id = $this->input->post('user_id');

        if (!empty($user_id)) {
            $pushSetting = $this->APIModel->getPushSetting($user_id);
            if(!empty($pushSetting)){
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_SETTING_FOUND');
                $this->resArr[CON_RES_DATA] = array('push_setting' => $pushSetting);
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_SETTING_NOT_FOUND');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('user_id'=>$user_id);
        logMessage('getPushSetting',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }
    
    /* ------------------------------- Get Contest Banner List for Slider ------------------------------- */
    public function getContestBannerList()
    {
        //Give List Of Contest Banner with Open and Scheduling Contest
        $contestBannerList = $this->APIModel->getBannerList();
        foreach ($contestBannerList as $key => $value) {
           if($contestBannerList[$key]['show_main_banner'] === 'false'){
                $contestBannerList[$key]['main_banner'] = "";
               

           }
        }
       
        if (!empty($contestBannerList)) {
            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_BANNER_LIST');
            $this->resArr[CON_RES_DATA] = array('banner_list' => $contestBannerList);
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_BANNER_NOT_FOUND');
        }
        $datArr = array('contestBannerList'=>$contestBannerList);
        logMessage('getContestBannerList',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Get Contest List with pagination and searching -------------------------------*/
    public function getContestList()
    {
        //Fetch Request Parameter
        $page = $this->input->post('page');
        if (empty($page)) {
            $page = 1;
        }
        $hasMorePage = false;

        //Give List Of Contest
        $contestList = $this->APIModel->getContestList($page);

        // adding status label
        foreach($contestList as $key=>$value) {
            $contestList[$key]['status_label'] = lang($value['status']);
        }
            
        $hasMorePageData = $this->APIModel->getContestList($page + 1);
        if (!empty($hasMorePageData)) {
            $hasMorePage = true;
        }
        if (!empty($contestList)) {
            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_CONTEST_LIST');
            $this->resArr[CON_RES_DATA] = array('contest_list' => $contestList, 'has_more_page' => $hasMorePage);
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_CONTEST_LIST_NOT_FOUND');
        }
        $datArr = array('page'=>$page);
        logMessage('getContestList',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    public function deleteContest() {
        $contestId = $this->input->post('contestId');
        $updateData = array(
            'status' => 'delete'
        );
        $where = array(
            'contest_id' => $contestId
        );
        $contestList = $this->APIModel->update('tbl_contest', $updateData ,$where);
        if (!empty($contestList)) {
            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_CONTEST_DELETED');
            $this->resArr[CON_RES_DATA] = array();
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_CONTEST_DELETED_FAIL');
        }
        $datArr = array('contestId'=>$contestId);
        logMessage('deleteContest',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    // delete contestant 

    public function deleteContestant(){
        $contestantId = $this->input->post('contestantId');
         $contestantWhr = array('contestant_id' => $contestantId);
         $contestantDetail = $this->APIModel->getByWhere('tbl_contestant_details',$contestantWhr);
         $userId = $contestantDetail[0]['user_id'];
          
        $contestantUpdateArr = array('status' => 'deleted');
        $contestantUpdate = $this->APIModel->update('tbl_contestant_details', $contestantUpdateArr, $contestantWhr);
        if($contestantUpdate == 1){
           $userWhr = array('user_id'=> $userId);
           $userUpdateArr = array('user_status' => 'deleted');
           $userUpdate = $this->APIModel->update('tbl_user', $userUpdateArr, $userWhr);
           if($userUpdate == 1){
            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_CONTESTANT_DELETED');
            $this->resArr[CON_RES_DATA] = array();
           }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_CONTESTANT_DELETED_FAIL');

           }
        }  else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_CONTESTANT_DELETED_FAIL');
        }
        $datArr = array('contestantId'=>$contestantId);
        logMessage('deleteContestant',$datArr, $this->resArr);     
        $this->sendResponse($this->resArr);
        
    }
    // delete notice 
    public function deleteNotice() {
        $noticeId = $this->input->post('noticeId');
        $updateData = array(
            'status' => 'deactive'
        );
        $where = array(
            'notice_id' => $noticeId
        );
        $result = $this->APIModel->update('tbl_notice', $updateData ,$where);
        if (!empty($result)) {
            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_NOTICE_DELETED');
            $this->resArr[CON_RES_DATA] = array();
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_NOTICE_DELETED_FAIL');
        }
        $datArr = array('noticeId'=>$noticeId);
        logMessage('deleteNotice',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Get contestant with searching and paging -------------------------------*/
    public function contestantBySearch()
    {
        //Fetch Request Parameter
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        if (empty($page)) {
            $page = 1;
        }
        $hasMorePage = false;

        if (!empty($searchTerm)) {
            //Give List Of Contest
            $contestantList = $this->APIModel->getContestantBySearch($page, $searchTerm);
            $hasMorePageData = $this->APIModel->getContestantBySearch($page + 1, $searchTerm);
            if (!empty($hasMorePageData)) {
                $hasMorePage = true;
            }
            if (!empty($contestantList)) {
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_SEARCH_FOUND');
                $this->resArr[CON_RES_DATA] = array('contestant_list' => $contestantList, 'has_more_page' => $hasMorePage);
            } else {
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_SEARCH_NOT_FOUND');
                $this->resArr[CON_RES_DATA] = array('contestant_list' => array(), 'has_more_page' => $hasMorePage);
                
            }
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('searchTerm'=>$searchTerm);
        logMessage('contestantBySearch',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Get Contest Details BY Id ------------------------------- */
    public function getContestDetails()
    {
        //Fetch Request Parameter
        $contest_id = $this->input->post('contest_id');
        // print_r($contest_id);
        // $category_id = $this->input->post('category_id');
        if (!empty($contest_id)) {
            //Get Contest Details with contestant and ranking
            $resArr = array();
            $contestDetails = $this->APIModel->getContestDetailsById($contest_id);
          
            // print_r($contestDetails);
            if (!empty($contestDetails)) {
                $contestDetails[0]['web_page_url'] = CON_NOTICE_WEB_VIEW_URL. $contestDetails[0]['web_page_url'] . $contest_id;
                // $contestDetails[0]['home_page_url'] = BASE_URL . $contestDetails[0]['home_page'] . $contest_id;
                $resArr['contest_details'] = $contestDetails;
                $params = Array(
                    'contest_id' => $contest_id,
                    // 'category_id' => $category_id
                );
                //Fetch Contestant List, Total Vote Count
                $contestantRanking = $this->APIModel->getContestantRankingByContest($params);
                $categoryList = $this->APIModel->getCategoryItems($contest_id);
                $resArr['contestant_details'] = $contestantRanking;
                $resArr['categoryItems'] = $categoryList;
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_CONTEST_DETAILS');
                $this->resArr[CON_RES_DATA] = $resArr;
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_CONTEST_NOT_FOUND');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('contest_id'=>$contest_id);
        logMessage('getContestDetails',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Get Contestant Details By Id ------------------------------- */
    public function getContestantDetails()
    {
        //Fetch Request Parameter
        $contestant_id = $this->input->post('contestant_id');
        $contest_id = $this->input->post('contest_id');
        if (!empty($contestant_id) && !empty($contest_id)) {
            //Get Contestant Details
            $resArr = array();
            $contestantDetails = $this->APIModel->getContestantDetailsById($contestant_id, $contest_id);
          
            if (!empty($contestantDetails)) {
                $profile2 = json_decode($contestantDetails[0]['profile_2'], TRUE);
                $profileArr = array();
                foreach($profile2 as $key=>$val){
                    $profileArr[] = array($key=>$val);
                }
                $contestantDetails[0]['profile_formatted'] = $profileArr;
                $contestantDetails[0]['profile_2'] = $profile2;
                $resArr['contestant_details'] = $contestantDetails;
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_CONTESTANT_DETAILS');
                $this->resArr[CON_RES_DATA] = $resArr;
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_CONTESTANT_NOT_FOUND');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('contest_id'=>$contest_id,'contestant_id'=>$contestant_id);
        logMessage('getContestDetails',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Get Contestant Media Gallary ------------------------------- */
    public function getContestantMediaGallary()
    {
        //Fetch Request Parameter
        $contestant_id = $this->input->post('contestant_id');
        if (!empty($contestant_id)) {
            //Get Contestant Details
            $resArr = array();
            $mediaDetails = $this->APIModel->getMediaById('contestant_id' , $contestant_id);
            foreach( $mediaDetails as $key=>$value) {
                if( $mediaDetails[$key]['media_type'] == 'youtube'){
                    $a = preg_match(EQUATION,  $mediaDetails[$key]['media_path'], $matches);
                    $video_id = $matches[2];
                    $mediaDetails[$key]['vedio_id'] = $video_id;
                }
               
            }
            if (!empty($mediaDetails)) {
                $resArr['media_details'] = $mediaDetails;
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_MEDIA_DETAILS');
                $this->resArr[CON_RES_DATA] = $resArr;
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_MEDIA_NOT_FOUND');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('contestant_id'=>$contestant_id);
        logMessage('getContestantMediaGallary',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Get Comment List ------------------------------- */
    public function getCommentList()
    {
        //Fetch Request Parameter
        $contestant_id = $this->input->post('contestant_id');
        if (!empty($contestant_id)) {
            //Get Contestant Details
            $resArr = array();
            $commentDetails = $this->APIModel->getCommentByContestant($contestant_id);
            if (!empty($commentDetails)) {
                $resArr['comment_details'] = $commentDetails;
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_COMMENT_LIST');
                $this->resArr[CON_RES_DATA] = $resArr;
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_COMMENT_NOT_FOUND');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('contestant_id'=>$contestant_id);
        logMessage('getCommentList',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Add Comment ------------------------------- */
    public function addComment()
    {
        //Fetch Request Parameter
        $contestant_id = $this->input->post('contestant_id');
        $comment_text = $this->input->post('comment_text');
        $commented_by = $this->input->post('commented_by');
        if (!empty($contestant_id) && !empty($comment_text) && !empty($commented_by)) {
            //Insert Comment Record
            $commentData = array(
                'contestant_id' => $contestant_id,
                'comment_text' => $comment_text,
                'commented_by' => $commented_by,
                'commented_date' => date('Y-m-d H:i:s'),
            );
            $comment_id = $this->APIModel->insert('tbl_comment', $commentData);
            if ($comment_id > 0) {
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_COMMENT_SUCCESS');
                $this->resArr[CON_RES_DATA] = [];
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_COMMENT_FAIL');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('contestant_id'=>$contestant_id,'comment_text'=>$comment_text,'commented_by'=>$commented_by);
        logMessage('addComment',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Like Unlink Comment ------------------------------- */
    public function likeUnlikeComment()
    {
        //Fetch Request Parameter
        $comment_id = $this->input->post('comment_id');
        $like_by = $this->input->post('like_by');
        $is_like = $this->input->post('is_like');
        if (!empty($comment_id) && !empty($like_by) && !empty($is_like)) {
            //If User Like Comment Than Insert it Else Delete It
            if ($is_like == "like") {
                $insertData = array(
                    'comment_id' => $comment_id,
                    'like_by' => $like_by,
                    'like_date' => date('Y-m-d H:i:s'),
                );
                $is_success = $this->APIModel->insert('tbl_comment_like', $insertData);
            } else {
                $whereArr = array('comment_id' => $comment_id, 'like_by' => $like_by);
                $is_success = $this->APIModel->delete('tbl_comment_like', $whereArr);
            }

            if ($is_success) {
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                if ($is_like == "like") {
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_LIKE_SUCCESS');
                } else {
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_UNLIKE_SUCCESS');
                }
                $this->resArr[CON_RES_DATA] = [];
            } else {
                if ($is_like == "like") {
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_LIKE_FAIL');
                } else {
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_UNLIKE_FAIL');
                }
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('comment_id'=>$comment_id,'like_by'=>$like_by,'is_like'=>$is_like);
        logMessage('likeUnlikeComment',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Edit Contestant Profile ------------------------------- */
    public function editContestantDetail()
    {
        //Fetch Request Parameter
        $contestant_id = $this->input->post('contestant_id');
        $introduction = $this->input->post('introduction');
        $youtube_id_1 = $this->input->post('youtube_id_1');
        $youtube_id_2 = $this->input->post('youtube_id_2');
        $youtube_id_3 = $this->input->post('youtube_id_3');
        $youtube_url_1 = $this->input->post('youtube_url_1');
        $youtube_url_2 = $this->input->post('youtube_url_2');
        $youtube_url_3 = $this->input->post('youtube_url_3');
        $currentDate = date('Y-m-d H:i:s');
        $matchArr = 0;
        $urlArray = array();
        if (!empty($contestant_id)) {
            // check valid url 
            if(!empty($youtube_url_1) || !empty($youtube_url_2) || !empty($youtube_url_3)){
                array_push($urlArray,$youtube_url_1,$youtube_url_2,$youtube_url_3);
                foreach($urlArray as $url){
                        if(!empty($url)){
                            $a = preg_match(EQUATION, $url, $matches);
                            if(empty($matches)){
                                $matchArr ++;
                            }
                        }
                }  
            }
           if($matchArr == 0){
                  //Check File Upload

            $main_image = "";
            if (!empty($_FILES['main_image']['name'])) {
                //Remove All files associated with this user
                $files = glob(CON_CONTESTANT_PATH.$contestant_id . "_*");  
                // Deleting all the files in the list 
                foreach($files as $file) { 
                    if(is_file($file)){
                        // Delete the given file 
                        unlink($file);  
                    }  
                }

                $config['upload_path'] = CON_CONTESTANT_PATH;
                $config['allowed_types'] = CON_ALLOWED_IMAGE_TYPE;
                $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
                $filename = $contestant_id . "_".uniqid()."." . $ext;
                $config['file_name'] = $filename;
                $config['overwrite'] = true;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('main_image')) {
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_FILE_UPLOAD_FAIL');
                    $this->sendResponse($this->resArr);
                } else {
                    // $main_image = $filename;
                    $fileData = $this->upload->data();
                    $main_image = $fileData['file_name'];
                    //Create Thumb For Image
                    $this->load->library('thumb');
                    $thumb_name = $this->thumb->createImageThumb($fileData, CON_CONTESTANT_PATH, CON_CONTESTANT_PATH);
                }
            }
            $updateData = array();
            if (!empty($main_image)) {
                $updateData['main_image'] = $main_image;
                $updateData['thumb_image'] = $thumb_name;
            }
            /*if (!empty($introduction)) {
                $updateData['introduction'] = $introduction;
            }*/
            $updateData['introduction'] = $introduction;
            $updated = true;
            if (!empty($updateData)) {
                $whereArr = array('contestant_id' => $contestant_id);
                $updated = $this->APIModel->update('tbl_contestant_details', $updateData, $whereArr);
            }
                 // adding youtube video
          
            if(empty($youtube_id_1) && !empty($youtube_url_1)){
                $a = preg_match(EQUATION, $youtube_url_1, $matches);
               if(!empty($matches)){
                $video_id = $matches[2];
                $thumb_image = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
                $mediaArr = array(
                    'contestant_id' => $contestant_id,
                     'media_name' => $youtube_url_1,
                     'media_path' => $youtube_url_1,
                     'thumb_path' => $thumb_image,
                     'media_type' => 'youtube',
                     'status' => 'active',
                     'created_date' => $currentDate,
                     'updated_date' => date('Y-m-d H:i:s'),
                );
                $addMedia = $this->APIModel->insert('tbl_gallary', $mediaArr);
               }
              
            }

            if(empty($youtube_id_2) && !empty($youtube_url_2)){
                $a = preg_match(EQUATION, $youtube_url_2, $matches);
                $video_id = $matches[2];
              
                $thumb_image = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
                $mediaArr = array(
                    'contestant_id' => $contestant_id,
                     'media_name' => $youtube_url_2,
                     'media_path' => $youtube_url_2,
                     'thumb_path' => $thumb_image,
                     'media_type' => 'youtube',
                     'status' => 'active',
                     'created_date' => $currentDate,
                     'updated_date' => date('Y-m-d H:i:s'),
                );
                $addMedia = $this->APIModel->insert('tbl_gallary', $mediaArr);
            }

            if(empty($youtube_id_3) && !empty($youtube_url_3)){
                $a = preg_match(EQUATION, $youtube_url_3, $matches);
                $video_id = $matches[2];
              
                $thumb_image = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
                $mediaArr = array(
                    'contestant_id' => $contestant_id,
                     'media_name' => $youtube_url_3,
                     'media_path' => $youtube_url_3,
                     'thumb_path' => $thumb_image,
                     'media_type' => 'youtube',
                     'status' => 'active',
                     'created_date' => $currentDate,
                     'updated_date' => date('Y-m-d H:i:s'),
                );
                $addMedia = $this->APIModel->insert('tbl_gallary', $mediaArr);
            }


            // deleting youtube video
            if(!empty($youtube_id_1) && empty($youtube_url_1) ){
                $whereArr = array(
                    'media_id' => $youtube_id_1,
                );
                $deleteMedia = $this->APIModel->delete('tbl_gallary', $whereArr);
            }

            if(!empty($youtube_id_2) && empty($youtube_url_2) ){
                $whereArr = array(
                    'media_id' => $youtube_id_2,
                );
                $deleteMedia = $this->APIModel->delete('tbl_gallary', $whereArr);
            }

            if(!empty($youtube_id_3) && empty($youtube_url_3) ){
                $whereArr = array(
                    'media_id' => $youtube_id_3,
                );
                $deleteMedia = $this->APIModel->delete('tbl_gallary', $whereArr);
            }

             // updating youtube video   
            if(!empty($youtube_id_1) && !empty($youtube_url_1)){
                $a = preg_match(EQUATION, $youtube_url_1, $matches);
                $video_id = $matches[2];
              
                $thumb_image = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
                $whereArr = array(
                    'media_id' => $youtube_id_1,
                );
                $mediaArr = array(
                     'media_name' => $youtube_url_1,
                     'media_path' => $youtube_url_1,
                     'thumb_path' => $thumb_image,
                     'updated_date' => date('Y-m-d H:i:s'),
                );
                $editMedia = $this->APIModel->update('tbl_gallary',$mediaArr,$whereArr);

            }

            if(!empty($youtube_id_2) && !empty($youtube_url_2)){
                $a = preg_match(EQUATION, $youtube_url_2, $matches);
                $video_id = $matches[2];
              
                $thumb_image = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
                $whereArr = array(
                    'media_id' => $youtube_id_2,
                );
                $mediaArr = array(
                     'media_name' => $youtube_url_2,
                     'media_path' => $youtube_url_2,
                     'thumb_path' => $thumb_image,
                     'updated_date' => date('Y-m-d H:i:s'),
                );
                $editMedia = $this->APIModel->update('tbl_gallary',$mediaArr,$whereArr);

            }

            if(!empty($youtube_id_3) && !empty($youtube_url_3)){
                $a = preg_match(EQUATION, $youtube_url_3, $matches);
                $video_id = $matches[2];
              
                $thumb_image = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
                $whereArr = array(
                    'media_id' => $youtube_id_3,
                );
                $mediaArr = array(
                     'media_name' => $youtube_url_3,
                     'media_path' => $youtube_url_3,
                     'thumb_path' => $thumb_image,
                     'updated_date' => date('Y-m-d H:i:s'),
                );
                $editMedia = $this->APIModel->update('tbl_gallary',$mediaArr,$whereArr);

            }

            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_PROFILE_EDIT_SUCCESS');
            $this->resArr[CON_RES_DATA] = array();
            
           }
           else{
            $this->resArr[CON_RES_MESSAGE] = lang('INVALID_URL');

           } 
           
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }

        $datArr = array('contestant_id'=>$contestant_id,'introduction'=>$introduction,'youtube_id_1'=>$youtube_id_1,'youtube_id_2'=>$youtube_id_2,'youtube_id_3'=>$youtube_id_3,'youtube_url_1'=>$youtube_url_1,'youtube_url_2'=>$youtube_url_2,'youtube_url_3'=>$youtube_url_3);
        logMessage('editContestantDetail',$datArr, $this->resArr);
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
            //If contest in open state than only allow to vote
            $checkContestStatus = array('contest_id'=> $contest_id, 'status' => 'open');
            $statusData = $this->APIModel->getByWhere('tbl_contest', $checkContestStatus);
            if(empty($statusData)){
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_YOU_CAN_NOT_VOTE');
            }else{
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
                }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
    
        $datArr = array('contestant_id'=>$contestant_id,'contest_id'=>$contest_id,'voter_id'=>$voter_id,'voter_name'=>$voter_name,'vote'=>$vote);
        logMessage('addVote',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Set Previous Ranking ------------------------------- */
    public function _setContestantPreviousRanking($contest_id)
    {
        $this->APIModel->updatePreviousRanking($contest_id);
    }

    /* ------------------------------- Set Current Ranking ------------------------------- */
    public function _setContestantCurrentRanking($contest_id)
    {
        $this->APIModel->updateCurrentRanking($contest_id);
    }

    /* ------------------------------- Voting History ------------------------------- */
    public function votingHistory()
    {
        //Fetch request parameter
        $contest_id = $this->input->post('contest_id');
        $contestant_id = $this->input->post('contestant_id');

        if (!empty($contestant_id) && !empty($contest_id)) {

            //Fetch Voting Data
            $votingHistory = $this->APIModel->getVotingHistory($contestant_id, $contest_id);
            // print_r($votingHistory);exit();
            if (!empty($votingHistory)) {
                //Fetching SUB Banner Image for Contest
                $subBannerImage = $this->APIModel->getSubBannerImage($contest_id);
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_VOTING_HISTORY');
                $this->resArr[CON_RES_DATA] = array('banner_list'=>$subBannerImage, 'voting_history' => $votingHistory);
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_VOTING_HISTORY_EMPTY');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('contestant_id'=>$contestant_id,'contest_id'=>$contest_id);
        logMessage('votingHistory',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Star History ------------------------------- */
    public function starHistory()
    {
        //Fetch request parameter
        $user_id = $this->input->post('user_id');

        if (!empty($user_id)) {
            //Fetch Usage, Purchase History
            $resArr = array();
            $usageHistory = $this->APIModel->getStarUsage($user_id);
            $purchaseHistory = $this->APIModel->getPurchaseHistory($user_id);
            $availableStarCount = $this->APIModel->getAvailableStarCount($user_id);

            $resArr['remaining_star'] = $availableStarCount['remaining_star'];
            $resArr['usage_history'] = $usageHistory;
            $resArr['purchase_history'] = $purchaseHistory;

            foreach( $resArr['usage_history'] as $key=>$value) {
                $resArr['usage_history'][$key]['type'] = lang($value['type']);
            }
    
        // adding status label
        foreach($resArr['purchase_history'] as $key=>$value) {
            $resArr['purchase_history'][$key]['description'] = lang($value['description']);
        }

            if (!empty($resArr)) {
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_STAR_HISTORY');
                $this->resArr[CON_RES_DATA] = $resArr;
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_STAR_HISTORY_EMPTY');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('user_id'=>$user_id);
        logMessage('starHistory',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Register Device ------------------------------- */
    public function registerDevice()
    {
        try
        {
            $pushNotification = new PushNotification();
            $req_arr = array();
            $req_para = array('app_name', 'device_token', 'client_id', 'environment', 'os', 'user_id');

            foreach ($req_para as $key => $value) {
                if (!isset($_REQUEST[$value]) || empty($_REQUEST[$value])) {
                    $req_arr[] = $value;
                }
            }

            if (count($req_arr) == 0) {
                //Check if user already claim signup bonus or not
                $whereArr = array('user_id'=> $_REQUEST['user_id'], 'type' => 'signup');
                $isClaimed = $this->APIModel->getByWhere('tbl_star_purchase', $whereArr);
                if(empty($isClaimed)){
                    //Check if any other user already register with same device token than don't assign signup bonus
                    $whereArr = array('device_token'=> $_REQUEST['device_token']);
                    $isDeviceExists = $this->APIModel->getByWhere('apns_devices', $whereArr);
                    if(empty($isDeviceExists)){
                        //Assign Signup Bonus to User
                        $currentDateTime = date('Y-m-d H:i:s');
                        $purchaseArr = array(
                            'user_id' => $_REQUEST['user_id'],
                            'star' => CON_DEFAULT_SIGNUP_BONUNS,
                            'description' => 'Welcome Bonus',
                            'type' => 'signup',
                            'purchase_date' => date('Y-m-d'),
                            'created_date' => $currentDateTime,
                            'updated_date' => $currentDateTime,
                        );
                        $purchase_id = $this->APIModel->insert('tbl_star_purchase', $purchaseArr);
                    }
                }
                $rs = $pushNotification->registerDevice($_REQUEST);
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_DEVICE_REGISTER');
                $this->resArr[CON_RES_DATA] = array();
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
            }
        } catch (Exception $ex) {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Register Device Token------------------------------- */
    public function registerDeviceToken()
    {
        try
        {
            $pushNotification = new PushNotification();
            $req_arr = array();
            $req_para = array('app_name', 'device_token', 'client_id', 'environment', 'os', 'user_id');

            foreach ($req_para as $key => $value) {
                if (!isset($_REQUEST[$value]) || empty($_REQUEST[$value])) {
                    $req_arr[] = $value;
                }
            }

            if (count($req_arr) == 0) {
                $rs = $pushNotification->registerDevice($_REQUEST);
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_DEVICE_REGISTER');
                $this->resArr[CON_RES_DATA] = array();
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
            }
        } catch (Exception $ex) {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Notification ------------------------------- */
    public function getNotification()
    {
        //Fetch request parameter
        $user_id = $this->input->post('user_id');

        if (!empty($user_id)) {
            //Fetch Notification List
            $notificationList = $this->APIModel->getNotificationList($user_id);
            if (!empty($notificationList)) {
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_NOTIFICATION_LIST');
                $this->resArr[CON_RES_DATA] = array('notification_list' => $notificationList);
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_NOTIFICATION_LIST_EMPTY');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('user_id'=>$user_id);
        logMessage('getNotification',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Notice ------------------------------- */
    public function getNotice()
    {
        // Fetch Notice List
        $noticeList = $this->APIModel->getNoticeList();
        if (!empty($noticeList)) {
            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_NOTICE_LIST');
            $this->resArr[CON_RES_DATA] = array('notice_list' => $noticeList);
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_NOTICE_LIST_EMPTY');
        }
    
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Delete Gallary ------------------------------- */
    public function deleteGallaryItem()
    {
        //Fetch request parameter
        $media_id = $this->input->post('media_id');
        if (!empty($media_id)) {
            //Update Gallary Record
            // $updateData = array(
            //     'status' => 'delete',
            //     'updated_date' => date('Y-m-d H:i:s'),
            // );
            // $whereArr = array('media_id' => $media_id);

            // $isDeleted = $this->APIModel->update('tbl_gallary', $updateData, $whereArr);

            $whereArr = array('media_id' => $media_id);
            $mediaDetail = $this->APIModel->getByWhere('tbl_gallary', $whereArr);
            
            if(!empty($mediaDetail)){
                $mediaName = $mediaDetail[0]['media_path'];
                $thumbName = $mediaDetail[0]['thumb_path'];
                
                $isDeleted = $this->APIModel->delete('tbl_gallary', $whereArr);
            
                if (!empty($isDeleted)) {
                    if($mediaName != '' && file_exists(CON_GALLARY_PATH .$mediaName)){
                        unlink(CON_GALLARY_PATH . $mediaName);
                    }
                    if($thumbName != '' && file_exists(CON_GALLARY_THUMB_PATH .$thumbName)){
                        unlink(CON_GALLARY_THUMB_PATH . $thumbName);
                    }
                    
                    $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_GALLARY_ITEM_DELETED');
                    $this->resArr[CON_RES_DATA] = array();
                } else {
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_GALLARY_ITEM_DELETED_FAIL');
                }
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_GALLARY_ITEM_DELETED_FAIL');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('media_id'=>$media_id);
        logMessage('deleteGallaryItem',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }
    /* ------------------------------- Add Gallary ------------------------------- */
    public function addGallaryItem()
    {
        //Fetch request parameter
        $contestant_id = $this->input->post('contestant_id');
        $media_type = $this->input->post('media_type');

        if (!empty($contestant_id) && !empty($media_type)) {
            $currentDate = date('Y-m-d H:i:s');
            $media_path = "";
            $whereArr = array('contestant_id' => $contestant_id , 'media_type' => $media_type);
            $getMediaDetails = $this->APIModel->getByWhere('tbl_gallary', $whereArr);
            $isValidCount = true;
            if($media_type == "image"){
                //Check Total Image for Contestant Max 12 allowed
                if(count($getMediaDetails) >= 12){
                    $isValidCount = false;
                }
            }else{
                //Check Total Video for Contestant Max 3 allowed
                if(count($getMediaDetails) >= 3){
                    $isValidCount = false;
                }
            }
            
            if($isValidCount){
                if (!empty($_FILES['media_path']['name'])) {
                    $config['upload_path'] = CON_GALLARY_PATH;
                    $config['allowed_types'] = CON_ALLOWED_IMAGE_TYPE;
                    $ext = pathinfo($_FILES['media_path']['name'], PATHINFO_EXTENSION);
                    $filename = $media_type . "_".uniqid()."." . $ext;
                    $config['file_name'] = $filename;
                    $config['overwrite'] = true;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('media_path')) {
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_FILE_UPLOAD_FAIL');
                        $this->sendResponse($this->resArr);
                    } else {
                        $fileData = $this->upload->data();
                        $media_path = $fileData['file_name'];
                        $thumb_name = "";
                        if($media_type == "image"){
                            //Create Thumb For Image
                            $this->load->library('thumb');
                            $thumb_name = $this->thumb->createImageThumb($fileData, CON_GALLARY_PATH, CON_GALLARY_THUMB_PATH);
                        }else{
                            //Create thumb for Video
                            $thumb_size = VIDEO_THUMB_SIZE;
                            $getFromSeconds = VIDEO_FROM_SECOND;
                            $source_file = CON_GALLARY_PATH . $fileData['file_name'];
                            $targetfile = CON_GALLARY_THUMB_PATH.$fileData['raw_name'].'_thumb.jpg';
                            $cmd = "/rankingstar/bin/ffmpeg -itsoffset -1 -i $source_file -vframes 1 -filter:v scale='280:-1' -deinterlace -an -ss $getFromSeconds -f mjpeg -t 1 -r 1 -y $targetfile 2>&1";
                            // $cmd = "/rankingstar/bin/ffmpeg -i $source_file -deinterlace -an -ss $getFromSeconds -f mjpeg -t 1 -r 1 -y -s $thumb_size $targetfile 2>&1";
                            exec($cmd, $retArr, $retVal);                            
                            if(!$retVal){
                                $thumb_name = $fileData['raw_name'].'_thumb.jpg';
                            }
                        }
                    }
                    $gallaryArray = array(
                        'contestant_id' => $contestant_id,
                        'media_name' => $media_path,
                        'media_path' => $media_path,
                        'thumb_path' => $thumb_name,
                        'media_type' => $media_type,
                        'status' => 'active',
                        'created_date' => $currentDate,
                        'updated_date' => $currentDate,
                    );
                    $media_id = $this->APIModel->insert('tbl_gallary', $gallaryArray);
                    if ($media_id) {
                        $mediaDetails = $this->APIModel->getMediaById('media_id' , $media_id);
                        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_GALLARY_ITEM_SUCCESS');
                        $this->resArr[CON_RES_DATA] = array('media_details' => $mediaDetails);
                    } else {
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_GALLARY_ITEM_FAIL');
                    }
                } else {
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
                }
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_MAX_UPLOAD_LIMIT_REACHED');
            }
        } else {
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        
        $datArr = array('contestant_id'=>$contestant_id,'media_type'=>$media_type);
        logMessage('addGallaryItem',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Purchase Plan List ------------------------------- */
    public function getPlanList()
    {
        //Get Device Type Android or iOS
        $type = $this->input->post('os');
        //Get Purchase Plan
        $whereArr = array('plan_type'=>$type, 'status' => 'active');
        $planList = $this->APIModel->getByWhere('tbl_purchase_plan', $whereArr);
        if(!empty($planList)){
            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_PLAN_LIST');
            $this->resArr[CON_RES_DATA] = array('plan_list' => $planList);
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_PLAN_LIST_EMPTY');
        }
        $datArr = array('type'=>$type);
        logMessage('getPlanList',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Get Details By Phone ------------------------------- */
    public function getDetailsByPhone(){
        //Fetch request parameter
        $mobile = $this->input->post('mobile');
        if(!empty($mobile)){
            //Fetch User Details From Mobile
            $userDetails = $this->APIModel->findByPhone($mobile);
            if(!empty($userDetails)){
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_USER_DETAILS');
                $this->resArr[CON_RES_DATA] = array('user_details' => $userDetails);
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_USER_DETAILS_NOT_FOUND');    
            }
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('mobile'=>$mobile);
        logMessage('getDetailsByPhone',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Daily Check In ------------------------------- */
    public function dailyCheckIn(){   
        //Fetch request parameter
        $user_id = $this->input->post('user_id');
        if(!empty($user_id)){
            $isCheckIn = false;
            //Get device token of user
            $whereArr = array('user_id' => $user_id);
            $deviceTokenDetails = $this->APIModel->getByWhere('apns_devices', $whereArr);
            if(!empty($deviceTokenDetails)){
                $device_token = $deviceTokenDetails[0]['device_token'];
                $this->db->query('SET SESSION group_concat_max_len=150000');
                $qry = "SELECT  GROUP_CONCAT(DISTINCT user_id) as user_id FROM apns_devices WHERE device_token = '$device_token'";
                $userData = $this->db->query($qry)->row_array();
                if(!empty($userData)){
                    //Fetch Daily Check in of all user if anyone is checked in than don't give star
                    $today = date('Y-m-d');
                    $qry = "SELECT * FROM tbl_star_purchase WHERE purchase_date='$today' AND type='daily' AND user_id IN ({$userData['user_id']})";
                    $checkInData = $this->db->query($qry)->result_array();
                    if(!empty($checkInData)){
                        $isCheckIn = true;
                    }
                }   
            }
            
            //Check if already checked in or not
            if($isCheckIn == false){
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
                        'updated_date' => $currentDate
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
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_DAILY_CHECK_IN_COMPLETED');    
            }
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }

        $datArr = array('user_id'=>$user_id);
        logMessage('dailyCheckIn',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

     /* ------------------------------- Daily Check In ------------------------------- */
     public function dailyCheckInStar(){   
        //Fetch request parameter
        $user_id = $this->input->post('user_id');
        $device_id = $this->input->post('device_id');
        if(!empty($user_id) && !empty($device_id)){
            //Check daily star collected by same device for today
            $today = date('Y-m-d');
            $whereArr = array('purchase_date' => $today, 'type' => 'daily', 'device_id' => $device_id);
            $isAlreadyCollected = $this->APIModel->getByWhere('tbl_star_purchase', $whereArr);
            if(empty($isAlreadyCollected)){
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
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_DAILY_CHECK_IN_COMPLETED');
            }
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('user_id'=>$user_id,'device_id'=>$device_id);
        logMessage('dailyCheckInStar',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Gift Star ------------------------------- */
    public function giftstar() {
        $receiver_id = $this->input->post('receiver_id');
        $sender_id = $this->input->post('sender_id');
        $star = $this->input->post('star');
        $sender_name = $this->input->post('sender_name');
        if(!empty($receiver_id) && !empty($sender_id) && !empty($star) && !empty($sender_name)) {
            
            // If star if less then give alert message
            $availableStarCount = $this->APIModel->getAvailableStarCount($sender_id);
            if($star <= $availableStarCount['remaining_star']) {
                $currentDate = date('Y-m-d H:i:s');
                $insertGiftArr = array(
                    'receiver_id' => $receiver_id,
                    'sender_id' => $sender_id,
                    'star' => $star,
                    'description' => 'Gift',
                    'gift_date' => $currentDate
                );
                $giftId = $this->APIModel->insert('tbl_gift_star', $insertGiftArr);
                if($giftId) {
                    // Credit Purchase Star Table
                    $starPurchaseArr = array(
                        'user_id' => $receiver_id,
                        'star' => $star,
                        'description' => lang('TITLE_GIFT_STAR'),
                        'type' => 'gift',
                        'gift_id' => $giftId,
                        'purchase_date' => date('Y-m-d'),
                        'created_date' => $currentDate,
                        'updated_date' => $currentDate
                    );
                    $purchase_id = $this->APIModel->insert('tbl_star_purchase' , $starPurchaseArr);
                    /* Start: Send push notification */
                    
                    // $userWhere = array(
                    //     'user_id' => $sender_id
                    // );
                    // $userDetails = $this->APIModel->getByWhere('tbl_user_details' , $userWhere);
                    // $messageTitle = "Gift Star";
                    $messageTitle = lang('TITLE_GIFT_STAR');
                     if($this->input->post_get('language') == 'english'){
                        $message = "{$sender_name} gives you a {$star} star";
                        }else{
                            $message = "{$sender_name}님께서 스타 {$star} 개를 선물하였습니다";

                        }
                   
                    $messageType = "push";
                    $customData = array();
                    $receiverCount = $this->APIModel->getAvailableStarCount($receiver_id);
                    $customData['receiver_star'] = $receiverCount['remaining_star'];
                    $senderCount = $this->APIModel->getAvailableStarCount($sender_id);
                    $customData['sender_star'] = $senderCount['remaining_star'];

                    $pushNotification = new PushNotification();
                    $response = $pushNotification->sendPushMessage($messageTitle, $message , $messageType , $sender_id, $receiver_id, $customData);

                    /* End: Send push notification */
                    if($purchase_id) {
                        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                        $this->resArr[CON_RES_MESSAGE] = lang('MSF_GIFT_SUCCESS');
                    } else {
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_GIFT_FAIL');
                    }
                } else {
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_GIFT_FAIL');    
                }
            } else {
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_INSUFFICIENT_STAR');    
            }
            //Fetch Remaining Star Details
            $availableStarCount = $this->APIModel->getAvailableStarCount($sender_id);
            $starDetails['available_star'] = $availableStarCount['remaining_star'];
            $this->resArr[CON_RES_DATA] = array('star_details' => $starDetails);
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
   
        $datArr = array('receiver_id'=>$receiver_id,'sender_id'=>$sender_id,'star'=>$star,'sender_name'=>$sender_name);
        logMessage('giftstar',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);

    }

    /* ------------------------------- Begin Transaction ------------------------------- */
    public function beginTransaction(){
        $user_id = $this->input->post('user_id');
        $plan_id = $this->input->post('plan_id');
        $amount = $this->input->post('amount');
        $contest_id = $this->input->post('contest_id');
        if(!empty($user_id) && !empty($plan_id) && !empty($amount)){
            //Begin Transaction
            $transactionArr = array(
                'user_id' => $user_id,
                'contest_id' => $contest_id,
                'plan_id' => $plan_id,
                'amount' => $amount,
                'status' => 'begin',
                'payment_status' => 'pending',
                'transaction_begin_date' => date('Y-m-d H:i:s')
            );
            $transaction_id = $this->APIModel->insert('tbl_transaction', $transactionArr);
            if($transaction_id){
                $this->resArr[CON_RES_DATA] = array('transaction_details' => array('transaction_id' => $transaction_id));
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_BEGIN');
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_FAIL');    
            }
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
        $datArr = array('user_id'=>$user_id,'plan_id'=>$plan_id,'amount'=>$amount,'contest_id'=>$contest_id);
        logMessage('beginTransaction',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Complete Transaction ------------------------------- */
    public function completeTransaction(){
        $transaction_id = $this->input->post('transaction_id');
        $payment_status = $this->input->post('payment_status');
        if(!empty($transaction_id) && !empty($payment_status)){
            //check if transction already completed or not
            $whereArr = array('transaction_id' => $transaction_id, 'status' => 'completed');
            $isAlreadyCompleted = $this->APIModel->getByWhere('tbl_transaction', $whereArr);
            if(empty($isAlreadyCompleted)){
                //Complete Transaction
                $transactionArr = array(
                    'status' => 'completed',
                    'payment_status' => $payment_status,
                    'transaction_complete_date' => date('Y-m-d H:i:s')
                );
                $whereArr = array('transaction_id' => $transaction_id);
                $isUpdated = $this->APIModel->update('tbl_transaction', $transactionArr, $whereArr);
                if($isUpdated){
                    //Assign Star to User if transaction success
                    if($payment_status == "success"){
                        //Fetch Transaction Details first
                        $transactionDetails = $this->APIModel->getByWhere('tbl_transaction', $whereArr);
                        
                        //Fetch Plan Details to assign star to user
                        $whereArr = array('plan_id'=>$transactionDetails[0]['plan_id']);
                        $planDetails = $this->APIModel->getByWhere('tbl_purchase_plan', $whereArr);
                        if(!empty($planDetails)){
                            //Get star and Extra star and assign it to user
                            $purchase_star = $planDetails[0]['star'];
                            $extra_star = $planDetails[0]['extra_star'];
                            $total_star = $purchase_star + $extra_star;

                            $purchaseArr = array(
                                'user_id' => $transactionDetails[0]['user_id'],
                                'contest_id' => $transactionDetails[0]['contest_id'],
                                'star' => $total_star,
                                'amount' => $transactionDetails[0]['amount'],
                                'transaction_id' => $transaction_id,
                                'description' => 'APP',
                                'type' => 'paid',
                                'purchase_date' => date('Y-m-d'),
                                'created_date' => date('Y-m-d H:i:s'),
                                'updated_date' => date('Y-m-d H:i:s')
                            );
                            $purchase_id = $this->APIModel->insert('tbl_star_purchase', $purchaseArr);
                            
                            //Fetch User Star Count
                            $availableStarCount = $this->APIModel->getAvailableStarCount($transactionDetails[0]['user_id']);
                            $starDetails['remaining_star'] = $availableStarCount['remaining_star'];
                            
                            $this->resArr[CON_RES_DATA] = array('star_details' => $starDetails);
                            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                            $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_COMPLETE');

                        }else{
                            $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_FAIL');
                        }
                    }else{
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_FAIL'); 
                    }
                }else{
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_FAIL');    
                }
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_ALREADY_COMPLETED');
            }
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
    
        $datArr = array('transaction_id'=>$transaction_id,'payment_status'=>$payment_status);
        logMessage('completeTransaction',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Start Transaction ------------------------------- */
    public function startTransaction(){
        $user_id = $this->input->post('user_id');
        $plan_id = $this->input->post('plan_id');
        $amount = $this->input->post('amount');
        $contest_id = $this->input->post('contest_id');
        $os = $this->input->post('os');
        $app_version = $this->input->post('app_version');
        if(!empty($user_id) && !empty($plan_id) && !empty($amount) && !empty($os) && !empty($app_version)){
            //Begin Transaction
            $trans_identifier = $user_id.time();
            $transactionArr = array(
                'trans_identifier' => $trans_identifier,
                'user_id' => $user_id,
                'contest_id' => $contest_id,
                'plan_id' => $plan_id,
                'amount' => $amount,
                'status' => 'begin',
                'payment_status' => 'pending',
                'os' => $os,
                'app_version' => $app_version,
                'transaction_begin_date' => date('Y-m-d H:i:s')
            );
            $transaction_id = $this->APIModel->insert('tbl_transaction', $transactionArr);
            if($transaction_id){
                $this->resArr[CON_RES_DATA] = array('transaction_details' => array('transaction_id' => $trans_identifier));
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_BEGIN');
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_FAIL');    
            }
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
  
        $datArr = array('user_id'=>$user_id,'plan_id'=>$plan_id,'amount'=>$amount,'contest_id'=>$contest_id,'os'=>$os,'app_version'=>$app_version);
        logMessage('startTransaction',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Update Transaction ------------------------------- */
    public function updateTransaction(){
        $transaction_id = $this->input->post('transaction_id');
        $payment_status = $this->input->post('payment_status');
        $description = $this->input->post('description');
        $os = $this->input->post('os');
        $payment_transaction_id = $this->input->post('payment_transaction_id');
        $payment_details = $this->input->post('payment_details');
        if(!empty($transaction_id) && !empty($payment_status)){
            //Complete Transaction
            $transactionArr = array(
                'payment_status' => $payment_status,
                'description' => $description,
                'os' => $os,
                'payment_transaction_id' => $payment_transaction_id,
                'payment_details' => $payment_details,
                'transaction_complete_date' => date('Y-m-d H:i:s')
            );
            $whereArr = array('trans_identifier' => $transaction_id);
            $isUpdated = $this->APIModel->update('tbl_transaction', $transactionArr, $whereArr);
            if($isUpdated){
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_COMPLETE');
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_FAIL');  
            }   
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }
  
        $datArr = array('transaction_id'=>$transaction_id,'payment_status'=>$payment_status,'description'=>$description,'os'=>$os,'payment_transaction_id'=>$payment_transaction_id,'payment_details'=>$payment_details);
        logMessage('updateTransaction',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- End Transaction ------------------------------- */
    public function endTransaction(){
        $transaction_id = $this->input->post('transaction_id');
        $payment_status = $this->input->post('payment_status');
        $description = $this->input->post('description');
        $os = $this->input->post('os');
        $payment_transaction_id = $this->input->post('payment_transaction_id');
        $payment_details = $this->input->post('payment_details');
        if(!empty($transaction_id) && !empty($payment_status)){
            //check if transction already completed or not
            $whereArr = array('trans_identifier' => $transaction_id, 'status' => 'completed');
            $isAlreadyCompleted = $this->APIModel->getByWhere('tbl_transaction', $whereArr);
            if(empty($isAlreadyCompleted)){
                //Complete Transaction
                $transactionArr = array(
                    'status' => 'completed',
                    'payment_status' => $payment_status,
                    'description' => $description,
                    'os' => $os,
                    'payment_transaction_id' => $payment_transaction_id,
                    'payment_details' => $payment_details,
                    'transaction_complete_date' => date('Y-m-d H:i:s')
                );
                $whereArr = array('trans_identifier' => $transaction_id);
                $isUpdated = $this->APIModel->update('tbl_transaction', $transactionArr, $whereArr);
                if($isUpdated){
                    //Assign Star to User if transaction success
                    if($payment_status == "success"){
                        //Fetch Transaction Details first
                        $transactionDetails = $this->APIModel->getByWhere('tbl_transaction', $whereArr);
                        
                        //Fetch Plan Details to assign star to user
                        $whereArr = array('plan_id'=>$transactionDetails[0]['plan_id']);
                        $planDetails = $this->APIModel->getByWhere('tbl_purchase_plan', $whereArr);
                        if(!empty($planDetails)){
                            //Get star and Extra star and assign it to user
                            $purchase_star = $planDetails[0]['star'];
                            $extra_star = $planDetails[0]['extra_star'];
                            $total_star = $purchase_star + $extra_star;

                            $purchaseArr = array(
                                'user_id' => $transactionDetails[0]['user_id'],
                                'contest_id' => $transactionDetails[0]['contest_id'],
                                'star' => $total_star,
                                'amount' => $transactionDetails[0]['amount'],
                                'transaction_id' => $transactionDetails[0]['transaction_id'],
                                'description' => 'APP',
                                'type' => 'paid',
                                'purchase_date' => date('Y-m-d'),
                                'created_date' => date('Y-m-d H:i:s'),
                                'updated_date' => date('Y-m-d H:i:s')
                            );
                            $purchase_id = $this->APIModel->insert('tbl_star_purchase', $purchaseArr);
                            
                            //Fetch User Star Count
                            $availableStarCount = $this->APIModel->getAvailableStarCount($transactionDetails[0]['user_id']);
                            $starDetails['remaining_star'] = $availableStarCount['remaining_star'];
                            
                            $this->resArr[CON_RES_DATA] = array('star_details' => $starDetails);
                            $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                            $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_COMPLETE');

                        }else{
                            $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_FAIL');
                        }
                    }else{
                        $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_FAIL'); 
                    }
                }else{
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_FAIL');    
                }
            }else{
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_ALREADY_COMPLETED');
            }   
        }else{
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_INVALID_PARAMETER');
        }

        $datArr = array('transaction_id'=>$transaction_id,'payment_status'=>$payment_status,'description'=>$description,'os'=>$os,'payment_transaction_id'=>$payment_transaction_id,'payment_details'=>$payment_details);
        logMessage('endTransaction',$datArr, $this->resArr);
        $this->sendResponse($this->resArr);
    }

    /* ------------------------------- Purchase Web View ------------------------------- */
    public function purchaseStarWebView()
    {
        $language = $this->input->get('language');
        $os = $this->input->get('os');
        $data = array();
        $data['os'] = $os;
        //Get Purchase Plan
        $whereArr = array('status' => 'active');
        $data['purchasePlanList'] = $this->APIModel->getByWhere('tbl_purchase_plan', $whereArr);

        //Get Advertise
        $whereArr = array('status' => 'active');
        $data['advertisementList'] = $this->APIModel->getByWhere('tbl_advertisement', $whereArr);

        //Get Star Shop
        $whereArr = array('status' => 'active');
        $data['tableStarShopList'] = $this->APIModel->getByWhere('tbl_star_shop', $whereArr);

        $this->load->view('purchase_star_web_view', $data);
    }

    /* ------------------------------- Terms & Condition Web View ------------------------------- */
    public function termsAndConditionWebView()
    {
        $language = $this->input->get('language');
        $this->load->view('terms_condition_web_view');
    }

    /* ------------------------------- Privacy Police Web View ------------------------------- */
    public function privacyPolicyWebView()
    {
        $language = $this->input->get('language');
        $this->load->view('privacy_policy_web_view');
    }

    /* ------------------------------- How to Use Web View ------------------------------- */
    public function howToUseWebView()
    {
        $language = $this->input->get('language');
        $this->load->view('how_to_use_web_view');
    }

    /* ------------------------------- Facebook Sharing For Contestant ------------------------------- */
    public function shareContestantOnFacebook(){
        
        //Fetch Request Parameter
        $contest_id = $this->input->get('contest_id');
        $contestant_id = $this->input->get('contestant_id');
        $language = $this->input->get('language');        
        if (!empty($contestant_id) && !empty($contest_id)) {
            //Get Contestant Details
            $resArr = array();
            $contestantDetails = $this->APIModel->getContestantDetailsById($contestant_id, $contest_id);
            $data['contestant_details'] = $contestantDetails[0];
            $data['language'] = $language;
            $this->load->view('contestant_facebook_share', $data);  
        } 
    }

     /* ------------------------------- Notice web view ------------------------------- */
     public function getNoticeWebView(){
        
        //Fetch Request Parameter
        $notice_id = $this->input->get('notice_id'); 
        $data['noticeDetails'] = $this->APIModel->getNoticeById($notice_id);
        $this->load->view('notice/notice_preview', $data);               
    }

     /* ------------------------------- Send Notification By crone job ------------------------------- */

     public  function sendByCron(){
        $pushNotification = new PushNotification();
        $response = $pushNotification->sendNotificationByCron();
        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
        $this->resArr[CON_RES_MESSAGE] = lang('MSG_PUSH_NOTIFICATION_SUCCESS');
        $this->resArr[CON_RES_DATA] = array('data' => '');
        $this->sendResponse($this->resArr);
     }



     ///// New Code Added For Version 2     
}
