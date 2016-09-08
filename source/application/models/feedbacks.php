<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feedbacks extends DataMapper {

    var $table = 'Feedback';
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
            'field' => 'Content',
            'label' => 'Content'
        ),
        array(
            'field' => 'Email',
            'label' => 'Email'
        ),
        array(
            'field' => 'Phone',
            'label' => 'Phone'
        ),
        array(
            'field' => 'Fullname',
            'label' => 'Fullname'
        ),
        array(
            'field' => 'Type',
            'label' => 'Type'
        ),
        array(
            'field' => 'Date_Create',
            'label' => 'Date Create'
        ),
        array(
            'field' => 'Status',
            'label' => 'Status'
        )
    );

    function Feedbacks() {
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
