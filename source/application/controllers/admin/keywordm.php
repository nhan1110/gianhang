<?php

/*
  Created on : Feb 15, 2016, 7:00:18 PM
  Author     : phanquanghiep
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Keywordm extends MY_Controller {

    public $show_number_page = 20;
    public function __construct() {
        parent::__construct();
        $this->load->library('pagination');
    }

    public function index() {
        $per_page = $this->show_number_page;
        $current_page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $offset = 0;
        if (!($current_page > 0)) {
            $current_page = 1;
        }
        $offset = ($current_page - 1)*$per_page;
        
        $model = new Keywords();
        $model->order_by('Created_at', 'DESC');
        $group = "";
        $keyword = "";
        if ($this->input->get()) {
            $keyword = $this->input->get('keyword');
            $group = $this->input->get('group');
            if ($keyword !== FALSE && !empty($keyword)) {
                $model->like('Name', $keyword);
            }
            if ($group !== FALSE && !empty($group)) {
                $model->where('Type_ID', $group);
                $data['group'] = $group;
            }
        }
        $model->get_paged($offset, $per_page, TRUE);

        $data['collections'] = $model;
        if ($offset > $model->paged->total_rows) {
            $offset = floor($model->paged->total_rows / $per_page) * $per_page;
        }
        
        $pagination_config = array(
            'base_url' => site_url('admin/keywordm'),
            'total_rows' => $model->paged->total_rows,
            'per_page' => $per_page,
            'uri_segment' => 4
        );
        $this->pagination->initialize($pagination_config);
        
        $data['pagination'] = $this->pagination;
        $data['offset'] = $offset;
        $data['total_rows'] = $model->paged->total_rows;
        $data['per_page'] = $per_page;
        $data['current_page'] = $current_page;
        $data['show_number_page'] = $this->show_number_page;

        $category_Type = new Category_Type();
        $table = $category_Type->get_raw()->result_array();
        $this->load->library('Helperclass');
        $table_tree = $this->helperclass->get_select_tree($table, 0, "Parent_ID", "Name", "table_tree_select", "ID", [array("ID" => $group)]);
        $data["all_cat_type"] = $table_tree["table_tree_select"];
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/keyword/index',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function trend() {
        $per_page = $this->show_number_page;
        $current_page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $offset = 0;
        if (!($current_page > 0)) {
            $current_page = 1;
        }
        $offset = ($current_page - 1)*$per_page;
        
        $model = new Keyword_Search();
        $model->order_by('Created_at', 'DESC');
        $group = "";
        $keyword = "";
        if ($this->input->get()) {
            $keyword = $this->input->get('keyword');
            $group = $this->input->get('group');
            if ($keyword !== FALSE && !empty($keyword)) {
                $model->like('Name', $keyword);
            }
            if ($group !== FALSE && !empty($group)) {
                $model->where('Type_ID', $group);
                $data['group'] = $group;
            }
        }
        $model->get_paged($offset, $per_page, TRUE);

        $data['collections'] = $model;
        if ($offset > $model->paged->total_rows) {
            $offset = floor($model->paged->total_rows / $per_page) * $per_page;
        }
        
        $pagination_config = array(
            'base_url' => site_url('admin/keywordm'),
            'total_rows' => $model->paged->total_rows,
            'per_page' => $per_page,
            'uri_segment' => 4
        );
        $this->pagination->initialize($pagination_config);
        
        $data['pagination'] = $this->pagination;
        $data['offset'] = $offset;
        $data['total_rows'] = $model->paged->total_rows;
        $data['per_page'] = $per_page;
        $data['current_page'] = $current_page;
        $data['show_number_page'] = $this->show_number_page;

        $category_Type = new Category_Type();
        $table = $category_Type->get_raw()->result_array();
        $this->load->library('Helperclass');
        $table_tree = $this->helperclass->get_select_tree($table, 0, "Parent_ID", "Name", "table_tree_select", "ID", [array("ID" => $group)]);
        $data["all_cat_type"] = $table_tree["table_tree_select"];
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/keyword/index',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function delete($id = null) {
        check_ajax();
        $data["success"] = "error";
        if ($id != null && is_numeric($id)) {
            $p = new Products();
            $check = $p->where("ID",$id)->get_raw()->row_array();
            if ($check !== null) {
                // update category
                $ctp = new Product_Category();
                $cat_all_id = $ctp->where("Product_ID", $id)->select("Term_ID")->get_raw()->result_array();
                $cat_id[] = -1;
                foreach ($cat_all_id as $key => $value) {
                    $cat_id [] = $value["Term_ID"];
                }
                $ct = new Categories();
                $ct->update_order($cat_id, -1);
                // update attribute 
                $attribute_id[] = -1;
                $a_value = new Attribute_Value();
                $a_update = new Attribute();
                $attr_arg = $a_value->where("Product_ID", $id)->select("*")->get_raw()->result_array();
                if ($attr_arg != null) {
                    foreach ($attr_arg as $key => $value) {
                        $attribute_id [] = $value["Attribute_ID"];
                        $arg_text_attr = explode("{[-]}", $value["Value"]);
                        if($arg_text_attr != null){
                            $get_attr_id =  $a_update->where( 
                                array(
                                    "Parent_ID" => $value["Attribute_ID"] , 
                                    "Order >" => "0"
                                )
                            )->where_in("Name",$arg_text_attr)->get_raw()->result_array();
                            $in_id_attr = array();
                            foreach ($get_attr_id as $key => $value_2) {
                                $in_id_attr [] = $value_2["ID"];
                            }
                            if($in_id_attr != null){
                                $a_update->update_order($in_id_attr,-1);
                            }
                        }
                    }
                }
                
                $a_update->update_order($attribute_id, -1);
                // update Country
                $country = new Country();
                $path_country = $check["Path_Adderss"];
                if($path_country != null){
                    $arg_slug_country = explode("/", $path_country);
                    $arg_slug_country = array_diff($arg_slug_country, array(''));
                    foreach ($arg_slug_country as $key => $value) {
                        $country->update_order(array($value),-1);
                    }
                }
                $this->db->delete("Attribute_Value", array('Product_ID' => $id));
                $this->db->delete("Products", array('ID' => $id));
                $data["success"] = "success";
            }
        }
        die(json_encode($data));
    }

    

}
