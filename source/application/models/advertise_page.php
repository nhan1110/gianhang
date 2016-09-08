<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Advertise_Page extends DataMapper {
    var $table = 'Advertise_Page';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Page',
            'label' => 'Page'
        ),
        array(
            'field' => 'Slug',
            'label' => 'Slug'
        ),
        array(
            'field' => 'Description',
            'label' => 'Description'
        ),
        array(
            'field' => 'Template_View',
            'label' => 'Template_View'
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
    function Advertise_Page() {
        parent::DataMapper();
    }
    function get_page_unique($block_id){
        $sql = "
            SELECT * FROM Advertise_Page AS ap WHERE ap.ID NOT IN (SELECT Page_ID FROM Advertise_Block_Page WHERE Block_ID = {$block_id})
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}

