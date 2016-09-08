<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter extends CI_Controller {

    private $is_login = false;
    private $user_info = array();
    private $user_id = 0;
    private $data = array();
    private $_token = false;

    function __construct() {
        parent::__construct();
        $this->is_login;
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
        }
        $this->_token = _token();
        $this->data["is_login"] = $this->is_login;
        $this->data["_token"] = $this->_token;
    }

    public function index() {
    	redirect(base_url());
    }
    public function activate(){
        if($this->input->get("token") && $this->input->get("email")){
            $token = $this->input->get("token");
            $email = $this->input->get("email");
            $filter = [
                "Email" => $email,
                "Token" => $token,
                "Active" => "0"
            ];
            $nl = new Newsletter_Signup();
            $check = $nl->where($filter)->get_raw()->row_array();
            if($check != null){
                $nl->where("ID",$check["ID"])->update(["Active" => "1","Active_Day" => date("Y-m-d H:i:s"),"Token" => uniqid()]);
                redirect(base_url("?action=newsletter&status=success"));
            }

        }
        redirect(base_url());
    }
}
