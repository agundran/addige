<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");

class Orderentry extends CI_Controller
{
 	
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('orderentrymodel','',TRUE);
 		$this->is_logged_in();
 	}
	 
   function is_logged_in()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!isset($is_logged_in) || $is_logged_in != true){
		echo 'you don\'t have permission to access this page.';
		 redirect('pages/login');
		die();
		}	
	} 
	 
	 	 
	function index() 
	{
	$data['title'] = 'Order Entry';
	$data['subtitle'] = 'Contract Details';

	$data['action'] = site_url('orderentry/index');
	 
	$atts = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
	 		
	$this->_set_rules();
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
					// set common properties
			$data['title'] = 'Order Entry';
			$data['subtitle'] = 'Contract Details';
			$data['message'] = '';
			$data['Users']['CIndex']='';
			$data['Users']['ContractName']='';
			$data['Users']['SiteName']='';
			$data['Users']['StartDate']='';
			$data['Users']['EndDate']='';
			$data['Users']['CustOrder']='';
			$data['Users']['EstCode']='';
			$data['Users']['Discount']='';
			$data['Users']['AIndex']='';
			$data['Users']['Rate']='';
	 	    $data['Users']['SIndex']='';
			$data['Users']['Salesmanrate']='';
	 		$data['Users']['Minseparation']='';
			$data['Users']['Revision']='';
		    $data['Users']['Attributes']='';
			
			
			$data['link_addcust'] = anchor_popup('PopupManageCustomers/index/','Entry',array('class'=>'link_addcust'), $atts);
			$data['link_addagency'] = anchor_popup('PopupManageAgencies/index/','Entry',array('class'=>'link_addagency'), $atts);
			
			$data['link_addsalesman'] = anchor_popup('PopupManageSalesman/index/','Entry',array('class'=>'link_addsalesman'), $atts);
		   
		    $Cinput = $this->input->post('CIndex');
			$CIndex = substr($Cinput,0,strrpos($Cinput,':'));
			$Customer_discount = $this->orderentrymodel->get_customer_discount($CIndex);		    $data['cust_discount'] = anchor($data['Users']['Discount']='0','Get Rate',array('class'=>'cust_discount' ));
			
			
			$data['print_me'] = anchor_popup('orderentry/me_view', 'print',array('class'=>'me_view'),$atts);  
		
			
			$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header2');
			$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/orderentry_view', $data);
			$this->load->view('pages/template/footer');
			
			
			if ($this->uri->segment(3)=='delete_success')
			$data['message'] = 'The Data was successfully deleted';
			else if ($this->uri->segment(3)=='add_success')
			$data['message'] = 'The Data has been successfully added';
			else if ($this->uri->segment(3)=='update_success')
			$data['message'] = 'The Data has been successfully updated';
			else
			$data['message'] = '';
		   
		}else{
	 
	// save data
	 	
		            //$Cinput = $this->input->post('CIndex');
					//$CIndex = substr($Cinput,0,strrpos($Cinput,':'));
	 				
					$CIndex = $this->input->post('CIndex');
					$ContractName = $this->input->post('ContractName');
					
					$CalendarType = $this->input->post('CalendarType');
					
					$StartDate = $this->input->post('StartDate');
					$EndDate = $this->input->post('EndDate');
					
					$ClientType = $this->input->post('ClientType');
					
					$CustOrder = $this->input->post('CustOrder');
					$EstCode = $this->input->post('EstCode');
					$iDiscount = $this->input->post('discount');
					$Discount = $iDiscount * 10;
					
					
					
					$SIndex  = $this->input->post('SIndex');
					$iSalesComm = $this->input->post('salesmanrate');
					$SalesComm = $iSalesComm * 10;
					
					
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
					
					
					
					//$Attribute = 0;
//					if ($pi_check == 1){ $Attribute +=1; }
//					if ($fi_check == 1){ $Attribute +=2; }
//					if ($pe_check == 1){ $Attribute +=4; }
//					if ($eo_check == 1){ $Attribute +=8; }
//					if ($co_check == 1){ $Attribute +=16; }
//					if ($am_check == 1){ $Attribute +=32; }
//					if ($pr_check == 1){ $Attribute +=64; }
					
					if ($ag_check == 1)
					{ 
						$AIndex = $this->input->post('AIndex');
						$iAgencyComm = $this->input->post('agencyrate');
						$AgencyComm = $iAgencyComm * 10;
					
					} 
					else	
					{
							//$AIndex = 0;
							$AgencyComm = 0;
							$AIndex = 0;
							//$Attribute +=256; 
					}
					if ($AIndex == "blank")
					{
						$AIndex = 0;
						}
					
					if ($SIndex == "blank")
					{
						$SIndex = 1;
						$SalesComm = 0;
					}
					
					
					
					
					if ($iDiscount == "")
					{
						
						$Discount = 0;	
					}
					
						
					if ($MinSeparation == "")
					{
						$MinSeparation = 0;
					}
					if ($Revision == "")
					{
						$Revision = null;
					}
					
					////change order entry attribute code. - Reynan
										//$Attribute +=256; 
					$Attribute = $this->orderentrymodel->GetAttributes($ag_check,$pi_check,$pe_check,$pr_check,$fi_check,$co_check,$eo_check,$am_check);
	///end of attribute code - Reynan

			$bStartDate = strtotime($StartDate);
			$bEndDate = strtotime($EndDate);
		
			$c1StartDate = date('Y-M-d 00:00:00', $bStartDate);
			$c1EndDate = date('Y-M-d  23:59:59',$bEndDate);
		
		     $cStartDate = new DateTime($c1StartDate);
			 $cEndDate = new DateTime($c1EndDate);


	If ($cEndDate <  $cStartDate){		
				
		 $message = "End Date Should be set after Start Date";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
        		</script>';
   			 }


	} else {
				
	
					
		foreach ($_POST['siteoperator'] as $SSiteName)
			{
			//$Sinput = $SSiteName;
			//$Sres=substr($Sinput, -14 ,(strrpos($Sinput,'-'))+15);
			$SiteName = $SSiteName;
			
			
			
			$id = $this->orderentrymodel->create_contract($CIndex,$ContractName,$CalendarType,$StartDate, $EndDate,$ClientType,$CustOrder,$EstCode,$Discount, $AIndex, $AgencyComm, $SIndex , $SalesComm, $MinSeparation, $Revision,$SiteName, $Attribute);
			
			 			
			}
			
			$this->validation->id = $id;
		
		
		redirect('pendingtesting2/index/','Refresh');
		$msg = "New Contract for ".$ContractName." has been successfully created";
   			 if ((isset($msg)) && ($msg!= '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
        		</script>';
			 }
			 
		 	
			}
		}
	
	 		
	}


function _set_rules(){
		
		//$StartDate = $this->input->post('StartDate');
		
		$this->form_validation->set_rules('ContractName', 'ContractName', 'required');
	    $this->form_validation->set_rules('ContractName', 'ContractName', 'required');
	    
		//$this->form_validation->set_rules('EndDate', 'EndDate','callback_compare_dates['.$StartDate.']');
		//$this->form_validation->set_rules('Username', 'Username', 'required|min_length[4]|max_length[20]|is_unique[users.Username]');
		//$this->form_validation->set_rules('Password', 'Password', 'trim|min_length[4]|max_length[32]');
		//$this->form_validation->set_rules('Email', 'Email Address', 'trim|valid_email');
			
	 	}


function compare_dates($str, $StartDate){
	
	$ed = strtotime($str);
	$sd = strtotime($StartDate);
	if ($ed > $sd) {
       return TRUE;
   }
   		
		$this->form_validation->set_message('End Date should be set after Start Date');
   return FALSE;
	
	}	

		function get_discount($Cinput)	{
			$result = $this->orderentrymodel->get_customer_discount($Cinput);
	        echo json_encode($result);
			  
			
			}

		function get_agencyrate($Ainput)	{
			$result1 = $this->orderentrymodel->get_agency_rate($Ainput);
	        echo json_encode($result1);
			  
			
			}
			
		function get_salesmanrate($Sinput)	{
			$result2 = $this->orderentrymodel->get_salesman_rate($Sinput);
	        echo json_encode($result2);
			  
			
			}	

		function get_networks(){
			
			
			
			}


}

?>

