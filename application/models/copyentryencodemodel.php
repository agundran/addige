<?php

class Copyentryencodemodel extends CI_Model{

	private $primary_key='Seq';
	private $table_name='contract_copy';  

	
	
	function __construct(){
	parent::__construct();
	}

	function get_by_id($id){	
							$this->db->select('*')                        
							->where('Seq',$id);
					
	return $this->db->get($this->table_name);
	}
	
function deletetheexistingcopy($Contract)
{
				$this->db->where('Contract',$Contract);
				$this->db->delete('contract_copy');
	
	
}
function combinecontractsandcopy($Contract, $seq)
{
			$query = $this->db->query("Select * from contract_copy WHERE Contract = '.$seq.'");

			foreach ($query->result() as $row)
			{
   				echo $row->StartDate;
   				echo $row->EndDate;
   				echo $row->SpotName;
				echo $row->Weighting;
				echo $row->SpotLength;
				echo $row->Network;
				

   				$id = $this->copyentryencodemodel->insert($Contract,$row->StartDate,$row->EndDate,$row->SpotName,$row->Weighting,$row->SpotLength,$row->Network);
				
				
			}
			
				
		
		
}


function insert($Contract,$StartDate,$EndDate,$SpotName,$Weighting,$SpotLength,$Network){			
				
				
				$SD = '0';
				$ED = '6';
				$ND = '1';
		$new_member_insert_data= array(
			
				
				
					'Contract' => $Contract,
					'StartDate' => $StartDate,
					'EndDate' => $EndDate,
					'StartDay' => $SD,
					'EndDay' => $ED,
					'NewDate' => $ND,
					'SpotName' => $SpotName,
					'Weighting' => $Weighting,
					
					'SpotLength' => $SpotLength,
					
					
				
					'Network' => $Network,
	
					
				
				
				
				
				
				
				
				
				);
		
	
				//$insert = 
				$this->db->insert('contract_copy',$new_member_insert_data );
				
				return ;
				
				
				
		}
	
	
function contractdetails($seq){
		$query1 = $this->db->select('*')
						->from('contract_copy')
						->where('Contract',$seq)
						->get();
		
		return $query1;
		
		}
	
	function update($id,$data){
			$this->db->where('Seq',$id);
			$this->db->update('contract_copy',$data);
		}

function get_site($contractname, $seq1)
{ 		
	  		$sql = "SELECT ch.Seq, concat(ch.Seq, ' - ' ,ch.ContractName, ' - ' , ch.SiteName, ' - ',  cu.Name , ' - ' ,ch.CustOrder) as mysite FROM contract_header as ch INNER JOIN customers as cu ON (ch.CIndex = cu.Seq) WHERE ContractName = '$contractname' AND ch.Seq <> '$seq1'";
			
			$query=$this->db->query($sql);	
			
			
				if($query->num_rows() > 0)
				{

	 			$result = $query->result();
     			$drop_menu_operator_name = array();
					foreach($result as $item)
							{
								$options[$item->Seq] = $item->mysite;
							}
      				return $options;
				
				} 
				else
 					{
         				echo '<script type = "text/javascript">alert("No contracts to duplicate a copy!");
		 				window.history.back();</script>';
				 //$result = $query->result();
     		
					}
				
				
		
			
		
			
			
		}
		
function count_all_results($contractname)
{
	$this->db->select('*')
                        ->from ('contract_header')
                        //->join('site_operators', 'clients.ShortName= site_operators.SiteName')
						 ->where('ContractName',$contractname);
						 //->where('Attributes',256);
						 
	
	return $this->db->count_all_results();
	
	
}		
	
	
	function get_site_network($mysiteoperator) { 		
			$query = $this->db->select('Network')
                              ->from ('network_mapping')
							  ->where ('SiteName',$mysiteoperator)
							  ->get(); 	
						$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->Network] = $item->Network;
	    				}
      		return $options;	
		}
	
    
	function create_copy($ContractNo, $StartWeek,$EndWeek, $StartDay, $EndDay, $SpotName, $SpotLength, $Network, $Weighting)
		{
			
			$NewSchedData = array(
				   			
					'Contract'=>$ContractNo,
					'StartDate'=>$StartWeek,
					
					'EndDate'=>$EndWeek,
					'StartDay'=>$StartDay,
					'EndDay'=>$EndDay, 			
					'SpotName'=>$SpotName,  
					'SpotLength'=>$SpotLength,
					'Network'=>$Network,
					'Weighting'=>$Weighting,
					
									
				);
		         
											
				//$insert = 
				$this->db->insert('contract_copy',$NewSchedData);
				
				return ;
			
			
			}
		
	///insert to copy_duplicate
	
	
	
	
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
			
		
		 
}


?>

