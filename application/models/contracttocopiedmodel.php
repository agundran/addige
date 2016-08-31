<?php

class contracttocopiedmodel extends CI_Model{

	private $primary_key='SiteName';
	private $primary_key2='SiteName';
	private $table_name='contract_header';  
	
	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit, $offset, $order_column, $order_type, $filter , $filter1 )
	{
		if (empty($filter) || $filter=='')
		{		
			$query = $this->db->select('*')
                        ->from ('contract_header')
                        ->where('Sitename',$order_column)
						//->where('Attributes',$pending = '260')
						 ->get('', $limit, $offset); 
		
			return $query;
		}else if(!empty($filter)){
	  
			if ($filter1 == 'ContractName'){
		
				$query = $this->db->select('*')
                        ->from ('contract_header')
                        ->where('ContractName', $filter, 'after')
						->where('SiteName', $order_column, 'after')
                        ->get('', $limit, $offset); 
					   
				return $query;}
			
			else if ($filter1 == 'Seq'){
				$query = $this->db->select('*')
                        ->from ('contract_header')
                        ->where('Seq', $filter, 'after')
						->where('SiteName', $order_column, 'after')
                        ->get('', $limit, $offset); 
					   
				
				return $query;}
			
			else if ($filter1 == 'CustOrder'){
		
				$query = $this->db->select('*')
                        ->from ('contract_header')
                        ->where('CustOrder', $filter, 'after')
						->where('SiteName', $order_column, 'after')
                         ->get('', $limit, $offset); 
		
				return $query;
				}	
		}

	}
		
	function count_all_results($order_column){
	$this->db->select('*')
                        ->from ('contract_header')
                        //->join('site_operators', 'clients.ShortName= site_operators.SiteName')
						 ->where('Sitename',$order_column);
						 //->where('Attributes',260);
						 
	
		return $this->db->count_all_results();
	}


	function get_by_id($id){	
		$this->db->select('*')
				->where('Seq',$id);
		//->join('customers', 'contract_header.CIndex= customers.Seq','left');
		return $this->db->get($this->table_name);
	
		}

	
	
	
 function create_contract($CIndex,$ContractName,$StartDate, $EndDate, $CustOrder, $Discount, $AIndex, $AgencyComm, $SIndex , $SalesComm, $MinSeparation, $Revision,$SiteName, $Attribute)
	{
		
		        $NewContractData = array(
				   
				    'CIndex'=> $CIndex,
					'ContractName'=>$ContractName,
					'SiteName'=>$SiteName,
					'StartDate'=>$StartDate, 
					'EndDate'=>$EndDate, 
					'AgencyComm'=>$AgencyComm,
					'Discount'=>$Discount,
					'AIndex'=>$AIndex,
					//'TotalValue'=>$TotalValue,
					'Attributes'=>$Attribute,
					'CustOrder'=>$CustOrder, 
					'SIndex'=>$SIndex,
				 
					'SalesComm'=>$SalesComm, 
					'MinSeparation'=>$MinSeparation, 
					'Revision'=>$Revision
					
									
				);
		         
											
				//$insert = 
				$this->db->insert('contract_header',$NewContractData);
				
				return ;
		}
		
	
	function get_site() { 		
	  		$sql = "SELECT SiteName, concat(SysCode,' -  ' , SiteName, ' ->  ', City,',',State)as mysite FROM site_operators order by SysCode asc";
			$query=$this->db->query($sql);
			$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->SiteName] = $item->mysite;
					}
      		return $options;	
	}

	
	function get_customer_name($ci) { 		
			$query = $this->db->select('Name')
						->from('customers')
						->where('Seq',$ci)
						->get();
		return $query;
	}
	
		
	function get_agency(){
		$sql = "SELECT Seq, concat(Seq,' : ' , Name)as myagency FROM agencies order by Seq";
	  		$query=$this->db->query($sql);
			$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
    				$options[$item->Seq] = $item->myagency;
      				}
      		return $options;
		}	
	
	function get_startdate() { 	
			$currentyear = date("Y");
			$currentmonth= date("m");
			//$myDateTime = DateTime::createFromFormat('Y-m-d', $today);
			//$Stoday = $myDateTime->format('Y-m-d');
			
			$this->db->select('Start_Date');
    		$where = "Year >= $currentyear and Month >= $currentmonth or Year > $currentyear order by Year, Month ASC";
			$this->db->where($where);
			//$this->db->like('Start_Date','$Stoday', 'after');
    		$query=$this->db->get('broadcast_calendar');
      		$result = $query->result();
     		$drop_menu_operator_name = array();
			foreach($result as $item){
        			$options[$item->Start_Date] = $item->Start_Date;
      				}
      		return $options;	
		}
		
	function get_enddate() { 		
	        $currentyear = date("Y");
			$currentmonth= date("m");
	
			$this->db->select('End_Date');
			$where = "Year >= $currentyear and Month >= $currentmonth or Year > $currentyear order by Year, Month ASC";
			$this->db->where($where);
     	    $query=$this->db->get('broadcast_calendar');
      		$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->End_Date] = $item->End_Date;
      				}
      		return $options;	
		}
		
	function get_salesman() { 		
			$sql = "SELECT Seq, concat(Seq,' :  ' , Name)as mysalesman FROM salesman order by Seq";
	  		$query=$this->db->query($sql);
			$result = $query->result();
    		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->Seq] = $item->mysalesman;
      				}
      		return $options;	
		}
		
	function get_salesman_name() { 		
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

	function get_customer_discount($Cinput){
			
			$this->db->select('Discount');
    		$this->db->where('Seq', $Cinput);
    		$query = $this->db->get('customers');
    		$customers = array();
			foreach($query->result() as $row) {
        		$customers[] =$row->Discount;
    		}
    		
			
			return $customers;
		}
			
	
	function get_agency_rate($Ainput){
			
			$this->db->select('Rate');
    		$this->db->where('Seq', $Ainput);
    		$query = $this->db->get('agencies');
    		$agencies = array();
			foreach($query->result() as $row) {
        		$agencies[] =$row->Rate;
    		}
    		return $agencies;
	}
		

	function get_salesman_rate($Sinput){
			$this->db->select('Rate');
    		$this->db->where('Seq', $Sinput);
    		$query = $this->db->get('salesman');
    		$salesman = array();
			foreach($query->result() as $row) {
        		$salesman[] =$row->Rate;
    		}
    		
			return $salesman;
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

