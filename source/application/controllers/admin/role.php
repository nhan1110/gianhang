<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MY_Controller {
    
    public $show_number_page = 1000;

    function __construct() 
    {
        parent::__construct();
        
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->helper('slugify');
        $this->load->model('Modules');
    }

    public function index() 
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('text_title', 'Title', 'required');
        $this->form_validation->set_rules('text_description', 'Description', 'required');

        if (isset($_POST) && $this->input->post('text_title') !== FALSE) {
            if ($this->form_validation->run() === FALSE) {
                $data['_POST'] = $_POST;
                $data['message'] = array('Please enter all required field.');
            } else {
                $bol = false;
                $role = new Roles();
                $id = $this->input->post('id');
                if (is_numeric($id) && floatval($id) > 0) {
                    $arr = array(
                        'Role_Title' => $this->input->post('text_title'),
                        'Role_Description' => $this->input->post('text_description')
                    );
                    $bol = $role->where('ID', $id)->update($arr);
                } else {
                    $role->Role_Title = $this->input->post('text_title');
                    $role->Role_Description = $this->input->post('text_description');
                    $bol = $role->save();
                }
                // Save new user
                if ($bol) {
                    $data['message'] = array('The item has been updated successfully.');
                } else {
                    $data['message'] = $role->error->all;
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
        
        $role = new Roles();
        $role->order_by('Role_Title', 'ASC');
        $role->get_paged($offset, $per_page, TRUE);
        $data['collections'] = $role;
        if ($offset > $role->paged->total_rows) {
            $offset = floor($role->paged->total_rows / $per_page) * $per_page;
        }
        
        $pagination_config = array(
            'base_url' => site_url('admin/role'),
            'total_rows' => $role->paged->total_rows,
            'per_page' => $per_page,
            'uri_segment' => 4
        );
        $this->pagination->initialize($pagination_config);
        
        $data['pagination'] = $this->pagination;
        $data['offset'] = $offset;
        $data['total_rows'] = $role->paged->total_rows;
        $data['per_page'] = $per_page;
        $data['current_page'] = $current_page;
        $data['show_number_page'] = $this->show_number_page;

        $this->load->view('backend/include/header', $data);
        $this->load->view('backend/role/index', $data);
        $this->load->view('backend/include/footer', $data);
    }

    function delete($id = null) 
    {
        if (isset($id) && $id != null && is_numeric($id)) {
            // Check this role was used?
            // Get user foo
            $role = new Roles();
            $role->delete_item($id);
        }
        redirect(site_url('admin/role/'));
        // die(json_encode(array('status' => 'false', 'message' => 'Cannot delete this item.')));
    }
    
    private $_rule = null;
    public function setrule() 
    {
    	$role = new Roles();
    	$role_id = $this->input->get('id');
    	if (isset($role_id) && $role_id != null && is_numeric($role_id)) {
            $role->where('ID', $role_id)->get();
            if (!$role->exists()) {
            	redirect(site_url('admin/role/'));
            }
    	}
    	$rule = new Rule_model();
    	$rule->where('Role_ID', $role_id)->get();
    	$this->_rule = $rule;
    	
        $modules = new Modules();
        $modules->order_by('Order', 'ASC');
        $modules->get();
        $category = array(
            'items' => array(),
            'parents' => array()
        );
        foreach ($modules as $item) {
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $category['items'][$item->ID] = array(
                'key' => $item->Module_Key,
                'title' => $item->Module_Name,
                'url' => $item->Module_Url,
                'id' => $item->ID
            );
            // Creates entry into parents array. Parents array contains a list of all items with children
            $category['parents'][$item->Parent_ID][] = $item->ID;
        }
        $data['category'] = $this->_build_tree(0, $category, 0);
        $data['rule'] = $rule;
        $data['role_id'] = $role_id;
        $this->load->view('backend/include/header', $data);
        $this->load->view('backend/role/rule', $data);
        $this->load->view('backend/include/footer', $data);
    }
    
    public function update_rule() 
    {
    	if ($this->input->is_ajax_request()) {
    		$role = new Roles();
	    	$role_id = $this->input->get('id');
	    	if (isset($role_id) && $role_id != null && is_numeric($role_id)) {
	            $role->where('ID', $role_id)->get();
	            if (!$role->exists()) {
	            	die('error');
	            }
	    	}
    	
    		$post = $this->input->post();
    		if ($post !== FALSE) {
    			$rule_model = new Rule_model();
            	$rule_model->delete_by_role($role_id);
				
				// Insert or update rule_model
				foreach ($post as $key => $value) {
					if ($key == "view" || $key == "add" || $key == "approve" || $key == "update" || $key == "delete") {
						foreach ($value as $module_id) {
							$rule_model = new Rule_model();
							$rule_model->where('Role_ID', $role_id);
							$rule_model->where('Module_ID', $module_id)->get();
							$key_update = 'Action_' . ucFirst($key);
							if ($rule_model->exists()) {
			                    $rule_model->update($key_update, 1);
			                } else {
			                	$rule_model = new Rule_model();
			                    $rule_model->Module_ID = $module_id;
			                    $rule_model->Role_ID = $role_id;
			                    $rule_model->$key_update = 1;
			                    $bol = $rule_model->save();
			                }
						}
					}
				}
				die('success');
    		}
    	}
    	
    	die('error');
    }
    
    function _build_tree($parent, $menu, $level = 0) {
        $html = "";
        if (isset($menu['parents'][$parent])) {
            foreach ($menu['parents'][$parent] as $itemId) {
            		// Get row by menu item
            		$row_checked = $this->_find_rule($menu['items'][$itemId]['id']);
                    $html .= "<tr class='row-item' id='menu-" . $menu['items'][$itemId]['id'] . "' data-url='" . $menu['items'][$itemId]['key'] . "'>\n
                        		<td class='level-".$level."'>" . $menu['items'][$itemId]['title'] . "</td>
                        		<td class='text-center'>
                                   	<input type='checkbox' " . @$row_checked['view'] . " data-parent='".$parent."' name='view[]' value='" . $menu['items'][$itemId]['id'] . "' />
                                </td>
                                <td class='text-center'>
                                   <input type='checkbox' " . @$row_checked['approve'] . " data-parent='".$parent."' name='approve[]' value='" . $menu['items'][$itemId]['id'] . "' />
                                </td>
                        		<td class='text-center'>
                                   <input type='checkbox' " . @$row_checked['add'] . " data-parent='".$parent."' name='add[]' value='" . $menu['items'][$itemId]['id'] . "' />
                                </td>
                                <td class='text-center'>
                                   <input type='checkbox' " . @$row_checked['update'] . " data-parent='".$parent."' name='update[]' value='" . $menu['items'][$itemId]['id'] . "' />
                                </td>
                        		<td class='text-center'>
                                   <input type='checkbox' " . @$row_checked['delete'] . " data-parent='".$parent."' name='delete[]' value='" . $menu['items'][$itemId]['id'] . "' />
                                </td>
                             </tr>";
                    $html .= $this->_build_tree($itemId, $menu, ($level + 1));
            }
        }
        return $html;
    }
    
    function _find_rule($module_id) {
    	if ($this->_rule == null)
    		return null;
    	foreach ($this->_rule as $rule_item) {
    		if ($rule_item->Module_ID == $module_id) {
    			return array('view' => $rule_item->Action_View == '1' ? 'checked' : '', 
    					'approve' => $rule_item->Action_Approve == '1' ? 'checked' : '', 
    					'add' => $rule_item->Action_Add == '1' ? 'checked' : '', 
    					'update' => $rule_item->Action_Update == '1' ? 'checked' : '', 
    					'delete' => $rule_item->Action_Delete == '1' ? 'checked' : '');
    		}
    	}
    }

}