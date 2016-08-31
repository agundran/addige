<?php

class Monthlycalendarmodel extends CI_Model{

	private $table_name='monthly_calendar';
	
	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='Year', $order_type='desc',$filter){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by('Year','desc');
	}
	else{
	  		$query = $this->db->select('*')
                        ->from('monthly_calendar')
						->order_by('Year','desc')
						->order_by('Month','asc')
                        ->like('Year', $filter, 'after')
                        ->get('', $limit, $offset); 
					   
				return $query;
		
		}
	}

	
	
	function create_calendar($year,$month,$startweek,$endweek,$startdate,$enddate){			
				
		$new_calendar_data= array(
				'Year' => $year,
				'Month' => $month,
	 			'Start_Week' => $startweek,
				'End_Week' => $endweek,
				'Start_Date' => $startdate,
				'End_Date' => $enddate
				);
			
		
	
				//$insert = 
				$this->db->insert($this->table_name,$new_calendar_data);
				
				return ;
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

