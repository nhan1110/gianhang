<?php

/*
  Created on : Feb 15, 2016, 7:00:18 PM
  Author     : phanquanghiep
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Events extends MY_Controller {
	private $data;
    public function __construct() {
        parent::__construct();
        $this->load->library('pagination');
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '350px');
    }
    public function index() {
    	$e = new Event();
    	$this->data["template"] = $e->get_raw()->result_array();
		$this->load->view('backend/include/header',$this->data);
    	$this->load->view('backend/events/index',$this->data);
    	$this->load->view('backend/include/footer',$this->data);
    }
    public function add() {
    	if($this->input->post()){
    		$e = new Event();
    		$colums = $this->db->list_fields('Events');
    		$this->data["record"]= $this->input->post();
			$data_insert = $this->input->post();
            foreach ($data_insert as $key => $value) {
                if(in_array($key, $colums)){
                    $e->{$key} = $value;
                }	           
            }
            $e->Createat = date("Y-m-d H:i:s");
        	$e->save();
        	$id = $e->db->insert_id();
        	redirect(base_url("admin/events/edit/".$id));
    	}
    	$e = new Email_Templates();
    	$np = new Events_Popup();
    	$email_id = $e->get_raw()->result_array();
    	$np_id = $np->get_raw()->result_array();
    	$this->data["email_template"] = $email_id;
    	$this->data["popup_template"] = $np_id;
    	$this->load->view('backend/include/header',$this->data);
	    $this->load->view('backend/events/add-edit',$this->data);
	    $this->load->view('backend/include/footer',$this->data);
    }
    public function edit($id = null) {
    	$e = new Event();
    	$this->data["record"]= $e->where("ID",$id)->get_raw()->row_array();
    	if($id!= null && is_numeric($id) && $this->data["record"] != null){
			if($this->input->post()){
				$colums = $this->db->list_fields('Events');
				$data_update = $this->input->post();
	            foreach ($data_update as $key => $value) {
	                if(!in_array($key, $colums)){
	                    unset($data_update[$key]);
	                }	           
	            }
	            $e->where("ID", $id)->update($data_update);
        		redirect(base_url("admin/events/edit/".$id));
        	}
    		$em = new Email_Templates();
	    	$np = new Events_Popup();
	    	$email_id = $em->get_raw()->result_array();
	    	$np_id = $np->get_raw()->result_array();
	    	$this->data["email_template"] = $email_id;
	    	$this->data["popup_template"] = $np_id;
	    	$this->load->view('backend/include/header',$this->data);
		    $this->load->view('backend/events/add-edit',$this->data);
		    $this->load->view('backend/include/footer',$this->data);
    		
    	}else{
    		redirect(base_url("admin/events/popup/edit/".$id));
    	}
    }
    public function popup($action = null,$id = null){
    	$view = "popup";
    	$colums = $this->db->list_fields('Events_Popup');
    	$this->data["error"] = FALSE;
    	if($this->input->post()){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('Title', 'Tiêu đề', 'required',['required'=> 'Thuộc tính %s không được trống.']);
		    if ($this->form_validation->run() == FALSE){
          		$this->data["error"] = true;
          	}
      	}
    	$e = new Events_Popup();
    	//index.
    	if($action == null){
    		$this->data["template"] = $e->get_raw()->result_array();
    	}else{
    		//add new.
			if($action == "add"){
				$view = "popup_add_edit";
				$this->data["title_page_template"]="Thêm mới";
				if($this->input->post() && !$this->data["error"]){
					$this->data["record"]= $this->input->post();
					$data_insert = $this->input->post();
		            foreach ($data_insert as $key => $value) {
		                if(in_array($key, $colums)){
		                    $e->{$key} = $value;
		                }	           
		            }
		            $e->Createat = date("Y-m-d H:i:s");
	            	$e->save();
	            	$id = $e->db->insert_id();
	            	redirect(base_url("admin/events/popup/edit/".$id));
	        	}
			}elseif($id != null && is_numeric($id)){
				//edit.
				if($action == "edit"){
					$this->data["title_page_template"]="Cập nhật";
					$view = "popup_add_edit";
					if($this->input->post() && !$this->data["error"]){
						$data_update = $this->input->post();
			            foreach ($data_update as $key => $value) {
			                if(!in_array($key, $colums)){
			                    unset($data_update[$key]);
			                }	           
			            }
			            $e->where("ID", $id)->update($data_update);
	            		redirect(base_url("admin/events/popup/edit/".$id));
	            	}
	            	$this->data["record"] = $e->where("ID",$id)->get_raw()->row_array();
	            	if($this->data["record"] == null){
	            		redirect(base_url("admin/events/popup"));
	            	}

				}
				//delete
				elseif($action == "delete"){
					$this->db->delete("Events_Popup", array("ID" => $id));
					redirect(base_url("admin/events/popup"));
				}
				else{
					redirect(base_url("admin/events/popup"));
				}

			}else{
				redirect(base_url("admin/events/popup"));
			}
    	}
    	if($view != ""){
    		$this->load->view('backend/include/header',$this->data);
	    	$this->load->view('backend/events/'.$view.'',$this->data);
	    	$this->load->view('backend/include/footer',$this->data);
    	}else{
    		redirect(base_url("admin/events/popup"));
    	}	
    }
    private function _editor($path,$height) {
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

