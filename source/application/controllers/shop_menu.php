<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_menu extends CI_Controller {

    private $is_login = false;
    private $user_info = array();
    private $user_id = 0;
    private $data = array();

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
            	$member_menus = new Member_Menu();
		        $member_menus->Member_ID = $this->user_id;
		        $member_menus->Title = $expolore[1];
		        $member_menus->URL = $expolore[0];
		        $member_menus->Path = $expolore[0];
		        $member_menus->Class_Menu = '';
		        $member_menus->Sort_Menu = 1000;
		        $member_menus->Type_Menu = 'inner';
		        $member_menus->Group_ID = $this->input->post('group_id');
		        $member_menus->Parent_ID = 0;
                if ($member_menus->save()) {
                    $data['status'] = 'success';
                    $reponse[] = array(
                        'url' => $member_menus->URL,
                        'title' => $member_menus->Title,
                        'id' => $member_menus->get_id_last_save()
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
            $member_menu = new Member_Menu();
            $member_menu->where( array('ID' => $id ,'Member_ID' => $this->user_id) )->get(1);
            if(! (isset($member_menu->ID) && $member_menu->ID != null) ){
            	die('false');
            }
            $member_menu->delete_by_id($member_menu->ID);

            
            $list_id = explode(',', $this->input->post('list_id'));
            if(isset($list_id) && count($list_id) > 0){
            	foreach ($list_id as $key => $value) {
            		if(isset($value) && trim($value)!=null && is_numeric($value)){
            			$member_menu->where( array('ID' => $value ,'Member_ID' => $this->user_id) )->get(1);
            			$member_menu->delete_by_id($member_menu->ID);
            		}
            	}
            }
            die('true');
        }
        die('false');
    }

    function update_item_menu($id = null) {
        if (isset($id) && $id != null && is_numeric($id) && $this->input->is_ajax_request()) {
            $member_menu = new Member_Menu();
            $member_menu->where( array('ID' => $id ,'Member_ID' => $this->user_id) )->get(1);
            if(! (isset($member_menu->ID) && $member_menu->ID != null) ){
            	die('false');
            }
            $arr = array(
                'Title' => $this->input->post('title'),
                'URL' => $this->input->post('url'),
                'Type_Menu' => $this->input->post('target')
            );
            $member_menu->where( array('ID' => $id ,'Member_ID' => $this->user_id))->update($arr);
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

        $check_count = new Member_Group_Menu();
        $check_count->where('Member_ID' , $this->user_id);
        if($check_count->count() >= 5){
        	$data['status'] = 'fail';
            $data['message'] = 'Số lượng menu của bạn đã vượt quá 5 menu.';
            die(json_encode($data));
        }

        $member_menu_group = new Member_Group_Menu();
        if (isset($id) && $id != null && is_numeric($id)) {
            
        } else { // Add new
            $member_menu_group->Member_ID = $this->user_id;
            $member_menu_group->Date_Creater = date('Y-m-d H:i:s');
            $member_menu_group->Title = $name;
            if ($member_menu_group->save()) {
                $data['status'] = 'success';
                $data['id'] = $member_menu_group->get_id_last_save();
            }
            else{
            	$data['status'] = 'fail';
            	$data['message'] = 'Lỗi không thể thêm mới.';
            }
        }
        die(json_encode($data));
    }

    function add_item_menu() {
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $member_menus = new Member_Menu();
        $member_menus->Member_ID = $this->user_id;
        $member_menus->Title = $this->input->post('title');
        $member_menus->URL = $this->input->post('url');
        $member_menus->Path = $this->input->post('url');
        $member_menus->Class_Menu = '';
        $member_menus->Sort_Menu = 1000;
        $member_menus->Type_Menu = $this->input->post('target');
        $member_menus->Group_ID = $this->input->post('group_id');
        $member_menus->Parent_ID = 0;
        if ($member_menus->save()) {
            $data['status'] = 'success';
            $data['id'] = $member_menus->get_id_last_save();
        }
        else{
        	$data['status'] = 'fail';
        	$data['message'] = 'Lỗi không thể thêm mới.';
        }
        die(json_encode($data));
    }

    function get_item_menu($id = null) {
        $data = array('status' => 'error');
        if (isset($id) && $id != null && is_numeric($id)) {
            $member_menus = new Member_Menu();
            $member_menus->where(array('ID' => $id , "Member_ID" => $this->user_id));
            $member_menus->get(1);
            if(! (isset($member_menus->ID) && $member_menus->ID != null) ){
            	die(json_encode($data));
            }
            $data['status'] = 'success';
            $data['title'] = $member_menus->Title;
            $data['url'] = $member_menus->URL;
            $data['target'] = $member_menus->Type_Menu;
        }
        die(json_encode($data));
    }

    private function position($data, $parent) {
        foreach ($data as $item => $value) {
            //update position menu item
            $arr = array(
                "Parent_ID" => $parent,
                "Sort_Menu" => $item
            );
            $member_menus = new Member_Menu();
            $member_menus->where('ID', $value['id'])->update($arr);
            if (isset($value['children']) && $value['children'] != null) {
                $this->position($value['children'], $value['id']);
            }
        }
    }

    private function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $slug;
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
