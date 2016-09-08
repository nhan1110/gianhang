<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Meta extends DataMapper {

    var $table = 'Member_Meta';

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
			'field' => 'Key',
			'label' => 'Key'
		),
		array(
			'field' => 'Value',
			'label' => 'Value'
		)
	);


    function Member_Meta()
    {
        parent::DataMapper();
    }
}