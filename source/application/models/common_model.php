<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function add($table, $data)
    {
        $this->db->trans_start();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    function delete($table, $where)
    {
        $return = false;
        $this->db->trans_start();
        $return = $this->db->delete($table, $where);
        $this->db->trans_complete();
        return $return;
    }
    function update($table, $data, $where)
    {
        $return = false;
        $this->db->trans_start();
        $this->db->where($where);
        $return = $this->db->update($table, $data);
        $this->db->trans_complete();
        return $return;
    }
    function get_record($table,$where){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        return $this->db->get()->row_array();
    }
    function get_result($table,$where = null,$offset = 0,$limit = 0,$orderby=null){
        $this->db->select('*');
        $this->db->from($table);
        if($where != null){
            $this->db->where($where);
        }
        if ($limit != 0) {
            $this->db->limit($limit, $offset);
        }
        if($orderby!=null) {
            $this->db->order_by($orderby,'DESC');
        }
        return $this->db->get()->result_array();
    }

    function query_raw($sql) {
        return $this->db->query($sql)->result_array();
    }

    function insert_batch_data($table,$data)
    {
        $this->db->insert_batch($table, $data); 
    }
    function count_table($table,$filter = array()){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($filter);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function slug($table,$colum,$like,$where = null){
        $this->db->select($colum);
        $this->db->from($table);
        $this->db->like($colum,$like);
        if($where != null){
            $this->db->where($where);
        }
        return $this->db->get()->result_array();
    }
    function slug_member($table,$colum,$like,$member_id){
        $this->db->select($colum);
        $this->db->from($table);
        $this->db->like($colum,$like);
        $this->db->where('Member_ID',$member_id);
        return $this->db->get()->result_array();
    }
    function findAll(){
        return $this->db->get('Block')->result();
    }
    function find($id){
        $this->db->where('ID',$id);
        return $this->db->get('Block',$id)->row();
    }
}