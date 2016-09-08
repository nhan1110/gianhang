<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_Tracking extends DataMapper {

    var $table = 'Common_Tracking';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Reference_ID',
			'label' => 'Reference_ID'
		),
		array(
			'field' => 'Type_ID',
			'label' => 'Type_ID'
		),
		array(
			'field' => 'Type',
			'label' => 'Type'
		),
		array(
			'field' => 'Order',
			'label' => 'Order'
		)
	);


    function Common_Tracking()
    {
        parent::DataMapper();
    }

    function update_order($type_id,$attr_id = array(),$type,$offset = 1){
    	$where = "";
    	if($offset == -1){ $where = "AND `Order` > 0 ";}
        $id_in = implode(",", $attr_id);
    	$sql = "UPDATE `Common_Tracking` SET `Order`= `Order` + " . $offset . " WHERE Reference_ID IN ({$id_in}) AND Type_ID = {$type_id} AND Type = '{$type}' {$where}"; 
    	$this->db->query($sql);
    }
}