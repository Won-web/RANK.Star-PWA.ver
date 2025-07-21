<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$this->setWebLanguage();
    }

    public function index()
    {
        $this->load->view('login_view');
    }

    public function userlogin()
    {
        // echo md5($password);die;
        $this->load->model('Login_Model', 'LoginModel');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user_type = $this->input->post('user_type');
        if (!empty($email) && !empty($password)) {
            $adminData = $this->LoginModel->login($email, md5($password), $user_type);
            if ($adminData) {
                $this->auth->login($adminData);
                $this->session->set_flashdata('login_success', lang('MSG_LOGIN_SUCCESS'));
               // echo "adws";die;
                redirect(BASE_URL . 'dashboard');
            } else {
                $this->session->set_flashdata('msg', lang('MSG_LOGIN_FAIL'));
                redirect(CON_LOGIN_PATH);
            }
        } else {
            $this->session->set_flashdata('msg', lang('MSG_LOGIN_MISSING'));
            redirect(CON_LOGIN_PATH);
        }
    }

    public function logout(){
        $this->auth->logout();
		redirect(BASE_URL);
	}
}
