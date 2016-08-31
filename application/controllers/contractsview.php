
<?php
require_once("system/core/Common.php");

 ini_set('memory_limit', '-1'); 
 ini_set ('max_execution_time', 10000);
	  
class Contractsview extends CI_Controller
{
	private $limit = 5;
 	
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('contractsviewmodel','',TRUE);
 		$this->is_logged_in();
 	}
	 
   function is_logged_in()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!isset($is_logged_in) || $is_logged_in != true){
		echo 'you don\'t have permission to access this page. <a href="<?php $this->config->base_url();?>">Login</a>';
		die();
		}	
	}
	 
	 	 
	function index( $offset , $order_column ,$syscode,$order_type){
		if (empty($offset)) $offset = 0;
		if (empty($order_type)) $order_type = 'asc';
		
		
	    $filter1 = 	$this->input->post('myselect');
		$filter  = $this->input->post('myvalue');
		
		if (empty($view_sitename)) $view_sitename = $order_column;
		 
	$Users = $this->contractsviewmodel->get_paged_list($this->limit, $offset, $order_column, $order_type,$filter, $filter1)->result();
	  $upd = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
			
		
		// generate pagination
		$this->load->library('pagination');
		//$config['base_url'] = site_url('/contractsview/index/');
		
		//$config['base_url'] = site_url('/contractsview/index/'.($offset+=10).'/'.$order_column.'/'.$syscode.'/'.$order_type.'/');
		
		$config['base_url'] = site_url('/contractsview/index/'.($offset+=10).'/'.$order_column.'/'.$syscode.'/'.$order_type.'/');
		
		$config['total_rows'] = $this->contractsviewmodel->count_all_results1($order_column);
		
		if ($filter == null || $filter1 == null){ 
		$config['per_page'] = 10;
		}else{
		//$config['per_page'] = $this->contractsviewmodel->count_all_results1($order_column);
		$config['per_page'] = $this->limit;
			}
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 		$data['title'] = $order_column;
		$data['syscode'] = $syscode;
		
		
		
		
		$data['no_row'] = $this->contractsviewmodel->count_all_results($order_column);
		//$data['filter'] = $filter;
		
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		anchor('contractsview/index/'.$offset.'/Seq/'.$new_order, 'Seq'),
		anchor('contractsview/index/'.$offset.'/ContractName/'.$new_order, 'ContractName'),
		anchor('contractsview/index/'.$offset.'/CustOrder/'.$new_order, 'CustOrder'),
		anchor('contractsview/index/'.$offset.'/StartDate/'.$new_order, 'Start Date'),
		
		//anchor('contractsview/index/'.$offset.'/StartDate/'.$new_order, 'Test Column'),
		
		anchor('contractsview/index/'.$offset.'/EndDate/'.$new_order, 'EndDate'),
	 //anchor('contractsview/index/'.$offset.'/EndDate/'.$new_order, 'Attributes')
	 '', 'Actions','','');
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			
			$Users->Seq,
			$Users->ContractName,
			$Users->CustOrder,			
			$Users->StartDate,
			
			//$Users->Name,
			
			$Users->EndDate,
			//$Users->Attributes,
			
		
		anchor((array('detailentry/index/'.$offset=0,$order_column,$order_type='asc', $Users->Seq )),'Schedule Entry',array('class'=>'detailentry')),
			
		anchor((array('copyentry/index/'.$offset=0,$order_column,$order_type='asc', $Users->Seq )),'Copy Entry',array('class'=>'copyentry')),	
		
		anchor_popup('contractsview/update/'.$Users->Seq,'Update',array('class'=>'edit'),$upd),
		//anchor('contractsview/update/'.$Users->Seq,'Update Contract',array('class'=>'edit')),		
				
		anchor((array('contractsview/delete/'.$Users->Seq,$order_column, $syscode)),'Delete',array('class'=>'delete','onclick'=>"return confirm('WARNING! This will erase all data associated with the contract?  Are you sure you want to remove this Contract?')")));
	 	}
	 
		$data['table'] = $this->table->generate();
	
		//if ($this->uri->segment(3)=='delete_success')
			//$data['message'] = 'The Data was successfully deleted';
		if ($this->uri->segment(3)=='add_success')
			$data['message'] = 'The Data has been successfully added';
		else if ($this->uri->segment(3)=='update_success')
			$data['message'] = 'The Data has been successfully updated';
		else
		$data['message'] = '';
		
	     $data['link_back'] = anchor('selectsite/index/','Return to Select Site',array('class'=>'back'));
		// load view
	 	 $data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/contractsview_view', $data);
		$this->load->view('pages/template/footer');
	 
	
	}

	function update($id){
	 
	// set common properties
	 	$data['title'] = 'Update Contract';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('contractsview/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	//$data['message'] = '';
	 	$data['Users'] = (array)$this->contractsviewmodel->get_by_id($id)->row();
	 	$data['title'] = 'Update Contract #: '.$id ;
	 	//$data['subtitle'] = '';
		$disfract= $data['Users']['CustOrder'] % 10;
	 	//$data['Users']['Discount']= ($data['Users']['Discount'] /= 10).'.'.$disfract;
		
	$data['Users']['Discount'] /= 10;
		
		//$agenfract =$data['Users']['AgencyComm'] % 10;
		$data['Users']['AgencyComm'] /=10;
		$data['Users']['SalesComm'] /=10;
		$ci = $data['Users']['CIndex'];
		$Users1  = $this->contractsviewmodel->get_customer_name($ci)->result();
		foreach ($Users1 as $Users1){
		
		$mycust = $Users1->Name; 
		}
		$data['Users']['CIndex'] = $ci.' - '.$mycust;
		$data['Myseq']=$id;
		
		}else{
	 
	// save data
	
					$CIndex = $this->input->post('CIndex');
					$ContractName = $this->input->post('ContractName');
					$CalendarType = $this->input->post('billing_type');
	 	            $StartDate = $this->input->post('StartDate');
					$EndDate = $this->input->post('EndDate');
					$ClientType = $this->input->post('client_type');
					
					$CustOrder = $this->input->post('CustOrder');
					$EstCode = $this->input->post('EstCode');
					
					$iDiscount = $this->input->post('Discount');
					
					$Discount = $iDiscount * 10;
					//$Attribute = 260;
					$SIndex  = $this->input->post('SIndex');
					
					$iSalesComm = $this->input->post('SalesComm');
					$SalesComm = $iSalesComm * 10;
					
					$AIndex = $this->input->post('AIndex');
					$iAgencyComm = $this->input->post('AgencyComm');
					$AgencyComm = $iAgencyComm * 10;
					
					$MinSeparation = $this->input->post('Minseparation');
					$Revision = $this->input->post('Revision');
		
					$ag_check = $this->input->post('ag');
					
					$pi_check = $this->input->post('pi');
					$pe_check = $this->input->post('pending');
					$pr_check = $this->input->post('prepaid');
					$fi_check = $this->input->post('filler');
					$co_check = $this->input->post('coop');
					$eo_check = $this->input->post('eof');
					$am_check = $this->input->post('amg');
					
		$Attribute = $this->contractsviewmodel->GetAttributes($ag_check,$pi_check,$pe_check,$pr_check,$fi_check,$co_check,$eo_check,$am_check);
		
		$data['Users'] = (array)$this->contractsviewmodel->get_by_id($id)->row();
		
		$id = $data['Users']['Seq'];
		
		$myedit = array(
					'CIndex' => $CIndex,
					'ContractName' => $ContractName,
					
					'billing_type' => $CalendarType,
	 				'StartDate' => $StartDate,
					'EndDate' => $EndDate,
					'client_type' => $ClientType,
					'CustOrder' =>  $CustOrder,
					'est' => $EstCode,
					'Discount' => $Discount,
					'SIndex'=>$SIndex,
					'SalesComm'=>$SalesComm,
					
					'AIndex' =>$AIndex,
					'AgencyComm' =>$AgencyComm,
				 
					'MinSeparation'=>$MinSeparation, 
					'Revision'=>$Revision,
					'Attributes'=>$Attribute
								
					);
	 		
				
		//var_dump($User);
	 	$this->contractsviewmodel->update($id,$myedit);
	 	$data['Users'] = (array)$this->contractsviewmodel->get_by_id($id)->row();
	  

		$message = "Contract #".$id." updated successfully";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
				 window.opener.location.reload();
				window.close ();
        		</script>';
   			 }
	
	 	}

	 
	// load view
	 		$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header2');
			//$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/contractsviewedit_view', $data);
		}
	
	
	function _set_rules(){
		
		$this->form_validation->set_rules('SIndex', 'SIndex', 'required');
	    //$this->form_validation->set_rules('Operator', 'operator');
		//$this->form_validation->set_rules('Username', 'Username', 'required|min_length[4]|max_length[20]|is_unique[users.Username]');
		
			
	 	}
		
	function delete($id, $order_column, $syscode){
	 $data['Users'] = (array)$this->contractsviewmodel->get_by_id($id)->row();
	 
	 $id = $data['Users']['Seq'];
		
	 // delete all contract data
	 	$this->contractsviewmodel->delete($id);
	 	
		 $message = "Contract Deleted Successfully";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
				
         		</script>';
   			 }
	  redirect('contractsview/index/0/'.$order_column.'/'.$syscode.'/asc','Refresh');
	//redirect('contractsview/index/','Refresh');
	
	 }
		

}

?>

