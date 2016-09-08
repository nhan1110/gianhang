<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('backend/include/header');
        $this->load->view('backend/dashboard/index');
        $this->load->view('backend/include/footer');
    }

    public function layout_top() {
        $this->load->view('backend/include/header');
        $this->load->view('backend/dashboard/layout-top');
        $this->load->view('backend/include/footer');
    }

}
