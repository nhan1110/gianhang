<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_role_model extends DataMapper {

    var $table = 'User_Role';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'User_ID',
            'label' => 'User_ID'
        ),
        array(
            'field' => 'Role_ID',
            'label' => 'Role_ID'
        ),
        array(
            'field' => 'Createdat',
            'label' => 'Created at'
        )
    );

    function User_role_model() {
        parent::DataMapper();
    }

	function get_last_id_save()
    {  
        return $this->db->insert_id();
    }

    function delete_by_id($id) {
        $this->db->delete($this->table, array('ID' => $id));
    }

}
