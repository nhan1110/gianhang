<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends CI_Controller {

    private $is_login = false;
    private $user_info = array();
    private $user_id = 0;
    private $data = array();

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
            $this->type_member = $this->user_info["type_member"];
        }
        $this->data["is_login"] = $this->is_login;
        $this->data["user_info"] = $this->user_info;
    }

    public function add(){
    	$this->_is_login();
    	$this->_is_ajax();
        $data = array('status' => 'error');
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('content', 'Content', 'trim|required');
            $this->form_validation->set_rules('url', 'URL', 'trim|required');
            if ($this->form_validation->run() === FALSE) {
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
                die(json_encode($data));
            }
            else{
                $comment = new Comments();
                $comment->URL  = $this->input->post('url');
                $comment->Parent_ID  = $this->input->post('parent_id') == null ? 0 : $this->input->post('parent_id');
                $comment->Member_ID = $this->user_id;
                $comment->Content  = $this->input->post('content');
                $comment->Createdat = date('Y-m-d H:i:s');
                $comment->Updatedat = date('Y-m-d H:i:s');
                $comment->Setting_ID = 0;
                $comment->save();
                $comment_id = $comment->get_id_last_save();
                if(isset($comment_id) && is_numeric($comment_id) && $comment_id > 0){
                    $data['status'] = 'success';
                    $data['responsive'] = $this->_responsive($comment_id);
                }
            }
        }
        die(json_encode($data));
    }

    public function edit($comment_id = null){
    	$this->_is_login();
    	$this->_is_ajax();
        $data = array('status' => 'error');
        if(!(isset($comment_id) && $comment_id != null && is_numeric($comment_id))){
            die(json_encode($data));
        }
        $comment = new Comments();
        $comment->where(array('ID' => $comment_id,'Member_ID' => $this->user_id))->get(1);
        if( !(isset($comment->ID) && $comment->ID !=null) ){
            die(json_encode($data));
        }
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('content', 'Content', 'trim|required');
            if ($this->form_validation->run() === FALSE) {
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
                die(json_encode($data));
            }
            else{
                $arr = array(
                    'Content'   => $this->input->post('content'),
                    'Updatedat' => date('Y-m-d H:i:s')
                );
                $comment = new Comments();
                if( $comment->where(array('ID' => $comment_id,'Member_ID' => $this->user_id))->update($arr) ){
                    $data['status'] = 'success';
                    //$data['responsive'] = $this->_responsive($comment_id);
                }
            }
        }
        die(json_encode($data));
    }

    public function delete($comment_id = null){
    	$this->_is_login();
    	$this->_is_ajax();
        $data = array('status' => 'error');
        if(!(isset($comment_id) && $comment_id != null)){
            die(json_encode($data));
        }
        $comment = new Comments();
        $comment->where(array('ID' => $comment_id,'Member_ID' => $this->user_id))->get(1);
        if(!(isset($comment->ID) && $comment->ID !=null )){
            die(json_encode($data));
        }
        //Delete comment children
        $comment_childrens = new Comments();
        $comment_childrens->where(array('Parent_ID' => $comment_id,'Member_ID' => $this->user_id))->get();
        if(isset($comment_childrens) && $comment_childrens!=null) {
        	foreach ($comment_childrens as $key => $value) {
        		$comment_childrens->delete_by_id(@$value->ID);
        	}
        }

        $comment->delete_by_id($comment->ID);
        $data['status'] = 'success';
        die(json_encode($data));
    }

    public function get_comment(){
    	$this->_is_ajax();
        $responsive = array('status' => 'error');
        $limit = 4;
        $offset = $limit*($this->input->post('start') != null && is_numeric($this->input->post('start')) ? $this->input->post('start') : 0);
        $url = $this->input->post('url');
        if(isset($url) &&  $url!=null){
        	$member = new Member();
        	$comment = new Comments();
        	$sqc = "SELECT count(*) AS count
        			FROM $comment->table AS c
        			INNER JOIN $member->table AS m ON m.ID = c.Member_ID
        			WHERE c.URL = '$url' AND c.Parent_ID = '0'";
        	$sql = "SELECT c.*,m.Avatar,m.Firstname,m.Lastname
        			FROM $comment->table AS c
        			INNER JOIN $member->table AS m ON m.ID = c.Member_ID
        			WHERE c.URL = '$url' AND c.Parent_ID = '0'
        			ORDER BY c.ID DESC
        			LIMIT $offset, $limit ";
            $data['count']   = $comment->query($sqc);
            $data['result']  = $comment->query($sql);
            $data['url'] 	 = $url;
            $data['current'] = $offset + $limit;
            $data['user_id'] = $this->user_id;
            $responsive['status'] = 'success';
            $responsive['responsive'] = $this->load->view("fontend/comment/comment",$data,true);
        }
        die(json_encode($responsive));
    }

    public function get_more_comment($comment_id = null){
    	$this->_is_ajax();
    	$limit = 3;
        $responsive = array('status' => 'error');
        $url = $this->input->post('url');
        $offset = $limit*($this->input->post('offset') && is_numeric($this->input->post('offset')));
        if(isset($comment_id) && $comment_id!=null && is_numeric($comment_id)){
            $member = new Member();
            $comment = new Comments();
            $sql = "SELECT c.*,m.Avatar,m.Firstname,m.Lastname
        			FROM $comment->table AS c
        			INNER JOIN $member->table AS m ON m.ID = c.Member_ID
        			WHERE c.URL = '$url' AND c.Parent_ID = $comment_id
        			ORDER BY c.ID DESC
        			LIMIT $offset,$limit";
            $data['result']  = $comment->query($sql);
            $data['user_id'] = $this->user_id;
            $responsive['status'] = 'success';
            $responsive['sql'] = $sql;
            $responsive['responsive'] = $this->load->view("fontend/comment/comment_more_parent",$data,true);
        }
        die(json_encode($responsive));
    }

    function _responsive($comment_id = null){
        $comment = new Comments();
        $comment->where(array('ID' => $comment_id,'Member_ID' => $this->user_id))->get(1);
        $count =  $comment->where(array('Parent_ID' => $comment_id))->count();
        $responsive = array();
        $member = new Member();
        $member->where('ID', $this->user_id)->get(1);
        $responsive['full_name'] = @$member->Firstname.' '.@$member->Lastname;
        $responsive['avatar'] =  @$member->Avatar;
        $responsive['user_id'] = $this->user_id;
        $responsive['content'] = @$comment->Content;
        $responsive['comment_id'] = $comment_id;
        $responsive['count_comment_children'] = $count;
        $responsive['date'] = @$comment->Updatedat;
        return $responsive;
    }

    function _is_login(){
    	if(!$this->is_login){
    		if ($this->input->is_ajax_request()) {
	            die(json_encode(array('status' => 'error')));
	        } else {
	            redirect(base_url());
	        }
    	}
    }
    function _is_ajax(){
    	if(!$this->input->is_ajax_request()){
	        die(json_encode(array('status' => 'error')));
    	}
    }
}