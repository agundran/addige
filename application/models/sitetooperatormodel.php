<?php

class Sitetooperatormodel extends CI_Model{

	private $primary_key='SiteName';
	private $table_name='site_operators';
	
	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit, $offset=0, $order_column='', $order_type='asc', $filter){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by($this->primary_key,'asc');
		}
	//else{	  
		$query = $this->db->select('*')
                        ->from($this->table_name)
						//->join ('registration','site_operators.SiteName= registration.SiteName' )
						->like('site_operators.SiteName', $filter, 'after')
						//->where ('registration.Active',1)
                        ->get('', $limit, $offset); 
					   
		return $query;
		
	//}
	  	 
	}
	
	
	function create_siteoperator($Operator){			
				$this->db->insert('site_operators',$Operator );
				
				return ;
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
	$this->db->select('*')
                        ->from($this->table_name);
						//->join ('registration','site_operators.SiteName= registration.SiteName' );
						
						//->where ('registration.Active',1);
                        
	
	return $this->db->count_all_results();
	
	
	
	}

	function get_by_id($id){	
	$this->db->select('*')                        
			->where($this->primary_key,$id);
                        	
	return $this->db->get($this->table_name);
	}

	function save($data){
	$this->db->insert($this->table_name,$data);
	return $this->db->insert_id();
	}

	function update($id,$data){
	$this->db->where($this->primary_key,$id);
	$this->db->update($this->table_name,$data);
	
	}

	function delete($id){
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
	
	
	}


	
}


?>

