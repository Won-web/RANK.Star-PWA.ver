<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contestant extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->auth->isLogin()) {
            redirect(CON_LOGIN_PATH);
        }
        $this->setWebLanguage();
        $this->load->model('Contestant_Model', 'ContestantModel');
    }

    public function index()
    {
        $a = $this->uri->segment(4);

        $whereContest = array(
            'status !=' => 'delete',
        );
        $data['contestList'] = $this->ContestantModel->getByWhere('tbl_contest', $whereContest);
        $data['contest_id'] = $a;
        $this->load->view('contestantlist_view', $data);
    }

    public function contestantlist()
    {
        // $contestId = $_POST['contestId'];

        $sortColumn = ['count', 'tcm.current_ranking', 'tc.contest_name', 'tcd.name', 'total_voting', 'tcd.created_date', 'tcd.updated_date'];

        $draw = intval($this->input->post("draw"));
        $offset = intval($this->input->post("start"));
        $limit = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $order = $this->input->post("order");
        $contestId = $this->input->post("contest_id");

        if ($draw === 1) {
            $count = 0;
        } else if ($draw > 1) {
            $count = $offset;
        }

        $searchText = "";
        if (!empty($search['value'])) {
            $searchText = $search['value'];
        }

        $column = $order[0]['column'];
        $sort_by = $order[0]['dir'];
        $order_by = $sortColumn[$column];
        // $order_by = null;
        $listofcontestant = $this->ContestantModel->listOfContestant($searchText, $order_by, $sort_by, $offset, $limit, $contestId);
	
        $allrecord = $this->ContestantModel->listOfContestant($searchText, $order_by, $sort_by, $offset, 0, $contestId);
	//$allrecord = $this->ContestantModel->listOfContestantCount($searchText, $order_by, $sort_by, $offset, 0, $contestId);

        $data = array();
        foreach ($listofcontestant as $contestant) {
            $count++;
            $sessionData = $this->auth->getUserSession();
            $deleteContestant = '';

            if ($sessionData['user_type'] === "admin") {
                $deleteContestant = '<a class="deleteContestant" data-toggle="modal" data-div-target="exampleModalLabel" data-contestId="' . $contestant['contest_id'] . '" data-id="' . $contestant['contestant_id'] . '" ><i class="fas fa-trash deleteicon"></i></a>';
            }
            $detail = '<a href="' . BASE_URL . 'contestant/detailcontestant/' . $contestant['contestant_id'] . '/' . $contestant['contest_id'] . '">' . $contestant['name'] . '</a>';
            if ($contestant['contest_id'] == "") {
                $detail = '<a href="' . BASE_URL . 'contestant/detailcontestant/' . $contestant['contestant_id'] . '">' . $contestant['name'] . '</a>';
            }
            
            
            $data[] = array(
                $count,
                $contestant['current_ranking'],
                $contestant['contest_name'],
                $contestant['thumb_image'],
                $detail,
                number_format($contestant['total_voting']),
                date('Y-m-d', strtotime($contestant['created_date'])),
                date('Y-m-d', strtotime($contestant['updated_date'])),
                $deleteContestant,
            );
        }
        
        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($allrecord),
            "recordsFiltered" => count($allrecord),
            "data" => $data,
        );
        
        echo json_encode($output);
        exit();
    }

    public function detailcontestant()
    {
        $contestant_id = $this->uri->segment(4);
        $contest_id = $this->uri->segment(5);
        $this->load->model('Category_Model', 'CategoryModel');
        $contestdetail = array('contest_id' => $contest_id);
        $contestantarray = array('contestant_id' => $contestant_id);

        $data['detailOfContestant'] = $this->ContestantModel->getcontestant($contestant_id, $contest_id);
        $whereImageArr = array(
            'contestant_id' => $contestant_id,
            'media_type' => 'image',
        );

        $data['detailOfImages'] = $this->ContestantModel->getByWhere('tbl_gallary', $whereImageArr);
        $whereVideoArr = array(
            'contestant_id' => $contestant_id,
            'media_type' => 'video',
        );
        $data['detailOfVideos'] = $this->ContestantModel->getByWhere('tbl_gallary', $whereVideoArr);

        $whereVideoArr = array(
            'contestant_id' => $contestant_id,
            'media_type' => 'youtube',
        );
        $data['detailOfYoutubeVideos'] = $this->ContestantModel->getByWhere('tbl_gallary', $whereVideoArr);

        $data['detailOfMapping'] = $this->ContestantModel->getByWhere('tbl_contestant_mapping', $contestantarray);
        $data['contestOfContestant'] = $this->ContestantModel->getByWhere('tbl_contest', $contestdetail);

        $contestArr = array('status !=' => 'delete');
        $catCondition = array(
            'status' => 'active',
            'contest_id' => $contest_id,
        );
        $data['contestList'] = $this->ContestantModel->getByWhere('tbl_contest', $contestArr);
        $data['categoryList'] = $this->CategoryModel->getByWhere('tbl_contest_category', $catCondition);

        $userId = $data['detailOfContestant'][0]['user_id'];
        $userarray = array(
            'user_id' => $userId,
        );
        $data['detailOfUser'] = $this->ContestantModel->getByWhere('tbl_user', $userarray);
        // echo '<pre>';
        // print_r($data);
        // exit;
        $this->load->view('contestantdetail_view', $data);
    }

    public function addcontestant()
    {

        $this->load->model('Category_Model', 'CategoryModel');
        $contestArr = array('status !=' => 'delete');
        $conestarray['contestList'] = $this->ContestantModel->getByWhere('tbl_contest', $contestArr);

        $catCondition = array('status' => 'active');
        $conestarray['categoryList'] = $this->CategoryModel->getByWhere('tbl_contest_category', $catCondition);
        // $conestarray['id'] = $r;
        $this->load->view('addcontestant_view', $conestarray);
    }

    public function savecontestant()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('contestant_name', lang('CONTESTANT_NAME'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
        $this->form_validation->set_rules('contest_id', lang('NAME_OF_CONTEST'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
        // $this->form_validation->set_rules('category_id', lang('LBL_CATEGORY'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
        $this->form_validation->set_rules('mobile', lang('PHONE_NO'), 'required|callback_mobile_check', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
        $this->form_validation->set_rules('email', lang('EMAIL'), 'required|valid_email|callback_email_check', array('required' => '%s ' . lang('VALIDATION_REQUIRED'), 'valid_email' => lang('VALIDATION_EMAIL')));
        $this->form_validation->set_rules('age', lang('AGE'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
        $this->form_validation->set_rules('height', lang('HEIGHT'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
        $this->form_validation->set_rules('weight', lang('WEIGHT'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
        if (empty($_FILES['main_image']['name'])) {
            $this->form_validation->set_rules('main_image', lang('MAIN_IMAGE'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
        }
        if ($this->form_validation->run() === false) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
        } else {
            $PhoneNo = $this->input->post("mobile");
            $Email = $this->input->post("email");

            // Email exists
            $isEmailExists = array();
            $emailWhereArr = array('email' => $Email, 'user_status !=' => 'deleted');
            $isEmailExists = $this->ContestantModel->getByWhere('tbl_user', $emailWhereArr);
            if (!empty($isEmailExists)) {
                $this->session->set_flashdata('error', lang('MSG_EMAIL_EXISTS'));
                redirect(BASE_URL . 'contestant');
                exit();
            }

            // Mobile no exists
            $isMobileExists = array();
            $mobileWhereArr = array('mobile' => $PhoneNo, 'user_status !=' => 'deleted');
            $isMobileExists = $this->ContestantModel->getByWhere('tbl_user', $mobileWhereArr);
            if (!empty($isMobileExists)) {
                $this->session->set_flashdata('error', lang('MSG_MOBILE_EXISTS'));
                redirect(BASE_URL . 'contestant');
                exit();
            }

            $contestantName = $this->input->post("contestant_name");
            $age = $this->input->post("age");
            $height = $this->input->post("height");
            $weight = $this->input->post("weight");
            $introductionMsg = $this->input->post("introduction");

            $password = mt_rand(10000000, 99999999); // Random 8 digit code
            $key = $this->input->post("key");
            $value = $this->input->post("value");
            $userType = 'contestant';
            $userStatus = 'active';
            $isAutologin = 0;
            $loginType = 'auth';
            $status = 'active';
            $registerDate = date('Y-m-d H:i:s');
            $contest_id = $this->input->post('contest_id');
            $contestName = $this->input->post('contestName');
            $contestCategoryId = $this->input->post('contest_category_id');
            $current_ranking = '0';
            $previous_ranking = '0';
            $status = 'Active';
            $gallaryArr = $this->input->post("gallary");
            $video_url = $this->input->post('videourl');
            // Email exists
            $isEmailExists = array();
            $emailWhereArr = array('email' => $Email, 'user_status !=' => 'deleted');
            $isEmailExists = $this->ContestantModel->getByWhere('tbl_user', $emailWhereArr);
            if (!empty($isEmailExists)) {
                $this->session->set_flashdata('error', lang('MSG_EMAIL_EXISTS'));
            } else {
                // Mobile no exists
                $isMobileExists = array();
                $mobileWhereArr = array('mobile' => $PhoneNo, 'user_status !=' => 'deleted');
                $isMobileExists = $this->ContestantModel->getByWhere('tbl_user', $mobileWhereArr);
                if (!empty($isMobileExists)) {
                    $this->session->set_flashdata('error', lang('MSG_MOBILE_EXISTS'));

                } else {
                    $userDetail = array(
                        'email' => $Email,
                        'mobile' => $PhoneNo,
                        'password' => md5($password),
                        'user_type' => $userType,
                        'user_status' => $userStatus,
                        'is_autologin' => $isAutologin,
                        'login_type' => $loginType,
                        'register_date_time' => $registerDate,
                        'update_date_time' => date('Y-m-d H:i:s'),
                    );

                    $userId = $this->ContestantModel->addUser($userDetail);
                    if ($userId) {

                        // oauth_users table insert value
                        $oauthUserInsert = $this->ContestantModel->upsertUserAuthData($Email, md5($password));

                        $profile2 = array();
                        $profileJson = "";
                        for ($i = 0; $i < count($key); $i++) {
                            if (!empty($key[$i]) && !empty($value[$i])) {
                                $profile2[$key[$i]] = $value[$i];
                            }
                        }
                        if (!empty($profile2)) {
                            $profileJson = json_encode($profile2);
                        }

                        $ContestantDetail = array(
                            'user_id' => $userId,
                            'name' => $contestantName,
                            'age' => $age,
                            'height' => $height,
                            'weight' => $weight,
                            'introduction' => $introductionMsg,
                            'profile_2' => $profileJson,
                            'created_date' => $registerDate,
                            'updated_date' => $registerDate,
                        );
                        $ContestantId = $this->ContestantModel->addContestant($ContestantDetail);
                        if ($ContestantId) {
                            $config['upload_path'] = CON_CONTESTANT_PATH;
                            $config['allowed_types'] = CON_ALLOWED_IMAGE_TYPE;
                            $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
                            $filename = $ContestantId . "_" . time() . "." . $ext;
                            $config['file_name'] = $filename;
                            $config['overwrite'] = true;
                            $config['file_name'] = $filename;
                            // $config['min_width']  = CON_IMAGE_MAX_WIDTH;
                            // $config['min_height'] = CON_IMAGE_MAX_HEIGHT;
                            // $imageDetails =    getimagesize($_FILES['main_image']['tmp_name']);
                            // $imageWidth = $imageDetails[0];
                            // $imageheight = $imageDetails[1];

                            // if($imageheight > $imageWidth){
                            //     $this->session->set_flashdata('file_upload_error',lang('MAX_HEIGHT_VALIDATION'));
                            //     redirect(BASE_URL . 'contestant/addcontestant');
                            // }

                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('main_image')) {
                                $this->session->set_flashdata('file_upload_error', lang('IMAGE_VALIDATION'));
                                redirect(BASE_URL . 'contestant/addcontestant');
                                $userWhereArr = array('user_id' => $userId);
                                $contestantWhrArr = array('contestant_id' => $ContestantId);
                                $this->ContestantModel->delete('tbl_user', $userWhereArr);
                                $this->ContestantModel->delete('tbl_contestant_details', $contestantWhrArr);
                            } else {
                                $mainProfile = $this->upload->data();
                                $updateMainImage['main_image'] = $mainProfile['file_name'];
                            }

                            if (!empty($_FILES['thumb_image']['name'])) {

                                $config1['upload_path'] = CON_CONTESTANT_PATH;
                                $config1['allowed_types'] = CON_ALLOWED_IMAGE_TYPE;
                                $ext = pathinfo($_FILES['thumb_image']['name'], PATHINFO_EXTENSION);
                                $thumbFilename = $ContestantId . "_" . time() . "_thumb." . $ext;
                                $config1['file_name'] = $filename;
                                $config1['overwrite'] = true;
                                $config1['file_name'] = $thumbFilename;
                                // $config1['min_width']  = THUMB_IMAGE_MAX_WIDTH;
                                // $config1['min_height'] = THUMB_IMAGE_MAX_HEIGHT;
                                // $config1['max_size'] = 512;
                                // $imageThumbDetails =    getimagesize($_FILES['thumb_image']['tmp_name']);
                                // $imageWidth = $imageThumbDetails[0];
                                // $imageheight = $imageThumbDetails[1];
                                // if($imageheight > $imageWidth){
                                //     $this->session->set_flashdata('file_upload_error',lang('MAX_HEIGHT_VALIDATION'));
                                //     redirect(BASE_URL . 'contestant/addcontestant');
                                // }

                                $this->upload->initialize($config1);
                                $this->load->library('upload', $config1);
                                if (!$this->upload->do_upload('thumb_image')) {
                                    $this->session->set_flashdata('file_upload_error', lang('IMAGE_VALIDATION'));
                                    redirect(BASE_URL . 'contestant/addcontestant');
                                    $userWhereArr = array('user_id' => $userId);
                                    $contestantWhrArr = array('contestant_id' => $ContestantId);
                                    $this->ContestantModel->delete('tbl_user', $userWhereArr);
                                    $this->ContestantModel->delete('tbl_contestant_details', $contestantWhrArr);
                                } else {
                                    $thumbProfile = $this->upload->data();
                                    $updateMainImage['thumb_image'] = $thumbProfile['file_name'];
                                }
                            } else {
                                $this->load->library('thumb');
                                $updateMainImage['thumb_image'] = $this->thumb->createImageThumb($mainProfile, CON_CONTESTANT_PATH, CON_CONTESTANT_PATH);
                            }

                            //Update Contestant Image
                            $whereArr = array('contestant_id' => $ContestantId);
                            $this->ContestantModel->update('tbl_contestant_details', $updateMainImage, $whereArr);

                            $mappingArr = array(
                                'contest_id' => $contest_id,
                                'contest_category_id' => $contestCategoryId,
                                'current_ranking' => $current_ranking,
                                'previous_ranking' => $previous_ranking,
                                'contestant_id' => $ContestantId,
                                'created_date' => $registerDate,
                                'updated_date' => $registerDate,
                                'status' => $status,
                            );
                            $mappingId = $this->ContestantModel->addMappingDetail($mappingArr);
                            if ($mappingId) {

                                $this->load->model('Api_Model', 'ApiModel');
                                // Update Contestant current Ranking
                                $this->ApiModel->updateCurrentRanking($contest_id);

                                //Give Free Bonus Star
                                $purchaseArr = array(
                                    'user_id' => $userId,
                                    'star' => CON_DEFAULT_SIGNUP_BONUNS,
                                    'description' => 'Welcome Bonus',
                                    'type' => 'signup',
                                    'purchase_date' => date('Y-m-d'),
                                    'created_date' => $registerDate,
                                    'updated_date' => $registerDate,
                                );
                                $purchase_id = $this->ContestantModel->insert('tbl_star_purchase', $purchaseArr);

                                // send mail to contestant
                                $android = '<a href ="https://play.google.com/store/apps/details?id=com.etech.starranking"><img src="' . CON_IMAGES_PATH . 'android2.png" width="120px"></a>';
                                $ios = '<a href="https://www.apple.com/ios/app-store/"><img src="' . CON_IMAGES_PATH . 'ios2.png" width="120px"></a>';
                                $data['mail_to'] = $Email;
                                $data['mail_subject'] = CON_SMTP_FROM_NAME . ' 참가자로 등록되었습니다.';

                                $data['mail_message'] = "안녕하세요, " . $contestantName . ", 참가자님, <br><br>” . $contestName .
                                “의 참가자로 등록되었습니다.</b>. <br>아래 정보로 로그인 하시기 바랍니다.</b>. <br> <br><br><b>아이디: </b>" .
                                    $Email . " <br><b>패스워드: </b>" . $password .
                                    " <br> <br><br>당신을 응원합니다. <br><b>랭킹스타</b>
                                 <br>
                                  <br>" . $android . "
                                 <br>  " . $ios . "";
                                $this->load->library('Mail', $data);
                                if (!$this->mail->sendMail()) {
                                    $this->session->set_flashdata('error', lang('EMAIL_SENT_FAILED'));
                                }

                                if (!empty($gallaryArr)) {
                                    foreach ($gallaryArr as $gallary) {
                                        $gallaryId = array(
                                            'media_id' => $gallary,
                                        );
                                        $gallaryWhere = array(
                                            'contestant_id' => $ContestantId,
                                        );
                                        $gallaryAdd = $this->ContestantModel->update('tbl_gallary', $gallaryWhere, $gallaryId);
                                    }
                                }

                                if (!empty($video_url)) {
                                    foreach ($video_url as $url) {
                                        $a = preg_match(EQUATION, $url, $matches);
                                        if (!empty($matches)) {
                                            $video_id = $matches[2];
                                            $thumb_image = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
                                            $gallaryArr = array(
                                                'contestant_id' => $ContestantId,
                                                'media_name' => $url,
                                                'media_path' => $url,
                                                'thumb_path' => $thumb_image,
                                                'media_type' => 'youtube',
                                                'status' => 'active',
                                                'created_date' => $registerDate,
                                                'updated_date' => $registerDate,
                                            );
                                            $gallaryAdd = $this->ContestantModel->insert('tbl_gallary', $gallaryArr);

                                        }

                                    }
                                }
                                adminLogMessage('Add Contestant',$userDetail,$ContestantId);
                                $this->session->set_flashdata('contestant_msg', lang('CONTESTANT_ADDED'));
                                redirect(BASE_URL . 'contestant/index/' . $contest_id);

                            } else {
                                $this->session->set_flashdata('error', lang('CONTESTANT_FAILED'));
                                redirect(BASE_URL . 'contestant');
                            }
                        } else {
                            $this->session->set_flashdata('error', lang('CONTESTANT_FAILED'));
                            redirect(BASE_URL . 'contestant');
                        }
                    } else {
                        $this->session->set_flashdata('error', lang('CONTESTANT_FAILED'));
                        redirect(BASE_URL . 'contestant');
                    }
                }

            }

        }

        $this->load->model('Category_Model', 'CategoryModel');
        $catCondition = array('status' => 'active');
        $contestArr = array('status !=' => 'delete');
        $conestarray['contestList'] = $this->ContestantModel->getByWhere('tbl_contest', $contestArr);
        $conestarray['categoryList'] = $this->CategoryModel->getByWhere('tbl_contest_category', $catCondition);
        $this->load->view('addcontestant_view', $conestarray);
    }

    public function email_check($email, $user_id)
    {
        $emailWhereArr = array('email' => $email, 'user_status !=' => 'deleted');
        if(!empty($user_id)){
            $emailWhereArr['user_id !='] = $user_id;
        }
        $isEmailExists = $this->ContestantModel->getByWhere('tbl_user', $emailWhereArr);
        if (!empty($isEmailExists)) {
            $this->form_validation->set_message('email_check', lang('MSG_EMAIL_EXISTS'));
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function mobile_check($mobile, $user_id)
    {
        $mobileWhereArr = array('mobile' => $mobile, 'user_status !=' => 'deleted');
        if(!empty($user_id)){
            $mobileWhereArr['user_id !='] = $user_id;
        }
        $isMobileExists = $this->ContestantModel->getByWhere('tbl_user', $mobileWhereArr);
        if (!empty($isMobileExists)) {
            $this->form_validation->set_message('mobile_check', lang('MSG_MOBILE_EXISTS'));
            return FALSE;
        }else{
            return TRUE;
        }
    }


    public function editcontestant()
    {

        $gallaryArr = $this->input->post("gallary");
        $contestId = $this->input->post('contest_id');
        $oldContestId = $this->input->post('old_contest_id');
        $contestantId = $this->input->post('contestant_id');
        $contest_category_id = $this->input->post("contest_category_id");
        $userId = $this->input->post("user_id");
        $this->load->library('form_validation');

        $this->form_validation->set_rules('contestant_name', lang('CONTESTANT_NAME'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
        // $this->form_validation->set_rules('contest_id', lang('NAME_OF_CONTEST'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
        $this->form_validation->set_rules('mobile', lang('PHONE_NO'), 'required|callback_mobile_check['.$userId.']', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
        $this->form_validation->set_rules('email', lang('EMAIL'), 'required|valid_email|callback_email_check['.$userId.']', array('required' => '%s ' . lang('VALIDATION_REQUIRED'), 'valid_email' => lang('VALIDATION_EMAIL')));
        $this->form_validation->set_rules('age', lang('AGE'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
        $this->form_validation->set_rules('height', lang('HEIGHT'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
        $this->form_validation->set_rules('weight', lang('WEIGHT'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));

        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            if ($oldContestId) {
                redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId . '/' . $oldContestId);
            }
            redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId);
        } else {
            
            $contestantName = $this->input->post("contestant_name");
            $age = $this->input->post("age");
            $height = $this->input->post("height");
            $weight = $this->input->post("weight");
            $introductionMsg = $this->input->post("introduction");
            $phoneNo = $this->input->post("mobile");
            $email = $this->input->post("email");

            $key = $this->input->post("key");
            $value = $this->input->post("value");
            $status = $this->input->post("status");
            $updatedDate = date('Y-m-d H:i:s');
            $video_url = $this->input->post('videourl');
            $videoId = $this->input->post("videoId");

            // storing profile in json form
            $profile2 = array();
            $profileJson = "";
            for ($i = 0; $i < count($key); $i++) {
                if (!empty($key[$i]) && !empty($value[$i])) {
                    $profile2[$key[$i]] = $value[$i];
                }
            }

            if (!empty($profile2)) {
                $profileJson = json_encode($profile2);
            }

            // Email exists
            $isEmailExists = array();
            $emailWhereArr = array('user_id !=' => $userId, 'email' => $email, 'user_status !=' => 'deleted');
            $isEmailExists = $this->ContestantModel->getByWhere('tbl_user', $emailWhereArr);

            // Mobile no exists
            $isMobileExists = array();
            $mobileWhereArr = array('user_id !=' => $userId, 'mobile' => $phoneNo, 'user_status !=' => 'deleted');
            $isMobileExists = $this->ContestantModel->getByWhere('tbl_user', $mobileWhereArr);

            if (!empty($isEmailExists)) {
                $this->session->set_flashdata('error', lang('MSG_EMAIL_EXISTS'));
                if ($oldContestId) {
                    redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId . '/' . $oldContestId);
                }
                redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId);
            } else {
                if (!empty($isMobileExists)) {
                    $this->session->set_flashdata('error', lang('MSG_MOBILE_EXISTS'));
                    if ($oldContestId) {
                        redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId . '/' . $oldContestId);
                    }
                    redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId);
                } else {
                    $contestantArray = array(
                        'name' => $contestantName,
                        // 'category_id' => $contest_category_id,
                        'age' => $age,
                        'height' => $height,
                        'weight' => $weight,
                        'profile_2' => $profileJson,
                        'introduction' => $introductionMsg,
                        'status' => $status,
                        'updated_date' => $updatedDate,
                    );
                    if (!empty($_FILES['main_image']['name'])) {
                        //Remove All files associated with this user
                        // $files = glob(CON_CONTESTANT_PATH . $contestantId . "_*");
                        // // Deleting all the files in the list
                        // foreach ($files as $file) {
                        //     if (is_file($file)) {
                        //         // Delete the given file
                        //         unlink($file);
                        //     }
                        // }
                        $config['upload_path'] = CON_CONTESTANT_PATH;
                        $config['allowed_types'] = CON_ALLOWED_IMAGE_TYPE;
                        $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
                        $filename = $contestantId . "_" . time() . "." . $ext;
                        $config['file_name'] = $filename;
                        // $config['min_width']  = CON_IMAGE_MAX_WIDTH;
                        // $config['min_height'] = CON_IMAGE_MAX_HEIGHT;
                        $config['overwrite'] = true;
                        // $imageDetails =    getimagesize($_FILES['main_image']['tmp_name']);
                        // $imageWidth = $imageDetails[0];
                        // $imageheight = $imageDetails[1];

                        // if($imageheight > $imageWidth){
                        //     $this->session->set_flashdata('error',lang("MAX_HEIGHT_VALIDATION"));
                        //     if ($oldContestId) {
                        //         redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId . '/' . $oldContestId);
                        //     }
                        //     redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId);
                        // }
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('main_image')) {
                            $this->session->set_flashdata('error', lang("IMAGE_VALIDATION"));
                            if ($oldContestId) {
                                redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId . '/' . $oldContestId);
                            }
                            redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId);
                        } else {
                            $mainProfile = $this->upload->data();
                            $contestantArray['main_image'] = $mainProfile['file_name'];
                            // $this->load->library('thumb');
                            // $contestantArray['thumb_image'] = $this->thumb->createImageThumb($mainProfile, CON_CONTESTANT_PATH, CON_CONTESTANT_PATH);
                        }
                    }

                    if (!empty($_FILES['thumb_image']['name'])) {

                        $config2['upload_path'] = CON_CONTESTANT_PATH;
                        $config2['allowed_types'] = CON_ALLOWED_IMAGE_TYPE;
                        $ext = pathinfo($_FILES['thumb_image']['name'], PATHINFO_EXTENSION);
                        $thumbFilename = $contestantId . "_" . time() . "_thumb." . $ext;
                        $config2['file_name'] = $thumbFilename;
                        // $config2['min_width']  = THUMB_IMAGE_MAX_WIDTH;
                        // $config2['min_height'] = THUMB_IMAGE_MAX_HEIGHT;
                        // $config2['max_size'] = 512;
                        $config2['overwrite'] = true;
                        // $imageThumbDetails =    getimagesize($_FILES['thumb_image']['tmp_name']);
                        // $imageWidth = $imageThumbDetails[0];
                        // $imageheight = $imageThumbDetails[1];
                        // if($imageheight > $imageWidth){
                        //     $this->session->set_flashdata('error',lang("MAX_HEIGHT_VALIDATION"));
                        //     if ($oldContestId) {
                        //         redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId . '/' . $oldContestId);
                        //     }
                        //     redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId);
                        // }
                        $this->load->library('upload', $config2);
                        $this->upload->initialize($config2);
                        if (!$this->upload->do_upload('thumb_image')) {
                            $this->session->set_flashdata('error', lang("IMAGE_VALIDATION"));
                            if ($oldContestId) {
                                redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId . '/' . $oldContestId);
                            }
                            redirect(BASE_URL . 'contestant/detailcontestant/' . $contestantId);
                        } else {

                            $thumbProfile = $this->upload->data();
                            $contestantArray['thumb_image'] = $thumbProfile['file_name'];

                        }
                    }
                    //     else{
                    //         if (!empty($_FILES['main_image']['name'])) {
                    //         $this->load->library('thumb');
                    //         $contestantArray['thumb_image'] = $this->thumb->createImageThumb($mainProfile, CON_CONTESTANT_PATH, CON_CONTESTANT_PATH);
                    //     }
                    // }

                    $whereArr = array('contestant_id' => $contestantId);
                    $contestantUpdate = $this->ContestantModel->update('tbl_contestant_details', $contestantArray, $whereArr);

                    $userArray = array(
                        'email' => $email,
                        'mobile' => $phoneNo,
                        'update_date_time' => $updatedDate,
                    );

                    $userWhereArr = array('user_id' => $userId);
                    $userUpdate = $this->ContestantModel->update('tbl_user', $userArray, $userWhereArr);

                    if ($contestId) {
                        $contestWheArr = array(
                            'contest_id' => $oldContestId,
                            'contestant_id' => $contestantId,
                        );
                        $mappingarr = array(
                            'contest_id' => $contestId,
                            'contest_category_id' => $contest_category_id,
                        );
                        $mappingUpdate = $this->ContestantModel->update('tbl_contestant_mapping', $mappingarr, $contestWheArr);
                    }
                    if (!empty($gallaryArr)) {
                        foreach ($gallaryArr as $gallary) {
                            $gallaryId = array(
                                'media_id' => $gallary,
                            );
                            $gallaryWhere = array(
                                'contestant_id' => $contestantId,
                            );
                            $gallaryAdd = $this->ContestantModel->update('tbl_gallary', $gallaryWhere, $gallaryId);
                        }
                    }

                    if (!empty($video_url) && !empty($videoId)) {
                        if ($video_url[0] != "" && $videoId[0] != "") {
                            // echo "YES";exit();
                            $gallaryWhere = array(
                                'media_id' => $videoId[0],
                            );

                            $a = preg_match(EQUATION, $video_url[0], $matches);
                            if (!empty($matches)) {

                                $video_id = $matches[2];
                                $thumb_image = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
                                $gallaryArr = array(
                                    'media_name' => $video_url[0],
                                    'media_path' => $video_url[0],
                                    'thumb_path' => $thumb_image,
                                    'updated_date' => $updatedDate,
                                );

                                $gallaryUpdate = $this->ContestantModel->update('tbl_gallary', $gallaryArr, $gallaryWhere);
                            }

                        }
                        if ($video_url[1] != "" && $videoId[1] != "") {
                            // echo "YES";exit();
                            $gallaryWhere = array(
                                'media_id' => $videoId[1],
                            );

                            $a = preg_match(EQUATION, $video_url[1], $matches);
                            if (!empty($matches)) {

                                $video_id = $matches[2];
                                $thumb_image = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
                                $gallaryArr = array(
                                    'media_name' => $video_url[1],
                                    'media_path' => $video_url[1],
                                    'thumb_path' => $thumb_image,
                                    'updated_date' => $updatedDate,
                                );

                                $gallaryUpdate = $this->ContestantModel->update('tbl_gallary', $gallaryArr, $gallaryWhere);
                            }

                        }
                        if ($video_url[2] != "" && $videoId[2] != "") {
                            // echo "YES";exit();
                            $gallaryWhere = array(
                                'media_id' => $videoId[2],
                            );

                            $a = preg_match(EQUATION, $video_url[2], $matches);
                            if (!empty($matches)) {

                                $video_id = $matches[2];
                                $thumb_image = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
                                $gallaryArr = array(
                                    'media_name' => $video_url[2],
                                    'media_path' => $video_url[2],
                                    'thumb_path' => $thumb_image,
                                    'updated_date' => $updatedDate,
                                );

                                $gallaryAdd = $this->ContestantModel->update('tbl_gallary', $gallaryArr, $gallaryWhere);
                            }

                        }

                        if ($video_url[0] != "" && $videoId[0] == "") {
                            $a = preg_match(EQUATION, $video_url[0], $matches);
                            if (!empty($matches)) {

                                $video_id = $matches[2];
                                $thumb_image = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
                                $gallaryArr0 = array(
                                    'contestant_id' => $contestantId,
                                    'media_name' => $video_url[0],
                                    'media_path' => $video_url[0],
                                    'thumb_path' => $thumb_image,
                                    'media_type' => 'youtube',
                                    'status' => 'active',
                                    'created_date' => $updatedDate,
                                    'updated_date' => $updatedDate,
                                );

                                $gallaryAdd = $this->ContestantModel->insert('tbl_gallary', $gallaryArr0);

                            }
                        }

                        if ($video_url[1] != "" && $videoId[1] == "") {
                            $a = preg_match(EQUATION, $video_url[1], $matches);
                            if (!empty($matches)) {

                                $video_id = $matches[2];
                                $thumb_image = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
                                $gallaryArr1 = array(
                                    'contestant_id' => $contestantId,
                                    'media_name' => $video_url[1],
                                    'media_path' => $video_url[1],
                                    'thumb_path' => $thumb_image,
                                    'media_type' => 'youtube',
                                    'status' => 'active',
                                    'created_date' => $updatedDate,
                                    'updated_date' => $updatedDate,
                                );

                                $gallaryAdd = $this->ContestantModel->insert('tbl_gallary', $gallaryArr1);
                            }
                        }
                        if ($video_url[2] != "" && $videoId[2] == "") {
                            $a = preg_match(EQUATION, $video_url[2], $matches);
                            if (!empty($matches)) {

                                $video_id = $matches[2];
                                $thumb_image = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
                                $gallaryArr2 = array(
                                    'contestant_id' => $contestantId,
                                    'media_name' => $video_url[2],
                                    'media_path' => $video_url[2],
                                    'thumb_path' => $thumb_image,
                                    'media_type' => 'youtube',
                                    'status' => 'active',
                                    'created_date' => $updatedDate,
                                    'updated_date' => $updatedDate,
                                );

                                $gallaryAdd = $this->ContestantModel->insert('tbl_gallary', $gallaryArr2);
                            }
                        }
                        if ($video_url[0] == "" && $videoId[0] != "") {
                            $gallaryDelete = array(
                                'media_id' => $videoId[0],
                            );
                            $gallaryDelete = $this->ContestantModel->delete('tbl_gallary', $gallaryDelete);

                        }
                        if ($video_url[1] == "" && $videoId[1] != "") {
                            $gallaryDelete1 = array(
                                'media_id' => $videoId[1],
                            );
                            $gallaryDelete = $this->ContestantModel->delete('tbl_gallary', $gallaryDelete1);

                        }
                        if ($video_url[2] == "" && $videoId[2] != "") {
                            $gallaryDelete2 = array(
                                'media_id' => $videoId[2],
                            );
                            $gallaryDelete = $this->ContestantModel->delete('tbl_gallary', $gallaryDelete2);

                        }

                    }

                    $this->session->set_flashdata('contestant_update_msg', lang('CONTESTANT_UPDATED'));
                    redirect(BASE_URL . 'contestant');
                }
            }
        }
        $this->session->set_flashdata('contestant_update_msg', lang('CONTESTANT_UPDATED'));
        redirect(BASE_URL . 'contestant');
    }

    public function removeVideo()
    {
        $mediaName = $this->input->post('videoName');

        $whereArr = array('media_name' => $mediaName);

        $mediaDetail = $this->ContestantModel->getByWhere('tbl_gallary', $whereArr);

        $imageName = $mediaDetail[0]['media_name'];
        $thumbName = $mediaDetail[0]['thumb_path'];
        $gallaryId = array(
            'media_id' => $mediaDetail[0]['media_id'],
        );
        $result = $this->ContestantModel->delete('tbl_gallary', $gallaryId);
        if ($result == 1) {
            unlink(CON_GALLARY_PATH . $imageName);
            unlink(CON_GALLARY_THUMB_PATH . $thumbName);
        }
        return $result;
    }

    public function deleteGallaryImages()
    {
        $mediaId = $this->input->post('media_id');

        $whereArr = array('media_id' => $mediaId);
        $mediaDetail = $this->ContestantModel->getByWhere('tbl_gallary', $whereArr);

        $imageName = $mediaDetail[0]['media_name'];
        $thumbName = $mediaDetail[0]['thumb_path'];

        $result = $this->ContestantModel->delete('tbl_gallary', $whereArr);
        if ($result == 1) {
            unlink(CON_GALLARY_PATH . $imageName);
            unlink(CON_GALLARY_THUMB_PATH . $thumbName);
        }
        return $result;
    }

    public function deleteGallaryVideos()
    {
        $mediaId = $this->input->post('media_id');

        $whereArr = array('media_id' => $mediaId);
        $mediaDetail = $this->ContestantModel->getByWhere('tbl_gallary', $whereArr);

        $imageName = $mediaDetail[0]['media_name'];
        $thumbName = $mediaDetail['thumb_path'];

        $result = $this->ContestantModel->delete('tbl_gallary', $whereArr);
        if ($result === 1) {
            unlink(CON_GALLARY_PATH . $imageName);
            unlink(CON_GALLARY_THUMB_PATH . $thumbName);
        }
        return $result;
    }

    public function removeImage()
    {
        $mediaName = $this->input->post('name');

        $whereArr = array('media_name' => $mediaName);
        $mediaDetail = $this->ContestantModel->getByWhere('tbl_gallary', $whereArr);

        $imageName = $mediaDetail[0]['media_name'];
        $thumbName = $mediaDetail[0]['thumb_path'];
        $gallaryId = array(
            'media_id' => $mediaDetail[0]['media_id'],
        );
        $result = $this->ContestantModel->delete('tbl_gallary', $gallaryId);
        // print_r($result);exit();
        if ($result === 1) {
            unlink(CON_GALLARY_PATH . $imageName);
            unlink(CON_GALLARY_THUMB_PATH . $thumbName);
        }
        return $result;
    }

    public function gallaryImageUpload()
    {
        $status = 'active';
        $media_type = 'image';
        $createdDate = date('Y-m-d H:i:s');
        $updatedDate = date('Y-m-d H:i:s');
        $config['upload_path'] = CON_GALLARY_PATH;
        $config['allowed_types'] = CON_ALLOWED_IMAGE_TYPE;
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $filename = $media_type . "_" . time() . "." . $ext;
        $config['file_name'] = $filename;
        $config['overwrite'] = true;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $galleryImage = $this->upload->data();
            $galleryProfileImage = $galleryImage['file_name'];
            $this->load->library('thumb');
            $thumb_name = $this->thumb->createImageThumb($galleryImage, CON_GALLARY_PATH, CON_GALLARY_THUMB_PATH);
            $galleryDetail = array(
                'media_name' => $galleryProfileImage,
                'media_path' => $galleryProfileImage,
                'thumb_path' => $thumb_name,
                'media_type' => $media_type,
                'status' => $status,
                'created_date' => $createdDate,
                'updated_date' => $updatedDate,
            );
            $galleryId = $this->ContestantModel->addGalleryDetail($galleryDetail);
            $resArr = array('res_code' => 1, 'data' => array('file_id' => $galleryId, 'file_name' => $galleryProfileImage));
            header('Content-Type: application/json');
            echo json_encode($resArr);
            exit();

        }
    }

    public function gallaryVideoUpload()
    {
        $status = 'active';
        $media_type = 'video';
        $createdDate = date('Y-m-d H:i:s');
        $updatedDate = date('Y-m-d H:i:s');
        $config['upload_path'] = CON_GALLARY_PATH;
        $config['allowed_types'] = CON_ALLOWED_VIDEO_TYPE;
        $ext = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
        $filename = $media_type . "_" . time() . "." . $ext;
        $config['file_name'] = $filename;
        $config['overwrite'] = true;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('video')) {
            $galleryImage = $this->upload->data();
            $galleryProfileImage = $galleryImage['file_name'];

            //Create thumb for Video
            $thumb_size = VIDEO_THUMB_SIZE;
            $getFromSeconds = VIDEO_FROM_SECOND;
            $source_file = CON_GALLARY_PATH . $galleryImage['file_name'];
            $targetfile = CON_GALLARY_THUMB_PATH . $galleryImage['raw_name'] . '_thumb.jpg';
            $cmd = "/rankingstar/bin/ffmpeg -itsoffset -1 -i $source_file -vframes 1 -filter:v scale='280:-1' -deinterlace -an -ss $getFromSeconds -f mjpeg -t 1 -r 1 -y $targetfile 2>&1";
            //    $cmd = "/rankingstar/bin/ffmpeg -i $source_file -deinterlace -an -ss $getFromSeconds -f mjpeg -t 1 -r 1 -y -s $thumb_size $targetfile 2>&1";
            exec($cmd, $retArr, $retVal);
            // print_r($retVal);exit();
            // shell_exec($cmd);

            $thumb_name = "";
            if (!$retVal) {

                $thumb_name = $galleryImage['raw_name'] . '_thumb.jpg';
            }

            // $this->load->library('thumb');
            // $thumb_name = $this->thumb->createImageThumb($galleryImage, CON_GALLARY_PATH, CON_GALLARY_THUMB_PATH);
            $galleryDetail = array(
                'media_name' => $galleryProfileImage,
                'media_path' => $galleryProfileImage,
                'thumb_path' => $thumb_name,
                'media_type' => $media_type,
                'status' => $status,
                'created_date' => $createdDate,
                'updated_date' => $updatedDate,
            );
            $galleryId = $this->ContestantModel->addGalleryDetail($galleryDetail);
            $resArr = array('res_code' => 1, 'data' => array('file_id' => $galleryId, 'file_name' => $galleryProfileImage));
            header('Content-Type: application/json');
            echo json_encode($resArr);
            exit();
        }
    }

    public function getCategoryFromContest()
    {
        $this->load->model('Category_Model', 'CategoryModel');
        $contestId = $this->input->post('contestId');
        $whereArr = array('contest_id' => $contestId);
        $categoryArr = $this->CategoryModel->getByWhere('tbl_contest_category', $whereArr);
        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
        $this->resArr[CON_RES_MESSAGE] = '';
        $this->resArr[CON_RES_DATA] = array('categoryData' => $categoryArr);
        $this->sendResponse($this->resArr);
    }

    public function deleteContestant()
    {
        $contestantId = $this->input->post('contestantId');
        $contestId = $this->input->post('contestId');

        $this->load->model('Api_Model', 'ApiModel');

        $contestantWhr = array('contestant_id' => $contestantId);
        $contestantDetail = $this->ContestantModel->getByWhere('tbl_contestant_details', $contestantWhr);
        $userId = $contestantDetail[0]['user_id'];

        $contestantUpdateArr = array('status' => 'deleted');
        $contestantUpdate = $this->ContestantModel->update('tbl_contestant_details', $contestantUpdateArr, $contestantWhr);
        if ($contestantUpdate == 1) {
            $userWhr = array('user_id' => $userId);
            $userUpdateArr = array('user_status' => 'deleted');
            $userUpdate = $this->ContestantModel->update('tbl_user', $userUpdateArr, $userWhr);
            if ($userUpdate == 1) {
                // update contestant rank
                $this->ApiModel->updateCurrentRanking($contestId);
                $resData = array('res_code' => 1, 'res_message' => lang('MSG_CONTESTANT_DELETED'));

            } else {
                $resData = array('res_code' => 1, 'res_message' => lang('MSG_CONTESTANT_DELETED_FAIL'));

            }
        } else {
            $resData = array('res_code' => 0, 'res_message' => lang('MSG_CONTESTANT_DELETED_FAIL'));
        }
        header('Content-Type: application/json');
        echo json_encode($resData);

    }

}
