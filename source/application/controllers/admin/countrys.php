<?php

/*
  Created on : Feb 17, 2016, 7:00:18 PM
  Author     : phanquanghiep
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Countrys extends MY_Controller {

    private $user_id = 0;
    private $data = [];
    private $type_member = "System";
    private $tree_country = "";
    public function __construct() {
        parent::__construct();
    }

    public function index($max_level=0) {
    	$slug = $this->input->get('slug');
    	$slug = (!$slug || empty($slug)) ? '/' : $slug;
    	if (substr($slug,-1) != '/') {
    		$slug .= '/';
    	}
        $country_model = new Country();
        $data['collections'] = $country_model->get_list_city($slug,$max_level);
        $title = 'Tỉnh/Thành Phố';
        $slug_array = explode('/', $slug);
        
        switch ($max_level) {
        	case "0":
        		$title = 'Tỉnh/Thành Phố';
        		break;
        	case "1":
        		// Get City name
        		$city_model = new Country();
        		$city_data = $city_model->get_row($slug_array[1]);
        		$title = 'Quận/Huyện';
        		if ($city_data != null) {
        			$title = '<a href="'.base_url('admin/countrys/index/') . '">' . $city_data['Name'] . '</a>' . ' >> ' . $title;
        		}
        		break;
        	case "2":
        		// Get City name
        		$city_model = new Country();
        		$city_data = $city_model->get_row($slug_array[1]);
        		$district_data = $city_model->get_row($slug_array[2]);
        		$title = 'Phường/Xã';
        		if ($city_data != null) {
        			$title = '<a href="'.base_url('admin/countrys/index/') . '">' . $city_data['Name'] . '</a>' . ' >> ' . '<a href="'.base_url('admin/countrys/index/1/?slug=/'.$slug_array[1]) . '">' . $district_data['Name'] . '</a>' . ' >> ' . $title;
        		}
        		break;
        }
        $data['title'] = $title;
        $data['max_level'] = ($max_level + 1);
        $this->load->view('backend/include/header', $data);
        $this->load->view('backend/countries/index', $data);
        $this->load->view('backend/include/footer', $data);
    }
    
    public function get_districts() {
        check_ajax();
        $data["success"] = "error";
        $id = $this->input->post("id");
        $level = $this->input->post("level");
        if (is_numeric($id)) {
            $c = new Country();
            $c_arg = $this->data["city"] = $c->get_country($this->user_id, $level, $id,0);
            echo json_encode($c_arg);
        }
    }
    
    public function list_construct($arg,$root){
    	$tree="";
    	if($arg != null){
    		foreach ($arg as $key => $value) {
    			$tree.="<ul>";
    			if($value["Parent_ID"] == $root){
    				unset($arg[$key]);
    				$tree.="<li><a>".$value["Name"]."</a>";
    				$tree.= $this->list_construct($arg,$value["ID"]);
    				$tree.="</li>";
    			}
    			$tree.="</ul>";
    		}
    	}
    	return $tree;
    }

}