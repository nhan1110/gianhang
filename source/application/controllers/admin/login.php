<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public $user_id = 0;
	function __construct() {
		parent::__construct();
	}
	public function index() {
        if ($this->session->userdata('admin_logged_in') === FALSE) {
            $data['title'] = 'Login';
            $data['error'] = FALSE;
            if ($this->input->post()) { // vmadmin.admin@123
            	$user_nick = $this->input->post('email');
                $user_pwd = $this->input->post('password');
            	$user = new Users_model();
		      	$user->where('User_Nick', $user_nick);
		      	$user->or_where('User_Email', $user_nick);
		      	$user->get();
		      	if ($user->User_Pwd !== null && $user->User_Pwd === md5($user->User_Nick . "." . $user_pwd)) {
		      		$dataArr = array(
                        'admin_logged_in' => TRUE,
                        'user_id' => $user->ID,
                        'user_nick' => $user->User_Nick,
                        'user_email' => $user->User_Email,
                        'user_avatar' => empty($user->User_Avatar) ? skins_url('images/default_avatar.png') : $user->User_Avatar,
                        'type_member' => "System"
                    );
                    $this->session->set_userdata("admin_logged_in", $dataArr);
                    $this->session->set_userdata("admin_info", $dataArr);
                    redirect('admin/menu');
	      		} else {
	      			$data['error'] = TRUE;
	      			$data['message'] = 'Your user or Your password does not match. Please try again.';
	      		}
            }
            $this->load->view("backend/login/index", $data);
        } else {
            redirect('admin/menu');
        }

    }
    function logout(){
        $this->session->sess_destroy();
    }

}