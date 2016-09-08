<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index(){
        $menu_group = new Menu_Group();
        $menu_group->order_by('Group_ID', 'ASC');
        $menu_group->get();
        $data['menu_group'] = $menu_group;
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/menu/menu',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function edit($id = null) {
        $menu_group = new Menu_Group();
        $menu_group->where('Group_ID', $id);
        $menu_group->get();
        if ( !(isset($menu_group->Group_ID) && $menu_group->Group_ID!=null) ) {
           redirect('/admin/menu');
           die;
        }
        $data['menu_group'] = $menu_group;
        $data['id'] = $id;
        $menu = array(
            'items' => array(),
            'parents' => array()
        );
        $menus = new Menus();
        $menus->where('Group_ID', $id);
        $menus->order_by('Order', 'ASC');
        $menus->get();
        foreach ($menus as $items) {
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $menu['items'][$items->ID] = array(
                'class' => $items->Class,
                'url' => $items->URL,
                'title' => $items->Name,
                'id' => $items->ID
            );
            // Creates entry into parents array. Parents array contains a list of all items with children
            $menu['parents'][$items->Parent_ID][] = $items->ID;
        }
        $data['menu'] = $this->build_menu_admin(0, $menu, "easymm");

        $page = new Pages();
        $page->where('Page_Status', 0)->get();
        $data['page'] = $page;

        $category_type = new Category_Type();
        $category_type->order_by('ID', 'ASC');
        $category_type->get();
        $data['category_type'] = $category_type;

        $this->load->view('backend/include/header', $data);
        $this->load->view('backend/menu/index', $data);
        $this->load->view('backend/include/footer', $data);
    }

    public function delete($id = null){
        $menu_group = new Menu_Group();
        $menu_group->where('Group_ID', $id);
        $menu_group->get();
        if ( !(isset($menu_group->Group_ID) && $menu_group->Group_ID!=null) ) {
           redirect('/admin/menu');
           die;
        }
        $menus = new Menus();
        $menus->delete_by_group_id($menu_group->Group_ID);
        $menu_group->delete_by_id($menu_group->Group_ID);
        redirect('/admin/menu');
        die;
    }

    function add_menu_list() {
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $reponse = array();
        $item = $this->input->post('item');

        foreach ($item as $key => $value) {
            $expolore = explode("|", $value);
            if (isset($expolore) && count($expolore) == 2) {
                $menus = new Menus();
                $menus->Name = $expolore[1];
                $menus->Slug = $this->create_slug($expolore[1]);
                $menus->URL = $expolore[0];
                $menus->Path = $expolore[0];
                $menus->Class = '';
                $menus->Type = 'inner';
                $menus->Group_ID = $this->input->post('group_id');
                $menus->Parent_ID = 0;
                if ($menus->save()) {
                    $data['status'] = 'success';
                    $reponse[] = array(
                        'url' => $menus->URL,
                        'title' => $menus->Name,
                        'id' => $menus->get_id_last_save()
                    );
                }
            }
        }
        $data['reponse'] = $reponse;
        die(json_encode($data));
    }

    function get_category() {
        if (!$this->input->is_ajax_request()) {
            die(json_encode('error'));
        }
        $category_type_id = $this->input->post('id');
        if (!(isset($category_type_id) && $category_type_id != null && is_numeric($category_type_id))) {
            die('error');
        }


        $category = array(
            'items' => array(),
            'parents' => array()
        );
        $categories = new Categories();
        $categories->where('Type_ID', $category_type_id);
        $categories->order_by('Order', 'ASC');
        $categories->get();
        foreach ($categories as $items) {
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $category['items'][$items->ID] = array(
                'slug' => $items->Slug,
                'path' => $items->Path,
                'name' => $items->Name,
                'id' => $items->ID
            );
            // Creates entry into parents array. Parents array contains a list of all items with children
            $category['parents'][$items->Parent_ID][] = $items->ID;
        }
        $reponse = $this->get_category_admin(0, $category);
        die($reponse);
    }

    function update_menu() {
        if ($this->input->post('easymm') != null && $this->input->is_ajax_request()) {
            $this->position($this->input->post('easymm'), 0);
            die('true');
        }
        die('false');
    }

    function delete_menu_item($id = null) {
        if (isset($id) && $id != null && is_numeric($id) && $this->input->is_ajax_request()) {
            $menu = new Menus();
            $menu->where('ID', $id)->get();
            $menu->delete_by_id($menu->ID);
            die('true');
        }
        die('false');
    }

    function update_item_menu($id = null) {
        if (isset($id) && $id != null && is_numeric($id) && $this->input->is_ajax_request()) {
            $arr = array(
                'Name' => $this->input->post('title'),
                'Slug' => $this->create_slug($this->input->post('title')),
                'URL' => $this->input->post('url'),
                'Class' => $this->input->post('class'),
                'Type' => $this->input->post('target')
            );
            $menu = new Menus();
            $menu->where('ID', $id)->update($arr);
            die('true');
        }
        die('false');
    }

    function add_menu_group() {
        $data = array('status' => 'error');
        $name = $this->input->post('name');
        $id = $this->input->post('id');
        if ($name == '' || trim($name) == '' || !$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $menu_group = new Menu_Group();
        if (isset($id) && $id != null && is_numeric($id)) { // Update
            $menu_group->Name = $name;
            $menu_group->Date_Creater = date('Y-m-d H:i:s');
            if ($menu_group->save()) {
                $data['status'] = 'success';
                $data['id'] = $menu_group->get_id_last_save();
            }
        } else { // Add new
            $menu_group->Name = $name;
            $menu_group->Date_Creater = date('Y-m-d H:i:s');
            if ($menu_group->save()) {
                $data['status'] = 'success';
                $data['id'] = $menu_group->get_id_last_save();
            }
        }
        die(json_encode($data));
    }

    function add_item_menu() {
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $menus = new Menus();
        $menus->Name = $this->input->post('title');
        $menus->Slug = $this->create_slug($this->input->post('title'));
        $menus->URL = $this->input->post('url');
        $menus->Path = $this->input->post('url');
        $menus->Class = $this->input->post('class');
        $menus->Type = $this->input->post('target');
        $menus->Group_ID = $this->input->post('group_id');
        $menus->Parent_ID = 0;
        if ($menus->save()) {
            $data['status'] = 'success';
            $data['id'] = $menus->get_id_last_save();
        }
        die(json_encode($data));
    }

    function get_item_menu($id = null) {
        $data = array('status' => 'error');
        if (isset($id) && $id != null && is_numeric($id)) {
            $menu = new Menus();
            $menu->where('ID', $id);
            $menu->get();
            $data['status'] = 'success';
            $data['title'] = $menu->Name;
            $data['url'] = $menu->URL;
            $data['class'] = $menu->Class;
            $data['target'] = $menu->Type;
        }
        die(json_encode($data));
    }

    private function position($data, $parent) {
        foreach ($data as $item => $value) {
            //update position menu item
            $arr = array(
                "Parent_ID" => $parent,
                "Order" => $item
            );
            $menu = new Menus();
            $menu->where('ID', $value['id'])->update($arr);
            if (isset($value['children']) && $value['children'] != null) {
                $this->position($value['children'], $value['id']);
            }
        }
    }

    private function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $slug;
    }

    private function build_menu_admin($parent, $menu, $id = "") {
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
	                              <div class='ns-url'>" . $menu['items'][$itemId]['url'] . "</div>
	                              <div class='ns-class'>" . @$menu['items'][$itemId]['class'] . "</div>
	                              <div class='ns-actions'>
	                                 <a href='#' class='edit-menu' data-id='".$menu['items'][$itemId]['id']."' data-toggle='modal' data-target='#editModal' title='Edit Menu'><img src='" . skin_url('images/edit.png') . "' alt='Edit'></a>
	                                 <a href='#' class='delete-menu'><img src='" . skin_url('images/cross.png') . "' alt='Delete'></a>
	                                 <a href='#' class='slider-menu'><i class='fa fa-chevron-down'></i></a>
	                                 <input type='hidden' id='menu_id' name='menu_id' value='" . $menu['items'][$itemId]['id'] . "'>
	                              </div>
	                           </div>
	                         </li> \n";
                }
                if (isset($menu['parents'][$itemId])) {
                    $href = '';
                    if (isset($menu['items'][$itemId]['url']) && $menu['items'][$itemId]['url'] != null && $menu['items'][$itemId]['url'] != '') {
                        $href = "href='" . $menu['items'][$itemId]['url'] . "'";
                    }
                    $html .= "<li id='menu-" . $menu['items'][$itemId]['id'] . "' class='sortable'>\n
	                          <div class='ns-row'>
	                              <div class='ns-title'>" . $menu['items'][$itemId]['title'] . "</div>
	                              <div class='ns-url'>" . $menu['items'][$itemId]['url'] . "</div>
	                              <div class='ns-class'>" . @$menu['items'][$itemId]['class'] . "</div>
	                              <div class='ns-actions'>
	                                 <a href='#' class='edit-menu' data-id='".$menu['items'][$itemId]['id']."' data-toggle='modal' data-target='#editModal' title='Edit Menu'><img src='" . skin_url('images/edit.png') . "' alt='Edit'></a>
	                                 <a href='#' class='delete-menu'><img src='" . skin_url('images/cross.png') . "' alt='Delete'></a>
	                                 <a href='#' class='slider-menu'><i style='font-size: 13px;' class='fa fa-chevron-down'></i></a>
	                                 <input type='hidden' id='menu_id' name='menu_id' value='" . $menu['items'][$itemId]['id'] . "'>
	                              </div>
	                           </div>";
                    $html .= $this->build_menu_admin($itemId, $menu);
                    $html .= "</li> \n";
                }
            }
            $html .= "</ul> \n";
        }
        return $html;
    }

    private function get_category_admin($parent, $menu) {
        $html = "";
        if (isset($menu['parents'][$parent])) {
            $html .= "<ul>";
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $html .= "<li>";
                    $html .= "<input id='" . $menu['items'][$itemId]['slug'] . "' type='checkbox' name='item[]' value='" . $menu['items'][$itemId]['path'] . "|" . $menu['items'][$itemId]['name'] . "'>";
                    $html .= "<label for='" . $menu['items'][$itemId]['slug'] . "'><span>" . $menu['items'][$itemId]['name'] . "</span></label>";
                    $html .= "</li>";
                }
                if (isset($menu['parents'][$itemId])) {
                    $html .= "<li>";
                    $html .= "<input id='" . $menu['items'][$itemId]['slug'] . "' type='checkbox' name='item[]' value='" . $menu['items'][$itemId]['path'] . "|" . $menu['items'][$itemId]['name'] . "'>";
                    $html .= "<label for='" . $menu['items'][$itemId]['slug'] . "'><span>" . $menu['items'][$itemId]['name'] . "</span></label>";
                    $html .= $this->get_category_admin($itemId, $menu);
                    $html .= "</li>";
                }
            }
            $html .= "</ul>";
        }
        return $html;
    }

}
