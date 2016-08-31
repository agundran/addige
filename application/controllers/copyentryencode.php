<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");


class Copyentryencode extends CI_Controller
{
 	
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('copyentryencodemodel','',TRUE);
 		$this->is_logged_in();
 	}
	 
   function is_logged_in()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!isset($is_logged_in) || $is_logged_in != true){
		echo 'you don\'t have permission to access this page. <a href="pages/login">Login</a>';
		die();
		}	
	}
	 
	 	 
	function index($siteoperator, $contractno) 
	{
	$data['title'] = 'Copy Entry for Contract# '. $contractno ;
	$data['subtitle'] = 'Site : '. $siteoperator;
    
	//$data['subtitle'] = 'Contract Details';
    $data['message'] = '';
	$data['action'] = site_url('copyentryencode/index/'.$siteoperator."/".$contractno);
	$data['mysiteoperator']=$siteoperator;
	 
	
    $this->_set_rules();
	if ($this->form_validation->run() === FALSE){
	
			$data['Users']['StartWeek']='';
			$data['Users']['EndWeek']='';
			$data['Users']['StartDay']='';
			$data['Users']['EndDay']='';
			$data['Users']['SpotName']='';
			$data['Users']['SpotLength']='';
			
			$data['Users']['net']='';
			$data['Users']['Weighting']='';

			
			$this->load->view('pages/template/header2');
			//$this->load->view('pages/template/nav');
			$this->load->view('pages/copyentryencode_view', $data);
			//$this->load->view('pages/template/footer');

	}else{
			//$SiteName= $siteoperator;
			$ContractNo = 	$contractno;
			$StartWeek= $this->input->post('StartWeek');
			$EndWeek = $this->input->post('EndWeek');
			$StartDay = null;//$this->input->post('StartDay');
			$EndDay = null;//$this->input->post('EndDay');
			
			$SpotName= $this->input->post('SpotName');
			
			///SpotName UPPERCASE
			$Spotupper = strtoupper($SpotName);
			
			$SpotLength= $this->input->post('SpotLength');
			
			//$strtoupper
						
			
			$Weighting = $this->input->post('Weighting');
			
			
			
			$netcheckbox= $this->input->post('netcheck');
			
			
			if ($netcheckbox == 1)
			{
				$Network = $this->input->post('NetworkName'); ;
				
				}
				
			else
			{
				
			$Network= 'Null';
				
				}
			
			
			$id = $this->copyentryencodemodel->create_copy($ContractNo, $StartWeek,$EndWeek, $StartDay, $EndDay, $Spotupper, $SpotLength, $Network, $Weighting);
			
		//$this->validation->id = $id;
		$message = "Copy entry for Contract #".$ContractNo." created";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
				 window.opener.location.reload();
				window.close ();
        		</script>';
   			 }
		
		}

	}
	
	
	
function update($id,$siteoperator){
	 
	// set common properties
	 	$data['title'] = 'Update Copy #'.$id;
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('copyentryencode/update/'.$id.'/'.$siteoperator);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
	 	$data['Users'] = (array)$this->copyentryencodemodel->get_by_id($id)->row();
	 	
	 	//$data['subtitle'] = '';
		$data['mysiteoperator']=$siteoperator;
		
		}else{
	// save data
	 	    
			$StartWeek= $this->input->post('StartWeek');
			$EndWeek = $this->input->post('EndWeek');
			$StartDay = null;//$this->input->post('StartDay');
			$EndDay = null;//$this->input->post('EndDay');
			
			$SpotName= $this->input->post('SpotName');
			
			///SpotName UPPERCASE
			$Spotupper = strtoupper($SpotName);
			
			$SpotLength= $this->input->post('SpotLength');
			
			$netcheckbox= $this->input->post('netcheck');
			
			
			if ($netcheckbox == 1)
			{
				$Network = $this->input->post('NetworkName'); ;
				
				}
				
			else
			{
				
			$Network= '';
				
				}
			
			
		//	$Network= $this->input->post('NetworkName');
			$Weighting = $this->input->post('Weighting');
		
		
						
		$data['Users'] = (array)$this->copyentryencodemodel->get_by_id($id)->row();
		
		$id = $data['Users']['Seq'];
				    	
		
			$myedit = array(
	 				'StartDate' => $StartWeek,
					'EndDate' => $EndWeek,
					'Startday' => $StartDay,
					'EndDay'=>$EndDay,
					'SpotName'=>$Spotupper,
					'SpotLength' =>$SpotLength,
					'Network' =>$Network,
				 	'Weighting'=>$Weighting 
					
					);
	 		
			
		//var_dump($User);
	 	$this->copyentryencodemodel->update($id,$myedit);
	 	//$data['Users'] = (array)$this->contractsviewmodel->get_by_id($id)->row();
	  
	// set user message
	 	
		 $message = "Copy Entry Updated Successfully";
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
			$this->load->view('pages/copyentryencodeEdit_view', $data);
		
	}
	
///insert to copy_duplication




function getContracts($seq)
{
	$counter = 0;
			foreach ($_POST['siteoperator'] as $CContract)
			{
				$Contract = $CContract;
				
				$id2 = $this->copyentryencodemodel->deletetheexistingcopy($Contract);
				$id = $this->copyentryencodemodel->combinecontractsandcopy($Contract,$seq);	
				
				//$RecordsAdded = 0;
				$counter++;
				//$ReynanRowsAffected = $RecordsAdded + $counter;
			}	
		
		//$this->validation->id = $id;
		$message = "Successfully Duplicated! ". $counter . ' ' . "contract(s) affected.";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		 window.history.back();
				
        		</script>';
   			 }
		
		
					
			 
}




///end



function DuplicateAllcopy($siteoperator, $contractname, $seq)
{

	$offset = '1';
	$order_type = 'asc';

	$Users=$this->copyentryencodemodel->contractdetails($seq)->result();
	$data['seq']=$seq;
	$data['contractname'] = $contractname;
		
		
	$this->load->library('pagination');
	//$config['base_url'] = site_url('/TrafficManageSalesman/index');
	//$config['total_rows'] = $this->TrafficManageSalesman_model->count_all();
	//$config['per_page'] = $this->limit;

	//$data['action'] = ('copyentryencode/getContracts/'.$seq.'/'.$siteoperator);
	$data['action'] = ('copyentryencode/getContracts/'.$seq);
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
	$this->table->set_heading(
	anchor('TrafficManageSalesman/index/'.$offset.'/Seq/'.$new_order, 'Seq'),
	anchor('TrafficManageSalesman/index/'.$offset.'/Contract/'.$new_order, 'Contract'),
	anchor('TrafficManageSalesman/index/'.$offset.'/StartDate/'.$new_order, 'StartDate'),
	anchor('manageoperatorlist/index/'.$offset.'/EndDate/'.$new_order, 'EndDate'),
	anchor('TrafficManageAgencies/index/'.$offset.'/SpotName/'.$new_order, 'SpotName'),
	anchor('TrafficManageAgencies/index/'.$offset.'/SpotName/'.$new_order, 'Weighting'),
	anchor('TrafficManageAgencies/index/'.$offset.'/SpotName/'.$new_order, 'SpotLength'),
	anchor('TrafficManageAgencies/index/'.$offset.'/SpotName/'.$new_order, 'Network')
	//anchor('TrafficManageAgencies/index/'.$offset.'/State/'.$new_order, 'State'),
	//anchor('manageoperatorlist/index/'.$offset.'/Zip/'.$new_order, 'Zip'),
	//anchor('manageoperatorlist/index/'.$offset.'/Country/'.$new_order, 'Country'),
	//anchor('manageoperatorlist/index/'.$offset.'/Telephone/'.$new_order, 'Telephone'),
);
	 
	  $upd = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            ); 
	 
	$i = 0 + $offset;
	foreach ($Users as $Users)
	 {
	$this->table->add_row(
	$Users->Seq,
	$Users->Contract,
	$Users->StartDate,
	$Users->EndDate,
	$Users->SpotName,
	$Users->Weighting,
	$Users->SpotLength,
	$Users->Network
	
	//anchor_popup('TrafficManageSalesman/update/'.$Users->Seq,'Update',array('class'=>'update'), $upd).'   '.
	//anchor('manageoperatorlist/view/'.$Users->ShortName,'view',array('class'=>'view')).'   '.
	//anchor('TrafficManageSalesman/update/'.$Users->Seq,'update',array('class'=>'update')).'   '.
	//anchor('TrafficManageSalesman/delete/'.$Users->Seq,'delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Operator?')"))
	);
	 
	}
	 
	$data['table'] = $this->table->generate();
	
	if ($this->uri->segment(3)=='delete_success')
	$data['message'] = 'The Data was successfully deleted';
	else if ($this->uri->segment(3)=='add_success')
	$data['message'] = 'The Data has been successfully added';
	else
	$data['message'] = '';
	 
		
		
		$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/Dupallcopyview', $data);
		$this->load->view('pages/template/footer');
	
}




function duplicate($id,$siteoperator, $contractname){
	 
	// set common properties
	 	$data['title'] = 'Duplicate Copy #'.$id;
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	//$data['action'] = ('copyentryencode/update/'.$id.'/'.$siteoperator);
	 $data['action2'] = site_url('copyentryencode/insert');
	 	
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
	 	$data['Users'] = (array)$this->copyentryencodemodel->get_by_id($id)->row();
	 	
	 	//$data['subtitle'] = '';
		$data['mysiteoperator']=$siteoperator;
		$data['contractname'] = $contractname;
		
		}else{
	// save data
	 	    
			$StartWeek= $this->input->post('StartWeek');
			$EndWeek = $this->input->post('EndWeek');
			$StartDay = null;//$this->input->post('StartDay');
			$EndDay = null;//$this->input->post('EndDay');
			
			$SpotName= $this->input->post('SpotName');
			$SpotLength= $this->input->post('SpotLength');
			
			
			$Network= $this->input->post('NetworkName');
			$Weighting = $this->input->post('Weighting');
		
		
						
		
	 		$this->validation->id = $id;
			
		//var_dump($User);
	 	//$this->copyentryencodemodel->update($id,$myedit);
	 	//$data['Users'] = (array)$this->contractsviewmodel->get_by_id($id)->row();
	  
	// set user message
	 	
		 $message = "Copy Entry Updated Successfully";
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
			$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/duplicatecopy_view', $data);
		
	}

	
		
 	function _set_rules(){
		
		$this->form_validation->set_rules('NetworkName', 'NetworkName', 'required');
		//$this->form_validation->set_rules('StartDate', 'StartDate', 'required');
		
	    			
	 	}

}
?>

