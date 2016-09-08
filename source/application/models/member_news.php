<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_News extends DataMapper {

    var $table = 'Member_News';

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
            'field' => 'Slug',
            'label' => 'Slug'
        ),
        array(
            'field' => 'Summary',
            'label' => 'Summary'
        ),
        array(
            'field' => 'Content',
            'label' => 'Content'
        ),
        array(
            'field' => 'Created_at',
            'label' => 'Created_at'
        ),
        array(
            'field' => 'Updated_at',
            'label' => 'Updated_at'
        ),
        array(
            'field' => 'Media_ID',
            'label' => 'Media ID'
        ),
        array(
            'field' => 'Type_News',
            'label' => 'Type_News'
        ),
        array(
            'field' => 'Status',
            'label' => 'Status'
        ),
        array(
            'field' => 'From_Date',
            'label' => 'From Date'
        ),
        array(
            'field' => 'To_Date',
            'label' => 'To Date'
        )
    );


    function Member_News()
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