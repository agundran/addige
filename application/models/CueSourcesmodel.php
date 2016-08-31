<?php

class CueSourcesmodel extends CI_Model{

	private $primary_key='';
	private $primary_key2='SiteID';
	private $primary_key3='SiteID';
	private $table_name='site_operators';
	private $table_name2='registration';
	private $table_name3='clients';
	
		function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc'){
		if(empty($order_column)||empty($order_type)){		
		$this->db->group_by($this->primary_key,'asc');
		//$this->db->join('Rolename', 'users.Username = usersinroles.Username');
	}
	//else{
		
		    
	  						
			$query = $this->db->select('site_operators.SiteName
						,registration.SSID,  SUBSTRING_INDEX(registration.Networks,"*",-1)as net, 		
						site_operators.SysCode
						,CONCAT(site_operators.City,",", site_operators.State) AS loc
						', FALSE)
				       ->from ('registration')
						->join('site_operators', 'site_operators.SiteName=registration.SiteName')
                        //->join('clients', 'clients.ShortName=site_operators.SiteName', '')					
						->where('(LOCATE("*",registration.Networks))!=',0)
						//-//>where('clients.SSID', 'registration.SSID', 'after')
						
						->get('', $limit, $offset); 
					   
		//$this->db->order_by($order_column,$order_type);
		//return $this->db->get($this->table_name, $limit, $offset);
		return $query;
		
		
	//}
	}


		
	
		
	function count_all_results(){
		
		$this->db->where('(LOCATE("*",registration.Networks))!=',0);
		
		
	return $this->db->count_all_results('registration');
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

