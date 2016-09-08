<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
    }

    public function index($cate_type = null) {
    	$user_id = $this->user_id;
        $this->data['is_main'] = true;
    	$category_type = new Category_Type();
        $where = array('Parent_ID' => 0);
        if(isset($cate_type) && $cate_type!=null){
            $category_type_check = new Category_Type();
            $category_type_check->where(array('Slug' => $cate_type))->get(1);
            if(isset($category_type_check->Parent_ID) && $category_type_check->Parent_ID == 0){
                $where = array('Parent_ID' => $category_type_check->ID);
                $this->data['is_main'] = false;
            }
        }
    	$category_type->where($where)->order_by('Sort','ASC')->get();
    	$list_item = array();
        if(isset($category_type) && $category_type!=null):
            foreach ($category_type as $key => $value) {
                $item = array();
                $category_type_id = $value->ID;
                $item['ID'] = $value->ID;
                $item['Name'] = $value->Name;
                $item['Slug'] = $value->Slug;
                $item['Images'] = $value->Images;
                $item['Icon'] = $value->Icon;
                $item['Path'] = $value->Path;
                $category_type_children = new Category_Type();
                $category_type_children->where(array('Parent_ID' => $category_type_id))->order_by('Sort','ASC')->get();
                $list_category_type_id = '('.$category_type_id.',';
                $item['cat_type_children'] = array();
                if(isset($category_type_children)){
                    foreach ($category_type_children as  $cat_item) {
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
                        ) rate ON rate.URL = concat('/product/details/',p.ID)
                        LEFT JOIN Tracking_Like AS tk ON tk.URL = concat('/product/details/',p.ID) AND tk.Member_ID = '$user_id'
                        LEFT JOIN Tracking AS t ON t.URL = concat('/product/details/',p.ID)
                        INNER JOIN Media AS m ON p.Featured_Image = m.ID
                        INNER JOIN Product_Price AS pr ON pr.Product_ID = p.ID
                        WHERE p.Type_ID IN $list_category_type_id AND p.Status='Publish'
                        GROUP BY p.ID
                        ORDER BY p.Createdat DESC
                        LIMIT 0,10";
               	//echo $sql_product_new;
               	//die;
                
                $product = $this->Common_model->query_raw($sql_product_new);
                $item['product_new'] = $product;

                $list_item[] = $item;
			}
		endif;
        $this->data['results'] = $list_item;
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/block/wrapper',$this->data);
        $this->load->view('fontend/block/footer',$this->data);
    }


    public function styled(){
        $data = array('status' => 'error');
        if(!$this->input->is_ajax_request()){
            die(json_encode($data));
        }
        $user_id = $this->user_id;
        $slug = $this->input->post('slug');
        $value = $this->input->post('value');
        if(!(isset($slug) && $slug!=null)){
            die(json_encode($data));
        }
        $category_type = new Category_Type();
        $category_type->where(array('Slug' => $slug))->get(1);
        if( !(isset($category_type->Slug) && $category_type->Slug!=null) ){
            die(json_encode($data));
        }

        $category_type_children = new Category_Type();
        $category_type_children->where(array('Parent_ID' => $category_type->ID))->order_by('Sort','ASC')->get();
        $list_category_type_id = '('.$category_type->ID.',';
        $item['cat_type_children'] = array();
        if(isset($category_type_children)){
            foreach ($category_type_children as  $cat_item) {
                $item_cat = array();
                $item_cat['ID'] = $cat_item->ID;
                $item_cat['Name'] = $cat_item->Name;
                $item_cat['Slug'] = $cat_item->Slug;
                $item['cat_type_children'][] = $item_cat;
                $list_category_type_id .= $cat_item->ID.',';
            }
        }
        $list_category_type_id .= '-1)';
        
        if(@$value == 'view'){
            $sql = "
                SELECT p.*,t.Num_View,t.Num_Comment,t.Num_Rate,t.Num_Like,t.Num_Share_Facebook,t.Num_Share_Google,m.Path_Thumb,rate.num_rate,tk.Is_Like
                FROM Products AS p
                LEFT JOIN (
                    SELECT AVG(Num_Rate) AS num_rate,URL
                    FROM Rate
                ) rate ON rate.URL = concat('/product/details/',p.ID)
                LEFT JOIN Tracking_Like AS tk ON tk.URL = concat('/product/details/',p.ID) AND tk.Member_ID = '$user_id'
                LEFT JOIN Tracking AS t ON t.URL = concat('/product/details/',p.ID)
                INNER JOIN Media AS m ON p.Featured_Image = m.ID
                INNER JOIN Product_Price AS pr ON pr.Product_ID = p.ID
                WHERE p.Type_ID IN $list_category_type_id AND p.Status='Publish'
                GROUP BY p.ID
                ORDER BY t.Num_View DESC
                LIMIT 0,10";
        }
        else if(@$value == 'sale'){
            $today = date('Y-m-d');
            $sql = "
                SELECT p.*,t.Num_View,t.Num_Comment,t.Num_Rate,t.Num_Like,t.Num_Share_Facebook,t.Num_Share_Google,m.Path_Thumb,rate.num_rate,tk.Is_Like
                FROM Products AS p
                LEFT JOIN (
                    SELECT AVG(Num_Rate) AS num_rate,URL
                    FROM Rate
                ) rate ON rate.URL = concat('/product/details/',p.ID)
                LEFT JOIN Tracking_Like AS tk ON tk.URL = concat('/product/details/',p.ID) AND tk.Member_ID = '$user_id'
                LEFT JOIN Tracking AS t ON t.URL = concat('/product/details/',p.ID)
                INNER JOIN Media AS m ON p.Featured_Image = m.ID
                INNER JOIN Product_Price AS pr ON pr.Product_ID = p.ID
                WHERE p.Type_ID IN $list_category_type_id AND p.Status='Publish' AND  $today BETWEEN pr.Special_Start AND pr.Special_End
                GROUP BY p.ID
                ORDER BY p.Createdat DESC
                LIMIT 0,10";
        }
        else{
            $sql = "
                SELECT p.*,t.Num_View,t.Num_Comment,t.Num_Rate,t.Num_Like,t.Num_Share_Facebook,t.Num_Share_Google,m.Path_Thumb,rate.num_rate,tk.Is_Like
                FROM Products AS p
                LEFT JOIN (
                    SELECT AVG(Num_Rate) AS num_rate,URL
                    FROM Rate
                ) rate ON rate.URL = concat('/product/details/',p.ID)
                LEFT JOIN Tracking_Like AS tk ON tk.URL = concat('/product/details/',p.ID) AND tk.Member_ID = '$user_id'
                LEFT JOIN Tracking AS t ON t.URL = concat('/product/details/',p.ID)
                INNER JOIN Media AS m ON p.Featured_Image = m.ID
                INNER JOIN Product_Price AS pr ON pr.Product_ID = p.ID
                WHERE p.Type_ID IN $list_category_type_id AND p.Status='Publish'
                GROUP BY p.ID
                ORDER BY p.Createdat DESC
                LIMIT 0,10";
        }
        $product = $this->Common_model->query_raw($sql);
        $data['status'] = 'success';
        $data['response'] = $this->load->view('fontend/home/styled',array('product' => $product),true);
        die(json_encode($data));
    }

    public function check() {
        die(json_encode($this->data));
    }
    public function events(){
        check_ajax();
        global $data;
        $id = $this->input->post("id");
        $ev = new Event();
        $event = $ev->get_event($id);
        $data["main"] = $event["Content"];
        $skin = preg_replace_callback('/{\$([a-zA-Z0-9_]+)}/i', create_function('$matches', 'global $data; return $data[$matches[1]];'), $event["Main"]);
        $event["Main"] =  $skin;
        die(json_encode($event));

    }
    public function get_events(){
        check_ajax();
        $date = date('Y-m-d');
        $ev = new Event();
        $all_event = $ev->get_all_is_user($this->is_login,$date);
        die(json_encode($all_event));
    }
    public function newsletter(){
        check_ajax();
        $data = ["success" => "error","messenger" => null]; 
        $date = date('Y-m-d');
        $token = uniqid();
        $nl = new Newsletter_Signup();
        $email = $this->input->post("Email");
        $check = $nl->where("Email",$email)->get_raw()->row_array();
        if( $check == null){
            $colums = $this->db->list_fields('Newsletter_Signup');
            $data_insert = $this->input->post();
            foreach ($data_insert as $key => $value) {
                if(in_array($key, $colums)){
                    $nl->{$key} = $value;
                }              
            }
            $nl->Createat = $date;
            $nl->Active = "0";
            $nl->Active_Day = null;
            $nl->Token = $token;
            $nl->save();
            $id = $nl->db->insert_id();
            if($id){
            	global $out_put;
                $out_put["token"] = trim($token); 
                $out_put["email"] = trim($email);
                $out_put["base_url"] = trim(base_url()); 
                $out_put["active_url"]= base_url("newsletter/activate?token=".$out_put["token"]."&amp;email=".$email."");
            	$e = new Email_Templates();
            	$tm = $e->where("Key","newsletter-templates")->get_raw()->row_array();
            	if($tm != null){
            		$skin = preg_replace_callback('/{{\$([a-zA-Z0-9_]+)}}/i', create_function('$matches', 'global $out_put; return $out_put[$matches[1]];'),$tm["Content"]);
            	}
                $skin =  $this->get_content($skin);
            	sendmail($email,"Đăng kí theo dõi bản tin của gianhangcuatoi",$skin);
            	$data["success"] = "success"; 
            	$data["messenger"] = "Đăng kí thành công, vui lòng kiểm tra hộp mail để xác nhận";
            }
            
        }else{
            $data["messenger"] = "Email này đã được sữ dụng vui lòng nhập một email khác!";
        }
        die(json_encode( $data ));
    }
    function get_content($string){
        // Create DOM from URL or file
        $html = $string;
        $doc = new DOMDocument();
        $doc->loadHTML($html);
        $tags_g = $doc->getElementsByTagName('img');
        foreach ($tags_g as $tag) {
            if(!strpos($tag->getAttribute('src'),"http//")){
                $html = str_replace($tag->getAttribute('src'),base_url($tag->getAttribute('src')),$html);
            }
        }
        return $html;
    }

}
