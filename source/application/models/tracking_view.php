<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tracking_View extends DataMapper {

    var $table = 'Tracking_View';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'OS',
			'label' => 'OS'
		),
		array(
			'field' => 'IP',
			'label' => 'IP'
		),
		array(
			'field' => 'BROW',
			'label' => 'BROW'
		),
		array(
			'field' => 'URL',
			'label' => 'URL'
		),
		array(
			'field' => 'Date',
			'label' => 'Date'
		)
	);


    function Tracking_View()
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