<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Like extends DataMapper {

    var $table = 'Like';

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
			'field' => 'URL',
			'label' => 'URL'
		),
		array(
			'field' => 'Type',
			'label' => 'Type'
		),
		array(
			'field' => 'Createdat',
			'label' => 'Createdat'
		)
	);


    function Like()
    {
        parent::DataMapper();
    }
}