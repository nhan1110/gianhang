<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Advertise_Member extends DataMapper {
    var $table = 'Advertise_Member';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Token',
            'label' => 'Token',
        ),
        array(
            'field' => 'Email',
            'label' => 'Email'
        ),
        array(
            'field' => 'Password',
            'label' => 'Password'
        ),
        array(
            'field' => 'Createat',
            'label' => 'Createat'
        ),
        array(
            'field' => 'Logo',
            'label' => 'Logo'
        ),
        array(
            'field' => 'Disable',
            'label' => 'Disable'
        )
    );
    function Advertise_Member() {
        parent::DataMapper();
    }
    
}

