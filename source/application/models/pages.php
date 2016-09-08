<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends DataMapper {

    var $table = 'Pages';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Page_Title',
			'label' => 'Page Title'
		),
		array(
			'field' => 'Page_Slug',
			'label' => 'Page Slug'
		),
		array(
			'field' => 'Page_Type',
			'label' => 'Page Type'
		),
		array(
			'field' => 'Page_Description',
			'label' => 'Page Description'
		),
		array(
			'field' => 'Page_Content',
			'label' => 'Page Content'
		),
		array(
			'field' => 'Page_Feature_Image',
			'label' => 'Page Feature Image'
		),
		array(
			'field' => 'Page_Createdat',
			'label' => 'Page Createdat'
		),
		array(
			'field' => 'Order',
			'label' => 'Order'
		),
		array(
			'field' => 'Page_Status',
			'label' => 'Page Status'
		),
		array(
			'field' => 'Page_Updatedat',
			'label' => 'Page Updatedat'
		),
		array(
			'field' => 'Page_Sort',
			'label' => 'Page Sort'
		)
	);


    function Pages()
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