<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_Meta extends DataMapper {

    var $table = 'Product_Meta';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Product_ID',
			'label' => 'Product ID'
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


    function Product_Meta()
    {
        parent::DataMapper();
    }
}