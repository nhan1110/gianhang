<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media_Folder extends DataMapper {

    var $table = 'Media_Folder';

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
			'field' => 'Parents_ID',
			'label' => 'Parents ID'
		),
		array(
			'field' => 'Path',
			'label' => 'Path'
		),
		array(
			'field' => 'Folder_Name',
			'label' => 'Folder Name'
		),
		array(
			'field' => 'Slug',
			'label' => 'Slug'
		),
		array(
			'field' => 'Status',
			'label' => 'Status'
		),
		array(
			'field' => 'Date_Created',
			'label' => 'Date Created'
		)
	);


    function Media_Folder()
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