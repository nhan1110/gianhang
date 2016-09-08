<?php



if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Category_Type extends DataMapper {

    var $table = 'Category_Type';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Name',
            'label' => 'Name'
        ),
        array(
            'field' => 'Parent_ID',
            'label' => 'Name'
        ),
        array(
            'field' => 'Slug',
            'label' => 'Slug'
        ),
        array(
            'field' => 'Sort',
            'label' => 'Sort'
        ),
        array(
            'field' => 'Disable',
            'label' => 'Disable'
        ),
        array(
            'field' => 'Images',
            'label' => 'Images'
        ),
        array(
            'field' => 'Icon',
            'label' => 'Icon'
        )
    );

    function Category_Type() {
        parent::DataMapper();
    }

    function get_id_last_save(){  
        return $this->db->insert_id();
    }

    function delete_by_id($id){
        $this->db->delete($this->table, array('ID' => $id));
    }
}

