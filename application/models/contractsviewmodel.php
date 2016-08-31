<?php

class Contractsviewmodel extends CI_Model{

	private $primary_key='SiteName';
	private $primary_key2='SiteName';
	private $primary_key3='Seq';
	
	private $table_name='contract_header';  
	private $table_name2='customers';
	private $table_name3='agencies';
	private $table_name4='salesman';
	
	
	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit, $offset, $order_column, $order_type, $filter , $filter1 )
	{
		
			$currentuser = $this->session->userdata('username');
	$StartDate = $this->get_billingstartdate($currentuser);
	$EndDate = $this->get_billingenddate($currentuser);
	
	//$BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
	$BMStartDate = date('Y-m-d',strtotime($StartDate));
	
	//$BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	$BMEndDate = date('Y-m-d',strtotime($EndDate));
		
		if (empty($filter) || $filter=='')
		{	/*	
			$query = $this->db->select('*')
                        ->from ('contract_header')
                        ->where('Sitename',$order_column)
						//->where('Attributes',$pending = '260')
						 ->get('', $limit, $offset); 
	              
	*/
										//and "." Attributes = 260
	
		$query = $this->db->query("SELECT 
								*
								FROM contract_header as c1
								WHERE `Sitename`='".$order_column."'"
										." 
										
										 and 
								 "." 
((STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') < "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >="."'".$BMStartDate."'".' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <= "."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d')  <"."'".$BMEndDate."'". ' and' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') <"."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".'))');
 

		
			return $query;
		}else if(!empty($filter) || $filter=='' ){
	  
			if ($filter1 == 'ContractName'){
		
				$query = $this->db->select('*')
                        ->from ('contract_header as c1')
                        
				->like('c1.ContractName', $filter, 'after')
						//->where('ContractName', $filter, 'after')
						//// revised
						 ->where('Sitename',$order_column)
						
						
						
						///

                        ->get('', $limit, $offset); 
		
		
		
		
		
					   
				return $query;}
			
			else if ($filter1 == 'Seq'){
				$query = $this->db->select('*')
                        ->from ('contract_header')
                        ->where('Seq', $filter, 'after')
						 ->where('Sitename',$order_column)
                        ->get('', $limit, $offset); 
					   
				
				return $query;}
			
			else if ($filter1 == 'CustOrder'){
		
				$query = $this->db->select('*')
                        ->from ('contract_header')
                        //->where('CustOrder', $filter, 'after')
						->like('CustOrder', $filter, 'after')
						 ->where('Sitename',$order_column)
                         ->get('', $limit, $offset);
		
				return $query;}	
		}

	}
	
	
	
	function get_calendarType($Myseq) { 		
			//$sql = "SELECT Network FROM network_mapping WHERE SiteName LIKE "."'"$mysiteoperator."'";
			
			//SELECT * FROM `network_mapping` WHERE `SiteName` LIKE 'CHA0525110081' 
			$query = $this->db->select('billing_type')
                              ->from ('contract_header')
							  ->where ('Seq',$Myseq)
							  ->get(); 	
			
			//$query=$this->db->query($sql);
			$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->billing_type] = $item->billing_type;
	    				}
      		return $options;	
		}
	
	
	
	
	
		
	function count_all_results($order_column){
	$this->db->select('*')
                        ->from ('contract_header')
                        //->join('site_operators', 'clients.ShortName= site_operators.SiteName')
						 ->where('Sitename',$order_column);
						 //->where('Attributes',256);
						 
	
	return $this->db->count_all_results();
	
	
	}
	
	function count_all_results1($order_column){
	if (empty($filter) || $filter=='')
		{		
			$query = $this->db->select('*')
                        ->from ('contract_header')
                        ->where('Sitename',$order_column);
						//->where('Attributes',$pending = '260')
						// ->get('', $limit, $offset); 
	
	
		
			return $this->db->count_all_results();
		}else if(!empty($filter)){
	  
			if ($filter1 == 'ContractName'){
		
				$query = $this->db->select('*')
                        ->from ('contract_header')
                        ->where('ContractName', $filter, 'after')
						 ->where('Sitename',$order_column);
                       // ->get('', $limit, $offset); 
					   
				return $this->db->count_all_results();
				}
			
			else if ($filter1 == 'Seq'){
				$query = $this->db->select('*')
                        ->from ('contract_header')
                        ->where('Seq', $filter, 'after')
						 ->where('Sitename',$order_column);
                      //  ->get('', $limit, $offset); 
					   
				
				return $this->db->count_all_results();
				}
			
			else if ($filter1 == 'CustOrder'){
		
				$query = $this->db->select('*')
                        ->from ('contract_header')
                        ->where('CustOrder', $filter, 'after')
						 ->where('Sitename',$order_column);
                        // ->get('', $limit, $offset);
		
				return $this->db->count_all_results();
				}	
		}

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
      				//$options[$item->SiteName] = $item->SiteName;
      				
					}
      		return $options;	
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
			//$this->db->cache_on();
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
	       //$this->db->cache_on();
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
			//$this->db->cache_on();
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
			//$this->db->cache_on();
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
			//$this->db->cache_on();
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
	
	function update($id,$myedit)
	{
	$this->db->where($this->primary_key3,$id);
	$this->db->update($this->table_name,$myedit);

	
	
	
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

