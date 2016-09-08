<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Like extends CI_Controller {

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


    public function index(){
    	$this->_is_login();
    	$this->_is_ajax();
        $data = array('status' => 'error');
        $type = $this->input->post('type');
        $type_id = $this->input->post('id');
        if(!(isset($type) && $type == 'product')){
            die(json_encode($data));
        }
        $product = new Products();
        $product->where(array('ID' => $type_id))->get(1);
        if(!(isset($product->ID) && $product->ID != null)){
            die(json_encode($data));
        } 
        $url = '/product/details/'.$product->Slug;

        $tracking_like = new Tracking_Like();
        $tracking_like->where(array('Member_ID' => $this->user_id,'URL' => $url))->get(1);
        if(isset($tracking_like->Is_Like) && $tracking_like->Is_Like != null){
            if($tracking_like->Is_Like == 1){
                $arr = array('Is_Like' => 0);
                $data['like'] = -1;
                $tracking_like->where(array('Member_ID' => $this->user_id,'URL' => $url))->update($arr);
            }
            else{
                $arr = array('Is_Like' => 1);
                $data['like'] = 1;
                $tracking_like->where(array('Member_ID' => $this->user_id,'URL' => $url))->update($arr);
            }
        }
        else{
            $data['like'] = 1;
            $tracking_like_new = new Tracking_Like();
            $tracking_like_new->Member_ID = $this->user_id;
            $tracking_like_new->URL = $url;
            $tracking_like_new->Is_Like = 1;
            $tracking_like_new->Date_Creat = date('Y-m-d H:i:s');
            $tracking_like_new->save();
        }

        $tracking = new Tracking();
        $tracking->where(array('URL' => $url))->get(1);
        if(isset($tracking->ID) && $tracking->ID != null ){
            if($data['like'] == 1){
                $num_like = $tracking->Num_Like + 1;
            }
            else{
                $num_like = $tracking->Num_Like - 1;
            }
            $arr = array(
                'Num_Like' => $num_like
            );
            $tracking->where(array('URL' => $url))->update($arr);
        }
        else{
            $tracking = new Tracking();
            $tracking->URL = $url;
            $tracking->Num_Rate = 0;
            $tracking->Num_View = 0;
            $tracking->Num_Comment = 0;
            $tracking->Num_Like = 1;
            $tracking->Num_Share_Facebook = 0;
            $tracking->Num_Share_Google = 0;
            $tracking->save();
        }

        $data['status'] = 'success';
        die(json_encode($data));
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