
<?php

    ini_set('memory_limit', '2048M');
    ini_set('max_execution_time', '3000');
	set_time_limit(3000);
	ini_set("display_errors", "on");
	
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");
     
      // sets memory size/limit for this controller and execution time
     

class Bookingdetail extends CI_Controller{	
	
	function __construct()
 	{
		parent::__construct();
	   //loads library and , helper, model
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('bookingdetailmodel','',TRUE);
		$this->is_logged_in();
 	}
	  //check if the user has user permission or login timeout
	function is_logged_in()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!isset($is_logged_in) || $is_logged_in != true){
		echo 'you don\'t have permission to access this page.';
		 redirect('pages/login');
		die();
		}	
	} 
	 
	 
	function index($yr, $mo)
	
	{
	ob_start();
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'SiteName';
	if (empty($order_type)) $order_type = 'asc';
	
	$currentuser = $this->session->userdata('username');
		
		 	$data1 = array('Year' => $yr,
							'Month' => $mo);
	$this->bookingdetailmodel->update($currentuser,$data1);
		
	$astartdate = $this->bookingdetailmodel->get_billingstartdate($currentuser);
	$aenddate = $this->bookingdetailmodel->get_billingenddate($currentuser);
	
	$StartDate = date('Y-m-d',strtotime($astartdate));
	$EndDate = date('Y-m-d',strtotime($aenddate));
	
	//popup attributes
	 $upd = array(
    'class'     =>  'blue-button',
    'width'     =>  '800',
    'height'    =>  '600',
    'screenx'   =>  '\'+((parseInt(screen.width) - 800)/2)+\'',
    'screeny'   =>  '\'+((parseInt(screen.height) - 600)/2)+\'',
);
			
	
	$filter  = $this->input->post('SiteName');
	// load data
	
	$id = $this->session->userdata('username');
	$Users = $this->bookingdetailmodel->get_paged_list()->result();
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/bookingdetail/index/');
	$config['total_rows'] = $this->bookingdetailmodel->count_sitename_active();
	$config['per_page'] =  $this->bookingdetailmodel->count_sitename_active();
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
 
    
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'desc' ? 'desc' : 'asc');
	
	$tmpl = array ( 'table_open'  => '<table id="table2excel" class="table2excel">' );
	$this->table->set_template($tmpl);
	
	$this->table->set_heading('Site Name','SysCode','Gross','Net');
		
	$TotalBooked = 0;
	$TotalNet = 0;
	$bookedgross=0;	
	$booked = 0;
	$i = 0 + $offset;
	
	foreach ($Users as $Users) {
	$bookedgross = $this->bookingdetailmodel->computepersite($Users->t2SN, $astartdate, $aenddate);
	$bookednet = $this->bookingdetailmodel->computepersitenet($Users->t2SN, $astartdate, $aenddate );
	//$bookednet = 0;
	
	$this->table->add_row(
	
	anchor(array('bookingdetailall/index/'.$Users->t2SN,$Users->t2SC),$Users->t2SN,array('class'=>'viewdetails')),
	
	$Users->t2SC,
	
	//'0.0',
	number_format($bookedgross,2),
	//'0.0'
	number_format($bookednet,2)
	);
	$TotalBooked =  $TotalBooked + $bookedgross;
	
	$TotalNet =  $TotalNet + $bookednet;
	 
	}
	$this->table->add_row("TOTAL","",number_format($TotalBooked,2),number_format($TotalNet,2));
	//$this->table->add_row("TOTAL","",number_format($TotalBooked,2),'');
	//number_format($TotalNet,2));
	
	$data['table'] = $this->table->generate();
	
	 
	$data['title'] = 'All Sites'; 
	$data['title1'] = 'From '.$astartdate." to ".$aenddate; 
	$data['output'] =  ob_get_clean(); 
	 
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/bookingdetail_view', $data);
		$this->load->view('pages/template/footer');
	 }
	 
	 function sitecontract($sitename){
		 
		$currentuser = $this->session->userdata('username');
		$astartdate = $this->bookingdetailmodel->get_billingstartdate($currentuser);
		$aenddate = $this->bookingdetailmodel->get_billingenddate($currentuser);
	
		 $Users = $this->bookingdetailallmodel->get_contract_no($sitename,$astartdate,$aenddate )->result(); 
		 $mytotal = 0;
			$mytotcon = 0;
		
	foreach($Users as $Users){
		$mytotal = number_format($this->bookingdetailallmodel->ComputeNet($Users->c1Se,$this->bookingdetailallmodel->ComputeContractValue($Users->c1Se) ),2) ;
		
		$mytotcon += $mytotal;
		}		 
		 
	return $mytotcon;	 
		 }
	 
	 
	 function view($sitename,$bookedgross){
		 
		 $currentuser = $this->session->userdata('username');
		$astartdate = $this->bookingdetailmodel->get_billingstartdate($currentuser);
		$aenddate = $this->bookingdetailmodel->get_billingenddate($currentuser);
		
		 $data['title'] = 'Booked Revenue for '.$sitename;
		 $data['title1'] ='from '.$astartdate.' to '.$aenddate;
		 $data['gross'] = $bookedgross;
		// $data['net'] = "0.0";
		 $data['net'] = $this->bookingdetailmodel->computepersitenet($sitename);
		 
		 
		 $this->load->view('pages/template/header2');
		 $this->load->view('pages/bookingdetailgn_view', $data);
		 }
	 
	}

?>