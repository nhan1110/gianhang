<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Advertise_Block_Page extends DataMapper {
    var $table = 'Advertise_Block_Page';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Page_ID',
            'label' => 'Page_ID'
        ),
        array(
            'field' => 'Block_ID',
            'label' => 'Block_ID'
        ),
        array(
            'field' => 'Description',
            'label' => 'Description'
        ),
        array(
            'field' => 'Price',
            'label' => 'Price'
        ),
        array(
            'field' => 'Number_Resgier',
            'label' => 'Number_Resgier'
        ),
        array(
            'field' => 'Createat',
            'label' => 'Createat'
        ),
        array(
            'field' => 'Disable',
            'label' => 'Disable'
        )
        
    );
    function Advertise_Block_Page() {
        parent::DataMapper();
    }
    function get_list_advertise(){
    	$this->db->select("abp.*,ab.Title,ap.Page");
    	$this->db->from("Advertise_Block AS ab");
    	$this->db->join("Advertise_Block_Page AS abp","abp.Block_ID = ab.ID");
    	$this->db->join("Advertise_Page AS ap","abp.Page_ID = ap.ID");
    	$query = $this->db->get();
    	return $query->result_array();
    }
    function show_register($user_id = -1){
        $this->db->select("abg.*,a.ID AS Advertise_ID,a.Advertise_Member_ID");
        $this->db->from($this->table . " AS abg");
        $this->db->join("Advertise AS a","a.Block_Page_ID = abg.ID AND `a`.`Advertise_Member_ID` = {$user_id}","LEFT");
        $query = $this->db->get();
        return $query->result_array();
    }
}

