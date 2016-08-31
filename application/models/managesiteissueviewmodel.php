<?php

class Managesiteissueviewmodel extends CI_Model{

	private $primary_key='Seq';
	private $table_name='cases';
	
	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $filter, $orderby ){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by($this->primary_key,'asc');
	}
	else{
	  	$query = $this->db->select('*')
                        ->from('cases')
                        //->join('clients', 'cases.SiteName = clients.ShortName')
						->where('SiteName',$orderby)
						//->like('clients.ShortName', $filter, 'after')
                        ->get('', $limit, $offset); 
					   
		//$this->db->order_by($order_column,$order_type);
		//return $this->db->get($this->table_name, $limit, $offset);
		return $query;
		
		}
	}

	
	
	function save_create_case($Date, $Originator,$Status, $Sitename,$Description){			
				$User= array(				
				'Date' => $Date,			
				'Originator' => $Originator,				
				'Status' => $Status,
				'SiteName' => $Sitename,
				'Description' => $Description
								
				);							
				$this->db->insert('cases',$User);
				return ;
		}
		
	function update_case($id,$Date,$SiteName, $Originator, $Status, $Description){
		
			$User= array(				
				'Date' => $Date,			
				'Originator' => $Originator,				
				'Status' => $Status,
				'SiteName' => $Sitename,
				'Description' => $Description);
		
		$this->db->where('Seq',$id);
		$this->db->update('cases',$User);
	
				return ;
		
		}
		
	function close_case($Seq,$Status){
		
						
		$User= array(				
				'Status' => $Status);
					
		$this->db->where('Seq',$Seq);
		$this->db->update('cases',$User);
	
				return ;
		
		}	
		
	function count_all(){
	return $this->db->count_all($this->table_name);
	
	}
	
	function count_all_open($orderby){
		$this->db->from('cases')
                          //->join('clients', 'cases.SiteName = clients.ShortName')
						->where('SiteName',$orderby);
	
	return $this->db->count_all_results();
	
	}

	function get_by_id($id){
		
	$this->db->where($this->primary_key,$id);
	return $this->db->get($this->table_name);
	
	}
	function get_by_id_edit($id){
	$this->db->where('Seq',$id);
	return $this->db->get('cases');
	}
	
	
	function save($person){
	$this->db->insert($this->table_name,$person);
	return $this->db->insert_id();
	}

	function update($id,$user){
	$this->db->where('Seq',$id);
	$this->db->update('cases',$user);
	}

	function delete($id){
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
	}

   function status_change($value){
		
		if ($value==1){
			$myvalue = "Close";
			} elseif($value == 0){
			$myvalue= "Open";
		}
	return $myvalue;
	}
	
}

?>

