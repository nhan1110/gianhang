<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Attribute_Group_Attribute extends DataMapper {
    var $table = 'Attribute_Group_Attribute';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Attribute_ID',
            'label' => 'Attribute_ID'
        ),
        array(
            'field' => 'Group_ID',
            'label' => 'Group_ID'
        )
    );

    function Attribute_Group_Attribute() {
        parent::DataMapper();
    }



    public function get_attribute_group($member_id, $category_type, $type_member = "Member",$product_id = -1) {

        if ($type_member == "System")

            $sql = "SELECT `aga`.*,`a`.* FROM (`Attribute_Group` AS ag)

                    JOIN `Attribute_Group_Attribute` AS aga ON `aga`.`Group_ID` = `ag`.`ID`

                    JOIN `Attribute` AS a ON `a`.`ID` = `aga`.`Attribute_ID`

                    WHERE 
                    ( 
                        (
                            (`a`.`Category_Type_ID` = {$category_type})OR 
                            (`a`.`Category_Type_ID` = (SELECT `cc`.`Parent_ID` FROM Category_Type AS cc WHERE `cc`.`ID` = {$category_type}))
                        ) AND 

                        `a`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$product_id} AND `cmns`.`Type` = 'attribute')

                        AND `a`.`Parent_ID` = 0 AND `a`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$category_type} AND `cmns`.`Type` = 'attribute' AND `cmns`.`Single_Type` = 'category_type')
                    )

                    GROUP BY `a`.`ID`  ORDER BY `aga`.`Sort` ASC";

        else

            $sql ="SELECT `aga`.*,`a`.* FROM (`Attribute_Group` AS ag)

            JOIN `Attribute_Group_Attribute` AS aga ON `aga`.`Group_ID` = `ag`.`ID`

            JOIN `Attribute` AS a ON `a`.`ID` = `aga`.`Attribute_ID`

            WHERE 
            ( 
                (
                    ((`a`.`Category_Type_ID` = {$category_type} AND `ag`.`Member_ID` = {$member_id} AND `ag`.`Type` ='Member') OR 
                    (`a`.`Category_Type_ID` = {$category_type} AND `ag`.`Type` = 'System') )OR 
                    (`a`.`Category_Type_ID` = (SELECT `cc`.`Parent_ID` FROM Category_Type AS cc WHERE `cc`.`ID` = {$category_type}))
                ) AND 

                `a`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$product_id} AND `cmns`.`Type` = 'attribute')

                AND `a`.`Parent_ID` = 0 AND `a`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$category_type} AND `cmns`.`Type` = 'attribute' AND `cmns`.`Single_Type` = 'category_type')
            )

            GROUP BY `a`.`ID`  ORDER BY `aga`.`Sort` ASC";
        $query = $this->db->query($sql);

        return $query->result_array();

    }



    function get_attr_group_attr($member_id, $category_type, $type = "Member") {

        $sql = "SELECT `a`.*,`aga`.`Attribute_ID`,`aga`.`Group_ID`,`aga`.`ID` AS AGA_ID FROM `Attribute_Group` AS ag

                JOIN `Attribute_Group_Category_Type` AS agct ON `agct`.`Attribute_Group_ID` = `ag`.`ID`

                JOIN `Attribute_Group_Attribute` AS aga ON `aga`.`Group_ID` = `ag`.`ID`

                JOIN `Attribute` AS a ON `a`.`ID` = `aga`.`Attribute_ID`";

        if ($type == "System") {

            $sql.= "WHERE (`a`.`Category_Type_ID` = {$category_type} ) AND `a`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$category_type} AND `cmns`.`Type` = 'attribute' AND `cmns`.`Single_Type` = 'category_type') GROUP BY `a`.`ID` ORDER BY `aga`.`Sort` ASC ";

        } else {

            $sql.= "WHERE (`a`.`Member_ID` = {$member_id} AND `a`.`Type` = 'Member' ) AND (`a`.`Category_Type_ID` = {$category_type} ) AND `a`.`ID` NOT IN (SELECT `cmns`.`Reference_ID` FROM Common_Not_Show AS cmns WHERE `cmns`.`Reference_Single_ID` = {$category_type} AND `cmns`.`Type` = 'attribute' AND `cmns`.`Single_Type` = 'category_type') GROUP BY `a`.`ID` ORDER BY `aga`.`Sort` ASC ,`a`.`Createat` ASC";

        }

        $query = $this->db->query($sql);

        return $query->result_array();

    }

    public function get_attr_by_attr_group($id,$cat_id){
        $sql = "SELECT `a`.*, `cmns`.`ID` AS Not_Show FROM Attribute AS a 
        JOIN Attribute_Group_Attribute AS aga ON aga.Attribute_ID = a.ID
        JOIN Attribute_Group_Category_Type AS agct ON agct.Attribute_Group_ID = aga.Group_ID
        LEFT JOIN Common_Not_Show AS cmns ON cmns.Reference_ID = a.ID AND cmns.Type = 'attribute' AND cmns.Reference_Single_ID = {$cat_id} AND cmns.Single_Type = 'category_type'
        WHERE (
            (a.ID IN (SELECT ca.ID FROM Attribute AS ca WHERE ca.Category_Type_ID = {$cat_id}) ) 
            OR 
            (
                agct.Category_Type_ID = (SELECT cc.Parent_ID FROM Category_Type AS cc WHERE cc.ID = {$cat_id} Limit 1) 
                AND a.Category_Type_ID = (SELECT cc1.Parent_ID FROM Category_Type  AS cc1 WHERE cc1.ID = {$cat_id} Limit 1)
            ) 
        )  
        AND aga.Group_ID = {$id}";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}

