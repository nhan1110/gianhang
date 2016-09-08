<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends DataMapper {

    var $table = 'Member';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'User',
			'label' => 'Username',
			//'rules' => array('required')
		),
		array(
			'field' => 'Pwd',
			'label' => 'Password',
			//'rules' => array('trim', 'min_length' => 6)
		),
		array(
			'field' => 'Email',
			'label' => 'Email Address',
			//'rules' => array('required')
		),
		array(
			'field' => 'Address',
			'label' => 'Address'
		),
		array(
			'field' => 'Avatar',
			'label' => 'Avatar'
		),
		array(
			'field' => 'Phone',
			'label' => 'Phone'
		),
		array(
			'field' => 'Firstname',
			'label' => 'First name'
		),
		array(
			'field' => 'Lastname',
			'label' => 'Last name'
		),
		array(
			'field' => 'Lat',
			'label' => 'Lat'
		),
		array(
			'field' => 'Lng',
			'label' => 'Lng'
		),
		array(
			'field' => 'Public_URL',
			'label' => 'URL'
		),
		array(
			'field' => 'Status',
			'label' => 'Status'
		),
		array(
			'field' => 'Showname',
			'label' => 'Show name'
		),
		array(
			'field' => 'Registered',
			'label' => 'Registered'
		),
		array(
			'field' => 'Token',
			'label' => 'Token'
		),
		array(
			'field' => 'Createat',
			'label' => 'Createat'
		),
		array(
			'field' => 'Updateat',
			'label' => 'Updateat'
		),
		array(
			'field' => 'Disable',
			'label' => 'Disable'
		)
	);


    function Member()
    {
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

	function get_id_last_save()
    {  
        return $this->db->insert_id();
    }

    function delete_by_id($id)
    {
    	$this->db->delete($this->table, array('ID' => $id));
    }
}