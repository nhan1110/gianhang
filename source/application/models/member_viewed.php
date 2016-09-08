<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Viewed extends DataMapper {

    var $table = 'Member_Viewed';

    var $validation = array(
    	array(
			'field' => 'ID',
			'label' => 'ID',
		),
		array(
			'field' => 'Member_ID',
			'label' => 'Member ID',
		),
		array(
			'field' => 'URL',
			'label' => 'URL'
		),
		array(
			'field' => 'Session_ID',
			'label' => 'Session ID'
		),
		array(
			'field' => 'Date_Created',
			'label' => 'Date Created'
		)
	);


    function Member_Viewed()
    {
        parent::DataMapper();
    }
    
    function get_id_last_save(){  
        return $this->db->insert_id();
    }

    function delete_by_id($id){
    	$this->db->delete($this->table, array('ID' => $id));
    }

    function add_viewed($member_id = null ,$url = null,$session_id = null){
    	$this->Member_ID = $member_id;
    	$this->URL = $url;
    	$this->Session_ID = $session_id;
    	$this->Date_Created = date('Y-m-d H:i:s');
    	$this->save();
    }
}