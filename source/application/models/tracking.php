<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tracking extends DataMapper {

    var $table = 'Tracking';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Num_Comment',
			'label' => 'Num Comment'
		),
		array(
			'field' => 'Num_View',
			'label' => 'Num View'
		),
		array(
			'field' => 'Num_Rate',
			'label' => 'Num Rate'
		),
		array(
			'field' => 'Num_Share_Google',
			'label' => 'Num Share Google'
		),
		array(
			'field' => 'Num_Like',
			'label' => 'Num Like'
		),
		array(
			'field' => 'Num_Share_Facebook',
			'label' => 'Num Share Facebook'
		),
		array(
			'field' => 'URL',
			'label' => 'URL'
		)
	);


    function Tracking()
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