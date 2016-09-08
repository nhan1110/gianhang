<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Setting_Website extends DataMapper {

    var $table = 'Member_Setting_Website';

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
            'field' => 'Key',
            'label' => 'Key'
        ),
        array(
            'field' => 'Value',
            'label' => 'Value'
        )
    );


    function Member_Setting_Website()
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