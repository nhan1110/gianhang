<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attribute_Value extends DataMapper {

    var $table = 'Attribute_Value';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Attribute_ID',
            'label' => 'Attribute_ID'
        ),
        array(
            'field' => 'Product_ID',
            'label' => 'Product_ID'
        ),
        array(
            'field' => 'Value',
            'label' => 'Value'
        )
    );

    function Attribute_Value() {
        parent::DataMapper();
    }

    function get_by_product_id($product_id){
        $this->db->select('av.*,a.Name');
        $this->db->from($this->table.' AS av');
        $this->db->join('Attribute AS a','av.Attribute_ID = a.ID');
        $this->db->where(array('av.Product_ID' => $product_id));
        return $this->db->get()->result_array();
    }
}
