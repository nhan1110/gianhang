<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Keyword_Search extends DataMapper {

    var $table = 'Member_Keyword_Search';

    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'Member_ID',
            'label' => 'Member ID'
        ),
        array(
            'field' => 'Keyword_ID',
            'label' => 'Keyword_ID'
        ),
        array(
            'field' => 'Created_at',
            'label' => 'Created_at'
        )
    );


    function Member_Keyword_Search()
    {
        parent::DataMapper();
    }

    function get_id_last_save()
    {  
        return $this->db->insert_id();
    }

    function delete_by_id($id)
    {
        $this->db->delete($this->table, array('ID' => $id));
    }
}