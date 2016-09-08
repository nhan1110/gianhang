<?php

if (!defined('BASEPATH'))exit('No direct script access allowed');

class Contact extends CI_Controller {
  public $user_id = 0;
  public $data;
  private $secret = '6LejPCcTAAAAAMGS0Sckk1onmnmUGiEhe5_bg1Td';
  public function __construct() { 
    parent::__construct();
    $this->load->helper('url');
    $this->load->helper('date', 'captcha');
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

  public function index() {

    if($this->input->post()){
  
      $this->load->library('form_validation');
      $this->form_validation->set_rules('title', 'Title', 'required|max_lenght[100]');
      $this->form_validation->set_rules('content', 'Content', 'required|max_lenght[1000]');
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_lenght[50]');
      $this->form_validation->set_rules('phone', 'Phone', 'required|is_numeric|min_length[9]|max_lenght[15]');
      $this->form_validation->set_rules('fullname', 'Fullname', 'required|max_lenght[50]');
      if($this->form_validation->run()) {
        
        check_ajax();
        //$data["status"] = "error";
        $data["message"] = '';
        $verifyResponse = $this->fetchData('https://www.google.com/recaptcha/api/siteverify?secret='.$this->secret.'&response='.$this->input->post('response'));
        $response = file_get_content($verifyResponse);
        $response = json_decode($response);
        if ($response->success == true) {
           //$data['status'] = 'fail';
          

        $Feedback = new Feedbacks();
        $Feedback->Title    = $this->input->post('title');
        $Feedback->Content  = $this->input->post('content');
        $Feedback->Email    = $this->input->post('email');
        $Feedback->Phone    = $this->input->post('phone');
        $Feedback->Fullname = $this->input->post('fullname');
        $Feedback->Date_Create = date('Y-m-d H:i:s');
        $Feedback->Type = 'feedback';
        $Feedback->save();

        $from_email = "feddback@gmail.com";
        $to_email = $this->input->post('email'); 
        
        //Load email library
        $this->load->library('email');

        $config['protocol']  = 'sendmail';
        $cocfig['smtp_host'] = 'http://gianhangcuatoi.com';
        $config['charset']   = 'utf-8';
        $config['mailtype']  = 'html';
        $config['wordwrap']  = TRUE;
        $this->email->initialize($config);
   
        $this->email->from($from_email, 'GIANHANGCUATOI');
        $this->email->to($to_email);
        $this->email->subject('Email Feedback');
        $data = array(
         	'userName' => 'Anil Kumar Panigrahi',
          'to_email_name' => $this->input->post('fullname')
          );
        $body = $this->load->view('fontend/include/send_mail_template',$data,TRUE);
        $this->email->message($body);

        //Send mail
        if($this->email->send()) {
          $this->session->set_flashdata("email_send", "<div title='Thông báo !' class='email_send'>Gửi email thành công! <br> GIANHANGCUATOI sẽ gửi email xác nhận khi nhận được tin nhắn của bạn. Email của bạn sẽ được xem xét trong vòng 24h. Cảm ơn bạn đã gửi tin nhắn!</div>");
        }
        else {
          $this->session->set_flashdata("email_send","Error in sending Email.");
        }
        
        redirect('http://gianhangcuatoi.com/help/contact');
      }
    }
  }
    $this->load->view('fontend/block/header');
    $this->load->view('fontend/include/contact');
    $this->load->view('fontend/block/footer');
  }
  function logout(){
    $this->session->sess_destroy();
  }
}