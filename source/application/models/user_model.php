<?php
class User_model extends CI_Model
{
  function __contruct()
  {
  }
  //public $table='Admin';
  public function user_login($email, $password)
  {
    $this->db->select('*');
    $this->db->from('Admin');
    $this->db->where(
      array('Email' => $email,
            'Password' => $password
        )
      );
    $query=$this->db->get();
    return $query->result_array();
  }
}

