<?php



   
  ini_set('memory_limit','128M');
 // ini_set('post_max_size','200M');
 // ini_set('max_input_time', 7200);
 //ini_set ('max_execution_time', 7200);
 set_time_limit(0);

class Invoicingbycustomermonthlymodel extends CI_Model{
	


	function __construct(){
	parent::__construct();
	}


function get_paged_list($limit=10, $offset=0, $order_column='ContractName', $order_type='asc', $filter, $filter1){
		
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
	
	


function get_contract_header($seq){
	$currentuser = $this->session->userdata('username');
	$StartDate = $this->get_billingstartdate($currentuser);
	$EndDate = $this->get_billingenddate($currentuser);
	
	$BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
	//$BMStartDate = date('Y-m-d',strtotime($StartDate));
	
	$BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	//$BMEndDate = date('Y-m-d',strtotime($EndDate));
		
		$query = $this->db->query("SELECT 
								c1.Seq as c1Se,
								
								c1.StartDate as c1S, 
								c1.EndDate as c1E
								FROM `contract_header` AS c1 
								INNER JOIN `customers` as c3 ON `c1`.`CIndex` = `c3`.`Seq` 
								
								WHERE c1.billing_type = 0 and 
								 "."
((STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') < "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >="."'".$BMStartDate."'".' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <= "."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d')  <"."'".$BMEndDate."'". ' and' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') <"."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')) and c3.Seq ='.$seq.' ');
 


$cv = 0;
$c = 0;
	if ($query->num_rows() > 0) {
		
	foreach ( $query->result() as $row)
			{
		      // $cv =  $this->GetDistributionAmount($row->StartDate,$row->EndDate,$row->Distribution, $row->UnitPrice);
		    $cv =  $this->get_contract_details($row->c1Se, $row->c1S,$row->c1E);
		    
			$c  += $cv;
	
		     
		}
        return $c;
	}
	

}


function get_contract_details($order_column , $StartDate, $EndDate){
		
	$currentuser = $this->session->userdata('username');
	$BMStartDate = $this->get_billingstartdate($currentuser);
	$BMEndDate = $this->get_billingenddate($currentuser);
	
	$bStartdate = date('Y/n/d',strtotime($StartDate));
	//$bStartdate =STR_TO_DATE(REPLACE($StartDate,'/','-'), '%Y-%c-%d');
	$bEnddate = date('Y/n/d',strtotime($EndDate));
	//$bEnddate =STR_TO_DATE(REPLACE($EndDate,'/','-'), '%Y-%c-%d');
			
			  $query = $this->db->query("SELECT t1.Line as t1L,
			  									
												t1.StartDate as t1S,
												t1.EndDate as t1E,
												t1.Distribution as t1D, 
												t1.UnitPrice as t1U	
												
			  FROM (`contract_header` AS t2) 
			  JOIN  `contract_detail` AS t1 ON `t2`.`Seq` = `t1`.`Contract`
	          WHERE (t1.StartDate >= t2.StartDate and t1.EndDate  <= t2.EndDate)
				"." and ("."

 t2.Seq = "."'". $order_column."' 

)" );
		
	$c = 0;
	if ($query->num_rows() > 0) {
		
	foreach ( $query->result() as $row)
			{
		       $cv =  $this->GetDistributionAmount($row->t1S,$row->t1E,$row->t1D, $row->t1U);
		   // $cv =  ($this->get_spotshown($row->t1L,$bStartdate,$bEnddate)) * ($row->t2U/100);
		 $c += $cv;
		}
      
	}
	 return $c;
	}


	
function get_spotshown($seq,$sd,$ed){
	$nsd = strtotime($sd."00:00:00");
	$ned = strtotime($ed."23:59:00");
	
	
			  $query = $this->db->query("SELECT Seq
			  							from `sale_item` 
						  				WHERE `Seq`='". $seq."'"
										." and "."

(Timestamp between"."'".$nsd. "'". ' and ' .""."'".$ned. "'".')'
										
										);
				

	$c = 0;
	if ($query->num_rows() > 0) {
		
	foreach ( $query->result() as $row)
			{
		     $c++;
	
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
	  //$xDist = str_replace("-", "", $Dist);
      
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



function computepercustomernet($cindex){
	
 $Billtype ='false';			   
				
 $currentuser = $this->session->userdata('username');
 $StartDate = $this->get_billingstartdate($currentuser);
 $EndDate = $this->get_billingenddate($currentuser);
	 
 $BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
 $BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	
		$query = $this->db->query("SELECT 
								c1.Seq as c1Se,
								c1.SiteName as c1SN, 
								c1.StartDate as c1S, 
								c1.EndDate as c1E 
								
								FROM `contract_header` AS c1 
							 
								WHERE 
								(c1.CIndex = "."'".$cindex."'". ')'
								
								." and "."
							
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

    $sc = 0;
		
	if ($query->num_rows() > 0) {
		foreach ( $query->result() as $row){
				$ec = $this->ComputeNet($row->c1Se,$this->ComputeContractValue($row->c1Se));
				$sc += $ec;
			
			}
			
			}
	
		return $sc;

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