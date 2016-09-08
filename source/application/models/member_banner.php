<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Banner extends DataMapper {

    var $table = 'Member_Banner';

    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Member_ID',
            'label' => 'Member ID'
        ),
        array(
            'field' => 'Title',
            'label' => 'Title'
        ),
        array(
            'field' => 'Summary',
            'label' => 'Summary'
        ),
        array(
            'field' => 'Start_Date',
            'label' => 'Start Date'
        ),
        array(
            'field' => 'To_Date',
            'label' => 'To Date'
        ),
        array(
            'field' => 'Status',
            'label' => 'Status'
        )
    );


    function Member_Banner()
    {
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