<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_template extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session'); 
        $this->load->helper('url'); 
    }

    public function index(){
    	$email_template = new Email_Templates();
    	$email_template->order_by('Title','ASC');
    	$email_template->get();
        $data['email_template'] = $email_template;
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/email_template/index',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function edit($email_id = null){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required');
        //$this->form_validation->set_rules('header', 'Header', 'required');
        //$this->form_validation->set_rules('content', 'Content', 'required');
        //$this->form_validation->set_rules('footer', 'Footer', 'required');
        $this->form_validation->set_rules('key', 'Key', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

    	$data['action'] = base_url().'admin/email_template/edit/'.$email_id;
        if( !(isset($email_id) && $email_id!=null && is_numeric($email_id)) ){
            redirect(base_url().'admin/members');
            die;
        }
        $email_template = new Email_Templates();
        $email_template->where('ID',$email_id)->get();
        if( !(isset($email_template->ID) && $email_template->ID != null) ){
            redirect(base_url().'admin/email_template');
            die;
        }
        if($this->input->post()){
            if ($this->form_validation->run() === FALSE) {
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else{
                $key = $this->gen_slug($this->input->post('key'));
                $email_template = new Email_Templates();
                $email_template->where('Key',$key)->get(1);
                if(isset($email_template->ID) && $email_template->ID != null && $email_template->ID != $email_id){
                    $data['message'] = 'Key này đã tồn tại.';
                }
                else{
                    $arr = array(
                        'Title' => $this->input->post('title'),
                        'Key' => $key,
                        'Header' => $this->input->post('header'),
                        'Content' => $this->input->post('content'),
                        'Footer' => $this->input->post('footer'),
                        'Status' => $this->input->post('status')
                    );
                    $email_template = new Email_Templates();
                    $email_template->where('ID',$email_id)->update($arr);
                    redirect(base_url().'admin/email_template/edit/'.$email_id);
                }
            }          
        }
    	$data['label'] = "Edit";
        $data['email_template'] = $email_template;
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '400px');
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/email_template/add',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function add(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('header', 'Header', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('footer', 'Footer', 'required');
        $this->form_validation->set_rules('key', 'Key', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        if($this->input->post()){
            $key = $this->gen_slug($this->input->post('key'));
            if ($this->form_validation->run() === FALSE) {
                $email_template = new Email_Templates();
                $email_template->Title = $this->input->post('title');
                $email_template->Key = $key;
                $email_template->Header = $this->input->post('header');
                $email_template->Content = $this->input->post('content');
                $email_template->Footer = $this->input->post('footer');
                $email_template->Status = $this->input->post('status');
                $data['email_template'] = $email_template;
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else{
                $email_template = new Email_Templates();
                $email_template->where('Key',$key)->get(1);
                if(isset($email_template->ID) && $email_template->ID != null){
                    $data['message'] = 'Key này đã tồn tại.';
                }
                else{
                    $email_template = new Email_Templates();
                    $email_template->Title = $this->input->post('title');
                    $email_template->Key = $key;
                    $email_template->Header = $this->input->post('header');
                    $email_template->Content = $this->input->post('content');
                    $email_template->Footer = $this->input->post('footer');
                    $email_template->Status = $this->input->post('status');
                    if($email_template->save()){
                        $email_id = $email_template->get_id_last_save();
                        redirect(base_url().'admin/email_template/edit/'.$email_id);
                    }
                }
            }
        }
    	$data['action'] = base_url().'admin/email_template/add/';
    	$data['label'] = "Add";
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '400px');

    	$this->load->view('backend/include/header',$data);
        $this->load->view('backend/email_template/add',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function delete($email_id = null){
    	if(isset($email_id) && $email_id!=null && is_numeric($email_id)){
    		$email_template = new Email_Templates();
          	$email_template->where('ID',$email_id)->get();
          	$email_template->delete_by_id($email_template->ID);
    	}
    	redirect(base_url().'admin/email_template');
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