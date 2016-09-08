<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Payments_History extends DataMapper {
    var $table = 'Payments_History';
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
            'field' => 'First_Name',
            'label' => 'First_Name'
        ),
        array(
            'field' => 'Last_Name',
            'label' => 'Last_Name'
        ),
        array(
            'field' => 'Email',
            'label' => 'Email'
        ),
        array(
            'field' => 'Company',
            'label' => 'Company'
        ),
        array(
            'field' => 'Phone',
            'label' => 'Phone'
        ),
        array(
            'field' => 'Address',
            'label' => 'Address'
        ),
        array(
            'field' => 'Type',
            'label' => 'Type'
        ),
        array(
            'field' => 'Total',
            'label' => 'Total'
        ),
        array(
            'field' => 'Status',
            'label' => 'Status'
        ),
        array(
            'field' => 'Return_ID',
            'label' => 'Return_ID'
        ),
        array(
            'field' => 'Createat',
            'label' => 'Createat'
        ),
        array(
            'field' => 'Updateat',
            'label' => 'Updateat'
        ),
        array(
            'field' => 'Upgrade_ID',
            'label' => 'Upgrade_ID'
        )
    );
    function Payments_History() {
        parent::DataMapper();
    }
    public function get_record_payment($id){
        $this->db->select("u.*");
        $this->db->from($this->table . " AS ph");
        $this->db->join("Upgrades AS u","u.ID = ph.Upgrade_ID");
        $this->db->where("ph.Return_ID",$id);
        $query = $this->db->get();
        return $query->row_array();
    }

}

