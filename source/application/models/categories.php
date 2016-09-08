<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories extends DataMapper {

    var $table = 'Categories';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Name',
            'label' => 'Name'
        ),
        array(
            'field' => 'Slug',
            'label' => 'Slug'
        ),
        array(
            'field' => 'Order',
            'label' => 'Order'
        ),
        array(
            'field' => 'Path',
            'label' => 'Path'
        ),
        array(
            'field' => 'Parent_ID',
            'label' => 'Parent_ID'
        ),
        array(
            'field' => 'Type',
            'label' => 'Type'
        ),
        array(
            'field' => 'Type_ID',
            'label' => 'Type ID'
        ),
        array(
            'field' => 'Member_id',
            'label' => 'Member ID'
        ),
        array(
            'field' => 'Slug',
            'label' => 'Slug'
        ),
        array(
            'field' => 'Created_at',
            'label' => 'Created_at'
        ),
        array(
            'field' => 'Updated_at',
            'label' => 'Updated_at'
        ),
        array(
            'field' => 'Order',
            'label' => 'Order'
        ),
        array(
            'field' => 'Disable',
            'label' => 'Disable'
        )
    );

    function Categories() {
        parent::DataMapper();
    }

    function get_categories_byuserid($id) {
        $this->db->select("*", "SElECT COUNT(ct1.id) FROM categories AS ct1 WHERE ct1.pid = ct.id AS order_items");
        $this->db->from($this->table . " AS ct");
        $this->db->where(array("user_id" => $id ,"Disable" => "0"));
        return $this->db->get()->result_array();
    }

    function get_id_last_save() {
        return $this->db->insert_id();
    }

    function delete_by_id($id) {
        $this->db->delete($this->table, array('ID' => $id));
    }

    function delete_by_group_id($id) {
        $this->db->delete($this->table, array('Type_ID' => $id));
    }

    public function update_order($id,$offset,$column = "ID") {
        $id_in = implode("','", $id);
        if($column == "ID"){
            $id_in = implode(",", $id);
        }else{
             $id_in = "'".implode("','", $id)."'";
        }
        if($offset > 0 ){
            $sql = "UPDATE `Categories` SET `Order`= `Order` + ".$offset." WHERE `{$column}` IN (".$id_in.")"; 
        }else{
            $sql = "UPDATE `Categories` SET `Order`= `Order` + ".$offset." WHERE `{$column}` IN (".$id_in.") AND `Order` != 0"; 
        }
        $this->db->query($sql);
    }
    public function get_cat_by_type($path){
        $this->db->select("c.*");
        $this->db->from($this->table." AS c");
        $this->db->join("Category_Type AS ct","ct.ID = c.Type_ID");
        $this->db->like("ct.Path",$path);
        $this->db->where(["c.Disable" => "0","c.Parent_ID" => "0"]);
        return $this->db->get()->result_array();
    }
    public function get_category_by_cat($cat_id = null){
        $this->db->select("c.*");
        $this->db->from($this->table." AS c");
        $this->db->join("Product_Category AS pc","pc.Term_ID = c.ID");
        $this->db->join("Products AS p","p.ID = pc.Product_ID AND p.Type_ID = {$cat_id}");
        $this->db->order_by("c.Createdat","DESC");
        $this->db->group_by("c.ID");
        return $this->db->get()->result_array();
    }
    public function get_cat_cat_set($type_path,$parent_id,$current_type_id){ 
        // current type.    
        $sql = "
        SELECT * FROM (SELECT c.*,ct.`Order` FROM  Common_Tracking AS ct 
        JOIN Category_Type AS cty ON cty.ID = ct.Type_ID AND cty.Path LIKE '%{$type_path}%'
        JOIN Categories AS c ON c.ID = ct.Reference_ID AND ct.Type='category'  order by ct.Order DESC) AS table_1 GROUP BY table_1.ID";
        $current =  $this->db->query($sql)->result_array();
        $id_not_in = [0];
        if($current != null){
            foreach ($current as $key => $value) {
                if(isset($value["ID"])){
                    $id_not_in [] = $value["ID"];
                }  
            }
        }
        $id_not_in = implode("','", $id_not_in);
        $id_not_in = "'".$id_not_in."'";
        // parent type.
        $sql = "
            SELECT c.*, '0' AS `Order`
            FROM Categories AS c
            JOIN Category_Type AS cty ON cty.ID = c.Type_ID AND (cty.Path LIKE '%{$type_path}%' OR cty.ID = {$parent_id})
            WHERE  c.ID NOT IN ({$id_not_in}) group by c.ID
        ";
        $parent =  $this->db->query($sql)->result_array();
        $all = array_merge($parent,$current);
        $all = $this->array_sort($all, 'Sort', SORT_ASC);
        return $all;
    }
    //Arrangement array
    function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }
            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        return $new_array;
    }

}
