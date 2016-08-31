<?php



   
ini_set('memory_limit', '2048M'); 
ini_set ( 'max_execution_time', 900); 

class Invoicingbycustomermodel extends CI_Model{
	


	function __construct(){
	parent::__construct();
	}


function get_paged_list($limit, $offset=0, $order_column='SiteName', $order_type='asc', $filter, $StartDate, $EndDate){
		
		//$aStartDate = date('Y-m-d',strtotime('2015-01-01'));
		$currentuser = $this->session->userdata('username');
	$aStartDate = $this->get_billingstartdate($currentuser);
	$aEndDate = $this->get_billingenddate($currentuser);
	
	
	$astartdate = date('Y/n/d',strtotime($aStartDate));
	$aenddate = date('Y/n/d',strtotime($aEndDate));
		
	
	if(empty($order_column)||empty($order_type)){		
		$this->db->order_by('SiteName','asc');
		}
	else{
		
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
								r1.Active = 1
								");
		return $query;
	}

}




function get_contracts($SiteName){
	
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
								WHERE 
								(c1.SiteName= "."'".$SiteName."'". ')'

." and "."
((STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') < "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >="."'".$BMStartDate."'".' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <= "."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d')  <"."'".$BMEndDate."'". ' and' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') <"."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".'))  '

 );


$c = 0;
	if ($query->num_rows() > 0) {
		
	foreach ( $query->result() as $row)
			{
		      // $cv =  $this->GetDistributionAmount($row->StartDate,$row->EndDate,$row->Distribution, $row->UnitPrice);
		    $cv =  $this->get_contract_details($row->c1Se,$row->c1S, $row->c1E);
		    
			 $c += $cv;
	
		
		}
      
	}
	 return $c;

	
	}




function get_contract_details($order_column, $sd, $ed){
		
	
			  $query = $this->db->query("SELECT c1.Line AS c1L,
			  									c1.UnitPrice/100 AS c1U, 
												c1.StartDate AS c1SD,
												c1.EndDate AS c1ED
												FROM `contract_detail` AS c1 
	          									WHERE (c1.Contract = "."'".$order_column."'". ')'
												." and "."

												(c1.StartDate >="."'".$sd. "'". ' && ' ." c1.EndDate  <="."'".$ed. "'".')'
												 );

		$c = 0;
		if ($query->num_rows() > 0) {
		
			foreach ( $query->result() as $row)
					{
		    		$cv =  ($this->get_spotshown($row->c1L)) * ($row->c1U);
		    
			 		$c += $cv;
	
				}
      
			}
			 return $c;

			}


function get_spotshown($seq){
	$currentuser = $this->session->userdata('username');
	$StartDate = $this->get_billingstartdate($currentuser);
	$EndDate = $this->get_billingenddate($currentuser);
	$sd = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
	$ed = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	
	$nsd = strtotime($sd."00:00:00");
	$ned = strtotime($ed."23:59:00");
 	$ts = date("Y-m-d H:i:s",$nsd);
	$te = date("Y-m-d H:i:s",$ned);
	
			  $query = $this->db->query("SELECT Seq
			  								
			  							 from `sale_item` 
										 
 			  						
			  				WHERE `Seq`='". $seq."'
							and Timestamp between '". $ts."' and '". $te."'
							"
				
				);
				

	$c = 0;
	if ($query->num_rows() > 0) {
		
	foreach ( $query->result() as $row)
			{
		     $c++;
	
		}
       return $c;
	}
		
		
		// and (sale_item.Timestamp between "."('". $ts."')". ' and ' ."('".$te."'))
		
}


function count_all(){
			$this->db->select('t1.SiteName, t1.SysCode, ')
					->from('site_operators as t1')
					->join ('registration as t3','t1.SiteName= t3.SiteName' )
					->join('clients as t2','t1.SiteName = t2.ShortName')
					->where ('t3.Active',1);
						 
	return $this->db->count_all_results();
	
	}
	
function count_cust(){
			$this->db->select('Name')
					->from('customers as cu')
				
					->where ('cu.EBill','True');
						 
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