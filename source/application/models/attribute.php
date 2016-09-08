<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Attribute extends DataMapper {
    var $table = 'Attribute';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Category_Type_ID',
            'label' => 'Category_Type_ID'
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
            'field' => 'Parent_ID',
            'label' => 'Parent ID'
        ),
        array(
            'field' => 'Path',
            'label' => 'Path'
        ),
        array(
            'field' => 'Value',
            'label' => 'Value'
        ),
        array(
            'field' => 'Type',
            'label' => 'Type'
        ),
        array(
            'field' => 'Require',
            'label' => 'Require'
        ),
        array(
            'field' => 'Validate',
            'label' => 'Validate'
        ),
        array(
            'field' => 'Messenger_Error',
            'label' => 'Messenger_Error'
        ),
        array(
            'field' => 'Disable',
            'label' => 'Disable'
        ),
        array(
            'field' => 'Order',
            'label' => 'Order'
        ),
        array(
            'field' => 'Createat',
            'label' => 'Createat'
        ),
        array(
            'field' => 'Sort',
            'label' => 'Sort'
        )
    );

    function Attribute() {
        parent::DataMapper();
    }

    function replace_slug($table = "", $old_slug = "", $slug = "", $pid = "") {
        $sql = "update {$table} set Path = replace(Path, '{$old_slug}', '{$slug}') where Parent_ID = {$pid}";
        $query = $this->db->query($sql);

    }



    public function get_attribute_hideen($reference_type_id = 0, $token, $type, $product_id = -1, $member_id) {
        $sql = "SELECT `a`.* FROM (`Attribute` AS a) JOIN `Attribute_Group_Attribute` AS ag ON `ag`.`Attribute_ID` = `a`.`ID` JOIN `Common_Not_Show` AS cns ON `cns`.`Reference_ID` = `a`.`ID`WHERE (`cns`.`Token` = '{$token}' OR `cns`.`Product_ID` = {$product_id}) AND(`cns`.`Reference_Type_ID` = {$reference_type_id} AND `cns`.`Type` = '{$type}') AND `a`.`Disable` = '0' AND (`a`.`Member_ID` = {$member_id} OR `a`.`Type` = 'System') GROUP BY `a`.`ID`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function update_order($id = array(-1),$offset) {
        $id_in = implode(",", $id);
        if($offset > 0){
            $sql = "UPDATE `Attribute` SET `Order`= `Order` + " . $offset . " WHERE `ID` IN (" . $id_in . ")"; 
        }else{
            $sql = "UPDATE `Attribute` SET `Order`= `Order` + " . $offset . " WHERE `ID` IN (" . $id_in . ") AND `Order` != 0"; 
        }
        $this->db->query($sql);
    }

    public function get_attribute_by_cat($cat_id = 0,$member_id = 0 ,$type_member ="member"){
        if($type_member == "System"){
            $sql = "SELECT `a`.* FROM Attribute AS a 
                    LEFT JOIN Category_Type AS aga ON `aga`.`ID` = `a`.`Category_Type_ID`
                    WHERE ( (`a`.`Category_Type_ID` = {$cat_id})  OR (`a`.`Category_Type_ID` = (SELECT `cc`.`Parent_ID` FROM Category_Type AS cc WHERE `cc`.`ID` = {$cat_id})) ) AND `a`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$cat_id} AND `cmns`.`Type` = 'attribute' AND `cmns`.`Single_Type` = 'category_type')
                    GROUP BY `a`.`ID` ORDER BY `a`.`Sort` ASC, `a`.`Createat` ASC";          
        }else{
            $sql = "SELECT `a`.* FROM Attribute AS a 
                    LEFT JOIN Category_Type AS aga ON `aga`.`ID` = `a`.`Category_Type_ID`
                    WHERE(
                            (`a`.`Category_Type_ID` = {$cat_id} AND `a`.`Member_ID` = {$member_id})  
                            OR 
                            (`a`.`Category_Type_ID` = (SELECT `cc`.`Parent_ID` FROM Category_Type AS cc WHERE `cc`.`ID` = {$cat_id}) AND `a`.`Type` = 'System')
                        ) AND `a`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$cat_id} AND `cmns`.`Type` = 'attribute' AND `cmns`.`Single_Type` = 'category_type') 
                    GROUP BY `a`.`ID` ORDER BY `a`.`Sort` ASC, `a`.`Createat` ASC";   
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function attribute_owner($cat_id){
        $this->db->select("a.*");
        $this->db->from($this->table. " AS a");
        $this->db->join("Attribute_Group_Attribute AS ag","ag.Attribute_ID = a.ID AND a.Parent_ID != 0");
        $this->db->join("Attribute_Group_Category_Type AS agct","agct.Attribute_Group_ID = ag.ID");
        $this->db->where("agct.Category_Type_ID",$cat_id);
        $this->db->or_where("Type", "system");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_attr_cat_set($category_type_id,$value,$not_id,$current_type_id = null){
        $this->db->select("a.*");
        $this->db->from($this->table. " AS a");
        $this->db->where_in("a.Category_Type_ID",$category_type_id);
        $this->db->where_in("a.Value",$value);
        $this->db->where_not_in("a.ID",$not_id);
        $this->db->where("Show_Search","1");
        $this->db->order_by("a.Sort","ASC");
        $query = $this->db->get();
        $table_1 = $query->result_array();
        $this->db->select("cm.*");
        $this->db->from("Common_Tracking AS cm");
        $this->db->where(["cm.Type_ID"=>$current_type_id,"Type" => "attribute"]);
        $query = $this->db->get();
        $table_2 = $query->result_array();
        $new_array = [];
        if($table_1 != null){
            foreach ($table_1 as $key_1 => $value_1) {
                if($table_2 != null){
                    foreach ($table_2 as $key_2 => $value_2) {
                        if($value_1["ID"] == $value_2["Reference_ID"]){
                            $value_1["Order"] = $value_2["Order"];
                            unset($table_2[$key_2]);
                        }
                    }
                }
                $new_array [] = $value_1;
            }
        }
        return  $new_array;
    }

}

