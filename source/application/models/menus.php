<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus extends DataMapper {

    var $table = 'Menu';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Name',
			'label' => 'Name'
		),
		array(
			'field' => 'Slug',
			'label' => 'Slug'
		),
		array(
			'field' => 'Path',
			'label' => 'Path'
		),
		array(
			'field' => 'Class',
			'label' => 'Class'
		),
		array(
			'field' => 'URL',
			'label' => 'URL'
		),
		array(
			'field' => 'Type',
			'label' => 'Type'
		),
		array(
			'field' => 'Order',
			'label' => 'Order'
		),
		array(
			'field' => 'Parent_ID',
			'label' => 'Parent ID'
		),
		array(
			'field' => 'Group_ID',
			'label' => 'Group ID'
		)
	);


    function Menus()
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

    function delete_by_group_id($group_id){
    	$this->db->delete($this->table, array('Group_ID' => $group_id));
    }
}