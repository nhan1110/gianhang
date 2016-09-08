<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_Templates extends DataMapper {

    var $table = 'Email_Template';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Title',
            'label' => 'Title'
        ),
        array(
            'field' => 'Key',
            'label' => 'Key'
        ),
        array(
            'field' => 'Header',
            'label' => 'Header'
        ),
        array(
            'field' => 'Footer',
            'label' => 'Footer'
        ),
        array(
            'field' => 'Content',
            'label' => 'Content'
        ),
        array(
            'field' => 'Status',
            'label' => 'Status'
        ),
        array(
            'field' => 'Phone',
            'label' => 'Phone'
        )
    );

    function Email_Templates() {
        parent::DataMapper();
    }

    function get_id_last_save()
    {  
        return $this->db->insert_id();
    }

    function delete_by_id($id)
    {
        $this->db->delete($this->table, array('ID' => $id));
    }
}
