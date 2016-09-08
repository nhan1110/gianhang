<?php

/*
  Author     : phanquanghiep
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Keyword extends CI_Controller {

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
        } else {
            if ($this->input->is_ajax_request()) {
                die(json_encode(array('status' => 'error')));
            } else {
                redirect(base_url());
            }
        }
        $this->data["is_login"] = $this->is_login;
    }
    public function get() {
        check_ajax();
        $data["success"] = "error";
        $keyword = $this->input->post("keyword");
        $not_name = $this->input->post("not_name");
        $not_name = explode(",", $not_name);
        $not_name = array_diff($not_name, array(''));
        $text_not_show = "";
        $count = count($not_name);
        $type_id = $this->input->post("type_id");
        $i = 0;
        foreach ($not_name as $value) {
            $i++;
            if ($i < $count) {
                $text_not_show .= "'" . $value . "',";
            } else {
                $text_not_show .= "'" . $value . "'";
            }
        }

        $k = new Keywords();
        $data_k = $k->get_keyword($type_id, $this->user_id, $keyword, $text_not_show);
        if ($data_k != null) {
            $data["success"] = "success";
            $data["response"] = $data_k;
        }
        die(json_encode($data));
    }

}
