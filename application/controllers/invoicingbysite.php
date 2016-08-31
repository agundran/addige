<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");

	
class Invoicingbysite extends CI_Controller{	
	
	private $limit = 5000;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('invoicingbysitemodel','',TRUE);
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
	 
	function GetStartDate($aSD){
		$currentuser = $this->session->userdata('username');
		 $bStartDate = $this->invoicingbysitemodel->get_billingstartdate($currentuser);
		  $bEndDate = $this->invoicingbysitemodel->get_billingenddate($currentuser);
		 
		 $bmStartDate = date('Y/n/d',strtotime($bStartDate));
		 $bmEndDate = strtotime($bEndDate);
		 
		 //$SD = strtotime($aSD);
		 
		 if ($aSD < $bmStartDate ){
			 
			  return $bmStartDate;
			 	 }
			 else   if  ($aSD >= $bmStartDate)
			 {
			return $aSD;
			}
	 		}
			
			 
	function GetEndDate($aED){
		 $currentuser = $this->session->userdata('username');
		$bEndDate = $this->invoicingbysitemodel->get_billingenddate($currentuser);
	
	   // $ED = date('Y/n/d',strtotime($aED));
		$bmEndDate = date('Y/n/d',strtotime($bEndDate));
		 
		   if ($aED > $bmEndDate){
			 
			 return $bmEndDate;
			 } elseif  ($aED == $bmEndDate){
				  return $aED;
					 }
			 else {
				 return $aED;
		     }
		 }	
		
		 
	function index($order_column,$syscode)
	
	{
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'Seq';
	if (empty($order_type)) $order_type = 'asc';
	
	$currentuser = $this->session->userdata('username');
	$aStartDate = $this->invoicingbysitemodel->get_billingstartdate($currentuser);
	$aEndDate = $this->invoicingbysitemodel->get_billingenddate($currentuser);
	
	$StartDate = date('Y/n/d',strtotime($aStartDate));
	$EndDate = date('Y/n/d',strtotime($aEndDate));
	
	//$StartDate = str_replace("-", "/", $aStartDate);
	//$EndDate = str_replace("-", "/", $aEndDate);
	
	$filter  = $this->input->post('Seq');
	
	
	//config popup window
	 $upd = 
	 array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
	//TODO: check for valid column
	// load data
	
	$limit = $this->invoicingbysitemodel->count_all($order_column, $StartDate, $EndDate);
	
	
	
	
	
	$Users = $this->invoicingbysitemodel->get_paged_list($this->limit,$order_column, $offset, $order_type, $filter, $StartDate, $EndDate)->result();
	

	 
	// generate paginationthis
	$this->load->library('pagination');
	
	$tc = $this->invoicingbysitemodel->count_all($order_column, $StartDate, $EndDate);
	
	$config['base_url'] = site_url('/invoicingbysite/index/'.$order_column.'/'.$syscode);

	$config['total_rows'] = $this->limit;
	
	$config['per_page'] = 1000;
	$config['uri_segment'] = 3;
	$config['num_links']     = 4;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
    
	
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'desc' ? 'desc' : 'asc');
	$this->table->set_heading(
	'Contract#','Contract Name','Start Date','End Date','Gross Booked','Gross Earned',	'Select','Select');
	 
	$Totalbooked = 0;		
	$i = 0 + $offset;

	foreach ($Users as $Users) {
	if (($this->invoicingbysitemodel->ComputeContractContri($Users->c1Se, $Users->c1S,$Users->c1E))<> 0){
	$this->table->add_row(
	
	$Users->c1Se,
	
	$Users->c1C,
	
	$Users->c1S,
	
	$Users->c1E,
	
	number_format($this->invoicingbysitemodel->ComputeContractValue($Users->c1Se, $Users->c1S,$Users->c1E),2),
	
	'0.0',
	
	anchor_popup(array('invoicingprint/index/'.$Users->c1Se,$Users->c1S,$Users->c1E),'Print Invoice',array('class'=>'print_preview'), $upd),
	anchor_popup(array('prtspotlog/index/'.$Users->c1Se,$Users->c1S,$Users->c1E),'Print Log',array('class'=>'prtspotlog'), $upd))
	;
		

	
	
	}
	
	$Totalbooked = $Totalbooked + $this->invoicingbysitemodel->ComputeContractValue($Users->c1Se, $Users->c1S,$Users->c1E);
	
	}
	 $this->table->add_row("","","Total Bookings","",number_format($Totalbooked,2),"","","");
	
	
	$data['table'] = $this->table->generate();
	
	
			
	if ($this->uri->segment(3)=='delete_success')
	$data['message'] = 'The Data was successfully deleted';
	else if ($this->uri->segment(3)=='add_success')
	$data['message'] = 'The Data has been successfully added';
	else
	$data['message'] = '';
	 
	$data['title'] = 'Contract Booked for '.$order_column.' ('.$syscode.')'; 
	//$data['title1'] = 'From '.$astartdate.' to '.$aenddate;
	$data['title1'] = 'From '.$StartDate.' to '.$EndDate;
	
	 
	// load view.$aenddate
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header3');
	//	$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/invoicingbysite_view', $data);
		//$this->load->view('pages/template/footer');
	 }
	
	
	
	
	
	
}

?>