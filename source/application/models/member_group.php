<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member_Group extends DataMapper {

    var $table = 'Member_Group';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Group_Title',
            'label' => 'Group Title',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 1, 'max_length' => 200)
        ),
        array(
            'field' => 'Group_Description',
            'label' => 'Group Desc',
            'rules' => array('required', 'trim')
        ),
    );

    function Member_Group() 
    {
        parent::DataMapper();
    }
    
    function delete_item($id) 
    {
        return $this->db->delete($this->table, array('ID' => $id)); 
    }

}
