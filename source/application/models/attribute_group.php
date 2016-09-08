<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attribute_Group extends DataMapper {
    var $table = 'Attribute_Group';
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
            'field' => 'Type_ID',
            'label' => 'Type_ID'
        ),
        array(
            'field' => 'Member_ID',
            'label' => 'Member_ID'
        ),

        array(
            'field' => 'Type',
            'label' => 'Type'
        ),
        array(
            'field' => 'Sort',
            'label' => 'Sort'
        )
    );

    function Attribute_Group() {
        parent::DataMapper();
    }

    function get_attr_cat_type($cat_type_id, $member_id = "0", $type_member = "Member", $product_id = -1) {
        if ($type_member == "System")
            $sql = "SELECT DISTINCT `ag`.* FROM `Attribute_Group` AS ag  
                    JOIN `Attribute_Group_Category_Type` AS agct ON `agct`.`Attribute_Group_ID` = `ag`.`ID`
                    WHERE
                    ( 

                        (

                            (`ag`.`Type` = 'System' AND (`agct`.`Category_Type_ID` = {$cat_type_id} OR `agct`.`Category_Type_ID` = (Select `cc`.`Parent_ID` From Category_Type AS cc WHERE `cc`.`ID` = {$cat_type_id} limit 1) ) ) 

                        ) AND 

                        `ag`.`ID` NOT IN(SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$product_id} AND `cmns`.`Type` = 'group')
                        AND `ag`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$cat_type_id} AND `cmns`.`Type` = 'group' AND `cmns`.`Single_Type` = 'category_type')

                    )

                    ORDER BY `ag`.`Type` ASC , `ag`.`Sort` ASC";

        else

            $sql = "SELECT DISTINCT `ag`.* FROM `Attribute_Group` AS ag  
                    JOIN `Attribute_Group_Category_Type` AS agct ON `agct`.`Attribute_Group_ID` = `ag`.`ID`
                    WHERE

                    ( 

                        (

                            (`ag`.`Type` = 'System' AND (`agct`.`Category_Type_ID` = {$cat_type_id} OR `agct`.`Category_Type_ID` = (Select `cc`.`Parent_ID` From Category_Type AS cc WHERE `cc`.`ID` = {$cat_type_id} limit 1) ) ) OR

                            (`ag`.`Member_ID` = {$member_id} AND `agct`.`Category_Type_ID` = {$cat_type_id}) 

                        ) AND 

                        `ag`.`ID` NOT IN(SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$product_id} AND `cmns`.`Type` = 'group')
                        AND `ag`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$cat_type_id} AND `cmns`.`Type` = 'group' AND `cmns`.`Single_Type` = 'category_type')

                    )

                    ORDER BY `ag`.`Type` ASC , `ag`.`Sort` ASC";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_group_attribute($cat_type, $product_id = -1, $member_id = 0, $type_member = "Member") {
        if ($type_member == "System")
            $sql = 'SELECT `ag`.* FROM (`Attribute_Group` AS ag) 
                    JOIN `Attribute_Group_Category_Type` AS agct ON `agct`.`Attribute_Group_ID` = `ag`.`ID`
                    WHERE 
                    (

                        `agct`.`Category_Type_ID` = {$cat_type} AND 
                        `ag`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$product_id} AND `cmns`.`Type` = "group")
                         AND `ag`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$cat_type} AND `cmns`.`Type` = "attribute" AND `cmns`.`Single_Type` = "category_type")

                    ) 

                    ORDER BY `ag`.`Sort` ASC, `ag`.`Createat` ASC';

        else

            $sql = "SELECT `ag`.* FROM (`Attribute_Group` AS ag) 
                    JOIN `Attribute_Group_Category_Type` AS agct ON `agct`.`Attribute_Group_ID` = `ag`.`ID`
                    WHERE 

                    (

                        `agct`.`Category_Type_ID` = {$cat_type} AND 

                        (

                            `ag`.`Member_ID` = {$member_id} OR  

                            `ag`.`Type` = 'system'

                        ) AND 

                        `ag`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$product_id} AND `cmns`.`Type` = 'group')
                        AND `ag`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$cat_type} AND `cmns`.`Type` = 'attribute' AND `cmns`.`Single_Type` = 'category_type')

                    ) 

                    ORDER BY `ag`.`Sort` ASC, `ag`.`Createat` ASC";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_by_member($cat_type, $member_id, $type ="Member") {
        if ($type != "System") {
            $sql = "SELECT `ag`.* , `ct`.`Slug` AS Ct_Slug ,`ct`.`Name` AS Ct_Name FROM `Attribute_Group` AS ag
                
                    JOIN `Attribute_Group_Category_Type` AS agct ON `agct`.`Attribute_Group_ID` = `ag`.`ID`
                    
                    JOIN `Category_Type` AS ct ON `ct`.`ID` = `agct`.`Category_Type_ID` AND `ct`.`ID` = {$cat_type}
                    
                    WHERE 

                    (
                        (
                            (`agct`.`Category_Type_ID` = {$cat_type} AND `ag`.`Type` = 'System') 
                            OR (
                                    (`agct`.`Category_Type_ID` = {$cat_type} AND `ag`.`Type` = 'Member') AND `ag`.`Member_ID` = {$member_id}
                                )
                            )
                        OR
                        (
                            (`agct`.`Category_Type_ID` = (SELECT `cc`.`Parent_ID` FROM Category_Type AS cc WHERE `cc`.`ID` = {$cat_type}) AND `ag`.`Type` = 'System' )
                            OR (`agct`.`Category_Type_ID` = (SELECT `cc`.`Parent_ID` FROM Category_Type AS cc WHERE `cc`.`ID` = {$cat_type}) AND `ag`.`Type` = 'Member' AND `ag`.`Member_ID` = {$member_id})
                        ) 
                        

                    )

                    ORDER BY `ag`.`Sort` ASC, `ag`.`Createat` ASC";

        } else {

            $sql = "SELECT `ag`.* ,`ct`.`ID` AS Category_Type_ID, `ct`.`Slug` AS Ct_Slug ,`ct`.`Name` AS Ct_Name FROM `Attribute_Group` AS ag
                    
                    JOIN `Attribute_Group_Category_Type` AS agct ON `agct`.`Attribute_Group_ID` = `ag`.`ID`
                    
                    JOIN `Category_Type` AS ct ON `ct`.`ID` = `agct`.`Category_Type_ID`
                    
                    WHERE 

                    (
                        ((`agct`.`Category_Type_ID` = {$cat_type}) OR (`agct`.`Category_Type_ID` = (SELECT `cc`.`Parent_ID` FROM Category_Type AS cc WHERE `cc`.`ID` = {$cat_type}))) AND `ag`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$cat_type} AND `cmns`.`Type` = 'group' AND `cmns`.`Single_Type` = 'category_type')
                    )

                    ORDER BY `ag`.`Sort` ASC, `ag`.`Createat` ASC";

        }

        $query = $this->db->query($sql);

        return $query->result_array();

    }

    function get_sort($cat_id,$member_id = 0,$type_member ="Member"){
        $this->db->select("MAX(ag.Sort) AS Sort");
        $this->db->from($this->table. " AS ag");
        $this->db->join("Attribute_Group_Category_Type AS agct","agct.Attribute_Group_ID = ag.ID");
        $this->db->where("agct.Category_Type_ID",$cat_id);
        if($type_member !="System"){
           $this->db->where(array("Member_ID" => $member_id)); 
        }
        $query = $this->db->get();
        return $query->row_array();
    }
    function get_group_by_cat_type($cat_id){
        $this->db->select("ag.*");
        $this->db->from($this->table. " AS ag");
        $this->db->join("Attribute_Group_Category_Type AS agct","agct.Attribute_Group_ID = ag.ID");
        $this->db->where("agct.Category_Type_ID",$cat_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function check_in_cat($name = "" ,$cat_type){
        $this->db->select("ag.ID,ag.Slug");
        $this->db->from($this->table . " AS ag");
        $this->db->join("Attribute_Group_Category_Type AS agct" ,"agct.Attribute_Group_ID = ag.ID" );
        $this->db->where(array("ag.Name" =>$name, "agct.Category_Type_ID" => $cat_type));
        $query = $this->db->get();
        return $query->row_array();
    }
    function get_group_bycat_id($id){
        $sql = "SELECT `ag`.*,`cmns`.`ID` AS Not_Show from {$this->table} AS ag 
                left join Attribute_Group_Category_Type agct on `agct`.`Attribute_Group_ID` = `ag`.`ID`
                Left join Common_Not_Show AS cmns on `cmns`.`Reference_ID` = `ag`.`ID` AND `cmns`.`Type` = 'group' AND `cmns`.`Single_Type` = 'category_type' AND `cmns`.`Reference_Single_ID` = {$id}
                WHERE `agct`.`Category_Type_ID` = {$id} OR `agct`.`Category_Type_ID`  = (Select `cc`.`Parent_ID` From Category_Type AS cc WHERE `cc`.`ID` = {$id} limit 1)  GROUP BY `ag`.`ID`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    

}

