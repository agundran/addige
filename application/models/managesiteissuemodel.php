<?php

class Managesiteissuemodel extends CI_Model{

	private $primary_key='ShortName';
	private $table_name='clients';
	
	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $filter){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by($this->primary_key,'asc');
	}
	else{
	  	$query = $this->db->select('*')
                        ->from('clients')
                        //->join('cases', 'clients.ShortName = cases.SiteName')
						//->like('clients.ShortName', $filter, 'after')
                        ->join('registration', 'clients.ShortName =registration.SiteName')
						->where('registration.Active',1)
						->like('clients.ShortName', $filter, 'after')
						
                        
						->get('', $limit, $offset); 
					   
		//$this->db->order_by($order_column,$order_type);
		//return $this->db->get($this->table_name, $limit, $offset);
		return $query;
		
		}
	}

	function get_paged_open($limit=10, $offset=0, $order_column='', $order_type='asc'){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by($this->primary_key,'asc');
	}
	else{
	  	$query = $this->db->select('*')
                        ->from('cases')
                        //->join('site_operators', 'cases.SiteName= site_operators.ShortName')
						->where('Status', '0')
                        ->get('', $limit, $offset); 
					   
		//$this->db->order_by($order_column,$order_type);
		//return $this->db->get($this->table_name, $limit, $offset);
		return $query;
		
		}
	}

	
	
		function count_all(){
			$this->db->select('*')
                        ->from('clients')
                        //->join('cases', 'clients.ShortName = cases.SiteName')
						//->like('clients.ShortName', $filter, 'after')
                        ->join('registration', 'clients.ShortName =registration.SiteName')
						->where('registration.Active',1);
						
			
	return $this->db->count_all_results();
	
	}
	
	function count_all_open(){
	
			$this->db->from('cases')
			
                        //->join('site_operators', 'cases.SiteName= site_operators.ShortName')
					->where('Status', '0');
	
	return $this->db->count_all_results();
	
	}
	
	

	function get_by_id($id){
	$this->db->where($this->primary_key,$id);
	return $this->db->get($this->table_name);
	}
	
	function get_by_id_edit($id){
	$this->db->where('Seq',$id);
	return $this->db->get('cases');
	}
	

	function save($person){
	$this->db->insert($this->table_name,$person);
	return $this->db->insert_id();
	}

	function update($id,$user){
	$this->db->where('Seq',$id);
	$this->db->update('cases',$user);
	}

	function delete($id){
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
	}

	function status_change($value){
		
		if ($value==1){
			$myvalue = "Close";
			} elseif($value == 0){
			$myvalue= "Open";
		}
	return $myvalue;
	}
	
}

?>

