<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Payment_History extends DataMapper {

    var $table = 'Member_Payment_History';

    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Member_ID',
            'label' => 'Member_ID'
        ),
        array(
            'field' => 'Package_ID',
            'label' => 'Package_ID'
        ),
        array(
            'field' => 'Price',
            'label' => 'Price'
        ),
        array(
            'field' => 'Payment_Code',
            'label' => 'Payment_Code'
        ),
        array(
            'field' => 'Status',
            'label' => 'Status'
        ),
        array(
            'field' => 'Created_at',
            'label' => 'Created_at'
        ),
        array(
            'field' => 'Approved_at',
            'label' => 'Approved_at'
        )
    );


    function Member_Payment_History()
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