<?php

class selectsitemodel extends CI_Model{

	private $primary_key='SiteID';
	private $primary_key2='SiteName';
	private $table_name='clients';  
	private $table_name2='site_operators';
	
		function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='SysCode', $order_type='asc', $filter){
		
		
		$pending = 256;
		
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by($this->primary_key,'asc');
	}
	//else{
	  
//		$query = $this->db->Distinct('contract_header.SiteName')
		$query = $this->db->select('distinct(contract_header.SiteName)
						,site_operators.HENumber, site_operators.SysCode
						
						,site_operators.City,site_operators.State')
						
                        
						//,CONCAT(site_operators.City,",", site_operators.State) AS loc
						//', FALSE)
                        
						->join('site_operators', 'contract_header.SiteName= site_operators.SiteName')
						->join ('registration','contract_header.SiteName= registration.SiteName' )
						->where('contract_header.Attributes', $pending )
						->where ('registration.Active',1)
						->like('site_operators.SysCode', $filter, 'after')
						//->group_by('SiteName')
                        ->get('contract_header', $limit, $offset); 
					   
		return $query;
		
	
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
		
	
	function count_all($order_column){
	//$this->db->distinct('SiteName');
	//$this->db->from('contract_header');
	//$this->db->where('Attributes', 260);
	//return $this->db->count_all_results();
	
	$this->db->select('distinct(contract_header.SiteName)
						,site_operators.HENumber, site_operators.SysCode
						,site_operators.City,site_operators.State')
						//,CONCAT(site_operators.City,",", site_operators.State) AS loc
						//', FALSE)
    					->from('contract_header')
	
	                    ->join('site_operators', 'contract_header.SiteName= site_operators.SiteName')
						->join ('registration','contract_header.SiteName= registration.SiteName' )
						->where ('registration.Active',1)
						->where('contract_header.Attributes', 260);
						 
	return $this->db->count_all_results();
	
	}
	
	
	




	function get_by_id($order_column){	
		
	$query = $this->db->select('*')
                        ->from ('contract_header')
                        //->join('site_operators', 'clients.ShortName= site_operators.SiteName')
						 ->where('Sitename',$order_column)
						 //->like('SiteName', $filter, 'after')
                        ->get('', $limit, $offset); 
						
	return $query;
	
	
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
 
	function get_billingstartdate($currentuser){
		$this->db->select('broadcast_calendar.Start_Date');
        $this->db->join('current_month', 'broadcast_calendar.Year= current_month.Year AND  broadcast_calendar.Month= current_month.Month','inner');
		$this->db->where('current_month.UserName', $currentuser);
			$query = $this->db->get('broadcast_calendar');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->Start_Date;
			return $rolltext;             
		
		}
   
   
   function get_billingenddate($currentuser){
		$this->db->select('broadcast_calendar.End_Date');
        $this->db->join('current_month', 'broadcast_calendar.Year= current_month.Year AND  broadcast_calendar.Month= current_month.Month','inner');
		$this->db->where('current_month.UserName', $currentuser);
			$query = $this->db->get('broadcast_calendar');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->End_Date;
			return $rolltext;             
		
		}
 

	
}

?>

