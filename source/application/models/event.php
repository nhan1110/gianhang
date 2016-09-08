<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends DataMapper {
    var $table = 'Events';
    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Title',
			'label' => 'Title'
		),
		array(
			'field' => 'Content',
			'label' => 'Content'
		),
		array(
			'field' => 'Popup_ID',
			'label' => 'Popup_ID'
		),
		array(
			'field' => 'Description',
			'label' => 'Description'
		),
		array(
			'field' => 'Email_ID',
			'label' => 'Email_ID'
		),
		array(
			'field' => 'Start_Day',
			'label' => 'Start_Day'
		),
		array(
			'field' => 'End_Day',
			'label' => 'End_Day'
		),
		array(
			'field' => 'Time_Display',
			'label' => 'Time_Display'
		),
		array(
			'field' => 'Set_Cookie',
			'label' => 'Set_Cookie'
		),
		array(
			'field' => 'Disable',
			'label' => 'Disable'
		)

	);
    function Event()
    {
        parent::DataMapper();
    }
    function get_event($id){
    	$this->db->select("e.Content,ep.*");
    	$this->db->from($this->table." AS e");
    	$this->db->join("Events_Popup AS ep","ep.ID = e.Popup_ID");
    	$this->db->where("e.ID",$id);
    	$this->db->where("e.Disable","0");
    	$query = $this->db->get();
    	return $query->row_array();
    }
    function get_all_is_user($is_login = false,$date){
    	if($is_login){
    		$sql = "
	    		SELECT `Events`.`ID`, `Events`.`Title`, `Events`.`Time_Display`, `Events`.`Set_Cookie`
				FROM (`Events`)
				WHERE `Events`.`Start_Day` <= '{$date}'
				AND `Events`.`End_Day` >= '{$date}' 
				AND (`Events`.`Is_Show` = '0' OR `Events`.`Is_Show` = '1')
				AND `Events`.`Disable` = '0'
    		";
    	}else{
    		$sql = "
	    		SELECT `Events`.`ID`, `Events`.`Title`, `Events`.`Time_Display`, `Events`.`Set_Cookie`
				FROM (`Events`)
				WHERE `Events`.`Start_Day` <= '{$date}'
				AND `Events`.`End_Day` >= '{$date}' 
				AND (`Events`.`Is_Show` = '0' OR `Events`.`Is_Show` = '2')
				AND `Events`.`Disable` = '0'
    		";
    	}
    	$query = $this->db->query($sql);
        return $query->result_array();
    }
}