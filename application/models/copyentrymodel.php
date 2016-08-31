<?php

class Copyentrymodel extends CI_Model{


	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit,$offset, $order_column, $order_type)
	{
				
			//$query = $this->db->select('*')
                       // ->from ('contract_copy')
                       // ->where('Contract',$order_column)
						// ->get('', $limit, $offset); 
			//	
		$sql = "SELECT * FROM contract_copy  WHERE Contract = '$order_column'";
		
		$query=$this->db->query($sql);	
			
		//$result = $query->result()
		
		
			
		
				
				
				
				
			
     			return $query;
				
				
				
				
	
	 		///
      				
				
			
					
			
		
		
		/////updated
		
		
		
		///
				
			
		
		
		

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
                        ->from ('contract_copy')
                        //->join('site_operators', 'clients.ShortName= site_operators.SiteName')
						 ->Where('Contract',$order_column);
					
						 
	
	return $this->db->count_all_results();
	
	
	}


	function get_by_id($id){	
	
						$this->db->select('Seq')                        
								->where('Seq',$id);
					
	return $this->db->get('contract_copy');
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
			$this->db->where('Seq',$id);
			$this->db->delete('contract_copy');
	
	
	}


	  function count_all_search($searchparams){		
		$this->db->like($searchparams,'','after');		
		$this->db->from($this->table_name);		
		return $this->db->count_all_results();		
	}
 
	
 

	
}

?>

