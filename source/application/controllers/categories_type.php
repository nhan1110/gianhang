<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_type extends CI_Controller {

    private $is_login = false;
    private $user_info = array();
    private $user_id = 0;
    private $data = array();
    private $_token = false;
    function __construct() {
        parent::__construct();
        $this->is_login;
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
        }
        $this->_token = _token();
        $this->data["is_login"] = $this->is_login;
        $this->data["_token"] = $this->_token;
        $this->data["product_on_page"] = $this->Common_model->get_record("Website_Setting",["Key_Identify" => "number_show_product"]);
        $this->data["product_on_page"] = (@$this->data["product_on_page"]["Title"] !== "" && is_numeric(@$this->data["product_on_page"]["Title"])) ? $this->data["product_on_page"]["Title"] : "0";
    }

    public function index($slug_1 = null, $slug_2 = null) {
        $slug = $slug_1;
        if($slug_2 != null){$slug = $slug_2;}
        $this->data["slug"] = $slug;
        if($slug_1 != null){
            $ct = new Category_Type();
            $cat = new Categories();
            $p = new Products();
            $check = $ct->where(["Slug" => trim($slug),"Disable" => "0"])->get_raw()->row_array();
            $path = null ;
            if($check != null){
                $path = @$check["Path"];
                $arg_path = explode("/",$path);
                $breadcrumb = '<li><a href="'.base_url().'">Home</a></li>';
                $url_breadcrumb = base_url();
                $arg_path = array_diff($arg_path, array(''));
                $i_check = count($arg_path);
                $i = 0;
                foreach ($arg_path as $key => $value) {
                	$i++;
                	$cat_item = $ct->where("Slug",trim($value))->get_raw()->row_array();
                	if($i >= $i_check){
                		$breadcrumb .= '<li>'.$cat_item["Name"].'</li>';
                	}else{	
                		$breadcrumb .= '<li class="active"><a href="'.base_url("danh-muc".$cat_item["Path"]).'">'.$cat_item["Name"].'</a></li>';
                	}
                }
                $this->data["breadcrumb"] = $breadcrumb;
                if($slug_2 == null){
                    if($check["Parent_ID"] == 0){
                        $user_id = $this->user_id;
                        $this->data['is_main'] = true;
                        $where = array('Parent_ID' => $check["ID"]);
                        $this->data['is_main'] = false;
                        $ct->where($where)->order_by('Sort','ASC')->get();
                        $list_item = array();
                        if(isset($ct) && $ct!=null):
                            foreach ($ct as $key => $value) {
                                $item = array();
                                $ct_id = $value->ID;
                                $item['ID'] = $value->ID;
                                $item['Name'] = $value->Name;
                                $item['Slug'] = $value->Slug;
                                $item['Images'] = $value->Images;
                                $item['Icon'] = $value->Icon;
                                $item['Path'] = $value->Path;
                                $ct->where(array('Parent_ID' => $ct_id))->order_by('Sort','ASC')->get();
                                $list_category_type_id = '('.$ct_id.',';
                                $item['cat_type_children'] = array();
                                if(isset($ct)){
                                    foreach ($ct as  $cat_item) {
                                        $item_cat = array();
                                        $item_cat['ID'] = $cat_item->ID;
                                        $item_cat['Name'] = $cat_item->Name;
                                        $item_cat['Slug'] = $cat_item->Slug;
                                        $item['cat_type_children'][] = $item_cat;
                                        $list_category_type_id .= $cat_item->ID.',';
                                    }
                                }
                                $list_category_type_id .= '-1)';

                                $sql_product_new = "SELECT p.*,t.Num_View,t.Num_Comment,t.Num_Rate,t.Num_Like,t.Num_Share_Facebook,t.Num_Share_Google,m.Path_Thumb,rate.num_rate,tk.Is_Like
                                        FROM Products AS p
                                        LEFT JOIN (
                                            SELECT AVG(Num_Rate) AS num_rate,URL
                                            FROM Rate
                                        ) rate ON rate.URL = concat('/product/details/',p.Slug)
                                        LEFT JOIN Tracking_Like AS tk ON tk.URL = concat('/product/details/',p.Slug) AND tk.Member_ID = '$user_id'
                                        LEFT JOIN Tracking AS t ON t.URL = concat('/product/details/',p.Slug)
                                        INNER JOIN Media AS m ON p.Featured_Image = m.ID
                                        INNER JOIN Product_Price AS pr ON pr.Product_ID = p.ID
                                        WHERE p.Type_ID IN $list_category_type_id AND p.Status='Publish'
                                        GROUP BY p.ID
                                        ORDER BY p.Createdat DESC
                                        LIMIT 0,10";
 
                                $product = $this->Common_model->query_raw($sql_product_new);
                                $item['product_new'] = $product;
                                $list_item[] = $item;
                            }
                        endif;
                        $this->data['results'] = $list_item;
                        $this->load->view('fontend/block/header', $this->data);
                        $this->load->view('fontend/block/wrapper',$this->data);
                        $this->load->view('fontend/block/footer',$this->data);
                    }else{
                        redirect(base_url("danh-muc".$check["Path"]));
                    }
                }else{
                    if(("/".$slug_1."/".$slug_2."/") != $path){
                        redirect(base_url());
                    }else{
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
                        $children  = $ct->select("*")->like("Path",$check["Path"])->get_raw()->result_array();
                        $categories = $cat->get_cat_cat_set($check["Path"],$check["Parent_ID"],$check["ID"]);
                        //$html_categories = $this->_attr_search($categories,0,"categories","list-cat","href",$slug);
                        $this->html  = "";
                        $html_categories = $this->_attr_search($categories,0,"categories");
                        $products = $p->get_product_by_type($check["Path"],null,null,0,$this->data["product_on_page"],$this->user_id);
                        $country = new Country();
                        $check["ID"] = (isset($check["ID"])) ? $check["ID"] : 0;
                        $this->data["city"] = $country->get_country($this->user_id, 0, 0,$check["ID"]);
                        $this->data["path"] = $check["Path"];
                        $this->data["keyword"] = $kw->get_kw_by_type($check["Path"]);
                        $this->data["categories"] = $html_categories;
                        $this->data["products"] = $products; 
                        $this->data["max_price"] = $p->get_max_min_price($check["Path"],null,null,true); 
                        $this->data["min_price"] = $p->get_max_min_price($check["Path"],null,null,false);      
                        $this->data["min_price"] = str_replace(".","",$this->data["min_price"]);
                        $this->data["max_price"] = str_replace(".","",$this->data["max_price"]);
                        $this->data["total_product"] = $p->get_total_product($check["Path"],null,null); 
                        $this->load->view('fontend/block/header', $this->data);
                        $this->load->view('fontend/category_type/index',$this->data);
                        $this->load->view('fontend/block/footer',$this->data);
                    }
                }
            } 
        }else{
            redirect(base_url());
        }  
    }

    private $html = "";
    function _attr_search ($arg,$root,$type,$class = "list-attribute",$link = null,$url = ""){
        if($root == 0){
            $this->html .= '<ul class="'.$class.'" id="box-search-parent">';
        }else{
            $this->html .= '<ul>';
        }
        if($arg != null){
            foreach ($arg as $key => $value) {
                if($value["Parent_ID"] == $root){
                	$order = (isset($value["Order"]) && $value["Order"] != null) ? $value["Order"] : "0";
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
                                        '.$value["Name"].' <span class="count">('.$order.')</span>
                                    </label>
                                </div>'; 
                                $this->_attr_search($arg,$value["ID"],$type,$class,$link);
                        $this->html.='</li>';
                    }else{
                        $this->html.= '<li><a href="'.base_url("loai-san-pham/".$url.$value["Path"]).'" title="'.$value["Name"].'">'.$value["Name"].' <span class="count">('.$order.')</span></a>';
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