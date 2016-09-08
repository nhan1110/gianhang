<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Track_Page extends DataMapper {

    var $table = 'Track_Page';

    var $validation = array(
    	array(
			'field' => 'Member_ID',
			'label' => 'Member ID',
		),
		array(
			'field' => 'Category_ID',
			'label' => 'Category ID'
		),
		array(
			'field' => 'Product_ID',
			'label' => 'Product ID'
		),
		array(
			'field' => 'Tracked_Date',
			'label' => 'TrackedDate'
		)
	);


    function Track_Page()
    {
        parent::DataMapper();
    }
}