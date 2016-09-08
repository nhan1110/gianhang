<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rates extends DataMapper {

    var $table = 'Rate';

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
			'field' => 'URL',
			'label' => 'URL'
		),
		array(
			'field' => 'Member_ID',
			'label' => 'Member ID'
		),
		array(
			'field' => 'Num_Rate',
			'label' => 'Num Rate'
		)
	);


    function Rate()
    {
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