<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_News_Member_Category extends DataMapper {

    var $table = 'Member_News_Member_Category';

    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'News_ID',
            'label' => 'News ID'
        ),
        array(
            'field' => 'Category_ID',
            'label' => 'Category_ID'
        )
    );


    function Member_News_Member_Category()
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

    function delete_by_post_id($post_id)
    {
        $this->db->delete($this->table, array('News_ID' => $post_id));
    }
}