<?php

class pendingtestingmodel extends CI_Model
{

	private $primary_key='SiteID';
	private $primary_key2='SiteName';
	private $table_name='contract_header'; 
	private $table_name2='site_operators';
	
	function __construct(){
	parent::__construct();
	}

	function get_paged_list($limit=10, $offset=0, $order_type='asc', $filter){
		
		
		//$pending = 260;
		
		//if(empty($order_column)||empty($order_type)){		
		//$this->db->order_by($this->primary_key,'asc');
	//}
	//else{
	  
//		$query = $this->db->Distinct('contract_header.SiteName')
		$query = $this->db->select('contract_header.Seq
						,site_operators.SysCode, contract_header.SiteName,
						contract_header.ContractName,contract_header.StartDate,
						contract_header.EndDate')  
						//,CONCAT(site_operators.City,",", site_operators.State) AS loc
						//', FALSE)
                        ->join('site_operators', 'contract_header.SiteName= site_operators.SiteName')
						
					->where('contract_header.Attributes >', '256')
						->like('contract_header.ContractName', $filter, 'after')
						->order_by("contract_header.Seq", "desc")
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
	function get_by_id($id){	
		$this->db->select('Attributes')
		->where('Seq',$id);
							            
	return $this->db->get($this->table_name);
	
	}
	function count_all(){
	//$this->db->distinct('SiteName');
	//$this->db->from('contract_header');
	//$this->db->where('Attributes', 260);
	//return $this->db->count_all_results();
	$query = $this->db->select('contract_header.Seq
						,site_operators.SysCode, contract_header.SiteName,
						contract_header.ContractName,contract_header.StartDate,
						contract_header.EndDate')  
						//,CONCAT(site_operators.City,",", site_operators.State) AS loc
						//', FALSE)
                        ->join('site_operators', 'contract_header.SiteName= site_operators.SiteName')
						
					->where('contract_header.Attributes >', '256')
						//->like('contract_header.ContractName', $filter, 'after')
						->order_by("contract_header.Seq", "desc")
						//->group_by('SiteName')
                        ->get('contract_header'); 
					   
		return $query->num_rows();
						 
	
	
	}
	function save($person){
	$this->db->insert($this->table_name,$person);
	return $this->db->insert_id();
	}

	function update($id,$User){
	$this->db->where('Seq',$id);
	$this->db->update($this->table_name,$User);

	}
	function delete($id){
	
		$this->db->where('Seq',$id);
		$this->db->delete('contract_header');
	
		$this->db->where('Contract',$id);
		$this->db->delete('contract_detail');
	
		$this->db->where('Contract',$id);
		$this->db->delete('contract_copy');
	}

	function count_all_search($searchparams){		
		$this->db->like($searchparams,'','after');		
		$this->db->from($this->table_name);		
		return $this->db->count_all_results();		
	}
}

?>

