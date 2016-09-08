<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feedback extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session'); 
        $this->load->helper('url'); 
    }

    public function index(){
    	$feedbacks = new Feedbacks();
    	$feedbacks->order_by('Title','ASC');
    	$feedbacks->get();
        $data['feedbacks'] = $feedbacks;
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/feedback/index',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function edit($feedback_id = null){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

    	$data['action'] = base_url().'admin/feedback/edit/'.$feedback_id;
        if( !(isset($feedback_id) && $feedback_id!=null && is_numeric($feedback_id)) ){
            redirect(base_url().'admin/feedback');
            die;
        }
        $feedbacks = new Feedbacks();
        $feedbacks->where('ID',$feedback_id)->get();
        if( !(isset($feedbacks->ID) && $feedbacks->ID != null) ){
            redirect(base_url().'admin/feedback');
            die;
        }
        if($this->input->post()){
            if ($this->form_validation->run() === FALSE) {
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else{
                $arr = array(
                    'Title' => $this->input->post('title'),
                    'Content' => $this->input->post('content'),
                    'Type' => $this->input->post('type'),
                    'Status' => $this->input->post('status')
                );
                $feedbacks = new Feedbacks();
                $feedbacks->where('ID',$feedback_id)->update($arr);
                redirect(base_url().'admin/feedback/edit/'.$feedback_id);
            }      
        }
    	$data['label'] = "Edit";
        $data['feedback'] = $feedbacks;
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '400px');
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/feedback/add',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function add(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        if($this->input->post()){
            $feedbacks = new Feedbacks();
            $feedbacks->Title = $this->input->post('title');
            $feedbacks->Content = $this->input->post('content');
            $feedbacks->Type = $this->input->post('type');
            $feedbacks->Status = $this->input->post('status');

            if ($this->form_validation->run() === FALSE) {
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
                $data['feedback'] = $feedbacks;
            }
            else{
                $feedbacks->Date_Create = date('Y-m-d H:i:s');
                if($feedbacks->save()){
                    $email_id = $feedbacks->get_id_last_save();
                    redirect(base_url().'admin/feedback/edit/'.$email_id);
                }
            }
        }
    	$data['action'] = base_url().'admin/feedback/add/';
    	$data['label'] = "Add";
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '400px');

    	$this->load->view('backend/include/header',$data);
        $this->load->view('backend/feedback/add',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function delete($feedback_id = null){
    	if(isset($feedback_id) && $feedback_id!=null && is_numeric($feedback_id)){
    		$feedbacks = new Feedbacks();
          	$feedbacks->where('ID',$feedback_id)->get();
          	$feedbacks->delete_by_id($feedbacks->ID);
    	}
    	redirect(base_url().'admin/feedback');
    }

    private function gen_slug($str) {
        $a = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ", " ");
        $b = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A ", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D", "-");
        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), str_replace($a, $b, $str)));
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