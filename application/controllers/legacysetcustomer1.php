<script>

window.onunload = function(){
  window.opener.location.reload();
};


</script>

<?php
require_once("system/core/Common.php");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

      ini_set('memory_limit', '128M'); 
	  //ini_set ('max_execution_time', 10000);
	  set_time_limit(0);
class Legacysetcustomer1 extends CI_Controller
{
	private $limit = 12;
 		
	function __construct()
 	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	 	$this->load->model('legacysetcustomer1model','',TRUE);
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
	
	
	if (empty($custcode) & empty($syscode)) $custcode =null;$syscode =null;
	$custcode = $this->input->post('custcode');
	$syscode = $this->input->post('syscode');
	
	
	$data['action'] = site_url('legacysetcustomer1/index/'.$custcode.'/'.$syscode);
	

	$data['currentuser'] = $this->session->userdata('username');
	$myuser = $data['currentuser'];
	$astartdate = $this->legacysetcustomer1model->get_billingstartdate($myuser);
	$aenddate = $this->legacysetcustomer1model->get_billingenddate($myuser);
	$cm = $this->legacysetcustomer1model->get_currentmonth($myuser);
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
	$data['syscode']= $syscode;
     $data['sysname'] =0 ;
    //Pass to the value to the view. Access it as '$search' in the view.
    //$this->load->view("about", $view_data);
	
	
	
	$data['title1'] = 'Current Billing Period is: '.$cm." ".'('.$StartDate." "."to"." ".$EndDate.")";		
	$data['setbm'] = anchor_popup('BillingSetUpdate/index/'.$custcode,'(change)',array('class'=>'changebillingmonth'),$upd);
	
	if ($custcode == null & $syscode == null){
		$data['createinvoice'] ="";
		$data['custname'] = "";
		$data['sysname'] = "";
		
		}else if($data['syscode'] == "All Sites"){
			$data['sysname'] = "";
		$data['custname'] = $this->legacysetcustomer1model->get_customer_name($custcode);
	 	$data['createinvoice'] = anchor('legacyinvoicingcust/index/'.$custcode,'&#10152  Generate ',array('class'=>'createinvoice'));
	   //$data['createinvoice'] = anchor('legacyinvoicing/index/'.$syscode,'&#10152  Generate ',array('class'=>'createinvoice'));
		} else {
			
			
				   $data['sysname'] = $this->legacysetcustomer1model->get_sysname($syscode);
	   $data['custname'] = $this->legacysetcustomer1model->get_customer_name($custcode);
	   
	   
	   $data['createinvoice'] = anchor((array('legacyinvoicingcust/invoicebysite/'.$custcode,$syscode)),'&#10152  Generate ',array('class'=>'createinvoice'));
	   }
		
	
	
	 
	// redirect('legacyinvoicing/index/'.$syscode,'Refresh');
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/legacysetcustomer1_view', $data);
		
	 }
	 


	
	 
	}
	
?>

