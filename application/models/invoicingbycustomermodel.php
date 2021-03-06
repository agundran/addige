<?php



   
ini_set('memory_limit', '2048M'); 
ini_set ( 'max_execution_time', 900); 

class Invoicingbycustomermodel extends CI_Model{
	


	function __construct(){
	parent::__construct();
	}


//function get_paged_list($limit=10, $offset=0, $order_column='ContractName', $order_type='asc', $filter, $filter1)
function get_paged_list($limit=10, $offset=0, $order_column='ContractName', $order_type='asc')
{
		
		$filter="";
		$filter1="";
		
		$aStartDate = date('Y-m-d',strtotime('2015-01-01'));
		
	/*if(empty($order_column)||empty($order_type)){		
		$this->db->order_by('ContractName','asc');
		}
	else{
		$query = $this->db->select('Seq, Name')
                        ->where('EBill','False')
						->order_by('Seq', 'asc')
						->like('Name', $filter, 'after')
                        ->get('customers', $limit, $offset); 
					   
		return $query;
		
	
	}*/



if (empty($filter) || $filter=='')
		{		
			$query = $this->db->select('Seq, Name')
                        ->where('EBill','False')
						->order_by('Seq', 'asc')
						->like('Name', $filter, 'after')
                        ->get('customers', $limit, $offset);
		
			return $query;
		}else if(!empty($filter)){
	  
			if ($filter1 == 'Seq'){
		
		
		           $query = $this->db->select('Seq, Name')
                        ->where('EBill','False')
						->order_by('Seq', 'asc')
		
				
                        ->where('Seq', $filter, 'after')
						->get('customers', $limit, $offset); 
					   
				return $query;}
			
			else if ($filter1 == 'Name'){
				 $query = $this->db->select('Seq, Name')
                        ->where('EBill','False')
						->order_by('Name', 'asc')
		
				
                        ->like('Name', $filter, 'after')
						->get('customers', $limit, $offset); 
					   
				
				return $query;}
			
		
		}



}

function count_all(){
	$aStartDate = date('Y-m-d',strtotime('2015-01-01'));
	
	$this->db->select('Seq')
						
    					->from('customers')
	                    ->where('EBill','False');
	                    
						 
	return $this->db->count_all_results();
	
	}
	function filter_contractno($CIndex, $StartDate, $EndDate){
	
 $BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
 $BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	   // $this->db->cache_on();
		$query = $this->db->query("SELECT 
								DISTINCT c1.Seq as c1Se
								
								FROM `contract_header` AS c1 
								WHERE 
								(c1.CIndex = "."'".$CIndex."'". ')'
								
								." and "."
							
((STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate. "'".')'." or "."

(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') < "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >="."'".$BMStartDate."'".' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <= "."'".$BMEndDate. "'".')'." or "."

(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d')  <"."'".$BMEndDate."'". ' and' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')'." or "."

(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') <"."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')) 
' );
	// find the contracts that are in range
	    // 1) Contract started and ended within the month
	    // 2) Contract started before the month and ended in it
	    // 3) Contract started in the month but ended after it
	    // 4) Contract started before and ended after the broadcast month
	return $query;
	
}

   function computepercust($Seq, $StartDate, $EndDate){
	//$this->db->cache_on();
	
	
	$query = $this->filter_contractno($Seq,$StartDate, $EndDate);
   
    $sc = 0.00;
	if ($query->num_rows() >= 0) {
		foreach ( $query->result() as $row){
		
				$ec = $this->ComputeContractValue($row->c1Se, $StartDate,$EndDate);
				//$ec = $this->get_contract_details($row->c1Se, $StartDate,$EndDate);
				
				
			$sc += $ec;
			
			}
		
			}
	
		return $sc;

}


function ComputeContractValue($ContractNo,$sd,$ed){
	$currentuser = $this->session->userdata('username');
	//$BMStartDate = $this->get_billingstartdate($currentuser);
	//$BMEndDate = $this->get_billingenddate($currentuser);
	

	$bStartdate = date('Y/n/d',strtotime($sd));
	$bEnddate = date('Y/n/d',strtotime($ed));
	//$this->db->cache_on();
	
		$query = $this->db->query("SELECT 
								Line,
								StartDate, 
								EndDate,
								Distribution,
								StartDay,
								EndDay,
								UnitPrice
								
								FROM contract_detail
							 
								WHERE 
						(Contract = "."'".$ContractNo."'".')' 
						
						);
						
	//(Contract = "."'".$ContractNo."'".')' 
	//					
//						);					
						
						
						
	$c = 0;
	if ($query->num_rows() > 0) {
	foreach ( $query->result() as $row)
			
			{
		    $cv =  $this->GetDistributionAmount($row->Line,$row->StartDate,$row->EndDate,$row->StartDay, $row->EndDay,$row->Distribution, $row->UnitPrice,$sd,$ed);
		    $c += $cv;
			}
		
		return $c;
		}
       
	}
	
function GetDistributionAmount($line,$aStartDate, $aEndDate, $aStartDay,$aEndDay,$Dist , $Price,$bStartDate,$bEndDate){
	 
	  $sday = intval($aStartDay);
	  $eday = intval($aEndDay);
	  
	  
	  $StartDate= strtotime($aStartDate);
	  $EndDate = strtotime($aEndDate);
	  
	  $bmStartDate= strtotime($bStartDate);
	  $bmEndDate = strtotime($bEndDate);
	    //adjusting start and end dates depending on the start and end days of specific contract detail   
	   if ($sday > 0 and $sday < 6) {
			$StartDate = strtotime($aStartDate . "+".$sday." days");
		   	}
	   if ($eday < 6 and $eday > 0){ 
			$EndDate = strtotime($aEndDate . "-".(1 * (6 - $eday))." days");
			}
	  
	  
	  	if ($StartDate <= $bmStartDate ) {
		$uStartDate = ($bmStartDate);
		} else {
		$uStartDate = ($StartDate);
		}
						 			
		if($EndDate > $bmEndDate){
		$uEndDate =($bmEndDate);}
		else{
		$uEndDate = ($EndDate);
		}
	  
	 
	  $ConvertDays = array(0,1,2,3,4,5,6);
	 // $xDist = str_replace("-", "", $Dist);
      
	  //$aDist = str_split($xDist);
      $aDist = explode('-',$Dist);
	  $totalAmount = 0;
	   
	  	   while ($uStartDate  <= $uEndDate){
		   		$ctr = date('w', $uStartDate);
		        $ConvertDayOfWeek = intval($ConvertDays[$ctr]);
				$nPlaysToday = $aDist[$ConvertDayOfWeek];
				$nPlaysToday = $aDist[$ctr];
				
				// $totalAmount += (number_format($nPlaysToday,2)) * ($Price/100);  
		        $totalAmount += $nPlaysToday * ($Price/100); 
		   $uStartDate = $uStartDate +(24*3600*1);
		   }
	  return $totalAmount;	  
	
	}
	
	
function ComputeNet($contractno, $chTV){
	
	$chAC  = ($this->get_contract_agencycomm($contractno))/1000;
	
	//$chTV = $this->get_contract_totalvalue($contractno);
	
 	$chD = ($this->get_contract_discount($contractno))/1000;
	
	$Discount = $chD;
	$AgencyAmt = $chTV * $chAC;
	$nValue = $chTV - $AgencyAmt;
	$DiscountAmt = $nValue*$Discount;
	$nValue -=$DiscountAmt;
	
	return $nValue;
	}
		
function get_contract_discount($contractno){
		$this->db->select('Discount');
		$this->db->where('Seq', $contractno);
			$query = $this->db->get('contract_header');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->Discount;
			return $rolltext;  
	}	
	
function get_contract_agencycomm($contractno){
		$this->db->select('AgencyComm');
		$this->db->where('Seq', $contractno);
			$query = $this->db->get('contract_header');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->AgencyComm;
			return $rolltext;  
	}	
	
	
	
function get_customername($Seq){
		$this->db->select('Name');
		$this->db->where('Seq',$Seq);
		$query = $this->db->get('customers');
		$result = $query->result();
		$result = $query->row();
		$rolltext = $result->Name;
		return $rolltext; 
		
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