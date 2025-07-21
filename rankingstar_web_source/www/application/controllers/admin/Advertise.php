<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Advertise extends MY_Controller
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

    /* Advertise List View */
    public function index()
    {
        $this->load->view('advertise/advertise_list_view');
    }

    /* Advertise List View */
    public function getAdvertiseList()
    {        
        $this->load->model('Advertise_Model', 'AdvertiseModel');
        $sortColumn = ['ta.ad_id', 'ta.ad_name', 'ta.ad_type', 'ta.ad_path', 'ta.star', 'ta.status'];

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
        $order_by = $sortColumn[$column];
        
        $totalData = $this->AdvertiseModel->getAdvertisementData($searchText, $order_by, $sort_by, $offset, 0);
        $advertiseData = $this->AdvertiseModel->getAdvertisementData($searchText, $order_by, $sort_by, $offset, $limit);
        // Process Data
        $data = array();
        foreach ($advertiseData as $advertise) {
            $details = '<a data-toggle="tooltip" title="Details" href="' . BASE_URL . 'advertise/details/' . $advertise['ad_id'] . '" data-id="' . $advertise['ad_id'] . '">' . $advertise['ad_name'] . '</a>';
            $delete = '';
            $sessionData = $this->auth->getUserSession();
            if ($sessionData['user_type'] === "admin") {
                $delete = '<a data-toggle="tooltip" title="' . lang('LBL_REMOVE_ADVERTISE') . '" class="remove-advertise" data-url="' . BASE_URL . 'advertise/delete/' . $advertise['ad_id'] . '" href="#" data-id="' . $advertise['ad_id'] . '"><i class="far fa-trash-alt"></i></a>';
            }
            $data[] = array($advertise['ad_id'], $details, $advertise['ad_type'], $advertise['ad_path'], number_format($advertise['star']), $advertise['status'], $delete);
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

    /* Advertise Add View */
    public function addAdvertise()
    {
        if ($this->input->post()) {
            $this->load->model('Advertise_Model', 'AdvertiseModel');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('ad_name', lang('LBL_ADVERTISE_NAME'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('ad_path', lang('LBL_ADVERTISEMENT_PATH'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('ad_type', lang('LBL_AD_PATH'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('star', lang('LBL_STAR'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('status', lang('LBL_STATUS'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));

            if ($this->form_validation->run() === false) {
                $errors = validation_errors();
                $this->session->set_flashdata('error', $errors);
            } else {
                $adName = $this->input->post('ad_name');
                $adPath = $this->input->post('ad_path');
                $adType = $this->input->post('ad_type');
                $star = $this->input->post('star');
                $status = $this->input->post('status');
                $currentDate = date('Y-m-d H:i:s');
                $advertiseData = array(
                    'ad_name' => $adName,
                    'ad_path' => $adPath,
                    'ad_type' => $adType,
                    'star' => $star,
                    'status' => $status,
                    'created_date' => $currentDate,
                    'updated_date' => $currentDate
                );
                $ad_id = $this->AdvertiseModel->insert('tbl_advertisement', $advertiseData);
                if ($ad_id) {
                    redirect(BASE_URL . "advertise");
                } else {
                    $this->session->set_flashdata('error', lang('MSG_ADVERTISE_SAVE_FAIL'));
                }
            }
        }
        $this->load->view('advertise/advertise_add_view');
    }

    /* Advertise Edit View */
    public function editAdvertise()
    {    
        if ($this->input->post()) {
            $this->load->model('Advertise_Model', 'AdvertiseModel');
            $ad_id = $this->input->post('ad_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('ad_name', lang('LBL_ADVERTISE_NAME'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('ad_path', lang('LBL_ADVERTISEMENT_PATH'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('ad_type', lang('LBL_AD_PATH'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('star', lang('LBL_STAR'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));
            $this->form_validation->set_rules('status', lang('LBL_STATUS'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));

            if ($this->form_validation->run() === false) {
                $errors = validation_errors();
                $this->session->set_flashdata('error', $errors);
                redirect(BASE_URL . "advertise/details/" . $ad_id);
            } else {
                $adName = $this->input->post('ad_name');
                $adPath = $this->input->post('ad_path');
                $adType = $this->input->post('ad_type');
                $star = $this->input->post('star');
                $status = $this->input->post('status');
                $updatedDate = date('Y-m-d H:i:s');                

                $whereArr = array('ad_id' => $ad_id);
                // Update Plan Table Data
                $advertiseData = array(
                    'ad_name' => $adName,
                    'ad_path' => $adPath,
                    'ad_type' => $adType,
                    'star' => $star,
                    'status' => $status,
                    'updated_date' => $updatedDate
                );
                $this->AdvertiseModel->update('tbl_advertisement', $advertiseData, $whereArr);                
                $this->session->set_flashdata('success_msg', lang('MSG_ADVERTISE_UPDATE_SUCCESS'));
                redirect(BASE_URL . "advertise/details/".$ad_id);                            
            }
        }
    }

    /* Advertise Details */
    public function details()
    {
        $this->load->model('Advertise_Model', 'AdvertiseModel');
        $advertiseId = $this->uri->segment(3);
        $data['advertiseDetails'] = $this->AdvertiseModel->getAdvertiseDetails($advertiseId);
        $this->load->view('advertise/advertise_details_view', $data);
    }

    /* Delete Advertise (Mark as Delete) */
    public function delete()
    {
        $this->load->model('Advertise_Model', 'AdvertiseModel');
        $advertiseId = $this->uri->segment(3);
        $updateData = array('status' => 'delete');
        $whereArr = array('ad_id' => $advertiseId);
        $isDeleted = $this->AdvertiseModel->update('tbl_advertisement', $updateData, $whereArr);
        if ($isDeleted) {
            $resData = array('res_code' => 1, 'res_message' => lang('LBL_DELETE_SUCCESS'));
        } else {
            $resData = array('res_code' => 0, 'res_message' => lang('LBL_DELETE_FAIL'));
        }
        header('Content-Type: application/json');
        echo json_encode($resData);
    }    
}
