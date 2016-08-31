

<?php

class Invoicingbysitemodel extends CI_Model{
	
	
	function __construct(){
	parent::__construct();
	}


function get_paged_list($limit,$order_column, $offset=0, $order_type='desc', $filter, $StartDate, $EndDate){
		
	$Billtype ='false';			   
				
	
	$BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
	//$BMStartDate = date('Y-m-d',strtotime($StartDate));
	
	$BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	//$BMEndDate = date('Y-m-d',strtotime($EndDate));
	
	if(empty($order_column)||empty($order_type)){		
		$this->db->order_by('Seq','desc');
		}
	else{
		
		$query = $this->db->query("SELECT 
								c1.Seq as c1Se,
								c1.SiteName as c1SN, 
								c1.ContractName as c1C,
								c1.StartDate as c1S, 
								c1.EndDate as c1E
								
								
								FROM `contract_header` AS c1 
								
								INNER JOIN `customers` as c3 ON `c1`.`CIndex` = `c3`.`Seq` 
								
								WHERE 
								(c1.SiteName = "."'".$order_column."'". ')'
								." and "."
								(c3.EBill = "."'".$Billtype. "'". ')'
								." and "."
								
((STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') < "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >="."'".$BMStartDate."'".' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <= "."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d')  <"."'".$BMEndDate."'". ' and' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') <"."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".'))  '
		// find the contracts that are in range
	    // 1) Contract started and ended within the month
	    // 2) Contract started before the month and ended in it
	    // 3) Contract started in the month but ended after it
	    // 4) Contract started before and ended after the broadcast month

 );

		return $query;
	}
}



function ComputeContractValue($ContractNo,$SD,$ED) {
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
	  //$xDist = str_replace("-", "", $Dist);
      
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
	 
	 //$currentuser = $this->session->userdata('username');
	// $bStartDate = $this->get_billingstartdate($currentuser);
	// $bEndDate = $this->get_billingenddate($currentuser);
	 
	 
	  $StartDate= strtotime($aStartDate);
	  $EndDate = strtotime($aEndDate);
	  $bmStartDate= strtotime($aStartDate);
	  $bmEndDate = strtotime($aEndDate);
	  
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
	  //$xDist = str_replace("-", "", $Dist);
      
	  //$aDist = str_split($xDist);
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

function count_all($order_column, $StartDate, $EndDate){
	//$aStartDate = date('Y-m-d',strtotime('2015-01-01'));
	
	$this->db->select('Seq, ContractName,StartDate, EndDate')  
						->from('contract_header')
						->where('SiteName',$order_column)
						->where('StartDate >=',$StartDate)
						->where('EndDate <=',$EndDate)
						//->group_by('SiteName')
                        ; 
				                    ;
						 
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
}

?>