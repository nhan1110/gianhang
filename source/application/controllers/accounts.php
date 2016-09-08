<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

    public $data;
    private $secret = '6LejPCcTAAAAAMGS0Sckk1onmnmUGiEhe5_bg1Td';

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            if($this->input->is_ajax_request()){
                $data["status"] = "error";
                die(json_encode($data));
            }
            else{
                redirect(base_url());
                die;
            }
        }
        $this->data["is_login"] = false;
    }

    public function signup() {
        check_ajax();
        $data["status"] = "error";
        $data["message"] = '';
        $verifyResponse = $this->fetchData('https://www.google.com/recaptcha/api/siteverify?secret='.$this->secret.'&response='.$this->input->post('g-recaptcha-response'));
        $responseData = json_decode($verifyResponse);
        if (!$responseData->success) {
           $data['status'] = 'fail';
           $data['message'] = 'CAPTCHA không được nhập chính xác. Vui lòng thử lại lần nữa.';
           die(json_encode($data));
        }

        $email = $this->input->post("email");
        $password = $this->input->post("password");
        $confirm_password = $this->input->post("confirm_password");
        $first_name = $this->input->post("first_name") ? $this->input->post("first_name") : "";
        $last_name = $this->input->post("last_name") ? $this->input->post("last_name") : "";
        $member = new Member();
        $member->where('Email', $email)->get(1);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $data['status'] = 'fail';
            $data["message"] = "Địa chỉ email không hợp lệ. Vui lòng nhập lại.";
            die(json_encode($data));
        }
        if (isset($member->ID) && $member->ID != null) {
            $data['status'] = 'fail';
            $data["message"] = "Email này đã tồn tại. Vui lòng hãy đăng nhập";
            die(json_encode($data));
        }

        if (strlen($password) < 6){
            $data['status'] = 'fail';
            $data["message"] = "Mật khẩu tối thiểu 6 ký tự. Vui lòng nhập lại.";
            die(json_encode($data));
        }
        if ($password != $confirm_password){
            $data['status'] = 'fail';
            $data["message"] = "Mật khẩu không khớp nhau. Vui lòng nhập lại.";
            die(json_encode($data));
        }
        $user = new Member();
        $user->Email = $email;
        $user->Firstname = $first_name;
        $user->Lastname = $last_name;
        $user->Pwd = md5(md5($email) . md5($password));
        $user->Token = md5(uniqid() . $email);
        $user->Createat = date('Y-m-d H:i:s');
        if ($user->save()) {
            $id = $user->db->insert_id();
            $token_activity = set_token();
            $this->session->set_userdata('user_info', array(
                'email' => $user->Email,
                'id' => $id,
                'full_name' => $user->Firstname . ' ' . $user->Lastname,
                'first_name' => $user->Firstname,
                'last_name' => $user->Lastname,
                'avatar' => $user->Avatar,
                'token_activity' => $token_activity,
                'type_member' => null
            ));
            $data["status"] = "success";
            $data["message"] = "Tài khoản đã đăng ký thành công. Vui lòng đăng nhập.";
        }
        die(json_encode($data));
    }


    public function login() {
        check_ajax();
        if ($this->input->post()) {
            $data["status"] = "error";
            $data["message"] = array();
            $email = ($this->input->post("email")) ? trim($this->input->post("email")) : "";
            $password = ($this->input->post("password")) ? trim($this->input->post("password")) : "";
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                $data['status'] = 'fail';
                $data["message"] = "Email không hợp lệ. Vui lòng nhập lại.";
            } else{
                $member = new Member();
                $member->where('Email', $email)->get(1);
                if (isset($member->ID) && $member->ID != null) {
                    if ($member->Pwd == md5(md5($email) . md5($password))) {
                        if ($member->Disable == 0) {
                            $mct = new Members_Category_Type();
                            $arg_mct = $mct->where("Member_ID",$member->ID)->select("Type_ID")->get_raw()->result_array();
                            $this->session->set_userdata('user_info', array(
                                'email' => $member->Email,
                                'id' => $member->ID,
                                'full_name' => $member->Firstname . ' ' . $member->Lastname,
                                'first_name' => $member->Firstname,
                                'last_name' => $member->Lastname,
                                'avatar' => $member->Avatar,
                                'type_member' => $member->Type_Member,
                                'category_type' => @$arg_mct
                            ));

                            $this->load->helper('cookie');
                            if ($this->input->post("remember") == "on") {
                                $cookie = array(
                                    'name' => 'email',
                                    'value' => $member->Email,
                                    'expire' => '86500',
                                );
                                $this->input->set_cookie($cookie);
                            } else {
                                delete_cookie("email");
                                delete_cookie("password");
                            }
                            $data["status"] = "success";
                        } else {
                            if ($member->Disable == 1) {
                                $data['status'] = 'fail';
                                $data["message"] = "Tài khoản này đã bị khóa. Xin vui lòng liên hệ với các admin để có thể tiếp tục sử dụng.";
                            }
                        }
                    } else {
                        $data['status'] = 'fail';
                        $data["message"] = "Tài khoản hoặc mật khẩu không đúng. Vui lòng nhập lại.";

                    }
                } else {
                    $data['status'] = 'fail';
                    $data["message"] = "Email này chưa tồn tại. Vui lòng đăng ký.";
                }
            }
            die(json_encode($data));
        }
    }

    public function forgot(){
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            if ($this->form_validation->run() === FALSE) {
                $this->data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else{
                $email = $this->input->post('email');
                $member = new Member();
                $member->where('Email', $email)->get(1);
                if(isset($member->ID) && $member->ID != null){
                    $token = md5(time());
                    $arr = array(
                        'Token' => $token
                    );
                    $member->where('Email', $email)->update($arr);
                    $to = $email;
                    $subject = 'Quên mật khẩu.';
                    $url_reset = base_url('/accounts/reset/?token='.$token.'&email='.$email);
                    $message = '<a href="'.$url_reset.'">'.$url_reset.'</a>';
                    sendmail($to,$subject,$message);
                    $this->data['success'] = 'Đã gửi yêu cầu thành công. Vui lòng kiểm tra hộp mail của bạn để tạo lại mật khẩu mới.';
                }
                else{
                    $this->data['message'] = 'Email này không tồn tại.';
                }
            }
        }
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/account/forgot',$this->data);
        $this->load->view('fontend/block/footer',$this->data);
    }

    public function reset(){
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        if( !(isset($token) && $token != null) ){
            redirect('/accounts/forgot/');
            die;
        }
        $member = new Member();
        $member->where(array('Email' => $email ,'Token' => $token))->get(1);
        if(isset($member->ID) && $member->ID != null){
            $this->data['email'] = $email;
            $this->data['token'] = $token;

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
                                'Token' => '',
                                'Pwd'   => md5(md5($email) . md5($password))
                            );
                            $member->where('Email', $email)->update($arr);
                            $this->data['success'] = 'Mật khẩu đã đổi thành công. Vui lòng đăng nhập lại để kiểm tra.';
                        }
                    }
                }
            }

        }
        else{
            redirect('/accounts/forgot/');
            die;
        }
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/account/reset',$this->data);
        $this->load->view('fontend/block/footer',$this->data);
    }

    private function fetchData($url,$data = null){
        $curl = $url;
        if(isset($data) && $data !=null && is_array($data)) {
          $request = '?';
          $i = 0;
          foreach ($data as $key => $value) {
              $request .= $key.'='.urlencode($value);
              if($i < count($data) - 1 ){
                 $request .='&';
              }
              $i++;
          }
          $curl = $url.$request;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt($ch, CURLOPT_URL, $curl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}

