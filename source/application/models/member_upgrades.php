<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member_Upgrades extends DataMapper {
    var $table = 'Member_Upgrades';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Member_ID',
            'label' => 'Member_ID'
        ),
        array(
            'field' => 'Upgrades_ID',
            'label' => 'Upgrades ID'
        ),
        array(
            'field' => 'Start_Day',
            'label' => 'Start_Day'
        ),
        array(
            'field' => 'End_Day',
            'label' => 'End_Day'
        ),
        array(
            'field' => 'Createat',
            'label' => 'Createat'
        ),
        array(
            'field' => 'Updateat',
            'label' => 'Updateat'
        )
    );
    
    function Member_Upgrades() {
        parent::DataMapper();
    }

}