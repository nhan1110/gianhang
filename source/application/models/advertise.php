<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Advertise extends DataMapper {
    var $table = 'Advertise';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Title',
            'label' => 'Title'
        ),
        array(
            'field' => 'Company_Name',
            'label' => 'Company_Name'
        ),
        array(
            'field' => 'Slug',
            'label' => 'Slug'
        ),
        array(
            'field' => 'Logo',
            'label' => 'Logo'
        ),
        array(
            'field' => 'Content',
            'label' => 'Content'
        ),
        array(
            'field' => 'Description',
            'label' => 'Description'
        ),
        array(
            'field' => 'Email',
            'label' => 'Email'
        ),
        array(
            'field' => 'Phone',
            'label' => 'Phone'
        ),
        array(
            'field' => 'Web_Addresses',
            'label' => 'Web_Addresses'
        ),
        array(
            'field' => 'Messenger_Error',
            'label' => 'Messenger_Error'
        ),
        array(
            'field' => 'Createat',
            'label' => 'Createat'
        ),
        array(
            'field' => 'Disable',
            'label' => 'Disable'
        ),
        array(
            'field' => 'Level',
            'label' => 'Level'
        ),
        array(
            'field' => 'Start_Day',
            'label' => 'Start_Day'
        ),
        array(
            'field' => 'End_Day',
            'label' => 'End_Day'
        )
    );
    function Advertise() {
        parent::DataMapper();
    }
    function get_all_advertise(){
        $this->db->select("a.*,abp.Name,abp.Price,abp.Number_Resgier");
        $this->db->from("Advertise AS a");
        $this->db->join("Advertise_Block_Page AS abp","a.Block_Page_ID = abp.ID");
        $query = $this->db->get();
        return $query->result_array();
    }
}

