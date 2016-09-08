<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {
    
    public $show_number_page = 20;
	private $old_username = "";
	private $old_email = "";
	
    function __construct() {
        parent::__construct();
        
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->helper('slugify');
    }
	
    public function index() {
    	$this->load->library('form_validation');
        $this->form_validation->set_rules('user_nick', 'Nick', 'trim|required|min_length[5]|max_length[50]|callback__unique_username');
        $this->form_validation->set_rules('user_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|callback__unique_email');
        $this->form_validation->set_rules('user_status', 'Status', 'trim|required');
        $this->form_validation->set_rules('ImagePath', 'Avatar', 'trim');
        $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');
        
        $id = $this->input->get_post('id');
        $action = $this->input->get('action');
        $addnew = FALSE;
        $url_form = base_url('admin/users/index/?action=add');
        $action = FALSE;
        if ($id != FALSE && is_numeric($id) && floatval($id) > 0) {
        	// Find this user?
        	$user = new Users_model();
        	$user->where('ID', $id);
        	$user->where('User_Default','no')->get();
        	if ($user == null || empty($user->ID)) {
        		redirect(site_url('admin/users/'));
        	} else {
        		$this->old_username = $user->User_Nick;
				$this->old_email = $user->User_Email;
        		$data['post'] = array(
        			'role' => $user->Role_ID,
        			'user_nick' => $user->User_Nick,
        			'user_name' => $user->User_Name,
        			'user_email' => $user->User_Email,
        			'user_status' => $user->User_Status,
        			'ImagePath' => $user->User_Avatar
        		);
        		$action = TRUE;
        		$url_form = base_url('admin/users/index/?id='.$id);
        	}
        } else {
        	$this->form_validation->set_rules('user_pwd', 'Password', 'trim|required|matches[user_confirm]|md5');
        	$this->form_validation->set_rules('user_confirm', 'Confirm Password', 'trim|required|md5');
        }
        
        if (isset($_POST) && $this->input->post('user_nick') !== FALSE) {
            if ($this->form_validation->run() === FALSE) {
                $data['post'] = $_POST;
                $data['message'] = array(validation_errors());
            } else {
                $bol = false;
                $user = new Users_model();
                $id = $this->input->get_post('id');
                if (is_numeric($id) && floatval($id) > 0) {
                    $arr = array(
                        'User_Nick' => $this->input->post('user_nick'),
                        'User_Name' => $this->input->post('user_name'),
                        'User_Email' => $this->input->post('user_email'),
                        'User_Status' => $this->input->post('user_status'),
                        'User_Avatar' => $this->input->post('ImagePath'),
                        'Updatedat' => date('Y-m-d H:i:s'),
                        'Role_ID' => $this->input->post('role'),
                        'Token' => ''
                    );
                    if ($this->input->post('user_pwd') != '') {
                    	$arr['User_Pwd'] = $this->input->post('user_pwd');
                    }
                    $user->trans_begin();
                    $bol = $user->where('ID', $id)->update($arr);
                    
                    if ($user->trans_status() === FALSE)
					{
					    $user->trans_rollback();
					}
					else
					{
					    $user->trans_commit();
					    // Update role for this user
	                    $user_role = new User_role_model();
	                    $user_role->where('User_ID', $id)->update(array('Role_ID' => $this->input->post('role')));
					}
                } else {
                	$user->trans_begin();
                    $user->User_Nick = $this->input->post('user_nick');
                    $user->User_Name = $this->input->post('user_name');
                    $user->User_Email = $this->input->post('user_email');
                    $user->User_Pwd = $this->input->post('user_pwd');
                    $user->User_Status = $this->input->post('user_status');
                    $user->Role_ID = $this->input->post('role');
                    $user->User_Avatar = $this->input->post('ImagePath');
                    $user->Createdat = date('Y-m-d H:i:s');
                    $user->Updatedat = date('Y-m-d H:i:s');
                    $bol = $user->save();
                    
					if ($user->trans_status() === FALSE)
					{
					    $user->trans_rollback();
					}
					else
					{
					    $user->trans_commit();
					    $last_id = $user->get_last_id_save();
					    
					    // Update role for this user
	                    $user_role = new User_role_model();
	                    $user->trans_begin();
	                    $user_role->User_ID = $last_id;
	                    $user_role->Role_ID = $this->input->post('role');
	                    $user_role->Createdat = date('Y-m-d H:i:s');
	                    $user_role->save();
	                    if ($user_role->trans_status() === FALSE)
						{
						    $user_role->trans_rollback();
						}
						else
						{
							$user_role->trans_commit();
						}
					}
                }
                // Save new user
                if ($bol) {
                    $data['message'] = array('The item has been updated successfully.');
                } else {
                    $data['message'] = $user->error->all;
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
        
        $user = new Users_model();
        $user->order_by('Createdat', 'DESC');
        $user->where('User_Default', 'no');
        $user->get_paged($offset, $per_page, TRUE);
        $data['collections'] = $user;
        if ($offset > $user->paged->total_rows) {
            $offset = floor($user->paged->total_rows / $per_page) * $per_page;
        }
        
        $pagination_config = array(
            'base_url' => site_url('admin/config'),
            'total_rows' => $user->paged->total_rows,
            'per_page' => $per_page,
            'uri_segment' => 4
        );
        $this->pagination->initialize($pagination_config);
        
        $data['pagination'] = $this->pagination;
        $data['offset'] = $offset;
        $data['total_rows'] = $user->paged->total_rows;
        $data['per_page'] = $per_page;
        $data['current_page'] = $current_page;
        $data['show_number_page'] = $this->show_number_page;
		
		$role = new Roles();
        $role->order_by('Role_Title', 'ASC');
        $role->get();
        $group = array();
		if ($role != null) {
			foreach ($role as $item) {
				$group[$item->ID] = $item->Role_Title;
			}
		}
		$data['group'] = $group;
        $data['action'] = $action;
        $data['addnew'] = $addnew;
        $data['url_form'] = $url_form;
        $this->load->view('backend/include/header', $data);
        $this->load->view('backend/user/index', $data);
        $this->load->view('backend/include/footer', $data);
    }
    
	public function _unique_username($username) {
		// Find old username
		if ($username == $this->old_username) {
			return true;
		}
		// Find this user?
    	$user = new Users_model();
    	$user->where('User_Nick', $username)->get();
    	if ($user != null && !empty($user->ID)) {
    		$this->form_validation->set_message('_unique_username', 'This nick name is already exists.');
    		return false;
    	}
		return true;
	}

	public function _unique_email($email) {
		if ($email == $this->old_email) {
			return true;
		}
		// Find this user?
    	$user = new Users_model();
    	$user->where('User_Email', $email)->get();
    	if ($user != null && !empty($user->ID)) {
    		$this->form_validation->set_message('_unique_email', 'This email is already exists.');
    		return false;
    	}
		return true;
	}

    function delete($id = null) {
        if (isset($id) && $id != null && is_numeric($id)) {
            // Check this role was used?
            // Get user foo
            $config = new Config();
            $config->delete_item($id);
        }
        redirect(site_url('admin/user/'));
        // die(json_encode(array('status' => 'false', 'message' => 'Cannot delete this item.')));
    }

}