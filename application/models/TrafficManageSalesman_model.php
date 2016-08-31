<?php

class TrafficManageSalesman_model extends CI_Model{

	private $primary_key='Seq';
	private $table_name='salesman';
	
	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $filter){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by($this->primary_key,'asc');
	}
	else{
	  
					   
		//$this->db->order_by($order_column,$order_type);
		///return $this->db->get($this->table_name, $limit, $offset);
		
		$query = $this->db->select('*')
                        ->from('salesman')
                       // ->join('usersinroles', 'users.Username= usersinroles.Username')
					   ->order_by($order_column, $order_type)
						->like('salesman.Name', $filter, 'after')
                        ->get('', $limit, $offset);
		return $query;
		
		}
	}

	
	
	function create_salesman(){			
				
		$new_member_insert_data= array(
				'Name' => $this->input->post('Name'),
				'Rate' => $this->input->post('Rate'),
				'Address1' => $this->input->post('Address1'),
				'Address2' => $this->input->post('Address2'),
				'City' => $this->input->post('City'),
				'State' => $this->input->post('State'),
				'Zip' => $this->input->post('Zip'),
				'Telephone' => $this->input->post('Telephone')
				);
		
	
				//$insert = 
				$this->db->insert('salesman',$new_member_insert_data );
				
				return ;
		}
		
		
	function count_all(){
	return $this->db->count_all($this->table_name);
	}

	function get_by_id($id){
	$this->db->where($this->primary_key,$id);
	return $this->db->get($this->table_name);
	}

	function save($person){
	$this->db->insert($this->table_name,$person);
	return $this->db->insert_id();
	}

	function update($id,$User){
	$this->db->where($this->primary_key,$id);
	$this->db->update($this->table_name,$User);
	}

	function delete($id){
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
	}


	
}

?>

