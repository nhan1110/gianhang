<?php

/*
  Created on : Feb 17, 2016, 7:00:18 PM
  Author     : phanquanghiep
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attributes extends CI_Controller {
    private $is_login = false;
    private $user_info = array();
    private $user_id = 0;
    private $data = array();
    private $type_member = "Member";
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
    public function index() {
        $this->data["title_curent"] = "Add new attribute";
        if ($this->input->get("category-type")) {
            $cat_type = $this->input->get("category-type");
            $ojb_cat_type = new Category_Type();
            $check_cat_type = $ojb_cat_type->where("Slug", $cat_type)->get_raw()->row_array();
            if (count($check_cat_type) > 0) {
                $table = $ojb_cat_type->get_raw()->result_array();
                $data_id_cat_type = $check_cat_type["ID"];
                $this->load->library('Helperclass');
                $attribute = new Attribute();
                $attribute_group = new Attribute_Group();
                $attribute_group_attribute = new Attribute_Group_Attribute();
                $arg_gr_attr = $attribute_group_attribute->get_attr_group_attr($this->user_id, $data_id_cat_type, $this->type_member);
                $all_grp = $attribute_group->get_by_member($data_id_cat_type, $this->user_id, $this->type_member);
                $all_attr = $attribute->get_attribute_by_cat($data_id_cat_type,$this->user_id,$this->type_member);
                $sort_get_gr = "";
                $sort_get_attr_parent = "";
                $element = "";
                $tree_attr = "<ul id = 'tree_attr' class='list-group droptrue level-0' data-level = '0'>";
                foreach ($all_grp as $key => $value) {
                    $sort_get_gr.= $value["ID"] . ",";
                    $tree_attr.="<li class='item ui-state-default' data-id = '" . $value["ID"] . "' data-slug ='" . $value["Slug"] . "' data-sort = '" . $value["Sort"] . "'>";
                    $tree_attr.="<div class='list-group-item'><span id='name-attribute'>" . $value["Name"] . "</span> (Category type " . $value["Ct_Name"] . ").";
                    $tree_attr.='<div class="actions">';
                    if ($this->type_member == "System") {
                        $tree_attr.="<select id='change-type' data-type = 'attribute-group'  data-id ='" . $value["ID"] . "'>";
                        if ($value["Type"] == "System") {
                            $tree_attr.="<option value = 'System' selected>System</option><option value = 'Member'>Member</option>";
                        } else {
                            $tree_attr.="<option value = 'System'>System</option><option value = 'Member' selected>Member</option>";
                        }
                        $tree_attr.=" </select>";
                    }

                    $tree_attr.='<a href="#" id="action-edit" data-type ="attribute-group"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                                <a href="#" id="action-delete" data-type ="attribute-group"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                    $type_parent = array("select", "multipleselect", "multipleradio");
                    $tree_attr.='<a href="#" id="action-add" data-type ="attribute-group" data-categorytype = "' . $value['Ct_Slug'] . '"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
                    $tree_attr.='</div>';
                    $tree_attr.="<div class='more close'><i class='fa fa-caret-right'></i></div>";
                    $tree_attr.="</div>";
                    $tree_attr .= "<ul class='list-group droptrue level-1' data-level = '1'>";
                    foreach ($arg_gr_attr as $key_1 => $value_1) {
                        if ($value_1["Group_ID"] == $value["ID"]) {
                            $sort_get_attr_parent .= $value_1["AGA_ID"] . ",";
                            $element.= $value_1["ID"] . ",";
                            $tree_attr.="<li class='item ui-state-default' data-attrid ='" . $value_1["ID"] . "' data-id = '" . $value_1["AGA_ID"] . "' data-slug ='" . $value_1["Slug"] . "' data-sort = '" . $value_1["Sort"] . "'>";
                            $tree_attr.="<div class='list-group-item'><span id='name-attribute'>" . $value_1["Name"] . "</span>";
                            $tree_attr.='<div class="actions">';
                            if ($this->type_member == "System") {
                                $tree_attr.="<select data-type ='attribute' id='change-type' data-id ='" . $value_1["ID"] . "'>";
                                if ($value_1["Type"] == "System") {
                                    $tree_attr.="<option value = 'System' selected>System</option><option value = 'Member'>Member</option>";
                                } else {
                                    $tree_attr.="<option value = 'System'>System</option><option value = 'Member' selected>Member</option>";
                                }
                                $tree_attr.=" </select>";
                            }
                            $tree_attr.='<a href="#" id="action-edit" data-type ="attribute-group-attribute"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                            <a href="#" id="action-delete" data-type ="attribute-group-attribute"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                            $type_parent = array("select", "multipleselect", "multipleradio");
                            if (in_array($value_1["Value"], $type_parent)) {
                                $tree_attr.='<a href="#" id="action-add" data-type ="attribute-group-attribute" data-categorytype = "' . $value['Ct_Slug'] . '"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
                            }
                            $tree_attr.='</div>';
                            $tree_attr.="</div>";
                            if (in_array($value_1["Value"], $type_parent)) {
                                $tree_attr.="<ul class='list-group dropfalse level-2' data-level = '2'>";
                                $sort_get_parent = "";
                                foreach ($all_attr as $key_2 => $value_2) {
                                    if ($value_2["Parent_ID"] == $value_1["ID"]) {
                                        $sort_get_parent .= $value_2["ID"] . ",";
                                        $tree_attr.="<li  class='ui-state-default' data-id = '" . $value_2["ID"] . "' data-slug ='" . $value_2["Slug"] . "' data-sort = '" . $value_2["Sort"] . "'>";
                                        $tree_attr.="<div class='list-group-item'><span id='name-attribute'>" . $value_2["Name"] . "</span>";
                                        $tree_attr.='<div class="actions">';
                                        if ($this->type_member == "System") {
                                            $tree_attr.="<select data-type ='attribute' id='change-type' data-id ='" . $value_1["ID"] . "'>";
                                            if ($value_1["Type"] == "System") {
                                                $tree_attr.="<option value = 'System' selected>System</option><option value = 'Member'>Member</option>";
                                            } else {
                                                $tree_attr.="<option value = 'System'>System</option><option value = 'Member' selected>Member</option>";
                                            }
                                            $tree_attr.=" </select>";
                                        }
                                        $tree_attr.='<a href="#" id="action-edit" data-type ="attribute"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> 
                                            <a href="#" id="action-delete" data-type ="attribute"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>     
                                        </div>';
                                        $tree_attr.="</div>";
                                        $tree_attr.="</li>";
                                        unset($all_attr[$key_2]);
                                    }
                                }
                                $tree_attr.="<input type='hidden' id='sort_get' value='" . $sort_get_parent . "' data-type='attribute'>";
                                $tree_attr.="</ul>";
                            }
                            $tree_attr.="</li>";
                            unset($arg_gr_attr[$key_1]);
                        }
                    }
                    $tree_attr.="<input type='hidden' id='sort_get' value='" . $sort_get_attr_parent . "' data-type='attribute-group-attribute'>";
                    $tree_attr.="<input type='hidden' id='element_attr' value='" . $element . "' data-type='attribute-group-attribute'>";
                    $tree_attr .= "</ul>";
                    $tree_attr.="</li>";
                    $sort_get_attr_parent = "";
                    $element = "";
                }
                $tree_attr.="<input type='hidden' id='sort_get' value='" . $sort_get_gr . "' data-type='attribute-group'>";
                $tree_attr .= "</ul>";
                $this->data["tree_attr"] = $tree_attr;
                $this->data["load_view"] = "add";
            } else {
                redirect(base_url("admin/attributes"));
            }
            $this->data["cat_type"] = $cat_type;
            $this->load->view('backend/include/header');
            $this->load->view('backend/attribute/index', $this->data);
            $this->load->view('backend/include/footer');
        } else {
            $this->data["title_curent"] = "Attributes";
            $category_Type = new Category_Type();
            $table = $category_Type->get_raw()->result_array();
            $this->load->library('Helperclass');
            $table_tree = $this->helperclass->get_select_tree($table, 0, "Parent_ID", "Name", "table_tree_select", "Slug");
            $this->data["all_cat_type"] = $table_tree["table_tree_select"];
            $this->load->view('backend/include/header');
            $this->load->view('backend/products/before', $this->data);
            $this->load->view('backend/include/footer');
        }
    }

    public function add() {
        check_ajax();
        $data_category = $this->input->post("data_category");
        $name = trim($this->input->post("name"));
        $type = ($this->input->post("type") != "0") ? $this->input->post("type") : "text";
        $arg_type = array('text', 'textarea', 'checkbox', 'select', 'number', 'option', 'radio', 'multipleselect', 'multipleradio', 'textarea', 'date', 'thumb', 'gallery', 'content', 'category');
        $ojb_cat_type = new Category_Type();
        $check_cat_type = $ojb_cat_type->where("Slug", $data_category)->get_raw()->row_array();
        $data["success"] = "error";
        $data["messenger"] = "";
        $data["response"] = [];
        $data["response"]["arg_parents"] = [];
        $data["response"]["attribute"] = [];
        $data["type_member"] = $this->type_member;
        if (count($check_cat_type) > 0 && $name != "" && in_array($type, $arg_type)) {
            $this->load->library('Helperclass');
            $slug = $this->helperclass->slug("Attribute", "slug", $name);
            $data_id_cat_type = $check_cat_type["ID"];
            $data_group = $this->input->post("data_group");
            $default_values = $this->input->post("default_values");
            $multivalue = $this->input->post("multivalue");
            $parent = $this->input->post("parent");
            $required = $this->input->post("required") ? $this->input->post("required") : "0";
            $validate = $this->input->post("validate");
            $attribute = new Attribute();
            $path = "/" . $slug . "/";
            if (is_numeric($parent) && $parent > 0) {
                $record_path = $this->Common_model->get_record("Attribute", array('ID' => $parent));
                $path = $record_path["Path"] . $slug . "/";
            }
            $get_sort = $attribute->where("Parent_ID", $parent)->order_by("Sort", "DESC")->get_raw()->row_array();
            if (is_array($get_sort) && count($get_sort) > 0) {
                $get_sort = $get_sort["Sort"] + 1;
            } else {
                $get_sort = 0;
            }
            $attribute_id = 0;
            $datime = date('Y-m-d H:i:s');
            $attribute->Name = $name;
            $attribute->Category_Type_ID = $data_id_cat_type;
            $attribute->Member_ID = $this->user_id;
            $attribute->Slug = $slug;
            $attribute->Parent_ID = $parent;
            $attribute->Path = $path;
            $attribute->Value = $type;
            $attribute->Type = $this->type_member;
            $attribute->Require = $required;
            $attribute->Validate = $validate;
            $attribute->Sort = $get_sort;
            $attribute->Createat = $datime;
            $attribute->Disable = "0";
            $attribute->save();
            $attribute_id = $attribute->db->insert_id();
            $attribute_group = new Attribute_Group();
            $check_attribute_group = $attribute_group->where("Slug", $data_group)->get_raw()->row_array();
            $data["response"]["attribute"] = [
                "Name" => $name,
                "Slug" => $slug,
                "Parent_ID" => $parent,
                "Sort" => $get_sort,
                "Value" => $type,
                "ID" => $attribute_id,
                "Group" => $check_attribute_group["ID"],
                "Type" => $this->type_member,
            ];
            $type_parent = array("select", "multipleselect", "multipleradio");
            if ($default_values != "") {
	        	$arg_default_values = explode("[*_*]", $default_values);
	        } elseif ($multivalue != "") {
	        	$arg_default_values = explode(PHP_EOL, trim($multivalue));
	        }
            $arg_default_values = array_diff($arg_default_values, array(''));
            $arg_default_values = array_unique($arg_default_values);
            if ($attribute_id !== 0) {
                if ($parent == 0 && $check_attribute_group != null) {
                    $attribute_group_attribute = new Attribute_Group_Attribute();
                    $max_sort = $attribute_group_attribute->where("Group_ID", $check_attribute_group["ID"])->get_raw()->row_array();
                    if ($max_sort == null) {
                        $max_sort = 0;
                    } else {
                        $max_sort = $max_sort["Sort"] + 1;
                    }
                    $attribute_group_attribute->Attribute_ID = $attribute_id;
                    $attribute_group_attribute->Group_ID = $check_attribute_group["ID"];
                    $attribute_group_attribute->Sort = $max_sort;
                    $attribute_group_attribute->save();
                    $id_group_attribute = $attribute_group_attribute->db->insert_id();
                    $data["response"]["attribute"]["Attribute_Group_Attribute"] = $id_group_attribute;
                    $data["response"]["attribute"]["Group"] = $check_attribute_group["ID"];
                }
                if (in_array($type, $type_parent) && count($arg_default_values) > 0 && $parent == 0) {
                    $arg_parents = [];
                    switch ($type) {
                        case "select":
                            $type_new = "option";
                            break;
                        case "multipleradio":
                            $type_new = "radio";
                            break;
                        case "multipleselect":
                            $type_new = "checkbox";
                    }
                    $i = 0;
                    foreach ($arg_default_values as $key => $value) {
                        $datime = date('Y-m-d H:i:s');
                        $slug_parent = $this->helperclass->slug("Attribute", "slug", trim($value));
                        $attribute->Name = $value;
                        $attribute->Category_Type_ID  = $data_id_cat_type;
                        $attribute->Member_ID = $this->user_id;
                        $attribute->Slug = $slug_parent;
                        $attribute->Parent_ID = $attribute_id;
                        $attribute->Path = $path . $slug_parent . "/";
                        $attribute->Value = $type_new;
                        $attribute->Type = $this->type_member;
                        $attribute->Createat = $datime;
                        $attribute->Disable = "0";
                        $attribute->Sort = $i;
                        $attribute->save();
                        $parents_attribute_id = $attribute->db->insert_id();
                        $arg_parents[] = [
                            "Name" => $value,
                            "Slug" => $slug_parent,
                            "Parent_ID" => $attribute_id,
                            "ID" => $parents_attribute_id,
                            "Sort" => $i,
                            "Type" => $this->type_member
                        ];
                        $i ++;
                    }
                    $data["response"]["arg_parents"] = $arg_parents;
                }
            }
            $data["success"] = "success";
        }
        die(json_encode($data));
    }

    public function updatesort($type = null) {
        check_ajax();
        $data["success"] = "error";
        $data_sort = $this->input->post("sort");
        $type_parent = array("attribute-group", "attribute-group-attribute", "attribute","cactegory-type");
        if ($data_sort != "" && $type != null && in_array($type, $type_parent)) {
            $masterclass = [];
            switch ($type) {
                case "attribute-group" :
                    $masterclass = new Attribute_Group();
                    break;
                case "attribute-group-attribute":
                    $masterclass = new Attribute_Group_Attribute();
                    break;
                case "cactegory-type":
                    $masterclass = new Category_type();
                    break;
                default:
                    $masterclass = new Attribute();
                    break;
            }
            $data_sort = explode(",", $data_sort);
            $data_sort = array_diff($data_sort, array(''));
            $i = 0;
            if (count($data_sort) > 0) {
                foreach ($data_sort as $key => $value) {
                    if (is_numeric($value)) {
                        $masterclass->where("ID", $value)->update('Sort', $i);
                        $i++;
                    }
                }
                $data["success"] = "success";
            }
        }
        die(json_encode($data));
    }

    public function add_group() {
        check_ajax();
        $data["success"] = "error";
        $data_name = trim($this->input->post("name"));
        $data_category = trim($this->input->post("category_type"));
        $category_type = new Category_Type();
        $check_cat_type = $category_type->where("Slug", $data_category)->get_raw()->row_array();
        if ($data_name != "" && count($check_cat_type) > 0) {
            $attribute_group = new Attribute_Group();
            $category_type_id = $check_cat_type["ID"];
            $max_sort = $attribute_group->get_sort($category_type_id,$this->user_id,$this->type_member);
            if ($max_sort == null) {
                $max_sort = 0;
            } else {
                $max_sort = $max_sort["Sort"] + 1;
            }
            $this->load->library('Helperclass');
            $slug = $this->helperclass->slug("Attribute_Group", "slug", $data_name);
            $datime = date('Y-m-d H:i:s');
            $attribute_group->Name = $data_name;
            $attribute_group->Slug = $slug;
            $attribute_group->Member_ID = $this->user_id;
            $attribute_group->Type = $this->type_member;
            $attribute_group->Sort = $max_sort;
            $attribute_group->Createat = $datime;
            $attribute_group->save();
            $id = $attribute_group->db->insert_id();
            $data["response"] = array(
                "ID" => $id,
                "Name" => $data_name,
                "Slug" => $slug,
                "Sort" => $max_sort,
                "Type" => $this->type_member,
            );
            $agct = new Attribute_Group_Category_Type();
            $agct->Attribute_Group_ID = $id;
            $agct->Category_Type_ID = $category_type_id;
            $agct->Createat = date('Y-m-d H:i:s');
            $agct->save();
            $data["type_member"] = $this->type_member;
            $data["success"] = "success";
        }
        die(json_encode($data));
    }

    public function delete($type = null, $id = null) {
        check_ajax();
        $data["success"] = "error";
        $type_parent = array("attribute-group", "attribute-group-attribute", "attribute");
        if ($type != null && $id != null && is_numeric($id) && in_array($type, $type_parent)) {
            $masterclass = [];
            switch ($type) {
                case "attribute-group" :
                    $masterclass = "Attribute_Group";
                    break;
                case "attribute-group-attribute":
                    $masterclass = "Attribute_Group_Attribute";
                    $attribute = new Attribute();
                    $attribute_group_attribute = new Attribute_Group_Attribute();
                    $check = $attribute_group_attribute->where("ID", $id)->get_raw()->row_array();
                    if ($check != null) {
                        $this->db->delete("Attribute", array('ID' => $check["Attribute_ID"], "Member_ID" => $this->user_id));
                        $this->db->delete("Attribute", array('Parent_ID' => $check["Attribute_ID"],"Member_ID" => $this->user_id));
                    }
                    break;
                default:
                    $masterclass = "Attribute";
                    $this->db->delete("Attribute", array('Parent_ID' => $check["Attribute_ID"],"Member_ID" => $this->user_id));
                    break;
            }
            if ($this->type_member == "System" || $type == "attribute-group-attribute")
                $this->db->delete($masterclass, array('ID' => $id));
            else
                $this->db->delete($masterclass, array('ID' => $id, "Member_ID" => $this->user_id));
            $data["success"] = "success";
        }
        die(json_encode($data));
    }

    public function move() {
        check_ajax();
        $data["success"] = "error";
        $data_sort = $this->input->post("sort");
        $id_attribute = $this->input->post("id_attribute");
        $id_group = $this->input->post("id_group");
        $attribute_group_attribute = new Attribute_Group_Attribute();
        if ($id_attribute != "" && is_numeric($id_attribute) && $id_group != "" && is_numeric($id_group)) {
            $attribute_group_attribute->where("Attribute_ID", $id_attribute)->update('Group_ID', $id_group);
            $data_sort = explode(",", $data_sort);
            $data_sort = array_diff($data_sort, array(''));
            $i = 0;
            if (count($data_sort) > 0) {
                foreach ($data_sort as $key => $value) {
                    if (is_numeric($value)) {
                        $attribute_group_attribute->where("ID", $value)->update('Sort', $i);
                        $i++;
                    }
                }
            }
            $data["success"] = "success";
        }
        die(json_encode($data));
    }

    public function update_type($type = null) {
        check_ajax();
        $data["success"] = "error";
        $data_value = $this->input->post("value");
        $data_id = $this->input->post("id");
        $type_parent = array("attribute-group", "attribute");
        if (in_array($type, $type_parent)) {
            $type_parent = array("System", "Member");
            if ($data_id != "" && in_array($data_value, $type_parent)) {
                $masterclass = [];
                switch ($type) {
                    case "attribute-group" :
                        $masterclass = new Attribute_Group();
                        break;
                    default:
                        $masterclass = new Attribute();
                        break;
                }
                $masterclass->where("ID", $data_id)->update('Type', $data_value);
                $data["success"] = "success";
            }
        }
        die(json_encode($data));
    }

    public function add_child() {
        check_ajax();
        $data["success"] = "error";
        $data_category = $this->input->post("data_category");
        $data_parent = $this->input->post("parent");
        $data_default_values = $this->input->post("default_values");
        $multivalue = $this->input->post("multivalue");
        if ($data_default_values != "") {
        	$arg_default_values = explode("[*_*]", $data_default_values);
        } elseif ($multivalue != "") {
        	$arg_default_values = explode(PHP_EOL, trim($multivalue));
        }
        $arg_default_values = array_diff($arg_default_values, array(''));
        if ($arg_default_values != null) {
            $ojb_cat_type = new Category_Type();
            $attribute = new Attribute();
            $check_cat_type = $ojb_cat_type->where("Slug", $data_category)->get_raw()->row_array();
            $check_attribute_parent = $attribute->where(array("ID" => $data_parent, "Parent_ID" => 0))->get_raw()->row_array();
            if ($ojb_cat_type != null && $check_attribute_parent != null) {
                $data_id_cat_type = $check_cat_type["ID"];
                $attribute_id = $check_attribute_parent["ID"];
                $type = $check_attribute_parent["Value"];
                $type_new = "";
                switch ($type) {
                    case "select":
                        $type_new = "option";
                        break;
                    case "multipleradio":
                        $type_new = "radio";
                        break;
                    case "multipleselect":
                        $type_new = "checkbox";
                }
                $max_sort = $attribute->where("Parent_ID", $data_parent)->order_by("Sort", "DESC")->get_raw()->row_array();
                $i = isset($max_sort["Sort"]) ? $max_sort["Sort"] : 0;
                $this->load->library('Helperclass');
                foreach ($arg_default_values as $key => $value) {
                    $datime = date('Y-m-d H:i:s');
                    $slug_parent = $this->helperclass->slug("Attribute", "slug", trim($value));
                    $attribute->Name = $value;
                    $attribute->Type_ID = $data_id_cat_type;
                    $attribute->Member_ID = $this->user_id;
                    $attribute->Slug = $slug_parent;
                    $attribute->Parent_ID = $attribute_id;
                    $attribute->Path = $check_attribute_parent["Path"] . $slug_parent . "/";
                    $attribute->Value = $type_new;
                    $attribute->Type = $this->type_member;
                    $attribute->Createat = $datime;
                    $attribute->Disable = "0";
                    $attribute->Sort = $i;
                    $attribute->save();
                    $parents_attribute_id = $attribute->db->insert_id();
                    $arg_parents[] = [
                        "Name" => $value,
                        "Slug" => $slug_parent,
                        "Parent_ID" => $attribute_id,
                        "ID" => $parents_attribute_id,
                        "Sort" => $i,
                        "Type" => $this->type_member
                    ];
                    $i ++;
                }
                $data["response"]["arg_parents"] = $arg_parents;
                $data["type_member"] = $this->type_member;
                $data["success"] = "success";
            }
        }
        die(json_encode($data));
    }

    public function change_name() {
        check_ajax();
        $data["success"] = "error";
        $type = $this->input->post("type");
        $type_parent = array("attribute-group", "attribute", "attribute-group-attribute");
        if (in_array($type, $type_parent)) {
            $data_id = $this->input->post("id");
            $name = trim($this->input->post("new_name"));
            $type_parent = array("System", "Member");
            if (is_numeric($data_id) && $name != "") {
                $table = "";
                $masterclass = [];
                switch ($type) {
                    case "attribute-group" :
                        $table = "Attribute_Group";
                        $masterclass = new Attribute_Group();
                        break;
                    default:
                        $table = "Attribute";
                        $masterclass = new Attribute();
                        break;
                }
                $this->load->library('Helperclass');
                $slug = $this->helperclass->slug("Attribute", "slug", $name);
                $path = "/" . $slug . "/";
                if ($this->type_member == "System") {
                    $check = $masterclass->where("ID", $data_id)->get_raw()->row_array();
                } else {
                    $check = $masterclass->where(array("ID" => $data_id, "Member_ID" => $this->user_id))->get_raw()->row_array();
                }
                if ($check != null) {

                    if ($table == "Attribute") {
                        $masterclass->where("ID", $data_id)->update(array('Name' => $name, 'Slug' => $slug, "Path" => $path));
                        $attribute = new Attribute();
                        $attribute->replace_slug($table, $check["Path"], $path, $check["ID"]);
                    } else {
                        $masterclass->where("ID", $data_id)->update(array('Name' => $name, 'Slug' => $slug));
                    }
                    $data["success"] = "success";
                }
            }
        }
        die(json_encode($data));
    }

}
