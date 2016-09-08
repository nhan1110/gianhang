<?php

/*
  Created on : Feb 15, 2016, 7:00:18 PM
  Author     : phanquanghiep
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories_Type extends MY_Controller {
    public $data = array();
    private $html_tree = "";
    private $chech_root = 0;
    public function index($page = null) { 
        $this->data["title_curent"] = "Attribute set";
        $ct = new Category_type();   
        $all_data  = $ct->order_by("Sort", "ASC")->get_raw()->result_array();
        $all_data_root  = $ct->where("Parent_ID",0)->order_by("Sort", "ASC")->get_raw()->result_array();
        $this->data["tree_type"] =  $this->get_tree_product_type($all_data);
        $this->load->library('Helperclass');
        $select_html = $this->helperclass->get_select_tree($all_data_root, 0, "Parent_ID", "Name", null, "ID");
        $this->data["record"] = $all_data;
        $this->data["select_root"] = $select_html["table_tree_select"];
        $this->load->view('backend/include/header');
        $this->load->view('backend/category_type/index',$this->data);
        $this->load->view('backend/include/footer');
    }
    private function get_tree_product_type($tree = array(),$key_set = "Parent_ID", $id_before = 0 ,$class = "tree"){
    	if($id_before == 0){
    		$this->html_tree .= "<ul class='".$class." tree_parent root list-group level-0' data-level='0' data-id = '".$id_before."'>";
    	}else{
    		$this->html_tree .= "<ul class='tree_parent level-1' data-level='1'  data-id = '".$id_before."'>";
    	}
    	$id_parent = [];
    	if(is_array($tree) && count($tree) > 0){
    		foreach ($tree as $key => $value) {
	            if ($id_before == $value[$key_set]) {
	            	$id_parent[] = $value["ID"];
	                $this->html_tree.='<li class="item" data-id = "'.$value["ID"].'"">
	                		<div class="list-group-item"><span id="name-attribute">' . $value["Name"] . '</span>';
                                $this->html_tree.='<div class="actions">
                                    <a href="#" id="action-edit-cattype" data-id ="'.$value["ID"].'" data-src="'.$value["Images"].'" data-icon=\''.$value["Icon"].'\' data-type="attribute-group"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                                    <a href="'.base_url("admin/categories_type/disable/".$value["ID"]).'" id="action-disable" data-type="disable"><i class="fa fa-lock"></i></a>
                                    <a href="'.base_url("admin/categories_type/delete/".$value["ID"]).'" id="action-delete" data-type="delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';     		                	
                                $this->html_tree.='</div>';
                                if($value["Parent_ID"] == 0){
		                			$this->html_tree.='<div class="more close"><i class="fa fa-caret-down"></i></div>';
		                		}
	                		$this->html_tree.='</div>';
	                unset($tree[$key]);
	                $this->chech_root++;
	                $this->get_tree_product_type($tree,$key_set,$value["ID"],$class);
	                $this->html_tree.="</li>";  
	            }
	            $this->chech_root = 0;
        	}
    	};
    	$this->html_tree .= "<input type='hidden' value = '".implode(",", $id_parent)."' id ='sort_get' data-type='cactegory-type'>";
    	$id_parent = [];
    	$this->html_tree .= "</ul>";
    	return $this->html_tree ;
    }
    public function add(){
        check_ajax();
        $data["success"] = "error";
        $dataname = $this->input->post("name");
        $dataroot = $this->input->post("root");
        $icon = $this->input->post("icon");
        if(trim($dataname) != ""){  
            $sort_set = 0; 	
            $this->load->library('Helperclass');
            $slug = $this->helperclass->slug("Category_Type", "slug", trim($dataname));
            $path = "/".$slug."/";
            $ct = new Category_type();
            $check_root =  $ct->where(array("ID"=> $dataroot,"Parent_ID" => 0))->get_raw()->row_array();
            if($check_root == null){
            	$dataroot = 0;
            }else{
            	$path = $check_root["Path"] . $slug ."/";
            }
            $sort = $ct->where("Parent_ID",$dataroot)->select_max("Sort")->get();
            if(isset($sort->Sort) && is_numeric($sort->Sort)){
            	$sort_set = $sort->Sort + 1;
            }
            $path_image = '';
            if(isset($_FILES['images'])){
                $config['upload_path']          = './uploads/category_type/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2*1024;
                $config['max_width']            = 3000;
                $config['max_height']           = 2000;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('images')){
                    $upload_data = $this->upload->data();
                    $path_image = '/uploads/category_type/'.$upload_data['file_name'];
                }
            }

            $ct->Name = $dataname;
            $ct->Slug = $slug;
            $ct->Path = $path;
            $ct->Parent_ID = $dataroot;
            $ct->Sort = $sort_set;
            $ct->Disable = 0;
            $ct->Icon = $icon;
            $ct->Images = $path_image;
            $ct->save();
            $id = $ct->db->insert_id();
            $response = $ct->where("ID",$id)->get_raw()->row_array();
            $data["success"] = "success";
            $data["response"] = $response;
            $data["group_attribute"] = array();
            if($dataroot != 0){
                $gra = new Attribute_Group();
                $data["group_attribute"] = $gra->get_group_by_cat_type($dataroot);
            }
        }
        die(json_encode($data));
    }
    public function delete($id){
    	check_ajax();
        $data["success"] = "error";    	
    	if(isset($id) && is_numeric($id)){
    		$ct = new Category_Type();
    		$record = $ct->where("ID",$id)->get_raw()->row_array();
    		if(isset($record['Images']) && $record['Images']!=null && file_exists('.'.$record['Images'])){
    			unlink('.'.$record['Images']);
    		}
    		$this->db->delete("Category_Type",array('ID' => $id));
    		$this->db->delete("Category_Type",array('Parent_ID' => $id));
    		$data["success"] = "success";
    	}
    	die(json_encode($data));
    }
    public function show(){
        check_ajax();
        if($this->input->post("id")){
            $id = $this->input->post("id");
            $ctat = new Attribute_Group();
            $record = $ctat->get_group_bycat_id($id);
            $record_full = [];
            if($record != null){
                $aga = new Attribute_Group_Attribute();
                foreach ($record as $key => $value) {
                    $value["Attribute"] = $aga->get_attr_by_attr_group($value["ID"],$id);
                    $record_full[] = $value;
                }
            }
            die(json_encode($record_full));
        }
    }
    public function un_set_ag(){
        check_ajax();
        $data["success"] = "error";
        $id = $this->input->get("cattype_id");
        $not_show = $this->input->get("not_show");
        $show = $this->input->get("show");
        $icon = $this->input->post("icon");
        $not_show = array_diff(explode(",", $not_show),array(""));
        $show = array_diff(explode(",", $show), array(""));
        $cmns = new Common_Not_Show();
        $datime = date('Y-m-d H:i:s');

        if($not_show != null){
            foreach ($not_show as $value) {
                $arg = explode(":", $value);
                if(isset($arg[0]) && isset($arg[1]) && is_numeric($arg[1])){
                    $check = $cmns->where(array("Reference_Single_ID" => $id,"Reference_ID" => $arg[1],"Type"=>$arg[0]))->get_raw()->row_array();
                    if($check == null){
                        $cmns->Reference_Single_ID = $id;
                        $cmns->Reference_ID = $arg[1];
                        $cmns->Type = trim($arg[0]);
                        $cmns->Single_Type = "category_type";
                        $cmns->Createat    = $datime;
                        $cmns->save();
                    }

                }
            }
        }
        if($show != null){
            $aa = array();
            foreach ($show as $value) {
                $arg = explode(":", $value);
                if(isset($arg[0]) && isset($arg[1]) && is_numeric($arg[1])){
                    $aa[] = $filter = array(
                        "Reference_Single_ID" => $id,
                        "Reference_ID" => $arg[1],
                        "Type"=>$arg[0],
                        "Single_Type" => "category_type"
                    );
                    $this->db->delete("Common_Not_Show",$filter);
                }
            }
        }

        $name = $this->input->post("name");
        if($name != "" && isset($id) && $id != null && is_numeric($id)){
            $path_image = '';
            if(isset($_FILES['images'])){
                $config['upload_path']   = './uploads/category_type/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']      = 2*1024;
                $config['max_width']     = 3000;
                $config['max_height']    = 2000;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('images')){
                    $upload_data = $this->upload->data();
                    $path_image = '/uploads/category_type/'.$upload_data['file_name'];
                   
                }
            }
            $ct = new Category_Type();
            $record = $ct->where("ID",$id)->get_raw()->row_array();
            if(isset($record) && $record != null){
                $arr = array(
                    'Name' => $name,
                    'Icon' => $icon
                );
                $attribute = new Attribute();
                if(trim($record["Name"]) != trim($name)){
                    $this->load->library('Helperclass');
                    $slug = $this->helperclass->slug("Category_Type", "slug", $name);
                    $path = "/" . $slug . "/";
                    $arr['Slug'] = $slug;
                    $arr['Path'] = $path;
                    $attribute->replace_slug("Category_Type", $record["Path"], $path, $record["ID"]);
                }
               
                
                if($path_image != ''){
                    $arr['Images'] = $path_image;
                    if(isset($record['Images']) && $record['Images']!=null && file_exists('.'.$record['Images'])){
                        unlink('.'.$record['Images']);
                    }
                }
               
                $ct->where("ID", $record["ID"])->update($arr);
                $data['images'] = $path_image;
                $data['icon'] = $icon;
                $data["success"] = "success";
            }
        }
        die(json_encode($data));

    }

}
