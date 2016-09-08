<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Package extends DataMapper {

    var $table = 'Member_Package';

    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Package_Title',
            'label' => 'Package Title'
        ),
        array(
            'field' => 'Package_Description',
            'label' => 'Package Description'
        ),
        array(
            'field' => 'Rule_ID',
            'label' => 'Rule_ID'
        ),
        array(
            'field' => 'Price',
            'label' => 'Price'
        ),
        array(
            'field' => 'Start_Date',
            'label' => 'Start_Date'
        ),
        array(
            'field' => 'Updated_at',
            'label' => 'Updated_at'
        ),
        array(
            'field' => 'End_Date',
            'label' => 'End_Date'
        )
    );


    function Member_Package()
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