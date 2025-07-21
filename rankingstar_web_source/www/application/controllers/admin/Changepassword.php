<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Changepassword extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->auth->isLogin()){
			redirect(CON_LOGIN_PATH);
		}
		$this->setWebLanguage();
		$this->load->model('User_Model', 'UserModel');
		
	}
	
	
	public function index()
	{
		$this->load->view('changepassword_view');
	}

	public function editPassword() {
        $user_id = $this->input->post('user_id');
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $register_date_time = date('Y-m-d H:i:s');
        $updatePass = array(
            'update_date_time' => $register_date_time
        );
        $whrArr = array(
            'user_id' => $user_id
        );
        $userData = $this->UserModel->getByWhere('tbl_user', $whrArr);
        // print_r($userData[0]['password']);die;
        if(!empty($userData)) {
            if($userData[0]['password'] == md5($old_password)) {
                $this->db->trans_begin();
                $updatePass['password'] = md5($new_password);

				// $this->UserModel->update('tbl_user', $userData, $whrArr);
                $update_pass = $this->UserModel->update('tbl_user' ,$updatePass, $whrArr);
                 if ($this->db->trans_status() === true) {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('success_msg', lang('MSG_PASSWORD_CHANGE'));
                 }
            } 
            else {
                $this->db->trans_rollback();  
                $this->session->set_flashdata('error_msg', lang('MSG_OLD_PASSWORD_DOSE_NOT_MATCH'));
                redirect(BASE_URL . 'changepassword');   
            }
        }
        else {
            $this->session->set_flashdata('error_msg', lang('MSG_USER_NOT_FOUND'));
            //$this->auth->logout();
            redirect(BASE_URL);
        }
        redirect(BASE_URL . 'changepassword');
    }
}
