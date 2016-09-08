<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Search extends CI_Controller {
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
        }
        $this->data["product_on_page"] = $this->Common_model->get_record("Website_Setting",["Key_Identify" => "number_show_product"]);
        $this->data["product_on_page"] = (@$this->data["product_on_page"]["Title"] !== "" && is_numeric(@$this->data["product_on_page"]["Title"])) ? $this->data["product_on_page"]["Title"] : "0";
    }
    function index(){
        $ct = new Category_Type();
        $cat = new Categories();
        $p = new Products();
        $cat_type = null;
        $keyword = null;
        if( $this->input->get() ){
            $cat_type = (trim($this->input->get("danh-muc")) == "") ? "all" : trim($this->input->get("danh-muc"));
            $keyword = (trim($this->input->get("tu-khoa")) == "") ? null : trim($this->input->get("tu-khoa"));
        }
        //chech category type.
        $check = $ct->where(["Slug" => trim($cat_type),"Disable" => "0"])->get_raw()->row_array();
        $path = null;
        if($check != null){ 
            $path = $check["Path"];
            $products = $p->get_product_by_type($path,null,$keyword,0,$this->data["product_on_page"],$this->user_id);
			// $this->output->enable_profiler(TRUE);
            $a = new Attribute();
            $cns = new Common_Not_Show();
            $kw = new Keywords();
            $att_ns = $cns->select("Reference_ID")->where(["Reference_Single_ID"=>$check["ID"],"Type" => "attribute","Single_Type" =>"category_type"])->get_raw()->result_array();
            $array_ns []= -1;
            foreach ($att_ns as $key => $value) {
               $array_ns[]=$value["Reference_ID"];
            }
            $attribute = $a->get_attr_cat_set([$check["ID"],$check["Parent_ID"]],["checkbox","select","radio","multipleselect","multipleradio","option"],$array_ns,$check["ID"]);
            $this->html  = "";
            $html = $this->_attr_search($attribute,0,"attribute");
            $this->data["attribute"] = $html;
            $children  = $ct->select("*")->like("Path",$path)->get_raw()->result_array();
            $categories = $cat->get_cat_cat_set($check["Path"],$check["Parent_ID"],$check["ID"]);
            //$html_categories = $this->_attr_search($categories,0,"categories","list-cat","href",$slug);
            $this->html  = "";
            $html_categories = $this->_attr_search($categories,0,"categories");
            $children_cattype = $ct->where("Parent_ID",$check["ID"])->get_raw()->result_array();
            if($children_cattype != null){
            	$name = $check["Name"];
                if(strlen($name) >= 30){
                	$arg_name = explode(" ", $name);
                	$str_name_arg = [] ;
                	$str_name = "";
                	$i = 0;
                	foreach ($arg_name as $key_arg_name => $value_arg_name) {
                		$str_name_arg[] = $value_arg_name;
                		$str_name = implode(" ", $str_name_arg);
                		if(strlen($str_name) >= 30){
                			unset($str_name_arg[$i]);
                			break;
                		}
                		$i ++;
                	}
                	$name = implode(" ", $str_name_arg)."...";
                }
                $category_type_html = '<ul class="list-attribute"><li class="parent_li">
                        <p title ="'.$check["Name"].'">
                            '.$name.'
                        </p>                
                    <ul>';
                foreach ($children_cattype as $key => $value) {
                	$name = $value["Name"];
                    if(strlen($name) >= 30){
                    	$arg_name = explode(" ", $name);
                    	$str_name_arg = [] ;
                    	$str_name = "";
                    	$i = 0;
                    	foreach ($arg_name as $key_arg_name => $value_arg_name) {
                    		$str_name_arg[] = $value_arg_name;
                    		$str_name = implode(" ", $str_name_arg);
                    		if(strlen($str_name) >= 30){
                    			unset($str_name_arg[$i]);
                    			break;
                    		}
                    		$i ++;
                    	}
                    	$name = implode(" ", $str_name_arg)."...";
                    }
                    $category_type_html .='<li><p><a title ="'.$value["Name"].'" class="link-category-type" href="'.base_url("danh-muc".$value["Path"]).'">'.$name.'</a></p></li>';
                    $category_type_html .='<li>';
                }
                $category_type_html .= '</ul></li></ul>';
                $this->data["category_type"] = $category_type_html;
            }
            
            $this->data["path"] = $check["Path"];
            $this->data["keyword"] = $kw->get_kw_by_type($check["Path"]);
            $this->data["categories"] = $html_categories;
            $this->data["products"] = $products; 
            $this->data["max_price"] = $p->get_max_min_price($check["Path"],null,$keyword,true); 
            $this->data["min_price"] = $p->get_max_min_price($check["Path"],null,$keyword,false); 
            $this->data["min_price"] = str_replace(".","",$this->data["min_price"]);
            $this->data["max_price"] = str_replace(".","",$this->data["max_price"]);   
            $this->data["total_product"] = $p->get_total_product($check["Path"],null,$keyword);
            
        }else{
        	$ct = new Category_Type();
        	$all_ct = $ct->get_raw()->result_array();
        	$this->data["category_type"] = $this->_attr_search($all_ct,0,"categories","list-cat","href");
            $products = $p->get_product_by_type($path,null,$keyword,0,$this->data["product_on_page"],$this->user_id);
            $this->data["products"] = $products; 
            $this->data["max_price"] = $p->get_max_min_price($path,null,$keyword,true); 
            $this->data["min_price"] = $p->get_max_min_price($path,null,$keyword,false); 
            $this->data["min_price"] = str_replace(".","",$this->data["min_price"]);
            $this->data["max_price"] = str_replace(".","",$this->data["max_price"]); 
            $this->data["total_product"] = $p->get_total_product($path,null,$keyword);    
        }   
        $country = new Country();
        $check["ID"] = (isset($check["ID"])) ? $check["ID"] : 0;
        $this->data["city"] = $country->get_country($this->user_id, 0, 0,$check["ID"]);
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/category_type/index',$this->data);
        $this->load->view('fontend/block/footer',$this->data); 
    }
    function filter(){
        check_ajax();
        $data["status"] = "error";
        $data["responsive"] = "error";
        $keyword = ($this->input->post("keyword") != "") ? trim($this->input->post("keyword")) : null;
        $current_uri = ($this->input->post("current_uri") != "") ? trim($this->input->post("current_uri")) : null;
        $category_type = ($this->input->post("category_type") != "") ? trim($this->input->post("category_type")) : null;
        $categories = ($this->input->post("categories") != null) ? $this->input->post("categories") : null;
        $attribute = ($this->input->post("attribute") != null) ? $this->input->post("attribute") : null;
        $max_price = ($this->input->post("max_price") != null) ? trim($this->input->post("max_price")) : null;
        $min_price = ($this->input->post("min_price") != null) ? trim($this->input->post("min_price")) : null;
        $sorted_by = ($this->input->post("sorted_by") != null) ? trim($this->input->post("sorted_by")) : null;
        $current_page = (trim($this->input->post("current_page")) != null) ? trim($this->input->post("current_page")) : 0;
        $country = ($this->input->post("country") != null && $this->input->post("country") != "null" && $this->input->post("country") != "") ? $this->input->post("country") : null;
        if($sorted_by != null){
            $data_check_order = ["rate","view","price-high","price-low"];
            //if(in_array($sorted_by, $data_check_order)){
            switch ($sorted_by) {
                case "rate":
                    $sorted_by = ["column" => "Rate_Number","order" => "DESC"];
                    break;
                case "view":
                    $sorted_by = ["column" => "t.Num_View","order" => "DESC"];
                    break;
                case "price-high":
                    $sorted_by = ["column" => "pp.Number_Price","order" => "DESC"];
                    break;
                case 'price-low':
                    $sorted_by = ["column" => "pp.Number_Price","order" => "ASC"];
                    break;
                default:
                    $sorted_by = ["column" => "p.Createdat","order" => "DESC"];
            }
            //}   
        }else{
            $sorted_by = ["column" => "p.Createdat","order" => "DESC"];  
        }
        $data["status"] = "error";
        $data["responsive"] = "null";
        $p = new Products;
        if($categories != null){
            $categories = implode("','", $categories);
        }
        if($attribute != null){
            $attribute = implode("','", $attribute);
        }
        if($country != null && is_numeric($country)){
            $c = new Country();
            $c_Path = $c->select("Path")->where("ID",$country)->get_raw()->row_array();
            if($c_Path != null){
                $country = $c_Path["Path"];
            }else{
                $country = null;
            }
        }
        $offset = intval($current_page) * intval($this->data["product_on_page"]);
        $limit = $this->data["product_on_page"];
        $data["offset"] = $offset;
        $data["limit"] = $limit;
        $records = $p->get_filter_search($offset,$limit,$keyword,$category_type,$categories,$attribute,$min_price ,$max_price,$sorted_by,$country,$this->user_id);
        $data["status"] = "success";
        $data["responsive"] = ""; 
        $data["data_post"] = $this->input->post();
        $data["product_on_page"] = $this->data["product_on_page"];
        $data["total_product"]  = $p->total_filter_search($keyword,$category_type,$categories,$attribute,$min_price ,$max_price,$country);
        $data["records"] = $records;
        if($records != null && is_array($records)){
            foreach ($records as $key => $value) {
                $data_sent["product"] = $value;
                $data["responsive"].= '<div class="col-sm-3">'.$this->load->view("fontend/include/product",$data_sent,true).'</div>';
            }
        }
        die(json_encode($data));
    }
    private $html = "";
    function _attr_search ($arg,$root,$type,$class = "list-attribute",$link = null,$url = ""){
        if($root == 0){
            $this->html  = "";
            $this->html .= '<ul class="'.$class.'" id="box-search-parent">';
        }else{
            $this->html .= '<ul>';
        }
        $text_number = 20;
        if($link != null){$text_number = 35;}
        if($arg != null){
            foreach ($arg as $key => $value) {
                if($value["Parent_ID"] == $root){
                    $order = (isset($value["Order"]) && $value["Order"] != null) ? $value["Order"] : "0";
                    $name = $value["Name"];
                    if(strlen($name) >= $text_number){
                    	$arg_name = explode(" ", $name);
                    	$str_name_arg = [] ;
                    	$str_name = "";
                    	$i = 0;
                    	foreach ($arg_name as $key_arg_name => $value_arg_name) {
                    		$str_name_arg[] = $value_arg_name;
                    		$str_name = implode(" ", $str_name_arg);
                    		if(strlen($str_name) >= $text_number){
                    			unset($str_name_arg[$i]);
                    			break;
                    		}
                    		$i ++;
                    	}
                    	$name = implode(" ", $str_name_arg)."...";
                    }
                    unset($arg[$key]);
                    if($link == null){
                        if($root == 0){
                            $this->html.= '<li class="parent_li">';
                        }else{
                            $this->html.= '<li>';
                        }
                        $this->html.= '<div class="checkbox">
                                    <input id="'.$value["Slug"].'" class="styled" type="checkbox" value ="'.$value["Path"].'" data-type ="'.$type.'">
                                    <label for="'.$value["Slug"].'" title="'.$value["Name"].'">
                                        '.$name.' <span class="count">('.$order.')</span>
                                    </label>
                                </div>'; 
                                $this->_attr_search($arg,$value["ID"],$type,$class,$link);
                        $this->html.='</li>';
                    }else{
                        $this->html.= '<li><a href="'.base_url("danh-muc".$value["Path"]).'" title="'.$value["Name"].'">'.$name.'</a>';
                            $this->_attr_search($arg,$value["ID"],$type,$class,$link,$url);
                        $this->html.='</li>';
                    }
                }
            }
        }
        $this->html .= "</ul>";
        return $this->html;
    }

}