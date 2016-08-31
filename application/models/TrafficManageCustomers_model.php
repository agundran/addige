<?php

class TrafficManageCustomers_model extends CI_Model{

	private $primary_key='Seq';
	private $table_name='customers';
	
	function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $filter){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by($this->primary_key,'asc');
	}
	else{
	  
					   
		//$this->db->order_by($order_column,$order_type);
		//return $this->db->get($this->table_name, $limit, $offset);
		
		$query = $this->db->select('*')
                        ->from('customers')
                       // ->join('usersinroles', 'users.Username= usersinroles.Username')
					   ->order_by($order_column, $order_type)
						->like('customers.Name', $filter, 'after')
                        ->get('', $limit, $offset); 	
					   
		
		
		return $query;
		
		}
	}

	
	
	function create_customers($Cname, $Address1, $Address2, $City, $StateUpper, $Zip, $Telephone, $Discount, $EBill, $Bonus){			
				
		$new_member_insert_data= array(
				'Name' => $Cname,
				'Address1' => $Address1,
				'Address2' => $Address2,
				'City' => $City,
				'State' => $StateUpper,
				'Zip' => $Zip,
				'Telephone' => $Telephone,
				'Discount' => $Discount,
				'EBill' => $EBill,
				'Bonus' => $Bonus
				);
		
	
				//$insert = 
				$this->db->insert('customers',$new_member_insert_data );
				
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

	function update($id,$Cname, $Address1, $Address2, $City, $StateUpper, $Zip, $Telephone, $Discount, $EBill, $Bonus){
	$this->db->where($this->primary_key,$id);
	
	
	
	$new_member_update_data= array(
				'Name' => $Cname,
				'Address1' => $Address1,
				'Address2' => $Address2,
				'City' => $City,
				'State' => $StateUpper,
				'Zip' => $Zip,
				'Telephone' => $Telephone,
				'Discount' => $Discount,
				'EBill' => $EBill,
				'Bonus' => $Bonus
				);
	
	
	
	$this->db->update($this->table_name,$new_member_update_data);
	}

	function delete($id){
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
	}


	
}

?>

