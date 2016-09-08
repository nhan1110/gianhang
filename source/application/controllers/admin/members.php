<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Members extends MY_Controller {
    public $show_number_page = 10;
    public function __construct() {
        parent::__construct();
        $this->load->library('pagination');
    }

    public function index() {
        $per_page = $this->show_number_page;
        $current_page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $offset = 0;
        if (!($current_page > 0)) {
            $current_page = 1;
        }
        $offset = ($current_page - 1)*$per_page;
        
        $member = new Member();
        $member->order_by('Createat', 'DESC');
        if ($this->input->get()) {
            $keyword = $this->input->get('keyword');
            $group = $this->input->get('group');
            if ($keyword !== FALSE && !empty($keyword)) {
                $member->like('Firstname', $keyword);
                $member->or_like('Lastname', $keyword);
                $member->or_like('Email', $keyword);    
            }
            if ($group !== FALSE && !empty($group)) {
                $member->where('Group_ID', $group);
                $data['group'] = $group;
            }
        }
        $member->get_paged($offset, $per_page, TRUE);

        $data['collections'] = $member;
        if ($offset > $member->paged->total_rows) {
            $offset = floor($member->paged->total_rows / $per_page) * $per_page;
        }
        
        $pagination_config = array(
            'base_url' => site_url('admin/members'),
            'total_rows' => $member->paged->total_rows,
            'per_page' => $per_page,
            'uri_segment' => 4
        );
        $this->pagination->initialize($pagination_config);
        
        $data['pagination'] = $this->pagination;
        $data['offset'] = $offset;
        $data['total_rows'] = $member->paged->total_rows;
        $data['per_page'] = $per_page;
        $data['current_page'] = $current_page;
        $data['show_number_page'] = $this->show_number_page;

        $member_group = new Member_Group();
        $member_group->order_by('Group_Title','ASC');
        $member_group->get();

        $data['member_group'] = $member_group;
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/members/index',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function edit($member_id=null) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

    	$data['action'] = base_url().'admin/members/edit/'.$member_id;
        if( !(isset($member_id) && $member_id!=null && is_numeric($member_id)) ){
            redirect(base_url().'admin/members');
            die;
        }
        $member = new Member();
        $member->where('ID',$member_id)->get();
        if (!(isset($member->ID) && $member->ID != null)) {
            redirect(base_url().'admin/members');
            die;
        }
        if ($this->input->post()) {
            if ($this->form_validation->run() === FALSE) {
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else{
                $arr = array(
                    'Email' => $this->input->post('email'),
                    'Address' => $this->input->post('address'),
                    'Phone' => $this->input->post('phone'),
                    'Firstname' => $this->input->post('firstname'),
                    'Lastname' => $this->input->post('lastname'),
                    'Status' => $this->input->post('status'),
                    'Createat' => date('Y-m-d H:i:s')
                );
                if ($this->input->post('group')) {
                    $arr['Group_ID'] = $this->input->post('group');
                }
                $member = new Member();
                $member->where('ID',$member_id)->update($arr);
                redirect(base_url().'admin/members/edit/'.$member_id);
            }
        }
        $member_group = new Member_Group();
        $member_group->order_by('Group_Title','ASC');
        $member_group->get();
    	$data['label'] = "Edit";
        $data['member_group'] = $member_group;
        $data['member'] = $member;
        $data['group'] = @$member->Group_ID;
        $this->load->view('backend/include/header',$data);
        $this->load->view('backend/members/add',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        if ($this->input->post()) {
            $email = $this->input->post('email');
            $member = new Member();
            $member->Email = $email;
            $member->Address = $this->input->post('address');
            $member->Phone = $this->input->post('phone');
            $member->Firstname = $this->input->post('firstname');
            $member->Lastname = $this->input->post('lastname');
            $member->Pwd = md5($this->input->post('email').':'.$this->input->post('password'));
            $member->Status = $this->input->post('status');
            $member->Group_ID = $this->input->post('group');
            if ($this->form_validation->run() === FALSE) {
                $data['member'] = $member;
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            else {
                $members = new Member();
                $members->where('Email',$email)->get(1);
                if (isset($members->ID) && $members->ID != null) {
                    $data['member'] = $member;
                    $data['message'] = 'Email này đã tồn tại.';
                }
                else {
                    $member->Createat = date('Y-m-d H:i:s');
                    if ($member->save()) {
                        $member_id = $member->get_id_last_save();
                        redirect(base_url().'admin/members/edit/'.$member_id);
                    }
                }
            }
        }
        $member_group = new Member_Group();
        $member_group->order_by('Group_Title','ASC');
        $member_group->get();
    	$data['action'] = base_url().'admin/members/add/';
    	$data['label'] = "Add";
        $data['group'] = "0";
        $data['member_group'] = $member_group;
    	$this->load->view('backend/include/header',$data);
        $this->load->view('backend/members/add',$data);
        $this->load->view('backend/include/footer',$data);
    }

    public function delete($member_id=null){
    	if(isset($member_id) && $member_id!=null && is_numeric($member_id)){
    		$member = new Member();
          	$member->where('ID',$member_id)->get();
          	$member->delete_by_id($member->ID);
    	}
    	redirect(base_url().'admin/members');
    }

}
