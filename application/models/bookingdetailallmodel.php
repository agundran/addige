

<?php

class Bookingdetailallmodel extends CI_Model{
	
	
	function __construct(){
	parent::__construct();
	}



function get_paged_list($SiteName, $StartDate, $EndDate){
		
	$Billtype ='false';			   
				
	$BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
	$BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	  // $this->db->cache_on();
		$query = $this->db->query("SELECT 
								c1.Seq as c1Se,
								c1.SiteName as c1SN, 
								c1.ContractName as c1C,
								c1.StartDate as c1S, 
								c1.EndDate as c1E 
								FROM `contract_header` AS c1 
								WHERE 
								(c1.SiteName = "."'".$SiteName."'". ') and c1.billing_type = 1'
								." and "."
							
((STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate. "'".')'." or "."

(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') < "."'".$BMStartDate. "'". ' and ' ." 
STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >="."'".$BMStartDate."'".' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <= "."'".$BMEndDate. "'".')'." or "."

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


function ComputeContractValue($ContractNo){
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
						(Contract = "."'".$ContractNo."'". ')' );
	$c = 0;
	if ($query->num_rows() > 0) {
	foreach ( $query->result() as $row)
			{
		       $cv =  $this->GetDistributionAmount($row->Line,$row->StartDate,$row->EndDate,$row->StartDay, $row->EndDay, $row->Distribution, $row->UnitPrice);
		   
		     $c += $cv;
			}
		return $c;
	}
       
	}
	


function ComputeSpots($ContractNo){
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
						(Contract = "."'".$ContractNo."'". ')' );
	$c = 0;
	if ($query->num_rows() > 0) {
	
	$cv = 0;
	foreach ( $query->result() as $row)
			{
		       $cv =  $this->count_spots($row->Line,$row->StartDate,$row->EndDate, $row->StartDay, $row->EndDay,$row->Distribution, $row->UnitPrice);
		   
		     $c += $cv;
			}
		
	}
       return $c;
	}
	

		
	

function GetContractDetail($ContractNo){
	//$this->db->cache_on();
	$query = $this->db->query("SELECT 
								cd.Line as cdL,
								cd.StartDate as cdS, 
								cd.EndDate as cdE,
								cd.Distribution as cdD,
								cd.UnitPrice as cdP
								ch.AgencyComm as chAC,
								ch.TotalValue as chTV,
								ch.Discount as chD
								
								
								FROM `contract_detail` AS cd 
								JOIN `contract_header` AS ch ON `cd`.`Contract`=`ch`.`Seq`  
							 
								WHERE 
						(cd.Contract = "."'".$ContractNo."'". ')' );
						
     	return $query;					
						
	}

function GetDistributionAmount($line,$aStartDate, $aEndDate,$aStartDay,$aEndDay, $Dist , $Price){
	 
	 $sday = intval($aStartDay);
	  $eday = intval($aEndDay);
	  
	 $currentuser = $this->session->userdata('username');
	 $bStartDate = $this->get_billingstartdate($currentuser);
	 $bEndDate = $this->get_billingenddate($currentuser);
	 
	 
	  $StartDate= strtotime($aStartDate);
	  $EndDate = strtotime($aEndDate);
	  
	  $bmStartDate= strtotime($bStartDate);
	  $bmEndDate = strtotime($bEndDate);
	  
	  //adjusting start and end dates depending on the start and end days of specific contract detail
	  //$StartDate= strtotime($aStartDate . "+".$sday." days");
	  //$EndDate = strtotime($aEndDate . "-".(1 * (6 - $eday))." days");
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
      
	//  $aDist = str_split($xDist);
      $aDist = explode('-',$Dist);
	  $totalAmount = 0;
	   
	  	   while ($uStartDate  <= $uEndDate){
		   		$ctr = date('w', $uStartDate);
		        $ConvertDayOfWeek = $ConvertDays[$ctr];
				$nPlaysToday = $aDist[$ConvertDayOfWeek];
				 $totalAmount += $nPlaysToday * ($Price/100);  
		   // $totalAmount += (number_format($nPlaysToday,2)) * ($Price/100);  
		   $uStartDate = $uStartDate +(24*3600*1);
		   }
	  return $totalAmount;	  
	
	}

function count_spots($line,$aStartDate, $aEndDate, $aStartDay, $aEndDay, $Dist, $price){
	 
	 $currentuser = $this->session->userdata('username');
	 $bStartDate = $this->get_billingstartdate($currentuser);
	 $bEndDate = $this->get_billingenddate($currentuser);
	 
	  $sday = intval($aStartDay);
	  $eday = intval($aEndDay);
	  
	  $StartDate= strtotime($aStartDate);
	  $EndDate = strtotime($aEndDate);
	  $bmStartDate= strtotime($bStartDate);
	  $bmEndDate = strtotime($bEndDate);
	  
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
	  $totalSched = 0;
	   
	  	   while ($uStartDate<= $uEndDate){
		   		$ctr = date('w', $uStartDate);
		        $ConvertDayOfWeek = $ConvertDays[$ctr];
				$nPlaysToday = $aDist[$ConvertDayOfWeek];
				 $totalSched += $nPlaysToday;  
		   
		   $uStartDate = $uStartDate +(24*3600*1);
		   }
	  return $totalSched;	  
	
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
	
function count_all($SiteName){
	//$aStartDate = date('Y-m-d',strtotime('2015-01-01'));
	
	$this->db->select('*')  
						->from('contract_header')
						->where('SiteName',$SiteName)
						//->where('StartDate >=',$StartDate )
						//->where('EndDate <=',$EndDate)
						//->group_by('SiteName')
                        ; 
				             
						 
	return $this->db->count_all_results();
	
	}


	
function get_contract_discount($contractno){
		//$this->db->cache_on();
		$this->db->select('Discount');
		$this->db->where('Seq', $contractno);
			$query = $this->db->get('contract_header');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->Discount;
			return $rolltext;  
	}	
	
function get_contract_agencycomm($contractno){
		//$this->db->cache_on();
		$this->db->select('AgencyComm');
		$this->db->where('Seq', $contractno);
			$query = $this->db->get('contract_header');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->AgencyComm;
			return $rolltext;  
	}		
	
	
function get_contract_totalvalue($contractno){
		//$this->db->cache_on();
		$this->db->select('TotalValue');
		$this->db->where('Seq', $contractno);
			$query = $this->db->get('contract_header');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->TotalValue;
			return $rolltext;  
	}
		
function get_billingstartdate($currentuser){
		//$this->db->cache_on();
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
		//$this->db->cache_on();
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