<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Menu extends DataMapper {

    var $table = 'Member_Menu';

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
            'field' => 'URL',
            'label' => 'URL'
        ),
        array(
            'field' => 'Title',
            'label' => 'Title'
        ),
        array(
            'field' => 'Type_Menu',
            'label' => 'Type_Menu'
        ),
        array(
            'field' => 'Sort_Menu',
            'label' => 'Sort_Menu'
        ),
        array(
            'field' => 'Class_Menu',
            'label' => 'Class_Menu'
        ),
        array(
            'field' => 'Path',
            'label' => 'Path'
        ),
        array(
            'field' => 'Group_ID',
            'label' => 'Group ID'
        ),
         array(
            'field' => 'Parent_ID',
            'label' => 'Parent ID'
        ),
    );


    function Member_Menu()
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