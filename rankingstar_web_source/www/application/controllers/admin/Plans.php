<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Plans extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->auth->isLogin()) {
            redirect(CON_LOGIN_PATH);
        }
        $this->setWebLanguage();        
        $this->load->model('Api_Model', 'APIModel');
    }

    /* Plan List View */
    public function index()
    {
        $this->load->view('plans/plan_list_view');
    }

    /* Plan List View */
    public function getPlanList()
    {        
        $this->load->model('Plan_Model', 'PlanModel');
        $sortColumn = ['tp.plan_name', 'tp.description', 'tp.star', 'tp.price', 'tp.status', 'tp.plan_type'];

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

        //Get Search Value
        $searchText = "";
        if (!empty($search['value'])) {
            $searchText = $search['value'];
        }

        //Get Order By And Direction
        $column = $order[0]['column'];
        $sort_by = $order[0]['dir'];
        // $order_by = $sortColumn[$column];
        $order_by=null;
        
        $totalData = $this->PlanModel->getPlanData($searchText, $order_by, $sort_by, $offset, 0);
        $planData = $this->PlanModel->getPlanData($searchText, $order_by, $sort_by, $offset, $limit);
        // Process Data
        $data = array();
        foreach ($planData as $plan) {
            $count ++;
            $details = '<a data-toggle="tooltip" title="Details" href="' . BASE_URL . 'plans/details/' . $plan['plan_id'] . '" data-id="' . $plan['plan_id'] . '">' . $plan['plan_name'] . '</a>';
            $delete = '';
            $sessionData = $this->auth->getUserSession();
            if ($sessionData['user_type'] === "admin"){
                $delete = '<a data-toggle="tooltip" title="' . lang('LBL_REMOVE_PLAN') . '" class="remove-plan" data-url="' . BASE_URL . 'plans/delete/' . $plan['plan_id'] . '" href="#" data-id="' . $plan['plan_id'] . '"><i class="fas fa-trash"></i></a>';
            }
            $data[] = array($count, $details, $plan['description'], number_format($plan['price']), number_format($plan['star']), $plan['status'], $plan['plan_type'], $delete);
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

    /* Plan Add View */
    public function addPlan()
    {
        if ($this->input->post()) {
            $this->load->model('Plan_Model', 'PlanModel');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('plan_name', lang('LBL_PLAN_NAME'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('description', lang('LBL_DESCRIPTION'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('price', lang('LBL_PRICE'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('star', lang('LBL_STAR'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('extra_star', lang('LBL_EXTRA_STAR'));
            $this->form_validation->set_rules('status', lang('LBL_STATUS'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));

            if ($this->form_validation->run() == false) {
                $errors = validation_errors();
                $this->session->set_flashdata('error', $errors);
            } else {
                $plan_name = $this->input->post('plan_name');
                $description = $this->input->post('description');
                $price = $this->input->post('price');
                $star = $this->input->post('star');
                $extra_star = $this->input->post('extra_star');
                $plan_type = $this->input->post('plan_type');
                $status = $this->input->post('status');
                $current_date = date('Y-m-d H:i:s');
                $planData = array(
                    'plan_name' => $plan_name,
                    'description' => $description,
                    'price' => $price,
                    'star' => $star,
                    'extra_star' => $extra_star,
                    'plan_type' => $plan_type,
                    'status' => $status,
                    'created_date' => $current_date,
                    'updated_date' => $current_date
                );
                $plan_id = $this->PlanModel->insert('tbl_purchase_plan', $planData);
                if ($plan_id) {
                    redirect(BASE_URL . "plans");
                } else {
                    $this->session->set_flashdata('error', lang('MSG_PLAN_SAVE_FAIL'));
                }
            }
        }
        $this->load->view('plans/plan_add_view');
    }

    /* Plan Edit View */
    public function editPlan()
    {
        if ($this->input->post()) {
            $this->load->model('Plan_Model', 'PlanModel');
            $plan_id = $this->input->post('plan_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('plan_name', lang('LBL_PLAN_NAME'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('description', lang('LBL_DESCRIPTION'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('price', lang('LBL_PRICE'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('star', lang('LBL_STAR'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('extra_star', lang('LBL_EXTRA_STAR'));
            $this->form_validation->set_rules('status', lang('LBL_STATUS'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));

            if ($this->form_validation->run() === false) {
                $errors = validation_errors();
                $this->session->set_flashdata('error', $errors);
                redirect(BASE_URL . "plans/details/".$plan_id);
            } else {
                $plan_name = $this->input->post('plan_name');
                $description = $this->input->post('description');
                $price = $this->input->post('price');
                $star = $this->input->post('star');
                $extra_star = $this->input->post('extra_star');
                $status = $this->input->post('status');
                $plan_type = $this->input->post('plan_type');
                $updated_date = date('Y-m-d H:i:s');                
                           
                $whereArr = array('plan_id'=>$plan_id);
                // Update Plan Table Data
                $planData = array(
                    'plan_name' => $plan_name,
                    'description' => $description,
                    'price' => $price,
                    'star' => $star,
                    'extra_star' => $extra_star,
                    'plan_type' => $plan_type,
                    'status' => $status,
                    'updated_date' => $updated_date
                );
                $this->PlanModel->update('tbl_purchase_plan', $planData, $whereArr);                
                $this->session->set_flashdata('success_msg', lang('MSG_PLAN_UPDATE_SUCCESS'));
                redirect(BASE_URL . "plans/details/".$plan_id);                            
            }
        }
    }

    /* Plan Details */
    public function details()
    {
        $this->load->model('Plan_Model', 'PlanModel');
        $planId = $this->uri->segment(4);
        $data['planDetails'] = $this->PlanModel->getPlanDetails($planId);
        $this->load->view('plans/plan_details_view', $data);
    }

    /* Delete Plan (Mark as Delete) */
    public function delete()
    {
        $this->load->model('Plan_Model', 'PlanModel');
        $planId = $this->uri->segment(4);
        $updateData = array('status' => 'delete');
        $whereArr = array('plan_id' => $planId);
        $isDeleted = $this->PlanModel->update('tbl_purchase_plan', $updateData, $whereArr);
        if ($isDeleted) {
            $resData = array('res_code' => 1, 'res_message' => lang('LBL_DELETE_SUCCESS'));
        } else {
            $resData = array('res_code' => 0, 'res_message' => lang('LBL_DELETE_FAIL'));
        }
        header('Content-Type: application/json');
        echo json_encode($resData);
    }

    /* User History View */
    public function history()
    {
        $user_id = $this->uri->segment(3);
        $this->load->view('user_history_view', array('user_id'=>$user_id));
    }

    /* Get Purchase History */
    public function purchasehistory(){
        $user_id = $this->uri->segment(4);

        $sortColumn = ['tsp.description', 'tsp.type', 'tsp.star', 'tsp.purchase_date'];

        // Datatables Variables
        $draw = intval($this->input->post("draw"));
        $offset = intval($this->input->post("start"));
        $limit = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $order = $this->input->post("order");

        //Get Search Value
        $searchText = "";
        if (!empty($search['value'])) {
            $searchText = $search['value'];
        }

        //Get Order By And Direction
        $column = $order[0]['column'];
        $sort_by = $order[0]['dir'];
        // $order_by = $sortColumn[$column];
        $order_by=null;

        $totalData = $this->UserModel->getUserPurchaseData($user_id, $searchText, $order_by, $sort_by, $offset, 0);
        $purchaseData['purchase_list'] = $this->UserModel->getUserPurchaseData($user_id, $searchText, $order_by, $sort_by, $offset, $limit);
        
        //Fetch Remaining Star Details
        $availableStarCount = $this->APIModel->getAvailableStarCount($user_id);
        $purchaseData['remaining_star'] = $availableStarCount['remaining_star'];

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
     public function usagehistory(){
        $user_id = $this->uri->segment(4);

        $sortColumn = ['tv.description', 'tc.contest_name', 'tcd.name', 'tv.vote', 'tv.vote_date'];

        // Datatables Variables
        $draw = intval($this->input->post("draw"));
        $offset = intval($this->input->post("start"));
        $limit = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $order = $this->input->post("order");

        //Get Search Value
        $searchText = "";
        if (!empty($search['value'])) {
            $searchText = $search['value'];
        }

        //Get Order By And Direction
        $column = $order[0]['column'];
        $sort_by = $order[0]['dir'];
        // $order_by = $sortColumn[$column];
        $order_by=null;

        $totalData = $this->UserModel->getUserVoteData($user_id, $searchText, $order_by, $sort_by, $offset, 0);
        $purchaseData['voting_list'] = $this->UserModel->getUserVoteData($user_id, $searchText, $order_by, $sort_by, $offset, $limit);
        
        //Fetch Remaining Star Details
        $availableStarCount = $this->APIModel->getAvailableStarCount($user_id);
        $purchaseData['remaining_star'] = $availableStarCount['remaining_star'];

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($totalData),
            "recordsFiltered" => count($totalData),
            "data" => $purchaseData,
        );
        echo json_encode($output);
        exit();
    }
}
