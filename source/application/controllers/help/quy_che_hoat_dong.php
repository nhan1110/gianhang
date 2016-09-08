<?php

if (!defined('BASEPATH'))exit('No direct script access allowed');

class Quy_che_hoat_dong extends MY_Controller {

  public function __construct() {
    parent::__construct();
    //$this->load->model('common_model');
  }

  public function index() {

    //$data['list'] = $this->common_model->findAll();
    $this->load->view('fontend/block/header');
    $this->load->view('fontend/include/quy_che');
    $this->load->view('fontend/block/footer');
  }
}
