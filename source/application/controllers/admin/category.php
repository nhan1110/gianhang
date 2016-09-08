<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {
    private $user_id = 0;
    private $type_member = "System";
    function __construct() {
        parent::__construct();
    }
    public function index(){
    	$category_type = new Category_Type();
        $category_type->order_by('ID', 'ASC');
        $category_type->get();
        $data['category'] = $category_type;
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/category/category',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function edit($id = null) {
        $category_type = new Category_Type();
        $category_type->where('ID', $id);
        $category_type->get(1);
        if ( !(isset($category_type->ID) &&  $category_type->ID!=null ) ) {
            redirect('/admin/category/');
            die;
        }
        $data['category_type'] = $category_type;
        $data['id'] = $id;
        $category = array(
            'items' => array(),
            'parents' => array()
        );
        $categories = new Categories();
        $categories->where('Type_ID', $id);
        $categories->order_by('Sort', 'ASC');
        $categories->get();
        foreach ($categories as $items) {
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $category['items'][$items->ID] = array(
                'slug' => $items->Slug,
                'title' => $items->Name,
                'id' => $items->ID
            );
            // Creates entry into parents array. Parents array contains a list of all items with children
            $category['parents'][$items->Parent_ID][] = $items->ID;
        }
        $data['category'] = $this->build_category_admin(0, $category, "easymm");
        $this->load->view('backend/include/header', $data);
        $this->load->view('backend/category/index', $data);
        $this->load->view('backend/include/footer', $data);
    }

    public function delete($category_type_id = null){
    	$category_type = new Category_Type();
        $category_type->where('ID', $category_type_id);
        $category_type->get(1);
        if ( !(isset($category_type->ID) &&  $category_type->ID!=null ) ) {
            redirect('/admin/category/');
            die;
        }
        $categories = new Categories();
        $categories->delete_by_group_id($category_type->ID);

        $category_type->delete_by_id($category_type->ID);

        redirect('/admin/category/');
        die;
    }

    private $data_category = array();

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
        $categories->Path = "/".$this->helperclass->slug($categories->table, "Slug", $this->input->post('name'))."/";
        $categories->Sort = 0;
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
                "Path" => $categories->Path . $cate_current->Slug."/",
                "Sort" => $item
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
    public function update_cat(){
        $all = $this->db->get("Categories")->result_array();
        foreach ($all as $key => $value) {
            $lengh = strlen($value["Path"]);
            if(substr($value["Path"],0,1) == "/"){
        
            }else{
                echo $value["Path"]."<br>";
                $this->db->where("ID",$value["ID"]);
                $data = array("Path" => "/".$value["Path"]);
                $this->db->update("Categories",$data);
            }
        }

    }

}