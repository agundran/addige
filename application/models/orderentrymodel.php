<?php

class Orderentrymodel extends CI_Model{

	private $primary_key='SiteName';
	private $primary_key2='SiteName';
	private $table_name='contract_header';  
	private $table_name2='customers';
	private $table_name3='agencies';
	private $table_name4='salesman';
	
	
	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list()
	{  
	 //$this->db->cache_on();
		$query = $this->db->select('*')
                      ->from ('contract_header')
             		->join('agencies', 'contract_header.AIndex= agencies.Seq','inner')
					->join('salesman', 'contract_header.SIndex= salesman.Seq','inner')
					->join('customers', 'contract_header.CIndex= customers.Seq','inner')
					 ->get(); 
		
			return $query;

	}
    
	function count_all_results($order_column){
	$this->db->select('*')
                        ->from ('contract_header')
     					 ->where('Sitename',$order_column);
	return $this->db->count_all_results();
	}

    
	function create_contract($CIndex,$ContractName,$CalendarType,$StartDate, $EndDate,$ClientType, $CustOrder, $EstCode, $Discount, $AIndex, $AgencyComm, $SIndex , $SalesComm, $MinSeparation, $Revision,$SiteName, $Attribute)
	{
		
		        $NewContractData = array(
				   
				    'CIndex'=> $CIndex,
					'ContractName'=>$ContractName,	
					'billing_type'=>$CalendarType,
					'SiteName'=>$SiteName,
					'StartDate'=>$StartDate, 
					'EndDate'=>$EndDate, 
					'client_type'=>$ClientType, 
					'AgencyComm'=>$AgencyComm,
					'Discount'=>$Discount,
					'AIndex'=>$AIndex,
					//'TotalValue'=>$TotalValue,
					'Attributes'=>$Attribute,
					'CustOrder'=>$CustOrder, 
					'EstimateCode' => $EstCode,
					'SIndex'=>$SIndex,
					'SalesComm'=>$SalesComm, 
					'MinSeparation'=>$MinSeparation 
					//'Revision'=>$Revision
					
									
				);
		         
											
				//$insert = 
				$this->db->insert('contract_header',$NewContractData);
				
				return ;
		}
		
	
	function get_site() { 		
	  		$sql = "SELECT so.SiteName, concat(so.SysCode,' -  ' , so.SiteName, ' ->  ', City,',',State) as mysite FROM site_operators as so INNER JOIN registration as re ON (so.SiteName = re.SiteName) WHERE (re.Active =1)
			 ";
			$query=$this->db->query($sql);
			$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->SiteName] = $item->mysite;
      				//$options[$item->SiteName] = $item->SiteName;
      				
					}
      		return $options;	
		}


	function get_by_id($id){	
	
		$this->db->select('*')
			->where('contract_header.Seq',$id)
			->join('customers', 'contract_header.CIndex= customers.Seq','left');
			return $this->db->get($this->table_name);
	}

   

	
	function get_customer() { 		
			//$this->db->cache_on();
			$sql = "SELECT Seq, concat(Name,' :  ' , Seq)as mycust FROM customers order by Name";
			
			$query=$this->db->query($sql);
			$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->Seq] = $item->mycust;
	    				}
      		return $options;	
		}
	
	function get_customer_name() { 		
			$sql = "SELECT Name, concat(Seq,' :  ' , Name)as mycust FROM customers order by Seq";
			//$this->db->cache_on();
			$query=$this->db->query($sql);
			$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->Name] = $item->mycust;
	    				}
      		return $options;	
		}
		
	function get_agency(){
		$sql = "SELECT Seq, concat(Seq,' : ' , Name)as myagency FROM agencies order by Seq";
	  		//$this->db->cache_on();
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
	        // $this->db->cache_on();    
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
	  		//$this->db->cache_on();
			$query=$this->db->query($sql);
			$result = $query->result();
    		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->Seq] = $item->mysalesman;
      				}
      		return $options;	
		}
		
	function get_salesman_name() { 		
			//$this->db->cache_on();
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
			//$this->db->cache_on();
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
		//	$this->db->cache_on();
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
		//	$this->db->cache_on();
			$this->db->select('Rate');
    		$this->db->where('Seq', $Sinput);
    		$query = $this->db->get('salesman');
    		$salesman = array();
			foreach($query->result() as $row) {
        		$salesman[] =$row->Rate;
    		}
    		
			
			return $salesman;
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
 
	
	
	function GetAttributes($ag_check,$pi_check,$pe_check,$pr_check,$fi_check,$co_check,$eo_check,$am_check)
	{
					
		$Attributes= 0;
		
		if($ag_check == 1)	
			$Attributes += 256;
		
		if($pi_check == 1)
			$Attributes += 1;
		if($fi_check == 1)
			$Attributes += 2;
		if($pe_check == 1)
			$Attributes += 4;
		if($eo_check == 1)
			$Attributes += 8;
		if($co_check == 1)
			$Attributes += 16;
		if($am_check == 1)
			$Attributes += 32;
		if($pr_check == 1)
			$Attributes += 64;
		
		
		
		return $Attributes;
		
	
	
	}
 

	
}

?>

