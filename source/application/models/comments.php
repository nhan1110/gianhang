<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends DataMapper {

    var $table = 'Comment';

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
			'field' => 'Content',
			'label' => 'Content'
		),
		array(
			'field' => 'Createdat',
			'label' => 'Createdat'
		),
		array(
			'field' => 'Updatedat',
			'label' => 'Updatedat'
		),
		array(
			'field' => 'Setting_ID',
			'label' => 'Setting ID'
		),
		array(
			'field' => 'URL',
			'label' => 'URL'
		),
		array(
			'field' => 'Parent_ID',
			'label' => 'Parent ID'
		)
	);


    function Comment()
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