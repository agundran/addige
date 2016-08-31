<?php

class Membership_model extends CI_Model 

{

	public function __construct()
	{
		parent::__construct();
	}
	
	
	function getRoles()
	{
		$this->db->select('Rolename');
		$this->db->from('usersinroles');
		$this->db->where('username', $this->input->post('username'));
		return $this->db->get();
	}
	function LastLogin()
	{	
		$creationdate =  date("Y-m-d H:i:s");
		$this->load->database();
		$data = array(
            'LastLoginDate'=>$creationdate
          );
		$this->db->where('Username',$this->input->post('username'));
  		$this->db->update('users',$data); 
		
	}
	public function login($role, $username, $password)
	{
		$this->db->select('users.Username, users.Password, usersinroles.Rolename');    
		$this->db->from('users');
		$this->db->join('usersinroles', 'users.Username = usersinroles.Username');
		$this->db->where('users.Username', $username);
		$this->db->where('users.Password', $password);
		$this->db->where('usersinroles.Rolename', $role); 
		
		$query = $this->db->get();
		return $query->result();
	}
	
}