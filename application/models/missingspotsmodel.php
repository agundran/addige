<?php

class Missingspotsmodel extends CI_Model{


	
	function __construct(){
	parent::__construct();
	}

	
function get_paged_list($limit, $offset=0, $order_column='', $order_type='asc', $filter){
		
		if(empty($order_column)||empty($order_type))
		{$this->db->order_by($this->primary_key,'asc');
		}
		else {
	
	
			if ($filter == null){
			//$today = date("Y-m-d", strtotime("-1 days"));
			$today = date("Y-m-d");
	
				} else {
			$today = date("Y-m-d", strtotime("$filter days"));
		
			}
			$bdate = date("2016-01-01");
		
			$query = $this->db->query("SELECT 
									AM.mis_id as mid,
									SO.SysCode as sos,
									sum(AM.Attempts) as ama,
									AM.SiteName as ams,
									AM.Date as amd,
									AM.Network as amn, 
							
								AM.Seq as amsq, 
								AM.SpotName as amsn,
									AM.Contract as amc
								
									
								
								FROM  missing_spots AS AM	
								INNER JOIN `registration` AS AR ON AM.SiteName = AR.SiteName 
								INNER JOIN `site_operators` AS SO ON AM.SiteName = SO.SiteName 
								 
								
								WHERE 
								 
								STR_TO_DATE(AM.Date, '%Y-%c-%d')
								=
								"."'".$today."'".' 
								 
								GROUP BY SpotName, SysCode, Date
								ORDER BY Syscode, Date DESC ');
								
			//INNER JOIN `contract_header` AS HE ON AM.Contract = HE.Seq 
	 
	 //	AM.Seq as amsq, 
		//							AM.SpotName as amsn,
		//							AM.Contract as amc, 
								
		//							HE.ContractName as hec

    			 return $query;

		}
	}

	
	
	
		
		
	function count_all(){
	$today = date("Y-m-d", strtotime("-1 days"));		
	$bdate = date("2016-01-01");
	$query = $this->db->query("SELECT 
								AM.SiteName as ams,
								AM.Date as amd,
								sum(AM.Attempts) as ama
								FROM  missing_spots AS AM	
								INNER JOIN `registration` AS AR ON AM.SiteName = AR.SiteName 
								INNER JOIN `site_operators` AS SO ON AM.SiteName = SO.SiteName 
									WHERE 
								
								STR_TO_DATE(AM.Date, '%Y-%c-%d')
								BETWEEN
								"."'".$bdate."'". ' AND '."
								"."'".$today."'".'
								GROUP BY  SpotName, SysCode
								') ;
								
	//return $this->db->count_all_results();
	//$result = $query->row_array();
//	$count = $result['COUNT(*)'];
	
	return $query->num_rows(); 
	}

	


	
}

?>

