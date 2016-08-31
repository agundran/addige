

<?php

ini_set('memory_limit', 512000000);
    ini_set('max_execution_time', -1);
class Legacyinvoicingcnmodel extends CI_Model{
	

 
	function __construct(){
	parent::__construct();
	$this->load->dbutil();
	}


function get_paged_list_bysite($cn, $StartDate, $EndDate ){
 //$BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
	$BMStartDate =$StartDate;
	
	//$BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	$BMEndDate = $EndDate;
	
		
		
		 

		$query = $this->db->query("SELECT 
								DISTINCT(c1.Seq) as c1Se,
								so.SysCode as c1SN, 
								c1.ContractName as c1C,
								cu.Name as c1CI,
								c1.StartDate as c1S, 
								c1.EndDate as c1E,
								cu.Seq as cuS
								
								
								FROM `contract_header` AS c1 
								INNER JOIN `registration` AS r1 ON c1.SiteName = r1.SiteName 
								INNER JOIN `site_operators` AS so ON c1.SiteName = so.SiteName 
								INNER JOIN `customers` AS cu ON c1.CIndex = cu.Seq
								
								WHERE 
								c1.Seq = ".$cn."  
								
								and r1.Active = 1 and 
								
								
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

function get_paged_list($cn, $StartDate, $EndDate ){
 //$BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
	$BMStartDate =$StartDate;
	
	//$BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	$BMEndDate = $EndDate;
	
		
		$query = $this->db->query("SELECT 
								c1.Seq as c1Se,
								so.SysCode as c1SN, 
								c1.ContractName as c1C,
								cu.Name as c1CI,
								c1.StartDate as c1S, 
								c1.EndDate as c1E,
								cu.Seq as cuS
								
								
								FROM `contract_header` AS c1 
								INNER JOIN `registration` AS r1 ON c1.SiteName = r1.SiteName 
								INNER JOIN `site_operators` AS so ON c1.SiteName = so.SiteName 
								INNER JOIN `customers` AS cu ON c1.CIndex = cu.Seq
								WHERE 
								
								c1.ContractName like "."'".$cn."%' 
								 and  r1.Active = 1 and 
								
								
((STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') < "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >="."'".$BMStartDate."'".' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <= "."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d')  <"."'".$BMEndDate."'". ' and' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') <"."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".'))  ' );

		return $query;
	
}


function ComputeContractValue($seq,$sd,$ed) {
	$nsd = strtotime($sd."00:00:00");
	$ned = strtotime($ed."23:59:00");
 	$ts = date("Y-m-d H:i:s",$nsd);
	$te = date("Y-m-d H:i:s",$ned);
	
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
 			  						
			  				WHERE `cd`.`Contract`=".$seq. " and si.Status = 0
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
	
function ComputeSpots($ContractNo){
	
	$query = $this->db->query("SELECT 
								Line,
								StartDate, 
								EndDate,
								StartDay,
								EndDay,
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
		       $cv =  $this->count_spots($row->Line,$row->StartDate,$row->EndDate,$row->StartDay,$row->EndDay,$row->Distribution, $row->UnitPrice);
		   
		     $c += $cv;
			}
		
	}
       return $c;
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
	  /*
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
	 */
	  $ConvertDays = array(0,1,2,3,4,5,6);
	 // $xDist = str_replace("-", "", $Dist);
      
	 // $aDist = str_split($xDist);
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
	 // $xDist = str_replace("-", "", $Dist);
      
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
	//$this->db->cache_on();
			  $this->db->select("*")
			  			->FROM('contract_detail') 
						->JOIN('sale_item', 'contract_detail.Line = sale_item.Seq')
						->JOIN('contract_header','contract_detail.Contract = contract_header.Seq')
 			  			->WHERE('contract_detail.Contract',$seq) 
						->WHERE('sale_item.Timestamp >=', $ts)
						->WHERE('sale_item.Timestamp <=', $te)
						->WHERE('sale_item.Status = ',0);
						
						
						
						
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

		
function get_billingmonth($currentuser){
		$this->db->select('broadcast_calendar.Month');
        $this->db->join('current_month', 'broadcast_calendar.Year= current_month.Year AND  broadcast_calendar.Month= current_month.Month','inner');
		$this->db->where('current_month.UserName', $currentuser);
			$query = $this->db->get('broadcast_calendar');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->Month;
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
		
		
function filter_contractno($StartDate, $EndDate){
	
 $BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
 $BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	    //$this->db->cache_on();
		
		//INNER JOIN `contract_detail` AS cd ON c1.Seq = cd.Contract
		$query = $this->db->query("SELECT 
								c1.Seq as c1C,
								c1.CIndex as c1Se,
								c1.AIndex as c1A,
								c1.SiteName as c1SN
								
								
								FROM `contract_header` AS c1 
								INNER JOIN `customers` AS cu ON c1.CIndex = cu.Seq
								
								
															 
								WHERE 
								(cu.EBill = 'True') and
							
(

(c1.StartDate >="."'".$BMStartDate. "'". ' and ' ." c1.EndDate  <="."'".$BMEndDate. "'".')'
." or "."
(c1.StartDate < "."'".$BMStartDate. "'". ' and ' ." c1.EndDate  >="."'".$BMStartDate."'".' and ' ." c1.EndDate  <= "."'".$BMEndDate. "'".')'
." or "."
(c1.StartDate >="."'".$BMStartDate. "'". ' and ' ." c1.StartDate  <"."'".$BMEndDate."'". ' and' ." c1.EndDate  >"."'".$BMEndDate. "'".')'
." or "."
(c1.StartDate <"."'".$BMStartDate. "'". ' and ' ." c1.EndDate  >"."'".$BMEndDate. "'".')

)
' );

		return $query;
	
	//$delimiter = ";";
	
	// if ($query->result() != null){  
	//	     foreach($query->result() as $row){
	//			return  "INFO;".$this->dbutil->csv_from_result($query, $delimiter)."\n" ;
			
	//		 }
	//	}
	
	
	
	
	
}	
		
	
	function get_customers_data($seq){
			

		$query = $this->db->query("Select 
										*								
									from customers
									WHERE 
									(EBill = 'True') and
									(Seq = "."'".$seq."'". ')' );
		

		$delimiter = ";";
		$newline = "\r\n";
        if ($query->result() != null){  
		return "CUST;".$this->dbutil->csv_from_result($query, $delimiter)."\r\n" ;
		}
		}
		
		
		function get_agency_data($seq){
		 		$query = $this->db->query("Select 
										*								
									from agencies
									WHERE 
									(Seq = "."'".$seq."'". ')' );
		
		
		$delimiter = ";";
		$newline = "\r\n";
        if ($query->result() != null){
		return "AGENCY;".$this->dbutil->csv_from_result($query, $delimiter)."\r\n" ;
		}
			
		}		
		
		function get_oper_data($SiteName){
		 		$query = $this->db->query("Select 
										*								
									from site_operators
									WHERE 
									(SiteName = "."'".$SiteName."'". ')' );
		$delimiter = ";";
		$newline = "\r\n";

        if ($query->result() != null){
		return "OPER;".$this->dbutil->csv_from_result($query, $delimiter)."\r\n" ;
		}
		}		
		
		function get_contract_data($Seq){
		 		$query = $this->db->query("Select 
										*								
									from contract_header
									WHERE 
									(Seq = "."'".$Seq."'". ')' );
		
		
		
		$delimiter = ";";
		$newline = "\r\n";
			
			
				
					 if ($query->result() != null){
					return "CONTRACT;".$this->dbutil->csv_from_result($query, $delimiter)."\n";
				
				
			}
					
		}		
		
		function get_contract_detail($Seq){
		$query = $this->db->query("Select 
										*								
									from contract_detail as cd
									INNER JOIN `sale_item` AS si ON cd.Line = si.Seq 
									WHERE 
									(cd.Contract = "."'".$Seq."'". ')' );
		
		
		$delimiter = ";";
		$newline = "\r\n";
		if ($query->result() != null){
			//foreach($query->result() as $row){
				return "SCHED;".$this->dbutil->csv_from_result($query, $delimiter)."\n" ;
			//}
		}
		
		}
		function get_sale_item($seq){
			
			//INNER JOIN `contract_detail` AS cd ON si.Seq = cd.Line
					$query = $this->db->query("Select 
										*								
									from sale_item as si
									
									WHERE 
									(si.Seq= "."'".$seq."'". ')' );



			$delimiter = ";";
		$newline = "\r\n";
			if ($query->result() != null){
				//foreach($query->result() as $row){
					return "SALE;".$this->dbutil->csv_from_result($query, $delimiter)."\r\n" ;
					}
				//}
			}
		
		
				
	function get_invoice_all(){
		
		$query = $this->db->query("Select SiteName as sn
									from registration
									where
									Active  = 1");
		
		
		
				$c = 0;
				if ($query->num_rows() > 0) {
					foreach ( $query->result() as $row)
						{
		     			$cv = $this->get_invoices($row->sn);
						// $cv =  $this->GetDistributionAmount($row->Line,$row->StartDate,$row->EndDate,$row->Distribution, $row->UnitPrice,$sd,$ed);
		    			//$c += $cv;
	
				}
       			return $query;
			}
			
		}	
		
	

		
		
		
	function get_salesitem($seq){
	
	 $currentuser = $this->session->userdata('username');
	 $bStartDate = $this->get_billingstartdate($currentuser);
	 $bEndDate = $this->get_billingenddate($currentuser);
	
	
	
	$nsd = strtotime($bStartDate."00:00:00");
	$ned = strtotime($bEndDate."23:59:00");
 	$ts = date("Y-m-d H:i:s",$nsd);
	$te = date("Y-m-d H:i:s",$ned);
	
			  $query = $this->db->query("SELECT si.Seq as siS, 
			  									si.Timestamp as siT, 					
												si.Network as siN,
												si.RunTime as siR,
												si.SpotName as siSp,
												(cd.UnitPrice/100) as siP,
												si.Status as siST, 
												si.ID as siI, 
												si.LogID as siL,
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
				

		return $query;
}

	
	
	
}

?>