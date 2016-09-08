<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Payment_History_Detail extends DataMapper {

    var $table = 'Member_Payment_History_Detail';

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
            'field' => 'History_ID',
            'label' => 'History_ID'
        ),
        array(
            'field' => 'Content',
            'label' => 'Content'
        ),
        array(
            'field' => 'Status',
            'label' => 'Status'
        ),
        array(
            'field' => 'Created_at',
            'label' => 'Created_at'
        )
    );


    function Member_Payment_History_Detail()
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