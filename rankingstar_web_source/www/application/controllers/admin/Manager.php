<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manager extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->auth->isLogin()) {
            redirect(CON_LOGIN_PATH);
        }
        $this->setWebLanguage();
        $this->load->model('User_Model', 'UserModel');
        $this->load->model('Api_Model', 'APIModel');
    }

    /* User List View */
    public function index()
    {
        $this->load->view('manager_view');
    }

    /* User List View */
    public function userlist()
    {

        $sortColumn = ['count', 'name', 'email', 'mobile', 'register_date_time', 'user_status'];

        // Datatables Variables
        $draw = intval($this->input->post("draw"));
        $offset = intval($this->input->post("start"));
        $limit = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $order = $this->input->post("order");

            $count = $offset;
        
        //Get Search Value
        $searchText = "";
        if (!empty($search['value'])) {
            $searchText = $search['value'];
        }

        //Get Order By And Direction
        $column = $order[0]['column'];
        $sort_by = $order[0]['dir'];
        $order_by = $sortColumn[$column];
        // $order_by=null;
        $totalData = $this->UserModel->getAdminManagerData($searchText, $order_by, $sort_by, $offset, 0);
        $userData = $this->UserModel->getAdminManagerData($searchText, $order_by, $sort_by, $offset, $limit);
        //Process Data
        $data = array();

        foreach ($userData as $user) {
            $count++;
            $details = '<a data-toggle="tooltip" title="Details" href="' . BASE_URL . 'manager/details/' . $user['user_id'] . '" data-id="' . $user['user_id'] . '">' . $user['name'] . '</a>';
            $delete = '';
            $sessionData = $this->auth->getUserSession();
            if ($sessionData['user_type'] === "admin" && $user['user_type'] != "admin") {
                $delete = '<a data-toggle="tooltip" title="' . lang('TT_REMOVE_USER') . '" class="remove-user" data-url="' . BASE_URL . 'manager/delete/' . $user['user_id'] . '" href="#" data-id="' . $user['user_id'] . '"><i class="fas fa-user-times"></i></a>';
            }
            $data[] = array($count, $details, $user['email'], $user['mobile'], date('Y-m-d', strtotime($user['register_date_time'])), $user['user_status'], $delete);
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($totalData),
            "recordsFiltered" => count($totalData),
            "data" => $data,
        );
        echo json_encode($output);
        exit();
    }

    public function sendMail(Type $var = null)
    {
        //Load email library
        $this->load->library('email');

        //SMTP & mail configuration
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.example.com',
            'smtp_port' => 465,
            'smtp_user' => 'manojg.etechmavens@gmail.com',
            'smtp_pass' => '1234@manoj',
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

        //Email content
        $htmlContent = '<h1>Sending email via SMTP server</h1>';
        $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';

        $this->email->to('bhavikd.etechmavens@gmail.com');
        $this->email->from('manojg.etechmavens@gmail.com', 'MyWebsite');
        $this->email->subject('How to send email via SMTP server in CodeIgniter');
        $this->email->message($htmlContent);

        //Send email
        $this->email->send();
    }

    /* User Add View */
    public function adduser()
    {
        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name', lang('LBL_NAME'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('email', lang('EMAIL'), 'required|valid_email', array('required' => '%s ' . lang('VALIDATION_REQUIRED'), 'valid_email' => lang('VALIDATION_EMAIL')));
            $this->form_validation->set_rules('phone', lang('LBL_PHONE'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));

            if ($this->form_validation->run() === false) {
                $errors = validation_errors();
                $this->session->set_flashdata('error', $errors);
            } else {
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $phone = $this->input->post('phone');
                $userType = $this->input->post('user_type');
                $nick_name = $this->input->post('nick_name');
                $password = mt_rand(10000000, 99999999); // Random 8 digit code
                $current_date = date('Y-m-d H:i:s');

                // Email exists
                $isEmailExists = array();
                $emailWhereArr = array('email' => $email, 'user_status !=' => 'deleted');
                $isEmailExists = $this->UserModel->getByWhere('tbl_user', $emailWhereArr);
                if (!empty($isEmailExists)) {
                    $this->session->set_flashdata('error', lang('MSG_EMAIL_EXISTS'));
                } else {
                    $isMobileExists = array();
                    $mobileWhereArr = array('mobile' => $phone, 'user_status !=' => 'deleted');
                    $isMobileExists = $this->UserModel->getByWhere('tbl_user', $mobileWhereArr);
                    if (!empty($isMobileExists)) {
                        $this->session->set_flashdata('error', lang('MSG_MOBILE_EXISTS'));
                    } else {

                        $insertUserArr = array(
                            'email' => $email,
                            'mobile' => $phone,
                            'user_type' => $userType,
                            'password' => md5($password),
                            'user_status' => 'active',
                            'login_type' => 'auth',
                            'register_date_time' => $current_date,
                            'update_date_time' => $current_date,
                        );

                        $user_id = $this->UserModel->insert('tbl_user', $insertUserArr);

                        // oauth_users table insert value
                        $oauthInsertArr = array(
                            'username' => $email,
                            'password' => md5($password)
                        );
                        $oauthUserInsert = $this->APIModel->insert('oauth_users', $oauthInsertArr);

                        if ($user_id) {
                            $userDetailsArr = array(
                                'user_id' => $user_id,
                                'name' => $name,
                                'nick_name' => $nick_name,
                                'main_image' => CON_DEFAULT_USER_IMAGE,
                            );
                            $user_detail_id = $this->UserModel->insert('tbl_user_details', $userDetailsArr);
                            if ($user_detail_id) {

                                //Give Free Bonus Star
                                $purchaseArr = array(
                                    'user_id' => $user_id,
                                    'star' => CON_DEFAULT_SIGNUP_BONUNS,
                                    'description' => 'Welcome Bonus',
                                    'type' => 'signup',
                                    'purchase_date' => date('Y-m-d'),
                                    'created_date' => $current_date,
                                    'updated_date' => $current_date,
                                );
                                $purchase_id = $this->UserModel->insert('tbl_star_purchase', $purchaseArr);

                                // Send Email
                                $android = '<a href ="https://play.google.com/store/apps/details?id=com.etech.starranking"><img src="' . CON_IMAGES_PATH . 'android2.png" width="120px"></a>';
                                $ios = '<a href="https://www.apple.com/ios/app-store/"><img src="' . CON_IMAGES_PATH . 'ios2.png" width="120px"></a>';
                                $data['mail_to'] = $email;
                                // $data['mail_subject'] = CON_SMTP_FROM_NAME. ' - 회원가입을 환영합니다';
                                $data['mail_subject'] = CON_SMTP_FROM_NAME . ' 회원가입을 환영합니다';

                                $data['mail_message'] = "안녕하세요, " . $name . " 회원님, 
                                <br>랭킹스타에 오신 것을 환영합니다. 
                                <br> 아래 정보로 로그인 하시기 바랍니다.
                                <br> 아이디: " . $email . "
                                <br> 패스워드: " . $password . "
                                <br><br><br>감사합니다.,
                                <br>랭킹스타,
                                <br>
                                <br>" . $android . "
                                <br>  " . $ios . "";
                                $this->load->library('Mail', $data);
                                if (!$this->mail->sendMail()) {
                                    $this->session->set_flashdata('error', lang('EMAIL_SENT_FAILED'));
                                }
                                // Send Email
                                adminLogMessage('Add User',$insertUserArr,$user_id);

                                $this->session->set_flashdata('success_msg', lang('MSG_USER_REGISTER_SUCCESS'));
                                redirect(BASE_URL . "user");
                            } else {
                                $this->session->set_flashdata('error', lang('MSG_USER_REGISTER_FAIL'));
                            }
                        } else {
                            $this->session->set_flashdata('error', lang('MSG_USER_REGISTER_FAIL'));
                        }
                    }
                }
            }
        }
        $this->load->view('manager_add_view');
    }

    /* User Edit View */
    public function edituser()
    {
        if ($this->input->post()) {
            $user_id = $this->input->post('user_id');          
            $login_type = $this->input->post('login_type');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name', lang('LBL_NAME'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            if (isset($login_type) && $login_type === "auth") {
                
                $this->form_validation->set_rules('email', lang('LBL_EMAIL'), 'required|valid_email', array('required' => '%s ' . lang('VALIDATION_REQUIRED'), 'valid_email' => lang('VALIDATION_EMAIL')));
                $this->form_validation->set_rules('phone', lang('LBL_PHONE'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            }

            if ($this->form_validation->run() === false) {
                $errors = validation_errors();
                $this->session->set_flashdata('error', $errors);
                redirect(BASE_URL . "user/details/" . $user_id);
            } else { 
                $email = $this->input->post('email');
                $previous_email = $this->input->post('previous_email');
                $name = $this->input->post('name');
                $mobile = $this->input->post('phone');
                $userType = $this->input->post('user_type');
                $nick_name = $this->input->post('nick_name');
                $user_status = $this->input->post('user_status');
                $updated_date = date('Y-m-d H:i:s');
                $password = $this->input->post("password");
                $device_id = $this->input->post('device_id');
                $ip_addr = $this->input->post('ip_addr');
                $register_date_time =date('Y-m-d H:i:s');
                $username = $this->input->post('username');
               
                // Check Email Exists
                $isEmailExists = array();
                if ($login_type === "auth") {
                    $whereArr = array('user_id !=' => $user_id, 'email' => $email,'user_status !=' =>'deleted');
                    $isEmailExists = $this->UserModel->getByWhere('tbl_user', $whereArr);
                }

               

                if (!empty($isEmailExists)) {
                    $this->session->set_flashdata('error', lang('MSG_EMAIL_EXISTS'));
                    redirect(BASE_URL . "user/details/" . $user_id);
                } else {
                   
                    $isMobileExists = array();
                    $mobileWhereArr = array('user_id !=' => $user_id,'mobile' => $mobile, 'user_status !=' => 'deleted');
                    $isMobileExists = $this->UserModel->getByWhere('tbl_user', $mobileWhereArr);
                    if (!empty($isMobileExists)) {
                        $this->session->set_flashdata('error', lang('MSG_MOBILE_EXISTS'));
                        redirect(BASE_URL . "user/details/" . $user_id);

                    }else{
                        $whereArr = array('user_id' => $user_id);
                        //Update User Table Data
                        $userData = array(
                            'email' => $email,
                            'mobile' => $mobile,
                            'user_type' => $userType,
                            'user_status' => $user_status,
                            'update_date_time' => $updated_date,
                            'device_id' => $device_id,
                            'ip_addr'=> $ip_addr,
                            'register_date_time' => $register_date_time 

                        );
    
                        $updateOAuthUserArr = array(
                            'username' => $email
                            // 'password' => md5($password)
                            
                        );
                        // check if passowrd is changed
                        if ($password) {
                            $userData['password'] = md5($password);
                            $updateOAuthUserArr['password'] = md5($password);

                            // send email for password change
                            $android = '<a href ="https://play.google.com/store/apps/details?id=com.etech.starranking"><img src="' . CON_IMAGES_PATH . 'android2.png" width="120px"></a>';
                            $ios = '<a href="https://www.apple.com/ios/app-store/"><img src="' . CON_IMAGES_PATH . 'ios2.png" width="120px"></a>';
                            $data['mail_to'] = $email;
                            // $data['mail_subject'] = CON_SMTP_FROM_NAME. ' -비밀번호가 변경되었습니다';
                            $data['mail_subject'] = CON_SMTP_FROM_NAME . ' 비밀번호가 변경되었습니다';
    
                            $data['mail_message'] = "안녕하세요," . $name . "회원님, 
                            <br>고객님의 비밀번호 변경 내역을 안내드립니다.
                            아래 정보로 로그인 하시기 바랍니다. . 
                           
                            <br> 아이디: " . $email . "
                            <br> 패스워: " . $password . "
                            <br><br><br>감사합니다.,
                            <br>랭킹스타.<br>
                            <br>" . $android . "
                            <br>  " . $ios . "";
                            $this->load->library('Mail', $data);
                            if (!$this->mail->sendMail()) {
                                $this->session->set_flashdata('error', lang('EMAIL_SENT_FAILED'));
                            }
                        }
                        $a = $this->UserModel->update('tbl_user', $userData, $whereArr);
                        
                        //// Oauth user update 
                        $updateUsername = array(
                            'username' => $username
                        );
                        $ans = $this->UserModel->update('oauth_users', $updateOAuthUserArr, $updateUsername);
                        // $this->UserModel->update('oauth_users', $updateOAuthUserArr, $updateUsername);
                        
                        //Update User Details Table Data
                        if ($userType == "contestant") {
                            $userDetailsData = array(
                                'name' => $name,
                                'nick_name' => $nick_name
                            );
                            $this->UserModel->update('tbl_contestant_details', $userDetailsData, $whereArr);
                        } else {
                            $userDetailsData = array(
                                'name' => $name,
                                'nick_name' => $nick_name
                            );
                            $this->UserModel->update('tbl_user_details', $userDetailsData, $whereArr);
                        }
    
    
                        if ($previous_email !== $email) {
                            // Update Email
                            $android = '<a href ="https://play.google.com/store/apps/details?id=com.etech.starranking"><img src="' . CON_IMAGES_PATH . 'android2.png" width="120px"></a>';
                            $ios = '<a href="https://www.apple.com/ios/app-store/"><img src="' . CON_IMAGES_PATH . 'ios2.png" width="120px"></a>';
                            $data['mail_to'] = $email;
                            // $data['mail_subject'] = CON_SMTP_FROM_NAME. ' -이메일이 변경되었습니다.';
                            $data['mail_subject'] = CON_SMTP_FROM_NAME . ' 이메일이 변경되었습니다.';
    
                            $data['mail_message'] = "안녕하세요, " . $name . " 회원님,
                            <br>고객님의 이메일 변경 내역을 안내드립니다. 
                            <br> 아래 정보로 로그인 하시기 바랍니다.
                            <br> 아이디: " . $email . "
                            <br><br><br>감사합니다.
                            <br>랭킹스타.<br>
                            <br>" . $android . "
                            <br>  " . $ios . "";
                            $this->load->library('Mail', $data);
                            if (!$this->mail->sendMail()) {
                                $this->session->set_flashdata('error', lang('EMAIL_SENT_FAILED'));
                            }
                            // Update Email
                        }
                        $this->session->set_flashdata('success_msg', lang('MSG_USER_UPDATE_SUCCESS'));
                        // redirect(BASE_URL . "user/details/" . $user_id);
                        // redirect(BASE_URL . "user");
                        echo json_encode(['success' => true]);
                    }
                }
            }
        }
    }

    /* User Details View */
    public function details()
    {
        $user_id = $this->uri->segment(4);
        $data['userDetails'] = $this->UserModel->getUserDetails($user_id);
        $this->load->view('manager_details_view', $data);
    }

    /* User Details View */
    public function delete()
    {
        $user_id = $this->uri->segment(4);
        $updateData = array('user_status' => 'deleted');
        $updateContestantWhr = array('status' => 'deleted');
        $whereArr = array('user_id' => $user_id);
        //$isDeleted = false;

        $isDeleted = $this->UserModel->update('tbl_user', $updateData, $whereArr);
        $delete = $this->UserModel->update('tbl_contestant_details', $updateContestantWhr, $whereArr);

        //print_r($contestantDetails);
        //print_r($userDetail);
        
        if ($isDeleted) {
            adminLogMessage('Delete User',$user_id,$user_id);
            $resData = array('res_code' => 1, 'res_message' => lang('LBL_DELETE_SUCCESS'));
            $userDetail = $this->UserModel->getByWhere('tbl_user', $whereArr);

            // Hard Delete Oauth user
            $whrOauth = array (
                'username' => $userDetail[0]['email'],
                // 'username' => $userDetail[0]['social_id'],
            );
            $deleteOauthUser = $this->UserModel->delete('oauth_users', $whrOauth);

            if ($userDetail[0]['user_type'] === 'contestant') {
                $this->load->model('Api_Model', 'ApiModel');
                $contestantDetails = $this->UserModel->getByWhere('tbl_contestant_details', $whereArr);
                // get contest id
                $contestantWhereCon = array(
                    'contestant_id' => $contestantDetails[0]['contestant_id']
                );
                $contestantMappingArr = $this->UserModel->getByWhere(
                    'tbl_contestant_mapping',
                    $contestantWhereCon
                );
                // update status to deleted
                $contestantMapWhere = array(
                    'contestant_id' => $contestantDetails[0]['contestant_id']
                );
                $contestantMapdelete = $this->UserModel->update(
                    'tbl_contestant_mapping',
                    $updateContestantWhr,
                    $contestantMapWhere
                );

                foreach ($contestantMappingArr as $contest) {
                    // print_r($contest);
                    // Update Contestant current Ranking
                    $this->ApiModel->updateCurrentRanking($contest['contest_id']);
                }

            }
        } else {
            $resData = array('res_code' => 0, 'res_message' => lang('LBL_DELETE_FAIL'));
        }

        header('Content-Type: application/json');
        echo json_encode($resData);
    }

    /* User History View */
    public function history()
    {
        $user_id = $this->uri->segment(4);
        $this->load->view('user_history_view', array('user_id' => $user_id));
    }

    /* Get Purchase History */
    public function purchasehistory()
    {
        $user_id = $this->uri->segment(4);

        $sortColumn = ['count', 'tsp.description', 'tsp.type', 'tsp.star', 'tsp.purchase_date'];

        // Datatables Variables
        $draw = intval($this->input->post("draw"));
        $offset = intval($this->input->post("start"));
        $limit = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $order = $this->input->post("order");

        if ($draw === 1) {
            $count = 0;
        } else if ($draw > 1) {
            $count = $offset;
        }

        //Get Search Value
        $searchText = "";
        if (!empty($search['value'])) {
            $searchText = $search['value'];
        }

        //Get Order By And Direction
        $column = $order[0]['column'];
        $sort_by = $order[0]['dir'];
        // $order_by = $sortColumn[$column];
        $order_by = null;

        $totalData = $this->UserModel->getUserPurchaseData($user_id, $searchText, $order_by, $sort_by, $offset, 0);
        $purchaseData['purchase_list'] = $this->UserModel->getUserPurchaseData($user_id, $searchText, $order_by, $sort_by, $offset, $limit);

        foreach ($purchaseData['purchase_list']  as $key => $value) {
            $count++;
            $purchaseData['purchase_list'][$key]['star'] = number_format($value['star']);
            if ($purchaseData['purchase_list'][$key]['type'] == 'gift') {
                $purchaseData['purchase_list'][$key]['description'] =  $value['reciever_name'] . ' ' .lang('RECIEVED_STAR'). ' ' .$value['sender_name'];
            } else {
                $purchaseData['purchase_list'][$key]['description'] = lang($value['description']);
            }
            $purchaseData['purchase_list'][$key]['type'] = lang($value['type']);
            $purchaseData['purchase_list'][$key]['purchase_date'] = date('Y-m-d', strtotime($value['purchase_date']));

            $purchaseData['purchase_list'][$key]['count'] = $count;
        }
        //Fetch Total of Purchase Amount
        $purchaseTotal = $this->UserModel->getTotalPurchase($user_id, $searchText);

        //Fetch Remaining Star Details
        $availableStarCount = $this->APIModel->getAvailableStarCount($user_id);
        $purchaseData['remaining_star'] = number_format($availableStarCount['remaining_star']);
        $purchaseData['total_purchase'] = number_format($purchaseTotal['total_purchase']);

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($totalData),
            "recordsFiltered" => count($totalData),
            "data" => $purchaseData,
        );
        echo json_encode($output);
        exit();
    }

    /* Get Purchase History */
    public function usagehistory()
    {
        $user_id = $this->uri->segment(4);

        $sortColumn = ['count', 'description', 'contest_name', 'receiver_name', 'vote', 'vote_date'];

        // Datatables Variables
        $draw = intval($this->input->post("draw"));
        $offset = intval($this->input->post("start"));
        $limit = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $order = $this->input->post("order");


        if ($draw === 1) {
            $count = 0;
        } else if ($draw > 1) {
            $count = $offset;
        }

        //Get Search Value
        $searchText = "";
        if (!empty($search['value'])) {
            $searchText = $search['value'];
        }

        //Get Order By And Direction
        $column = $order[0]['column'];
        $sort_by = $order[0]['dir'];
        // $order_by = $sortColumn[$column];
        $order_by = null;
        $totalData = $this->UserModel->getUserVoteData($user_id, $searchText, $order_by, $sort_by, $offset, 0);
        $purchaseData['voting_list'] = $this->UserModel->getUserVoteData($user_id, $searchText, $order_by, $sort_by, $offset, $limit);
        foreach ($purchaseData['voting_list'] as $key => $value) {
            $count++;
            $purchaseData['voting_list'][$key]['vote'] = number_format($value['vote']);
            $purchaseData['voting_list'][$key]['vote_date'] =  date('Y-m-d', strtotime($value['vote_date']));
            $purchaseData['voting_list'][$key]['description'] = lang($value['description']);
            $purchaseData['voting_list'][$key]['count'] = $count;
        }
        //Fetch Total of Usage Amount
        $totalUsage = $this->UserModel->getTotalUsage($user_id, $searchText);
        $totalUsage['total_usage'] = number_format($totalUsage['total_usage']);
        //Fetch Remaining Star Details
        $availableStarCount = $this->APIModel->getAvailableStarCount($user_id);
        $purchaseData['remaining_star'] = number_format($availableStarCount['remaining_star']);
        $purchaseData['total_usage'] = $totalUsage['total_usage'];
        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($totalData),
            "recordsFiltered" => count($totalData),
            "data" => $purchaseData,
        );
        echo json_encode($output);
        exit();
    }


    ///// Unsubscribe user to delete 
    public function deleteUserToUnsubscribe(){
        $user_id = $this->input->post('user_id');
        $whereArr = array('user_id' => $user_id,'user_status !=' =>'deleted');
        $userid = $this->UserModel->getByWhere('tbl_user', $whereArr);

        if(!empty($user_id)) {
            $this->db->trans_begin();
            $updateData = array(
                'user_status' => 'deleted'
            );
            $whrUserArr = array(
                'user_id' => $userid[0]['user_id']
            );
            $user = $this->UserModel->update('tbl_user', $updateData, $whrUserArr);

            // Hard Delete Oauth user
            $whrOauth = array (
                'username' => $userid[0]['email'],
            );
            $deleteOauthUser = $this->UserModel->delete('oauth_users', $whrOauth);

            if($this->db->trans_status() === false) {
                $this->db->trans_rollback();
            }
            else {
                $this->db->trans_commit();
                $this->session->set_flashdata('success_msg', lang('LBL_DELETE_SUCCESS'));
            }
        }
        else {
            $this->session->set_flashdata('error', lang('MSG_USER_REGISTER_FAIL'));
            // $resData = array('res_code' => 0, 'res_message' => lang('MSG_USER_DELETE_FAILED'));
        }
        // header('Content-Type: application/json');
        // echo json_encode($resData);die;
    }

}
