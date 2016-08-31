<?php

class BillingSetInvoicingMonth_model extends CI_Model{

	private $primary_key='Start_Date';
	private $table_name='broadcast_calendar';
	
	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='Year', $order_type='desc'){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by('Year','desc');
	}
	else{
	  		$query = $this->db->select('*')
                        ->from('broadcast_calendar')
						->order_by('Year','desc')
						->order_by('Month','asc')
                       // ->like('Year', $filter, 'after')
                        ->get('', $limit, $offset); 
					   
				return $query;
		
		}
	}

	
	function create_user($username,$year,$month){
		
		$new_data= array(
				'Year' => $year,
				'Month' => $month,
	 			'UserName' => $username);
		
		$this->db->insert('current_month',$new_data);
				
				return ;
		
		}
	
	function get_sd($year,$month){
		$query = $this->db->select('Start_Date')
						->from('broadcast_calendar')
						->where('Year',$year)
						->where('Month',$month)
						
						->get();
		
			return $query;
		}
		
		
			function get_ed($year,$month){
		$query = $this->db->select('End_Date')
						->from('broadcast_calendar')
						->where('Year',$year)
						->where('Month',$month)
						
						->get();
		
			return $query;
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
   
	
	function count_all(){
	return $this->db->count_all($this->table_name);
	}

	function get_by_id($id){
	$this->db->where('UserName',$id);
	return $this->db->get('current_month');
	}

	function save($person){
	$this->db->insert($this->table_name,$person);
	return $this->db->insert_id();
	}

	function update($id,$data){
	$this->db->where('UserName',$id);
	$this->db->update('current_month',$data);
	}

	
	function delete($id){
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
	}

	function user_exists($user)
	{
    $this->db->where('UserName',$user);
    $query = $this->db->get('current_month');
    if ($query->num_rows() > 0){
        return true;
    }
    else{
        return false;
    }
}
	
}

?>

