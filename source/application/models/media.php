<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends DataMapper {

    var $table = 'Media';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Member_ID',
			'label' => 'Member ID'
		),
		array(
			'field' => 'Type',
			'label' => 'Type'
		),
		array(
			'field' => 'Name',
			'label' => 'Name'
		),
		array(
			'field' => 'Description',
			'label' => 'Description'
		),
		array(
			'field' => 'Createdat',
			'label' => 'Createdat'
		),
		array(
			'field' => 'Folder_ID',
			'label' => 'Folder ID'
		),
		array(
			'field' => 'Path',
			'label' => 'Path'
		),
		array(
			'field' => 'Path_Large',
			'label' => 'Path_Large'
		),
		array(
			'field' => 'Path_Medium',
			'label' => 'Path_Medium'
		),
		array(
			'field' => 'Path_Thumb',
			'label' => 'Path_Thumb'
		),
		array(
			'field' => 'Disable',
			'label' => 'Disable'
		)
	);


    function Media()
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