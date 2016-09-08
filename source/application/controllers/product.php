<?php
/*
  Created on : Feb 15, 2016, 7:00:18 PM
  Author     : phanquanghiep
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends CI_Controller {
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
        }
        $this->data["is_login"] = $this->is_login;
    }


    public function details($slug = null) {
        if ( !(isset($slug) && $slug != null)) {
            redirect(base_url());
            die;
        }
        $p = new Products();
        $check = $p->where(array('Slug' => $slug))->get(1);
        if ( !(isset($check->ID) && $check->ID != null) ) {
            redirect(base_url());
            die;
        }
        $url = '/product/details/'.$check->ID;
        $url_router = '/san-pham/'.$check->ID;
        $p_id = @$check->ID;
        $type_id = @$check->Type_ID;
        $this->data['current_url'] = base_url($url);
        $this->data['current_url_router'] = base_url($url_router);

        if($check->QrCode == null){
        	$qrcode_link = qrcode($this->data['current_url_router']);
        	$arr = array('QrCode' => $qrcode_link);
        	$p->where(array('ID' => $p_id))->update($arr);
        }

        require_once(APPPATH . 'controllers/view.php');
        $tracking_view = new View();
        $tracking_view->add($url);

        $member = new Member();
        $member->where(array('ID' => $check->Member_ID))->get(1);
        $this->data['member'] = $member;

        $facebook = $this->facebooke_get_share('https://api.facebook.com/method/links.getStats?urls='.base_url($url_router).'&format=json');
        $google   = $this->curl_get_count("https://clients6.google.com/rpc",'[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . base_url($url_router) . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
        $tracking = new Tracking();
        $tracking->where(array('URL' => $url))->get(1);
        if(isset($tracking->ID) && $tracking->ID != null ){
            $arr = array();
            if(isset($facebook[0]['share_count']) && is_numeric($facebook[0]['share_count'])){
                $arr['Num_Share_Facebook'] = $facebook[0]['share_count'];
            }
            if(isset($facebook[0]['commentsbox_count']) && is_numeric($facebook[0]['commentsbox_count'])){
                $arr['Num_Comment'] = $facebook[0]['commentsbox_count'];
            }
            if(isset($google[0]['result']['metadata']['globalCounts']['count']) && is_numeric($google[0]['result']['metadata']['globalCounts']['count'])){
                $arr['Num_Share_Google'] = $google[0]['result']['metadata']['globalCounts']['count'];
            }
            if(count($arr) > 0){
                $tracking->where(array('URL' => $url))->update($arr);
            }
        }
        else{
            $tracking = new Tracking();
            $tracking->URL = $url;
            $tracking->Num_Rate = 0;
            $tracking->Num_View = 0;
            $tracking->Num_Comment = isset($facebook[0]['comment_count']) && is_numeric($facebook[0]['comment_count']) ? $facebook[0]['comment_count'] : 0;;
            $tracking->Num_Share_Facebook = isset($facebook[0]['share_count']) && is_numeric($facebook[0]['share_count']) ? $facebook[0]['share_count'] : 0;
            $tracking->Num_Share_Google = isset($google[0]['result']['metadata']['globalCounts']['count']) && is_numeric($google[0]['result']['metadata']['globalCounts']['count']) ? $google[0]['result']['metadata']['globalCounts']['count'] : 0;
            $tracking->save();
        }

        $check_member_viewed = $this->input->cookie('member_viewed',true);
        if(isset($check_member_viewed) && $check_member_viewed != null){
            $history = json_decode($check_member_viewed,true);
            $product_history = $history['product'];
            if(!in_array($check->ID, $product_history)){
                $product_history[] = $check->ID;
            }
            $history['product'] = $product_history;
            $cookie= array(
              'name'   => 'member_viewed',
              'value'  => json_encode($history),
              'expire' => '86500'
            );
            $this->input->set_cookie($cookie);
        }
        else{
            $product_history = array();
            $product_history[] = $check->ID;
            $arr = array(
                "product" => $product_history,
                "stand"   => array()
            );
            $cookie= array(
              'name'   => 'member_viewed',
              'value'  => json_encode($arr),
              'expire' => '86500'
            );
            $this->input->set_cookie($cookie);
        }
        if($this->is_login){
            $session_id = $this->session->userdata('session_id');
            $member_viewed = new Member_Viewed();
            $member_viewed->where(array('Member_ID' => $this->user_id,'Session_ID' => $session_id ,'URL' => $url))->get(1);

            $member_viewed1 = new Member_Viewed();
            $member_viewed1->where(array('Member_ID' => $this->user_id,'Date_Created' => date('Y-m-d H:i:s') ,'URL' => $url))->get(1);
            if( !(isset($member_viewed->ID) && $member_viewed->ID != null) &&  !(isset($member_viewed1->ID) && $member_viewed1->ID != null)){
                $member_viewed = new Member_Viewed();
                $member_viewed->add_viewed($this->user_id,$url,$session_id);
            }
        }

        $product = $p->get_product_details_new($slug,$this->user_id);
        $this->data["product"] = $product;
        $m = new Media();
        $media_record  = $m->where("ID",@$product["Featured_Image"])->get_raw()->row_array();
        $gallery = new Media_Product();
        $attribute_value = new Attribute_Value();
        $product_keyword = new Product_Keyword();
        $keyword = $product_keyword->get_by_product($p_id);
        $list_keyrowd = array();
        if(isset($keyword) && $keyword != null ){
            foreach ($keyword as $key => $value) {
                 $list_keyrowd[] = $value['Name'];
            }
        }
        if(count($list_keyrowd) > 0){
        	$this->data['results'] = $p->get_product_by_keyword($type_id,$list_keyrowd,$this->user_id,$p_id,0,8);
        }
        $this->data['gallery'] = $gallery->get_by_product($p_id);
        $this->data["featured"] = @$media_record["Path"];             
        $this->data['attribute'] = $attribute_value->get_by_product_id($p_id);
        $this->data['product_by_user'] = $p->get_product_by_member($type_id,$this->user_id,$p_id);
        $this->data['keyword'] = $keyword;
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/product/index', $this->data);
        $this->load->view('fontend/block/footer');
    }


    public function add_product(){
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/product/add');
        $this->load->view('fontend/block/footer');
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
            $check_attribute_group = $attribute_group->check_in_cat($name,$check_category["ID"]);
            if (count($check_attribute_group) > 0) {
                $data["slug"] = $check_attribute_group["Slug"];
            } else {
                $check = $attribute_group->where("Name",$name)->get_raw()->row_array();              
                if($check == null){
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
                    $id = $attribute_group->db->insert_id(); 
                }else{
                    $id =  $check["ID"];
                }
                $atct = new Attribute_Group_Category_Type();
                $atct->Attribute_Group_ID = $id;
                $atct->Category_Type_ID = $check_category["ID"];
                $atct->Createat = $datime;
                $atct->save();
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
            $check = $p->where(array(
                        "ID" => $id,
                        "Member_ID" => $this->user_id
                    ))->get_raw()->row_array();
            if ($check !== null) {
                $ctp = new Product_Category();
                $cat_all_id = $ctp->where("Product_ID", $id)->select("Term_ID")->get_raw()->result_array();
                $cat_id[] = -1;
                foreach ($cat_all_id as $key => $value) {
                    $cat_id [] = $value["Term_ID"];
                }
                $attribute_id[] = -1;
                $a_value = new Attribute_Value();
                $attr_arg = $a_value->where("Product_ID", $id)->select("Attribute_ID")->get_raw()->result_array();
                if ($attr_arg != null) {
                    foreach ($attr_arg as $key => $value) {
                        $attribute_id [] = $value["Attribute_ID"];
                    }
                }
                $a_update = new Attribute();
                $a_update->update_order($attribute_id, -1);
                $ct = new Categories();
                $ct->update_order($cat_id, -1);
                $this->db->delete("Attribute_Value", array('Product_ID' => $id));
                $this->db->delete("Products", array('ID' => $id, "Member_ID" => $this->user_id));
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
            $check = $p->where(array(
                        "ID" => $id,
                        "Member_ID" => $this->user_id
                    ))->get_raw()->row_array();
            if ($check !== null) {
                $data_update = 0;
                if ($check["Disable"] == 0) {
                    $data_update = 1;
                }
                $data["success"] = "success";
                $p->where("ID", $id)->update(array("Disable" => $data_update));
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

    private function curl_get_count($url,$postvars = ''){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_POST, 1);//0 for a get request
        curl_setopt($ch,CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch,CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        $response = curl_exec($ch);
        curl_close ($ch);
        if(count(json_decode($response,true)) > 0){
            return json_decode($response,true);
        }
        return null;
    }

    private function facebooke_get_share($url) {
      $response = @file_get_contents($url);
      if(count(json_decode($response,true)) > 0){
        return json_decode($response,true);
      }
      return null;
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
}

