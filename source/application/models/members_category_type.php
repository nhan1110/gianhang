<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Members_Category_Type extends DataMapper {

    var $table = 'Members_Category_Type';
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
            'field' => 'Type_ID',
            'label' => 'Type_ID'
        ),
        array(
            'field' => 'Createdat',
            'label' => 'Createdat'
        )
    );

    function Members_Category_Type() {
        parent::DataMapper();
    }
}

