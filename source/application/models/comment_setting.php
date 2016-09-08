<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment_Setting extends DataMapper {

    var $table = 'Comment_Setting';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'URL',
			'label' => 'URL'
		),
		array(
			'field' => 'Status',
			'label' => 'Status'
		),
		array(
			'field' => 'Member_ID',
			'label' => 'Member ID'
		)
	);


    function Comment_Setting()
    {
        parent::DataMapper();
    }
}