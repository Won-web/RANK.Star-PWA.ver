<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notice extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->auth->isLogin()) {
            redirect(CON_LOGIN_PATH);
        }
        require_once APPPATH . "/third_party/apns/PushNotification.php";
        $this->setWebLanguage();        
        $this->load->model('Api_Model', 'APIModel');
        $this->load->model('Notice_Model', 'NoticeModel');
    }

    /* Notice List View */
    public function index()
    {
        $this->load->view('notice/notice_list_view');
    }

    /* Notice List View */
    public function getNoticeList()
    {        
        $this->load->model('Notice_Model', 'NoticeModel');
        $sortColumn = ['tn.notice_id', 'tn.notice_title', 'tn.send_notice' , 'tn.notice_date'];

        // Datatables Variables
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

        // Get Search Value
        $searchText = "";
        if (!empty($search['value'])) {
            $searchText = $search['value'];
        }

        // Get Order By And Direction
        $column = $order[0]['column'];
        $sort_by = $order[0]['dir'];
        // $order_by = $sortColumn[$column];
        $order_by=null;
        
        $totalData = $this->NoticeModel->getNoticeData($searchText, $order_by, $sort_by, $offset, 0);
        $noticeData = $this->NoticeModel->getNoticeData($searchText, $order_by, $sort_by, $offset, $limit);
        // Process Data
        $data = array();
        foreach ($noticeData as $notice) {
            $count ++;
            $deleteNotice = "";
            $sessionData = $this->auth->getUserSession();
            if ($sessionData['user_type'] === "admin") {
                // $deleteNotice = '<a  id="deleteNotice" data-toggle="modal" data-div-target="noticeModalLabel" data-id="' . $notice['notice_id'] . '" ><i class="fas fa-trash"></i></a>';
                // $delete = '<a data-toggle="tooltip" title="' . lang('LBL_REMOVE_PLAN') . '" class="remove-plan" data-url="' . BASE_URL . 'plans/delete/' . $plan['plan_id'] . '" href="#" data-id="' . $plan['plan_id'] . '"><i class="far fa-trash-alt"></i></a>';
                $deleteNotice = '<a data-toggle="modal" title="' . lang('LBL_REMOVE_NOTICE') . '" class="deleteNotice" data-url="' . BASE_URL . 'notice/deleteNotice/' . $notice['notice_id'] . '" href="#" data-id="' . $notice['notice_id'] . '"><i class="fas fa-trash"></i></a>';
            }
            $details = '<a href="' . BASE_URL . 'notice/details/'.$notice['notice_id'].'">' . $notice['notice_title'] . '</a>';
            $sessionData = $this->auth->getUserSession();
            $sendNotice = ($notice['send_notice'] == 1) ? "Yes" : "No";
            $date =  date('Y-m-d',strtotime($notice['notice_date']));
            $data[] = array($count, $details, $sendNotice ,$date,$deleteNotice);
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

    /* Notice Add View */
    public function addNotice()
    {
        $this->load->view('notice/notice_add_view');
    }

    /* Notice Details */
    public function details()
    {
        $this->load->model('Notice_Model', 'NoticeModel');
        $noticeId = $this->uri->segment(4);
        $data['noticeDetails'] = $this->NoticeModel->getNoticeDetails($noticeId);
        $this->load->view('notice/notice_details_view', $data);
    }

    public function sendPushNotification()
    {
        $this->load->model('Notice_Model', 'NoticeModel');
        $messageTitle = $this->input->post('messageTitle');
        $message = $this->input->post('message');
        $sendNotice = $this->input->post('sendNotice');
        $senderId = $this->input->post('senderId');
        $currentDate = date('Y-m-d H:i:s');

        $noticeData = array(
            'notice_title' => $messageTitle,
            'notice_description' => $message,
            'send_notice' => ($sendNotice === "yes") ? 1 : 0,
            'sender_id' => $senderId,
            'notice_date' => $currentDate
        );
        $tblNoticeId = $this->NoticeModel->insert('tbl_notice', $noticeData);

        if($sendNotice === "yes") {
            $messageType = "notice";
            $deliver_by_crone = 'Yes';
            $pushNotification = new PushNotification();
            $response = $pushNotification->sendPushMessage($messageTitle , $message, $messageType , $senderId, $receiverId = NULL,$customData = NULL,$deliver_by_crone);
        }
        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
        $this->resArr[CON_RES_MESSAGE] = lang('MSG_PUSH_NOTIFICATION_SUCCESS');
        $this->resArr[CON_RES_DATA] = array('data' => '');
        $this->sendResponse($this->resArr);
    }

    public function editNotice(){
        
        $messageTitle = $this->input->post('messageTitle');
        $message = $this->input->post('message');
        $sendNotice = $this->input->post('sendNotice');
        $senderId = $this->input->post('senderId');
        $noticeId = $this->input->post('noticeId');
        $currentDate = date('Y-m-d H:i:s');
        $noticeData = array(
            'notice_title' => $messageTitle,
            'notice_description' => $message,
            'send_notice' => ($sendNotice === "yes") ? 1 : 0,
            'sender_id' => $senderId,
            'notice_date' => $currentDate
        );
        $noticeWhr = array('notice_id' => $noticeId);
      
        $tblNoticeId = $this->NoticeModel->update('tbl_notice', $noticeData , $noticeWhr);
       
        if($sendNotice === "yes") {
            $messageType = "notice";
            $deliver_by_crone = 'Yes';
            $pushNotification = new PushNotification();
            $response = $pushNotification->sendPushMessage($messageTitle , $message, $messageType , $senderId, $receiverId = NULL,$customData = NULL,$deliver_by_crone);
        }
        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
        $this->resArr[CON_RES_MESSAGE] = lang('MSG_PUSH_NOTIFICATION_SUCCESS');
        $this->resArr[CON_RES_DATA] = array('data' => '');
        $this->sendResponse($this->resArr);
        // $this->session->set_flashdata('success_msg', lang('MSG_PUSH_NOTIFICATION_SUCCESS'));
    }
    public function deleteNotice() {
        $noticeId = $this->input->post('noticeId');
        $updateData = array(
            'status' => 'deactive'
        );
        $where = array(
            'notice_id' => $noticeId
        );
        $result = $this->NoticeModel->update('tbl_notice', $updateData ,$where);
        if ($result) {
            $resData = array('res_code' => 1, 'res_message' => lang('MSG_NOTICE_DELETED'));

        } else {
            $resData = array('res_code' => 0, 'res_message' => lang('MSG_NOTICE_DELETED_FAIL'));
        }
        header('Content-Type: application/json');
        echo json_encode($resData);
    }
}
