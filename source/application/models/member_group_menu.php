<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Group_Menu extends DataMapper {

    var $table = 'Member_Group_Menu';

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
            'field' => 'Date_Creater',
            'label' => 'Date Creater'
        )
    );


    function Member_Group_Menu()
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