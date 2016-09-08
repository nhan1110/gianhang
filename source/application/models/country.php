<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Country extends DataMapper {

    var $table = 'Country';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
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
            'field' => 'Path',
            'label' => 'Path'
        ),
        array(
            'field' => 'Parent_ID',
            'label' => 'Parent ID'
        ),
        array(
            'field' => 'Levels',
            'label' => 'Levels'
        ),
        array(
            'field' => 'Level',
            'label' => 'Level'
        ),
        array(
            'field' => 'Type',
            'label' => 'Type'
        ),
        array(
            'field' => 'Sort',
            'label' => 'Sort'
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

    function Country() {
        parent::DataMapper();
    }
    
    public function get_country($member_id = -1,$level = 0,$parent_id = 0,$cat_type = null) {
        $sql = "SELECT c.*,ct.Order
                FROM `Country` AS c
                LEFT JOIN Common_Tracking AS ct ON ct.Reference_ID = c.ID AND ct.Type = 'country' AND ct.Type_ID = {$cat_type}
                WHERE (`c`.`Type` =  'System' OR `c`.`Member_ID` =  {$member_id} ) AND `c`.`Level` = {$level} AND `c`.`Parent_ID` = {$parent_id} AND `c`.`Disable` = 0 GROUP BY `c`.ID ORDER BY `c`.`Sort` ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function get_list_city($slug='/',$max_level=0) {
    	$sql = "SELECT *
                FROM (`Country`)
                WHERE `Country`.`Name` != '' AND Disable = 0";
        if ($slug != '') {
        	$sql .= " AND Path LIKE '{$slug}%' AND Path != '{$slug}' ";
        }
        if ($max_level >= 0) {
        	$sql .= " AND Level <= '{$max_level}' ";
        }
        $sql .= " ORDER BY Path ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function get_row($slug) {
    	$sql = "SELECT *
                FROM (`Country`)
                WHERE `Country`.`Name` != '' AND Disable = 0";
        if ($slug != '') {
        	$sql .= " AND Slug = '{$slug}' ";
        }
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    
    public function update_order($id = array(-1),$offset) {
        $id_in = implode(",", $id);
        if($offset > 0){
            $sql = "UPDATE `Country` SET `Order`= `Order` + " . $offset . " WHERE `Slug` IN ('{$id_in}')"; 
        }else{
            $sql = "UPDATE `Country` SET `Order`= `Order` + " . $offset . " WHERE `Slug` IN ('{$id_in}') AND `Order` != 0"; 
        }
        $this->db->query($sql);
    }
}
