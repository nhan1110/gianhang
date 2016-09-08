<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Payment extends MY_Controller {
  private $data = array();
  
  public function __construct() {
    parent::__construct();
    $this->data["title_page"] = "Payment";
  }

  public function index() {
    $ps = new Payments();
    if($this->input->post()){
    	$data_update = array("Setting" => json_encode($this->input->post()));
    	$ps->where("Slug","payment")->update($data_update);
    }
    $this->data["record"] = $ps->where("Slug","payment")->get_raw()->row_array();
    $et = new Email_Templates();
    $this->data["payments"] = $ps->where("Show","1")->get_raw()->result_array();
    $this->data["email_template"] = $et->get_raw()->result_array();
    $this->data["load_view"] = "payment";
    $this->data["data_wrapper"] = "payment";
    $this->load->view('backend/include/header');
    $this->load->view('backend/payment/index', $this->data);
    $this->load->view('backend/include/footer');
  }

  public function add_new(){
    $this->load->view('backend/include/header');
    $this->load->view('backend/payment/index', $this->data);
    $this->load->view('backend/include/footer');
  }

  public function gateway($slug = null){
    $ps = new Payments();
    $record = $ps->where("Slug",$slug)->get_raw()->row_array();
    if($record != null){
        if($this->input->post()){
          $validation = true;
          $setting = json_decode($record["Setting"],true);
            $data_update = array("Setting" => json_encode($this->input->post("setting")));
            $data_update["Description"] = $this->input->post("description");
            $ps->where("Slug",$slug)->update($data_update);
        }
        $record = $ps->where("Slug",$slug)->get_raw()->row_array();
        $this->data["title_page"] = $this->data["title_page"]. " | ".$record["Title"]."";
        $this->data["load_view"] = $slug;
        $this->data["data_wrapper"] = $slug;
        $this->data["title_curent"] = $record["Title"];
        $this->data["record"] = $record ;
        $this->load->view('backend/include/header');
        $this->load->view('backend/payment/index', $this->data);
        $this->load->view('backend/include/footer');
    }  
  }

  public function upgrade($action = null,$id = null){
  	$view = "upgrade";
  	$upgrade = new Upgrades();
  	$this->data["error"] = false;
  	$this->data["upgrade"] = [];
  	if($action == null){
  		$all = $upgrade->get_raw()->result_array();
  		$this->data["upgrade"] = $all;
  	}else{
  		if($this->input->post()){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('Number_Month', 'Số tháng', 'required|numeric|min_length[1]|max_length[12]',['required'=> 'Thuộc tính %s không được trống.']);
		    $this->form_validation->set_rules('Price_One_Month', 'Giá một tháng', 'required|numeric|min_length[1]',['required'=> 'Thuộc tính %s không được trống.']);
			if ($this->form_validation->run() == FALSE){
                $this->data["error"] = true;
            }
		}
  		if($action == "add"){
  			if($this->input->post() && !$this->data["error"]){
  				$this->data["record"] = $this->input->post();
  				$colums = $this->db->list_fields('Upgrades');
  				$data_insert = $this->input->post();
	            foreach ($data_insert as $key => $value) {
	                if(in_array($key, $colums)){
	                    $upgrade->{$key} = $value;
	                }	           
	            }
	            $upgrade->save();
	            $id = $upgrade->db->insert_id();
	            redirect(base_url("admin/payment/upgrade/edit/".$id));
  			}
  			$view = "upgrade_add_edit";
  		}elseif ($action == "edit" && $id != null && is_numeric($id)) {
  			$this->data["record"] = $upgrade->where("ID",$id)->get_raw()->row_array();
  			if($this->data["record"] != null){
  				if($this->input->post() && !$this->data["error"]){
	  				$this->data["record"] = $this->input->post();
	  				$colums = $this->db->list_fields('Upgrades');
	  				$data_update = $this->input->post();
		            foreach ($data_update as $key => $value) {
		                if(!in_array($key, $colums)){
		                    unset($data_update[$key]);
		                }	           
		            }
		            $upgrade->where("ID", $id)->update($data_update);
		            redirect(base_url("admin/payment/upgrade/edit/".$id));
	  			}
	  			$view = "upgrade_add_edit";
	  		}else{
	  			redirect(base_url("admin/payment/upgrade"));
	  		}	
  			
  		}elseif ($action == "delete" && $id != null && is_numeric($id)) {
  			$this->db->delete("Upgrades", array("ID" => $id));
  			redirect(base_url("admin/payment/upgrade"));
  		}else{
  			redirect(base_url("admin/payment/upgrade"));
  		}
  	}
  	$this->load->view('backend/include/header');
    $this->load->view('backend/payment/'.$view.'', $this->data);
    $this->load->view('backend/include/footer');
  }

  public function active(){
    check_ajax();
    $id = $this->input->post("id");
    $ps = new Payments();
    $record = $ps->where("ID",$id)->get_raw()->row_array();
    if($record != null){
      $active = ($record["Status"] == "0") ? "1" : "0";
      $data_update = array("Status" =>$active);
      $ps->where("ID",$id)->update($data_update);
    }
  }
  
}
