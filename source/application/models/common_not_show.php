<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_Not_Show extends DataMapper {

    var $table = 'Common_Not_Show';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Reference_ID',
            'label' => 'Reference_ID'
        ),
        array(
            'field' => 'Reference_Single_ID',
            'label' => 'Reference_Single_ID'
        ),
        array(
            'field' => 'Type',
            'label' => 'Type'
        ),
        array(
            'field' => 'Token',
            'label' => 'Token'
        ),
        array(
            'field' => 'Createat',
            'label' => 'Createat'
        )
    );

    function Common_Not_Show() {
        parent::DataMapper();
    }

}
