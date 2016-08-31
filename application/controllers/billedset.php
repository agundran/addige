<script>

window.onunload = function(){
  window.opener.location.reload();
};


</script>

<?php
require_once("system/core/Common.php");

class Billedset extends CI_Controller
{
	private $limit = 12;
 		
	function __construct()
 	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	 	$this->load->model('legacysetmodel','',TRUE);
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
	
	
	
	
	$data['action'] = site_url('billedset/index/');
	

	$data['currentuser'] = $this->session->userdata('username');
	$myuser = $data['currentuser'];
	$astartdate = $this->legacysetmodel->get_billingstartdate($myuser);
	$aenddate = $this->legacysetmodel->get_billingenddate($myuser);
	$cm = $this->legacysetmodel->get_currentmonth($myuser);
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
    
	
  
    //Pass to the value to the view. Access it as '$search' in the view.
    //$this->load->view("about", $view_data);
	
	
	
	$data['title1'] = 'Current Billing Period is: '.$cm." ".'('.$StartDate." "."to"." ".$EndDate.")";		
	//$data['setbm'] = anchor('BillingSetInvoicingMonth/index/'.$syscode,'(change)',array('class'=>'changebillingmonth'));
	$data['setbm'] = anchor_popup('BillingSetUpdate/index/','(change)',array('class'=>'changebillingmonth'),$upd);
	
	
	
	   //$data['createinvoice'] = anchor('legacyinvoicing/index/'.$syscode,'&#10152  Generate ',array('class'=>'createinvoice'));
	   
	   $data['createinvoice'] = anchor('billeddetail/index/','&#10152  Generate ',array('class'=>'createinvoice'));
	   $data['title']="Create Invoices / Logs";
		$data['title2']="Summary";
		

	 
	// redirect('legacyinvoicing/index/'.$syscode,'Refresh');
	// load view
		$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/billedset_view', $data);
		
		
		
		//$this->load->view('pages/template/footer');
		
	 }
	 
	
	
		
		
		
	 
	 
	}
	
?>

