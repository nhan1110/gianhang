<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_Price extends DataMapper {

    var $table = 'Product_Price';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Type',
			'label' => 'Type'
		),
		array(
			'field' => 'Price',
			'label' => 'Price'
		),
		array(
			'field' => 'Special_Start',
			'label' => 'Special Start'
		),
		array(
			'field' => 'Special_End',
			'label' => 'Special End'
		),
		array(
			'field' => 'Is_Main',
			'label' => 'Is Main'
		),
		array(
			'field' => 'Special_Percent',
			'label' => 'Special Percent'
		),
		array(
			'field' => 'Special_Price',
			'label' => 'Special Price'
		)
	);


    function Product_Price()
    {
        parent::DataMapper();
    }
}