<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Invoice extends DataMapper {

    var $table = 'Member_Invoice';

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
            'field' => 'Invoice_Code',
            'label' => 'Invoice Code'
        ),
        array(
            'field' => 'Created_at',
            'label' => 'Created_at'
        ),
        array(
            'field' => 'Total_Items',
            'label' => 'Total Items'
        ),
        array(
            'field' => 'Sub_Price',
            'label' => 'Sub_Price'
        ),
        array(
            'field' => 'Discount_Price',
            'label' => 'Discount_Price'
        ),
        array(
            'field' => 'Shipping_Price',
            'label' => 'Shipping_Price'
        ),
        array(
            'field' => 'Grand_Price',
            'label' => 'Grand_Price'
        ),
        array(
            'field' => 'Status',
            'label' => 'Status'
        )
    );


    function Member_Invoice()
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