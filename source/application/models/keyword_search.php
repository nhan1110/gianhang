<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Keyword_Search extends DataMapper {
    var $table = 'Keyword_Search';
    var $table = 'Keyword_Search_Tracking';

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
            'field' => 'Created_at',
            'label' => 'Created_at'
        ),
        array(
            'field' => 'Type_ID',
            'label' => 'Type_ID'
        ),
        array(
            'field' => 'Publish',
            'label' => 'Publish'
        )
    );

    function Keyword_Search() {
        parent::DataMapper();
    }

    function get_trend($keyword="", $type_id="", $type_order="DESC", $start_date="", $end_date="") {
        $sql = "SELECT A.* FROM Keyword_Search as A INNER JOIN Keyword_Search_Tracking as B
                    ON A.ID = B.Keyword_Search_ID WHERE 1=1 ";
        $where = "";
        if (!empty($type_id)) {
            $where .= " AND (A.`Type_ID` = '{$type_id}') ";
        }
        if (!empty($keyword)) {
            $where .= " AND (A.`Name` LIKE '%{$keyword}%') ";
        }
        if (!empty($start_date)) {
            $where .= " AND (B.`Created_at` >= '') ";
        }
        $query = $this->db->query($sql);

        return $query->result_array();
    }

}

