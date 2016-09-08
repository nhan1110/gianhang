<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Advertises extends CI_Controller {
    private $is_login = false;
    private $user_info = array();
    private $user_advertises = array();
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
        $this->data["is_login"] = $this->is_login;
        if ($this->session->userdata('user_advertises')) {
            $this->user_advertises = $this->session->userdata('user_advertises');
        }
    }
    public function index() {
    	$user_id = (!empty($this->user_advertises)) ? $this->user_advertises["ID"] : -1;
        $advertise_block = new Advertise_Block();
        $advertise_page = new Advertise_Page();
        $advertise_bock_page = new Advertise_Block_Page();
        $page = $advertise_page->where("Disable","0")->get_raw()->result_array();
        $block = $advertise_block->where("Disable","0")->get_raw()->result_array();
        $bock_page = $advertise_bock_page->show_register($user_id); 
        $table = "<table valign='middle' id ='advertise' class='table table-hover table-bordered'><thead>";
                $table .= "<tr><th>Stt</th><th>Vị trí</th>";
                    foreach ($page as $key => $value) {
                        $table .= "<th>".$value["Page"]."</th>";
                    }
                $table .= "</tr></thead><tbody>";
        $i = 0;
        $data = "";
        $stt = 1;
        foreach ($block as $key => $value) {
            $table .= "<tr>
                        <td>".$stt."</td>
                        <td>".$value["Title"]."</td>"; 
            foreach ($page as $key => $value_page) {
                foreach ($bock_page as $key => $value_item) {
                    if($value["ID"] == $value_item["Block_ID"] && $value_page["ID"] == $value_item["Page_ID"]){
                    	$edit_add = (!empty($value_item["Advertise_Member_ID"])) ? "<a href = '".base_url("advertises/edit/".$value_item["Advertise_ID"])."'>Chỉnh sửa đăng kí</a>"  : "<a class='btn btn-info' onclick='return register_advertises(this);' href='".base_url("advertises/register/".$value_item["Slug"])."'>Đăng kí</a>" ;
                        $data = "<td><p>".$value_item["Price"]."</p><p><a class='btn btn-success' href='".base_url("advertises/view/".$value_item["Slug"])."'>Xem</a>".$edit_add."</p></td>";
                    }
                }
                if($data == ""){
                    $data = "<td>------</td>";
                }
                $table .= $data;
                $data = "";
            }
            $table .= "</tr>";
            $stt++;
        }
        $table .= "</tbody></table>";
        $this->data["advertise"] = '<div class="table-responsive">'.$table.'</div>';
        $this->data["view"] = "fontend/advertises/index";
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/block/wrapper_full', $this->data);
        if($this->session->userdata('user_advertises')){
            $this->load->view('fontend/advertises/sidaber', $this->data);
        }
        $this->load->view('fontend/block/footer');
    }
    public function check_user(){
        check_ajax();
        $data["success"] = "error";
        $data["login"] = "false";
        if(!empty($this->user_advertises)){
            $data["login"] = "true";
        }
        $data["success"] = "success";
        die(json_encode($data));
    }
    public function signin(){
        check_ajax();
        $data = ["status" => "error","messenger" => null];
        if(empty($this->user_advertises)){
            $this->form_validation->set_rules('email', 'Email company', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() == TRUE ){
            	$am = new Advertise_Member();
            	$email = $this->input->post("email");
    	        $password = $this->input->post("password");
    	        $filter = ["Email" => $email,"Password" => md5(md5($email).":".md5($password)),"Disable" => "0"];
    	        $check_email = $am->where($filter)->get_raw()->row_array();
    	        if(!empty($check_email)){
    	        	$this->session->set_userdata('user_advertises',$check_email);
    	        	$data = ["status" => "success","messenger" => ["Đăng nhập thành công đang chuyển trang."]];
    	        }else{
    	        	$data["messenger"][] = "Email hoặc password không chính xác ! vui lòng kiểm tra lại.";
    	        }
            }else{
            	$data["messenger"][] = "Vui lòng nhập đủ thông tin cần thiết";
            }
        }
        die(json_encode($data));
        
    }
    public function signup(){
        check_ajax();
        $data = ["status" => "error","messenger" => null];
       	$this->load->library('form_validation');
	    $this->form_validation->set_rules('company', 'Company name', 'required');
	    $this->form_validation->set_rules('email', 'Email company', 'required|valid_email');
        if ($this->form_validation->run() == TRUE)
        {   $am = new Advertise_Member();
            $token = uniqid();
	        $email = trim($this->input->post("email"));
	        $check_email = $am->where("Email",$email)->get_raw()->row_array();
	        if(empty($check_email)){
		        $company = $this->input->post("company");
		        $today = date("Y-m-d H:i:s"); 
		        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			    $randstring = '';
			    for ($i = 0; $i < 10; $i++) {
			        $randstring .= $characters[rand(0, strlen($characters) - 1)];
			    }
			    $password = md5(md5($email).":".md5($randstring));
		        $am->Email = $email;
		        $am->Password = $password;
		        $am->Company_Name = $company;
		        $am->Createat = $today;
	            $am->Token = $token;
	            $am->Disable = "1";
		        $am->save();
	            $subject = "Xác nhận đăng kí  thành viên quảng cáo.";
	            $content = '<table>
	                <tr><td><img src = "'.base_url("skins/images/logo.png").'"></td></tr>
	                <tr><td><p>Bạn vừa sử dụng email này để đăng kí thành viên quảng cáo của <a href="'.base_url().'">'.base_url().'</a></p></td></tr>
	                <tr><td><p>Email đăng nhập: '.$email.'</p></td></tr>
	                <tr><td><p>Password đăng nhập: '.$randstring.'</p></td></tr>
	                <tr><td><p>Vui lòng xác thực thành viên trước khi đăng nhập.</p></td></tr>
	                <tr><td><p>Để xác thực người dùng vui lòng click vào link này: <a style ="color:#fff;background-color:#449d44;border-color:#398439;padding: 7px 20px;text-decoration: none;border-radius: 3px;" href="'.base_url("advertises/active/".$token."?status=success").'">Xác nhận </a> </p></td></tr>
	                <tr><td><p>Để hủy người dùng vui lòng click vào link này: <a style ="color:#fff;background-color:red;border-color:#red;padding:10px 20px;padding: 7px 20px;text-decoration: none;border-radius: 3px;" href="'.base_url("advertises/active/".$token."?status=cancel").'">Hủy xác nhận </a> </p></td></tr>
	            </table>';
	            sendmail($email,$subject,$content);
	            $data = ["status" => "success","messenger" => ["Đăng kí thành công vui lòng kiểm tra email để hoàn thành đăng kí ! Cảm ơn bạn."]];
	        }else{
	        	$data["messenger"][] = "Email này đã được sử dùng cho việc đăng kí ! Vui lòng chọn một email khác.";
	        }
    	}else{
    		$data["messenger"][] = "Vui lòng nhập đủ thông tin cần thiết !";
    	}
    	die(json_encode($data));

    }
    public function register($slug){
        $advertise_bock_page = new Advertise_Block_Page();
        $record = $advertise_bock_page->where(array("Disable"=>"0","Slug" => $slug))->get_raw()->row_array();
        $this->data["record"] = $record;
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '350px');
        $this->data["view"] = "fontend/advertises/register";
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/block/wrapper_full', $this->data);
        $this->load->view('fontend/block/footer');
    }
    public function active($token = null){
        if($token != null && $this->input->get("status")){
            $am = new Advertise_Member();
            $check_record = $am->where("Token",$token)->get_raw()->row_array();
            if(!empty($check_record)){
                if($this->input->get("status") == "success"){
                    $data_update["Disable"] = "0";
                    $data_update["Token"] = uniqid();
                    $am->where("ID", $check_record["ID"])->update($data_update);
                    redirect(base_url("advertises?signin=true"));
                }else if($this->input->get("status") == "cancel"){
                    $am->where("ID", $check_record["ID"])->delete();
                }
            } 
        }
        redirect(base_url());

    }
    private function _editor($path,$height) {
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
}
