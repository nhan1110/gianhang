<?php

/*
  Created on : Feb 15, 2016, 7:00:18 PM
  Author     : phanquanghiep
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends MY_Controller {

    private $user_id = 0;
    private $data = [];
    private $type_member = "System";

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->data["page_product"] = "index";
        $this->data["title_curent"] = "Product";
        $p = new Products();
        $keyword = $cat = null;
        $string = "";
        $page_current = 0;
        $per_page = 30;
        if($this->input->get()){
        	$cat = ($this->input->get("category-type") != "") ? $this->input->get("category-type") :null ;
        	$keyword = ($this->input->get("product-name") != "") ? $this->input->get("product-name") : null;
        	$page_current = ($this->input->get("per_page") != "") ? $this->input->get("per_page") : 0 ;    
        	$page_current = ($page_current > 0) ? ($page_current - 1) : $page_current;
        }
        $offset = $per_page * $page_current;
        $full_product = $p->get_index($this->user_id,$this->type_member,$cat,$keyword);
        $this->data["product_record"] = $p->get_index($this->user_id, $this->type_member,$cat,$keyword,$offset,$per_page);
        $category_Type = new Category_Type();
        $table = $category_Type->get_raw()->result_array();
        $this->load->library('Helperclass');
        $table_tree = $this->helperclass->get_select_tree($table, 0, "Parent_ID", "Name", "table_tree_select", "Slug", [array("Slug" => $cat)]);
        $this->data["all_cat_type"] = $table_tree["table_tree_select"];
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/product/?category-type='.@$cat.'&product-name='.@$keyword);
        $config['total_rows'] = count($full_product);
        $config['per_page'] = $per_page; 
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['prev_link'] = '&larr; Previous';
        $config['first_link'] = '<< First';
        $config['last_link'] = 'Last >>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['enable_query_strings']  = true;
        $config['page_query_string']  = true;
        $config['query_string_segment'] = "per_page";
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config); 
        $this->load->view('backend/include/header');
        $this->load->view('backend/products/index', $this->data);
        $this->load->view('backend/include/footer');
    }
    public function add() {
        $user_id = $this->user_id;
        $member = new Member();
        $member->where('ID', $user_id)->get(1);
        $data['member'] = $member;
        $this->data["action"] =" add new";
        $this->data["title"] = "My product";
        $this->data["wrapper"] = $data;
        $this->data["page_product"] = "add";
        $this->load->helper('cookie');
        $this->data ["text_button"] = " Thêm mới";
        $this->data["title_curent"] = "Add New Product";
        if ($this->input->post()) {
            $required = array("name", "type_price", "featured");
            $number = array();
            $datime = array();
            $check = $this->valid_product($this->input->post(), $required, $number, $datime);
            $category_type_id = $this->input->post("category_type");
            $category_type = new Category_Type();
            $check_type = $category_type->where("ID", $category_type_id)->get_raw()->row_array();
            $category = $this->input->post("category");
            $address = $this->input->post("address");
            $tags = $this->input->post("tags");
            $id_address = "";
            if ($check["check"] == true && $category != false && count($category) > 0 && is_array($check_type) && count($check_type) > 0) {
                $datime = date('Y-m-d H:i:s');
                $general = $this->input->post("general");
                $price = $this->input->post("price");
                $media = $this->input->post("media");
                $attribute = $this->input->post("attribute");
                $this->load->library('Helperclass');
                $slug = $this->helperclass->slug("Products", "slug", trim($general["name"]));
                $address_path = $address["city"];
                if (isset($address["districts"]) && $address["districts"] != "" && $address["districts"] != "{[-]}") {
                    $address_path = $address["districts"];
                }
                if (isset($address["wards"]) && $address["wards"] != "" && $address["wards"] != "{[-]}") {
                    $address_path = $address["wards"];
                }
                $country = new Country();
                $cmtk = new Common_Tracking();
                if (trim($address_path) != "{[-]}") {
                    $arg_country = $country->where("ID", $address_path)->get_raw()->row_array();
                    if ($arg_country != null) {
                        $address_path = $arg_country["Path"];
                        $arg_slug_country = explode("/", $address_path);
                        $arg_slug_country = array_diff($arg_slug_country, array(''));
                        $id_country = $country->where_in("Slug", $arg_slug_country)->get_raw()->result_array();
                        $country_tk = [];
                        if($id_country != null){
                            foreach ($id_country as $key => $value) {
                                $country_tk [] = $value["ID"];
                                $check_order = $cmtk->where(
                                    [
                                        "Reference_ID" => $value["ID"],
                                        "Type_ID" => $check_type["ID"],
                                        "Type" => "country"
                                    ]
                                )->get_raw()->row_array();
                                if($check_order == null){
                                    $cmtk->Reference_ID = $value["ID"];
                                    $cmtk->Type_ID = $check_type["ID"];
                                    $cmtk->Type = "country";
                                    $cmtk->Order = 0;
                                    $cmtk->save();
                                }
                                $check_order = $cmtk->where(
                                    [
                                        "Reference_ID" => $value["ID"],
                                        "Type_ID" => $check_type["Parent_ID"],
                                        "Type" => "country"
                                    ]
                                )->get_raw()->row_array();
                                if($check_order == null){
                                    $cmtk->Reference_ID = $value["ID"];
                                    $cmtk->Type_ID = $check_type["Parent_ID"];
                                    $cmtk->Type = "country";
                                    $cmtk->Order = 0;
                                    $cmtk->save();
                                }
                                $check_order = $cmtk->where(
                                    [
                                        "Reference_ID" => $value["ID"],
                                        "Type_ID" => 0,
                                        "Type" => "country"
                                    ]
                                )->get_raw()->row_array();
                                if($check_order == null){
                                    $cmtk->Reference_ID = $value["ID"];
                                    $cmtk->Type_ID = 0;
                                    $cmtk->Type = "country";
                                    $cmtk->Order = 0;
                                    $cmtk->save();
                                }
                            }
                        }
                        $data_id = $arg_country["ID"];
                        if (isset($address["districts_new"]) && $address["districts_new"] != "") {
                            $slug_districts = $this->helperclass->slug("Country", "slug", $address["districts_new"]);
                            $address_path = $address_path . $slug_districts . "/";
                            $country->Name = $address["districts_new"];
                            $country->Slug = $slug_districts;
                            $country->Path = $address_path;
                            $country->Parent_ID = $data_id;
                            $country->Levels = "";
                            $country->Level = 1;
                            $country->Disable = 0;
                            $country->Member_ID = $this->user_id;
                            $country->Type = "Member";
                            $country->save();
                            $data_id = $country->db->insert_id();
                            $country_tk [] = $data_id;
                        }
                        if (isset($address["wards_new"]) && $address["wards_new"] != "") {
                            $slug_districts = $this->helperclass->slug("Country", "slug", $address["wards_new"]);
                            $address_path = $address_path . $slug_districts . "/";
                            $country->Name = $address["wards_new"];
                            $country->Slug = $slug_districts;
                            $country->Path = $address_path;
                            $country->Parent_ID = $data_id;
                            $country->Levels = "";
                            $country->Level = 2;
                            $country->Disable = 0;
                            $country->Member_ID = $this->user_id;
                            $country->Type = "Member";
                            $country->save();
                            $data_id = $country->db->insert_id();
                            $country_tk [] = $data_id;
                        }
                        if($country_tk != null){
                            $cmtk->update_order($check_type["ID"],$country_tk,"country");
                            $cmtk->update_order($check_type["Parent_ID"],$country_tk,"country");
                            $cmtk->update_order(0,$country_tk,"country");
                        }
                    }
                }
                $featured = explode(",", $media["featured"]);
                if (isset($featured[0]) && is_numeric($featured[0]))
                    $featured = $featured[0];
                else
                    $featured = "";
                $p = new Products();
                $p->Type_ID = $check_type["ID"];
                $p->Name = trim($general["name"]);
                $p->Slug = $slug;
                $p->Description = trim($general["description"]);
                $p->Content = $general["content"];
                $p->Featured_Image = $featured;
                $p->Createdat = $datime;
                $p->Updatedat = $datime;
                $p->Member_ID = $this->user_id;
                $p->Disable = 1;
                $p->Path_Adderss = $address_path;
                $p->save();
                $product_id = $p->db->insert_id();
                if ($product_id != 0) {
                    if (isset($address["save"])) {
                        delete_cookie("product_address");
                        $cookie_address = array(
                            'name' => 'product_address',
                            'value' => $address_path,
                            'expire' => time() + 86500,
                        );
                        $this->input->set_cookie($cookie_address);
                    }
                    if (is_array($tags) && $tags != null) {
                        $k = new Keywords();
                        foreach ($tags as $key => $value) {
                            $check_keyword = $k->where("Name",trim($value))->get_raw()->row_array();
                            $id_k = null;
                            if ($check_keyword == null) {
                                $slug_k = $this->helperclass->slug("Keywords", "slug", $value);
                                $k->Member_ID = $this->user_id;
                                $k->Name = $value;
                                $k->Slug = $slug_k;
                                $k->Type = $this->type_member;
                                $k->Created_at = $datime;
                                $k->Type_ID = $check_type["ID"];
                                $k->Order = 1;
                                $k->save();
                                $id_k = $k->db->insert_id();
                            } else {
                                $id_k = $check_keyword["ID"];
                                $k->update_order(array($id_k),1);
                            }
                            if ($id_k !== null) {
                                $kp = new Product_Keyword();
                                $kp->Product_ID = $product_id;
                                $kp->Keyword_ID = $id_k;
                                $kp->save();
                            }
                        }
                    }
                    if (isset($category) && is_array($category) && count($category) > 0) {
                        $product_categories = new Product_Category();
                        $tem_id [] = -1;
                        foreach ($category as $key => $value) {
                            if (is_numeric($value)) {
                                $tem_id [] = $value;
                                $product_categories->Product_ID = $product_id;
                                $product_categories->Term_ID = $value;
                                $product_categories->save();
                            }
                        }
                        $ct = new Categories();
                        $all_category = $ct->where_in("ID",$tem_id)->get_raw()->result_array();
                        $slug_tems = $this->add_category($all_category);
                        $all_category = $ct->where_in("Slug",$slug_tems)->get_raw()->result_array();
                        foreach ($all_category as $key => $value_cat) {
                        	$order_key[] = $value_cat["ID"];
                        	$check_order = $cmtk->where(
                                [
                                    "Reference_ID" => $value_cat["ID"],
                                    "Type_ID" => $check_type["ID"],
                                    "Type" => "category"
                                ]
                            )->get_raw()->row_array();
                            if($check_order == null){
                                $cmtk->Reference_ID = $value_cat["ID"];
                                $cmtk->Type_ID = $check_type["ID"];
                                $cmtk->Type = "category";
                                $cmtk->Order = 0;
                                $cmtk->save();
                            }
                            $check_order = $cmtk->where(
                                [
                                    "Reference_ID" => $value_cat["ID"],
                                    "Type_ID" => $check_type["Parent_ID"],
                                    "Type" => "category"
                                ]
                            )->get_raw()->row_array();
                            if($check_order == null){
                                $cmtk->Reference_ID = $value_cat["ID"];
                                $cmtk->Type_ID = $check_type["Parent_ID"];
                                $cmtk->Type = "category";
                                $cmtk->Order = 0;
                                $cmtk->save();
                            }
                        }
                        if($order_key != null){
                        	$cmtk->update_order($check_type["ID"],$order_key,"category");
                            $cmtk->update_order($check_type["Parent_ID"],$order_key,"category");
                        }
                       
                    }
                    if ($media["list_photos"] != "") {
                        $list_photos = explode(",", $media["list_photos"]);
                        $list_photos = array_diff($list_photos, array(''));
                        $list_photos = array_unique($list_photos);
                        $media_product = new Media_Product();
                        foreach ($list_photos as $key => $value) {
                            if (is_numeric($value)) {
                                $media_product->Media_ID = $value;
                                $media_product->Product_ID = $product_id;
                                $media_product->save();
                            }
                        }
                    }
                    $product_price = new Product_Price();
                    $product_price->Product_ID = $product_id;
                    $product_price->Price = @$price["price_product"];
                    $product_price->Special_Price = (isset($price["special_price"]) && is_numeric($price["special_price"]) ) ? $price["special_price"] : "";
                    $product_price->Special_Start = null;
                    $product_price->Special_End = null;
                    $product_price->Is_Main = $price["type_price"];
                    $product_price->Number_Price = str_replace(".","",@$price["price_product"]);
                    $product_price->save();
                    $a_update = new Attribute();
                    $a_value = new Attribute_Value();                    
                    if (is_array($attribute) && count($attribute) > 0) {
                    	$id_attr_update_order = [] ;
                    	foreach ($attribute as $key_attribute => $value_attribute) {
                    		$key_attr = explode("-", $key_attribute);
                    		if(count($key_attr) == 2){	
                    			$group_id = $key_attr[0];
                    			$attr_id = $key_attr[1];
                    			$value_set = "";
                    			if(count($value_attribute) == 1){
                    				$value_set = implode("",$value_attribute);
                    				$value_set = str_replace("{[-]}","",$value_set);
                    			}else if(count($value_attribute) > 1){
                    				// remove value {[-]}
                    				$value_attribute = array_diff($value_attribute, array("{[-]}"));
                    				//get attribute child.
                    				$attribute_child = $a_update->where_in("Name",$value_attribute)->where("Parent_ID",$attr_id)->get_raw()->result_array();
                    				if($attribute_child != null){
                    					foreach ($attribute_child as $key_attribute_child => $value_attribute_child) {
                    						$id_attr_update_order[] = $value_attribute_child["ID"];
                    					}
                    				}
                    				$value_set = implode("{[-]}",$value_attribute);
                                    if($value_set != ""){
                                        $value_set = "{[-]}".$value_set."{[-]}";
                                    }
                    			}
                    			if($value_set != ""){
                    				$id_attr_update_order[] = $attr_id;
                					$a_value->Product_ID = $product_id;
                					$a_value->Attribute_ID = $attr_id;
                					$a_value->Group_ID = $group_id;
                					$a_value->Value = $value_set;
                					$a_value->save();
                    			}
                    		}	
                    	}
                    	//update order attribute.
                    	if($id_attr_update_order != null){
                    		foreach ($id_attr_update_order as $key_update_order => $value_update_order) {
                    			$filter = array(
                    				"Reference_ID" => $value_update_order,
                    				"Type_ID" => $check_type["ID"],
                    				"Type"    => "attribute"
                    			);
                    			$check_order_att = $cmtk->where($filter)->get_raw()->row_array();
                    			if($check_order_att == null){
                    				$cmtk->Reference_ID = $value_update_order;
                    				$cmtk->Type_ID = $check_type["ID"];
                    				$cmtk->Type = "attribute";
                    				$cmtk->Order = 0;
                    				$cmtk->save();
                    			}
                                $filter = array(
                                    "Reference_ID" => $value_update_order,
                                    "Type_ID" => $check_type["Parent_ID"],
                                    "Type"    => "attribute"
                                );
                                $check_order_att = $cmtk->where($filter)->get_raw()->row_array();
                                if($check_order_att == null){
                                    $cmtk->Reference_ID = $value_update_order;
                                    $cmtk->Type_ID = $check_type["Parent_ID"];
                                    $cmtk->Type = "attribute";
                                    $cmtk->Order = 0;
                                    $cmtk->save();
                                }
                    		}
                    		$cmtk->update_order($check_type["ID"],$id_attr_update_order,"attribute",1);
                            $cmtk->update_order($check_type["Parent_ID"],$id_attr_update_order,"attribute",1);
                    	}
                    }
                    $p->where("ID", $product_id)->update(array("Disable" => 0));
                    redirect(base_url("admin/product"));
                }
            } else {
                if ($category == false) {
                    $check["key_error"][] = "categories";
                    $check["input_error"][] = "category";
                }
                $this->data["error"] = $check;
                $this->data["success"] = "error";
            }
        }
        if ($this->input->get("category-type")) {
            $cat_type = $this->input->get("category-type");
            $ojb_cat_type = new Category_Type();
            $check_cat_type = $ojb_cat_type->where("Slug", $cat_type)->get_raw()->row_array();
            if (count($check_cat_type) > 0) {
                $data_id_cat_type = $check_cat_type["ID"];
                $this->data["cat_type_id"] = $data_id_cat_type;
                $this->data["category_type_slug"] = $cat_type;
                $attribute_group = new Attribute_Group();
                $attribute_group_attribute = new Attribute_Group_Attribute();
                $attribute = new Attribute();
                $category = new Categories();
                $arg_new_attr = [];
                $attribute_arg = $attribute_group->get_attr_cat_type($data_id_cat_type, $this->user_id,$this->type_member);
                $this->data["attr_group"] = $attribute_arg;
                $arg_tabs = [];
                $attribute_parent_id [] = "*-*";
                $arg_gr = $attribute_group_attribute->get_attribute_group($this->user_id, $data_id_cat_type,$this->type_member);
                if (is_array($attribute_arg) && count($attribute_arg) > 0) {
                    foreach ($attribute_arg as $key => $attribute_group_value) {
                        if (is_array($arg_gr) && count($arg_gr) > 0) {
                            foreach ($arg_gr as $key => $arg_gr_value) {
                                if ($arg_gr_value["Group_ID"] == $attribute_group_value["ID"]) {
                                    $attribute_group_value["items"][] = $arg_gr_value;
                                }
                                $attribute_parent_id []= $arg_gr_value["Attribute_ID"] ;
                            }
                        }
                        $arg_tabs[] = $attribute_group_value;
                    }
                }
                $sql = "SELECT * FROM (`Categories`) WHERE (`Categories`.`Type_ID` = {$data_id_cat_type} OR (`Categories`.`Type_ID` = (SELECT `cc`.`Parent_ID` FROM Category_Type AS cc WHERE `cc`.`ID` = {$data_id_cat_type}) ) ) AND `Disable` = 0";
                $record_cat = $category->db->query($sql);
                $record_cat = $record_cat->result_array();
                if (count($record_cat) > 0) {
                    $this->load->library('Helperclass');
                    $select_html = $this->helperclass->get_select_tree($record_cat, 0, "Parent_ID", "Name", null, "ID");
                    $this->data["select_cat"] = $select_html['table_tree_select'];
                    $this->data["cat_tree"] = $select_html['table_tree'];
                }
                $filter = array(
                    "Parent_ID !=" => 0,
                    "Type_ID" => $data_id_cat_type
                );
                $this->input->cookie('product_address', TRUE);
                $product_address = get_cookie('product_address');
                if (isset($product_address) && $product_address != null) {
                    $path_adderss = explode("/", $product_address);
                    $path_adderss = array_diff($path_adderss, array(''));
                    $country = new Country();
                    $arg_country = $country->where_in("Slug", $path_adderss)->get_raw()->result_array();
                    $this->data["arg_country"] = $arg_country;
                    $this->data["city_activer"] = -1;
                    $this->data["districts_activer"] = -1;
                    $this->data["wards_activer"] = -1;
                    if (isset($arg_country) && is_array($arg_country)) {
                        foreach ($arg_country as $key => $value) {
                            if ($value["Level"] == 0) {
                                $this->data["city_activer"] = $value["ID"];
                                $this->data["districts_arg"] = $country->get_country($this->user_id, 1, $value["ID"],0);
                            }
                            if ($value["Level"] == 1) {
                                $this->data["districts_activer"] = $value["ID"];
                                $this->data["wards_arg"] = $country->get_country($this->user_id, 2, $value["ID"],0);
                            }
                            if ($value["Level"] == 2) {
                                $this->data["wards_activer"] = $value["ID"];
                            }
                        }
                    }
                }
                $attribute_owner = $attribute->where_in("Parent_ID",$attribute_parent_id)->get_raw()->result_array();
                $country = new Country();
                $this->data["city"] = $country->get_country($this->user_id, 0, 0,0);
                $this->data["arg_tabs"] = $arg_tabs;
                $this->data["attribute_owner"] = $attribute_owner;
                $this->data["view"] = "fontend/profile/products/add-edit";
                $this->load->view('backend/include/header');
                $this->load->view('backend/products/add-edit', $this->data);
                $this->load->view('backend/include/footer');

            } else {
                redirect(base_url("admin/product/add"));
            }
        } else {
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
    public function edit($slug = "") {
        $user_id = $this->user_id;
        $this->data["action"] =" edit";
        $member = new Member();
        $member->where('ID', $user_id)->get(1);
        $data['member'] = $member;
        $this->data["title"] = "My product";
        $this->data["wrapper"] = $data;
        $this->data["page_product"] = "edit";
        $this->data ["text_button"] = " Cập nhật";
        $this->data["title_curent"] = "Edit Product";
        if ($this->input->post()) {
            $slug_product = trim($this->input->post("product_slug"));
            //load model.
            $p = new Products();
            $k = new Keywords();
            $kp = new Product_Keyword();
            $category_type = new Category_Type();
            $country = new Country();
            $cmtk = new Common_Tracking();  
            $ct = new Categories();
            $product_categories = new Product_Category();
            $media_product = new Media_Product();
            $product_price = new Product_Price(); 
            $a_value = new Attribute_Value();
            $a_update = new Attribute();
            //!load model.
            $check_product = $p->where(array("Slug" => $slug_product))->get_raw()->row_array();
            if ($check_product != null) {
                $product_id = $check_product["ID"];
                $required = array("name", "type_price", "featured");
                $number = array();
                $datime = array();
                $check = $this->valid_product($this->input->post(), $required, $number, $datime);
                $category_type_id = $this->input->post("category_type");
                $check_type = $category_type->where("ID", $category_type_id)->get_raw()->row_array();
                $category = $this->input->post("category");
                $address = $this->input->post("address");
                $tags = $this->input->post("tags");
                $this->load->library('Helperclass');
                if ($check["check"] == true && $category != false && count($category) > 0 && is_array($check_type) && count($check_type) > 0) {
                    $datime = date('Y-m-d H:i:s');
                    $general = $this->input->post("general");
                    $price = $this->input->post("price");
                    $media = $this->input->post("media");
                    $attribute = $this->input->post("attribute");
                    $data_insert["Name"] = trim($general["name"]);
                    $address_path = $address["city"];
                    $all_k_p = $kp->where("Product_ID",$product_id)->get_raw()->result_array();
                    $all_k_p_id = [];
                    if($all_k_p != null){
                        foreach ($all_k_p as $key => $value_kw) {
                            $all_k_p_id [] = $value_kw["Keyword_ID"];
                        }
                    }
                    if($all_k_p_id != null){
                        $k->update_order($all_k_p_id,-1);
                    }
                    $this->db->delete("Product_Keyword", array("Product_ID" => $product_id));
                    if (is_array($tags) && $tags != null) {
                        foreach ($tags as $key => $value) {
                            $check_keyword = $k->where("Name",trim($value))->get_raw()->row_array();
                            $id_k = null;
                            if ($check_keyword == null) {
                                $slug_k = $this->helperclass->slug("Keywords", "slug", $value);
                                $k->Member_ID = $this->user_id;
                                $k->Name = $value;
                                $k->Slug = $slug_k;
                                $k->Type = $this->type_member;
                                $k->Created_at = $datime;
                                $k->Type_ID = $check_type["ID"];
                                $k->Order = 1;
                                $k->save();
                                $id_k = $k->db->insert_id();
                            } else {
                                $id_k = $check_keyword["ID"];
                                $k->update_order(array($id_k),1);
                            }
                            if ($id_k !== null) {                                
                                $kp->Product_ID = $product_id;
                                $kp->Keyword_ID = $id_k;
                                $kp->save();  
                            }
                        }
                    }
                    if (isset($address["districts"]) && $address["districts"] != "" && $address["districts"] != "{[-]}") {
                        $address_path = $address["districts"];
                    }
                    if (isset($address["wards"]) && $address["wards"] != "" && $address["wards"] != "{[-]}") {
                        $address_path = $address["wards"];
                    }
                    $path_country = $check_product["Path_Adderss"];
                    if($path_country != null){
                        $arg_slug_country = explode("/", $path_country);
                        $arg_slug_country = array_diff($arg_slug_country, array(''));
                        $id_country = $country->where_in("Slug", $arg_slug_country)->get_raw()->result_array();
                        $country_tk = null;
                        foreach ($id_country as $key => $value) {
                            $country_tk []= $value["ID"];
                        }
                        if($country_tk != null){
                            $cmtk->update_order($check_type["ID"],$country_tk,"country",-1);
                            $cmtk->update_order($check_type["Parent_ID"],$country_tk,"country",-1);
                            $cmtk->update_order(0,$country_tk,"country",-1);
                        }
                    }
                    if (trim($address_path) != "{[-]}") {
                        $country_tk = null ;
                        $arg_country = $country->where("ID", $address_path)->get_raw()->row_array();
                        if ($arg_country != null) {
                            $address_path = $arg_country["Path"];
                            if($address_path != null){
                                $arg_slug_country = explode("/", $address_path);
                                $arg_slug_country = array_diff($arg_slug_country, array(''));
                                $id_country = $country->where_in("Slug", $arg_slug_country)->get_raw()->result_array();
                                if($id_country != null){
                                    foreach ($id_country as $key => $value) {
                                        $country_tk [] = $value["ID"];
                                        $check_order = $cmtk->where(
                                            [
                                                "Reference_ID" => $value["ID"],
                                                "Type_ID" => $check_type["ID"],
                                                "Type" => "country"
                                            ]
                                        )->get_raw()->row_array();
                                        if($check_order == null){
                                            $cmtk->Reference_ID = $value["ID"];
                                            $cmtk->Type_ID = $check_type["ID"];
                                            $cmtk->Type = "country";
                                            $cmtk->Order = 0;
                                            $cmtk->save();
                                        }
                                        $check_order = $cmtk->where(
                                            [
                                                "Reference_ID" => $value["ID"],
                                                "Type_ID" => $check_type["Parent_ID"],
                                                "Type" => "country"
                                            ]
                                        )->get_raw()->row_array();
                                        if($check_order == null){
                                            $cmtk->Reference_ID = $value["ID"];
                                            $cmtk->Type_ID = $check_type["Parent_ID"];
                                            $cmtk->Type = "country";
                                            $cmtk->Order = 0;
                                            $cmtk->save();
                                        }
                                        $check_order = $cmtk->where(
                                            [
                                                "Reference_ID" => $value["ID"],
                                                "Type_ID" => 0,
                                                "Type" => "country"
                                            ]
                                        )->get_raw()->row_array();
                                        if($check_order == null){
                                            $cmtk->Reference_ID = $value["ID"];
                                            $cmtk->Type_ID = 0;
                                            $cmtk->Type = "country";
                                            $cmtk->Order = 0;
                                            $cmtk->save();
                                        }
                                    }
                                }
                            }
                            $data_id = $arg_country["ID"];
                            if (isset($address["districts_new"]) && $address["districts_new"] != "") {
                                $slug_districts = $this->helperclass->slug("Country", "slug", $address["districts_new"]);
                                $address_path = $address_path . $slug_districts . "/";
                                $country->Name = $address["districts_new"];
                                $country->Slug = $slug_districts;
                                $country->Path = $address_path;
                                $country->Parent_ID = $data_id;
                                $country->Levels = "";
                                $country->Level = 1;
                                $country->Disable = 0;
                                $country->Order = 1;
                                $country->Member_ID = $this->user_id;
                                $country->Type = "Member";
                                $country->save();
                                $data_id = $country->db->insert_id();
                                $country_tk [] = $data_id;
                            }
                            if (isset($address["wards_new"]) && $address["wards_new"] != "") {
                                $slug_districts = $this->helperclass->slug("Country", "slug", $address["wards_new"]);
                                $address_path = $address_path . $slug_districts . "/";
                                $country->Name = $address["wards_new"];
                                $country->Slug = $slug_districts;
                                $country->Path = $address_path;
                                $country->Parent_ID = $data_id;
                                $country->Levels = "";
                                $country->Level = 2;
                                $country->Disable = 0;
                                $country->Order = 1;
                                $country->Member_ID = $this->user_id;
                                $country->Type = "Member";
                                $country->save();
                                $data_id = $country->db->insert_id();
                                $country_tk [] = $data_id;
                            }
                            if($country_tk != null){
                                $cmtk->update_order($check_type["ID"],$country_tk,"country");
                                $cmtk->update_order($check_type["Parent_ID"],$country_tk,"country");
                                $cmtk->update_order(0,$country_tk,"country");
                            }
                        }
                    }
                    if ($check_product["Name"] !== $general["name"]) {
                        $this->load->library('Helperclass');
                        $slug = $this->helperclass->slug("Products", "slug", trim($general["name"]));
                        $data_insert["Slug"] = $slug;
                    }
                    $featured = explode(",", $media["featured"]);
                    if (isset($featured[0]) && is_numeric($featured[0]))
                        $featured = $featured[0];
                    else
                        $featured = "";
                    $data_insert["Description"] = trim($general["description"]);
                    $data_insert["Content"] = $general["content"];
                    $data_insert["Featured_Image"] = $featured;
                    $data_insert["Path_Adderss"] = $address_path;
                    $data_insert["Updatedat"] = $datime;
                    $data_insert["Status"] = "Publish";
                    $p->where("ID", $product_id)->update($data_insert);
                    if ($product_id != 0) {
                        if (isset($category) && is_array($category) && count($category) > 0) {
                            //delete category 
                            $cat_update [] = -1;
                            $arg_id = $product_categories->where("Product_ID", $product_id)->select("Term_ID")->get_raw()->result_array();
                            if ($arg_id != null) {
                                foreach ($arg_id as $value) {
                                    $cat_update [] = $value ["Term_ID"];
                                }
                            }
                            $all_category = $ct->where_in("ID",$cat_update)->get_raw()->result_array();
                            $slug_tems = $this->add_category($all_category);
                              $order_key = [];
                            if($slug_tems != null){
                                $all_category = $ct->where_in("Slug",$slug_tems)->get_raw()->result_array();                        
                                foreach ($all_category as $key => $value_cat) { $order_key[] = $value_cat["ID"];}
                            }
	                        if($order_key != null){
	                        	$cmtk->update_order($check_type["ID"],$order_key,"category",-1);
                                $cmtk->update_order($check_type["Parent_ID"],$order_key,"category",-1);
	                        }
                            $this->db->delete('Product_Category', array('Product_ID' => $product_id));
                            $tem_id [] = -1;
                            //add category.
                            foreach ($category as $key => $value) {
                                if (is_numeric($value)) {
                                    $tem_id [] = $value;
                                    $product_categories->Product_ID = $product_id;
                                    $product_categories->Term_ID = $value;
                                    $product_categories->save();  
                                }
                            }
                            $order_key = [];
	                        $all_category = $ct->where_in("ID",$tem_id)->get_raw()->result_array();
	                        $slug_tems = $this->add_category($all_category);
                            if($slug_tems != null){
                                $all_category = $ct->where_in("Slug",$slug_tems)->get_raw()->result_array();
                            }
	                        foreach ($all_category as $key => $value_cat) {
	                        	$order_key[] = $value_cat["ID"];
	                        	$check_order = $cmtk->where(
	                                [
	                                    "Reference_ID" => $value_cat["ID"],
	                                    "Type_ID" => $check_type["ID"],
	                                    "Type" => "category"
	                                ]
	                            )->get_raw()->row_array();
	                            if($check_order == null){
	                                $cmtk->Reference_ID = $value_cat["ID"];
	                                $cmtk->Type_ID = $check_type["ID"];
	                                $cmtk->Type = "category";
	                                $cmtk->Order = 0;
	                                $cmtk->save();
	                            }
                                $check_order = $cmtk->where(
                                    [
                                        "Reference_ID" => $value_cat["ID"],
                                        "Type_ID" => $check_type["Parent_ID"],
                                        "Type" => "category"
                                    ]
                                )->get_raw()->row_array();
                                if($check_order == null){
                                    $cmtk->Reference_ID = $value_cat["ID"];
                                    $cmtk->Type_ID = $check_type["Parent_ID"];
                                    $cmtk->Type = "category";
                                    $cmtk->Order = 0;
                                    $cmtk->save();
                                }
	                        }
	                        if($order_key != null){
	                        	$cmtk->update_order($check_type["ID"],$order_key,"category");
                                $cmtk->update_order($check_type["Parent_ID"],$order_key,"category");
	                        }
                        }
                        $list_photos = explode(",", $media["list_photos"]);
                        $list_photos = array_diff($list_photos, array(''));
                        $list_photos = array_unique($list_photos);
                        //delete media 
                        $media_product->db->delete('Media_Product', array('Product_ID' => $product_id));
                        //add media/
                        foreach ($list_photos as $key => $value) {
                            if (is_numeric($value)) {
                                $media_product->Media_ID = $value;
                                $media_product->Product_ID = $product_id;
                                $media_product->save();
                            }
                        }
                        //!add media
                        //update price.    
                        $update_price["Product_ID"] = $product_id;
                        $update_price["Price"] = @$price["price_product"];
                        $update_price["Special_Price"] = (isset($price["special_price"]) ) ? $price["special_price"] : "";
                        $update_price["Special_Start"] = null;
                        $update_price["Special_End"] = null;
                        $update_price["Is_Main"] = $price["type_price"];
                        $update_price["Number_Price"] = str_replace(".","",@$price["price_product"]);
                        $product_price->where("Product_ID", $product_id)->update($update_price);
                        //!update price.                       
                        //update attribute.
                        //data update order attribute -1.
                        $old_attr = $a_value->where('Product_ID',$product_id)->get_raw()->result_array(); 
                        if($old_attr){
                        	$id_old_attr = null;
                        	foreach ($old_attr as $key_old_attr => $value_old_attr) {
                        		$id_old_attr [] = $value_old_attr["Attribute_ID"];
                        		$all_child_attr = $a_update->where("Parent_ID",$value_old_attr["Attribute_ID"])->get_raw()->result_array();
                        		if($all_child_attr != null){
                        			foreach ($all_child_attr as $key_all_child_attr => $value_all_child_attr) {
                        				$id_old_attr [] = $value_all_child_attr["ID"];
                        			}
                        		}
                        	}
                        	//update order attribute -1.
                        	if($id_old_attr != null){
                        		$cmtk->update_order($check_type["ID"],$id_old_attr,"attribute",-1);
                                $cmtk->update_order($check_type["Parent_ID"],$id_old_attr,"attribute",-1);
                        	}
                        }
                        //!data update order attribute -1.
                        //delete all attr value by product.
                        $this->db->delete('Attribute_Value', array('Product_ID' => $product_id));
                        //!delete all attr value by product.
                        //insert attribute value.
                        if (is_array($attribute) && count($attribute) > 0) {
                        	$id_attr_update_order = [] ;
                        	foreach ($attribute as $key_attribute => $value_attribute) {
                        		$key_attr = explode("-", $key_attribute);
                        		if(count($key_attr) == 2){
                        			$group_id = $key_attr[0];
                        			$attr_id = $key_attr[1];
                        			$value_set = "";
                        			if(count($value_attribute) == 1){
                        				$value_set = implode("",$value_attribute);
                        				$value_set = str_replace("{[-]}","",$value_set);
                        			}else if(count($value_attribute) > 1){
                        				$value_attribute = array_diff($value_attribute, array("{[-]}"));
                        				$attribute_child = $a_update->where_in("Name",$value_attribute)->where("Parent_ID",$attr_id)->get_raw()->result_array();
                        				if($attribute_child != null){
                        					foreach ($attribute_child as $key_attribute_child => $value_attribute_child) {
                        						$id_attr_update_order[] = $value_attribute_child["ID"];
                        					}
                        				}
                        				$value_set = implode("{[-]}",$value_attribute);
                                        if($value_set != ""){
                                            $value_set = "{[-]}".$value_set."{[-]}";
                                        }
                        			}
                        			if($value_set != ""){
                        				$id_attr_update_order[] = $attr_id;
                    					$a_value->Product_ID = $product_id;
                    					$a_value->Attribute_ID = $attr_id;
                    					$a_value->Group_ID = $group_id;
                    					$a_value->Value = $value_set;
                    					$a_value->save();
                        			}

                        		}	
                        	}
                        	//update order attribute.
                        	if($id_attr_update_order != null){
                        		foreach ($id_attr_update_order as $key_update_order => $value_update_order) {
	                    			$filter = array(
	                    				"Reference_ID" => $value_update_order,
	                    				"Type_ID" => $check_type["ID"],
	                    				"Type"    => "attribute"
	                    			);
	                    			$check_order_att = $cmtk->where($filter)->get_raw()->row_array();
	                    			if($check_order_att == null){
	                    				$cmtk->Reference_ID = $value_update_order;
	                    				$cmtk->Type_ID = $check_type["ID"];
	                    				$cmtk->Type = "attribute";
	                    				$cmtk->Order = 0;
	                    				$cmtk->save();
	                    			}
                                    $filter = array(
                                        "Reference_ID" => $value_update_order,
                                        "Type_ID" => $check_type["Parent_ID"],
                                        "Type"    => "attribute"
                                    );
                                    $check_order_att = $cmtk->where($filter)->get_raw()->row_array();
                                    if($check_order_att == null){
                                        $cmtk->Reference_ID = $value_update_order;
                                        $cmtk->Type_ID = $check_type["Parent_ID"];
                                        $cmtk->Type = "attribute";
                                        $cmtk->Order = 0;
                                        $cmtk->save();
                                    }
	                    		}
                        		$cmtk->update_order($check_type["ID"],$id_attr_update_order,"attribute",1);
                                $cmtk->update_order($check_type["Parent_ID"],$id_attr_update_order,"attribute",1);
                        	}
                        	//!update order attribute.
                        }
                        //!update attribute.
                        redirect(base_url("admin/product/edit/" . $slug . "/?category-type=" . $check_type["Slug"] . "&success=done"));
                    }
                } else {
                    if ($category == false) {
                        $check["key_error"][] = "categories";
                        $check["input_error"][] = "category";
                    }
                    $this->data["error"] = $check;
                    $this->data["success"] = "error";
                }
            }
        }
        if($this->input->get("category-type")) {
            $cat_type = $this->input->get("category-type");
            //load model.
            $p = new Products();
            $ojb_cat_type = new Category_Type();
            $country = new Country();
            $attr_value = new Attribute_Value();
            $categories_product = new Product_Category();
            $media_product = new Media_Product();
            $media = new Media();
            $product_price = new Product_Price();
            $attribute_group = new Attribute_Group();
            $category = new Categories();
            $attribute_group_attribute = new Attribute_Group_Attribute();
            $attribute = new Attribute();
            $pk = new Product_Keyword();
            //!load model.
            $check_cat_type = $ojb_cat_type->where("Slug", $cat_type)->get_raw()->row_array();
            $product = $p->where("Slug", $slug)->get_raw()->row_array();
            if (is_array($product) && count($product) > 0 && is_array($check_cat_type) && count($check_cat_type) > 0 && $product["Type_ID"] == $check_cat_type["ID"]) {
                $path_adderss = explode("/", $product["Path_Adderss"]);
                $path_adderss = array_diff($path_adderss, array(''));
                $arg_country = $country->where_in("Slug", $path_adderss)->get_raw()->result_array();
                $this->data["arg_country"] = $arg_country;
                $this->data["city_activer"] = -1;
                $this->data["districts_activer"] = -1;
                $this->data["wards_activer"] = -1;
                if (isset($arg_country) && is_array($arg_country)) {
                    foreach ($arg_country as $key => $value) {
                        if ($value["Level"] == 0) {
                            $this->data["city_activer"] = $value["ID"];
                            $this->data["districts_arg"] = $country->get_country($this->user_id, 1, $value["ID"],0);
                        }
                        if ($value["Level"] == 1) {
                            $this->data["districts_activer"] = $value["ID"];
                            $this->data["wards_arg"] = $country->get_country($this->user_id, 2, $value["ID"],0);
                        }
                        if ($value["Level"] == 2) {
                            $this->data["wards_activer"] = $value["ID"];
                        }
                    }
                }
                $this->data["product_slug"] = trim($slug);
                $product_id = $product["ID"];
                $this->data["product_id"] = $product_id;
                $attr_activer = $attr_value->where("Product_ID", $product_id)->get_raw()->result_array();
                $cat_activer = $categories_product->select("Term_ID AS ID")->where("Product_ID", $product_id)->get_raw()->result_array();
                $this->data["media_activer"] = $media_product->get_by_product($product_id);
                $this->data["thumbnail"] = $media->where("ID", $product["Featured_Image"])->get_raw()->row_array();
                $price_activer = $product_price->where("Product_ID", $product_id)->get_raw()->row_array();
                $data_id_cat_type = $check_cat_type["ID"];
                $this->data["cat_type_id"] = $data_id_cat_type;
                $this->data["category_type_slug"] = $cat_type;
                $arg_new_attr = [];
                $attribute_arg = $attribute_group->get_attr_cat_type($data_id_cat_type, $this->user_id);
                $this->data["attr_group"] = $attribute_arg;
                $arg_tabs = [];
                $attribute_parent_id [] = "*-*";
                $arg_gr = $attribute_group_attribute->get_attribute_group($this->user_id, $data_id_cat_type);
                if (is_array($attribute_arg) && count($attribute_arg) > 0) {
                    foreach ($attribute_arg as $key => $attribute_group_value) {
                        if (is_array($arg_gr) && count($arg_gr) > 0) {
                            foreach ($arg_gr as $key => $arg_gr_value) {
                                if ($arg_gr_value["Group_ID"] == $attribute_group_value["ID"]) {
                                    $attribute_group_value["items"][] = $arg_gr_value;
                                }
                                $attribute_parent_id []= $arg_gr_value["Attribute_ID"] ;
                            }
                        }
                        $arg_tabs[] = $attribute_group_value;
                    }
                }
                $sql = "SELECT * FROM (`Categories`) WHERE (`Categories`.`Type_ID` = {$data_id_cat_type}  OR (`Categories`.`Type_ID` = (SELECT `cc`.`Parent_ID` FROM Category_Type AS cc WHERE `cc`.`ID` = {$data_id_cat_type}) ) ) AND `Disable` = 0";
                $record_cat = $category->db->query($sql);
                $record_cat = $record_cat->result_array();
                if (count($record_cat) > 0) {
                    $this->load->library('Helperclass');
                    $select_html = $this->helperclass->get_select_tree($record_cat, 0, "Parent_ID", "Name", null, "ID", $cat_activer);
                    $this->data["select_cat"] = $select_html['table_tree_select'];
                    $this->data["cat_tree"] = $select_html['table_tree'];
                }
                
                $attribute_owner = $attribute->where_in("Parent_ID",$attribute_parent_id)->get_raw()->result_array(); 
                $keyword_arg = $pk->get_by_product($product_id);
                $this->data["keywords"] = $keyword_arg;
                $this->data["city"] = $country->get_country($this->user_id, 0, 0,0);
                $this->data["product"] = $product;
                $this->data["price"] = $price_activer;
                $this->data["arg_tabs"] = $arg_tabs;
                $this->data["att_activer"] = $attr_activer;
                $this->data["attribute_owner"] = $attribute_owner;
                $this->data["view"] = "fontend/profile/products/add-edit";
                $this->load->view('backend/include/header');
                $this->load->view('backend/products/add-edit', $this->data);
                $this->load->view('backend/include/footer');

            } else {
                redirect(base_url("admin/product/add"));
            }
        } else {
            redirect(base_url("admin/product/add"));
        }
    }
    private function valid_product($arg = [], $required = [], $number = [], $datime = []) {
        $check = true;
        $data_return = [];
        $data_input_error = [];
        $key_error = "";
        $key_error_f = "";
        if (is_array($arg) && count($arg) > 0) {
            foreach ($arg AS $key => $value_arg) {
                $key_error = $key;
                foreach ($required as $key => $value) {
                    if (isset($value_arg[$value]) && trim($value_arg[$value]) == "") {
                        $check = false;
                        $key_error_f = $key_error;
                        $data_input_error [] = $value;
                    }
                }
                if ($key_error_f != "") {
                    $data_return[] = $key_error_f;
                    $key_error_f = "";
                }
                foreach ($number as $key => $value) {
                    if (isset($value_arg[$value]) && $value_arg[$value] != "" && !is_numeric($value_arg[$value])) {
                        $check = false;
                        $key_error_f = $key_error;
                        $data_input_error [] = $value;
                    }
                }
                if ($key_error_f != "") {
                    $data_return[] = $key_error_f;
                    $key_error_f = "";
                }
                foreach ($datime as $key => $value) {
                    if (isset($value_arg[$value]) && $value_arg[$value] != "" && !$this->validateDate($value_arg[$value])) {
                        $check = false;
                        $key_error_f = $key_error;
                        $data_input_error [] = $value;
                    }
                }
                if ($key_error_f != "") {
                    $data_return[] = $key_error_f;
                    $key_error_f = "";
                }
            }
        }
        return array(
            "check" => $check,
            "key_error" => $data_return,
            "input_error" => $data_input_error
        );
    }
    private function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    public function addgroup() {
        check_ajax();
        $data["success"] = "error";
        $data["messenger"] = "";
        $data_category = trim($this->input->post("data_category"));
        $name = trim($this->input->post("name"));
        $sort = trim($this->input->post("sort"));
        $category_type = new Category_Type();
        $check_category = $category_type->where("Slug", $data_category)->get_raw()->row_array();
        if (count($check_category) > 0) {
            $attribute_group = new Attribute_Group();
            $datime = date('Y-m-d H:i:s');
            $filter = array(
                "Type_ID" => $check_category["ID"],
                "Name" => $name
            );
            $check_attribute_group = $attribute_group->where($filter)->get_raw()->row_array();
            if (count($check_attribute_group) > 0) {
                $data["slug"] = $check_attribute_group["Slug"];
            } else {
                $this->load->library('Helperclass');
                $slug = $this->helperclass->slug("Attribute_Group", "slug", $name);
                $attribute_group->Name = $name;
                $attribute_group->Slug = $slug;
                $attribute_group->Type_ID = $check_category["ID"];
                $attribute_group->Member_ID = $this->user_id;
                $attribute_group->Type = $this->type_member;
                $attribute_group->Sort = $sort;
                $attribute_group->Createat = $datime;
                $attribute_group->save();
                $data["success"] = "success";
                $data["slug"] = $slug;
                $data["name"] = $name;
                $data["category"] = $data_category;
                $data["sort"] = $sort;
            }
        }
        die(json_encode($data));
    }
    public function delete($id = null) {
        check_ajax();
        $data["success"] = "error";
        if ($id != null && is_numeric($id)) {
            $p = new Products();
            $ctp = new Product_Category();
            $ct = new Categories();
            $a_value = new Attribute_Value();
            $a_update = new Attribute();
            $country = new Country();
            $cmtk = new Common_Tracking();
            $kw = new Keywords();
            $kwp = new Product_Keyword();
            $cat_type = new Category_Type();
            $check = $p->where("ID",$id)->get_raw()->row_array();
            if ($check !== null) {
            	// update category
                $cat_all_id = $ctp->where("Product_ID", $check["ID"])->select("Term_ID")->get_raw()->result_array();
                $cat_id[] = -1;
                foreach ($cat_all_id as $key => $value) {
                    $cat_id [] = $value["Term_ID"];
                }
                $all_category = $ct->where_in("ID",$cat_id)->get_raw()->result_array();
                $slug_tems = $this->add_category($all_category);
                $all_category = $ct->where_in("Slug",$slug_tems)->get_raw()->result_array();
                $order_key = [];
                $category_type = $cat_type->where("ID",$check["Type_ID"])->get_raw()->row_array();
                foreach ($all_category as $key => $value_cat) { $order_key[] = $value_cat["ID"];}
                if($order_key != null){
                	$cmtk->update_order($check["Type_ID"],$order_key,"category",-1);
                    if($category_type != null){
                        $cmtk->update_order($category_type["Parent_ID"],$order_key,"category",-1);
                    }
                    
                }
                // update attribute 
                $old_attr = $a_value->where('Product_ID',$check["ID"])->get_raw()->result_array(); 
                if($old_attr){
                	$id_old_attr = null;
                	foreach ($old_attr as $key_old_attr => $value_old_attr) {
                		$id_old_attr [] = $value_old_attr["Attribute_ID"];
                		$all_child_attr = $a_update->where("Parent_ID",$value_old_attr["Attribute_ID"])->get_raw()->result_array();
                		if($all_child_attr != null){
                			foreach ($all_child_attr as $key_all_child_attr => $value_all_child_attr) {
                				$id_old_attr [] = $value_all_child_attr["ID"];
                			}
                		}
                	}
                	//update order attribute -1.
                	if($id_old_attr != null){
                		$cmtk->update_order($check["Type_ID"],$id_old_attr,"attribute",-1);
                        if($category_type != null){
                            $cmtk->update_order($category_type["Parent_ID"],$id_old_attr,"attribute",-1);
                        }
                	}
                	
                }
                // update Country
                $path_country = $check["Path_Adderss"];
                if($path_country != null){
                    $arg_slug_country = explode("/", $path_country);
                    $arg_slug_country = array_diff($arg_slug_country, array(''));
                    $id_country = $country->where_in("Slug", $arg_slug_country)->get_raw()->result_array();
                    $country_tk = null;
                    if($id_country!= null){
                        foreach ($id_country as $key => $value) {
                            $country_tk [] = $value["ID"];
                        }
                        $cmtk->update_order($check["Type_ID"],$country_tk,"country",-1);
                        if($category_type != null){
                            $cmtk->update_order($category_type["Parent_ID"],$country_tk,"country",-1);
                        }
                        $cmtk->update_order(0,$country_tk,"country",-1);
                    }
                   
                }
                //updata keyword.
                $all_key = $kwp->where("Product_ID",$check["ID"])->get_raw()->result_array();
                if($all_key != null){
                    $arg_keyword = [];
                    foreach ($all_key as $key => $value) {
                       $arg_keyword [] = @$value["Keyword_ID"];
                    }
                    if($arg_keyword != null){
                        $kw->update_order($arg_keyword,-1);
                    }  
                }
                $this->db->delete('Product_Keyword', array('Product_ID' => $check["ID"]));
                $this->db->delete("Attribute_Value", array('Product_ID' => $check["ID"]));
                $this->db->delete("Product_Category", array('Product_ID' => $check["ID"]));
                $this->db->delete("Products", array('ID' => $check["ID"]));
                $data["success"] = "success";
            }
        }
        die(json_encode($data));
    }
    public function disabled($id = null) {
        check_ajax();
        $data["success"] = "error";
        if ($id != null && is_numeric($id)) {
            $p = new Products();
            $ctp = new Product_Category();
            $ct = new Categories();
            $a_value = new Attribute_Value();
            $a_update = new Attribute();
            $country = new Country();
            $cmtk = new Common_Tracking();
            $kw = new Keywords();
            $kwp = new Product_Keyword();
            $cat_type = new Category_Type();
            $check = $p->where(array("ID" => $id))->get_raw()->row_array();
            if ($check != null) {
                $data_update = 0;
                $data_order = 1;
                if ($check["Disable"] == 0) {
                    $data_update = 1;
                    $data_order = -1;
                }
                // update category
                $cat_all_id = $ctp->where("Product_ID", $id)->select("Term_ID")->get_raw()->result_array();
                $cat_id[] = -1;
                foreach ($cat_all_id as $key => $value) {
                    $cat_id [] = $value["Term_ID"];
                }
                $all_category = $ct->where_in("ID",$cat_id)->get_raw()->result_array();
                $slug_tems = $this->add_category($all_category);
                $all_category = $ct->where_in("Slug",$slug_tems)->get_raw()->result_array();
                $order_key = [];
                foreach ($all_category as $key => $value_cat) { $order_key[] = $value_cat["ID"];}
                $category_type = $cat_type->where("ID",$check["Type_ID"])->get_raw()->row_array();
                if($order_key != null){
                    $cmtk->update_order($check["Type_ID"],$order_key,"category",$data_order);
                    if($category_type != null){
                        $cmtk->update_order($category_type["Parent_ID"],$order_key,"category",$data_order);
                    }
                }
                // update attribute 
                $old_attr = $a_value->where('Product_ID',$check["ID"])->get_raw()->result_array(); 
                if($old_attr){
                    $id_old_attr = null;
                    foreach ($old_attr as $key_old_attr => $value_old_attr) {
                        $id_old_attr [] = $value_old_attr["Attribute_ID"];
                        $all_child_attr = $a_update->where("Parent_ID",$value_old_attr["Attribute_ID"])->get_raw()->result_array();
                        if($all_child_attr != null){
                            foreach ($all_child_attr as $key_all_child_attr => $value_all_child_attr) {
                                $id_old_attr [] = $value_all_child_attr["ID"];
                            }
                        }
                    }
                    //update order attribute.
                    if($id_old_attr != null){
                        $cmtk->update_order($check["Type_ID"],$id_old_attr,"attribute",$data_order);
                        if($category_type != null){
                            $cmtk->update_order($category_type["Parent_ID"],$id_old_attr,"attribute",$data_order);
                        }

                    }
                }
                // update Country
                $path_country = $check["Path_Adderss"];
                if($path_country != null){
                    $arg_slug_country = explode("/", $path_country);
                    $arg_slug_country = array_diff($arg_slug_country, array(''));
                    $id_country = $country->where_in("Slug", $arg_slug_country)->get_raw()->result_array();
                    $country_tk = null;
                    if($id_country!= null){
                        foreach ($id_country as $key => $value) {
                            $country_tk [] = $value["ID"];
                        }
                        $cmtk->update_order($check["Type_ID"],$country_tk,"country",$data_order);
                        if($category_type != null){
                            $cmtk->update_order($category_type["Parent_ID"],$country_tk,"country",$data_order);
                        }
                        $cmtk->update_order(0,$country_tk,"country",$data_order);
                    }
                }
                //updata keyword.
                $all_key = $kwp->where("Product_ID",$check["ID"])->get_raw()->result_array();
                if($all_key != null){
                    $arg_keyword = [];
                    foreach ($all_key as $key => $value) {
                       $arg_keyword [] = @$value["Keyword_ID"];
                    }
                    if($arg_keyword != null){
                        $kw->update_order($arg_keyword,$data_order);
                    }  
                }
                $p->where("ID", $id)->update(array("Disable" => $data_update));
                $data["success"] = "success";
                $data["number"] = $data_update;
            }
        }
        die(json_encode($data));
    }

    public function remove_attribute() {
        check_ajax();
        $id = $this->input->post("id");
        $type = $this->input->post("type");
        $token = $this->input->post("token");
        $reference_type = $this->input->post("reference_type");
        $data["success"] = "error";
        if ($id != null && is_numeric($id) && $type != "" && $token != "") {
            $datime = date('Y-m-d H:i:s');
            $cmns = new Common_Not_Show();
            $cmns->Reference_ID = $id;
            $cmns->Type = $type;
            $cmns->Reference_Type_ID = $reference_type;
            $cmns->Token = $token;
            $cmns->Createat = $datime;
            $cmns->save();
            $data["success"] = "success";
        }
        die(json_encode($data));
    }

    public function show_attribute_hidden() {
        check_ajax();
        $data["success"] = "error";
        $data["post"] = $_POST;
        $token_set = $this->input->post("token_set");
        $product_id = ($this->input->post("product_id") != 0) ? $this->input->post("product_id") : -1;
        $type = $this->input->post("type");
        $group = $this->input->post("group");
        $g = new Attribute_Group();
        if ($type == "attribute") {
            $group_record = $g->where("Slug", $group)->get_raw()->row_array();
            if ($group_record != null) {
                $group_id = $group_record["ID"];
                $a = new Attribute ();
                $hideen_result = $a->get_attribute_hideen($group_id, $token_set, $type, $product_id, $this->user_id);
                $data["response"] = $hideen_result;
                $data["success"] = "success";
            }
        } else {
            
        }
        die(json_encode($data));
    }

    public function add_attribute_hidden() {
        check_ajax();
        $data["success"] = "error";
        $token_set = $this->input->post("token_set");
        $product_id = ($this->input->post("product_id") != 0) ? $this->input->post("product_id") : -1;
        $type = $this->input->post("type");
        $id = $this->input->post("id");
        $id = explode(",", $id);
        $filter = [];
        foreach ($id AS $key => $value) {
            if ($value != "" && is_numeric($value)) {
                $filter = [
                    "Reference_ID" => $value,
                    "Product_ID" => $product_id,
                    "Type" => $type
                ];
                $this->db->delete("Common_Not_Show", $filter);
                $filter = [
                    "Reference_ID" => $value,
                    "Token" => $token_set,
                    "Type" => $type
                ];
                $this->db->delete("Common_Not_Show", $filter);
            }
        }
        $data["success"] = "success";
        die(json_encode($data));
    }

    private function update_slug($table) {
        $this->db->select("ID,Path");
        $this->db->from($table);
        $q = $this->db->get()->result_array();
        foreach ($q as $key => $value) {
            $this->db->where("ID", $value["ID"]);
            $data = array(
                "Path" => "/" . $value["Path"] . "/"
            );
            $return = $this->db->update($table, $data);
        }
    }
    public function product_paging(){
        check_ajax();
        $cat_type = $this->input->post("cat_type");
        $page     = $this->input->post("page");
        $number_item = 30;
        $offset = $page;
        $limit = $page * $number_item;
        $ojb_cat_type = new Category_Type();
        $check_cat_type = $ojb_cat_type->where("Slug", $cat_type)->get_raw()->row_array();
        if($check_cat_type != null){
            $p = new Products();
            $data["product_record"] = $p->get_index($this->user_id, $this->type_member,$check_cat_type["ID"],0,1);
            print_r($data["product_record"]);
        }
    }
    private function add_category ($arg_id = []){
        $arg_return = [];
        foreach ($arg_id as $key => $value) {
            $path = $value["Path"];
            $arg_path = explode("/",$path);
            $arg_path = array_diff($arg_path, array(''));
            $arg_return = array_merge($arg_return,$arg_path);
            
        }
        return array_unique($arg_return);
    }

}
