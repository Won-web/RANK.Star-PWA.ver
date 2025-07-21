<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contest extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->auth->isLogin()) {
            redirect(CON_LOGIN_PATH);
        }
        require_once APPPATH . "/third_party/apns/PushNotification.php";
        $this->setWebLanguage();
        $this->load->model('Contest_Model', 'ContestModel');
    }

    public function index()
    {
        
        // print_r( $data['listofcontestant']);exit();
        $this->load->view('listofcontest_view');
    }

    public function contestList()
    {
             

        $sortColumn = ['t1.contest_name', 't1.vote_open_date', 't1.vote_close_date', 'user_count', 'total_vote', 't1.status'];

        // print_r($sortColumn); exit();
        $draw = intval($this->input->post("draw"));
        $offset = intval($this->input->post("start"));
        $limit = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $order = $this->input->post("order");

        if($draw === 1){
            $count = 0;
        }else if ($draw > 1){
            $count = $offset;
        }


        $searchText = "";
        if (!empty($search['value'])) {
            $searchText = $search['value'];
        }

        $column = $order[0]['column'];
        $sort_by = $order[0]['dir'];
        // $order_by = $sortColumn[$column];
        $order_by = null;
        $getContestArr = array(
            'status !=' => 'delete',
        );
        $allrecord = $this->ContestModel->getByWhere('tbl_contest' , $getContestArr);
        $listofcontest = $this->ContestModel->listOfContest($searchText, $order_by, $sort_by, $offset, $limit);
        $data = array();
        // $maping = '<a  class="mappingContestant" data-toggle="modal" data-target="#exampleModalLabel" data-id="'.$contest['contest_id'].'"><i class="fas fa-map-pin"></i></a>';
        foreach ($listofcontest  as $contest) {
            $count ++;
            $sessionData = $this->auth->getUserSession();
            $maping='';
            $deleteContest = '';
            $show_main_banner = '';
            $hide_contest = '';
            if ($sessionData['user_type'] === "admin") {
                $maping = '<a  class="mappingContestant" data-toggle="modal" data-div-target="exampleModalLabel" data-id="' . $contest['contest_id'] . '" ><i class="fas fa-map-pin"></i></a>';
                $deleteContest = '<a class="deleteContest" data-toggle="modal" data-div-target="exampleModalLabel" data-id="' . $contest['contest_id'] . '" ><i class="fas fa-trash"></i></a>';
                $show_main_banner = '<input type="checkbox" class="showBannerClass"  name="show_main_banner" id="show_main_banner" value="true" data-id="' . $contest['contest_id'] . '" data-value="'.$contest['show_main_banner'].'"  '.  (($contest['show_main_banner'] == 'true') ? "checked" : "").'>';
                $hide_contest = '<input type="checkbox" name="hide_contest" id="hide_contest" data-toggle="toggle"   value="Hide"  data-id="' . $contest['contest_id'] . '"  '.  (($contest['hide_contest'] == 'Hide') ? "checked" : "").' ">';
                // $hide_contest =' <label class="switch"><input type="checkbox" id="togBtn"  class="hide_contest"  name="hide_contest" value="Hide"> <div class="slider round"><span class="on">HIDE</span> <span class="off">SHOW</span></div> </label>  ';
            }
            $data[] = array(
               $count ,
              $show_main_banner ,
                '<a href="' . BASE_URL . 'contest/detailcontest/' . $contest['contest_id'] . '">' . $contest['contest_name'] . '</a>',
                date('Y-m-d', strtotime($contest['vote_open_date'])),
                date('Y-m-d', strtotime($contest['vote_close_date'])),
                '<a href="' . BASE_URL . 'contestant?contestid=' . $contest['contest_id'] . '">' . $contest['user_count'] . '</a>',
                number_format($contest['total_vote']),
                lang($contest['status']),               
                $maping,
                $hide_contest,
                $deleteContest
            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($allrecord),
            "recordsFiltered" => count($allrecord),
            "data" => $data
        );

        echo json_encode($output);
        exit();
    }

    public function addcontest()
    {
        $this->load->view('addcontest_view');
    }

    public function savecontest()
    {
        if ($this->input->post()) {   
            
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('contest_name', lang('NAME_OF_CONTEST'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('status', lang('STATUS'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('description', lang('CONTEST_DESCRIPTION'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('vote_open_date', lang('VOTE_OPEN_DATE'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('vote_close_date', lang('VOTE_CLOSING_DATE'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('fees_percent', lang('FEES'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('cost', lang('COST'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            
            if (empty($_FILES['main_banner']['name'])) {
                $this->form_validation->set_rules('main_banner', lang('MAIN_BANNER'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            }
            if (empty($_FILES['sub_banner']['name'])) {
                $this->form_validation->set_rules('sub_banner', lang('SUB_BANNER'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            }
            // if (empty($_FILES['home_page']['name'])) {
            //     $this->form_validation->set_rules('home_page', lang('HOME_PAGE_BANNER'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            // }

            if ($this->form_validation->run() === false) {
                $errors = validation_errors();
                $this->session->set_flashdata('error', $errors);
            } else {
                $config['upload_path'] = CON_CONTEST_PATH ;
                $config['allowed_types'] = CON_ALLOWED_IMAGE_TYPE ;
                $ext = pathinfo($_FILES['main_banner']['name'], PATHINFO_EXTENSION);
                $filename = "main_banner_" . time() . "." . $ext;
                $config['file_name'] = $filename;
                $config['overwrite'] = true;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('main_banner')) {
                    $this->session->set_flashdata('file_upload_error', $this->upload->display_errors());
                    redirect(BASE_URL . 'contest/addcontest');
                } else {
                    $main = array('upload_mainbanner' => $this->upload->data());
                    $config1['upload_path'] = CON_CONTEST_PATH ;
                    $config1['allowed_types'] = CON_ALLOWED_IMAGE_TYPE ;
                    $ext = pathinfo($_FILES['sub_banner']['name'], PATHINFO_EXTENSION);
                    $filename1 = "sub_banner_" . time() . "." . $ext;
                    $config1['file_name'] = $filename1;
                    $config1['overwrite'] = true;
                    $this->upload->initialize($config1);
                    $this->load->library('upload', $config1);
                    if (!$this->upload->do_upload('sub_banner')) {
                        $this->session->set_flashdata('file_upload_error', $this->upload->display_errors());
                        redirect(BASE_URL . 'contest/addcontest');
                    } else {
                        $sub = array('upload_subbanner' => $this->upload->data());
                    }
                }
                
                // upload sub home banner
                // if ($this->upload->do_upload('home_page')) {
                //     $homeBannerURL = "api/contestWebView?contest_id=";
                //     $homeBannerData = array('bannerData' => $this->upload->data());
                // } else {
                //     $this->session->set_flashdata('file_upload_error', $this->upload->display_errors());
                //     redirect(BASE_URL . 'contest/addcontest');
                // }
                $contestName = $this->input->post('contest_name');
                $categoryArr = json_decode($this->input->post('category_name'));
                $voteOpenDate = $this->input->post('vote_open_date');
                $voteCloseDate = $this->input->post('vote_close_date');
                $ContestDescription = $this->input->post('description');
                $partner = $this->input->post('partner');
                $fees = $this->input->post('fees_percent');
                $cost = $this->input->post('cost');
                $memo = $this->input->post('memo');
                $status = $this->input->post('status');
                $homePage = $this->input->post('home_page');
                $show_main_banner = $this->input->post('show_main_banner');
                $hide_contest = $this->input->post('hide_contest');
                $createdDate = date('Y-m-d H:i:s');
                $main_banner = $main['upload_mainbanner']['file_name'];
                $sub_banner = $sub['upload_subbanner']['file_name'];
                $homeBannerURL = "api/contestWebView?contest_id=";                
                $homePageImage = '';
                
                $contestData = array(
                    'contest_name' => $contestName,
                    'vote_open_date' => $voteOpenDate,
                    'vote_close_date' => $voteCloseDate,
                    'description' => $ContestDescription,
                    'main_banner' => $main_banner,
                    'sub_banner' => $sub_banner,
                    'partner' => $partner,
                    'fees_percent' => $fees,
                    'cost' => $cost,
                    'memo' => $memo,
                    'home_page' => $homePage,
                    'home_page_image' => $homePageImage,
                    'web_page_url' => $homeBannerURL,
                    'status' => $status,
                    'created_date'  => $createdDate,
                    'updated_date' => date('Y/m/d H:i:s'),
                );
                if(!empty($show_main_banner)){
                    $contestData['show_main_banner'] = $show_main_banner;
                }
                if(!empty($hide_contest)){
                    $contestData['hide_contest'] = $hide_contest;
                }
                $contestId = $this->ContestModel->addContest($contestData);
                foreach ($categoryArr as $category) {
                    $categoryData = array(
                        'category_name' => $category->value,
                        'contest_id' => $contestId,
                    );
                    $this->addCategoryFromContest($categoryData);
                }
                if ($contestId) {
                    $this->session->set_flashdata('contest_msg', lang('CONTEST_ADDED'));
                    redirect(BASE_URL . 'contest');
                }
            }
        }
        $this->load->view('addcontest_view');
    }

    /**
     * Add multiple categories
     */
    public function addCategoryFromContest($params = array()) {
        $this->load->model('Category_Model', 'CategoryModel');
        $currentDate = date('Y-m-d H:i:s');
        if(!empty($params)) {
            $categoryData = array(
                'category_name' => $params['category_name'],
                'contest_id' => $params['contest_id'],
                'status' => 'active',
                'updated_date' => $currentDate,
                'created_date' => $currentDate
            );
            $this->CategoryModel->insert('tbl_contest_category', $categoryData);
        }        
    }

    public function detailcontest($contestId = null)
    {
        $this->load->model('Category_Model', 'CategoryModel');
        if(!empty($contestId)) {
            $contest_id = $contestId;
        } else {
            $contest_id = $this->uri->segment(3);
        }
        $contestarray = array('contest_id' => $contest_id);
        $categoryWhere = array('contest_id' => $contest_id);
        $data['detail'] = $this->ContestModel->getByWhere('tbl_contest', $contestarray);
        $data['totalcontestant'] = $this->ContestModel->getContestant($contest_id);
        $categoryItems = $this->CategoryModel->getByWhere('tbl_contest_category', $categoryWhere);
        $categoryArr = Array();
        foreach ($categoryItems as $category) {
            array_push($categoryArr, $category['category_name']);
        }
        $data['categoryArr'] = $categoryArr;
        $this->load->view('detailcontest_view', $data);
    }

    public function editcontest()
    {     
        $main_banner = '';
        $sub_banner = '';
        $homeBannerURL = '';
        $homePageImage = '';
        $config['upload_path'] = CON_CONTEST_PATH ;
        $config['allowed_types'] = CON_ALLOWED_IMAGE_TYPE ;
        $ext = pathinfo($_FILES['main_banner']['name'], PATHINFO_EXTENSION);
        $filename = "main_banner_" . time() . "." . $ext;
        $config['file_name'] = $filename;
        $config['overwrite'] = true;
        $this->load->library('upload', $config);
        if (!empty($_FILES['main_banner']['name'])) {
            if($this->upload->do_upload('main_banner')) {
                $main = array('upload_mainbanner' => $this->upload->data());
                $main_banner = $main['upload_mainbanner']['file_name'];
            } else {
                $this->session->set_flashdata('file_upload_error', $this->upload->display_errors());
                redirect(BASE_URL . 'contest/detailcontest/'.$this->input->post('contest_id'));
            }
        }
        if (!empty($_FILES['sub_banner']['name'])) {
            $config1['upload_path'] = CON_CONTEST_PATH ;
            $config1['allowed_types'] = CON_ALLOWED_IMAGE_TYPE ;
            $ext = pathinfo($_FILES['sub_banner']['name'], PATHINFO_EXTENSION);
            $filename1 = "sub_banner_" . time() . "." . $ext;
            $config1['file_name'] = $filename1;
            $config1['overwrite'] = true;
            $this->upload->initialize($config1);
            $this->load->library('upload', $config1);
            if($this->upload->do_upload('sub_banner')) {
                $sub = array('upload_subbanner' => $this->upload->data());
                $sub_banner = $sub['upload_subbanner']['file_name'];
            } else {
                $this->session->set_flashdata('file_upload_error', $this->upload->display_errors());
                redirect(BASE_URL . 'contest/detailcontest/'.$this->input->post('contest_id'));
            }
        }
        // upload sub home banner
        // if (!empty($_FILES['home_page']['name'])) {
        //     if($this->upload->do_upload('home_page')) {
        //         $homeBannerURL = "api/contestWebView?contest_id=";
        //         $homeBannerData = array('bannerData' => $this->upload->data());
        //         $homePageImage = $homeBannerData['bannerData']['file_name'];
        //     } else {
        //         $this->session->set_flashdata('file_upload_error', $this->upload->display_errors());
        //         redirect(BASE_URL . 'contest/detailcontest/'.$this->input->post('contest_id'));
        //     }
        // }
        $senderId = $this->input->post('loginUserId');
        $contestName = $this->input->post('contest_name');
        $categoryArr = json_decode($this->input->post('category_name'));
        $voteOpenDate = $this->input->post('vote_open_date');
        $voteCloseDate = $this->input->post('vote_close_date');
        $ContestDescription = $this->input->post('description');
        $partner = $this->input->post('partner');
        $homepage = $this->input->post('home_page');
        $fees = $this->input->post('fees_percent');
        $cost = $this->input->post('cost');
        $memo = $this->input->post('memo');
        $status = $this->input->post('status');
        $previousStatus = $this->input->post('previousStatus');
        $show_main_banner= $this->input->post('show_main_banner');
        $hide_contest= $this->input->post('hide_contest');


        $createdDate = $this->input->post('created_date');
        $contestid = array(
            'contest_id' => $this->input->post('contest_id'),
        );
        $homeBannerURL = "api/contestWebView?contest_id="; 
        $contestData = array(
            'contest_name' => $contestName,
            'vote_open_date' => $voteOpenDate,
            'vote_close_date' => $voteCloseDate,
            'description' => $ContestDescription,
            'partner' => $partner,
            'fees_percent' => $fees,
            'cost' => $cost,
            'memo' => $memo,
            'home_page' => $homepage,
            'home_page_image' => '',
            'web_page_url' => $homeBannerURL,
            'status' => $status,
            'updated_date' => date('Y/m/d H:i:s'),
        );
        if(!empty($_FILES['main_banner']['name'])) {
            $contestData['main_banner'] = $main_banner;
        }
        if(!empty($_FILES['sub_banner']['name'])) {
            $contestData['sub_banner'] = $sub_banner;
        }
        // if(!empty($_FILES['home_page']['name'])) {
        //     $contestData['home_page'] = $homeBannerURL;
        //     $contestData['home_page_image'] = $homePageImage;
        // }
        if(!empty($show_main_banner)){
            $contestData['show_main_banner'] = $show_main_banner;
        }else{
            $contestData['show_main_banner'] = 'false';
        }
        if(!empty($hide_contest)){
            $contestData['hide_contest'] = $hide_contest;
        }else{
            $contestData['hide_contest'] = 'Show';
        }
        $result = $this->ContestModel->update('tbl_contest', $contestData, $contestid);
        foreach ($categoryArr as $category) {
            $categoryData = array(
                'category_name' => $category->value,
                'contest_id' => $this->input->post('contest_id')
            );
            $this->updateCategoryFromContest($categoryData);
        }
        if ($result) {
            if($previousStatus !== $status && $status !== 'preparing') {
                $this->load->model('Contestant_Model', 'ContestantModel');
                $contestantList = $this->ContestantModel->getContestantList($this->input->post('contest_id'));
                $contestStatus = '';
                if($status === 'open') {
                    // $contestStatus = 'started';
                    if(CON_DEFAULT_SITE_LANGUAGE == 'english'){
                        $message = "{$contestName} is started now.";
                    }else{
                        $message = "{$contestName} 의 투표가 시작되었습니다.";;
                    }
                } else if($status === 'close') {
                    // $contestStatus = 'closed';
                    if(CON_DEFAULT_SITE_LANGUAGE == 'english'){
                        $message = "{$contestName} is closed now.";
                    }else{
                        $message = "{$contestName} 의 투표를 지금 종료합니다.";
                    }
                }

                /**
                    * Don't Send Push Message To add Comment The Code
                */

                // $messageTitle = "{$contestName}";
            
                // $messageType = "push";
                // foreach ($contestantList as $contestant) {
                //     /**
                //      * Question: what is sender & receiver id
                //      */
                //     $pushNotification = new PushNotification();
                //     $response = $pushNotification->sendPushMessage($messageTitle, $message , $messageType , $senderId, $contestant['user_id']);
                // }
            }
            $this->session->set_flashdata('contest_update_msg', lang('CONTEST_UPDATED'));
            redirect(BASE_URL . 'contest');
        } else {
            $this->session->set_flashdata('contest_update_msg', lang('CONTEST_UPDATE_FAILED'));
            $this->load->view('listofcontest_view');
        }
    }

    /**
     * update multiple categories
     */
    public function updateCategoryFromContest($params = array()) {
        $this->load->model('Category_Model', 'CategoryModel');
        $categoryWhere = array(
            'contest_id' => $params['contest_id'],
            'category_name' => $params['category_name']
        );
        $isExist = $this->CategoryModel->getByWhere('tbl_contest_category', $categoryWhere);
        if(empty($isExist)) {
            $currentDate = date('Y-m-d H:i:s');
            $categoryData = array(
                'category_name' => $params['category_name'],
                'contest_id' => $params['contest_id'],
                'status' => 'active',
                'updated_date' => $currentDate,
                'created_date' => $currentDate
            );
            $this->CategoryModel->insert('tbl_contest_category', $categoryData);
        }
    }

    /**
     * Delete category
     */
    public function deleteCategory() {
        $this->load->model('Category_Model', 'CategoryModel');
        $contestId = $this->input->post('contestId');
        $categoryName = $this->input->post('categoryName');
        $this->resArr[CON_RES_DATA] = [];
        if($contestId && $categoryName) {
            $categoryWhere = array(
                'contest_id' => $contestId,
                'category_name' => $categoryName
            );
            $isDelete = $this->CategoryModel->delete('tbl_contest_category', $categoryWhere);
            if($isDelete) {
                $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_CATEGORY_DELETE_SUCCESS');
                $this->sendResponse($this->resArr);
            } else {
                $this->resArr[CON_RES_CODE] = CON_CODE_FAIL;
                $this->resArr[CON_RES_MESSAGE] = lang('MSG_CATEGORY_DELETE_FAILED');
                $this->sendResponse($this->resArr);
            }
        } else {
            $this->resArr[CON_RES_CODE] = CON_CODE_FAIL;
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_CATEGORY_DELETE_FAILED');
            $this->sendResponse($this->resArr);
        }
    }

    public function addtomapping()
    {
        $contestantId = $this->input->post("contestantId");
        $contestId = $this->input->post("contestId");
        $contest_category_id = $this->input->post("contest_category_id");
        
       
        $oldContestantId = array();
        $whereArr = array(
            'contest_id' => $contestId,
        );
        $oldcontestant = $this->ContestModel->getByWhere('tbl_contestant_mapping', $whereArr);
        // print_r($contestantId); print_r($oldcontestant); exit();
        foreach ($oldcontestant as $list) {
            array_push($oldContestantId, $list['contestant_id']);
        }
        if ($contestantId) {
            foreach ($contestantId as $key => $newId) {
                if (!(in_array($newId, $oldContestantId))) {
                    $mappingData = array(
                        'contest_id' => $contestId,
                        'contestant_id' => $newId,
                        'contest_category_id' => $contest_category_id[$key],
                        'created_date'=> date('Y-m-d H:i:s'),
                        'updated_date'=> date('Y-m-d H:i:s'),
                    );
                    $result = $this->ContestModel->addMapping($mappingData);
                } else {
                    $where = Array(
                        'contest_id' => $contestId,
                        'contestant_id' => $newId,
                    ); 
                    $updateData = array(
                        'contest_category_id' => $contest_category_id[$key]
                    );
                    $result = $this->ContestModel->update('tbl_contestant_mapping', $updateData, $where);
                }
            }
            
        }

        if ($oldContestantId) {
            foreach ($oldContestantId as $oldId) {
                if (!(in_array($oldId, $contestantId))) {
                    $deleteArr = array(
                        'contest_id' => $contestId,
                        'contestant_id' => $oldId,
                    );
                    $result = $this->ContestModel->delete('tbl_contestant_mapping', $deleteArr);
                }
            }
        }
        $this->load->model('Api_Model', 'ApiModel');
        // Update Contestant current Ranking
        $this->ApiModel->updateCurrentRanking($contestId);  
        
        $this->session->set_flashdata('contest_update_msg', lang('CONTESTANT_MAPPED'));
        redirect(BASE_URL . 'contest');
    }

    public function mapping()
    {
        $this->load->model('Category_Model', 'CategoryModel');
        $contest_id = $this->input->post("contest_id");
        $whereArr = array(
            'contest_id' =>  $contest_id,
        );
        $mappingList = $this->ContestModel->getByWhere('tbl_contestant_mapping', $whereArr);
        $conteatantIdArr = array();
        $categoryMapIdArr = array();
        foreach($mappingList as $contestantId) {
            array_push($conteatantIdArr, $contestantId['contestant_id']);
        } 
        foreach($mappingList as $data) {
            $categoryMapIdArr[$data['contestant_id']] = $data['contest_category_id'];
        } 
        $contestantArr = array(
            'status' => 'active',
        );
        $data['listofcontestant'] = $this->ContestModel->getListOfContestant($contest_id);
       
        // get contest category
        $categoryWhere = array(
            'contest_id' => $contest_id,
        );
        $data['categoryData'] = $this->CategoryModel->getByWhere('tbl_contest_category', $categoryWhere);
        $data['mappingList'] = $mappingList;
        $data['mappingContesantId'] = $conteatantIdArr;
        $data['mappingCategoryId'] = $categoryMapIdArr;
        
        $this->load->view('mapping_view', $data);
    }

    public function addDescriptionImage(){
        // files storage folder
        $files = [];
        // Count total files
        $countfiles = count($_FILES['file']['name']);
        // Looping all files
        for($i=0;$i<$countfiles;$i++){
    
            if(!empty($_FILES['file']['name'][$i])){
    
                // Define new $_FILES array - $_FILES['file']
                $_FILES['newfile']['name'] = $_FILES['file']['name'][$i];
                $_FILES['newfile']['type'] = $_FILES['file']['type'][$i];
                $_FILES['newfile']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
                $_FILES['newfile']['error'] = $_FILES['file']['error'][$i];
                $_FILES['newfile']['size'] = $_FILES['file']['size'][$i];

                $config['upload_path'] = CON_CONTEST_PATH;
                $config['allowed_types'] = CON_ALLOWED_IMAGE_TYPE;
                $ext = pathinfo($_FILES['newfile']['name'], PATHINFO_EXTENSION);
                $filename = "desc_".time()."." . $ext;
                $config['file_name'] = $filename;
                $config['overwrite'] = true;

                $this->load->library('upload', $config);
        
                // File upload
                if($this->upload->do_upload('newfile')){
                    // Get data about the file
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
                    $files['file-'.($i+1)] = array(
                        'url' => CON_CONTEST_URL.$filename, 
                        'id' => $filename
                    );
                }
            }
    
        }
        echo stripslashes(json_encode($files));
    }

    public function selectMainBanner(){
        $contest_id = $this->input->post('contestId');
        $show_main_banner = $this->input->post('value');
        $contestWhr = array('contest_id' => $contest_id);
        $contestUpdateArr = array('show_main_banner' => $show_main_banner);

        $result= $this->ContestModel->update('tbl_contest', $contestUpdateArr , $contestWhr);
        echo $result;
    }

    public function hideContest(){
        $contest_id = $this->input->post('contestId');
        $hide_contest = $this->input->post('value');
        
        $contestWhr = array('contest_id' => $contest_id);
        $contestUpdateArr = array('hide_contest' => $hide_contest);

        $result= $this->ContestModel->update('tbl_contest', $contestUpdateArr , $contestWhr);
        echo $result;
    }

    public function deleteContest() {
        $contestId = $this->input->post('contestId');
        $updateData = array(
            'status' => 'delete'
        );
        $where = array(
            'contest_id' => $contestId
        );
        $isDeleted = $this->ContestModel->update('tbl_contest', $updateData ,$where);
        if ($isDeleted) {
            $resData = array('res_code' => 1, 'res_message' => lang('MSG_CONTEST_DELETED'));
        } else {
            $resData = array('res_code' => 0, 'res_message' => lang('MSG_CONTEST_DELETED_FAIL'));
        }

        header('Content-Type: application/json');
        echo json_encode($resData);
    }
}
