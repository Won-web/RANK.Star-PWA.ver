<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mail
{
    public $mail_to = '';
    public $mail_subject = '';
    public $mail_message = '';
    public $mail_attach = '';
    public $mail_from_name = CON_SMTP_FROM_NAME;
    public $mail_from = CON_SMTP_FROM_MAIL_ADDRESS;
    public $mail_protocol = 'smtp';
    public $mail_smtp_username = CON_SMTP_USERNAME;
    public $mail_smtp_password = CON_SMTP_PASSWORD;
    public $mail_host = CON_SMTP_HOST;
    public $mail_port = CON_SMTP_PORT;
    public $mail_smtp_crypto = CON_SMTP_CRYPTO;
    public $mail_type = 'html';
    public $mail_charset = 'UTF-8';
    public $mail_wordwrap = TRUE;
    public $mail_setnewline = "\r\n"; // must be in double qoute
    
    /* END - Changable Part of Library */
    public $CI;

    public function __construct($params = array())
    {
        $this->CI = & get_instance();
        $this->init($params);        
    }
    public function init($params = array()) {
        foreach ($params as $key => $val) {        
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
    }
    public function sendMail($to_address = '')
    {
        $config = Array(
            'protocol' => $this->mail_protocol,
            'smtp_host' => $this->mail_host,
            'smtp_port' => $this->mail_port,
            'smtp_user' => $this->mail_smtp_username,
            'smtp_pass' => $this->mail_smtp_password,
            'mailtype' => $this->mail_type,
            'charset' => $this->mail_charset,
            'wordwrap' => $this->mail_wordwrap,
            'smtp_crypto' => CON_SMTP_CRYPTO
        );
        
        $this->CI->load->library('email', $config);
        if (! empty($to_address)) {
            $this->CI->email->to($to_address);
        }
        else {
            $this->CI->email->to($this->mail_to);
        } 
        $this->CI->email->from($this->mail_from, $this->mail_from_name);
        $this->CI->email->subject($this->mail_subject);
        $this->CI->email->message($this->mail_message);
        $this->CI->email->set_newline($this->mail_setnewline);
        
        if ($this->mail_attach != '') {
            $this->CI->email->attach($this->mail_attach);
        }
        if ($this->CI->email->send()) {
            return TRUE;
        }
        else {
            // echo $this->CI->email->print_debugger();exit();
            return FALSE;
        }
    }
}
?>