<?php
/*
  Created on : 
  Author     : truongphuocvui
 */
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Block extends MY_Controller {

  public function __construct() {
    parent::__construct();
    //$this->load->model('common_model');
  }

  public function index() {

    //$data['list'] = $this->common_model->findAll();
    $this->load->view('backend/include/header');
    $this->load->view('backend/block-page/index', array('error' =>' '));
    $this->load->view('backend/include/footer');
  }

  public function xulythem()
  {

    $this->load->helper( array('form', 'url'));
    $config = array();
    $config['upload_path'] = "./uploads/user/";
    $config['allowed_types'] = 'jpg|png|gif|jpeg';
    $path_upload = "./uploads/user/";
    $this->response = '';
    $this->success  = TRUE;
    $this->load->library('upload');
    $this->upload->initialize($config);

    if(!$this->upload->do_upload('image')){

      $this->success  = FALSE;
      $this->response = $this->upload->display_errors();
      return FALSE;

    }else{
      $this->success  = TRUE;
      $file_data = $this->upload->data();
      $path_upload = base_url().'uploads/user/'.$file_data['file_name'];
      $title = $this->input->post('name');
      $content = $this->input->post('description');
      $keyword = $this->input->post('content');
      
      $arr = array(
          'Name' => $title,
          'Description' => $content,
          'Logo' => $path_upload,
          'Banner' => $path_upload,
          'Content' =>  $content,
          //'date_create' => date('Y-m-d H:i:s')
          );
          
          
      $article_id = $this->Common_model->add('Block',$arr);//insert database
      //$this->db->insert_batch('mytable', $data); 
    }
    redirect(base_url().'admin/block');
  }

       
}
