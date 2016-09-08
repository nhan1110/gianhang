<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session'); 
        $this->load->helper('url'); 
    }

    public function index() {
    	$model = new Notification_model();
    	$model->order_by('Created_at','DESC');
    	$model->get();
        $data['collections'] = $model;
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/notification/index',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function edit($id = null) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('content', 'Content', 'trim|required');
        $this->form_validation->set_rules('type_notification', 'Type_Notification', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
    	
        if (!(isset($id) && $id != null && is_numeric($id))) {
            redirect(base_url().'admin/notification');
            die;
        }
        $model = new Notification_model();
        $model->where('ID',$id)->get();
        if (!(isset($model->ID) && $model->ID != null)) {
            redirect(base_url().'admin/notification');
            die;
        }
        
        if ($this->input->post()) {
            if ($this->form_validation->run() === FALSE) {
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else {
                $arr = array(
                    'Title' => $this->input->post('title'),
                    'Content' => $this->input->post('content'),
                    'Type_Notification' => $this->input->post('type_notification'),
                    'Status' => $this->input->post('status')
                );
                $model = new Notification_model();
                $model->where('ID',$id)->update($arr);
                redirect(base_url().'admin/notification/edit/'.$id);
            }
        }
        
        $data['action'] = base_url().'admin/notification/edit/'.$id;
        $data['cancel'] = base_url().'admin/notification/';
    	$data['label'] = "Edit";
        $data['row'] = $model;
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '400px');
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/notification/add',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('content', 'Content', 'trim|required');
        $this->form_validation->set_rules('type_notification', 'Type_Notification', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        if ($this->input->post()) {
            $model = new Notification_model();
            $model->Title = $this->input->post('title');
            $model->Content = $this->input->post('content');
            $model->Type_Notification = $this->input->post('type_notification');
            $model->Status = $this->input->post('status');

            if ($this->form_validation->run() === FALSE) {
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
                $data['row'] = $model;
            }
            else {
                $model->Created_at = date('Y-m-d H:i:s');
                if ($model->save()) {
                    $id = $model->get_id_last_save();
                    redirect(base_url().'admin/notification/edit/'.$id);
                }
            }
        }
        $data['cancel'] = base_url().'admin/notification/';
    	$data['action'] = base_url().'admin/notification/add/';
    	$data['label'] = "Add";
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '400px');

    	$this->load->view('backend/include/header',$data);
        $this->load->view('backend/notification/add',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function delete($id = null) {
    	if (isset($id) && $id != null && is_numeric($id)) {
    		$model = new Notification_model();
          	$model->where('ID', $id)->get();
          	$model->delete_by_id($model->ID);
    	}
    	redirect(base_url().'admin/notification');
    }

    function _editor($path,$height) {
        // Loading Library For Ckeditor
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        // Configure base path of ckeditor folder 
        $this->ckeditor->basePath = base_url().'skins/js/ckeditor/';
        $this->ckeditor->config['toolbar'] = 'Full';
        $this->ckeditor->config['language'] = 'vi';
        $this->ckeditor->config['height'] = $height;
        // Configure ckfinder with ckeditor config 
        $this->ckfinder->SetupCKEditor($this->ckeditor,$path); 
    }
}