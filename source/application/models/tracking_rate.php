<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tracking_Rate extends DataMapper {

    var $table = 'Tracking_Rate';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Num_1',
			'label' => 'Num 1'
		),
		array(
			'field' => 'Num_2',
			'label' => 'Num 2'
		),
		array(
			'field' => 'Num_3',
			'label' => 'Num 3'
		),
		array(
			'field' => 'Num_4',
			'label' => 'Num 4'
		),
		array(
			'field' => 'Num_5',
			'label' => 'Num 5'
		),
		array(
			'field' => 'URL',
			'label' => 'URL'
		)
	);


    function Tracking_Rate(){
        parent::DataMapper();
    }
    
    function get_id_last_save(){  
        return $this->db->insert_id();
    }

    function delete_by_id($id){
    	$this->db->delete($this->table, array('ID' => $id));
    }
}