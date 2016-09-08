<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Advertise_promo extends MY_Controller {
    private $data;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
    	$advertise_promo = new Advertise_Promos();
    	$advertise_promo->get();
        $this->data["advertise_promo"] = $advertise_promo;
	    $this->load->view('backend/include/header');
	    $this->load->view('backend/advertise_promo/index', $this->data);
	    $this->load->view('backend/include/footer');
    }

    public function add(){
    	$advertise_promo = new Advertise_Promos();
    	$colums = $this->db->list_fields($advertise_promo->table);
    	$advertise_block_page = new Advertise_Block_Page();
    	$advertise_block_page->get();

    	if($this->input->post()){
    		$this->load->library('form_validation');
			$this->form_validation->set_rules('Sale', 'Giảm giá', 'required|numeric',['required'=> 'Thuộc tính %s không được trống.']);
			$this->form_validation->set_rules('Apply', 'Áp dụng', 'required|numeric',['required'=> 'Thuộc tính %s không được trống.']);
    		$this->form_validation->set_rules('Unit' , 'Đơn vị', 'required',['required'=> 'Thuộc tính %s không được trống.']);
    		$this->form_validation->set_rules('Date_Start', 'Ngày bắt đầu', 'required',['required'=> 'Thuộc tính %s không được trống.']);
    		$this->form_validation->set_rules('Date_End', 'Ngày kết thúc', 'required',['required'=> 'Thuộc tính %s không được trống.']);
    		$this->form_validation->set_rules('Status', 'Trạng thái', 'required|numeric',['required'=> 'Thuộc tính %s không được trống.']);
    		if($this->form_validation->run() !== FALSE){
    			$advertise_promo = new Advertise_Promos();
    			$data = $this->input->post();
    			foreach ($data as $key => $value) {
    				if(in_array($key, $colums)){
    					$advertise_promo->{$key} = $value;
    				}
    			}
    			if($advertise_promo->save()){
    				$insert_id = $advertise_promo->db->insert_id();
    				$apply = $this->input->post('Apply');
    				if($apply == -1){
    					foreach ($advertise_block_page as $key => $value) {
    						$apbp = new Advertise_Promo_Block_Page();
	    					$apbp->Advertise_Promo_ID = $insert_id;
	    					$apbp->Advertise_Block_Page_ID = $value->ID;
	    					$apbp->save();
    					}
    				}
    				else{
    					$apbp = new Advertise_Promo_Block_Page();
    					$apbp->Advertise_Promo_ID = $insert_id;
    					$apbp->Advertise_Block_Page_ID = $apply;
    					$apbp->save();
    				}
    				redirect('/admin/advertise_promo/edit/'.$insert_id);
    				die;
    			}
    		}
    		else{
    			$this->data['error'] = true;
    			$this->data['record'] = $this->input->post();
    		}
    	}
    	$this->data['advertise_block_page'] = $advertise_block_page;
    	$this->load->view('backend/include/header');
	    $this->load->view('backend/advertise_promo/add', $this->data);
	    $this->load->view('backend/include/footer');
    }

    public function edit($id = null){
    	$advertise_promo = new Advertise_Promos();
    	$colums = $this->db->list_fields($advertise_promo->table);
    	$advertise_promo->where(array('ID' => $id))->get(1);
    	if(!(isset($advertise_promo->ID) && $advertise_promo->ID!=null)){
    		redirect('/admin/advertise_promo/add');
    		die;
    	}
    	$record = array();
    	foreach ($colums as $key) {
    		$record[$key] = $advertise_promo->{$key};
    	}
    	$this->data['record'] = $record;
    	$advertise_block_page = new Advertise_Block_Page();
    	$advertise_block_page->get();

    	if($this->input->post()){
    		$this->load->library('form_validation');
			$this->form_validation->set_rules('Sale', 'Giảm giá', 'required|numeric',['required'=> 'Thuộc tính %s không được trống.']);
			$this->form_validation->set_rules('Apply', 'Áp dụng', 'required|numeric',['required'=> 'Thuộc tính %s không được trống.']);
    		$this->form_validation->set_rules('Unit' , 'Đơn vị', 'required',['required'=> 'Thuộc tính %s không được trống.']);
    		$this->form_validation->set_rules('Date_Start', 'Ngày bắt đầu', 'required',['required'=> 'Thuộc tính %s không được trống.']);
    		$this->form_validation->set_rules('Date_End', 'Ngày kết thúc', 'required',['required'=> 'Thuộc tính %s không được trống.']);
    		$this->form_validation->set_rules('Status', 'Trạng thái', 'required|numeric',['required'=> 'Thuộc tính %s không được trống.']);
    		if($this->form_validation->run() !== FALSE){
    			$advertise_promo = new Advertise_Promos();
    			$data = $this->input->post();
    			$arr = array();
    			foreach ($data as $key => $value) {
    				if(in_array($key, $colums)){
    					$arr[$key] = $value;
    				}
    			}
    			if($advertise_promo->where(array('ID' => $id))->update($arr) ){
    				$apbp = new Advertise_Promo_Block_Page();
    				$apbp->delete_by_promo_id($id);
    				$apply = $this->input->post('Apply');
    				if($apply == -1){
    					foreach ($advertise_block_page as $key => $value) {
    						$apbp = new Advertise_Promo_Block_Page();
	    					$apbp->Advertise_Promo_ID = $id;
	    					$apbp->Advertise_Block_Page_ID = $value->ID;
	    					$apbp->save();
    					}
    				}
    				else{
    					$apbp = new Advertise_Promo_Block_Page();
    					$apbp->Advertise_Promo_ID = $id;
    					$apbp->Advertise_Block_Page_ID = $apply;
    					$apbp->save();
    				}
    				redirect('/admin/advertise_promo/edit/'.$id);
    				die;
    			}
    		}
    		else{
    			$this->data['error'] = true;
    		}
    	}
    	$this->data['advertise_block_page'] = $advertise_block_page;
    	$this->load->view('backend/include/header');
	    $this->load->view('backend/advertise_promo/add', $this->data);
	    $this->load->view('backend/include/footer');
    }

    public function delete($id){
    	$advertise_promo = new Advertise_Promos();
    	$advertise_promo->where(array('ID' => $id))->get(1);
    	if(!(isset($advertise_promo->ID) && $advertise_promo->ID!=null)){
    		redirect('/admin/advertise_promo/');
    		die;
    	}
    	$apbp = new Advertise_Promo_Block_Page();
    	$apbp->delete_by_promo_id($advertise_promo->ID);
    	$advertise_promo->delete_by_id($advertise_promo->ID);
    	redirect('/admin/advertise_promo/');
    	die;
    }
}
