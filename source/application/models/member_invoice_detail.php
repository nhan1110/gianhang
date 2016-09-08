<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Invoice_Detail extends DataMapper {

    var $table = 'Member_Invoice_Detail';

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
            'field' => 'Product_ID',
            'label' => 'Product ID'
        ),
        array(
            'field' => 'Qty',
            'label' => 'Qty'
        ),
        array(
            'field' => 'Unit_Price',
            'label' => 'Unit_Price'
        ),
        array(
            'field' => 'Price',
            'label' => 'Price'
        ),
        array(
            'field' => 'Invoice_ID',
            'label' => 'Invoice_ID'
        )
    );


    function Member_Invoice_Detail()
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