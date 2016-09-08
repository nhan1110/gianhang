<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modules extends DataMapper {

    var $table = 'Modules';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Module_Name',
            'label' => 'Name'
        ),
        array(
            'field' => 'Module_Key',
            'label' => 'Key'
        ),
        array(
            'field' => 'Module_Url',
            'label' => 'Url'
        ),
        array(
            'field' => 'Path',
            'label' => 'Path'
        ),
        array(
            'field' => 'Parent_ID',
            'label' => 'Parent'
        )
    );

    function Modules() {
        parent::DataMapper();
    }

    function get_last_id() {
        return $this->db->insert_id();
    }

    function delete_by_id($id) {
        $this->db->delete($this->table, array('ID' => $id));
    }

}
