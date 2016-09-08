<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Helperclass extends CI_Controller {

    private $key_slug = 0;
    private $table_tree_select = "";
    private $table_tree = "";
    private $all_record_category = [];
    private $id_tree = [];

    public function __construct() {
        $CI = & get_instance();
        $CI->load->helper('url');
        $CI->load->library('session');
        $CI->load->database();
    }

    public function gen_slug($str) {
        $a = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ", " ");
        $b = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A ", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D", "-");
        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), str_replace($a, $b, $str)));
    }

    public function check_slug($slug, $arg, $key_slug, $default) {
        if (in_array($slug, $arg) == true) {
            $this->key_slug++;
            $this->check_slug($default . "-" . $this->key_slug, $arg, $this->key_slug, $default);
        }
        return $this->key_slug;
    }

    public function slug($table, $colum, $name , $where = null) {
        $CI = & get_instance();
        $CI->load->model("Common_model");
        $slug = $this->gen_slug($name);
        $record = $CI->Common_model->slug($table, $colum, $slug , $where);
        $arg_slug = array();
        if (count($record) > 0) {
            foreach ($record as $key => $value) {
                $arg_slug[] = $value[$colum];
            }
            $key_slug = $this->check_slug($slug, $arg_slug, $this->key_slug, $slug);
            if ($key_slug != 0) {
                $slug = $slug . "-" . $key_slug;
            }
        }
        $this->key_slug = 0;
        return $slug;
    }


    public function slug_member($table, $colum, $name,$member_id) {
        $CI = & get_instance();
        $CI->load->model("Common_model");
        $slug = $this->gen_slug($name);
        $record = $CI->Common_model->slug($table, $colum, $slug, $member_id);
        $arg_slug = array();
        if (count($record) > 0) {
            foreach ($record as $key => $value) {
                $arg_slug[] = $value[$colum];
            }
            $key_slug = $this->check_slug($slug, $arg_slug, $this->key_slug, $slug);
            if ($key_slug != 0) {
                $slug = $slug . "-" . $key_slug;
            }
        }
        $this->key_slug = 0;
        return $slug;
    }

    public function get_select_tree($arg, $id, $colum, $colum_get, $return = null, $value_show, $itemActive = array(), $space = "", $i = 0, $id_list = "category") {
        
        if ($id != 0) {
            $space .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            $i++;
        }
        if ($return == null || $return == "table_tree") {
            $this->table_tree .= '<ul class="list no-list-style box-select" data-id ="' . $id . '" id ="' . $id_list . '">';
        }
        foreach ($arg as $key => $value) {
            if ($value[$colum] == $id) {
                $activer = "";
                if (count($itemActive) > 0) {
                    foreach ($itemActive as $key_Activer => $valueActiver) {
                        if ($value[$value_show] == $valueActiver[$value_show]) {
                            if($return == "table_tree_select"){
                                $activer = "selected";
                            }else{
                                $activer = "checked";
                            }
                            unset($itemActive[$key_Activer]);
                        }
                    }
                }
                if ($return == null || $return == "table_tree") {
                    $this->table_tree.='<li data-slug ="' . $value["Slug"] . '">';
                    $this->table_tree.='<div class="checkbox"><input type="checkbox" class="custom" id="category-' . $value["Slug"] . '-' . $value["ID"] . '" value="' . $value[$value_show] . '" name="category[]" ' . $activer . '><label for="category-' . $value["Slug"] . '-' . $value["ID"] . '"><span>' . $value[$colum_get] . '<span></label></div>';
                }
                if ($return == null || $return == "table_tree_select") { 
                    $this->table_tree_select.='<option class="level-' . $i . '" data-space="' . $i . '" value="' . $value[$value_show] . '" '.$activer.'>' . $space . $value[$colum_get] . '</option>';
                }
                unset($arg[$key]);
                $this->get_select_tree($arg, $value["ID"], $colum, $colum_get, $return, $value_show, $itemActive, $space, $i, "parent");
                if ($return == null || $return == "table_tree") {
                    $this->table_tree.='</li>';
                }
            }
        }
        $this->table_tree .= '</ul>';
        $space = "";
        $i = 0;
        if ($return == null) {
            $this->all_record_category['table_tree'] = $this->table_tree;
            $this->all_record_category['table_tree_select'] = $this->table_tree_select;
        } else if ($return == "table_tree") {
            $this->all_record_category['table_tree'] = $this->table_tree;
        } else if ($return == "table_tree_select") {
            $this->all_record_category['table_tree_select'] = $this->table_tree_select;
        }
        return $this->all_record_category;
    }

    function get_id_tree($arg, $id, $colum_get, $colum_set) {
        $id_all = [];
        foreach ($arg as $key => $value) {
            if ($id == $value[$colum_set]) {
                $id_all[] = $value[$colum_get];
                unset($arg[$key]);
                $this->get_id_tree($arg, $value[$colum_get], $colum_get, $colum_set);
            }
        }
        $this->id_tree = $id_all;
        return $this->id_tree;
    }

}
