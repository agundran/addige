<?php

class clearflagmodel extends CI_Model{

	private $primary_key='Seq';
	private $primary_key2='SiteName';
	private $table_name='contract_header';  
	private $table_name2='site_operators';
	
	function __construct(){
	parent::__construct();
	}
	function update($id)
	{
		$clearpending =  "256";	
		$data = array(
         	   'Attributes'=>$clearpending
          		);
		$this->db->where('Seq',$Users);
		$this->db->update($this->table_name,$data);
	}
	
	function delete($id)
	{
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
	}
	
}

?>

