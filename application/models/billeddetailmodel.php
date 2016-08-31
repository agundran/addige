
<?php

//ini_set('memory_limit', '2048M');
    ini_set('memory_limit', '2048M');
    ini_set('max_execution_time', '5000');
	set_time_limit(5000);
	ini_set("display_errors", "on");
	
class Billeddetailmodel extends CI_Model{
	 // $this->db->start_cache();

	function __construct(){
	parent::__construct();
	}


 
function get_paged_list(){
	
	
	$currentuser = $this->session->userdata('username');
   	$StartDate= $this->get_billingstartdate($currentuser);
	$EndDate = $this->get_billingenddate($currentuser);
   $BMStartDate = date('Y-m-d',strtotime($StartDate)) or date('Y/m/d',strtotime($StartDate));
 $BMEndDate = date('Y-m-d',strtotime($EndDate)) or date('Y/m/d',strtotime($EndDate));
	    
		    // $this->db->cache_on();
			$query = $this->db->query("SELECT 
							      DISTINCT c1.Seq as t2S,
								  so.SysCode as sCO,
    							  cu.Name as t2SC,
								  
								  c1.ContractName as chCN
								  
								  
								  
  								FROM
								 contract_header as c1
								
								 INNER JOIN customers as cu ON (c1.CIndex = cu.Seq)
								 INNER JOIN site_operators AS so ON (c1.SiteName = so.SiteName)
								 INNER JOIN registration as re on (so.SiteName = re.SiteName) 
								 
        						
								
								WHERE 
								re. Active = 1 and
														
								
							
((STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') < "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >="."'".$BMStartDate."'".' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <= "."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d')  <"."'".$BMEndDate."'". ' and' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') <"."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')) 
' 
)   ;
								
		return $query;

}


function get_contract_details($order_column, $bStartDate, $bEndDate){
		

			  // $this->db->cache_on();
			  $query = $this->db->query("SELECT t1.Line AS t1L,
			  									t1.Contract AS t1C, 
												t1.Distribution AS t1D, 
										        t1.StartDate AS t1S,
											    t1.EndDate AS t1E,
												(t1.UnitPrice/100) AS t1U,
												t2.StartDate AS t2SD,
												t2.EndDate AS t2ED 
												
		  
									FROM (`contract_header` AS t2) 
			  						JOIN  `contract_detail` AS t1 ON `t2`.`Seq` = `t1`.`Contract`
	           
									WHERE 	
								
								
								(t2.Seq = "."'". $order_column."')   " );
   
	  $sc = 0;
	    if ($query->num_rows() > 0) {
		foreach ( $query->result() as $row){
		
		//$ec = $this->getDistribution( $row->t1S, $row->t1E, $row->t1D);
			
	  $StartDate= strtotime($row->t1S);
	  $EndDate = strtotime($row->t1E);
	  $Dist = $row->t1D;
	 
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
	  $totalSched = 0;
	   
	  	   while ($uStartDate <= $uEndDate){
		   		$ctr = date('w', $uStartDate);
		        $ConvertDayOfWeek = $ConvertDays[$ctr];
				$nPlaysToday = $aDist[$ConvertDayOfWeek];
				 $totalSched += $nPlaysToday;  
		   
		   $uStartDate = $uStartDate +(24*3600*1);
		   }
			$sc +=  $totalSched;
		  
			}
		//return $row->t1D;
          return $sc;  
		}
		

}



function count_billed_spots($seq,$sd,$ed){
	
	$nsd = strtotime($sd."00:00:00");
	$ned = strtotime($ed."23:59:00");
 	$ts = date("Y-m-d H:i:s",$nsd);
	$te = date("Y-m-d H:i:s",$ned);
	//$this->db->cache_on();
			  $this->db->select("Line")
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

	
	
	}

*/
}


function get_spotbilled($order_column, $bStartdate, $bEnddate){
	//$currentuser = $this->session->userdata('username');
	//$BMStartDate = $this->get_billingstartdate($currentuser);
	//$BMEndDate = $this->get_billingenddate($currentuser);
	//$bStartdate = date('Y/n/d',strtotime($BMStartDate));
	//$bEnddate = date('Y/n/d',strtotime($BMEndDate));
	
	$nsd = strtotime($bStartdate." 00:00:00");
	$ned = strtotime($bEnddate." 23:59:59");
 	$ts = date("Y-m-d H:i:s",$nsd);
	$te = date("Y-m-d H:i:s",$ned);
	
			//$this->db->cache_on();
			  $query = $this->db->query("SELECT t1.Line AS t1L,
			  								
												t2.StartDate AS t2SD,
												t2.EndDate AS t2ED 
												
		  
									FROM (`contract_detail` AS t1) 
			  						JOIN  `contract_header` AS t2 ON `t1`.`Contract`=`t2`.`Seq` 
	           					
									
									WHERE 	
								(t2.Seq = "."'". $order_column."')   " );

  //(t2.Seq = "."'". $order_column."' and (t1.StartDate >= "."'".$bStartdate."' and t1.EndDate  <=    "."'". $bEnddate."'   ))   " );     
	  $sc = 0;
	  $c = 0;
	    if ($query->num_rows() > 0) {
		foreach ( $query->result() as $row){
			 $this->db->cache_on();
			 $query2 = $this->db->query("SELECT Seq 								
			  							 from `sale_item` 
			  							WHERE `Seq`='".$row->t1L."' and sale_item.status = 0
										 and (sale_item.Timestamp between "."DATE_FORMAT('".$ts."','%Y-%m-%d %H:%i:%s')". ' and ' ."DATE_FORMAT('".$te."','%Y-%m-%d %H:%i:%s'))");
			            
					foreach ( $query2->result() as $row2)
					{
		         		$c++;
					}
			 
		      
                   }               
				return $c;
		}
		
	
	}


function get_gross($order_column, $bStartdate, $bEnddate){
	
	$nsd = strtotime($bStartdate." 00:00:00");
	$ned = strtotime($bEnddate." 23:59:59");
 	$ts = date("Y-m-d H:i:s",$nsd);
	$te = date("Y-m-d H:i:s",$ned);
	
	  $sc = 0.00;
	  $c = 0;
	  $ig = 0.00;
	  $up =0.0;
				//$this->db->cache_on();
			  $query = $this->db->query("SELECT t1.Line AS t1L,
			  								    (t1.UnitPrice/100) AS t1U,
												t2.StartDate AS t2SD,
												t2.EndDate AS t2ED 
										FROM (`contract_detail` AS t1) 
			  							JOIN  `contract_header` AS t2 ON `t1`.`Contract`=`t2`.`Seq` 
	           							WHERE (t2.Seq = "."'". $order_column."')   " );

	     		foreach ($query->result() as $row){
					
					    //   $this->db->cache_on();
						  $query2 = $this->db->query("SELECT Seq 								
			  										from `sale_item` 
										 			WHERE `Seq`='".$row->t1L."' and sale_item.status = 0
													 and (sale_item.Timestamp between "."DATE_FORMAT('".$ts.
													 "','%Y-%m-%d %H:%i:%s')". ' and ' ."DATE_FORMAT('".$te.
													 "','%Y-%m-%d %H:%i:%s'))");
			              $c = 0;
							foreach ($query2->result() as $row2)
								{
		         	  				$c++;
								//count spot shown
				    			}
			       		 
		          		 $sc = $c * $row->t1U;	
					     $ig = $ig + $sc;
				      				  
					}
			
	              // $this->db->cache_off();
			 return $ig;
		
		
	}





function get_contract_uprice($order_column){
		
	           
			  $query = $this->db->query("SELECT t1.Line AS t1L,
			  									
												(t1.UnitPrice/100) AS t1U
									FROM (`contract_header` AS t2) 
			  						JOIN  `contract_detail` AS t1 ON `t2`.`Seq` = `t1`.`Contract`
	           
									WHERE 	
								(t2.Seq = "."'". $order_column."')   " );

   
	  $sc = 0;
	    if ($query->num_rows() > 0) {
		foreach ( $query->result() as $row){
				
			//$sc += $ec;
			 return $row->t1U;   
			}
		//return $row->t1D;

		}
		

}








function computepersitenet($SiteName, $StartDate, $EndDate){
	
    $query = $this->filter_contractno($SiteName,$StartDate, $EndDate);
    $sc = 0.00;
		
	if ($query->num_rows() > 0) {
		foreach ( $query->result() as $row){
				$ec = $this->ComputeNet($row->c1Se,$this->ComputeShownValue($row->c1Se, $StartDate,$EndDate));
				$sc += $ec;
			
				}
			
			}
	
		return $sc;

}



function ComputeShownValue($ContractNo,$sd,$ed){
		//$this->db->cache_on();
		$query = $this->db->query("SELECT 
								Line,
								StartDate, 
								EndDate,
								
								UnitPrice
								
								FROM contract_detail
							 
								WHERE 
						(Contract = "."'".$ContractNo."'". ')'
												." and "."

												(StartDate >="."'".$sd. "'". ' && ' ." EndDate  <="."'".$ed. "'".')'
												 );
	$c = 0;
	$cv = 0.00;
	if ($query->num_rows() > 0) {
	foreach ( $query->result() as $row)
			{
				
				
		    //$cv =  $row->UnitPrice;
			
			
			$cv =  $row->UnitPrice * $this->get_spotshown($row->Line,$row->StartDate,$row->EndDate);
			
			
		    $c += $cv;
			
			
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
	



	
	
	function count_all(){
			//$this->db->cache_on();
			$this->db->select('t1.SiteName, t1.SysCode, ')
					->from('site_operators as t1')
					->join ('registration as t3','t1.SiteName= t3.SiteName' )
					->join('clients as t2','t1.SiteName = t2.ShortName')
					->where ('t3.Active',1);
						 
	return $this->db->count_all_results();
	
	}
	
function get_contract_discount($contractno){
		$this->db->select('Discount');
		$this->db->where('Seq', $contractno);
			$query = $this->db->get('contract_header');
           // $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->Discount;
			return $rolltext;  
	}	
	
function get_contract_agencycomm($contractno){
		$this->db->select('AgencyComm');
		$this->db->where('Seq', $contractno);
			$query = $this->db->get('contract_header');
           // $result = $query->result();  //  returns the query result as an array of objects
 			$result = $query->row(); // returns a single result row
 			$rolltext = $result->AgencyComm;
			return $rolltext;  
	}		




	function count_sitename_active(){
	
	$query = $this->db->query("SELECT  SiteName 
								from registration
								where Active = 1");
								
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
		
		
   	function update($id,$data){
		$this->db->where('UserName',$id);
		$this->db->update('current_month',$data);
	}

}

?>