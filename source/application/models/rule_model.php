<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rule_model extends DataMapper {

    var $table = 'Rules';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Module_ID',
            'label' => 'Module_ID'
        ),
        array(
            'field' => 'Role_ID',
            'label' => 'Role_ID'
        ),
        array(
            'field' => 'Action_Delete',
            'label' => 'Delete'
        ),
        array(
            'field' => 'Action_Update',
            'label' => 'Update'
        ),
        array(
            'field' => 'Action_Add',
            'label' => 'Add'
        ),
        array(
            'field' => 'Action_View',
            'label' => 'View'
        ),
        array(
            'field' => 'Action_Approve',
            'label' => 'Approve'
        )
    );

    function Rule_model() {
        parent::DataMapper();
    }

	function get_last_id_save()
    {  
        return $this->db->insert_id();
    }

    function delete_by_id($id) {
        $this->db->delete($this->table, array('ID' => $id));
    }

	function delete_by_role($role_id) {
        $this->db->delete($this->table, array('Role_ID' => $role_id));
    }
}
