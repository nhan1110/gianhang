<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    private $is_login = false;
    private $user_info = array();
    private $user_id = 0;
    private $data = array();
    private $type_member = "Member";
    private $data_category = array();
    function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
            $this->type_member = $this->user_info["type_member"];
        } 
        $this->data["is_login"] = $this->is_login;
        $this->data["product_on_page"] = $this->Common_model->get_record("Website_Setting",["Key_Identify" => "number_show_product"]);
        $this->data["product_on_page"] = (@$this->data["product_on_page"]["Title"] !== "" && is_numeric(@$this->data["product_on_page"]["Title"])) ? $this->data["product_on_page"]["Title"] : "0";
    }
    public function index($slug = null){
        if($slug != null){
            $last = $this->uri->total_segments();
            $category_current = $this->uri->segment($last);
            $uri = $this->uri->segment_array();
            $ct = new Category_Type();
            $cat = new Categories();
            $p = new Products();
            $check = $ct->where(["Slug" => trim($slug),"Disable" => "0"])->get_raw()->row_array();
            if($check != null){
                $id = @$check["ID"];
                $breadcrumb = '<li><a href="'.base_url().'">Home</a></li>';
                $i_check = count($uri);
                $active_link = [];
                $path_current = "/";
                $check_category = null;
                for ($i=0; $i <= ($i_check); $i++) { 
                    if($i > 0){
                        if($i == 1){
                            $breadcrumb .= '<li><a href="'.base_url("danh-muc".$check["Path"]).'">'.$check["Name"].'</a></li>';
                        }else{
                            $cat_current = $cat->where("Slug",$uri[$i])->get_raw()->row_array();
                            if($cat_current != null){
                                if($i < $i_check){
                                    $breadcrumb .= '<li><a href="'.base_url("loai-san-pham/".$check["Slug"].$cat_current["Path"]).'">'.$cat_current["Name"].'</a></li>';
                                }else{
                                    $breadcrumb .= '<li class="activer">'.$cat_current["Name"].'</li>';
                                    $check_category = $cat_current;
                                }
                                $path_current .= $cat_current["Slug"].'/';
                                $active_link[] = $cat_current["ID"]; 
                            }  
                        }
                    }
                }
                if($check_category != null){
                    if(@$check_category["Path"] != $path_current){
                        redirect(base_url("loai-san-pham/".$check["Slug"].$check_category["Path"]));
                    }else{
                        $path = $check_category["Path"];
                        $this->data["breadcrumb"] = $breadcrumb;
                        $parent_id = $check["Parent_ID"];
                        $a = new Attribute();
                        $cns = new Common_Not_Show();
                        $att_ns = $cns->select("Reference_ID")->where(["Reference_Single_ID"=>$id,"Type" => "attribute","Single_Type" =>"category_type"])->get_raw()->result_array();
                        $array_ns []= -1;
                        foreach ($att_ns as $key => $value) {
                           $array_ns[]=$value["Reference_ID"];
                        }
                        $attribute = $a->get_attr_cat_set([$id,$parent_id],["checkbox","select","radio","multipleselect","multipleradio","option"],$array_ns,$id);
                        $html = $this->_attr_search($attribute,0,"attribute");
                        $this->data["attribute"] = $html;
                        $children  = $ct->select("*")->like("Path",$path)->get_raw()->result_array();
                        $categories = $cat->get_cat_cat_set([$id,$parent_id],$id);
                        $html_categories = $this->_attr_search($categories,0,"categories","list-cat","href","/".$slug,$active_link);
                        $products = $p->get_product_by_type($check["Path"],$check_category["Path"],null,0,$this->data["product_on_page"]);
                        $this->data["categories"] = $html_categories;
                        $kw = new keywords();
                        $this->data["path"] = $check["Path"];
                        $this->data["keyword"] = $kw->get_kw_by_type($check["Path"]);
                        $this->data["products"] = $products; 
                        $this->data["max_price"] = $p->get_max_min_price($check["Path"],$check_category["Path"],null,true); 
                        $this->data["min_price"] = $p->get_max_min_price($check["Path"],$check_category["Path"],null,false);     
                        $this->data["min_price"] = str_replace(".","",$this->data["min_price"]);
                        $this->data["max_price"] = str_replace(".","",$this->data["max_price"]);
                        $this->data["total_product"] = $p->get_total_product($check["Path"],$check_category["Path"],null);    
                        $this->load->view('fontend/block/header', $this->data);
                        $this->load->view('fontend/category_type/index',$this->data);
                        $this->load->view('fontend/block/footer',$this->data);

                    }                    
                }else{
                    redirect(base_url());
                }
                
            }else{
                redirect(base_url());
            }
        }
    }
    public function store() {
        check_ajax();
        if ($this->input->post()) {
            $name = $this->input->post("name");
            $pid = $this->input->post("pid");
            $datime = date('Y-m-d H:i:s');
            $this->load->library('Helperclass');
            $slug = $this->helperclass->slug("categories", "slug", trim($name));
            $path = $slug;
            if (is_numeric($pid) && $pid > 0) {
                $record_path = $this->Common_model->get_record("categories", array('id' => $pid));
                $path = $record_path["path"] . "/" . $slug;
            }
            $data_insert = array(
                "name" => trim($name),
                "slug" => $slug,
                "pid" => $pid,
                "order" => 0,
                "path" => $path,
                "type" => "custom",
                "created_at" => $datime,
                "updated_at" => $datime,
                "disable" => "0",
                "user_id" => $this->user_id
            );
            $id = $this->Common_model->add("categories", $data_insert);
            $data_insert["id"] = $id;
            die(json_encode($data_insert));
        }
    }
    function update_category() {
        if ($this->input->post('easymm') != null && $this->input->is_ajax_request()) {
            $this->data_category = $this->input->post('easymm');
            $this->position($this->input->post('easymm'), 0);
            die('true');
        }
        die('false');
    }

    function delete_category_item($id = null) {
        if (isset($id) && $id != null && is_numeric($id) && $this->input->is_ajax_request()) {
            $categories = new Categories();
            $categories->where('ID', $id)->get();
            $categories->delete_by_id($categories->ID);
            die('true');
        }
        die('false');
    }

    function update_item_category($id = null) {
        if (isset($id) && $id != null && is_numeric($id) && $this->input->is_ajax_request()) {
            //$this->load->library('Helperclass');
            $categories = new Categories();
            $arr = array(
                'Name' => $this->input->post('name'),
                    // 'Slug' => $this->helperclass->slug($categories->table,"Slug",$this->input->post('name'))
            );
            $categories->where('ID', $id)->update($arr);
            die('true');
        }
        die('false');
    }

    function add_type_group() {
        $data = array('status' => 'error');
        $name = $this->input->post('name');
        if ($name == '' || trim($name) == '' || !$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $this->load->library('Helperclass');
        $category_type = new Category_Type();
        $category_type->Name = $name;
        $category_type->Slug = $this->helperclass->slug($category_type->table, "Slug", $this->input->post('name'));
        if ($category_type->save()) {
            $data['status'] = 'success';
            $data['id'] = $category_type->get_id_last_save();
        }
        die(json_encode($data));
    }

    function add_item_category() {
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $this->load->library('Helperclass');
        $categories = new Categories();
        $categories->Name = $this->input->post('name');
        $categories->Slug = $this->helperclass->slug($categories->table, "Slug", $this->input->post('name'));
        $categories->Path = $this->helperclass->slug($categories->table, "Slug", $this->input->post('name'));
        $categories->Order = 0;
        $categories->Type = 'System';
        $categories->Type_ID = $this->input->post('group_id');
        $categories->Parent_ID = 0;
        $categories->Member_id = 1;
        $categories->Createdat = date('Y-m-d H:i:s');
        if ($categories->save()) {
            $data['status'] = 'success';
            $data['id'] = $categories->get_id_last_save();
            $data['slug'] = $categories->Slug;
        }
        die(json_encode($data));
    }

    function get_item_category($id = null) {
        $data = array('status' => 'error');
        if (isset($id) && $id != null && is_numeric($id)) {
            $categories = new Categories();
            $categories->where('ID', $id);
            $categories->get();
            $data['status'] = 'success';
            $data['name'] = $categories->Name;
            $data['slug'] = $categories->Slug;
        }
        die(json_encode($data));
    }

    private function position($data, $parent) {
        foreach ($data as $item => $value) {
            //update position category item

            $parents_id = $this->get_parents_key($this->data_category, $value['id']);
            if (!is_numeric($parents_id)) {
                $parents_id = 0;
            }

            $categories = new Categories();
            $categories->where('ID', $parent)->get();

            $cate_current = new Categories();
            $cate_current->where('ID', $value['id'])->get();

            $arr = array(
                "Parent_ID" => $parent,
                "Parents_ID" => $parents_id,
                "Path" => $categories->Path . '/' . $cate_current->Slug,
                "Order" => $item
            );
            $Categories = new Categories();
            $Categories->where('ID', $value['id'])->update($arr);
            if (isset($value['children']) && $value['children'] != null) {
                $this->position($value['children'], $value['id']);
            }
        }
    }

    private function get_parents_key($array, $current_id) {
        if (isset($array) && count($array) > 0) {
            for ($i = 0; $i < count($array); $i++) {
                if ($array[$i]['id'] == $current_id) {
                    return true;
                }
                if (isset($array[$i]['children']) && $this->get_parents_key($array[$i]['children'], $current_id)) {
                    return $array[$i]['id'];
                }
            }
        } else {
            return false;
        }
    }

    private function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $slug;
    }

    private function build_category_admin($parent, $menu, $id = "") {
        $html = "";
        if (isset($menu['parents'][$parent])) {
            $cls = '';
            if ($parent == 0) {
                $cls = $id;
            }
            $html .= "<ul id='" . $cls . "'>\n";
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $html .= "<li id='menu-" . $menu['items'][$itemId]['id'] . "' class='sortable'>\n  
                              <div class='ns-row'>
                                <div class='ns-title'>" . $menu['items'][$itemId]['title'] . "</div>
                                <div class='ns-url'>" . $menu['items'][$itemId]['slug'] . "</div>
                                <div class='ns-actions'>
                                   <a href='#' class='edit-menu' data-id='" . $menu['items'][$itemId]['id'] . "' data-toggle='modal' data-target='#editModal' title='Edit'><img src='" . skin_url('images/edit.png') . "' alt='Edit'></a>
                                   <a href='#' class='delete-menu'><img src='" . skin_url('images/cross.png') . "' alt='Delete'></a>
                                   <a href='#' class='slider-menu'><i class='fa fa-chevron-down'></i></a>
                                   <input type='hidden' id='menu_id' name='menu_id' value='" . $menu['items'][$itemId]['id'] . "'>
                                </div>
                             </div>
                           </li> \n";
                }
                if (isset($menu['parents'][$itemId])) {
                    $html .= "<li id='menu-" . $menu['items'][$itemId]['id'] . "' class='sortable'>\n
                            <div class='ns-row'>
                                <div class='ns-title'>" . $menu['items'][$itemId]['title'] . "</div>
                                <div class='ns-url'>" . $menu['items'][$itemId]['slug'] . "</div>
                                <div class='ns-actions'>
                                   <a href='#' class='edit-menu' data-id='" . $menu['items'][$itemId]['id'] . "' data-toggle='modal' data-target='#editModal' title='Edit Menu'><img src='" . skin_url('images/edit.png') . "' alt='Edit'></a>
                                   <a href='#' class='delete-menu'><img src='" . skin_url('images/cross.png') . "' alt='Delete'></a>
                                   <a href='#' class='slider-menu'><i style='font-size: 13px;' class='fa fa-chevron-down'></i></a>
                                   <input type='hidden' id='menu_id' name='menu_id' value='" . $menu['items'][$itemId]['id'] . "'>
                                </div>
                             </div>";
                    $html .= $this->build_category_admin($itemId, $menu);
                    $html .= "</li> \n";
                }
            }
            $html .= "</ul> \n";
        }
        return $html;
    }

    public function addcategory() {
        check_ajax();
        $name = $this->input->post("name");
        $type = $this->input->post("type");
        $pid = $this->input->post("pid");
        $type_id = $this->input->post("cattypeid");
        $datime = date('Y-m-d H:i:s');
        $this->load->library('Helperclass');
        $slug = $this->helperclass->slug("Categories", "slug", trim($name));
        $path = "/" . $slug . "/";
        if (is_numeric($pid) && $pid > 0) {
            $record_path = $this->Common_model->get_record("Categories", array('ID' => $pid));
            $path = $record_path["Path"] . $slug . "/";
        }
        $category = new Categories();
        $category->Name = $name;
        $category->Slug = $slug;
        $category->Order = 0;
        $category->Path = $path;
        $category->Parent_ID = $pid;
        $category->Type = $this->type_member;
        $category->Type_ID = $type_id;
        $category->Member_id = $this->user_id;
        $category->Createdat = $datime;
        $category->Updatedat = $datime;
        $category->save();
        $id = $category->db->insert_id();
        $data = array(
            "id" => $id,
            "type" => $type,
            "name" => $name,
            "pid" => $pid,
            "slug" => $slug
        );
        die(json_encode($data));
    }
    private $html = "";
    function _attr_search ($arg,$root,$type,$class = "list-attribute",$link = null,$url = "",$actives = null){
        if($root == 0){
            $this->html  = "";
            $this->html .= '<ul class="'.$class.'" id="box-search-parent">';
        }else{
            $this->html .= '<ul>';
        }
        if($arg != null){
            foreach ($arg as $key => $value) {
                if($value["Parent_ID"] == $root){
                    $active = "";
                    if($actives != null && $actives){
                        foreach ($actives as $key_actives => $value_actives) {
                            if($value["ID"] == $value_actives){
                                $active = "active";
                                unset($actives[$key_actives]);
                            }
                        }
                    }
                    $order = (isset($value["Order"]) && $value["Order"] != null) ? $value["Order"] : "0";
                    unset($arg[$key]);
                    if($link == null){
                        $this->html.= '<li class="'.$active.'">
                                <div class="checkbox">
                                    <input id="'.$value["Slug"].'" class="styled" type="checkbox" value ="'.$value["Path"].'" data-type ="'.$type.'">
                                    <label for="'.$value["Slug"].'">
                                        '.$value["Name"].' <span class="count">('.$order.')</span>
                                    </label>
                                </div>'; 
                                $this->_attr_search($arg,$value["ID"],$type,$class,$link,$actives);
                        $this->html.='</li>';
                    }else{
                        $this->html.= '<li class="'.$active.'"><a href="'.base_url("loai-san-pham".$url.$value["Path"]).'" title="'.$value["Name"].'">'.$value["Name"].' <span class="count">('.$order.')</span></a>';
                            $this->_attr_search($arg,$value["ID"],$type,$class,$link,$url,$actives);
                        $this->html.='</li>';
                    }
                    $active = "";
                }
            }
        }
        $this->html .= "</ul>";
        return $this->html;
    }
}
