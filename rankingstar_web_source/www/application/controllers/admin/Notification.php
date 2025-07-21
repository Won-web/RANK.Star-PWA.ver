<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->auth->isLogin()) {
            redirect(CON_LOGIN_PATH);
        }
        require_once APPPATH . "/third_party/apns/PushNotification.php";
        $this->setWebLanguage();        
        $this->load->model('Notification_Model', 'NotificationModel');
    }

    /* Notification List View */
    public function index()
    {
        // redirect('notification/sendNotification');
        $this->load->view('notification/notification_list_view');
    }

    /* Notification List View */
    public function getNotificationList()
    {        
        $this->load->model('Notification_Model', 'NotificationModel');
        $sortColumn = ['am.apns_master_id', 'am.message_title', 'am.message', 'am.message_type','am.created_date'];

        // Datatables Variables
        $draw = intval($this->input->post("draw"));
        $offset = intval($this->input->post("start"));
        $limit = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $order = $this->input->post("order");

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
               
        if($draw === 1){
            $count = 0;
        }else if ($draw > 1){
            $count = $offset;
        }

        
        $totalData = $this->NotificationModel->getNotificationData($searchText, $order_by, $sort_by, $offset, 0);
        $noticeData = $this->NotificationModel->getNotificationData($searchText, $order_by, $sort_by, $offset, $limit);
        
        // Process Data
        $data = array();
        foreach ($noticeData as $notice) {
            $count ++;
            $details = '<a href="javascript:void(0)">' . $notice['message_title'] . '</a>';
            $sessionData = $this->auth->getUserSession();
            $date =  date('Y-m-d',strtotime($notice['created_date']));
            $data[] = array($count, $details, $notice['message'],$notice['message_type'],$date);
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

    /* Send Notification View */
    public function sendNotification()
    {
        // $contestant['contestantList'] = $this->NotificationModel->getContestantList();
        $this->load->view('notification/notification_add_view' );
    }

    /* Notification Details */
    public function details()
    {
        $this->load->model('Notice_Model', 'NoticeModel');
        $noticeId = $this->uri->segment(3);
        $data['noticeDetails'] = $this->NoticeModel->getAdvertiseDetails($noticeId);
        $this->load->view('notification/notification_details_view', $data);
    }

    public function sendPushNotification()
    {
        $this->load->model('User_Model', 'UserModel');
        $messageTitle = $this->input->post('messageTitle');
        $message = $this->input->post('message');
        $senderId = $this->input->post('senderId');
        $userArr = $this->input->post('multiContestant');
        
        $messageTitle = "{$messageTitle}";
        $message = "{$message}";
        $messageType = "push";
        $deliver_by_crone = 'Yes';
        
        $customArr['push_type']= 'Admin';
        $pushNotification = new PushNotification();
        $response = $pushNotification->sendPushMessage($messageTitle, $message , $messageType , $senderId, $userArr,$customArr,$deliver_by_crone);
        $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
        $this->resArr[CON_RES_MESSAGE] = lang('MSG_PUSH_NOTIFICATION_SUCCESS');
        $this->resArr[CON_RES_DATA] = array('data' => '');
        $this->sendResponse($this->resArr);
    }

    public function getListOfUser()
    {
        $sortColumn = ['tu.user_id', 'tcd.name' , 'tu.email'];

        $draw = intval($this->input->post("draw"));
        $offset = intval($this->input->post("start"));
        $limit = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $order = $this->input->post("order");

        $searchText = "";
        if (!empty($search['value'])) {
            $searchText = $search['value'];
        }

        $column = $order[0]['column'];
        $sort_by = $order[0]['dir'];
        $order_by = $sortColumn[$column];

        $allRecord = $this->NotificationModel->getAllContenstant();
        $listofContestant = $this->NotificationModel->getContestantList($searchText, $order_by, $sort_by, $offset, $limit);

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($allRecord),
            "recordsFiltered" => count($allRecord),
            "data" => $listofContestant
        );

        echo json_encode($output);
        exit();
    }
}
