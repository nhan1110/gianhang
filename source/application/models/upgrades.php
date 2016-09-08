<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Upgrades extends DataMapper {
    var $table = 'Upgrades';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Number_Month',
            'label' => 'Number_Month'
        ),
        array(
            'field' => 'Description',
            'label' => 'Description'
        ),
        array(
            'field' => 'Price_One_Month',
            'label' => 'Price_One_Month'
        ),
        array(
            'field' => 'Sale',
            'label' => 'Sale'
        ),
        array(
            'field' => 'Unit',
            'label' => 'Unit'
        ),
        array(
            'field' => 'Date_Start',
            'label' => 'Date Start'
        ),
        array(
            'field' => 'Date_End',
            'label' => 'Date End'
        )
    );
    function Upgrades() {
        parent::DataMapper();
    }

}

