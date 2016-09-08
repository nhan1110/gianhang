<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Advertise_Promo_Block_Page extends DataMapper {
    var $table = 'Advertise_Promo_Block_Page';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Advertise_Promo_ID',
            'label' => 'Advertise Promo ID'
        ),
        array(
            'field' => 'Advertise_Block_Page_ID',
            'label' => 'Advertise Block Page ID'
        )
    );
    function Advertise_Promo_Block_Page() {
        parent::DataMapper();
    }

    function get_list_promo_by_block_page($block_page_id){
        $this->db->select("ap.*");
        $this->db->from($this->table." AS pr");
        $this->db->join("Advertise_Promo AS ap",'pr.Advertise_Promo_ID = ap.ID');
        $this->db->where(array('pr.Advertise_Block_Page_ID' => $block_page_id,"Status" => 1));
        return $this->db->get()->result_array();
    }

    function delete_by_promo_id($id)
    {
        $this->db->delete($this->table, array('Advertise_Promo_ID' => $id));
    }
}

