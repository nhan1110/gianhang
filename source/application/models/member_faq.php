<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_FAQ extends DataMapper {

    var $table = 'Member_FAQ';

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
            'field' => 'Title',
            'label' => 'Title'
        ),
        array(
            'field' => 'Question',
            'label' => 'Question'
        ),
        array(
            'field' => 'Member_ID_Question',
            'label' => 'Member ID Question'
        ),
        array(
            'field' => 'Created_at',
            'label' => 'Created_at'
        ),
        array(
            'field' => 'Answer',
            'label' => 'Answer'
        ),
        array(
            'field' => 'Replied_at',
            'label' => 'Replied_at'
        ),
        array(
            'field' => 'Category_ID',
            'label' => 'Category ID'
        )
    );


    function Member_FAQ()
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