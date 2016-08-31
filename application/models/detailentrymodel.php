<?php

class detailentrymodel extends CI_Model{


	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit, $offset, $order_column, $order_type, $filter , $filter1 )
	{
		if (empty($filter) || $filter=='Seq')
		{		
			$query = $this->db->select('*')
                        ->from ('contract_detail')
                        ->where('Contract',$order_column)
						->order_by('Line','asc')
						 ->get('', $limit, $offset); 
		
			return $query;
		}else if(!empty($filter)){
	  
			if ($filter1 == 'ContractName'){
		
				$query = $this->db->select('*')
                        ->from ('contract_detail')
                        ->like('ContractName', $filter, 'after')
						->order_by('Line','asc')
                        ->get('', $limit, $offset); 
					   
				return $query;}
			
			else if ($filter1 == 'Seq'){
				$query = $this->db->select('*')
                        ->from ('contract_detail')
                        ->like('Seq', $filter, 'after')
						->order_by('Line','asc')
                        ->get('', $limit, $offset); 
					   
				
				return $query;}
			
			else if ($filter1 == 'CustOrder'){
		
				$query = $this->db->select('*')
                        ->like('CustOrder', $filter, 'after')
                        ->from ('contract_detail')
						->order_by('Line','asc')
                        ->get('', $limit, $offset); 
		
				return $query;}	
				
				
		}
		
		
		

	}
	
	function contractdetails($contractno){
		$query1 = $this->db->select('*')
						->from('contract_header')
						->where('Seq',$contractno)

						->get();
		
		return $query1;
		
		}
		
	function count_all_results($order_column){
	$this->db->select('*')
                        ->from ('contract_detail')
                        //->join('site_operators', 'clients.ShortName= site_operators.SiteName')
						 ->Where('Contract',$order_column);
					
						 
	
	return $this->db->count_all_results();
	
	
	}


	function ComputeSchedValue($contractno) {
//	$nsd = strtotime($sd."00:00:00");
	//$ned = strtotime($ed."23:59:00");
 //	$ts = date("Y-m-d H:i:s",$nsd);
	//$te = date("Y-m-d H:i:s",$ned);
	
			  $query = $this->db->query("Select Value from contract_detail WHERE Contract = ".$contractno."");
						
	$c = 0;
	if ($query->num_rows() > 0) {
		
	foreach ( $query->result() as $row)
			{
		     $c += ($row->Value);
	
		}
       return $c;
	}
	
}


	

	function get_by_id($id){	
	
						$this->db->select('Line')                        
								->where('Line',$id);
					
	return $this->db->get('contract_detail');
	}



		function get_customer() { 		
			$this->db->select('Name');
     	    $this->db->order_by('Name', 'ASC');
      		$query=$this->db->get('customers');
      		$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->Name] = $item->Name;
      				}
      		return $options;	
		}
		
	
		
		
		function get_startdate() { 		
			$this->db->select('StartDate');
     	    $this->db->order_by('StartDate', 'ASC');
      		$query=$this->db->get('contract_header');
      		$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->StartDate] = $item->StartDate;
      				}
      		return $options;	
		}
		
			function get_enddate() { 		
			$this->db->select('EndDate');
     	    $this->db->order_by('EndDate', 'ASC');
      		$query=$this->db->get('contract_header');
      		$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->EndDate] = $item->EndDate;
      				}
      		return $options;	
		}
		function get_salesman() { 		
			$this->db->select('Name');
     	    $this->db->order_by('Seq', 'ASC');
      		$query=$this->db->get('salesman');
      		$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->Name] = $item->Name;
      				}
      		return $options;	
		}


		function save($person){
			$this->db->insert($this->table_name,$person);
			return $this->db->insert_id();
		}

		
		function update($id,$data){
			$this->db->where('ShortName',$id);
			$this->db->update($this->table_name,$data);
		}

		function delete($id){
			$this->db->where('Line',$id);
			$this->db->delete('contract_detail');
	
	
	}


	function count_all_search($searchparams){		
		$this->db->like($searchparams,'','after');		
		$this->db->from($this->table_name);		
		return $this->db->count_all_results();		
	}
 
	
 

	
}

?>

