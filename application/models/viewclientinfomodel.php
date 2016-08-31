<?php

class Viewclientinfomodel extends CI_Model{

	private $primary_key='SiteID';
	private $primary_key2='SiteName';
	private $table_name='clients';  
	private $table_name2='site_operators';
	
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
                        ->from ('clients')
                        ->join('site_operators', 'clients.ShortName= site_operators.SiteName')
						->join ('registration','site_operators.SiteName= registration.SiteName' )
                        ->like('clients.ShortName', $filter, 'after')
						->where ('registration.Active',1)
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
		
		
	function username_check($str){
		$this->db->select('Username');
		$this->db->from('users');
		$str1 = $this->db->get();
		
			if($str == $str1)
			{
			$this->form_validation->set_message('Username already exist!');
			return false;
			}
			else
			{
				return true;
				
				
		}
		
	}
		

	
	function count_all(){
	$this->db->select('*')
                        ->from ('clients')
                        ->join('site_operators', 'clients.ShortName= site_operators.SiteName')
						->join ('registration','site_operators.SiteName= registration.SiteName' )
                        
						->where ('registration.Active',1);
	
	return $this->db->count_all_results();
	}



	function get_by_id($id){	
	$this->db->select('*')                        
						//->where($this->primary_key,$id)
						->where('ShortName',$id)
						//->join('usersinroles', 'users.Username= usersinroles.Username');
						->join('site_operators', 'clients.ShortName= site_operators.SiteName');
                        //->get('', $limit, $offset); 	
	return $this->db->get($this->table_name);
	}



	function save($person){
	$this->db->insert($this->table_name,$person);
	return $this->db->insert_id();
	}

	function update($id,$data){
	$this->db->where('ShortName',$id);
	$this->db->update($this->table_name,$data);

	
	
	
	}

	function delete($id, $id2){
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
	
	$this->db->where($this->primary_key2,$id2);
	$this->db->delete($this->table_name2);
	
	}


	function count_all_search($searchparams){		
		$this->db->like($searchparams,'','after');		
		$this->db->from($this->table_name);		
		return $this->db->count_all_results();		
	}
 
	
 

	
}

?>

