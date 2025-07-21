<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();

    }

    /*  login */

    public function login($email, $password, $user_type)
    {
        $sql = "SELECT t1.user_id,t1.email,t1.mobile,t1.user_type,t1.user_status,t1.is_autologin,t1.login_type,t1.register_date_time,
                t2.name,t2.nick_name,t2.main_image 
                FROM tbl_user AS t1 
                INNER JOIN tbl_user_details  AS t2 ON t1.user_id=t2.user_id
                WHERE user_status='active' AND login_type='auth' AND email='{$email}' AND password='{$password}' AND user_type ='{$user_type}'";
        /*$sql = "SELECT t1.user_id,t1.email,t1.mobile,t1.user_type,t1.user_status,t1.is_autologin,t1.login_type,t1.register_date_time,
              t2.name,t2.nick_name,t2.main_image 
              FROM tbl_user AS t1 
              INNER JOIN tbl_user_details  AS t2 ON t1.user_id=t2.user_id
              WHERE user_status='active' AND login_type='auth' AND email='{$email}'";*/
        $result = $this->db->query($sql)->row_array();
        return $result;
    }
}
