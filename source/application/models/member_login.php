<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Login extends DataMapper {

    var $table = 'Member_Login';

    var $validation = array(
    	array(
			'field' => 'Member_ID',
			'label' => 'Member ID',
		),
		array(
			'field' => 'Access_IP',
			'label' => 'Access IP'
		),
		array(
			'field' => 'Access_Type',
			'label' => 'Access Type'
		),
		array(
			'field' => 'Accessed_Date',
			'label' => 'Accessed Date'
		)
	);


    function Member_Login()
    {
        parent::DataMapper();
    }
}