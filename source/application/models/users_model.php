<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends DataMapper {

    var $table = 'Users';
    var $validation = array(
        array(
            'field' => 'ID',
            'label' => 'ID',
        ),
        array(
            'field' => 'User_Nick',
            'label' => 'Nick'
        ),
        array(
            'field' => 'User_Name',
            'label' => 'Name'
        ),
        array(
            'field' => 'User_Email',
            'label' => 'Email'
        ),
        array(
            'field' => 'User_Status',
            'label' => 'Status'
        ),
        array(
            'field' => 'User_Avatar',
            'label' => 'Avatar'
        ),
        array(
            'field' => 'User_Pwd',
            'label' => 'Password'
        ),
        array(
            'field' => 'Createdat',
            'label' => 'Created at'
        ),
        array(
            'field' => 'Updatedat',
            'label' => 'Updated at'
        )
    );

    function Users_model() {
        parent::DataMapper();
    }

    // Validation prepping function to encrypt passwords
	function _encrypt($field)
	{
		// Don't encrypt an empty string
		if (!empty($this->{$field}))
		{
			// Generate a random salt if empty
			if (empty($this->salt))
			{
				$this->salt = md5(uniqid(rand(), true));
			}
			$this->{$field} = sha1($this->salt . $this->{$field});
		}
	}

	function get_last_id_save()
    {  
        return $this->db->insert_id();
    }

    function delete_by_id($id) {
        $this->db->delete($this->table, array('ID' => $id));
    }

}
