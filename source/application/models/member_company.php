<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Company extends DataMapper {

    var $table = 'Member_Company';

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
            'field' => 'Company_Title',
            'label' => 'Company Title'
        ),
        array(
            'field' => 'Company_Info',
            'label' => 'Company Info'
        ),
        array(
            'field' => 'Company_Logo',
            'label' => 'Company Logo'
        ),
        array(
            'field' => 'Company_Banner',
            'label' => 'Company Banner'
        ),
        array(
            'field' => 'Company_Avatar',
            'label' => 'Company Avatar'
        ),
        array(
            'field' => 'Company_Address',
            'label' => 'Company Address'
        ),
        array(
            'field' => 'Company_Email',
            'label' => 'Company Email'
        ),
        array(
            'field' => 'Company_Phone',
            'label' => 'Company Phone'
        ),
        array(
            'field' => 'Company_Website',
            'label' => 'Company Website'
        ),
        array(
            'field' => 'Body_Background_Color',
            'label' => 'Body Background Color'
        ),
        array(
            'field' => 'Body_Background_Image',
            'label' => 'Body Background Image'
        ),
    );


    function Member_Company()
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