<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Advertise_Promos extends DataMapper {
    var $table = 'Advertise_Promo';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Sale',
            'label' => 'Sale'
        ),
        array(
            'field' => 'Unit',
            'label' => 'Unit'
        ),
        array(
            'field' => 'Apply',
            'label' => 'Apply'
        ),
        array(
            'field' => 'Date_Start',
            'label' => 'Date Start'
        ),
        array(
            'field' => 'Date_End',
            'label' => 'Date End'
        ),
        array(
            'field' => 'Status',
            'label' => 'Status'
        ) 
    );
    function Advertise_Promos() {
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

