
<?php

 ini_set('memory_limit', '4000M');
    ini_set('max_execution_time', '120000');
	set_time_limit(120000);
	ini_set("display_errors", "on");
	
class Generatebillingmodel extends CI_Model{
private $table_name='broadcast_calendar';
	
	function __construct(){
	parent::__construct();
	$this->load->dbutil();
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
           // $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->Name;
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
            
									
			//$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->Start_Date;
			return $rolltext;             
		
		}
   
   
   function get_billingenddate($currentuser){
		$this->db->select('broadcast_calendar.End_Date');
        $this->db->join('current_month', 'broadcast_calendar.Year= current_month.Year AND  broadcast_calendar.Month= current_month.Month','inner');
		$this->db->where('current_month.UserName', $currentuser);
			$query = $this->db->get('broadcast_calendar');
            //$result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->End_Date;
			return $rolltext;             
		
		}
   
   function get_currentmonth($currentuser){
		$this->db->select('current_month.Month');
        $this->db->join('current_month', 'broadcast_calendar.Year= current_month.Year AND  broadcast_calendar.Month= current_month.Month','inner');
		$this->db->where('current_month.UserName', $currentuser);
			$query = $this->db->get('broadcast_calendar');
           // $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->Month;
			return $rolltext;             
		
		}
	
	function filter_contractno($StartDate, $EndDate){
 	
	$BMStartDate = date('Y-m-d',strtotime($StartDate));
 	$BMEndDate = date('Y-m-d',strtotime($EndDate));

     $bol = 'True';

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
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') <"."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')) and cu.Ebill ='.$bol.' ');


// find the contracts that are in range
	    // 1) Contract started and ended within the month
	    // 2) Contract started before the month and ended in it
	    // 3) Contract started in the month but ended after it
	    // 4) Contract started before and ended after the broadcast month
		return $query;
	}	


function get_customers_data($seq){
		//$this->db->cache_on();
		$query = $this->db->query("Select 
										*								
									from customers
									WHERE 
									(Seq = "."'".$seq."'". ')' );
									
			$delimiter = ";";
			$newline = "\n";
       		if ($query->result() != null){  
				return $this->dbutil->csv_from_result_wof($query, $delimiter);
			}
	}
		
	//get compete Agency data from table agencies	
	function get_agency_data($seq){
		//$this->db->cache_off();
		 		$query = $this->db->query("Select *								
											from agencies
											WHERE 
											(Seq = "."'".$seq."'". ')' );
		
			$delimiter = ";";
			//$newline = "\r\n";
        	if ($query->result() != null){
				return $this->dbutil->csv_from_result_wof($query, $delimiter);
			} else {
				
				return ";;;;;;;;;;;";
				}
	}		
	
	//get complete Operator data from table site_operators 	
	function get_oper_data($SiteName){
		//$this->db->cache_on();
		 		$query = $this->db->query("Select *								
									from site_operators
									WHERE 
									(SiteName = "."'".$SiteName."'". ')' );
				$delimiter = ";";
				//$newline = "\r\n";

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

 
 function get_detail_new($Seq,$aStartDate,$aEndDate){
	
	$BMStartDate = date('Y-m-d',strtotime($aStartDate));
    $BMEndDate = date('Y-m-d',strtotime($aEndDate));

		$query = $this->db->query("Select Concat('SCHED;',Line) as SL, 
									Line, 
									Contract, 
									Network, 
									StartDate, 
									EndDate, 
									TimeOn, 
									TimeOff, 
									Distribution, 
									Bonus,Priority, 
									UnitPrice,nWeeks, 
									Value, 
									nSched, 
									nPlaced, 
									nPlayed, 
									ActualValue, 
									ProgramName,
									StartDay, 
									EndDay, 
									MakeGoods, 
									MakeGoodDays,
									NOrdered, 
									LineID 
									from contract_detail as cd 
									WHERE 
					((StartDate) >= "."'".$BMStartDate. "'". ' and ' ." 				
					(EndDate)  <="."'".$BMEndDate."'".') and ' ." 
					cd.Contract  = "."'".$Seq. "'".''."");
		
		
		//				WHERE 
		///			(STR_TO_DATE(REPLACE(StartDate,'/','-'), '%Y-%c-%d') >= "."'".$BMStartDate. "'". ' and ' ." 				
		//			STR_TO_DATE(REPLACE(EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate."'".') and ' ." 
		$rolltext= "";
		$rolltext2 = "";
		$saleitem="";
		
		
		foreach ($query->result() as $row){
			 
			  $gd = $this->GetDistributionAmount($row->StartDate,$row->EndDate, $row->Distribution);
			  $ss = $this->get_spotshown($row->Line,$row->StartDate,$row->EndDate);
			   
			  if($ss > 0){
				$total = 
				$gd.';'.
				$ss.';'.
				$ss.';'.
				$ss * ($row->Value);
				
				             		
				$rolltext = $rolltext.($row->SL.';'.$row->Contract.';'.$row->Network.';'.$row->StartDate.';'.$row->EndDate.';'. $row->TimeOn.';'. $row->TimeOff.';'. $row->Distribution.';'. $row->Bonus.';'.$row->Priority.';'. $row->UnitPrice.';'.$row->nWeeks.';'. $row->Value.';'.$total.';'.$row->ProgramName.';'.$row->StartDay.';'.$row->EndDay.';'
. $row->MakeGoods.';'. $row->MakeGoodDays.';'.$row->NOrdered.';'.$row->LineID).';'.PHP_EOL				
				
				.$this->get_sale_item2($row->Line,$ss).
			  
				'TOTAL;'.$total.';'.PHP_EOL;
				
			   }else if ($ss == 0){
				   
				$total = 
				$gd.';'.
				'0'.';'.
				'0'.';'.
				'0';
				
				             		
				$rolltext = $rolltext.($row->SL.';'.$row->Contract.';'.$row->Network.';'.$row->StartDate.';'.$row->EndDate.';'. $row->TimeOn.';'. $row->TimeOff.';'. $row->Distribution.';'. $row->Bonus.';'.$row->Priority.';'. $row->UnitPrice.';'.$row->nWeeks.';'. $row->Value.';'.$total.';'.$row->ProgramName.';'.$row->StartDay.';'.$row->EndDay.';'
. $row->MakeGoods.';'. $row->MakeGoodDays.';'.$row->NOrdered.';'.$row->LineID).';'.PHP_EOL				
				.'TOTAL;'.$total.';'.PHP_EOL;
					   }
				}
			return $rolltext;
		}
	

 function get_detail_new1($Seq,$aStartDate,$aEndDate){
	
	$BMStartDate = date('Y-m-d',strtotime($aStartDate));
    $BMEndDate = date('Y-m-d',strtotime($aEndDate));

		$query = $this->db->query("Select Concat('SCHED;',Line) as SL, 
									Line, 
									Contract, 
									Network, 
									StartDate, 
									EndDate, 
									TimeOn, 
									TimeOff, 
									Distribution, 
									Bonus,Priority, 
									UnitPrice,nWeeks, 
									Value, 
									nSched, 
									nPlaced, 
									nPlayed, 
									ActualValue, 
									ProgramName,
									StartDay, 
									EndDay, 
									MakeGoods, 
									MakeGoodDays,
									NOrdered, 
									LineID 
									from contract_detail as cd 
									WHERE 
					((StartDate) >= "."'".$BMStartDate. "'". ' and ' ." 				
					(EndDate)  <="."'".$BMEndDate."'".') and ' ." 
					cd.Contract  = "."'".$Seq. "'".''."");
		
		
		//				WHERE 
		///			(STR_TO_DATE(REPLACE(StartDate,'/','-'), '%Y-%c-%d') >= "."'".$BMStartDate. "'". ' and ' ." 				
		//			STR_TO_DATE(REPLACE(EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate."'".') and ' ." 
		$rolltext= "";
		$rolltext2 = "";
		$saleitem="";
		
		
		foreach ($query->result() as $row){
			 
			  $gd = $this->GetDistributionAmount($row->StartDate,$row->EndDate, $row->Distribution);
			  $ss = $this->get_spotshown($row->Line,$row->StartDate,$row->EndDate);
			   
			  if($ss > 0){
				$total = 
				$gd.';'.
				$ss.';'.
				$ss.';'.
				$ss * ($row->Value);
				
				             		
				$rolltext = $rolltext.($row->SL.';'.$row->Contract.';'.$row->Network.';'.$row->StartDate.';'.$row->EndDate.';'. $row->TimeOn.';'. $row->TimeOff.';'. $row->Distribution.';'. $row->Bonus.';'.$row->Priority.';'. $row->UnitPrice.';'.$row->nWeeks.';'. $row->Value.';'.$total.';'.$row->ProgramName.';'.$row->StartDay.';'.$row->EndDay.';'
. $row->MakeGoods.';'. $row->MakeGoodDays.';'.$row->NOrdered.';'.$row->LineID).';'.PHP_EOL;				
				
				//$this->get_sale_item2($row->Line,$ss).
			  
				//'TOTAL;'.$total.';'.PHP_EOL;
				
			   }else if ($ss == 0){
				   
				$total = 
				$gd.';'.
				'0'.';'.
				'0'.';'.
				'0';
				
				             		
				$rolltext = $rolltext.($row->SL.';'.$row->Contract.';'.$row->Network.';'.$row->StartDate.';'.$row->EndDate.';'. $row->TimeOn.';'. $row->TimeOff.';'. $row->Distribution.';'. $row->Bonus.';'.$row->Priority.';'. $row->UnitPrice.';'.$row->nWeeks.';'. $row->Value.';'.$total.';'.$row->ProgramName.';'.$row->StartDay.';'.$row->EndDay.';'
. $row->MakeGoods.';'. $row->MakeGoodDays.';'.$row->NOrdered.';'.$row->LineID).';'.PHP_EOL;				
				//.'TOTAL;'.$total.';'.PHP_EOL;
					   }
				}
			return $rolltext;
		}	
	function GetDistributionAmount($aStartDate, $aEndDate, $Dist){
	 
      $uStartDate= strtotime($aStartDate);
	  $uEndDate = strtotime($aEndDate);
	  $ConvertDays = array(0,1,2,3,4,5,6);
	  //$xDist = str_replace("-", "", $Dist);
      
	  //$aDist = str_split($xDist);
       $aDist = explode('-',$Dist);
	  $totalSched = 0;
	   
	  	   while ($uStartDate <= $uEndDate){
		   		$ctr = date('w', $uStartDate);
		        $ConvertDayOfWeek = $ConvertDays[$ctr];
				$nPlaysToday = $aDist[$ConvertDayOfWeek];
				 $totalSched += $nPlaysToday;  
		   
		   $uStartDate = $uStartDate +(24*3600*1);
		   }
	 	 if ($totalSched == null || $totalSched == 0){
	 		 return "0";}
	 			 else {
	  		return $totalSched;	  
	 	}
	}
	
	function get_spotshown($seq,$sd,$ed){
	//$currentuser = $this->session->userdata('username');
	//$BMStartDate = $this->get_billingstartdate($currentuser);
//	$BMEndDate = $this->get_billingenddate($currentuser);
	
	$nsd = strtotime($sd." "."00:00:00");
	$ned = strtotime($ed." "."23:59:59");
 	$ts = date("Y-m-d H:i:s",$nsd);
	$te = date("Y-m-d H:i:s",$ned);
	
			  $query = $this->db->query("SELECT Seq
			  							 from `sale_item` 
										 WHERE `Seq`='". $seq."' and sale_item.status = 0
							 and (sale_item.Timestamp between "."DATE_FORMAT('". $ts."','%Y-%m-%d %H:%i:%s')". ' and ' ."DATE_FORMAT('".$te."','%Y-%m-%d %H:%i:%s'))");
	
			$c = 0; 
			if ($query->num_rows() > 0) {
					foreach ($query->result() as $row)
					{
		   			  $c++;
					  }
  				
				 return $c; 
			}
	}

	function get_sale_item2($line,$ss)
	{
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
									(si.status = 0 and si.Seq= "."'".$line."'". ')' );


		$rolltext= "";
	
		//$ctr = 0;
		
	  	
		foreach ($query->result() as $row) {
		
				$rolltext = $rolltext.($row->siT.';'.$row->siI.';'.$row->siS.';'.$row->siN.';'.$row->siL.';'.$row->siSe.';'. $row->siSt.';'.$row->siR.';'.$row->siSp.';'.PHP_EOL);
		 
			}
							
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



 function get_detail_new2($Seq,$aStartDate,$aEndDate){
	
	$BMStartDate = date('Y-m-d',strtotime($aStartDate));
    $BMEndDate = date('Y-m-d',strtotime($aEndDate));
	 
	 
	//$this->db->cache_on();
	
	$query = $this->db->query("Select Concat('SCHED;',Line) as SL, Line, Contract, Network, StartDate, EndDate, TimeOn, TimeOff, Distribution, Bonus,Priority, UnitPrice,nWeeks, Value, nSched, nPlaced, nPlayed, ActualValue, ProgramName,StartDay, EndDay, MakeGoods, MakeGoodDays,NOrdered, LineID from contract_detail as cd WHERE 
(STR_TO_DATE(REPLACE(StartDate,'/','-'), '%Y-%c-%d') >= "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate."'".') and ' ." cd.Contract  = "."'".$Seq. "'".''
."");
		$rolltext= "";
		$rolltext2 = "";
		$saleitem="";
		
		
		foreach ($query->result() as $row){
			  
			 // $gd = $this->GetDistributionAmount($row->StartDate,$row->EndDate, $row->Distribution);
			  $ConvertDays = array(0,1,2,3,4,5,6);
					 $aDist = explode('-',$row->Distribution);
	 				 $uStartDate = strtotime($row->StartDate);
					 $uEndDate = strtotime($row->EndDate);
					
					 $totalSched = 0;
	                 $ctr = 0;
	  	  				 while ($uStartDate <= $uEndDate){
		   					$ctr = intval(date('w', $uStartDate));
							
		      			  $ConvertDayOfWeek = $ConvertDays[$ctr];
							$nPlaysToday = $aDist[$ConvertDayOfWeek];
						 $totalSched += $nPlaysToday;  
		   
		 				  $uStartDate = $uStartDate +(24*3600*1);
		 					  }
	 				$gd =  $totalSched;
			 
			 
			 // $ss = $this->get_spotshown($row->Line,$row->StartDate,$row->EndDate);
			  
			     $sd = $row->StartDate;
				 $ed = $row->EndDate;
			 	$nsd = strtotime($sd." 00:00:00");
				$ned = strtotime($ed." 23:59:59");
 				$ts = date("Y-m-d H:i:s",$nsd);
				$te = date("Y-m-d H:i:s",$ned);
	
	          $seq1= $row->Line;
	
			  $query2 = $this->db->query("SELECT Seq
			  								
			  							 from `sale_item` 
										 
 			  						
			  				WHERE `Seq`='". $seq1."' and sale_item.status = 0
							 and (sale_item.Timestamp between "."DATE_FORMAT('". $ts."','%Y-%m-%d %H:%i:%s')". ' and ' ."DATE_FORMAT('".$te."','%Y-%m-%d %H:%i:%s'))
							"
				
				);
	
				$c = 0; 
				if ($query2->num_rows() > 0) {
		
					foreach ( $query2->result() as $row2)
						{
		   				  $c++;
	
					}
			  
				}
				$ss = $c;
			  
			  
			  
			  if($ss > 0){
				$total = 
				$gd.';'.
				$gd.';'.
				$ss.';'.
				$ss * ($row->Value);
				
				             		
				$rolltext = $rolltext.($row2->SL.';'.$row2->Contract.';'.$row2->Network.';'.$row2->StartDate.';'.$row2->EndDate.';'. $row2->TimeOn.';'. $row2->TimeOff.';'. $row2->Distribution.';'. $row2->Bonus.';'.$row2->Priority.';'. $row2->UnitPrice.';'.$row2->nWeeks.';'. $row2->Value.';'.$total.';'.$row2->ProgramName.';'.$row2->StartDay.';'.$row2->EndDay.';'
. $row2->MakeGoods.';'. $row2->MakeGoodDays.';'.$row2->NOrdered.';'.$row2->LineID).';'.PHP_EOL				
							
				
				.$this->get_sale_item2($row2->Line).
				
			  
			'TOTAL;'.$total.';'.PHP_EOL;
				
			//'TOTAL;'.$total.';';
				
			   }else {
				   
				   $total = 
				$gd.';'.
				$gd.';'.
				'0'.';'.
				'0';
				
				             		
				$rolltext = $rolltext.($row2->SL.';'.$row2->Contract.';'.$row2->Network.';'.$row2->StartDate.';'.$row2->EndDate.';'. $row2->TimeOn.';'. $row2->TimeOff.';'. $row2->Distribution.';'. $row2->Bonus.';'.$row2->Priority.';'. $row2->UnitPrice.';'.$row2->nWeeks.';'. $row2->Value.';'.$total.';'.$row2->ProgramName.';'.$row2->StartDay.';'.$row2->EndDay.';'
. $row2->MakeGoods.';'. $row2->MakeGoodDays.';'.$row2->NOrdered.';'.$row2->LineID).';'.PHP_EOL				
				.'TOTAL;'.$total.';'.PHP_EOL;

					   }
				}
				 return $rolltext;
		}
	

	
}

?>

