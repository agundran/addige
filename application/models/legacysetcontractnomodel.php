<?php

class Legacysetcontractnomodel extends CI_Model{

	private $table_name='broadcast_calendar';
	
	function __construct(){
	parent::__construct();
	$this->load->dbutil();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column, $order_type='desc'){
		
		
	$data['currentuser'] = $this->session->userdata('username');
	$myuser = $data['currentuser'];
	$astartdate = $this->get_billingstartdate($myuser);
	$aenddate = $this->get_billingenddate($myuser);
	$cm = $this->get_currentmonth($myuser);
	$BMStartDate = date('Y-m-d',strtotime($astartdate));
	$BMEndDate = date('Y-m-d',strtotime($aenddate));
		
		
		
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by('Year','desc');
		}
		else{
	  		$query = $this->db->query("SELECT 
								DISTINCT(c1.Seq) as c1Se,
								so.SysCode as c1SN, 
								c1.ContractName as c1C,
								
								c1.StartDate as c1S, 
								c1.EndDate as c1E
								
								
								FROM `contract_header` AS c1 
								INNER JOIN `registration` AS r1 ON c1.SiteName = r1.SiteName 
								INNER JOIN `site_operators` AS so ON c1.SiteName = so.SiteName 
								WHERE 
								
								
								c1.Seq like '".$order_column."%' and 
								
								
((STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') < "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >="."'".$BMStartDate."'".' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <= "."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d')  <"."'".$BMEndDate."'". ' and' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') <"."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".'))  ' );

		return $query;
		
		}
	}

	
	
	function get_site() { 		
	  		$sql = "SELECT so.SysCode, so.SiteName, concat(so.SysCode,' -  ' , so.SiteName) as mysite FROM site_operators as so INNER JOIN registration as re ON (so.SiteName = re.SiteName) WHERE (re.Active = 1)
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
	
		function count_all($order_column, $BMStartDate, $BMEndDate){
	//$aStartDate = date('Y-m-d',strtotime('2015-01-01'));
	
	$this->db->query("SELECT 
								DISTINCT(c1.Seq) as c1Se,
								so.SysCode as c1SN, 
								c1.ContractName as c1C,
								
								c1.StartDate as c1S, 
								c1.EndDate as c1E
								
								
								FROM `contract_header` AS c1 
								INNER JOIN `registration` AS r1 ON c1.SiteName = r1.SiteName 
								INNER JOIN `site_operators` AS so ON c1.SiteName = so.SiteName 
								WHERE 
								
								
								c1.Seq like '".$order_column."%' and 
								
								
((STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <="."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') < "."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >="."'".$BMStartDate."'".' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  <= "."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') >="."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d')  <"."'".$BMEndDate."'". ' and' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".')'." or "."
(STR_TO_DATE(REPLACE(c1.StartDate,'/','-'), '%Y-%c-%d') <"."'".$BMStartDate. "'". ' and ' ." STR_TO_DATE(REPLACE(c1.EndDate,'/','-'), '%Y-%c-%d')  >"."'".$BMEndDate. "'".'))  ' );

						 
	return $this->db->count_all_results();
	
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
		
		$sql = "SELECT so.SysCode, so.SiteName, concat(so.SysCode,' -  ' , so.SiteName) as mysite FROM site_operators as so INNER JOIN registration as re ON (so.SiteName = re.SiteName) WHERE (re.Active =1)
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

