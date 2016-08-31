<?php

class legacysetcustomer1model extends CI_Model{

	private $table_name='broadcast_calendar';
	
	function __construct(){
	parent::__construct();
	
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='Year', $order_type='desc',$filter){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by('Year','desc');
	}
	else{
	  		$query = $this->db->select('*')
                        ->from('broadcast_calendar')
						->order_by('Year','desc')
						->order_by('Month','asc')
                        ->like('Year', $filter, 'after')
                        ->get('', $limit, $offset); 
					   
				return $query;
		
		}
	}

	
	
	function get_site() { 		
	  		$sql = "SELECT so.SysCode, concat(so.SysCode,' -  ' , so.SiteName) as mysite FROM site_operators as so INNER JOIN registration as re ON (so.SiteName = re.SiteName) WHERE (re.Active = 1)
			 ";
			$query=$this->db->query($sql);
			$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->SysCode] = $item->mysite;
      				//$options[$item->SiteName] = $item->SiteName;
      				
					}
      		return $options;	
		}
	
	function get_customer() { 		
	  		$sql = "SELECT Seq, concat(Seq ,' -  ' , Name) as mycust FROM customers  WHERE (EBill = 'True')";
			$query=$this->db->query($sql);
			$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->Seq] = $item->mycust;
      				//$options[$item->SiteName] = $item->SiteName;
      				
					}
      		return $options;	
		}
	
		
	function get_customer_name($Seq) { 		
	  		
			$this->db->select('Name');
        	$this->db->where('Seq', $Seq);
			$query = $this->db->get('customers');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->Name;
			return $rolltext;  
			
		}
	
	function get_sysname($syscode) { 	
	       	$this->db->select('SiteName');
        	$this->db->where('SysCode', $syscode);
			$query = $this->db->get('site_operators');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->SiteName;
			return $rolltext; 
	
		
		}
	
	function get_site_list(){
		
		$sql = "SELECT so.SysCode, concat(so.SysCode,' -  ' , so.SiteName) as mysite FROM site_operators as so INNER JOIN registration as re ON (so.SiteName = re.SiteName) WHERE (re.Active =1)
			 ";
			$query=$this->db->query($sql);
			$result = $query->result();
			
			$return = array();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row) {
			$return[$row['SysCode']] = $row['SiteName'];
			}
		}

        return $return;
		
		}	
		
		
	function get_billingstartdate($currentuser){
		$this->db->select('broadcast_calendar.Start_Date');
        $this->db->join('current_month', 'broadcast_calendar.Year= current_month.Year AND  broadcast_calendar.Month= current_month.Month','inner');
		$this->db->where('current_month.UserName', $currentuser);
					$query = $this->db->get('broadcast_calendar');
            
			/*$query = $this->db->query("SELECT 
								Start_Date
								FROM `broadcast_calendar` AS bc 
								INNER JOIN `current_month` AS cm ON bc.Year = cm.Year and  bc.Month = cm.Month 
								WHERE 
									(cm.UserName = "."'".$currentuser."'". ')' );*/
								
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
   
   function get_currentmonth($currentuser){
		$this->db->select('current_month.Month');
        $this->db->join('current_month', 'broadcast_calendar.Year= current_month.Year AND  broadcast_calendar.Month= current_month.Month','inner');
		$this->db->where('current_month.UserName', $currentuser);
			$query = $this->db->get('broadcast_calendar');
            $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->Month;
			return $rolltext;             
		
		}
	
	function filter_contractno($Seq,$StartDate, $EndDate){
  		$time = strtotime('10/16/2003');
		$newformat = date('Y-m-d',$time);
		
        		
		// $BMStartDate = $StartDate;	
  		 //$BMEndDate =	$EndDate;
 	//$BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
 $BMStartDate = date('Y-m-d',strtotime($StartDate));
	// $BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
 $BMEndDate = date('Y-m-d',strtotime($EndDate));

	   	// $this->db->cache_on();
		
		//INNER JOIN `contract_detail` AS cd ON c1.Seq = cd.Contract
		$query = $this->db->query("SELECT 
								c1.Seq as c1C,
								c1.CIndex as c1Se,
								c1.AIndex as c1A,
								c1.SiteName as c1SN
								FROM `contract_header` AS c1 
								INNER JOIN `customers` AS cu ON c1.CIndex = cu.Seq
								WHERE 

((STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') < "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >="."'".$BMStartDate."'".' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <= "."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d')  <"."'".$BMEndDate."'". ' and' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') <"."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')) and c1.CIndex ='.$Seq.' ');


// find the contracts that are in range
	    // 1) Contract started and ended within the month
	    // 2) Contract started before the month and ended in it
	    // 3) Contract started in the month but ended after it
	    // 4) Contract started before and ended after the broadcast month
		return $query;
	}	


function get_customers_data($seq){
		$this->db->cache_off();
		$query = $this->db->query("Select 
										*								
									from customers
									WHERE 
									(Seq = "."'".$seq."'". ')' );
									
			$delimiter = ";";
			$newline = "\r\n";
       		if ($query->result() != null){  
				return $this->dbutil->csv_from_result_wof($query, $delimiter);
			}
	}
		
	//get compete Agency data from table agencies	
	function get_agency_data($seq){
		$this->db->cache_off();
		 		$query = $this->db->query("Select *								
											from agencies
											WHERE 
											(Seq = "."'".$seq."'". ')' );
		
			$delimiter = ";";
			$newline = "\n";
        	if ($query->result() != null){
				return $this->dbutil->csv_from_result_wof($query, $delimiter);
			}
	}		
	
	//get complete Operator data from table site_operators 	
	function get_oper_data($SiteName){
		$this->db->cache_off();
		 		$query = $this->db->query("Select *								
									from site_operators
									WHERE 
									(SiteName = "."'".$SiteName."'". ')' );
				$delimiter = ";";
				$newline = "\n";

        if ($query->result() != null){
			return $this->dbutil->csv_from_result_wof($query, $delimiter);
		}
	}		
		
	//get complete COntract data from table contract_header
	function get_contract_data($Seq,$aStartDate,$aEndDate){
		//$this->db->cache_on();
		$currentuser = $this->session->userdata('username');
			//$aStartDate = $this->get_billingstartdate($currentuser); 
			//$aEndDate = $this->get_bi,llingenddate($currentuser);
			$BMStartDate = $aStartDate;
    		 $BMEndDate = $aEndDate;
	
		
		 		$query = $this->db->query("Select *								
									from contract_header
									WHERE 
									Seq = "."'".$Seq. "'" );
		
		
		$delimiter = ";";
		
		//Seq = "."'".$Seq. "' and (STR_TO_DATE(REPLACE(StartDate,'/','-'), '%Y-%c-%d') >= "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate."'".') and ' ." Seq = "."'".$Seq. "'".''."");
		$newline = "\n";
					 if ($query->result() != null){
						 
					return $this->dbutil->csv_from_result_wof($query, $delimiter);
			}
					
		}		

	

	function get_contract_detail($Seq){
	
	$currentuser = $this->session->userdata('username');
	$aStartDate = $this->get_billingstartdate($currentuser); 
	$aEndDate = $this->get_billingenddate($currentuser);
	
	// $BMStartDate = date('Y-m-d',strtotime($aStartDate)) or date('Y/m/d',strtotime($aStartDate));
    // $BMEndDate = date('Y-m-d',strtotime($aEndDate)) or date('Y/m/d',strtotime($aEndDate));
	 $BMStartDate = date('Y-m-d',strtotime($aStartDate));
     $BMEndDate = date('Y-m-d',strtotime($aEndDate));
	//$this->db->cache_on();
	
	$query = $this->db->query("Select Concat('SCHED;',Line) as SL, Line, Contract, Network, StartDate, EndDate, TimeOn, TimeOff, Distribution, Bonus,Priority, UnitPrice,nWeeks, Value, nSched, nPlaced, nPlayed, ActualValue, ProgramName,StartDay, EndDay, MakeGoods, MakeGoodDays,NOrdered,LineID from contract_detail as cd WHERE 

(STR_TO_DATE(REPLACE(StartDate,'/','-'), '%Y-%c-%d') >= "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(EngfdDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate."'".') and ' ." cd.Contract  = "."'".$Seq. "'".''
."");
		$rolltext= "";
		$rolltext2 = "";
		$saleitem="";
		foreach ($query->result() as $row){
				$rolltext = $rolltext. ($row->SL.';'.$row->Contract.';'.$row->Network.';'.$row->StartDate.';'.$row->EndDate.';'. $row->TimeOn.';'. $row->TimeOff.';'. $row->Distribution.';'. $row->Bonus.';'.$row->Priority.';'. $row->UnitPrice.';'.$row->nWeeks.';'. $row->Value.';'. $row->nSched.';'. $row->nPlaced.';'. $row->nPlayed.';'. $row->ActualValue.';'. $row->ProgramName.';'.$row->StartDay.';'.$row->EndDay.';'. $row->MakeGoods.';'. $row->MakeGoodDays.';'.$row->NOrdered.';'.$row->LineID).';'.$this->get_sale_item2($row->Line)."<br />";$this->get_sale_item2($row->Line);
				
			//	$saleitem = $saleitem."<br />". $this->get_sale_item2($row->Line);
				
					   }
			//return $rolltext."<br />".$saleitem; 
				 return $rolltext;
		}
		
	
	
	function get_detail($Seq,$aStartDate,$aEndDate){
	
	//$currentuser = $this->session->userdata('username');
	//$aStartDate = $this->get_billingstartdate($currentuser); 
	//$aEndDate = $this->get_billingenddate($currentuser);
	
	// $BMStartDate = date('Y-m-d',strtotime($aStartDate)) or date('Y/m/d',strtotime($aStartDate));
    // $BMEndDate = date('Y-m-d',strtotime($aEndDate)) or date('Y/m/d',strtotime($aEndDate));
	 $BMStartDate = date('Y-m-d',strtotime($aStartDate));
     $BMEndDate = date('Y-m-d',strtotime($aEndDate));
	//$this->db->cache_on();
	
	$query = $this->db->query("Select Concat('SCHED;',Line) as SL, Line, Contract, Network, StartDate, EndDate, TimeOn, TimeOff, Distribution, Bonus,Priority, UnitPrice,nWeeks, Value, nSched, nPlaced, nPlayed, ActualValue, ProgramName,StartDay, EndDay, MakeGoods, MakeGoodDays,NOrdered,LineID from contract_detail as cd WHERE 
(STR_TO_DATE(REPLACE(StartDate,'/','-'), '%Y-%c-%d') >= "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate."'".') and ' ." cd.Contract  = "."'".$Seq. "'".''
."");
		$rolltext= "";
		$rolltext2 = "";
		$saleitem="";
		
		
		
		foreach ($query->result() as $row){
			
			
				$rolltext = $rolltext. ($row->SL.';'.$row->Contract.';'.$row->Network.';'.$row->StartDate.';'.$row->EndDate.';'. $row->TimeOn.';'. $row->TimeOff.';'. $row->Distribution.';'. $row->Bonus.';'.$row->Priority.';'. $row->UnitPrice.';'.$row->nWeeks.';'. $row->Value.';'. $row->nSched.';'. $row->nPlaced.';'. $row->nPlayed.';'. $row->ActualValue.';'. $row->ProgramName.';'.$row->StartDay.';'.$row->EndDay.';'. $row->MakeGoods.';'. $row->MakeGoodDays.';'.$row->NOrdered.';'.$row->LineID).';'.$this->get_sale_item2($row->Line);$this->get_sale_item2($row->Line);
$saleitem = $saleitem. $this->get_sale_item2($row->Line);
				
			   }
			//return $rolltext."<br />".$saleitem; 
				 return $rolltext;
				 
		
		}
		
	function get_contract_detailA($Seq){
	
	//$this->db->cache_on();
	
	$query = $this->db->query("Select Concat('SCHED;',Line) as SL, Line, Contract, Network, StartDate, EndDate, TimeOn, TimeOff, Distribution, Bonus,Priority, UnitPrice,nWeeks, Value, nSched, nPlaced, nPlayed, ActualValue, ProgramName,StartDay, EndDay, MakeGoods, MakeGoodDays,NOrdered,LineID from contract_detail as cd WHERE cd.Contract  <= "."'".$Seq. "'".''."");
		$rolltext= "";
		
		
		foreach ($query->result() as $row){
				$rolltext = $rolltext. ($row->SL.';'.$row->Contract.';'.$row->Network.';'.$row->StartDate.';'.$row->EndDate.';'. $row->TimeOn.';'. $row->TimeOff.';'. $row->Distribution.';'. $row->Bonus.';'.$row->Priority.';'. $row->UnitPrice.';'.$row->nWeeks.';'. $row->Value.';'. $row->nSched.';'. $row->nPlaced.';'. $row->nPlayed.';'. $row->ActualValue.';'. $row->ProgramName.';'.$row->StartDay.';'.$row->EndDay.';'. $row->MakeGoods.';'. $row->MakeGoodDays.';'.$row->NOrdered.';'.$row->LineID).';'.$this->get_sale_item2($row->Line);$this->get_sale_item2($row->Line);
				
			//	$saleitem = $saleitem."<br />". $this->get_sale_item2($row->Line);
				
					   }
			//return $rolltext."<br />".$saleitem; 
				 return $rolltext;
		}
	
	
function get_sale_item2($line){
							$query = $this->db->query("Select 
										Concat('SALE;',si.Timestamp) as siT,
									
										si.ID as siI,
										si.SiteID as siS,
										si.Network as siN,
										si.LogID as siL,
										si.Seq as siSe,
										si.Status as siSt,
										si.Runtime as siR,
										si.SpotName as siSp
																		
									from sale_item as si
									WHERE 
									(si.Seq= "."'".$line."'". ')' );


		$rolltext= "";
		$rolltext2 = "";
		foreach ($query->result() as $row){
				$rolltext = $rolltext.($row->siT.';'.$row->siI.';'.$row->siS.';'.$row->siN.';'.$row->siL.';'. $row->siSe.';'. $row->siSt.';'. $row->siR.';'. $row->siSp.';'."");
		//$delimiter = ";";
							}
			//$rolltext = siT.';'.siI.';'.siS.';'.siN.';'.siL.';'.siSe.';'.siSt.';'.siR.';'.siSp.';';			
							
			return $rolltext;
					
			}
	
	
					
	function count_all(){
	return $this->db->count_all($this->table_name);
	}

	function get_by_id($year,$month){
	$this->db->where('Year',$year)
			->where('Month',$month);
	
	return $this->db->get($this->table_name);
	}

	
	function update($year,$month,$User){
	$this->db->where('Year',$year)
			->where('Month',$month);
	$this->db->update($this->table_name,$User);
	}

	function delete($year,$month){
	$this->db->where('Year',$year)
			->where('Month',$month);
	$this->db->delete($this->table_name);
	}





	
}

?>

