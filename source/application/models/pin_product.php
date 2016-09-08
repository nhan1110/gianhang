<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pin_Product extends DataMapper {

    var $table = 'Pin_Product';
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
            'field' => 'Pin_ID',
            'label' => 'Pin ID'
        ),
        array(
            'field' => 'Date_Created',
            'label' => 'Date Created'
        )
    );

    function Pin_Product() {
        parent::DataMapper();
    }

	function get_last_id_save()
    {  
        return $this->db->insert_id();
    }

    function delete_by_id($cat_id = null ,$product_id = null) {
        $this->db->delete($this->table, array('Product_ID' => $product_id,'Pin_ID' => $cat_id));
    }

    function get_product_by_favorite($favorite_id = null){
        $this->db->select('p.*,pp.Pin_ID,m.Path_Thumb');
        $this->db->from($this->table .' AS pp');
        $this->db->join('Products AS p','pp.Product_ID = p.ID');
        $this->db->join('Member AS mb','p.Member_ID = mb.ID','LEFT');
        $this->db->join('Media_Product AS mp','mp.Product_ID = p.ID','LEFT');
        $this->db->join('Media AS m','m.ID = mp.Media_ID','LEFT');
        $this->db->where(array('pp.Pin_ID' => $favorite_id,'p.Disable' => 0));
        return $this->db->get()->result_array();
    }
}
