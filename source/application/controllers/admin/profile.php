<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		$this->load->library(array(
            'pagination',
            'form_validation',
            "session"
        ));
	}

	function index() {
		die('Profile');
    }
    
    function logout() {
        $this->session->sess_destroy();
        redirect('admin/login');
    }

}