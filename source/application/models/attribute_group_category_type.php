<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Attribute_Group_Category_Type extends DataMapper {



    var $table = 'Attribute_Group_Category_Type';

    var $validation = array(

        array(

            'field' => 'ID',

            'label' => 'ID',

        ),

        array(

            'field' => 'Attribute_Group_ID',

            'label' => 'Attribute_Group_ID'

        ),

        array(

            'field' => 'Category_Type_ID',

            'label' => 'Category_Type_ID'

        ),

        array(

            'field' => 'Createdat',

            'label' => 'Createdat'

        )

    );



    function Attribute_Group_Category_Type() {
        parent::DataMapper();

    }

}

