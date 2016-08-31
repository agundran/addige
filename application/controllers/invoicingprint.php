<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");

	
class Invoicingprint extends CI_Controller{	
	
	private $limit = 132;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('invoicingprintmodel','',TRUE);
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
    	$DaysRep = explode("-",$Distribution);
	    
			
		 $Schedule = "";
	 	for($i=0;$i<=6;$i++){
	   			if ($DaysRep[$i] != "0"){
			   $Schedule = $Schedule.$DaysOfWeek[$i];
	 	   }
		 }
	 	return $Schedule;
	}
	
	// this is function for computing total number of orders for a specific broadcast calendar
	function GetDistributionAmount($aStartDate, $aEndDate, $aStartDay, $aEndDay, $Dist){
	 
	 $currentuser = $this->session->userdata('username');
	 $bStartDate = $this->invoicingprintmodel->get_billingstartdate($currentuser);
	 $bEndDate = $this->invoicingprintmodel->get_billingenddate($currentuser);
	 
	  $sday = intval($aStartDay);
	  $eday = intval($aEndDay);
	 
	  $StartDate= strtotime($aStartDate);
	  $EndDate = strtotime($aEndDate);
	  $bmStartDate= strtotime($bStartDate);
	  $bmEndDate = strtotime($bEndDate);
	     //adjusting start and end dates depending on the start and end days of specific contract detail   
	   if ($sday > 0 and $sday < 6) {
			$StartDate = strtotime($aStartDate . "+".$sday." days");
		   	}
	   if ($eday < 6 and $eday > 0){ 
			$EndDate = strtotime($aEndDate . "-".(1 * (6 - $eday))." days");
			}
	  
	  
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
	  //$xDist = str_replace("-", "", $Dist);
      
	  //$aDist = str_split($xDist);
        $aDist = explode('-',$Dist);
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
		 $bStartDate = $this->invoicingprintmodel->get_billingstartdate($currentuser);
		  $bEndDate = $this->invoicingprintmodel->get_billingenddate($currentuser);
		 
		 $bmStartDate = strtotime($bStartDate);
		 $bmEndDate = strtotime($bEndDate);
		 
		 $SD = strtotime($aSD);
		 
		 if ($SD < $bmStartDate ){
			 
			  return date("M d ,Y",$bmStartDate)." ".$ton;
			 	 }
			 else   if  ($SD >= $bmStartDate)
			 {
			return date("M d,Y", $SD)." ".$ton;
			}
	 		}
			
			
	
		 
	function GetEndDate($aED, $toff){
		 $currentuser = $this->session->userdata('username');
		$bEndDate = $this->invoicingprintmodel->get_billingenddate($currentuser);
	
	    $ED = strtotime($aED);
		$bmEndDate = strtotime($bEndDate);
		 
		   if ($ED > $bmEndDate){
			 
			 return date("M d, Y",$bmEndDate)." ".$toff;
			 } elseif  ($ED == $bmEndDate){
				  return date("M d, Y",$ED)." ".$toff;
				 
				 }
			 
			 
			 else {
				 
				 return date("M d, Y", $ED)." ".$toff;
				 			  
		     }
		 
		 }	 
		 
		 
		 //	if($EndDate > $bmEndDate)
		//	{$uEndDate =date('Y-m-d', ($bmEndDate));}
			//else{
	//		$uEndDate = date('Y-m-d', ($EndDate));
		//	}
	    
	 
	function index($order_column,$StartDate, $EndDate)
	
	{
	
	$currentuser = $this->session->userdata('username');
	$astartdate = $this->invoicingprintmodel->get_billingstartdate($currentuser);
	$aenddate = $this->invoicingprintmodel->get_billingenddate($currentuser);
	
	// load data
	$Users = $this->invoicingprintmodel->get_contract_details($order_column,$StartDate, $EndDate)->result();
    //$Users2 = $this->invoicingprintmodel->get_spotnames($order_column);
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/invoicingprint/index/');
	$config['total_rows'] = $this->invoicingprintmodel->count_all($order_column);
	
	$config['per_page'] = $this->invoicingprintmodel->count_all($order_column);
	
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
	$data['name'] = $this->invoicingprintmodel->get_customer($order_column);
	$data['add1'] = $this->invoicingprintmodel->get_add1($order_column);
	$data['add2'] = $this->invoicingprintmodel->get_add2($order_column);
	
	$data['city'] = $this->invoicingprintmodel->get_city($order_column);
	$data['state'] = $this->invoicingprintmodel->get_state($order_column);
	$data['zip'] = $this->invoicingprintmodel->get_zip($order_column);
	
	$data['syscode'] =$this->invoicingprintmodel->get_systemcode($order_column);
	//$data['StartDate'] =$Users->t2SD;
	$data['StartDate'] =$astartdate;
	//$data['EndDate'] =$Users->t2ED;
	$data['EndDate'] =$aenddate;
	
	$data['cn'] =$this->invoicingprintmodel->get_contractname($order_column);
	$data['co'] =$this->invoicingprintmodel->get_custorder($order_column);
	
	$data['cy'] = $this->invoicingprintmodel->get_current_year($currentuser);
	$data['cm'] = $this->invoicingprintmodel->get_current_month($currentuser);
	//$data['cn'] =m "";
	//$data['co'] ="";
	
	$nBilled =0;
	$TotalOrders = 0;
	$TotalBilled = 0;
	$TotalShown = 0;
	$TotalPrice = 0;
	$Discount = 0;
	$AmountDue = 0;
	
	$offset = 0;
	
		$i = 0 + $offset;
	foreach ($Users as $Users) {
		
	$gda = $this->GetDistributionAmount($Users->t1S1, $Users->t1E1, $Users->t1SD1,$Users->t1ED1 ,$Users->t1D);	
	
	
	
	$gss = $this->invoicingprintmodel->get_spotshown($Users->t1L,$Users->t2SD,$Users->t2ED);
	if ($gss <= $gda){
	
	$ta = $gss * $Users->t1U;
	$billed = $gss;
	
	} else{
		$ta = $gda * $Users->t1U;
		$gss = $gda;
		$billed = $gda;
	}
	
	
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
	
	$gda,
	
	$gss,
	$billed,
	
	
	//Price Comlumn
	number_format($Users->t1U,2),
	//"0",
	number_format($ta,2), 
		
	""
	);
	$TotalOrders +=  $gda;
	
	$TotalBilled += $billed;
	$TotalShown += $gss;
	$TotalPrice += $ta;
	
	
	}
	 //Total Order Computation
	
	 
	}
	
	 //$Users1 = $this->invoicingprintmodel->get_customer_detail($Users->t2CI)->result();
	
	$this->table->add_row("","","","Total Order","",$TotalOrders,$TotalShown,$TotalBilled,"",number_format($TotalPrice,2));
	 
	$data['totalprice'] = number_format($TotalPrice,2);
	$AmountDue = $this->invoicingprintmodel->ComputeNet($Users->t1C,$TotalPrice);
	$Discount = $TotalPrice - $AmountDue;
	
	$data['discount']	= number_format($Discount,2);
	
	
	$data['due'] = number_format($AmountDue,2);
	
		$data['contractno'] =$order_column;
	$data['spotname'] =$this->invoicingprintmodel->get_spotnames($order_column);
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