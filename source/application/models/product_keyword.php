<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_Keyword extends DataMapper {

    var $table = 'Product_Keyword';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Product_ID',
            'label' => 'Product ID'
        ),
        array(
            'field' => 'Keyword_ID',
            'label' => 'Keyword ID'
        )
    );

    function ProductKeyword() {
        parent::DataMapper();
    }

    public function get_by_product($product = -1) {
        $this->db->select("k.*");
        $this->db->from($this->table." AS pk");
        $this->db->join("Keywords AS k", "k.ID = pk.Keyword_ID");
        $this->where("pk.Product_ID",$product);
        $query = $this->db->get();
        return $query->result_array();
    }

}
