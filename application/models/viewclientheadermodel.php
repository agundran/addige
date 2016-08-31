<?php 

class Viewclientheadermodel extends CI_Model{

	private $primary_key='Seq';
	private $table_name='contract_header';
	
		function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $filter){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by('SiteName','asc');
		//$this->db->join('Rolename', 'users.Username = usersinroles.Username');
	}
	//else{
	  
		$query = $this->db->select('*')
                        ->from('contract_header')
                        ->like('SiteName', $filter, 'after')
						->get('', $limit, $offset); 
					   
		//$this->db->order_by($order_column,$order_type);
		//return $this->db->get($this->table_name, $limit, $offset);
		return $query;
		
	//}
	}

	
		
		
	function count_all(){
	return $this->db->count_all($this->table_name);
	}

	function get_by_id($id){	
	$this->db->select('*')                        
						->where($this->primary_key,$id)
                        ->join('usersinroles', 'users.Username= usersinroles.Username');
                        //->get('', $limit, $offset); 	
	return $this->db->get($this->table_name);
	}

	function save($person){
	$this->db->insert($this->table_name,$person);
	return $this->db->insert_id();
	}

	function update($id,$id2,$person1, $person2){
	$this->db->where($this->primary_key,$id);
	$this->db->update($this->table_name,$person1);
	
	$this->db->where($this->primary_key2,$id2);
	$this->db->update($this->table_name2,$person2);
	
	
	
	}

	function delete($id, $id2){
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
	
	$this->db->where($this->primary_key2,$id2);
	$this->db->delete($this->table_name2);
	
	}


	
	function encryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5(md5( $cryptKey ))));
    return( $qEncoded );
	}


	function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ),MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
	}
	
}

?>

