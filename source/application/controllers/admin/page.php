<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session'); 
        $this->load->helper('url'); 
    }

    public function index(){
    	$pages = new Pages();
    	$pages->order_by('Page_Createdat','DESC');
    	$pages->get();
        $data['pages'] = $pages;
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/block-page/index',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function edit($page_id = null){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('content', 'Content', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

    	$data['action'] = base_url().'admin/page/edit/'.$page_id;
        if( !(isset($page_id) && $page_id!=null && is_numeric($page_id)) ){
            redirect(base_url().'admin/page');
            die;
        }
        $pages = new Pages();
        $pages->where('ID',$page_id)->get();
        if( !(isset($pages->ID) && $pages->ID != null) ){
            redirect(base_url().'admin/page');
            die;
        }
        if($this->input->post()){
            if ($this->form_validation->run() === FALSE) {
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else{
                $arr = array(
                    'Page_Title' => $this->input->post('title'),
                    'Page_Content' => $this->input->post('content'),
                    'Page_Description' => $this->input->post('description'),
                    'Page_Feature_Image' => $this->input->post('feature_image'),
                    'Page_Type' => $this->input->post('type'),
                    'Page_Status' => $this->input->post('status'),
                    'Page_Updatedat' => date('Y-m-d H:i:s')
                );
                $pages = new Pages();
                $pages->where('ID',$page_id)->update($arr);
                redirect(base_url().'admin/page/edit/'.$page_id);
            }      
        }
    	$data['label'] = "Edit";
        $data['pages'] = $pages;
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '400px');
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/block-page/add',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function add(){
        $this->load->library('Helperclass');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('content', 'Content', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        if($this->input->post()){
            $pages = new Pages();
            $pages->Page_Title = $this->input->post('title');
            $pages->Page_Slug = $this->helperclass->slug($pages->table,"Page_Slug",$this->input->post('title'));
            $pages->Page_Content = $this->input->post('content');
            $pages->Page_Type = $this->input->post('type');
            $pages->Page_Status = $this->input->post('status');
            $pages->Page_Description = $this->input->post('description');
            $pages->Page_Feature_Image = $this->input->post('feature_image');
            $pages->Page_Sort = 0;
            if ($this->form_validation->run() === FALSE) {
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
                $data['pages'] = $pages;
            }
            else{
                $pages->Page_Createdat = date('Y-m-d H:i:s');
                $pages->Page_Updatedat = date('Y-m-d H:i:s');
                if($pages->save()){
                    $page_id = $pages->get_id_last_save();
                    redirect(base_url().'admin/page/edit/'.$page_id);
                }
            }
        }
    	$data['action'] = base_url().'admin/page/add/';
    	$data['label'] = "Add";
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '400px');

    	$this->load->view('backend/include/header',$data);
        $this->load->view('backend/block-page/add',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function delete($page_id = null){
    	if(isset($page_id) && $page_id!=null && is_numeric($page_id)){
    		$pages = new Pages();
          	$pages->where('ID',$page_id)->get();
          	$pages->delete_by_id($pages->ID);
    	}
    	redirect(base_url().'admin/page');
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
}