<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Payments extends DataMapper {
    var $table = 'Payments';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Title',
            'label' => 'Title'
        ),
        array(
            'field' => 'Slug',
            'label' => 'Slug'
        ),
        array(
            'field' => 'Setting',
            'label' => 'Setting'
        ),
        array(
            'field' => 'Status',
            'label' => 'Status'
        ),
        array(
            'field' => 'Sort',
            'label' => 'Sort'
        )
    );
    function Payments() {
        parent::DataMapper();
    }

}

