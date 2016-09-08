<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media_Product extends DataMapper {

    var $table = 'Media_Product';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Media_ID',
			'label' => 'Media ID'
		),
		array(
			'field' => 'Product_ID',
			'label' => 'Product ID'
		)
	);


    function Media_Product()
    {
        parent::DataMapper();
    }
    
    function get_by_product($product_id){
        $this->db->select("m.*");
        $this->db->from("Media AS m");
        $this->db->join("Media_Product AS mp","mp.Media_ID = m.ID");
        $this->db->where("mp.Product_ID",$product_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}