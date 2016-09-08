<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends DataMapper {

    var $table = 'Notifications';
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
            'field' => 'Type_Notification',
            'label' => 'Type Notification'
        ),
        array(
            'field' => 'Created_at',
            'label' => 'Created at'
        ),
        array(
            'field' => 'Status',
            'label' => 'Status'
        )
    );

    function Notification_model() {
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
