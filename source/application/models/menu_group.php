<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_Group extends DataMapper {

    var $table = 'Menu_Group';

    var $validation = array(
		array(
			'field' => 'Group_ID',
			'label' => 'Group ID'
		),
		array(
			'field' => 'Name',
			'label' => 'Name'
		),
		array(
			'field' => 'Date_Creater',
			'label' => 'Date Creater'
		)
	);


    function Menu_Group()
    {
        parent::DataMapper();
    }

    function get_id_last_save()
    {  
        return $this->db->insert_id();
    }

    function delete_by_id($id)
    {
    	$this->db->delete($this->table, array('Group_ID' => $id));
    }
}