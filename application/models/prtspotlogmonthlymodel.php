<?php

class Prtspotlogmonthlymodel extends CI_Model{
	
	
	function __construct(){
	parent::__construct();
	}


function get_paged_list($seq,$sd,$ed){
	
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
				

		return $query;
}


function get_spotnames($order_column){
		
	$currentuser = $this->session->userdata('username');
	$aStartDate = $this->get_billingstartdate($currentuser);
	$aEndDate = $this->get_billingenddate($currentuser);
	
	
	$astartdate = date('Y-n-d',strtotime($aStartDate));
	$aenddate = date('Y-n-d',strtotime($aEndDate));
            
			//$this->db->distinct();
	        //$this->db->select('SpotName');
			//$this->db->where('Contract', $order_column);
	  		//$query=$this->db->get('contract_copy');
      		
			
			 $query = $this->db->query("SELECT DISTINCT SpotName 
	 							from `contract_copy` AS cc 
								WHERE `cc`.`Contract`="."'".$order_column."'
	 							");
			
			
			$result = $query->result();
			$rolltext ="";
			
			foreach($result as $row){
				//$result = $query->row();	
				$rolltext = $rolltext.",".$row->SpotName;	
			}
   		
			return $rolltext;      
      		
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
	
	function get_sd($cn){
	
	 $query = $this->db->query("SELECT  StartDate AS t4S 
	 							from `contract_header` AS t4 
								inner join `customers` AS t2 ON `t4`.`CIndex` =`t2`.`Seq` 
								WHERE `t4`.`Seq`="."'".$cn."'
	 							");
	
	 		$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->t4S;
			return $rolltext;  
	}

	function get_ed($cn){
	
	 $query = $this->db->query("SELECT  EndDate AS t4S 
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
	
	function get_syscode($cn){
	
	 $query = $this->db->query("SELECT  SysCode AS t4S 
	 							from `site_operators` AS t4 
								WHERE `t4`.`SiteName`="."'".$cn."'
	 							");
	
	 		$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->t4S;
			return $rolltext;  
	}


	function get_progname($cn){
	
	 $query = $this->db->query("SELECT  NCCAlias AS t4S 
	 							from `network` AS t4 
								WHERE `t4`.`Name`="."'".$cn."'
	 							");
	
	 		$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->t4S;
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