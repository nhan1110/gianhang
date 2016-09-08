<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quick_Track extends DataMapper {

    var $table = 'Quick_Track';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Qty_Comment',
			'label' => 'Qty Comment'
		),
		array(
			'field' => 'Qty_Favorite',
			'label' => 'Qty Favorite'
		),
		array(
			'field' => 'Qty_Like',
			'label' => 'Qty Like'
		),
		array(
			'field' => 'Qty_Dislike',
			'label' => 'Qty Dislike'
		),
		array(
			'field' => 'Qty_Rate',
			'label' => 'Qty Rate'
		),
		array(
			'field' => 'URL',
			'label' => 'URL'
		),
		array(
			'field' => 'Member_ID',
			'label' => 'Member ID'
		)
	);


    function Quick_Track()
    {
        parent::DataMapper();
    }
}