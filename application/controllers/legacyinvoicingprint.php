<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");

	
class Legacyinvoicingprint extends CI_Controller{	
	
	
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('legacyinvoicingprintmodel','',TRUE);
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
	 
	 
	//Convert distribution into days in a week which order was placed 
	function GetDistribution($Distribution){	
		$DaysOfWeek = array("M","T","W","Th","F","S","Su" );
    	$DaysRep = str_replace("-", "", $Distribution);
	
		 $Schedule = "";
	
		for($i=0;$i<=(strlen($DaysRep)-1);$i++){
	   		$char = substr( $DaysRep, $i, 1 );
	   			if ($char != "0"){
			   $Schedule = $Schedule.$DaysOfWeek[$i];
	 	   }
		 }
	 	return $Schedule;
	}
	
	// this is function for computing total number of orders for a specific boradcast calendar
	function GetDistributionAmount($aStartDate, $aEndDate, $Dist){
	 
	 $currentuser = $this->session->userdata('username');
	 $bStartDate = $this->legacyinvoicingprintmodel->get_billingstartdate($currentuser);
	 $bEndDate = $this->legacyinvoicingprintmodel->get_billingenddate($currentuser);
	 
	 
	  $StartDate= strtotime($aStartDate);
	  $EndDate = strtotime($aEndDate);
	  $bmStartDate= strtotime($bStartDate);
	  $bmEndDate = strtotime($bEndDate);
	  
	  	  if ($StartDate <= $bmStartDate ) {
			   $uStartDate = ($bmStartDate);
			   } else {
				$uStartDate = ($StartDate);
				}
						 			
			if($EndDate > $bmEndDate){
				$uEndDate =($bmEndDate);}
			else{
			$uEndDate = ($EndDate);
				}
	 
	 
	 
	 
	  $ConvertDays = array(0,1,2,3,4,5,6);
	  $xDist = str_replace("-", "", $Dist);
      
	  $aDist = str_split($xDist);
     
	  $totalSched = 0;
	   
	  	   while ($uStartDate <= $uEndDate){
		   		$ctr = date('w', $uStartDate);
		        $ConvertDayOfWeek = $ConvertDays[$ctr];
				$nPlaysToday = $aDist[$ConvertDayOfWeek];
				 $totalSched += $nPlaysToday;  
		   
		   $uStartDate = $uStartDate +(24*3600*1);
		   }
	  return $totalSched;	  
	
	}
	
	 
	 function GetStartDate($aSD, $ton){
		$currentuser = $this->session->userdata('username');
		 $bStartDate = $this->legacyinvoicingprintmodel->get_billingstartdate($currentuser);
		  $bEndDate = $this->legacyinvoicingprintmodel->get_billingenddate($currentuser);
		 
		 $bmStartDate = strtotime($bStartDate);
		 $bmEndDate = strtotime($bEndDate);
		 
		 $SD = strtotime($aSD);
		 
		 if ($SD < $bmStartDate ){
			 
			  return date("M j ,Y",$bmStartDate)." ".$ton;
			 	 }
			 else   if  ($SD >= $bmStartDate)
			 {
			return date("M j,Y", $SD)." ".$ton;
			}
	 		}
			
			
	
		 
	function GetEndDate($aED, $toff){
		 $currentuser = $this->session->userdata('username');
		$bEndDate = $this->legacyinvoicingprintmodel->get_billingenddate($currentuser);
	
	    $ED = strtotime($aED);
		$bmEndDate = strtotime($bEndDate);
		 
		   if ($ED > $bmEndDate){
			 
			 return date("M j, Y",$bmEndDate)." ".$toff;
			 } elseif  ($ED == $bmEndDate){
				  return date("M j, Y",$ED)." ".$toff;
				 
				 }
			 
			 
			 else {
				 
				 return date("M j, Y", $ED)." ".$toff;
				 			  
		     }
		 
		 }	 
		 
		 
		 //	if($EndDate > $bmEndDate)
		//	{$uEndDate =date('Y-m-d', ($bmEndDate));}
			//else{
	//		$uEndDate = date('Y-m-d', ($EndDate));
		//	}
	    
	 
	function index($order_column)
	
	{
	
	$currentuser = $this->session->userdata('username');
	$astartdate = $this->legacyinvoicingprintmodel->get_billingstartdate($currentuser);
	$aenddate = $this->legacyinvoicingprintmodel->get_billingenddate($currentuser);
	
	// load data
	$Users = $this->legacyinvoicingprintmodel->get_contract_details($order_column)->result();
    //$Users2 = $this->legacyinvoicingprintmodel->get_spotnames($order_column);
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/invoicingprint/index/');
	$config['total_rows'] = $this->legacyinvoicingprintmodel->count_all($order_column);
	$config['per_page'] =  $this->legacyinvoicingprintmodel->count_sitename_active();
	//$config['per_page'] = $this->legacyinvoicingprintmodel->count_all($order_column);
	
	//$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	//$new_order = ($order_type == 'desc' ? 'desc' : 'asc');
	$this->table->set_heading(
	'Line', 'Network', 'From', 'To', 'Dist', 'Sched','Shown', 'Billed', 'Price','Total');
	 $upd = array(
              'width'      => '900',
              'height'     => '800',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
			
	//if ($query->num_rows() > 0){		
	$data['name'] = $this->legacyinvoicingprintmodel->get_customer($order_column);
	$data['add1'] = $this->legacyinvoicingprintmodel->get_add1($order_column);
	$data['add2'] = $this->legacyinvoicingprintmodel->get_add2($order_column);
	
	$data['city'] = $this->legacyinvoicingprintmodel->get_city($order_column);
	$data['state'] = $this->legacyinvoicingprintmodel->get_state($order_column);
	$data['zip'] = $this->legacyinvoicingprintmodel->get_zip($order_column);
	
	$data['syscode'] =$this->legacyinvoicingprintmodel->get_systemcode($order_column);
	//$data['StartDate'] =$Users->t2SD;
	$data['StartDate'] =$astartdate;
	//$data['EndDate'] =$Users->t2ED;
	$data['EndDate'] =$aenddate;
	
	$data['cn'] =$this->legacyinvoicingprintmodel->get_contractname($order_column);
	$data['co'] =$this->legacyinvoicingprintmodel->get_custorder($order_column);
	
	//$data['cn'] = "";
	//$data['co'] ="";
	
	$nBilled =0;
	$TotalOrders = 0;
	$TotalPrice = 0;
	$offset = 0;
	
	
	$i = 0 + $offset;
	foreach ($Users as $Users) {
		
	$gda =$this->GetDistributionAmount($Users->t1S1, $Users->t1E1, $Users->t1D);
	//$gda =$this->count_billed_spots($Users->t1S1, $Users->t1E1, $Users->t1D);
				
	if 	($gda <> 0){
	$this->table->add_row(
	//Line Column
	$Users->t1L,
	//Network Column
	$Users->t1N,
	//Start Date Column
	
	//$Users->t1S1,
	$this->GetStartDate($Users->t1S1, $Users->TimeOn),
	//End Date Column
	//$Users->t1E1,
	$this->GetEndDate($Users->t1E1, $Users->TimeOff),
	//Distribution Column
	$this->GetDistribution($Users->t1D),
	//No of order Column
	
	$gda ,
	
	'0',
	
	$nBilled,
	//Price Comlumn
	number_format($Users->t1U,2),
	//"0",
	number_format(($gda * $Users->t1U),2), 
		
	""
	);
	}
	 //Total Order Computation
	$TotalOrders = $TotalOrders + ($gda);
	$TotalPrice = $TotalPrice +($gda * $Users->t1U);
	 
	}
	
	 //$Users1 = $this->legacyinvoicingprintmodel->get_customer_detail($Users->t2CI)->result();
	
	$this->table->add_row("","","","Total Order","",$TotalOrders,"","","",number_format($TotalPrice,2));
	 
	$data['totalprice'] = $TotalPrice;
	
	
		$data['contractno'] =$order_column;
	$data['spotname'] =$this->legacyinvoicingprintmodel->get_spotnames($order_column);
	$data['table'] = $this->table->generate();
	
	$data['title'] = 'All Sites'; 
	 
		// load view
		$data['Role']=$this->session->userdata('role');
		
		$this->load->view('pages/template/invoice_header');
		//$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/invoicingprint_view', $data);
		
		
		//$this->load->view('pages/template/footer');
	 }
	}

?>