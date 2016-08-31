<?php

class mappingmodel extends CI_Model{

	private $primary_key='SiteName';
	private $primary_key2='SiteID';
	private $table_name='site_operators';
	private $table_name2='clients';
		private $table_name3='network_mapping';
	
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
						->join('registration', 'site_operators.SiteName = registration.SiteName')
						->where('registration.Active',1)
						->like('site_operators.SiteName', $filter, 'after')
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
						//->where($this->primary_key,$id)
						//->where('SiteName',$id)
						//->join('usersinroles', 'users.Username= usersinroles.Username');
						//->join('clients', 'clients.ShortName = network_mapping.SiteName');
                        //->get('', $limit, $offset); 	
//	return $this->db->get($this->table_name3);
	
	->where($this->primary_key,$id);
                       // ->join('usersinroles', 'users.Username= usersinroles.Username');
                        //->get('', $limit, $offset); 	
	return $this->db->get($this->table_name3);
	
	}

	

	
}

?>

