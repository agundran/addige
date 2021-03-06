<?php

class Legacyinvoicingprintmodel extends CI_Model{
	
	
	function __construct(){
	parent::__construct();
	}


function get_contract_details($order_column){
		
		//$aStartDate = date('Y-m-d',strtotime('2015-01-01'));
		
	$currentuser = $this->session->userdata('username');
	$BMStartDate = $this->get_billingstartdate($currentuser);
	$BMEndDate = $this->get_billingenddate($currentuser);
	

	//$bStartDate = date('Y-m-d',strtotime($StartDate));
	//$bEndDate = date('Y-m-d',strtotime($EndDate));
	
	//$bStartdate = date('Y/n/d',strtotime($StartDate));
	//$bEnddate = date('Y/n/d',strtotime($EndDate));
	
			  $query = $this->db->query("SELECT t1.Line AS t1L,
			  									t1.Contract AS t1C, 
												t1.Network AS t1N,
												t1.StartDate as t1S1, 
												t1.EndDate as t1E1, 
												t2.CIndex as t2CI,
												
												t1.TimeOn, 
												t1.TimeOff, 
												t1.Distribution AS t1D, 
												(t1.UnitPrice/100) AS t1U, 
												t1.Value AS t1V, t1.nSched AS t1Sc, 
												t1.nPlaced AS t1Pc, 
												t1.nPlayed AS t1Py, 
												
												t2.ContractName AS t2CN,
												t2.CustOrder AS t2CO ,
												t2.StartDate AS t2SD,
												t2.EndDate AS t2ED
												
		  
			  FROM (`contract_header` AS t2) 
			  JOIN  `contract_detail` AS t1 ON `t2`.`Seq` = `t1`.`Contract`
	           

				WHERE (t1.StartDate >= t2.StartDate and t1.EndDate  <= t2.EndDate)
				
				"." and "."
								
								

								
								
(


 t2.Seq = "."'". $order_column."' 



)" );


/*				
								
(
(t1
.StartDate >="."'".$BMStartDate. "'". ' and ' ." t1.EndDate  <="."'".$BMEndDate. "'".')'

." or "."
(t1.StartDate < "."'".$BMStartDate. "'". ' and ' ." t1.EndDate  >="."'".$BMStartDate."'".' and ' ." t1.EndDate  <= "."'".$BMEndDate. "'".')'
." or "."  
(t1.StartDate >="."'".$BMStartDate. "'". ' and ' ." t1.StartDate  <"."'".$BMEndDate."'". ' and' ." t1.EndDate  >"."'".$BMEndDate. "'".')'
." or "."
(t1.StartDate <"."'".$BMStartDate. "'". ' and ' ." t1.EndDate  >"."'".$BMEndDate. "'".')


) '
				
			
				
	//			t5.StartDate between "."'". $astartdate."'". 'and' ."'".$aenddate.
*/
//CONCAT(Date_format(t1.StartDate,'%b %d, %Y ') ,' ' ,t1.TimeOn) AS t1S, CONCAT(Date_format(t1.EndDate,'%b %d, %Y '),' ' ,t1.TimeOff) AS t1E,
		return $query;

	}
	
function count_sitename_active(){
	
	$query = $this->db->query("SELECT  SiteName 
								from registration
								where Active = 1");
								
	return $this->db->count_all_results();							 
	
	}
function get_contractname($cn){
	
	 $query = $this->db->query("SELECT  ContractName AS t4S 
	 							from `contract_header` AS t4 
								WHERE `t4`.`Seq`="."'".$cn."'
	 							");
	
	 		$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->t4S;
			return $rolltext;  
	}
	
	function get_custorder($cn){
	
	 $query = $this->db->query("SELECT  CustOrder AS t4S 
	 							from `contract_header` AS t4 
								WHERE `t4`.`Seq`="."'".$cn."'
	 							");
	
	 		$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->t4S;
			return $rolltext;  
	}
	
	function get_customer($cn){
	
	 $query = $this->db->query("SELECT  t2.Name AS t4S 
	 							from `contract_header` AS t4 
								inner join `customers` AS t2 ON `t4`.`CIndex` =`t2`.`Seq` 
								WHERE `t4`.`Seq`="."'".$cn."'
	 							");
	
	 		$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->t4S;
			return $rolltext;  
	}
	
	function get_add1($cn){
	
	 $query = $this->db->query("SELECT  Address1 AS t4S 
	 							from `contract_header` AS t4 
								inner join `customers` AS t2 ON `t4`.`CIndex` =`t2`.`Seq` 
								WHERE `t4`.`Seq`="."'".$cn."'
	 							");
	
	 		$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->t4S;
			return $rolltext;  
	}

	function get_add2($cn){
	
	 $query = $this->db->query("SELECT  Address2 AS t4S 
	 							from `contract_header` AS t4 
								inner join `customers` AS t2 ON `t4`.`CIndex` =`t2`.`Seq` 
								WHERE `t4`.`Seq`="."'".$cn."'
	 							");
	
	 		$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->t4S;
			return $rolltext;  
	}
	
	function get_city($cn){
	
	 $query = $this->db->query("SELECT  City AS t4S 
	 							from `contract_header` AS t4 
								inner join `customers` AS t2 ON `t4`.`CIndex` =`t2`.`Seq` 
								WHERE `t4`.`Seq`="."'".$cn."'
	 							");
	
	 		$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->t4S;
			return $rolltext;  
	}
	
	function get_state($cn){
	
	 $query = $this->db->query("SELECT  State AS t4S 
	 							from `contract_header` AS t4 
								inner join `customers` AS t2 ON `t4`.`CIndex` =`t2`.`Seq` 
								WHERE `t4`.`Seq`="."'".$cn."'
	 							");
	
	 		$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->t4S;
			return $rolltext;  
	}

	function get_zip($cn){
	
	 $query = $this->db->query("SELECT  Zip AS t4S 
	 							from `contract_header` AS t4 
								inner join `customers` AS t2 ON `t4`.`CIndex` =`t2`.`Seq` 
								WHERE `t4`.`Seq`="."'".$cn."'
	 							");
	
	 		$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->t4S;
			return $rolltext;  
	}
	
	
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

function get_spotnames($order_column){
		
	$currentuser = $this->session->userdata('username');
	$aStartDate = $this->get_billingstartdate($currentuser);
	$aEndDate = $this->get_billingenddate($currentuser);
	
	
	$astartdate = date('Y/n/d',strtotime($aStartDate));
	$aenddate = date('Y/n/d',strtotime($aEndDate));

		//$query = $this->db->query("SELECT Distinct SpotName FROM contract_copy  WHERE Contract=".$order_column. " and StartDate between "." '".$astartdate. "'". ' and ' ."'".$aenddate."' ");

	
	        $this->db->select('Distinct(SpotName)');
			//$this->db->select('SpotName');
			
			$this->db->where('Contract', $order_column);
			
     	    //$this->db->where('StartDate >= ', $astartdate);
			//$this->db->where('StartDate <= ', $aenddate);
			
      		$query=$this->db->get('contract_copy');
      		$result = $query->result();
			
			//if ($query->num_rows() > 0){
			//foreach($result as $item){
				
			
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->SpotName;
			return $rolltext;     
      		
			
	
	}
	

function count_all($order_column){
	
	$currentuser = $this->session->userdata('username');
	$aStartDate = $this->get_billingstartdate($currentuser);
	$aEndDate = $this->get_billingenddate($currentuser);
	
	$astartdate = date('Y/n/d',strtotime($aStartDate));
	$aenddate = date('Y/n/d',strtotime($aEndDate));
	
	
			//$this->db->select('*')
			//		->from('contract_detail')
		//			->where ('Contract',$contract);
			 $query = $this->db->query("SELECT Contract , StartDate, EndDate FROM contract_detail  WHERE Contract=".$order_column. " and StartDate between "." '".$astartdate. "'". ' and ' ."'".$aenddate."' ");

    
						 
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