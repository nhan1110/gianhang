<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Configs extends DataMapper {

    var $table = 'Website_Setting';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Key_Identify',
            'label' => 'Key Identify',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 1, 'max_length' => 200)
        ),
        array(
            'field' => 'Title',
            'label' => 'Title',
            'rules' => array('required', 'trim')
        ),
        array(
            'field' => 'Group_ID',
            'label' => 'Group',
            'rules' => array('required', 'trim')
        ),
    );

    function Configs() 
    {
        parent::DataMapper();
    }
    
    function delete_item($id) 
    {
        return $this->db->delete($this->table, array('ID' => $id)); 
    }
    
    function get_item($slug) 
    {
    	return $this->where('Key_Identify', $slug)->get();
    }

}
