<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Favorite_Model extends DataMapper {

    var $table = 'Favorite';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Member_Owner_ID',
			'label' => 'Member Owner ID'
		),
		array(
			'field' => 'Member_ID',
			'label' => 'Member ID'
		),
		array(
			'field' => 'Product_ID',
			'label' => 'Product ID'
		),
		array(
			'field' => 'Createdat',
			'label' => 'Createdat'
		)
	);


    function Favorite_Model()
    {
        parent::DataMapper();
    }
}