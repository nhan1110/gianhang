<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MY_Controller {
    
    public $show_number_page = 1000;

    function __construct() {
        parent::__construct();
        
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->helper('slugify');
    }

    public function index($id=null) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('key_identify', 'Key Identify', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if (is_numeric($id) && floatval($id) > 0) {
        	// $this->form_validation->set_rules('group', 'Group', 'required');
		}
        if (isset($_POST) && $this->input->post('key_identify') !== FALSE) {
            if ($this->form_validation->run() === FALSE) {
                $data['_POST'] = $_POST;
                $data['message'] = array('Please enter all required field.');
            } else {
                $bol = false;
                $config = new Configs();
                $id = $this->input->post('id');
                if (is_numeric($id) && floatval($id) > 0) {
                    $arr = array(
                        'Title' => $this->input->post('title'),
                        'Key_Identify' => $this->input->post('key_identify'),
                        'Group_ID' => $this->input->post('group')
                    );
                    $bol = $config->where('ID', $id)->update($arr);
                } else {
                    $config->Title = $this->input->post('title');
                    $config->Key_Identify = $this->input->post('key_identify');
                    $config->Group_ID = $this->input->post('group');
                    $bol = $config->save();
                }
                // Save new user
                if ($bol) {
                    $data['message'] = array('The item has been updated successfully.');
                } else {
                    $data['message'] = $config->error->all;
                }
            }
        }
        
        $per_page = $this->show_number_page;
        $current_page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $offset = 0;
        if (!($current_page > 0)) {
            $current_page = 1;
        }
        $offset = ($current_page - 1)*$per_page;
        
        $config = new Configs();
        $config->order_by('Group_ID', 'ASC');
        $config->order_by('Title', 'ASC');
        
        $config->get_paged($offset, $per_page, TRUE);
        $data['collections'] = $config;
        if ($offset > $config->paged->total_rows) {
            $offset = floor($config->paged->total_rows / $per_page) * $per_page;
        }
        
        $pagination_config = array(
            'base_url' => site_url('admin/config'),
            'total_rows' => $config->paged->total_rows,
            'per_page' => $per_page,
            'uri_segment' => 4
        );
        $this->pagination->initialize($pagination_config);
        
        $data['pagination'] = $this->pagination;
        $data['offset'] = $offset;
        $data['total_rows'] = $config->paged->total_rows;
        $data['per_page'] = $per_page;
        $data['current_page'] = $current_page;
        $data['show_number_page'] = $this->show_number_page;
		
		$config2 = new Configs();
        $config2->order_by('Title', 'ASC');
        $config2->where('Group_ID', '0');
        $config2->get();
        $group = array();
		if ($config2 != null) {
			foreach ($config2 as $item) {
				$group[$item->ID] = $item->Title;
			}
		}
		$data['group'] = $group;
        $this->load->view('backend/include/header', $data);
        $this->load->view('backend/config/index', $data);
        $this->load->view('backend/include/footer', $data);
    }

    function delete($id = null) {
        if (isset($id) && $id != null && is_numeric($id)) {
            // Check this role was used?
            // Get user foo
            $config = new Configs();
            $config->delete_item($id);
        }
        redirect(site_url('admin/config/'));
        // die(json_encode(array('status' => 'false', 'message' => 'Cannot delete this item.')));
    }

}