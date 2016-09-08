<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Authentication extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('session');
    }
    public function login() {
        $data = [];
        if($this->input->post()){
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            //kiem tra form_validation tra ve false neu phuong thuc dung
            if($this->form_validation->run() == FALSE) {
                $data["error"] = validation_errors();
            }else{
                $email = $this->input->post("email");
                $password = $this->input->post("password");
                $rememberme = $this->input->post("rememberme");
                $this->session->set_userdata(array('email' => $email));
                $this->session->set_userdata(array('email' => $password));
                $user = $this->user_model->user_login($email, $password);
                if ($user != null && $rememberme != null) {
                    
                    redirect(base_url("admin/block-page"));
                }else{
                    $data["error_login"] = "<p>Invalid Email or Password !</p>";
                }
            }
        }
        $this->load->view('backend/authentication/index', $data);
    }

}
