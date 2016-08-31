<?php

class Mappinglistupdatemodel extends CI_Model{

	//private $primary_key='SiteName';
	private $table_name='network_mapping';
	
	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $filter){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by($this->primary_key,'asc');
		//$this->db->join('Rolename', 'users.Username = usersinroles.Username');
	}
	//else{
	  
		$query = $this->db->select('*')
                        ->from('site_operators')
                        ->join('clients', 'site_operators.SiteName = clients.Shortname')
						->like('site_operators.SiteName', $filter, 'after')
                        ->get('', $limit, $offset); 
					   
		//$this->db->order_by($order_column,$order_type);
		//return $this->db->get($this->table_name, $limit, $offset);
		return $query;
		
	//}
	}

	
	
		
	function get_operator() { 		
			$this->db->select('ShortName');
     	    $this->db->order_by('ShortName', 'ASC');
      		$query=$this->db->get('operators');
      		$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->ShortName] = $item->ShortName;
      				}
      		return $options;	
		}
		
	function count_all(){
	return $this->db->count_all($this->table_name);
	}

	


	function get_by_id($id){	
	$this->db->select('*')                        
	     		->where('SiteName',$id);
             	
	return $this->db->get($this->table_name);
	
	}

    function get_by_site_network($SiteName, $Network){	
	//$where = "SiteName = $SiteName and 'Network' = $Network";
	$this->db->select('*')                        
	     		->where('SiteName',$SiteName)
             	->where('Network',$Network);
             	
	return $this->db->get($this->table_name);
	
	}

	function save($person){
	$this->db->insert($this->table_name,$person);
	return $this->db->insert_id();
	}

	function update($SiteName, $Network,$HENumber,$NetworkNum){
	//$this->db->where('SiteName',$id);
  	//$where = "SiteName = $SiteName and Network = $Network";

		$mydata = array(
			'HENumber'=>$HENumber,
			'NetworkNum'=>$NetworkNum
			
		);


	$this->db->where('SiteName',$SiteName)
             ->where('Network',$Network);
	
	$this->db->update($this->table_name,$mydata);
		
	//$query= $this->db->UPDATE('network_mapping')
		//			 ->SET HENumber = '{$HENumber}', NetworkNum = '{$NetworkNum}'
			//		 ->WHERE SiteName = '{$SiteName}' and Network = '{$Network}';
	
		//	$this->db->where($where);
	
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

