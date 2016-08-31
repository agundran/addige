<?php

class Ebilldetailmonthlymodel extends CI_Model{
	
	
	function __construct(){
	parent::__construct();
	}


function count_all($seq){
	
		$currentuser = $this->session->userdata('username');
	$StartDate = $this->get_billingstartdate($currentuser);
	$EndDate = $this->get_billingenddate($currentuser);
	
	$BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
	//$BMStartDate = date('Y-m-d',strtotime($StartDate));
	
	$BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	//$BMEndDate = date('Y/m/d',strtotime($EndDate));
		
	
	$query = $this->db->query("SELECT 
								c1.Seq as c1Se,
								
								c3.Name AS c3N,
								c1.SiteName as c1SN, 
								c1.ContractName as c1C,
								c1.StartDate as c1S, 
								c1.EndDate as c1E
								
								
								FROM `contract_header` AS c1 
								INNER JOIN `contract_detail` AS c2 ON `c1`.`Seq` = `c2`.`Contract`
								INNER JOIN `customers` as c3 ON `c1`.`CIndex` = `c3`.`Seq` 
								
								
								WHERE 
								(c3.Seq= "."'".$seq."'". ')'
								." and "."

((STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') < "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >="."'".$BMStartDate."'".' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <= "."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d')  <"."'".$BMEndDate."'". ' and' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') <"."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')) '
 );
	                    
						 
	return $this->db->count_all_results();
	
	}
	
	


function get_contract_detail($seq){
	$currentuser = $this->session->userdata('username');
	$StartDate = $this->get_billingstartdate($currentuser);
	$EndDate = $this->get_billingenddate($currentuser);
	
	$BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
	$BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	
	$query = $this->db->query("SELECT 
								c1.Seq as c1Se,
								c3.Name AS c3N,
								c4.SysCode as c4S,
								c1.SiteName as c1SN, 
								c1.ContractName as c1C,
								c1.StartDate as c1S, 
								c1.EndDate as c1E
								
								FROM `contract_header` AS c1 
								
								INNER JOIN `customers` as c3 ON `c1`.`CIndex` = `c3`.`Seq` 
								INNER JOIN `site_operators` as c4 ON `c1`.`SiteName` = `c4`.`SiteName` 
								
								WHERE 
								(c3.Seq= "."'".$seq."'". ')'
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

	function get_customer_name($sw2) { 		
		$this->db->select('Name');
		$this->db->where('Seq', $sw2);
			$query = $this->db->get('customers');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->Name;
		return $rolltext;             
		
	}

	function ComputeContractValue($ContractNo) {
		$query = $this->db->query("SELECT 
								Line,
								StartDate, 
								EndDate,
								Distribution,
								UnitPrice
								FROM contract_detail
							 
								WHERE 
						Contract = "."'".$ContractNo."'
						"); 
						
						 
	$c = 0;
	if ($query->num_rows() > 0) {
		
	foreach ( $query->result() as $row)
			{
		      // $cv =  $this->GetDistributionAmount($row->StartDate,$row->EndDate,$row->Distribution, $row->UnitPrice);
		    $cv =  $this->GetDistributionAmount($row->StartDate,$row->EndDate,$row->Distribution, $row->UnitPrice);
		     $c += $cv;
	
		
		}
       return $c;
	}
	
}
	
	
	function GetDistributionAmount($aStartDate, $aEndDate, $Dist , $Price){
	 
	 $currentuser = $this->session->userdata('username');
	 $bStartDate = $this->get_billingstartdate($currentuser);
	 $bEndDate = $this->get_billingenddate($currentuser);
	 
	 
	  $StartDate= strtotime($aStartDate);
	  $EndDate = strtotime($aEndDate);
	  $bmStartDate= strtotime($bStartDate);
	  $bmEndDate = strtotime($bEndDate);
	  
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
      
	 // $aDist = str_split($xDist);
        $aDist = explode('-',$Dist);
	   $totalAmount = 0;
	   
	  	   while ($uStartDate  <= $uEndDate){
		   		$ctr = date('w', $uStartDate);
		        $ConvertDayOfWeek = $ConvertDays[$ctr];
				$nPlaysToday = $aDist[$ConvertDayOfWeek];
				 $totalAmount += $nPlaysToday * ($Price/100);  
		   
		   $uStartDate = $uStartDate +(24*3600*1);
		   }
	  return $totalAmount;	  
	
	}
	

	function ComputeContractContri($ContractNo,$SD,$ED) {
		$query = $this->db->query("SELECT 
								Line,
								StartDate, 
								EndDate,
								Distribution,
								UnitPrice
								
								FROM contract_detail
							 
								WHERE 
						Contract = "."'".$ContractNo."'
						
						"); 
						
						 
	$c = 0;
	if ($query->num_rows() > 0) {
		
		foreach ( $query->result() as $row)
				{
		      // $cv =  $this->GetDistributionAmount($row->StartDate,$row->EndDate,$row->Distribution, $row->UnitPrice);
		    $cv =  $this->GetDistribution($row->StartDate,$row->EndDate,$row->Distribution, $row->UnitPrice);
		     $c += $cv;
				}
       return $c;
		}
	
	}


	function GetDistribution($aStartDate, $aEndDate, $Dist , $Price){
	 
		 $currentuser = $this->session->userdata('username');
		 $bStartDate = $this->get_billingstartdate($currentuser);
		 $bEndDate = $this->get_billingenddate($currentuser);
	 
		  $StartDate= strtotime($aStartDate);
		  $EndDate = strtotime($aEndDate);
		  $bmStartDate= strtotime($bStartDate);
		  $bmEndDate = strtotime($bEndDate);
	  
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
	//  $xDist = str_replace("-", "", $Dist);
      
	 // $aDist = str_split($xDist);
        $aDist = explode('-',$Dist);
	   $totalAmount = 0;
	   
	  	   while ($uStartDate  <= $uEndDate){
		   		$ctr = date('w', $uStartDate);
		        $ConvertDayOfWeek = $ConvertDays[$ctr];
				$nPlaysToday = $aDist[$ConvertDayOfWeek];
				 $totalAmount += $nPlaysToday ;  
		   
		   $uStartDate = $uStartDate +(24*3600*1);
		   }
	  return $totalAmount;	  
	
	}


	
	function get_billingstartdate($currentuser){
		$this->db->select('monthly_calendar.Start_Date');
        $this->db->join('current_month', 'monthly_calendar.Year= current_month.Year AND  monthly_calendar.Month= current_month.Month','inner');
		$this->db->where('current_month.UserName', $currentuser);
			$query = $this->db->get('monthly_calendar');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->Start_Date;
		return $rolltext;             
	}
   
   
   function get_billingenddate($currentuser){
		$this->db->select('monthly_calendar.End_Date');
        $this->db->join('current_month', 'monthly_calendar.Year= current_month.Year AND  monthly_calendar.Month= current_month.Month','inner');
		$this->db->where('current_month.UserName', $currentuser);
			$query = $this->db->get('monthly_calendar');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->End_Date;
		return $rolltext;             
	}

}

?>