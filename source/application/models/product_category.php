<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_Category extends DataMapper {

    var $table = 'Product_Category';

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
			'field' => 'Term_ID',
			'label' => 'Term ID'
		)
	);


    function Product_Category()
    {
        parent::DataMapper();
    }
}