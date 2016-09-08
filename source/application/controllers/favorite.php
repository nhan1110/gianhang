<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Favorite extends CI_Controller {

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
        }

        if(!$this->is_login){
            if (!$this->input->is_ajax_request()) {
               redirect(base_url());
            }
            else{
                die(json_encode(array('status' => 'error')));
            }
        }
        $this->data["is_login"] = $this->is_login;
        $this->data["user_info"] = $this->user_info; 
    }

    public function index(){
        $favorite = new Pin_Model();
        $per_page = 12;
        $offset = $this->uri->segment(2)!=null ? $this->uri->segment(3) : 0;
        $count_favorite = $favorite->where(array('Member_ID' => $this->user_id))->count();
        $result = $favorite->order_by('Name','ASC')->get_where(array('Member_ID' => $this->user_id),$per_page,$offset);
        $ct = new Category_Type();
        $ct->where(array('Parent_ID' => '0'))->get();

        $arr['base_url'] = base_url('/yeu-thich/trang/');
        $arr['total_rows'] = $count_favorite;
        $arr['per_page'] = $per_page;
        $arr["segment"] = 2;
        $config = get_paging($arr);
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $this->data['result'] = $result;
        $this->data['count'] = $count_favorite;
        $this->data['cat'] = $ct;
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/favorite/index',$this->data);
        $this->load->view('fontend/block/footer',$this->data);
    }

    public function view($slug = null){
        if( !(isset($slug) && $slug!=null) ){
            redirect(base_url('/yeu-thich/'));
            die;
        }
        $favorite = new Pin_Model();
        $favorite->where(array('Slug' => $slug, 'Member_ID' => $this->user_id))->get(1);
        if( !(isset($favorite->ID) && $favorite->ID != null) ){
            redirect(base_url('/yeu-thich/'));
            die;
        }
        $cat_favorite = new Pin_Model();
        $cat_favorite->where(array('Type_ID' => $favorite->Type_ID, 'Member_ID' => $this->user_id))->get();

        $category_type = new Category_Type();
        $category_type->where(array('Parent_ID' => '0','ID' => $favorite->Type_ID))->get(1);
        $favorite_product = new Pin_Product();
        $product = $favorite_product->get_product_by_favorite($favorite->ID);
        $this->data['favorite'] = $favorite;
        $this->data['cat_favorite'] = $cat_favorite;
        $this->data['cate_type'] = $category_type;
        $this->data['result'] = $product;
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/favorite/view',$this->data);
        $this->load->view('fontend/block/footer',$this->data);
    }

    public function add(){
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $name = $this->input->post('name');
        $type = $this->input->post('type');
        $ct = new Category_Type();
        $ct->where(array('Parent_ID' => '0','ID' => $type))->get(1);
        if( !(isset($ct) && $ct->ID!=null) ){
            $data['status'] = 'fail';
            $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
            die(json_encode($data));
        }

        if( !(isset($name) && trim($name)!=null && trim($name)!='') ){
            $data['status'] = 'fail';
            $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
            die(json_encode($data));
        }
        $this->load->library('Helperclass');
        $favorite = new Pin_Model();
        $slug = $this->helperclass->slug($favorite->table, "Slug", trim($name),array('Member_ID' => $this->user_id));
        $favorite->Name = trim($name);
        $favorite->Slug = $slug;
        $favorite->Banner = '';
        $favorite->Member_ID = $this->user_id;
        $favorite->Type_ID = $type;
        $favorite->Date_Created = date('Y-m-d H:i:s');
        if($favorite->save()){
            $data['status'] = 'success';
        }

        $cat_favorite = new Pin_Model();
        $cat_favorite->where(array('Type_ID' => $type, 'Member_ID' => $this->user_id))->get();
        $responsive = array();
        if(isset($cat_favorite->ID) && $cat_favorite->ID != null){
            foreach ($cat_favorite as $key => $value) {
                $temp = array(
                    'id' => @$value->ID,
                    'name' => @$value->Name
                );
                $responsive[] = $temp;
            }
        }
        $data['responsive'] = $responsive;

        die(json_encode($data));
    }

    public function edit(){
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $slug = $this->input->post('slug');
        $name = $this->input->post('name');
        if( !(isset($slug) && $slug!=null)  || !(isset($name) && trim($name)!=null) ){
           die(json_encode($data));
        }
        $favorite = new Pin_Model();
        $favorite->where(array('Slug' => $slug, 'Member_ID' => $this->user_id))->get(1);
        if( !(isset($favorite->ID) && $favorite->ID != null) ){
            die(json_encode($data));
        }
        $this->load->library('Helperclass');
        $slug = $this->helperclass->slug($favorite->table, "Slug", trim($name),array('Member_ID' => $this->user_id));
        $arr = array(
            'Name' => $name,
            'Slug' => $slug
        );
        $favorite->where(array('ID' => $favorite->ID))->update($arr);
        $data['status'] = 'success';
        die(json_encode($data));
    }   

    public function delete($slug = null){
        if( !(isset($slug) && $slug!=null) ){
            redirect(base_url('/yeu-thich/'));
            die;
        }
        $favorite = new Pin_Model();
        $favorite->where(array('Slug' => $slug, 'Member_ID' => $this->user_id))->get(1);
        if( !(isset($favorite->ID) && $favorite->ID != null) ){
            redirect(base_url('/yeu-thich/'));
            die;
        }
        if (isset($favorite->Banner) && $favorite->Banner != null) {
            if(file_exists('.' . $favorite->Banner)){
                @unlink('.' . $favorite->Banner);
            }
        }
        $favorite->delete_by_id($favorite->ID);
        redirect(base_url('/yeu-thich/'));
        die;
    }

    public function delete_item($slug = null , $product_id = null){
        if( !(isset($slug) && $slug!=null) ){
            redirect(base_url('/yeu-thich/'));
            die;
        }
        $favorite = new Pin_Model();
        $favorite->where(array('Slug' => $slug, 'Member_ID' => $this->user_id))->get(1);
        if( !(isset($favorite->ID) && $favorite->ID != null) ){
            redirect(base_url('/yeu-thich/'));
            die;
        }
        $pin_product = new Pin_Product();
        $pin_product->delete_by_id($favorite->ID,$product_id);
        redirect(base_url('/yeu-thich/chuyen-muc/'.$slug));
        die;
    }

    public function change_banner(){
        $data = array('status' => 'error');
        $slug = $this->input->post('slug');
        if( !(isset($slug) && $slug!=null) || !$this->input->is_ajax_request() ){
           die(json_encode($data));
        }
        $favorite = new Pin_Model();
        $favorite->where(array('Slug' => $slug, 'Member_ID' => $this->user_id))->get(1);
        if( !(isset($favorite->ID) && $favorite->ID != null) ){
            die(json_encode($data));
        }
        if($this->input->post()){
            if (isset($_FILES['fileupload']) && is_uploaded_file($_FILES['fileupload']['tmp_name'])) {
                $output_dir = "./uploads/favorite/";
                $output_url = "/uploads/favorite/";
                $filename = $_FILES['fileupload']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION); //type image
                $RandomNum = time();
                $ImageName = str_replace(' ', '-', strtolower($_FILES['fileupload']['name']));
                $ImageType = $_FILES['fileupload']['type']; //"image/png", image/jpeg etc.
                $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt = str_replace('.', '', $ImageExt);
                $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $output_dir . $NewImageName)) {
                    $data1 = crop_image($NewImageName, $ext, $output_url);
                    if ($data1["status"] = "success") {
                        if (isset($favorite->Banner) && $favorite->Banner != null && $favorite->Banner != $output_url) {
                            if(file_exists('.' . $favorite->Banner)){
                                @unlink('.' . $favorite->Banner);
                            }
                        }
                        $banner = $output_url . $data1["name"];;

                        if ($favorite->where(array('ID' => $favorite->ID))->update('Banner', $banner)) {
                            $data['banner'] = $output_url . $data1["name"];
                        }
                        $data["status"] = "success";
                    }
                }
            }
        }
        die(json_encode($data));
    }


    public function move(){
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $product_id = $this->input->post('product_id');
        $favorite_id = $this->input->post('favorite_id');
        $cat_current_id = $this->input->post('cat_current_id');

        $favorite = new Pin_Model();
        $favorite->where(array('ID' => $favorite_id, 'Member_ID' => $this->user_id))->get(1);
        if( !(isset($favorite->ID) && $favorite->ID != null) ){
            $data['status'] = 'fail';
            $data['message'] = 'Chuyên mục không tồn tại.';
            die(json_encode($data));
        }

        $pin_product = new Pin_Product();
        $pin_product->where(array('Product_ID' => $product_id , 'Pin_ID' => $cat_current_id))->get(1);
        if( !(isset($pin_product->ID) && $pin_product->ID != null) ){
            $data['status'] = 'fail';
            $data['message'] = 'Chuyên mục hoặc sản phẩm không tồn tại.';
            die(json_encode($data));
        }

        $arr = array('Pin_ID' => $favorite_id , 'Product_ID' => $product_id);
        $pin_product->where($arr)->get(1);
        if( !(isset($pin_product->ID) && $pin_product->ID != null) ){
            $pin_product->where(array('Pin_ID' => $cat_current_id , 'Product_ID' => $product_id))->update($arr);
            $data['status'] = 'success';
        }
        else{
            $data['status'] = 'fail';
            $data['message'] = 'Sản phẩm này đã tồn tại trong chuyên mục.';
        }
        die(json_encode($data));
    }

    public function get_favorite(){
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $product_id = $this->input->post('product_id');
        $product = new Products();
        $product->where(array('ID' => $product_id))->get(1);
        if( !(isset($product->Type_ID) && $product->Type_ID !=null) ){
            die(json_encode($data));
        }

        $category_type_id = $product->Type_ID;

        $cat = new Category_Type();
        $cat->where(array('ID' => $category_type_id))->get(1);
        if( !(isset($cat->Parent_ID) && $cat->Parent_ID !=null) ){
            die(json_encode($data));
        }
        $cat_favorite = new Pin_Model();
        $cat_favorite->where(array('Type_ID' => $cat->Parent_ID, 'Member_ID' => $this->user_id))->get();
        
        $data['favorite_type_id'] = $cat->Parent_ID;
        
        $responsive = array();
        if(isset($cat_favorite->ID) && $cat_favorite->ID != null){
            foreach ($cat_favorite as $key => $value) {
                $temp = array(
                    'id' => @$value->ID,
                    'name' => @$value->Name
                );
                $responsive[] = $temp;
            }
        }

        $data['status'] = 'success';
        $data['responsive'] = $responsive;
        die(json_encode($data));
    }

    public function add_product(){
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $product_id = $this->input->post('product_id');
        $favorite_id = $this->input->post('favorite_id');

        $favorite = new Pin_Model();
        $favorite->where(array('ID' => $favorite_id, 'Member_ID' => $this->user_id))->get(1);
        if( !(isset($favorite->ID) && $favorite->ID != null) ){
            $data['status'] = 'fail';
            $data['message'] = 'Chuyên mục không tồn tại.';
            die(json_encode($data));
        }

        $pin_product = new Pin_Product();
        $arr = array('Pin_ID' => $favorite_id , 'Product_ID' => $product_id);
        $pin_product->where($arr)->get(1);
        if( !(isset($pin_product->ID) && $pin_product->ID != null) ){
            $pin_product = new Pin_Product();
            $pin_product->Pin_ID = $favorite_id;
            $pin_product->Product_ID = $product_id;
            $pin_product->Date_Created = date('Y-m-d H:i:s');
            $pin_product->save();
            $data['url'] = base_url('/yeu-thich/chuyen-muc/'.@$favorite->Slug);
            $data['name'] = @$favorite->Name;
            $data['status'] = 'success';
        }
        else{
            $data['status'] = 'fail';
            $data['message'] = 'Sản phẩm này đã tồn tại trong chuyên mục.';
        }
        die(json_encode($data));
    }
}