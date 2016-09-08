<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Website_Templates extends DataMapper {

    var $table = 'Website_Template';
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
            'field' => 'Status',
            'label' => 'Status'
        ),
        array(
            'field' => 'Date_Create',
            'label' => 'Date Create'
        )
    );

    function Website_Templates() {
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
