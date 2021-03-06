<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Category_News extends DataMapper {

    var $table = 'Member_Category_News';

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
            'field' => 'Name',
            'label' => 'Name'
        ),
        array(
            'field' => 'Slug',
            'label' => 'Slug'
        ),
        array(
            'field' => 'Path',
            'label' => 'Path'
        ),
        array(
            'field' => 'Parent_ID',
            'label' => 'Parent ID'
        ),
        array(
            'field' => 'Date_Creater',
            'label' => 'Date Creater'
        )
    );


    function Member_Category_News()
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