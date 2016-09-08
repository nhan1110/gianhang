<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends CI_Controller {
    private $is_login = false;
    private $user_info = array();
    private $user_id = 0;
    private $data = array();
    private $type_member = "Member";
    private $tree_select = "";

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
        $this->data["user_info"] = $this->user_info;
    }

    public function index() {
        $this->data['title'] = 'Thông tin tài khoản';
        $user_id = $this->user_id;
        $member = new Member();
        $member->where('ID', $user_id)->get(1);
        $this->data['member'] = $member;
        $this->load->view('fontend/profile/backend/header', $this->data);
        $this->load->view('fontend/profile/backend/profile', $this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    public function edit() {
        $user_id = $this->user_id;
        $member = new Member();
        $member->where('ID', $user_id)->get(1);
        $this->data['member'] = $member;
        $this->data['title'] = 'Chỉnh sữa thông tin tài khoản';
        $this->data['action'] = base_url('/profile/edit');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        if($this->input->post()){
            $m = new Member();
            $arr = array(
                'Firstname' => $this->input->post('first_name'),
                'Lastname'  => $this->input->post('last_name'),
                'Address'  => $this->input->post('address'),
                'Phone'  => $this->input->post('phone'),
                'Lat'  => $this->input->post('lat'),
                'Lng'  => $this->input->post('lng'),
                'Updateat' => date('Y-m-d H:i:s')
            );

            if ($this->form_validation->run() === FALSE) {
                $this->data['error'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else{
                if( $m->where(array('ID' => $this->user_id))->update($arr) ){
                    $this->data['success'] = 'Trang đã được chỉnh sữa thành công.';
                    redirect(base_url('/profile/edit/'));
                }
                else{
                     $this->data['error'] = 'Lỗi khi thực hiện.';
                }
            }
        }
        $this->load->view('fontend/profile/backend/header', $this->data);
        $this->load->view('fontend/profile/backend/profile-edit', $this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    public function update_profile() {
        $user_id = $this->user_id;
        $member = new Member();
        $member->where('ID', $user_id)->get(1);
        $this->data['member'] = $member;
        $this->data['title'] = 'Chỉnh sữa thông tin tài khoản';
        $this->data['action'] = base_url('/tai-khoan/chinh-sua-thong-tin');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'Họ đệm', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Tên', 'trim|required');
        $this->form_validation->set_rules('address', 'Địa chỉ', 'trim|required');
        $this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required');
        if($this->input->post()){
            $m = new Member();
            $arr = array(
                'Firstname' => $this->input->post('first_name'),
                'Lastname'  => $this->input->post('last_name'),
                'Address'  => $this->input->post('address'),
                'Phone'  => $this->input->post('phone'),
                'Lat'  => $this->input->post('lat'),
                'Lng'  => $this->input->post('lng'),
                'Updateat' => date('Y-m-d H:i:s')
            );

            if ($this->form_validation->run() === FALSE) {
                $this->data['error'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else{
                if( $m->where(array('ID' => $this->user_id))->update($arr) ){
                    $this->data['success'] = 'Trang đã được chỉnh sữa thành công.';
                    redirect(base_url('/tai-khoan/chinh-sua-thong-tin'));
                }
                else{
                     $this->data['error'] = 'Lỗi khi thực hiện.';
                }
            }
        }
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/account/update_profile', $this->data);
        $this->load->view('fontend/block/footer',$this->data);
    }

    public function chang_password() {
        $user_id = $this->user_id;
        $member = new Member();
        $member->where('ID', $user_id)->get(1);
        $this->data['title'] = 'Thay đổi mật khẩu';
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');
            if ($this->form_validation->run() === FALSE) {
                $this->data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else{
                $password = $this->input->post('password');
                $confirm_password = $this->input->post('confirm_password');
                if (strlen($password) < 6){
                    $this->data["message"] = "Mật khẩu tối thiểu 6 ký tự. Vui lòng nhập lại.";
                }
                else{
                    if ($password != $confirm_password){
                        $this->data["message"] = "Mật khẩu phải trùng với phần xác nhận lại mật khẩu. Vui lòng nhập lại.";
                    }
                    else{
                        $arr = array(
                            'Pwd'   => md5(md5($member->Email) . md5($password))
                        );
                        $member->where('Email', $member->Email)->update($arr);
                        $this->data['success'] = 'Mật khẩu đã thay đổi đổi thành công.';
                    }
                }
            }
        }
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/account/change_password', $this->data);
        $this->load->view('fontend/block/footer',$this->data);
    }

    public function save_media() {
        $data = array('status' => 'error');
        $user_id = $this->user_id;
        $member = new Member();
        $member->where('ID', $user_id)->get(1);
        if ($this->input->is_ajax_request() && isset($member->ID) && $member->ID != null) {
            if (isset($_FILES['fileupload']) && is_uploaded_file($_FILES['fileupload']['tmp_name'])) {
                $output_dir = "./uploads/user/";
                $output_url = "/uploads/user/";
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
                        if (isset($member->Avatar) && $member->Avatar != null ) {
                            if(!preg_match("~^(?:f|ht)tps?://~i", $member->Avatar)){
                                if(file_exists('.' . $member->Avatar)){
                                    unlink('.' . $member->Avatar);
                                }
                            }
                        }
                        $vatar = $output_url . $data1["name"];

                        $arrs = $this->session->userdata('user_info');
                        $arrs['avatar'] = $output_url . $data1["name"];
                        $this->session->set_userdata('user_info', $arrs);

                        if ($member->update('Avatar', $vatar)) {
                            $data['name'] = $output_url . $data1["name"];
                        }
                        $data["status"] = "success";
                    }
                }
            }
        }

        die(json_encode($data));
    }

    public function logout() {
        //$this->Common_model->delete("user_activity", array("user_id" => $this->user_id));
        $this->session->unset_userdata('user_info');
        $this->session->unset_userdata('ci_session');
        redirect(base_url());
    }

    /*Product*/
    public function myproduct() {
        $user_id = $this->user_id;
        $member = new Member();
        $member->where('ID', $user_id)->get(1);
        $this->data['member'] = $member;
        $this->data['title'] = 'Sản phẩm';

        $p =  new Products();
        $media = new Media();
        $sql = "SELECT p.*,m.Path_Large 
                FROM $p->table AS p 
                LEFT JOIN $media->table AS m ON m.ID = p.Featured_Image ";
        $like = '';
        if($this->input->get('q')){
            $title = $this->input->get('q');
            $like .="AND p.Name LIKE '%".$title."%'";
        }
        
        $per_page = 20;
        $offset = $this->uri->segment(3) == '' ? 0 : $this->uri->segment(3);
        $sql .= "WHERE p.Member_ID = $this->user_id  ". $like ." ORDER BY p.Createdat DESC";// LIMIT $offset , $per_page";
        $p->query($sql);
        $this->data['product'] = $p;

        $this->load->library('pagination');
        $product =  new Products();
        if($this->input->get('q')){
            $product->like('Name',$this->input->get('q'));
        }
        $count = $product->where('Member_ID',$this->user_id)->count();
        $config['base_url'] = base_url().'profile/myproduct/';
        $config['total_rows'] = $count;
        $config['per_page'] = $per_page; 
        $config['segment'] = 3;
        $this->pagination->initialize(get_paging($config));

        $this->load->view('fontend/profile/backend/header',$this->data);
        $this->load->view('fontend/profile/backend/myproduct',$this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    public function my_product($page = 0) {
        $user_id = $this->user_id;
        $per_page = 5;
        $member = new Member();
        $member->where('ID', $user_id)->get(1);
        $this->data['member'] = $member;
        $this->data['title'] = 'Sản phẩm';
        $this->data["user_id"] = $user_id;
        $p = new Products();
        $this->data["record_product"] = $p->get_product_by_user($user_id);
        //$this->data["record_product"] = $p->get_product_by_user($user_id,$page, $per_page);
        $this->load->library('pagination');
        $config['base_url'] = base_url('profile/my_product/');
        $config['total_rows'] = count($p->get_product_by_user($user_id));
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
        $this->pagination->initialize($config); 
        $this->load->view('fontend/profile/backend/header',$this->data);
        $this->load->view('fontend/profile/products/my_product', $this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    public function add_product() {
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
                $this->load->view('fontend/profile/backend/header', $this->data);
                $this->load->view('backend/products/add-edit', $this->data);
                $this->load->view('fontend/profile/backend/footer',$this->data);

            } else {
                redirect(base_url("admin/product/add"));
            }
        } else {
            $category_Type = new Category_Type();
            $table = $category_Type->get_raw()->result_array();
            $table_tree = "";
            $this->data["all_cat_type"] = "";
            $table_tree = $this->get_option_type($table, 0, "Parent_ID");
            $this->data["all_cat_type"] = $table_tree;
            $this->load->view('fontend/profile/backend/header', $this->data);
            $this->load->view('fontend/profile/products/before', $this->data);
            $this->load->view('fontend/profile/backend/footer',$this->data);
        }
    }

    public function edit_product($slug = null) {
       $user_id = $this->user_id;
        $member = new Member();
        $member->where('ID', $user_id)->get(1);
        $this->data ["text_button"] = " Thêm mới";
        $this->data['title'] = 'Edit Product';
        $this->data['member'] = $member;
        $this->data ["text_button"] = " Cập nhật";
        $this->data["title_curent"] = "Edit Product";
        if ($this->input->post()) {
            $slug_product = trim($this->input->post("product_slug"));
            $p = new Products();
            $check_product = $p->where(array("Slug" => $slug_product, "Member_ID" => $this->user_id))->get_raw()->row_array();
            if ($check_product != null) {
                $product_id = $check_product["ID"];
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
                $this->load->library('Helperclass');
                if ($check["check"] == true && $category != false && count($category) > 0 && is_array($check_type) && count($check_type) > 0) {
                    $datime = date('Y-m-d H:i:s');
                    $general = $this->input->post("general");
                    $price = $this->input->post("price");
                    $media = $this->input->post("media");
                    $attribute = $this->input->post("attribute");
                    $data_insert["Name"] = trim($general["name"]);
                    $address_path = $address["city"];
                    $k = new Keywords();
                    $kp = new Product_Keyword();
                    $all_k_p = $kp->where("Product_ID",$product_id)->get_raw()->result_array();
                    $all_k_p_id = [];
                    if($all_k_p != null){
                        foreach ($all_k_p as $key => $value_kw) {
                            $all_k_p_id [] = $value_kw["Keyword_ID"];
                        }
                    }
                    if($all_k_p_id  != null){
                        $k->update_order($all_k_p_id,-1);
                    }
                    $this->db->delete("Product_Keyword", array("Product_ID" => $product_id));
                    if (is_array($tags) && $tags != null) {
                        foreach ($tags as $key => $value) {
                            $check_keyword = $k->where("Name", trim($value))->get_raw()->row_array();
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
                    $country = new Country();
                    $path_country = $check_product["Path_Adderss"];
                    if($path_country != null){
                        $arg_slug_country = explode("/", $path_country);
                        $arg_slug_country = array_diff($arg_slug_country, array(''));
                        foreach ($arg_slug_country as $key => $value) {
                            $country->update_order(array($value),-1);
                        }
                    }
                    if (trim($address_path) != "{[-]}") {
                        $arg_country = $country->where("ID", $address_path)->get_raw()->row_array();
                        if ($arg_country != null) {
                            $address_path = $arg_country["Path"];
                            if($address_path != null){
                                $arg_slug_country = explode("/", $address_path);
                                $arg_slug_country = array_diff($arg_slug_country, array(''));
                                foreach ($arg_slug_country as $key => $value) {
                                    $country->update_order(array($value),1);
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
                            $ct = new Categories();
                            $product_categories = new Product_Category();
                            //delete category 
                            $cat_update [] = -1;
                            $arg_id = $product_categories->where("Product_ID", $product_id)->select("Term_ID")->get_raw()->result_array();
                            if ($arg_id != null) {
                                foreach ($arg_id as $value) {
                                    $cat_update [] = $value ["Term_ID"];
                                }
                            }
                            $ct->update_order($cat_update, -1);
                            $this->db->delete('Product_Category', array('Product_ID' => $product_id));
                            $tem_id [] = -1;
                            foreach ($category as $key => $value) {
                                if (is_numeric($value)) {
                                    $tem_id [] = $value;
                                    $product_categories->Product_ID = $product_id;
                                    $product_categories->Term_ID = $value;
                                    $product_categories->save();
                                }
                            }
                            $ct->update_order($tem_id, 1);
                        }
                        $list_photos = explode(",", $media["list_photos"]);
                        $list_photos = array_diff($list_photos, array(''));
                        $list_photos = array_unique($list_photos);
                        $media_product = new Media_Product();
                        //delete media 
                        $media_product->db->delete('Media_Product', array('Product_ID' => $product_id));
                        foreach ($list_photos as $key => $value) {
                            if (is_numeric($value)) {
                                $media_product->Media_ID = $value;
                                $media_product->Product_ID = $product_id;
                                $media_product->save();
                            }
                        }
                        $product_price = new Product_Price();     
                        $update_price["Product_ID"] = $product_id;
                        $update_price["Price"] = @$price["price_product"];
                        $update_price["Special_Price"] = (isset($price["special_price"]) ) ? $price["special_price"] : "";
                        $update_price["Special_Start"] = null;
                        $update_price["Special_End"] = null;
                        $update_price["Is_Main"] = $price["type_price"];
                        $update_price["Number_Price"] = str_replace(".","",$price["price_product"]);
                        $product_price->where("Product_ID", $product_id)->update($update_price);
                        $attribute_value = new Attribute_Value();
                        $a_update = new Attribute();
                        if (is_array($attribute) && count($attribute) > 0) {
                            $key_attr = 0;
                            $id_attribute_update_order_1[] = -1;
                            $id_attribute_update_order_2[] = -1;
                            foreach ($attribute as $key => $value) {
                                $key_attr = explode("-", $key);
                                $check_attribute_value = null;
                                $get_text = $attribute_value->where(
                                    array(
                                        "Attribute_ID" => $key_attr[1],
                                        "Product_ID" => $product_id,
                                        "Group_ID"   => $key_attr[0]
                                    )
                                )->get_raw()->row_array();
                                if($get_text != null){
                                    $arg_text_attr = explode("{[-]}", $get_text["Value"]);
                                    if($arg_text_attr != null){
                                        $get_attr_id =  $a_update->where( 
                                            array(
                                                "Parent_ID" => $key_attr[1] , 
                                                "Order >" => "0"
                                            )
                                        )->where_in("Name",$arg_text_attr)->get_raw()->result_array();
                                        $in_id_attr = array();
                                        foreach ($get_attr_id as $key => $value_2) {
                                            $in_id_attr [] = $value_2["ID"];
                                        }
                                        if($in_id_attr != null){
                                            $a_update->update_order($in_id_attr,-1);
                                        }
                                    }
                                }
                                if (count($key_attr) > 1) {
                                    $check_attribute_value = $attribute_value->where(
                                                array(
                                                    "Attribute_ID" => $key_attr[1],
                                                    "Product_ID" => $product_id,
                                                    "Group_ID" => $key_attr[0]
                                                )
                                            )->get_raw()->result_array();
                                }
                                if (count($key_attr) == 2) {
                                    if (count($value) == 1) {
                                        if (trim($value[0]) !== "" && trim($value[0]) != "{[-]}") {
                                            if ($check_attribute_value != null && count($check_attribute_value) == 1) {
                                                $update_attribute["Value"] = $value[0];
                                                $attribute_value->where(
                                                        array(
                                                            "Attribute_ID" => $key_attr[1],
                                                            "Product_ID" => $product_id,
                                                            "Group_ID" => $key_attr[0]
                                                        )
                                                )->update($update_attribute);
                                            } else {
                                                $attribute_value->Attribute_ID = is_numeric($key_attr[1]) ? $key_attr[1] : 0;
                                                $attribute_value->Product_ID = $product_id;
                                                $attribute_value->Value = $value[0];
                                                $attribute_value->Group_ID = is_numeric($key_attr[0]) ? $key_attr[0] : 0;
                                                $attribute_value->save();
                                                if (is_numeric($key_attr[1])) {
                                                    $id_attribute_update_order_1[] = $key_attr[1];
                                                }
                                            }
                                        } else {
                                            $filter = array(
                                                "Attribute_ID" => $key_attr[1],
                                                "Product_ID" => $product_id,
                                                "Group_ID" => $key_attr[0]
                                            );
                                            $this->db->delete("Attribute_Value", $filter);
                                            if (is_numeric($key_attr[1])) {
                                                $id_attribute_update_order_2[] = $key_attr[1];
                                            }
                                        }
                                    }
                                    if (count($value) > 1) {
                                        $new_value = array_diff($value, array(''));
                                        if (count($new_value) > 0) {
                                            $get_attr_id =  $a_update->where( 
                                                array(
                                                    "Parent_ID" => $key_attr[1]
                                                )
                                            )->where_in("Name",$new_value)->get_raw()->result_array();
                                            $in_id_attr = array();
                                            foreach ($get_attr_id as $key => $value_3) {
                                                $in_id_attr [] = $value_3["ID"];
                                            }
                                            if($in_id_attr != null){
                                                 $a_update->update_order($in_id_attr,1);
                                            }
                                            $new_value = implode("{[-]}", $new_value);
                                            $new_value = str_replace("{[-]}{[-]}", "", $new_value);
                                            if ($new_value != "") {
                                                if ($check_attribute_value != null && count($check_attribute_value) == 1) {
                                                    $update_attribute["Value"] = $new_value;
                                                    $attribute_value->where(
                                                            array(
                                                                "Attribute_ID" => $key_attr[1],
                                                                "Product_ID" => $product_id,
                                                                "Group_ID" => $key_attr[0]
                                                            )
                                                    )->update($update_attribute);
                                                } else {
                                                    $attribute_value->Attribute_ID = is_numeric($key_attr[1]) ? $key_attr[1] : 0;
                                                    $attribute_value->Product_ID = $product_id;
                                                    $attribute_value->Value = $new_value;
                                                    $attribute_value->Group_ID = is_numeric($key_attr[0]) ? $key_attr[0] : 0;
                                                    $attribute_value->save();
                                                    if (is_numeric($key_attr[1])) {
                                                        $id_attribute_update_order_1[] = $key_attr[1];
                                                    }
                                                }
                                            } else {
                                                $filter = array(
                                                    "Attribute_ID" => $key_attr[1],
                                                    "Product_ID" => $product_id,
                                                    "Group_ID" => $key_attr[0]
                                                );
                                                $this->db->delete("Attribute_Value", $filter);
                                                if (is_numeric($key_attr[1])) {
                                                    $id_attribute_update_order_2[] = $key_attr[1];
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $a_update->update_order($id_attribute_update_order_1, 1);
                            $a_update->update_order($id_attribute_update_order_2, -1);
                        }
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
        if ($this->input->get("category-type")) {
            $cat_type = $this->input->get("category-type");
            $p = new Products();
            $ojb_cat_type = new Category_Type();
            $check_cat_type = $ojb_cat_type->where("Slug", $cat_type)->get_raw()->row_array();
            $product = $p->where("Slug", $slug)->get_raw()->row_array();
            if (is_array($product) && count($product) > 0 && is_array($check_cat_type) && count($check_cat_type) > 0 && $product["Type_ID"] == $check_cat_type["ID"]) {
                $path_adderss = explode("/", $product["Path_Adderss"]);
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
                            $this->data["districts_arg"] = $country->get_country($this->user_id, 1, $value["ID"]);
                        }
                        if ($value["Level"] == 1) {
                            $this->data["districts_activer"] = $value["ID"];
                            $this->data["wards_arg"] = $country->get_country($this->user_id, 2, $value["ID"]);
                        }
                        if ($value["Level"] == 2) {
                            $this->data["wards_activer"] = $value["ID"];
                        }
                    }
                }
                $this->data["product_slug"] = trim($slug);
                $product_id = $product["ID"];
                $this->data["product_id"] = $product_id;
                $attr_value = new Attribute_Value();
                $categories_product = new Product_Category();
                $media_product = new Media_Product();
                $media = new Media();
                $product_price = new Product_Price();
                $attribute_group = new Attribute_Group();
                $category = new Categories();
                $attribute_group_attribute = new Attribute_Group_Attribute();
                $attr_activer = $attr_value->where("Product_ID", $product_id)->get_raw()->result_array();
                $cat_activer = $categories_product->select("Term_ID AS ID")->where("Product_ID", $product_id)->get_raw()->result_array();
                $this->data["media_activer"] = $media_product->get_by_product($product_id);
                $this->data["thumbnail"] = $media->where("ID", $product["Featured_Image"])->get_raw()->row_array();
                $price_activer = $product_price->where("Product_ID", $product_id)->get_raw()->row_array();
                $data_id_cat_type = $check_cat_type["ID"];
                $this->data["cat_type_id"] = $data_id_cat_type;
                $this->data["category_type_slug"] = $cat_type;
                $attribute_group = new Attribute_Group();
                $attribute_group_attribute = new Attribute_Group_Attribute();
                $attribute = new Attribute();
                $category = new Categories();
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
                $sql = "SELECT * FROM (`Categories`) WHERE ((`Categories`.`Type_ID` = {$data_id_cat_type} AND `Categories`.`Member_ID` = {$this->user_id}) OR (`Categories`.`Type_ID` = (SELECT `cc`.`Parent_ID` FROM Category_Type AS cc WHERE `cc`.`ID` = {$data_id_cat_type}) ) ) AND `Disable` = 0";
                $record_cat = $category->db->query($sql);
                $record_cat = $record_cat->result_array();
                if (count($record_cat) > 0) {
                    $this->load->library('Helperclass');
                    $select_html = $this->helperclass->get_select_tree($record_cat, 0, "Parent_ID", "Name", null, "ID", $cat_activer);
                    $this->data["select_cat"] = $select_html['table_tree_select'];
                    $this->data["cat_tree"] = $select_html['table_tree'];
                }
                $attribute = new Attribute();
                $attribute_owner = $attribute->where_in("Parent_ID",$attribute_parent_id)->get_raw()->result_array(); 
                $pk = new Product_Keyword();
                $keyword_arg = $pk->get_by_product($product_id);
                $this->data["keywords"] = $keyword_arg;
                $country = new Country();
                $this->data["city"] = $country->get_country($this->user_id, 0, 0);
                $this->data["product"] = $product;
                $this->data["price"] = $price_activer;
                $this->data["arg_tabs"] = $arg_tabs;
                $this->data["att_activer"] = $attr_activer;
                $this->data["attribute_owner"] = $attribute_owner;
                $this->load->view('fontend/profile/backend/header', $this->data);
                $this->load->view('fontend/profile/products/add-edit', $this->data);
                $this->load->view('fontend/profile/backend/footer',$this->data);
                
            } else {
                redirect(base_url("profile/add_product"));
            }
        } else {
            redirect(base_url("profile/add_product"));
        }
    }
    private function my_attribute() {
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
                $tree_attr = "<ul id = 'tree_attr' class='list-group droptrue tree_parent level-0' data-level = '0'>";
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
                redirect(base_url("attributes"));
            }
            $user_id = $this->user_id;
            $member = new Member();
            $member->where('ID', $user_id)->get(1);
            $data['member'] = $member;
            $this->data["view"] = "fontend/profile/attribute/index";
            $this->data["wrapper"] = $data;
            $this->data["cat_type"] = $cat_type;
            $this->load->view('fontend/block/header', $this->data);
            $this->load->view('fontend/block/wrapper_sidebar_right', $this->data);
            $this->load->view('fontend/block/footer');
        } else {
            $this->data["title_curent"] = "Attributes";
            $category_Type = new Category_Type();
            $table = $category_Type->get_raw()->result_array();
            $this->load->library('Helperclass');
            $table_tree = "";
            $this->data["all_cat_type"] = "";
            if(isset($this->data["user_info"]["category_type"])&&is_array($this->data["user_info"]["category_type"]) && count($this->type_member) > 0){
                foreach ($this->data["user_info"]["category_type"] as $key => $value) {
                    $table_tree = $this->helperclass->get_select_tree($table, $value["Type_ID"], "Parent_ID", "Name", "table_tree_select", "Slug");
                    $this->data["all_cat_type"] .= $table_tree["table_tree_select"];
                }
            }
           
            $this->data["view"] = "fontend/profile/products/before";
            $this->load->view('fontend/block/header',$this->data);
            $this->load->view('fontend/block/wrapper_sidebar_right', $this->data);
            $this->load->view('fontend/block/footer',$this->data);
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

    public function copy_product($id = null) {
        check_ajax();
        $data["success"] = "error";
        $data["messenger"] = "";
        if ($id != null) {
            $p = new Products();
            $old_product = $p->where(array("ID" => $id, "Member_ID" => $this->user_id))->get_raw()->row_array();
            if ($old_product != null) {
                $cp = new Product_Category();
                $a_value = new Attribute_Value();
                $pp = new Product_Price();
                $kp = new Product_Keyword();
                $md = new Media_Product();
                $arg_category = $cp->where("Product_ID", $id)->get_raw()->result_array();
                $arg_attr_value = $a_value->where("Product_ID", $id)->get_raw()->result_array();
                $arg_pp = $pp->where("Product_ID", $id)->get_raw()->row_array();
                $arg_k = $kp->where("Product_ID", $id)->get_raw()->result_array();
                $arg_media = $md->where("Product_ID", $id)->get_raw()->result_array();
                $datime = date('Y-m-d H:i:s');
                $this->load->library('Helperclass');
                $slug = $this->helperclass->slug("Products", "slug", trim($old_product["Name"]));
                $p->Type_ID = $old_product["Type_ID"];
                $p->Name = str_replace("(copy)","",$old_product["Name"])." (copy)";
                $p->Slug = $slug;
                $p->Description = $old_product["Description"];
                $p->Content = $old_product["Content"];
                $p->Featured_Image = $old_product["Featured_Image"];
                $p->Createdat = $datime;
                $p->Updatedat = $datime;
                $p->Member_ID = $old_product["Member_ID"];
                $p->Status = "Draft";
                $p->Version = $old_product["Version"];
                $p->Root_ID = $old_product["Root_ID"];
                $p->Path_Adderss = $old_product["Path_Adderss"];
                $p->Disable = "0";
                $p->save();
                $new_pr_id = $p->db->insert_id();
                if ($new_pr_id) {
                    if ($arg_category != null) {
                        foreach ($arg_category as $value) {
                            $cp->Product_ID = $new_pr_id;
                            $cp->Term_ID = $value["Term_ID"];
                            $cp->save();
                        }
                    }
                    if ($arg_attr_value != null) {
                        foreach ($arg_attr_value as $value) {
                            $a_value->Attribute_ID = $value["Attribute_ID"];
                            $a_value->Product_ID = $new_pr_id;
                            $a_value->Value = $value["Value"];
                            $a_value->Group_ID = $value["Group_ID"];
                            $a_value->save();    
                        }
                    }
                    if ($arg_pp != null) {
                        $pp->Product_ID = $new_pr_id;
                        $pp->Price = $arg_pp["Price"];
                        $pp->Special_Start = null;
                        $pp->Special_End = null;
                        $pp->Is_Main = $arg_pp["Is_Main"];
                        $pp->Special_Percent = $arg_pp["Special_Percent"];
                        $pp->Special_Price = $arg_pp["Special_Price"];
                        $pp->save();
                    }
                    if ($arg_k != null) {
                        foreach ($arg_k as $value) {
                            $kp->Keyword_ID = $value["Keyword_ID"];
                            $kp->Product_ID = $new_pr_id;
                            $kp->save();            
                        }
                    }
                    if ($arg_media != null) {
                        foreach ($arg_media as $value) {
                            $md->Media_ID = $value["Media_ID"];
                            $md->Product_ID = $new_pr_id;
                            $md->save();            
                        }
                    }
                }
                $data["success"] = "success";
            }
            
        } 
        die(json_encode($data));
    }

    /*Menu*/
    public function menu($group_id = null){
        $this->data['title'] = 'Menu';
        $member_menu_group = new Member_Group_Menu();
        $member_menu_group->where('Member_ID',$this->user_id)->get();
        if (!isset($group_id) || $group_id == null) {
            $group_id = $member_menu_group->ID;
        }
        $this->data['menu_group'] = $member_menu_group;
        $this->data['id'] = $group_id;
        $menu = array(
            'items' => array(),
            'parents' => array()
        );
        $member_menus = new Member_Menu();
        $member_menus->where(array('Group_ID' => $group_id , 'Member_ID' => $this->user_id));
        $member_menus->order_by('Sort_Menu', 'ASC');
        $member_menus->get();
        foreach ($member_menus as $items) {
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $menu['items'][$items->ID] = array(
                'class' => $items->Class_Menu,
                'url' => $items->URL,
                'title' => $items->Title,
                'id' => $items->ID
            );
            // Creates entry into parents array. Parents array contains a list of all items with children
            $menu['parents'][$items->Parent_ID][] = $items->ID;
        }
        $this->data['menu'] = $this->build_menu_admin(0, $menu, "easymm");

        $member_page = new Member_Page();
        $member_page->where('Member_ID', $this->user_id )->get();
        $this->data['page'] = $member_page;

        /*$category_type = new Category_Type();
        $category_type->order_by('ID', 'ASC');
        $category_type->get();
        $data['category_type'] = $category_type;*/
        $this->load->view('fontend/profile/backend/header',$this->data);
        $this->load->view('fontend/profile/backend/menu',$this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    /*Page*/
    public function page(){
        $this->data['title'] = 'Trang';
        $member_page =  new Member_Page();
        if($this->input->get('q')){
            $member_page->like('Title',$this->input->get('q'));
        }
        $per_page = 20;
        $offset = $this->uri->segment(3) == '' ? 0 : $this->uri->segment(3);
        $member_page->order_by('Date_Creater','DESC')->where('Member_ID',$this->user_id)->get($per_page,$offset);
        $this->load->library('pagination');
        $p = new Member_Page();
        if($this->input->get('q')){
            $p->like('Title',$this->input->get('q'));
        }
        $count = $p->where('Member_ID',$this->user_id)->count();
        $config['base_url'] = base_url().'profile/page/';
        $config['total_rows'] = $count;
        $config['per_page'] = $per_page; 
        $config['segment'] = 3;
        $this->pagination->initialize(get_paging($config)); 

        $this->data['page'] = $member_page;
        $this->load->view('fontend/profile/backend/header',$this->data);
        $this->load->view('fontend/profile/backend/page',$this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    public function addpage(){
        $this->data['title'] = 'Thêm trang';
        $this->data['action'] = base_url().'profile/addpage';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('content', 'Content', 'trim|required');

        if($this->input->post()){
            $member_page =  new Member_Page();
            $member_page->Member_ID = $this->user_id;
            $member_page->Title = $this->input->post('title');
            $member_page->Content = $this->input->post('content');
            $member_page->Summary = substr(strip_tags($this->input->post('content')),0,130);
            $member_page->Media_ID = 0;

            if ($this->form_validation->run() === FALSE) {
                $this->data['error'] = 'Vui lòng nhập đầy đủ thông tin.';
                $this->data['pages'] = $member_page;
            }
            else{
                $p = new Member_Page();
                $count = $p->where('Member_ID',$this->user_id)->count();
                if($count >= 100){
                    $this->data['error'] = 'Số lượng trang đã vượt quá số lượng.';
                    $this->data['pages'] = $member_page;
                }
                else{
                    $member_page->Date_Creater = date('Y-m-d H:i:s');
                    if($member_page->save()){
                        $this->data['success'] = 'Trang đã được lưu thành công.';
                        redirect(base_url().'profile/editpage/'.$member_page->get_id_last_save());
                    }
                    else{
                        $this->data['error'] = 'Lỗi khi thực hiện.';
                    }
                }
            }
        }

        $this->data['label'] = "Add";
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '250px');

        $this->load->view('fontend/profile/backend/header',$this->data);
        $this->load->view('fontend/profile/backend/page-add',$this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    public function editpage($paged_id = null){
        $this->data['action'] = base_url().'profile/editpage/'.$paged_id;
        $this->data['title'] = 'Sữa trang';
        $member_page =  new Member_Page();
        $member_page->where(array('ID' => $paged_id,'Member_ID' => $this->user_id))->get(1);
        if(!(isset($member_page->Member_ID) && $member_page->Member_ID!=null)) {
            redirect(base_url().'profile/page');
        }
        $this->data['pages'] = $member_page;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('content', 'Content', 'trim|required');

        if($this->input->post()){
            $member_page =  new Member_Page();
            $arr = array(
                'Title' => $this->input->post('title'),
                'Content' => $this->input->post('content'),
                'Summary' => substr(strip_tags($this->input->post('content')),0,150)
            );

            if ($this->form_validation->run() === FALSE) {
                $this->data['error'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else{
                if( $member_page->where(array('ID' => $page_id,'Member_ID' => $this->user_id))->update($arr) ){
                    $this->data['success'] = 'Trang đã được chỉnh sữa thành công.';
                    redirect(base_url().'profile/editpage/'.$paged_id);
                }
                else{
                     $this->data['error'] = 'Lỗi khi thực hiện.';
                }
            }
        }
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '250px');

        $this->load->view('fontend/profile/backend/header',$this->data);
        $this->load->view('fontend/profile/backend/page-add',$this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    public function deletepage($paged_id = null){
        $member_page =  new Member_Page();
        $member_page->where(array('ID' => $paged_id,'Member_ID' => $this->user_id))->get(1);
        if(!(isset($member_page->Member_ID) && $member_page->Member_ID!=null)) {
            redirect(base_url().'profile/page');
        }
        $member_page->delete_by_id($member_page->ID);
        redirect(base_url().'profile/page');
    }

    /*Category News*/
    public function category_news(){
        $this->data['title'] = 'Thể loại bài viết';
        $cn =  new Member_Category_News();
        if($this->input->get('q')){
            $cn->like('Name',$this->input->get('q'));
        }
        $per_page = 20;
        $offset = $this->uri->segment(3) == '' ? 0 : $this->uri->segment(3);
        $cn->where('Member_ID',$this->user_id)->get($per_page,$offset);
        $this->load->library('pagination');
        $p = new Member_Category_News();
        if($this->input->get('q')){
            $p->like('Name',$this->input->get('q'));
        }
        $count = $p->where('Member_ID',$this->user_id)->count();
        $config['base_url'] = base_url().'profile/category_news/';
        $config['total_rows'] = $count;
        $config['per_page'] = $per_page; 
        $config['segment'] = 3;
        $this->pagination->initialize(get_paging($config)); 

        $this->data['category_new'] = $cn;
        $this->load->view('fontend/profile/backend/header',$this->data);
        $this->load->view('fontend/profile/backend/category-news',$this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    public function addcategory_news(){
        $this->data['title'] = 'Thêm trang';
        $this->data['action'] = base_url().'profile/addcategory_news';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim|required');

        if($this->input->post()){
            $this->load->library('Helperclass');
            $cn =  new Member_Category_News();
            $cn->Member_ID = $this->user_id;
            $cn->Name = $this->input->post('title');
            $cn->Slug = $this->helperclass->slug_member($cn->table,"Slug",$this->input->post('slug'),$this->user_id);
            $cn->Path = '';
            $cn->Parent_ID = 0;

            if ($this->form_validation->run() === FALSE) {
                $this->data['error'] = 'Vui lòng nhập đầy đủ thông tin.';
                $this->data['category_news'] = $cn;
            }
            else{
                $p = new Member_Category_News();
                $count = $p->where('Member_ID',$this->user_id)->count();
                if($count >= 100){
                    $this->data['error'] = 'Số lượng Thể loại đã vượt quá số lượng.';
                    $this->data['category_news'] = $cn;
                }
                else{
                    $cn->Date_Creater = date('Y-m-d H:i:s');
                    if($cn->save()){
                        $this->data['success'] = 'Trang đã được lưu thành công.';
                        redirect(base_url().'profile/editcategory_news/'.$cn->get_id_last_save());
                    }
                    else{
                        $this->data['error'] = 'Lỗi khi thực hiện.';
                    }
                }
            }
        }

        $this->load->view('fontend/profile/backend/header',$this->data);
        $this->load->view('fontend/profile/backend/category-news-add',$this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    public function editcategory_news($category_id = null){
        $this->data['action'] = base_url().'profile/editcategory_news/'.$category_id;
        $this->data['disable'] = 'yes';
        $this->data['title'] = 'Sữa thể loại';
        $cn =  new Member_Category_News();
        $cn->where(array('ID' => $category_id,'Member_ID' => $this->user_id))->get(1);
        if(!(isset($cn->Member_ID) && $cn->Member_ID!=null)) {
            redirect(base_url().'profile/category_news');
        }
        $this->data['category_news'] = $cn;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim|required');

        if($this->input->post()){
            $cn =  new Member_Category_News();
            $arr = array(
                'Name' => $this->input->post('title')
            );

            if ($this->form_validation->run() === FALSE) {
                $this->data['error'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else{
                if( $cn->where(array('ID' => $category_id,'Member_ID' => $this->user_id))->update($arr) ){
                    $this->data['success'] = 'Trang đã được chỉnh sữa thành công.';
                    redirect(base_url().'profile/editcategory_news/'.$category_id);
                }
                else{
                     $this->data['error'] = 'Lỗi khi thực hiện.';
                }
            }
        }
        $this->load->view('fontend/profile/backend/header',$this->data);
        $this->load->view('fontend/profile/backend/category-news-add',$this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    public function deletecategory_news($category_id = null){
        $cn =  new Member_Category_News();
        $cn->where(array('ID' => $category_id,'Member_ID' => $this->user_id))->get(1);
        if(!(isset($cn->Member_ID) && $cn->Member_ID!=null)) {
            redirect(base_url().'profile/category_news');
        }
        $cn->delete_by_id($cn->ID);
        redirect(base_url().'profile/category_news');
    }

    /*Post*/
    public function post(){
        $post =  new Member_News();
        $media = new Media();
        $sql = "SELECT p.*,m.Path_Large 
                FROM $post->table AS p 
                LEFT JOIN $media->table AS m ON m.ID = p.Media_ID ";
        

        $this->data['title'] = 'Bài viết';
        $post =  new Member_News();
        $like = '';
        if($this->input->get('q')){
            $title = $this->input->get('q');
            $like .="AND p.Title LIKE '%".$title."%'";
        }
        
        $per_page = 20;
        $offset = $this->uri->segment(3) == '' ? 0 : $this->uri->segment(3);
        $sql .= "WHERE p.Member_ID = $this->user_id  ". $like ." ORDER BY p.Created_at DESC LIMIT $offset , $per_page";
        $post->query($sql);
        $this->load->library('pagination');
        $p = new Member_News();
        if($this->input->get('q')){
            $p->like('Title',$this->input->get('q'));
        }
        $count = $p->where('Member_ID',$this->user_id)->count();
        $config['base_url'] = base_url().'profile/post/';
        $config['total_rows'] = $count;
        $config['per_page'] = $per_page; 
        $config['segment'] = 3;
        $this->pagination->initialize(get_paging($config)); 
        $this->data['post'] = $post;
        $this->load->view('fontend/profile/backend/header',$this->data);
        $this->load->view('fontend/profile/backend/post',$this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    public function addpost(){
        $this->data['title'] = 'Thêm bài viết';
        $this->data['action'] = base_url().'profile/addpost';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('content', 'Content', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');

        if($this->input->post()){
            $this->load->library('Helperclass');
            $post =  new Member_News();
            $post->Member_ID = $this->user_id;
            $post->Title = $this->input->post('title');
            $post->Slug = $this->helperclass->slug_member($post->table,"Slug",$this->input->post('title'),$this->user_id);
            $post->Content = $this->input->post('content');
            $post->Summary = substr(strip_tags($this->input->post('content')),0,130);
            $post->Type_News = $this->input->post('type');
            $post->Status = $this->input->post('status');

            if ($this->form_validation->run() === FALSE) {
                $this->data['error'] = 'Vui lòng nhập đầy đủ thông tin.';
                $this->data['post'] = $post;
            }
            else{
                $p = new Member_Page();
                $count = $p->where('Member_ID',$this->user_id)->count();
                if($count >= 500){
                    $this->data['error'] = 'Số lượng trang đã vượt quá số lượng.';
                    $this->data['post'] = $post;
                }
                else{
                    $post->Created_at = date('Y-m-d H:i:s');
                    $post->Updated_at = date('Y-m-d H:i:s');
                    $post->Media_ID = $this->input->post('media_id');
                    if($post->save()){
                        $post_id = $post->get_id_last_save();
                        $cat = $this->input->post('cat');
                        if(isset($cat) && $cat != null) {
                            foreach ($cat as $key => $value) {
                                $nc = new Member_News_Member_Category();
                                $nc->News_ID = $post_id;
                                $nc->Category_ID = $value;
                                $nc->save();
                            }
                        }
                        $this->data['success'] = 'Trang đã được lưu thành công.';
                        redirect(base_url().'profile/editpost/'.$post_id);
                    }
                    else{
                        $this->data['error'] = 'Lỗi khi thực hiện.';
                    }
                }
            }
        }

        $cn =  new Member_Category_News();
        $cn->where('Member_ID',$this->user_id)->get();
        $this->data['category'] = $cn;

        $this->data['label'] = "Add";
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '250px');

        $this->data['cn'] = array();

        $this->load->view('fontend/profile/backend/header',$this->data);
        $this->load->view('fontend/profile/backend/post-add',$this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    public function editpost($post_id = null){
        $this->data['action'] = base_url().'profile/editpost/'.$post_id;
        $post =  new Member_News();
        $post->where(array('ID' => $post_id,'Member_ID' => $this->user_id))->get(1);
        if(!(isset($post->Member_ID) && $post->Member_ID!=null)) {
            redirect(base_url().'profile/post');
        }
        $post =  new Member_News();
        $media = new Media();
        $sql = "SELECT p.*,m.Path_Large 
                FROM $post->table AS p 
                LEFT JOIN $media->table AS m ON m.ID = p.Media_ID 
                WHERE p.ID = $post_id";
        $post->query($sql);
        $this->data['post'] = $post;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('content', 'Content', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');

        if($this->input->post()){
            $post =  new Member_News();
            $arr = array(
                'Title' => $this->input->post('title'),
                'Content' => $this->input->post('content'),
                'Summary' => substr(strip_tags($this->input->post('content')),0,150)
            );

            if ($this->form_validation->run() === FALSE) {
                $this->data['error'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else{
                if($post->where(array('ID' => $post_id,'Member_ID' => $this->user_id))->update($arr) ){
                    $nc = new Member_News_Member_Category();
                    $nc->delete_by_post_id($post_id);
                    $cat = $this->input->post('cat');
                    if(isset($cat) && $cat != null) {
                        foreach ($cat as $key => $value) {
                            $nc = new Member_News_Member_Category();
                            $nc->News_ID = $post_id;
                            $nc->Category_ID = $value;
                            $nc->save();
                        }
                    }
                    $this->data['success'] = 'Trang đã được chỉnh sữa thành công.';
                    redirect(base_url().'profile/editpost/'.$post_id);
                }
                else{
                     $this->data['error'] = 'Lỗi khi thực hiện.';
                }
            }
        }
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '250px');

        $cn =  new Member_Category_News();
        $cn->where('Member_ID',$this->user_id)->get();
        $this->data['category'] = $cn;

        $mnc = new Member_News_Member_Category();
        $mnc->where('News_ID',$post_id)->get();
        $list_cat = array();
        if(isset($mnc) && $mnc!=null) {
            foreach ($mnc as $key => $value) {
               $list_cat[] = $value->Category_ID;
            }
        }
        $this->data['cn'] = $list_cat;

        $this->load->view('fontend/profile/backend/header',$this->data);
        $this->load->view('fontend/profile/backend/post-add',$this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    public function deletepost($post_id = null){
        $post =  new Member_News();
        $post->where(array('ID' => $post_id,'Member_ID' => $this->user_id))->get(1);
        if(!(isset($post->Member_ID) && $post->Member_ID!=null)) {
            redirect(base_url().'profile/post');
        }
        $post->delete_by_id($post->ID);
        redirect(base_url().'profile/post');
    }

    /*Payment*/
    public function payment(){
        $this->data['title'] = 'Lịch sữ thanh toán';
        $member_page =  new Member_Page();
        if($this->input->get('q')){
            $member_page->like('Title',$this->input->get('q'));
        }
        $per_page = 20;
        $offset = $this->uri->segment(3) == '' ? 0 : $this->uri->segment(3);
        $member_page->order_by('Date_Creater','DESC')->where('Member_ID',$this->user_id)->get($per_page,$offset);
        $this->load->library('pagination');
        $p = new Member_Page();
        if($this->input->get('q')){
            $p->like('Title',$this->input->get('q'));
        }
        $count = $p->where('Member_ID',$this->user_id)->count();
        $config['base_url'] = base_url().'profile/page/';
        $config['total_rows'] = $count;
        $config['per_page'] = $per_page; 
        $config['segment'] = 3;
        $this->pagination->initialize(get_paging($config)); 

        $this->data['page'] = $member_page;
        $this->load->view('fontend/profile/backend/header',$this->data);
        $this->load->view('fontend/profile/backend/payment',$this->data);
        $this->load->view('fontend/profile/backend/footer',$this->data);
    }

    
    public function setting(){
        $ms = new Member_Setting_Website();
        if($this->input->post()){
            $contact_infor = "";
            if($this->input->post("contact_infor_name") && $this->input->post("contact_infor_infor")){
                $contact_infor_name = $this->input->post("contact_infor_name");
                $contact_infor_infor = $this->input->post("contact_infor_infor");
                $length = count($contact_infor_name);
                $arg_infor = [];
                for ($i = 0; $i < $length; $i++) {
                    if( 
                        isset($contact_infor_name[$i]) && isset($contact_infor_infor[$i]) && 
                        trim($contact_infor_name[$i]) != "" && trim($contact_infor_infor[$i]) != "" && $i < 21
                    ){
                        $new = array($contact_infor_name[$i] => $contact_infor_infor[$i]);
                        $arg_infor = $arg_infor + $new;  
                    } 
                }
                $contact_infor = json_encode($arg_infor);
            }
            $check = $ms->where("Member_ID",$this->user_id)->get_raw()->result_array();
            $per_page = ($this->input->post("per_page") != "") ? $this->input->post("per_page") : 21;
            $order_by_follow = $this->input->post("order_by_follow");
            $contact_name = $this->input->post("contact_name");
            $contact_email = $this->input->post("contact_email");
            $title_site = $this->input->post("title_site");
            $description_site = $this->input->post("description_site");
            if($check == null){
                $ms->Member_ID = $this->user_id;
                $ms->Item_Per_Page = $per_page;
                $ms->Contact_Email = $contact_email;
                $ms->Title_Site = $title_site;
                $ms->Description_Site = $description_site;
                $ms->Order_By_Follow = $order_by_follow;
                $ms->Contact_Info = $contact_infor;
                $ms->Contact_Name = $contact_name;
                $ms->save();
            }else{
                $data_update = array(
                    "Item_Per_Page" => $per_page,
                    "Contact_Email" => $contact_email,
                    "Title_Site" => $title_site,
                    "Description_Site" => $description_site,
                    "Order_By_Follow" => $order_by_follow,
                    "Contact_Info" => $contact_infor,
                    "Contact_Name" => $contact_name,
                );
                $ms->where("Member_ID", $this->user_id)->update($data_update);
            }
        }
        $this->data["member"] = $ms->where("Member_ID",$this->user_id)->get_raw()->row_array();
        $this->data["view"] = "fontend/profile/setting";
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/block/wrapper_sidebar_right', $this->data);
        $this->load->view('fontend/block/footer');
    }
    function update_category_type (){
        check_ajax();
        $slug = $this->input->post("slug");
        $ct = new Category_Type();
        $data["success"] = "error";
        $data["messenger"] = "";
        $record = $ct->where("Slug",$slug)->get_raw()->row_array();
        if($record !== null){
            $mt = new Members_Category_Type();
            $mt->Member_ID = $this->user_id ;
            $mt->Type_ID = $record["ID"] ;
            $mt->Createdat = date('Y-m-d H:i:s');
            $mt->save();
            $new_infor = $this->user_info;
            $arg_mct = $mt->where("Member_ID",$this->user_id)->select("Type_ID")->get_raw()->result_array();
            $new_infor["category_type"] = $arg_mct;
            $this->session->unset_userdata('user_info');
            $this->session->set_userdata('user_info',$new_infor);
            $data["success"] = "success";
        }
        die(json_encode($data));
    }

    /*Function*/
    private function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
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

    function _editor($path,$height) {
        //Loading Library For Ckeditor
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        //configure base path of ckeditor folder 
        $this->ckeditor->basePath = base_url().'skins/js/ckeditor/';
        $this->ckeditor->config['toolbar'] = 'Full';
        $this->ckeditor->config['language'] = 'vi';
        $this->ckeditor->config['height'] = $height;
        //configure ckfinder with ckeditor config 
        $this->ckfinder->SetupCKEditor($this->ckeditor,$path); 
    }
    private function update_gia(){
            $Product_Price = new Product_Price();
            $all = $Product_Price->get_raw()->result_array();
            $Price = "";
            $arg = [];
            
            if($all){
                foreach ($all as $key => $value) {
                   $gia = "";
                   if($value["Price"] != ""){
                        $Price  = str_replace(".","",$value["Price"]);
                        $data_update = [
                            "Number_Price" => $Price
                        ];
                        $Product_Price->where("ID", $value["ID"])->update($data_update);
                   }
                }
            }
            echo "<pre>";
            print_r($arg);
            echo "</pre>";

    }
    public function get_option_type($arg, $id, $colum,$space = "", $i = 0) {
        if ($id != 0) {
            $space .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            $i++;
        }
        foreach ($arg as $key => $value) {
            if ($value[$colum] == $id) {
            	if($i == 0){
            		$this->tree_select.='<option class="level-' . $i . '" data-space="' . $i . '" style=" font-weight: bold;" value="' . $value["Slug"] . '" disabled>' . $space . $value["Name"] . '</option>';
            	}else{
            		$this->tree_select.='<option class="level-' . $i . '" data-space="' . $i . '" value="' . $value["Slug"] . '">' . $space . $value["Name"] . '</option>';
            	}
                unset($arg[$key]);
                $this->get_option_type($arg, $value["ID"], $colum,$space,$i);
            }
        }
        $space = "";
        $i = 0;
        return $this->tree_select;
    }

}
