<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter_Signup extends DataMapper {
    var $table = 'Newsletter_Signup';
    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Email',
			'label' => 'Email'
		),
		array(
			'field' => 'Createat',
			'label' => 'Createat'
		),
		array(
			'field' => 'Active',
			'label' => 'Active'
		),
		array(
			'field' => 'Active_Day',
			'label' => 'Active_Day'
		),
		array(
			'field' => 'Event_ID',
			'label' => 'Event_ID'
		),
		array(
			'field' => 'Token',
			'label' => 'Token'
		),
		array(
			'field' => 'Disable',
			'label' => 'Disable'
		)

	);
    function Newsletter_Signup()
    {
        parent::DataMapper();
    }
   
}