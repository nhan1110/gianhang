<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Keywords extends DataMapper {
    var $table = 'Keywords';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Member_ID',
            'label' => 'Member_ID',
        ),
        array(
            'field' => 'Name',
            'label' => 'Name'
        ),
        array(
            'field' => 'Slug',
            'label' => 'Slug'
        ),
        array(
            'field' => 'Type',
            'label' => 'Type'
        ),
        array(
            'field' => 'Created_at',
            'label' => 'Created_at'
        ),
        array(
            'field' => 'Type_ID',
            'label' => 'Type_ID'
        ),
        array(
            'field' => 'Order',
            'label' => 'Order'
        ),
        array(
            'field' => 'Disable',
            'label' => 'Disable'
        )
    );

    function Keyword() {
        parent::DataMapper();
    }

    function get_keyword($cat_type="", $meber_id="", $name="", $not_name="") {
        $sql = "SELECT `Keywords`.`ID`, `Keywords`.`Name` FROM (`Keywords`) WHERE 1=1";
        $where = " AND (`Keywords`.`Disable` = '0')";
        if (!empty($cat_type)) {
            $where .= " AND (`Keywords`.`Type_ID` = {$cat_type}) ";
        }
        if (!empty($name)) {
            $where .= " AND (`Keywords`.`Name` LIKE '%{$name}%') ";
        }
        if (!empty($not_name)) {
            $where .= " AND (`Keywords`.`Name` NOT IN ({$not_name})) ";
        }
        if (!empty($meber_id)) {
            $where .= " AND (`Keywords`.`Member_ID` = {$meber_id} OR `Keywords`.`Type` = 'System') ";
        }
        $query = $this->db->query($sql.$where);

        return $query->result_array();
    }

    public function update_order($id = array(-1),$offset) {
        $id_in = implode(",", $id);
        if ($offset > 0) {
            $sql = "UPDATE `Keywords` SET `Order`= `Order` + " . $offset . " WHERE `ID` IN (" . $id_in . ")"; 
        } else {
            $sql = "UPDATE `Keywords` SET `Order`= `Order` + " . $offset . " WHERE `ID` IN (" . $id_in . ") AND `Order` != 0"; 
        }
        $this->db->query($sql);
    }
    public function get_kw_by_type($path){
        $this->db->select("kw.*");
        $this->db->from($this->table." AS kw");
        $this->db->join("Category_Type AS ct","ct.ID = kw.Type_ID");
        $this->db->like("ct.Path",$path);
        $this->db->where("kw.Disable","0");
        $this->db->order_by("Order","DESC");
        $this->db->limit(10);
        return $this->db->get()->result_array();
    }

}

