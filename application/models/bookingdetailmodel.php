
<?php

    ini_set('memory_limit', '2048M');
    ini_set('max_execution_time', '1500');
	set_time_limit(1500);
	ini_set("display_errors", "on");
	
class Bookingdetailmodel extends CI_Model{
	

	function __construct(){
	parent::__construct();
	}


 
function get_paged_list(){
           
			$query = $this->db->query("SELECT 
							      distinct r1.SiteName as t2SN,
   								   so.SysCode as t2SC
  								FROM
    							contract_header AS ch 
    							INNER JOIN site_operators AS so 
        							ON (ch.SiteName = so.SiteName )
    							 INNER JOIN registration AS r1
       							 ON (so.SiteName = r1.SiteName) 
								
								WHERE 
								r1.Active = 1 and ch.billing_type = 1
								");
		return $query;

}

function filter_contractno($SiteName,$StartDate, $EndDate){
	
 $BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
 $BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	   // $this->db->cache_on();
		$query = $this->db->query("SELECT 
								DISTINCT c1.Seq as c1Se
								
								FROM `contract_header` AS c1 
								INNER JOIN `registration` AS r1 ON c1.SiteName = r1.SiteName 
								
								WHERE 
								(c1.SiteName = "."'".$SiteName."'". ') and r1.Active = 1 and c1.billing_type = 1 '
								
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

function computepersite($SiteName, $StartDate, $EndDate){
	//$this->db->cache_on();
	$query = $this->filter_contractno($SiteName,$StartDate, $EndDate);
   
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




function computepersitenet($SiteName, $StartDate, $EndDate){
	//$this->db->cache_on();
    $query = $this->filter_contractno($SiteName,$StartDate, $EndDate);
    $sc = 0;
		
	if ($query->num_rows() >= 0) {
		foreach ( $query->result() as $row){
				$ec = $this->ComputeNet($row->c1Se,$this->ComputeContractValue($row->c1Se, $StartDate,$EndDate));
				//$ec = $this->ComputeNet($row->c1Se,$this->get_contract_details($row->c1Se, $StartDate,$EndDate));
				
				$sc += $ec;
			
			
			
			
			
			
				}
			
			}
	
		return $sc;

}


function ComputeContractValue($ContractNo,$sd,$ed){
	$currentuser = $this->session->userdata('username');
	//$BMStartDate = $this->get_billingstartdate($currentuser);
	//$BMEndDate = $this->get_billingenddate($currentuser);
	

	//$bStartdate = date('Y/n/d',strtotime($BMStartDate));
	//$bEnddate = date('Y/n/d',strtotime($BMEndDate));
	//$this->db->cache_on();
	
		$query2 = $this->db->query("SELECT 
								Line,
								StartDate, 
								EndDate,
								StartDay,
								EndDay,
								Distribution,
								
								UnitPrice
								
								FROM contract_detail
							 
								WHERE 
						(Contract = "."'".$ContractNo."'".')' 
						
						);
						
	//(Contract = "."'".$ContractNo."'".')' 
	//					
//						);					
						
						
						
	$c = 0.00;
	if ($query2->num_rows() > 0) {
	foreach ( $query2->result() as $row)
			
			{
		    $cv =  $this->GetDistributionAmount($row->Line,$row->StartDate, $row->EndDate, $row->StartDay, $row->EndDay,$row->Distribution, $row->UnitPrice,$sd,$ed);
		    $c += $cv;
			}
		
		return $c;
		}
       
	}
	


function GetDistributionAmount($line,$aStartDate, $aEndDate, $aStartDay, $aEndDay, $Dist , $Price,$bStartDate,$bEndDate){
	 
	  //$NewDate = date('Y-m-d', strtotime($day . " +7 days"));
	  
	 $sday = intval($aStartDay);
	  $eday = intval($aEndDay);
	  
	  $StartDate= strtotime($aStartDate);
	  $EndDate = strtotime($aEndDate);
	  //adjusting start and end dates depending on the start and end days of specific contract detail
	  
	  
	  $bmStartDate= strtotime($bStartDate);
	  $bmEndDate = strtotime($bEndDate);
	     //version 3
	   //adjusting start and end dates depending on the start and end days of specific contract detail
	  //$StartDate= strtotime($aStartDate . "+".$sday." days");
	  //$EndDate = strtotime($aEndDate . "-".(1 * (6 - $eday))." days");
	   if ($sday > 0 and $sday < 6) {
				   
				 $StartDate = strtotime($aStartDate . "+".$sday." days");
	   }
	   
	   if ($eday < 6 and $eday > 0)
					{ 
					 
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
	
	
	
	function count_all(){
			//$this->db->cache_on();
			$this->db->select('t1.SiteName, t1.SysCode, ')
					->from('site_operators as t1')
					->join ('registration as t3','t1.SiteName= t3.SiteName' )
					->join('clients as t2','t1.SiteName = t2.ShortName')
					->where ('t3.Active',1);
						 
	return $this->db->count_all_results();
	
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
	
	function count_sitename_active(){
	
	$query = $this->db->query("SELECT  SiteName 
								from registration
								where Active = 1");
								
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
		
		
   	function update($id,$data){
		$this->db->where('UserName',$id);
		$this->db->update('current_month',$data);
	}

}

?>