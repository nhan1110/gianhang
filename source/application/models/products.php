<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Products extends DataMapper {

    var $table = 'Products';
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
            'field' => 'Description',
            'label' => 'Description'
        ),
        array(
            'field' => 'QrCode',
            'label' => 'QrCode'
        ),
        array(
            'field' => 'Content',
            'label' => 'Content'
        ),
        array(
            'field' => 'Featured_Image',
            'label' => 'Featured_Image'
        ),
        array(
            'field' => 'Createdat',
            'label' => 'Createdat'
        ),
        array(
            'field' => 'Updatedat',
            'label' => 'Updatedat'
        ),
        array(
            'field' => 'Member_ID',
            'label' => 'Member ID'
        ),
        array(
            'field' => 'Status',
            'label' => 'Status'
        ),
        array(
            'field' => 'Version',
            'label' => 'Version'
        ),
        array(
            'field' => 'Root_ID',
            'label' => 'Root ID'
        )
    );
    function Products() {
        parent::DataMapper();
    }
    function get_index($member_id = -1, $type_member = "Member", $cat_type = null,$keyword = null, $offset = null, $limit = null) {
        $this->db->select("p.*,m.Path,m.Path_Large,m.Path_Medium,m.Path_Medium,m.Path_Thumb,pp.Is_Main,pp.Price,pp.Special_Price,pp.Special_Start,pp.Special_End,ct.Slug AS Slug_Type");
        $this->db->from($this->table . " AS p");
        $this->db->join("Product_Price AS pp", "pp.Product_ID = p.ID", "LEFT");
        $this->db->join("Media AS m", "m.ID = p.Featured_Image", "LEFT");
        $this->db->join("Category_Type AS ct", "ct.ID = p.Type_ID", "LEFT");
        $filter = [];
        if ($type_member != "System") {
            $filter = array(
                "p.Member_ID" => $member_id
            );
            $this->db->where($filter);
        } 
        if($cat_type != null){
            $this->db->like("ct.Path","/".$cat_type."/");
        }
        if($keyword != null){
            $this->db->like("p.Name",$keyword);
        }
        if($offset != null || $limit != null){
            $this->db->limit($limit,$offset);
        }
        $this->db->group_by('p.ID');
        $this->db->order_by('p.ID',"desc");
        return $this->db->get()->result_array();

    }
    public function get_product_by_user($member_id = -1, $offset = 0, $limit = 20) {
        $filter = array( 
            "p.Member_ID" => $member_id,
            "p.Disable"     => "0"
        );
        $this->db->select("p.*,m.Path,m.Path_Large,m.Path_Medium,m.Path_Medium,m.Path_Thumb,pp.Is_Main,pp.Price,pp.Special_Price,pp.Special_Start,pp.Special_End,ct.Slug AS Ct_Slug");
        $this->db->from($this->table . " AS p");
        $this->db->join("Product_Price AS pp", "pp.Product_ID = p.ID", "LEFT");
        $this->db->join("Media AS m", "m.ID = p.Featured_Image", "LEFT");
        $this->db->join("Category_Type AS ct", "ct.ID = p.Type_ID", "LEFT");
        $this->db->where($filter);
        $this->db->order_by("Createdat","DESC");
        $this->db->group_by("p.id");
        //$this->db->limit($limit,$offset);
        return $this->db->get()->result_array();
    }

    function get_product_details($slug = null){
        $this->db->select("p.*,pp.Is_Main,pp.Price,pp.Special_Price,pp.Special_Start,pp.Special_End,m.Email,m.Phone");
        $this->db->from($this->table . " AS p");
        $this->db->join("Product_Price AS pp", "pp.Product_ID = p.ID", "LEFT");
        $this->db->join("Product_Price AS pp", "pp.Product_ID = p.ID", "LEFT");
        $this->db->join("Member AS m", "m.ID = p.Member_ID", "LEFT");
        $this->db->where("p.Slug",$slug);
        return $this->db->get()->row_array();
    }

    function get_product_details_new($slug = null,$user_id = null){
        $sql = "
        SELECT p.*,t.Num_View,t.Num_Comment,t.Num_Rate,t.Num_Like,t.Num_Share_Facebook,t.Num_Share_Google,m.Path_Thumb,rate.num_rate,tk.Is_Like
        FROM Products AS p
        LEFT JOIN (
            SELECT AVG(Num_Rate) AS num_rate,URL
            FROM Rate
        ) rate ON rate.URL = concat('/product/details/',p.ID)
        LEFT JOIN Tracking_Like AS tk ON tk.URL = concat('/product/details/',p.ID) AND tk.Member_ID = '$user_id'
        LEFT JOIN Tracking AS t ON t.URL = concat('/product/details/',p.ID)
        LEFT JOIN Media AS m ON p.Featured_Image = m.ID
        LEFT JOIN Product_Price AS pr ON pr.Product_ID = p.ID
        WHERE p.Status='Publish' AND p.Slug = '$slug'
        GROUP BY p.ID";
        return $this->db->query($sql)->row_array();
    }
    public function get_product_by_type($path_cat = null,$cat_path = null,$keyword=null,$offset = 0,$limit = null,$user_id = null){
        $this->db->select("p.Name,p.Slug,(SELECT ROUND(sum(rt.Num_Rate)/count(rt.ID),2) FROM `Rate` AS `rt` WHERE rt.URL = CONCAT('/product/details/',`p`.`ID`)) AS Rate_Number,p.ID,p.Description,pp.Price,pp.Is_Main,pp.Special_Price,m.Path,m.Path_Thumb,t.Num_Comment,t.Num_View,t.Num_Rate,t.Num_Like,rate.num_rate,tk.Is_Like",false);
        $this->db->from($this->table." AS p");
        $this->db->join("Product_Price AS pp","pp.Product_ID = p.ID");
        $this->db->join("Media AS m","m.ID = p.Featured_Image");
        $this->db->join("Tracking_Like AS tk","tk.URL = concat('/product/details/',p.ID) AND tk.Member_ID = '".$user_id."'",'left');
        $this->db->join("( SELECT AVG(Num_Rate) AS num_rate,URL FROM Rate ) rate","rate.URL = concat('/product/details/',p.ID)",'left');
        $this->db->join("Tracking AS t","t.URL = concat('/product/details/',p.ID)","LEFT");
        if($keyword != null){
            $this->db->join("Product_Keyword AS pk","pk.Product_ID = p.ID","LEFT");
            $this->db->join("Keywords AS kw","kw.ID = pk.Keyword_ID","LEFT");
            $this->db->where("(kw.Name LIKE '%".$keyword."%' OR p.Name LIKE '%".$keyword."%')", null, false);
        }
        if($cat_path != null){
            $this->db->join("Product_Category AS pc","pc.Product_ID = p.ID");
            $this->db->join("Categories AS cat","cat.ID = pc.Term_ID" );
            $this->db->like("cat.Path", $cat_path);
        }
        if($path_cat != null){
            $this->db->join("Category_Type AS ct","ct.ID = p.Type_ID");
            $this->db->like("ct.Path",$path_cat);
        }
        $this->db->where("p.Disable","0");
        $this->db->order_by("p.Createdat","DESC");
        $this->db->group_by("p.ID");
        if($limit != null){
            $this->db->limit($limit,$offset);
        }
        return $this->db->get()->result_array();
    }
    public function get_total_product($path_cat = null,$cat_path = null,$keyword = null){
        $this->db->select("p.ID");
        $this->db->from($this->table." AS p");
        $this->db->join("Product_Price AS pp","pp.Product_ID = p.ID");
        $this->db->join("Media AS m","m.ID = p.Featured_Image");
        if($keyword != null){
            $this->db->join("Product_Keyword AS pk","pk.Product_ID = p.ID","LEFT");
            $this->db->join("Keywords AS kw","kw.ID = pk.Keyword_ID","LEFT");
            $this->db->where("(kw.Name LIKE '%".$keyword."%' OR p.Name LIKE '%".$keyword."%')", null, false);
        }
        if($cat_path != null){
            $this->db->join("Product_Category AS pc","pc.Product_ID = p.ID");
            $this->db->join("Categories AS cat","cat.ID = pc.Term_ID" );
            $this->db->like("cat.Path", $cat_path);
        }
        if($path_cat != null){
            $this->db->join("Category_Type AS ct","ct.ID = p.Type_ID");
            $this->db->like("ct.Path",$path_cat);
        }
        $this->db->group_by("p.ID");
        $this->db->where("p.Disable","0");
        return $this->db->get()->num_rows();
    }
    public function get_max_min_price($cat_type_path = null,$cat_path = null,$keyword = null,$max = true){
        $this->db->select("pp.Number_Price");
        $this->db->from($this->table." AS p");
        if($keyword != null){
            $this->db->join("Product_Keyword AS pk","pk.Product_ID = p.ID","LEFT");
            $this->db->join("Keywords AS kw","kw.ID = pk.Keyword_ID","LEFT");
            $this->db->where("(kw.Name LIKE '%".$keyword."%' OR p.Name LIKE '%".$keyword."%')", null, false);
        }
        if($cat_type_path != null){
            $this->db->join("Category_Type AS ct","ct.ID = p.Type_ID");
            $this->db->like("ct.Path",$cat_type_path);
        }
        if($cat_path != null){
            $this->db->join("Product_Category AS pcat","pcat.Product_ID = p.ID");
            $this->db->join("Categories AS cat","cat.ID = pcat.Term_ID");
            $this->db->like("cat.Path",$cat_path);
        }
        $this->db->join("Product_Price AS pp","pp.Product_ID = p.ID");
        $this->db->where(["p.Disable" => "0","pp.Is_Main" => "1"]);
        
        if($max == true){
            $this->order_by("pp.Number_Price","DESC");
        }else{
            $this->order_by("pp.Number_Price","ASC");
        }
        $query = $this->db->get()->row_array();
        if(isset($query["Number_Price"]) && $query["Number_Price"] != null){
            return $query["Number_Price"];
        }else{
            return 0;
        }
        
    }

    public function get_product_by_member($type_id = null ,$user_id = null, $p_not_id = null){
        $where = array("p.Type_ID" => $type_id,"p.Disable" => "0");
        if($p_not_id!=null){
            $where = array("p.Type_ID" => $type_id,"p.Disable" => "0",'p.ID !=' => $p_not_id);
        }
        $this->db->select("p.ID,p.Name,p.Slug,p.Description,pp.Price,pp.Is_Main,pp.Special_Price,m.Path,m.Path_Thumb,t.Num_Comment,t.Num_View,t.Num_Rate,tk.Is_Like");
        $this->db->from($this->table." AS p");
        $this->db->join("Product_Price AS pp","pp.Product_ID = p.ID");
        $this->db->join("Media AS m","m.ID = p.Featured_Image");
        $this->db->join("Tracking AS t","t.URL = concat('/product/details/',p.Slug)","LEFT");
        $this->db->join("Tracking_Like AS tk","tk.URL = concat('/product/details/',p.Slug) AND tk.Member_ID = '".$user_id."'","LEFT");
        $this->db->where($where);
        $this->db->order_by("p.Createdat","DESC");
        $this->db->limit(3,0);
        return $this->db->get()->result_array();
    }

    public function get_product_by_keyword($type_id = null,$keyword = array() ,$user_id = null, $p_not_id = null,$offset = 0,$limit = 3){
        $where = array("p.Type_ID" => $type_id,"p.Disable" => "0");
        if($p_not_id!=null){
            $where = array("p.Type_ID" => $type_id,"p.Disable" => "0",'p.ID !=' => $p_not_id);
        }
        $this->db->select("p.ID,p.Name,p.Slug,p.Description,pp.Price,pp.Is_Main,pp.Special_Price,m.Path,m.Path_Thumb,t.Num_Comment,t.Num_View,t.Num_Rate,tk.Is_Like");
        $this->db->from($this->table." AS p");
        $this->db->join("Product_Price AS pp","pp.Product_ID = p.ID");
        $this->db->join("Media AS m","m.ID = p.Featured_Image");
        $this->db->join("Tracking AS t","t.URL = concat('/product/details/',p.Slug)","LEFT");
        $this->db->join("Tracking_Like AS tk","tk.URL = concat('/product/details/',p.Slug) AND tk.Member_ID = '".$user_id."'","LEFT");
        $this->db->join("Product_Keyword AS pk","pk.Product_ID = p.ID");
        $this->db->join("Keywords AS k","k.ID = pk.Keyword_ID","LEFT");
        $this->db->where($where);
        if(isset($keyword[0]) && $keyword[0] != null){
            $this->db->like('k.Name', $keyword[0]);
            foreach ($keyword as $key => $value) {
                if($key != 0){
                    $this->db->or_like('k.Name', $value);
                }
            }
        }
        $this->db->order_by("p.Createdat","DESC");
        $this->db->limit($limit,$offset);
        return $this->db->get()->result_array();
    }
    function get_filter_search($offset = 0,$limit = 20,$keyword = null,$category_type = null,$categories = null,$attribute = null, $min_price = null,$max_price = null,$sorted_by = null ,$country = null,$user_id = null){ 
        $sql_where = "";
        $data_search = 0;
        $having  = "";
        $data_search = 0;
        $categories_id = 0;
        $number_category = ($categories != null) ? " COUNT(cat.ID) AS Number_Category," : "";
        $number_attribute = ($attribute != null) ? " COUNT(a.ID) AS Number_Attribute," : "";
        $data_push = 0;
        $order = "";
        if($attribute != null && $categories !=null){
            $data_push = 1;
        }
        if($attribute != null){
            $attribute_for = explode("','", $attribute);
            $attribute_parent = [];
            foreach ($attribute_for  as $key => $value) {
                $items = explode("/", $value);
                $items = array_diff ($items,array(""));
                if( isset($items[1])  && !in_array($items[1],$attribute_parent)){
                    $attribute_parent [] = $items[1];
                }
            }
            $data_search = count($attribute_parent);
        }
        if($categories != null){
            $categories_for = explode("','", $categories);
            $categories_id = count($categories_for);
        }
        $sql = "SELECT{$number_category}{$number_attribute} (SELECT ROUND(sum(rt.Num_Rate)/count(rt.ID),2) FROM `Rate` AS `rt` WHERE rt.URL = CONCAT('/product/details/',p.ID) ) AS Rate_Number ,p.Path_Adderss, p.Name,p.Slug,p.ID,p.Description,pp.Price,pp.Is_Main,pp.Special_Price,m.Path,m.Path_Thumb,t.Num_Comment,t.Num_View,t.Num_Rate,t.Num_Like,rate.num_rate,tk.Is_Like FROM Products AS p JOIN Product_Price AS pp ON pp.Product_ID = p.ID JOIN  Media AS m ON m.ID = p.Featured_Image LEFT JOIN Tracking_Like AS tk ON tk.URL = concat('/product/details/',p.Slug) AND tk.Member_ID = '{$user_id}' LEFT JOIN (SELECT AVG(Num_Rate) AS num_rate,URL FROM Rate) AS rate ON rate.URL = concat('/product/details/',p.Slug) LEFT JOIN Tracking AS t ON t.URL = concat('/product/details/',p.Slug)";
        if($keyword != null){
            $sql .=" LEFT JOIN Product_Keyword AS pk ON pk.Product_ID = p.ID LEFT JOIN Keywords AS kw ON kw.ID = pk.Keyword_ID";
            $sql_where .= " AND ( kw.Name LIKE '%{$keyword}%' OR p.Name LIKE '%{$keyword}%' )";
        }
        if($category_type != null){
            $sql .=" JOIN Category_Type AS ct ON ct.ID = p.Type_ID ";
            $sql_where .=" AND ct.Path LIKE '%{$category_type}%'";
        }
        if($categories != null){
            $sql .=" JOIN Product_Category AS pct ON pct.Product_ID = p.ID 
            JOIN Categories AS cat ON cat.ID = pct.Term_ID AND cat.Path IN ('$categories')";
            /*if($having == ""){
                $having.= " HAVING ((Number_Category - {$data_search}) + {$data_push}) >= {$categories_id}";
            }else{
                $having.=" AND ((Number_Category - {$data_search}) + {$data_push}) >= {$categories_id}";
            }*/
        }
        if($attribute != null){
            $attribute_parent = "'".implode("','", $attribute_parent)."'";
            $sql .=" JOIN Attribute_Value AS av ON av.Product_ID = p.ID JOIN Attribute AS a ON a.ID = av.Attribute_ID";
            if($attribute_for != null){
                $attribute = implode("|", $attribute_for);
                $sql .=" AND (
                    (av.Value LIKE CONCAT('%{[-]}',(SELECT GROUP_CONCAT(a1.Name SEPARATOR '{[-]}') FROM Attribute AS a1 WHERE (a1.Parent_ID = a.Parent_ID  OR a1.Parent_ID = a.ID )AND a1.Path REGEXP '{$attribute}' ORDER BY a1.Sort ASC), '{[-]}%'))
                    OR 
                    ((SELECT GROUP_CONCAT(a1.Name SEPARATOR '') FROM Attribute AS a1 WHERE (a1.Parent_ID = a.Parent_ID  OR a1.Parent_ID = a.ID )AND a1.Path REGEXP '{$attribute}') is NULL)
                )";
            }
            $sql_where .=" AND a.Slug IN ({$attribute_parent})";
            if($having == ""){
                $having.=" HAVING ((Number_Attribute - {$categories_id})+{$data_push}) >= {$data_search}";
            }else{
                $having.=" AND ((Number_Attribute - {$categories_id})+{$data_push}) >= {$data_search}";
            }    
        }
        if($min_price != null){
            $sql_where .= " AND pp.Number_Price >= {$min_price}";
        }
        if($max_price != null){
            $sql_where .= " AND pp.Number_Price <= {$max_price}";
        }
        if($country != null){
            $sql_where .= " AND p.Path_Adderss LIKE '%{$country}%'";
        }
        if($sorted_by != null){
            $order ="ORDER BY {$sorted_by["column"]} {$sorted_by["order"]}";
        }
        $sql .= " WHERE p.Disable = '0' {$sql_where} GROUP BY p.ID {$having} {$order}";
        $sql .= " LIMIT {$offset},{$limit}";
        //return $sql;
        return $this->db->query($sql)->result_array();
 
    }
    function total_filter_search($keyword = null,$category_type = null,$categories = null,$attribute = null, $min_price = null,$max_price = null,$country = null){
        $sql_where = "";
        $data_search = 0;
        $having  = "";
        $data_search = 0;
        $categories_id = 0;
        $number_category = ($categories != null) ? "COUNT(cat.ID) AS Number_Category," : "";
        $number_attribute = ($attribute != null) ? "COUNT(a.ID) AS Number_Attribute," : "";
        $data_push = 0;
        if($attribute != null && $categories !=null){
            $data_push = 1;
        }
        if($attribute != null){
            $attribute_for = explode("','", $attribute);
            $attribute_parent = [];
            foreach ($attribute_for  as $key => $value) {
                $items = explode("/", $value);
                $items = array_diff ($items,array(""));
                if( isset($items[1])  && !in_array($items[1],$attribute_parent)){
                    $attribute_parent [] = $items[1];
                    unset($attribute_for[$key]);
                }
            }
            $data_search = count($attribute_parent);
        }
        if($categories != null){
            $categories_for = explode("','", $categories);
            $categories_id = count($categories_for);
        }
        $sql = "SELECT {$number_category} {$number_attribute} p.ID FROM Products AS p JOIN Product_Price AS pp ON pp.Product_ID = p.ID JOIN  Media AS m ON m.ID = p.Featured_Image";
        if($keyword != null){
            $sql .=" LEFT JOIN Product_Keyword AS pk ON pk.Product_ID = p.ID LEFT JOIN Keywords AS kw ON kw.ID = pk.Keyword_ID";
            $sql_where .= " AND ( kw.Name LIKE '%{$keyword}%' OR p.Name LIKE '%{$keyword}%' )";
        }
        if($category_type != null){
            $sql .=" JOIN Category_Type AS ct ON ct.ID = p.Type_ID ";
            $sql_where .=" AND ct.Path LIKE '%{$category_type}%'";
        }
        if($categories != null){
            $sql .=" JOIN Product_Category AS pct ON pct.Product_ID = p.ID 
            JOIN Categories AS cat ON cat.ID = pct.Term_ID AND cat.Path IN ('$categories')";
            /*if($having == ""){
                $having.= " HAVING ((Number_Category - {$data_search}) + {$data_push}) >= {$categories_id}";
            }else{
                $having.=" AND ((Number_Category - {$data_search}) + {$data_push}) >= {$categories_id}";
            }*/
        }
        if($attribute != null){
            $attribute_parent = "'".implode("','", $attribute_parent)."'";
            $sql .=" JOIN Attribute_Value AS av ON av.Product_ID = p.ID JOIN Attribute AS a ON a.ID = av.Attribute_ID";
            if($attribute_for != null){
                $attribute = implode("|", $attribute_for);
                $sql .=" AND (
                    (av.Value LIKE CONCAT('%{[-]}',(SELECT GROUP_CONCAT(a1.Name SEPARATOR '{[-]}') FROM Attribute AS a1 WHERE (a1.Parent_ID = a.Parent_ID  OR a1.Parent_ID = a.ID )AND a1.Path REGEXP '{$attribute}' ORDER BY a1.Sort ASC), '{[-]}%'))
                    OR 
                    ((SELECT GROUP_CONCAT(a1.Name SEPARATOR '') FROM Attribute AS a1 WHERE (a1.Parent_ID = a.Parent_ID  OR a1.Parent_ID = a.ID )AND a1.Path REGEXP '{$attribute}') is NULL)
                )";
            }
            $sql_where .=" AND a.Slug IN ({$attribute_parent})";
            if($having == ""){
                $having.=" HAVING ((Number_Attribute - {$categories_id})+{$data_push}) >= {$data_search}";
            }else{
                $having.=" AND ((Number_Attribute - {$categories_id})+{$data_push}) >= {$data_search}";
            }    
        }
        if($country != null){
            $sql_where .= " AND p.Path_Adderss LIKE '%{$country}%'";
        }
        if($min_price != null){
            $sql_where .= " AND pp.Number_Price >= {$min_price}";
        }
        if($max_price != null){
            $sql_where .= " AND pp.Number_Price <= {$max_price}";
        }
        $sql .= " WHERE p.Disable = '0' {$sql_where} GROUP BY p.ID {$having}";
        return $this->db->query($sql)->num_rows();
    }
}

