<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Module extends MY_Controller {
    private $data = [];
    private $data_category = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Modules');
    }

    public function index() {
        $modules = new Modules();
        $modules->order_by('Order', 'ASC');
        $modules->get();
        $category = array(
            'items' => array(),
            'parents' => array()
        );
        foreach ($modules as $item) {
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $category['items'][$item->ID] = array(
                'key' => $item->Module_Key,
                'title' => $item->Module_Name,
                'url' => $item->Module_Url,
                'id' => $item->ID
            );
            // Creates entry into parents array. Parents array contains a list of all items with children
            $category['parents'][$item->Parent_ID][] = $item->ID;
        }
        $data['category'] = $this->build_tree(0, $category, "easymm");
        $this->load->view('backend/include/header', $data);
        $this->load->view('backend/module/index', $data);
        $this->load->view('backend/include/footer', $data);
    }
    
    private function build_tree($parent, $menu, $id = "") {
        $html = "";
        if (isset($menu['parents'][$parent])) {
            $cls = '';
            if ($parent == 0) {
                $cls = $id;
            }
            $html .= "<ul id='" . $cls . "'>\n";
            foreach ($menu['parents'][$parent] as $itemId) {
                    $html .= "<li id='menu-" . $menu['items'][$itemId]['id'] . "' data-url='" . $menu['items'][$itemId]['key'] . "' class='sortable'>\n
                            <div class='ns-row'>
                                <div class='ns-actions'>
                                   <a href='#' class='edit-menu' data-id='" . $menu['items'][$itemId]['id'] . "' title='Edit Menu'><i class='fa fa-edit'></i></a>
                                   <a href='#' class='delete-menu'><i class='fa fa-close'></i></a>
                                   <a href='#' class='slider-menu'><i style='font-size: 13px;' class='fa fa-chevron-down'></i></a>
                                   <input type='hidden' id='menu_id' name='menu_id' value='" . $menu['items'][$itemId]['id'] . "'>
                                </div>
                                <div class='ns-url'>" . $menu['items'][$itemId]['url'] . "</div>
                                <div class='ns-title'>" . $menu['items'][$itemId]['title'] . "</div>
                             </div>";
                    $html .= $this->build_tree($itemId, $menu);
                    $html .= "</li> \n";
            }
            $html .= "</ul> \n";
        }
        return $html;
    }

    function update_position_action() {
        if ($this->input->post('easymm') != null && $this->input->is_ajax_request()) {
            $this->data_category = $this->input->post('easymm');
            $this->position($this->input->post('easymm'), 0);
            die('true');
        }
        die('false');
    }

    function delete_action($id = null) {
        if (isset($id) && $id != null && is_numeric($id) && $this->input->is_ajax_request()) {
            $m = new Modules();
            // Find all child
            $m->where('Parent_ID', $id)->get(1);
            if (!(isset($m->ID) && $m->ID != null)) {
            	$modules = new Modules();
            	$modules->where('ID', $id)->get();
            	$modules->delete_by_id($modules->ID);
            	die('true');
            }
            die('child');
        }
        die('false');
    }

    function update_action($id = null) {
        if (isset($id) && $id != null && is_numeric($id) && $this->input->is_ajax_request()) {
            $modules = new Modules();
            $arr = array(
                'Module_Name' => $this->input->post('name'),
                'Module_Key' => $this->input->post('key'),
                'Module_Url' => $this->input->post('url'),
                'Module_Class' => $this->input->post('class')
            );
            $modules->where('ID', $id)->update($arr);
            die(json_encode(array('status' => 'success')));
        }
        die(json_encode(array('status' => 'false')));
    }

    function add_action() {
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $modules = new Modules();
        $this->load->library('Helperclass');
        $modules->Module_Name = $this->input->post('name');
        $modules->Module_Key = $this->input->post('key');
        $modules->Module_Url = $this->input->post('url');
        $modules->Module_Class = $this->input->post('class');
        $modules->Module_Path = '/';
        $modules->Order = 0;
        $modules->Parent_ID = 0;
        if ($modules->save()) {
            $data['status'] = 'success';
            $data['id'] = $modules->get_last_id();
            $data['key'] = $modules->Module_Key;
            $data['name'] = $modules->Module_Title;
            $data['url'] = $modules->Module_Url;
        }
        die(json_encode($data));
    }

    function get_item($id = null) {
        $data = array('status' => 'error');
        if (isset($id) && $id != null && is_numeric($id)) {
            $modules = new Modules();
            $modules->where('ID', $id);
            $modules->get();
            $data['status'] = 'success';
            $data['name'] = $modules->Module_Name;
            $data['key'] = $modules->Module_Key;
            $data['url'] = $modules->Module_Url;
            $data['class'] = $modules->Module_Class;
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

            $modules = new Modules();
            $modules->where('ID', $parent)->get();

            $current = new Modules();
            $current->where('ID', $value['id'])->get();
            
            $path = '/';
            if (!empty($modules->Module_Path)) {
            	$path = '';
            }
            $arr = array(
                "Parent_ID" => $parent,
                "Module_Path" => $modules->Module_Path . $path . $this->create_slug($current->Module_Name) . '/',
                "Order" => $item
            );
            
            // Update position
            $moduleUpdate = new Modules();
            $moduleUpdate->where('ID', $value['id'])->update($arr);
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

}