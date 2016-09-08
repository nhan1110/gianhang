<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Advertise_Block extends DataMapper {
    var $table = 'Advertise_Block';
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
            'field' => 'Description',
            'label' => 'Description'
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
    function Advertise_Block() {
        parent::DataMapper();
    }
}

