<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Page extends DataMapper {

    var $table = 'Member_Page';

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
            'field' => 'Content',
            'label' => 'Content'
        ),
        array(
            'field' => 'Summary',
            'label' => 'Summary'
        ),
        array(
            'field' => 'Media_ID',
            'label' => 'Media ID'
        ),
        array(
            'field' => 'Date_Creater',
            'label' => 'Date Creater'
        )
    );


    function Member_Page()
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