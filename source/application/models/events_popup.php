<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events_Popup extends DataMapper {
    var $table = 'Events_Popup';
    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Hearder',
			'label' => 'Hearder'
		),
		array(
			'field' => 'Main',
			'label' => 'Main'
		),
		array(
			'field' => 'Footer',
			'label' => 'Footer'
		),
		array(
			'field' => 'Createat',
			'label' => 'Createat'
		),
		array(
			'field' => 'Disable',
			'label' => 'Disable'
		)
	);
    function Events_Popup()
    {
        parent::DataMapper();
    }
}