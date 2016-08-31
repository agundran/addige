<script>

window.onunload = function(){
  window.opener.location.reload();
};


</script>

<?php

ini_set('memory_limit', 512000000);
    ini_set('max_execution_time', -1);
	
require_once("system/core/Common.php");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

     
	  
class Legacysetcustomer extends CI_Controller
{
	private $limit = 12;
 		
	function __construct()
 	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	 	$this->load->model('legacysetcustomermodel','',TRUE);
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
	 
	 
	function index(){
	
	
	if (empty($custcode)) $custcode =null;
	$custcode = $this->input->post('custcode');
	
	$data['action'] = site_url('legacysetcustomer/index/'.$custcode);
	

	$data['currentuser'] = $this->session->userdata('username');
	$myuser = $data['currentuser'];
	$astartdate = $this->legacysetcustomermodel->get_billingstartdate($myuser);
	$aenddate = $this->legacysetcustomermodel->get_billingenddate($myuser);
	$cm = $this->legacysetcustomermodel->get_currentmonth($myuser);
	$StartDate = date('Y-m-d',strtotime($astartdate));
	$EndDate = date('Y-m-d',strtotime($aenddate));
	 
	$upd = 
	 array(
              'width'      => '1300',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
	

    //Put the value in an array to pass to the view. 
   
	$data['custcode']= $custcode;
	

    //Pass to the value to the view. Access it as '$search' in the view.
    //$this->load->view("about", $view_data);
	
	
	
	$data['title1'] = 'Current Billing Period is: '.$cm." ".'('.$StartDate." "."to"." ".$EndDate.")";		
	//$data['setbm'] = anchor('BillingSetInvoicingMonth/index/'.$custcode,'(change)',array('class'=>'changebillingmonth'));
	$data['setbm'] = anchor_popup('BillingSetUpdate/index/','(change)',array('class'=>'changebillingmonth'),$upd);
	
	if ($custcode == null){
		$data['createinvoice'] ="";
		$data['custname'] = "";
		}else{
	
	   //$data['createinvoice'] = anchor('legacyinvoicing/index/'.$syscode,'&#10152  Generate ',array('class'=>'createinvoice'));
	   
	   $data['custname'] = $this->legacysetcustomermodel->get_customer_name($custcode);
	   $data['createinvoice'] = anchor_popup('legacyinvoicingcust/index/'.$custcode,'&#10152  Generate ',array('class'=>'createinvoice'),$upd);
	   
		}
	
	
	 
	// redirect('legacyinvoicing/index/'.$syscode,'Refresh');
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/legacysetcustomer_view', $data);
		
	 }
	 


	
	 
	}
	
?>

