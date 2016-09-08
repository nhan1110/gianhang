<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pin_Model extends DataMapper {

    var $table = 'Pin';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Name',
            'label' => 'Name'
        ),
        array(
            'field' => 'Slug',
            'label' => 'Slug'
        ),
        array(
            'field' => 'Banner',
            'label' => 'Banner'
        ),
        array(
            'field' => 'Member_ID',
            'label' => 'Member ID'
        ),
        array(
            'field' => 'Type_ID',
            'label' => 'Type ID'
        ),
        array(
            'field' => 'Date_Created',
            'label' => 'Date Created'
        )
    );

    function Pin_Model() {
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
