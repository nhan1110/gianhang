<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Category_Product extends DataMapper {

    var $table = 'Member_Category_Product';

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
            'field' => 'Category_ID',
            'label' => 'Category ID'
        ),
        array(
            'field' => 'Sort_Order',
            'label' => 'Sort Order'
        )
    );


    function Member_Category_Product()
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