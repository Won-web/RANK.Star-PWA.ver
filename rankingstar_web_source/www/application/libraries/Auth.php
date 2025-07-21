<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth
{

    public $CI;

    public $remember_cookie_name = 'remcookie';
    public $remember_cookie_expire = 3600;
    public $login_session_key = 'session_login';

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /*
     * set login session and cookie
     */
    public function login($userArr, $isRemember = false)
    {
        try
        {
            $this->CI->load->library('session');
            $this->CI->session->set_userdata($this->login_session_key, $userArr);
            if ($isRemember == true) {
                $this->CI->load->helper('cookie');
                set_cookie($this->remember_cookie_name, $isRemember, $this->remember_cookie_expire);
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    /*
     * check user is whether loged in or not
     */
    public function isLogin()
    {
        try
        {
            if (!empty($this->CI->session->userdata($this->login_session_key))) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {

            return false;
        }
    }

    /*
     * return : user_id session
     */
    public function getUserSession()
    {
        try
        {
            if ($this->isLogin() == true) {
                return $this->CI->session->userdata($this->login_session_key);
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /*
     * logout : destroy session
     */
    public function logout()
    {
        try
        {
            $this->CI->session->unset_userdata($this->login_session_key);
            $this->CI->session->unset_userdata('site_language');
        } catch (Exception $ex) {
            return false;
        }
    }
}
