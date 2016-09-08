<?php

/*
  Created on : Feb 17, 2016, 7:00:18 PM
  Author     : phanquanghiep
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Countrys extends CI_Controller {

    private $is_login = false;
    private $user_info = array();
    private $user_id = 0;
    private $data = array();
    private $type_member = "Member";

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
            $this->type_member = $this->user_info["type_member"];
        }
        $this->data["is_login"] = $this->is_login;
    }

    public function index() {
        
    }

    public function get_districts() {
        check_ajax();
        $id = $this->input->post("id");
        $level = $this->input->post("level");
        $category_type = $this->input->post("category_type");
        $c = new Country();
        $ct = new Category_type();
        if($category_type != null && $category_type != ""){
            $category_type = $ct->where("Path",$category_type)->get_raw()->row_array();
            $type_id = $category_type["ID"];
        }else{
            $type_id = 0;
        }
        
        $c_arg = [];
        if(is_numeric($id) && $id != null && $id != "" && is_numeric($level) && $level != "" && $level != null){
            $c_arg = $c->get_country($this->user_id, $level, $id,$type_id);
        }
        die(json_encode($c_arg));
    }

}
