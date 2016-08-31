

<?php

class Legacyinvoicingsummodel extends CI_Model{
	
	
	function __construct(){
	parent::__construct();
	}


function get_paged_list($StartDate, $EndDate ){
 //$BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
	$BMStartDate =$StartDate;
	
	//$BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	$BMEndDate = $EndDate;
	
		//$this->db->cache_on();
		$query = $this->db->query("SELECT 
								c1.Seq as c1Se,
								so.SysCode as c1SN, 
								c1.ContractName as c1C,
								c1.StartDate as c1S,
								c1.EndDate as c1E,
								cu.Name as c1CI
								
								FROM `contract_header` AS c1 
								INNER JOIN `registration` AS r1 ON c1.SiteName = r1.SiteName 
								INNER JOIN `site_operators` AS so ON c1.SiteName = so.SiteName 
								INNER JOIN `customers` AS cu ON c1.CIndex = cu.Seq
								WHERE 
								
								
								 r1.Active = 1 and 
								
								
((STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') < "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >="."'".$BMStartDate."'".' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <= "."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d')  <"."'".$BMEndDate."'". ' and' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') <"."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".'))  ' );

		return $query;
	
}



/*
(c1.StartDate >="."'".$BMStartDate. "'". ' && ' ." c1.EndDate  <="."'".$BMEndDate. "'".')'
." || "."
(c1.StartDate < "."'".$BMStartDate. "'". ' && ' ." c1.EndDate  >="."'".$BMStartDate."'".' && ' ." c1.EndDate  <= "."'".$BMEndDate. "'".')'
." || "."
(c1.StartDate >="."'".$BMStartDate. "'". ' && ' ." c1.StartDate  <"."'".$BMEndDate."'". ' && ' ." c1.EndDate  >"."'".$BMEndDate. "'".')'
." || "."
(c1.StartDate <"."'".$BMStartDate. "'". ' && ' ." c1.EndDate  >"."'".$BMEndDate. "'".')



*/


function count_sitename_active(){
	//$this->db->cache_on();
	$query = $this->db->query("SELECT  SiteName 
								from registration
								where Active = 1");
								
	return $this->db->count_all_results();							 
	
	}

function ComputeContractValue1($seq,$sd,$ed) {
	$nsd = strtotime($sd."00:00:00");
	$ned = strtotime($ed."23:59:00");
 	$ts = date("Y-m-d H:i:s",$nsd);
	$te = date("Y-m-d H:i:s",$ned);
				//$this->db->cache_on();
			  $query = $this->db->query("SELECT si.Seq as siS, 
			  									si.Timestamp as siT, 					
												si.Network siN,
												si.RunTime siR,
												si.SpotName siSp,
												(cd.UnitPrice/100) siP,
												si.Status siST, 
												si.ID siI, 
												si.LogID siL,
												si.SiteID as siSI,
												ch.SiteName as chS
			  		
			  							  FROM (`contract_detail` AS cd) 
										 INNER JOIN  `sale_item` AS si ON cd.Line = si.Seq
										 INNER JOIN  `contract_header` AS ch ON cd.Contract = ch.Seq
 			  						
			  				WHERE (si.Timestamp between "."('". $ts."')". ' and ' ."('".$te."'))
							".
				" ORDER BY si.Network, si.Timestamp ASC"
				
				);
						
	$c = 0;
	if ($query->num_rows() > 0) {
		
	foreach ( $query->result() as $row)
			{
		     $c += ($row->siP);
	
		}
       return $c;
	}
	
}

function ComputeContractValue($seq,$sd,$ed) {
	$nsd = strtotime($sd."00:00:00");
	$ned = strtotime($ed."23:59:00");
 	$ts = date("Y-m-d H:i:s",$nsd);
	$te = date("Y-m-d H:i:s",$ned);
	//$this->db->cache_on();
			  $query = $this->db->query("SELECT si.Seq as siS, 
			  									si.Timestamp as siT, 					
												si.Network siN,
												si.RunTime siR,
												si.SpotName siSp,
												(cd.UnitPrice/100) siP,
												si.Status siST, 
												si.ID siI, 
												si.LogID siL,
												si.SiteID as siSI,
												ch.SiteName as chS
			  		
			  							  FROM (`contract_detail` AS cd) 
										 INNER JOIN  `sale_item` AS si ON cd.Line = si.Seq
										 INNER JOIN  `contract_header` AS ch ON cd.Contract = ch.Seq
 			  						
			  				WHERE `cd`.`Contract`=".$seq. " 
							 and (si.Timestamp between "."('". $ts."')". ' and ' ."('".$te."'))
							".
				" ORDER BY si.Network, si.Timestamp ASC"
				
				);
						
	$c = 0;
	if ($query->num_rows() > 0) {
		
	foreach ( $query->result() as $row)
			{
		     $c += ($row->siP);
	
		}
       return $c;
	}
	
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
		$this->db->cache_off();
		$this->db->select('Discount');
		$this->db->where('Seq', $contractno);
			$query = $this->db->get('contract_header');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->Discount;
			return $rolltext;  
	}	
	
function get_contract_agencycomm($contractno){
		$this->db->cache_off();
		$this->db->select('AgencyComm');
		$this->db->where('Seq', $contractno);
			$query = $this->db->get('contract_header');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->AgencyComm;
			return $rolltext;  
	}		
	
function ComputeSpots($ContractNo){
	//$this->db->cache_on();
	$query = $this->db->query("SELECT 
								Line,
								StartDate, 
								EndDate,
								Distribution,
								UnitPrice
								
								FROM contract_detail
							 
								WHERE 
						(Contract = "."'".$ContractNo."'". ')' );
	$c = 0;
	if ($query->num_rows() > 0) {
	
	$cv = 0;
	foreach ( $query->result() as $row)
			{
		       $cv =  $this->count_spots($row->Line,$row->StartDate,$row->EndDate,$row->Distribution, $row->UnitPrice);
		   
		     $c += $cv;
			}
		
	}
       return $c;
	}
	

function count_spots($line,$aStartDate, $aEndDate, $Dist, $price){
	 
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
      
	  //$aDist = str_split($xDist);
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

function count_all( $StartDate, $EndDate){
	//$aStartDate = date('Y-m-d',strtotime('2015-01-01'));
	//$this->db->cache_on();
	$this->db->select('*')  
						->from('contract_header')
						//->where('SiteName',$order_column)
						->where('StartDate >=',$StartDate)
						->where('EndDate <=',$EndDate)
						//->group_by('SiteName')
                        ; 
				                    ;
						 
	return $this->db->count_all_results();
	
	function get_systemcode($order_column){
	//$this->db->cache_on();
	 $query = $this->db->query("SELECT  t4.SysCode AS t4S 
	 							from `site_operators` AS t4 
								inner join `contract_header` AS t2 ON `t4`.`SiteName` =`t2`.`SiteName` 
	 							WHERE `t2`.`Seq`="."'".$order_column."'
	 							"
	 
	 
	 );
	
	 		$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->t4S;
			return $rolltext;       
	}
	
	}




function count_billed_spots($seq,$sd,$ed){
	
	$nsd = strtotime($sd."00:00:00");
	$ned = strtotime($ed."23:59:00");
 	$ts = date("Y-m-d H:i:s",$nsd);
	$te = date("Y-m-d H:i:s",$ned);
	         // $this->db->cache_on();
			  $this->db->select("*")
			  			->FROM('contract_detail') 
						->JOIN('sale_item', 'contract_detail.Line = sale_item.Seq')
						->JOIN('contract_header','contract_detail.Contract = contract_header.Seq')
 			  			->WHERE('contract_detail.Contract',$seq) 
						->WHERE('sale_item.Timestamp >=', $ts)
						->WHERE('sale_item.Timestamp <=', $te);
						
						
						
						
						//->WHERE('sale_item.Timestamp between ',"."('". $ts."')". ' and ' ."('".$te."'));
				

		//return $query;
		return $this->db->count_all_results();
/*

	$this->db->select('distinct(contract_header.SiteName)
						,site_operators.HENumber, site_operators.SysCode
						,CONCAT(site_operators.City,",", site_operators.State) AS loc
						', FALSE)
    					->from('contract_header')
	
	                    ->join('site_operators', 'contract_header.SiteName= site_operators.SiteName')
						
						->where('contract_header.Attributes', 260);
						 
	return $this->db->count_all_results();
	
	}

*/
}

		
	
function get_billingstartdate($currentuser){
		$this->db->cache_off();
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
		$this->db->cache_off();
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