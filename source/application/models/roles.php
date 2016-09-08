<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Roles extends DataMapper {

    var $table = 'Roles';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Role_Title',
            'label' => 'Role Title',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 5, 'max_length' => 50)
        ),
        array(
            'field' => 'Role_Description',
            'label' => 'Role Desc',
            'rules' => array('required', 'trim')
        ),
    );

    function Roles() 
    {
        parent::DataMapper();
    }
    
    function delete_item($id) 
    {
        return $this->db->delete($this->table, array('ID' => $id)); 
    }

}
