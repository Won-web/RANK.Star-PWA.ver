<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends MY_Controller
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

    /* Category List View */
    public function index()
    {
        $this->load->view('category/category_list_view');
    }

    /* Category List View */
    public function getCategoryList()
    {        
        $this->load->model('Category_Model', 'CategoryModel');
        $sortColumn = ['tc.contest_category_id', 'tc.category_name', 'tct.contest_name', 'tc.status'];

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
        $order_by = $sortColumn[$column];
        
        $totalData = $this->CategoryModel->getCategoryData($searchText, $order_by, $sort_by, $offset, 0);
        $categoryData = $this->CategoryModel->getCategoryData($searchText, $order_by, $sort_by, $offset, $limit);
        // Process Data
        $data = array();
        foreach ($categoryData as $category) {
            // print_r($plan);
            $details = '<a data-toggle="tooltip" title="Details" href="' . BASE_URL . 'category/details/' . $category['contest_category_id'] . '" data-id="' . $category['contest_category_id'] . '">' . $category['category_name'] . '</a>';
            $delete = '';
            $sessionData = $this->auth->getUserSession();
            if ($sessionData['user_type'] === "admin") {
                $delete = '<a data-toggle="tooltip" title="' . lang('LBL_REMOVE_CATEGORY') . '" class="remove-category" data-url="' . BASE_URL . 'category/delete/' . $category['contest_category_id'] . '" href="#" data-id="' . $category['contest_category_id'] . '"><i class="far fa-trash-alt"></i></a>';
            }
            $data[] = array($category['contest_category_id'], $details, $category['contest_name'], $category['status'], $delete);
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

    /* Category Add View */
    public function addCategory()
    {
        if ($this->input->post()) {
            $this->load->model('Category_Model', 'CategoryModel');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('contest_id', lang('NAME_OF_CONTEST'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));            
            $this->form_validation->set_rules('category_name', lang('LBL_CATEGORY_NAME'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));            

            if ($this->form_validation->run() === false) {
                $errors = validation_errors();
                $this->session->set_flashdata('error', $errors);
            } else {
                $category_name = $this->input->post('category_name');               
                $contest_id = $this->input->post('contest_id');               
                $status = $this->input->post('status');
                $current_date = date('Y-m-d H:i:s');
                $categoryData = array(
                    'category_name' => $category_name,
                    'contest_id' => $contest_id,                    
                    'status' => $status,
                    'updated_date' => $current_date,
                    'created_date' => $current_date
                );
                $contest_category_id = $this->CategoryModel->insert('tbl_contest_category', $categoryData);
                if ($contest_category_id) {
                    redirect(BASE_URL . "category");
                } else {
                    $this->session->set_flashdata('error', lang('MSG_CATEGORY_SAVE_FAIL'));
                }
            }
        }
        $this->load->model('Contestant_Model', 'ContestantModel');
        $contestArr = array('status' => 'preparing');
        $data['contestList'] = $this->ContestantModel->getByWhere('tbl_contest', $contestArr);
        $this->load->view('category/category_add_view', $data);
    }

    /* Category Edit View */
    public function editCategory()
    {
        if ($this->input->post()) {
            $this->load->model('Category_Model', 'CategoryModel');
            $contest_category_id = $this->input->post('contest_category_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('contest_id', lang('NAME_OF_CONTEST'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));            
            $this->form_validation->set_rules('category_name', lang('LBL_CATEGORY_NAME'), 'required', array('required' => '%s ' . lang('VALIDATION_REQUIRED')));            

            if ($this->form_validation->run() === false) {
                $errors = validation_errors();
                $this->session->set_flashdata('error', $errors);
                redirect(BASE_URL . "category/details/".$contest_category_id);
            } else {
                $category_name = $this->input->post('category_name');
                $contest_id = $this->input->post('contest_id');
                $status = $this->input->post('status');
                $updated_date = date('Y-m-d H:i:s');                
                           
                $whereArr = array('contest_category_id'=>$contest_category_id);
                // Update Category Table Data
                $categoryData = array(
                    'category_name' => $category_name,
                    'contest_id' => $contest_id,                         
                    'status' => $status,
                    'updated_date' => $updated_date
                );
                $this->CategoryModel->update('tbl_contest_category', $categoryData, $whereArr);                
                $this->session->set_flashdata('success_msg', lang('MSG_CATEGORY_UPDATE_SUCCESS'));
                redirect(BASE_URL . "category/details/".$contest_category_id);                           
            }
        }
    }

    /* Category Details */
    public function details()
    {
        $this->load->model('Contestant_Model', 'ContestantModel');
        $contestArr = array('status' => 'preparing');
        $data['contestList'] = $this->ContestantModel->getByWhere('tbl_contest', $contestArr);
        $this->load->model('Category_Model', 'CategoryModel');
        $categoryId = $this->uri->segment(3);
        $data['categoryDetails'] = $this->CategoryModel->getCategoryDetails($categoryId);
        $this->load->view('category/category_details_view', $data);
    }

    /* Delete Category (Mark as Delete) */
    public function delete() 
    {
        $this->load->model('Category_Model', 'CategoryModel');
        $categoryId = $this->uri->segment(3);
        $updateData = array('status' => 'delete');
        $whereArr = array('contest_category_id' => $categoryId);
        $isDeleted = $this->CategoryModel->update('tbl_contest_category', $updateData, $whereArr);
        if ($isDeleted) {
            $resData = array('res_code' => 1, 'res_message' => lang('LBL_DELETE_SUCCESS'));
        } else {
            $resData = array('res_code' => 0, 'res_message' => lang('LBL_DELETE_FAIL'));
        }
        header('Content-Type: application/json');
        echo json_encode($resData);
    }            
}
