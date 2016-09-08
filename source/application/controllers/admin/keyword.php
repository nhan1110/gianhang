<?php

/*
  Author     : phanquanghiep
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Keyword extends MY_Controller {

    private $user_id = 0;
    private $data = [];
    private $type_member = "Member";

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
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
        $data_k = $k->get($type_id, $this->user_id, $keyword, $text_not_show);
        if ($data_k != null) {
            $data["success"] = "success";
            $data["response"] = $data_k;
        }
        die(json_encode($data));
    }

}