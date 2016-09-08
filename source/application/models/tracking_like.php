<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tracking_Like extends DataMapper {

    var $table = 'Tracking_Like';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Is_Like',
			'label' => 'Is Like'
		),
		array(
			'field' => 'Member_ID',
			'label' => 'Member ID'
		),
		array(
			'field' => 'Date_Creat',
			'label' => 'Date Creat'
		),
		array(
			'field' => 'URL',
			'label' => 'URL'
		)
	);


    function Tracking_Like()
    {
        parent::DataMapper();
    }
    
    function get_id_last_save(){  
        return $this->db->insert_id();
    }

    function delete_by_id($id){
    	$this->db->delete($this->table, array('ID' => $id));
    }
}