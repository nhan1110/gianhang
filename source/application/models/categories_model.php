<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories_model extends CI_Model {

    private $table = "categories";

    function __construct() {
        parent::__construct();
    }

    function get_categories_byuserid($id) {
        $this->db->select("*","SElECT COUNT(ct1.id) FROM categories AS ct1 WHERE ct1.pid = ct.id AS order_items");
        $this->db->from($this->table . " AS ct");
        $this->db->where("user_id", $id);
        return $this->db->get()->result_array();
    }

}
