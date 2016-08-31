<?php

class Detailentryencodemodel extends CI_Model{

	private $primary_key='SiteName';
	private $primary_key3='Line';
	
	private $table_name='contract_header';  
	private $table_name3='contract_detail'; 

	
	
	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list()
	{
		$query = $this->db->select('*')
                      ->from ('contract_header')
             		->join('agencies', 'contract_header.AIndex= agencies.Seq','inner')
					->join('salesman', 'contract_header.SIndex= salesman.Seq','inner')
					->join('customers', 'contract_header.CIndex= customers.Seq','inner')
					 ->get(); 
		
			return $query;

	}
	
	
	function get_site_network($mysiteoperator) { 		
			//$sql = "SELECT Network FROM network_mapping WHERE SiteName LIKE "."'"$mysiteoperator."'";
			
			//SELECT * FROM `network_mapping` WHERE `SiteName` LIKE 'CHA0525110081' 
			$query = $this->db->select('Network')
                              ->from ('network_mapping')
							  ->where ('SiteName',$mysiteoperator)
							  ->get(); 	
			
			//$query=$this->db->query($sql);
			$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->Network] = $item->Network;
	    				}
      		return $options;	
		}
	
    	function GetDistributionString($dmo,$dtu,$dwe,$dth,$dfr,$dsa,$dsu){
		
		$distribution = $dmo."-".$dtu."-".$dwe."-".$dth."-".$dfr."-".$dsa."-".$dsu;
		
		return 	$distribution;
		
		}
		
		
		function AddDistribution($dmo,$dtu,$dwe,$dth,$dfr,$dsa,$dsu){
		
		$distribution = $dmo + $dtu + $dwe + $dth + $dfr + $dsa + $dsu;
		
		return 	$distribution;
		
		}
		//CODE WITH STARTDAY AND END DAY ACCORDING TO BOSS REMOVE STARTDAY AND END DAY
			//UPDATED BY: REYNAN			
		//function CalculateLineValue($dmo,$dtu,$dwe,$dth,$dfr,$dsa,$dsu,$UnitPrice,$StartDate,$EndDate,$StartDay,$EndDay){
			//WITHOUT STARTDATE & ENDDAY
		function CalculateLineValue($dmo,$dtu,$dwe,$dth,$dfr,$dsa,$dsu,$UnitPrice,$StartDate,$EndDate){
		
		//if($StartDay != 6)
		//{
			//$StartDay = $StartDay + 1;
		//} 
		//elseif ($StartDay == 6)
		//{
			//$StartDay = 0;
		//}
		
		$ConvertDays = array(0,1,2,3,4,5,6);
		
		$nWeeks =  $this->GetContractWeeks($StartDate,$EndDate);
		
			$bStartDate = strtotime($StartDate);
			$bEndDate = strtotime($EndDate);
		
			$c1StartDate = date('Y-M-d 00:00:00', $bStartDate);
			$c1EndDate = date('Y-M-d  23:59:59',$bEndDate);
		
		     $cStartDate = new DateTime($c1StartDate);
			 $cEndDate = new DateTime($c1EndDate);		      
		 
		    
		
	    // $cStartDate = $cStartDate->modify('+'.$StartDay.' day');
		 
		 //$date->modify('+3 day');	
		// $cEndDate = $cEndDate->modify('+'.-1 * (6 - $EndDay).' day');
		
		$aDistribution = array($dmo,$dtu,$dwe,$dth,$dfr,$dsa,$dsu);
		
		$TotalPrice = 0;
			while ($cStartDate <= $cEndDate){
				//$ConvertedDayofWeek = $ConvertDays[$cStartDate->format('w')];
				$nPlaysToday = $aDistribution[$cStartDate->format('w')];
				$TotalPrice +=$nPlaysToday * $UnitPrice;
				$cStartDate = $cStartDate->modify('+1 day'); 
				
			}
		
		
		return  $TotalPrice;
		}
		
		
			
			
		function GetContractWeeks($StartDate,$EndDate){
			$nWeeks = 0;
			$aStartDate = strtotime($StartDate);
			$aEndDate = strtotime($EndDate);
			
			while ( date('Y-m-d',strtotime($StartDate)) < date('Y-m-d',strtotime($EndDate))){
				$StartDate = date('Y-m-d',strtotime($StartDate) + (24*3600*7));
				$nWeeks++;		
				}
			
			   return $nWeeks;
			}	
			
		function GetMakeGoodDays($gdmo,$gdtu,$gdwe,$gdth,$gdfr,$gdsa,$gdsu){
					
		$mask= 0;
		
		if ($gdmo == 1)
		$mask+=1; 
	
		if ($gdtu == 1)
		$mask+=2; 
	
		if ($gdwe == 1)
		$mask+=4; 
	
		if ($gdth == 1)
		$mask+=8; 
	
		if ($gdfr == 1)
		$mask+=16; 
	
	
		if ($gdsa == 1)
		$mask+=32; 
	
		if ($gdsu == 1)
		$mask+=64; 
	
		
		return $mask;
	
	
		 }
		 //CODE WITH STARTDAY, END DAY &  BONUS ACCORDING TO BOSS REMOVE STARTDAY ,END DAY & BONUS
			//UPDATED BY: REYNAN
		 //function create_networksched($ContractNo,$NetworkName,$StartDate,$EndDate, $StartDay, $EndDay, $TimeOn, $TimeOff, $Distribution, $MakeGoodDays, $Bonus, $UnitPrice, $Priority, $ProgramName, $Value, $nWeeks){
			 
		//WITHOUT STARTDATE, ENDDAY & BONUS	 
		function create_networksched($ContractNo,$NetworkName,$StartDate,$EndDate, $TimeOn, $TimeOff, $Distribution, $MakeGoodDays, $UnitPrice, $Priority, $ProgramName, $Value, $nWeeks)
		{
			
			$NewSchedData = array(
				   			
					'Contract'=>$ContractNo,
					//correct this later to 'Network'=>$NetworkName,
					'Network'=>$NetworkName,
					
					'StartDate'=>$StartDate,
					'EndDate'=>$EndDate,
					//'StartDay'=>$StartDay,
					//'EndDay'=>$EndDay, 			
					'TimeOn'=>$TimeOn,  
					'TimeOff'=>$TimeOff,
					'Distribution'=>$Distribution,
					'MakeGoodDays'=>$MakeGoodDays,
					'UnitPrice'=>$UnitPrice,
					'Priority'=>$Priority,
					'ProgramName'=>$ProgramName,
					'Value'=>$Value,
					//'nWeek'=>$nWeeks,
					//for testing correct later
					'nWeeks'=>$nWeeks
					
					 
					//'Bonus'=>$Bonus, 
					
					
					
									
				);
		         
											
				//$insert = 
				$this->db->insert('contract_detail',$NewSchedData);
				
				return ;
			
			
			}
		
		
		function get_detail_startdate($mycontract) { 
		
		   				
			$this->db->select('StartDate');
    		$this->db->where('Seq',$mycontract);
			//$this->db->like('Start_Date','$Stoday', 'after');
    		$query=$this->db->get('contract_header');
      		$result = $query->result();
     		$drop_menu_operator_name = array();
			foreach($result as $item){
        			$options[$item->StartDate] = $item->StartDate;
      				}
      		return $options;
		}
		
	//	function get_by_id($id){	
	
		//				
	//}

	function get_by_id($id){
	$this->db->where('Line',$id);
	return $this->db->get('contract_detail');
	}
	
	//GET DISTRIBUTION
	function get_by_distribution($id){
	
	
	$this->db->select('Distribution')                        
				->where('Line',$id);
				return $this->db->get('contract_detail');
				
			
				
	}
	
	
	function splitDistributionString($splitDis){
	
	
	//$varDis = (string)$splitDis;
  	//$xDist = str_replace("-", "", $varDis);
      
	  //$aDist = str_split($xDist);
			
			
			 //return (string)$splitDis;	 
				
	}
	
	function update($id,$myedit)
	{
	$this->db->where($this->primary_key3,$id);
	$this->db->update($this->table_name3,$myedit);
	}

		 
}	




?>

