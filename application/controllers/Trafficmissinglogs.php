
<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");
     
      // sets memory size/limit for this controller and execution time
      ini_set('memory_limit', '-1'); 
	  ini_set ('max_execution_time', 10000);

class Trafficmissinglogs extends CI_Controller{	
	
	function __construct()
 	{
		parent::__construct();
	   //loads library and , helper, model
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('TrafficMissingLogsmodel','',TRUE);
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
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'SiteName';
	if (empty($order_type)) $order_type = 'asc';
	
	$currentuser = $this->session->userdata('username');
		
		 	$data1 = array('Year' => $yr,
							'Month' => $mo);
	$this->TrafficMissingLogsmodel->update($currentuser,$data1);
		
		$astartdate = $this->TrafficMissingLogsmodel->get_billingstartdate($currentuser);
		$aenddate = $this->TrafficMissingLogsmodel->get_billingenddate($currentuser);
		
		//$limit = $this->input->post('hours');		
		
		//TODO: check for valid column
		// load data
		//$Users = $this->TrafficMissingLogsmodel->get_paged_list()->result();
		
		
	// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/Trafficmissinglogs/index');
		//$config['total_rows'] = $this->TrafficMissingLogsmodel->count_all();
		
		
				
		//$config['per_page'] =$limit;
		
		$config['uri_segment'] =3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['title'] = "Addige User Profile";
		$data['print_them'] = site_url('/Trafficmissinglogs/print_user');
		
 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
	
		
		

	 	
	 
		$data['table'] = $this->table->generate();
	
		if ($this->uri->segment(3)=='delete_success')
			$data['message'] = 'The Data was successfully deleted';
		else if ($this->uri->segment(3)=='add_success')
			$data['message'] = 'The Data has been successfully added';
		else if ($this->uri->segment(3)=='update_success')
			$data['message'] = 'The Data has been successfully updated';
		else
		$data['message'] = '';
	 
		// load view
	 	$data['Role']=$this->session->userdata('role');
		
		$atts = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		
		$data['print_me'] = anchor_popup('/Trafficmissinglogs/print_user/','Print User List',array('class'=>'print_hello_world'),$atts);
		
		
	//$data['table'] = $this->table->generate();
	
	 
$data['title'] = 'All Sites'; 
	$data['title1'] = 'From '.$astartdate." to ".$aenddate; 
	 
	 
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/TrafficMissinglogs_view', $data);
		$this->load->view('pages/template/footer');
	 }
	 
	 function sitecontract($sitename){
		 
		$currentuser = $this->session->userdata('username');
		$astartdate = $this->TrafficMissingLogsmodel->get_billingstartdate($currentuser);
		$aenddate = $this->TrafficMissingLogsmodel->get_billingenddate($currentuser);
	
		 $Users = $this->TrafficMissingLogsmodel->get_contract_no($sitename,$astartdate,$aenddate )->result(); 
		 $mytotal = 0;
			$mytotcon = 0;
		
	foreach($Users as $Users){
		$mytotal = number_format($this->TrafficMissingLogsmodel->ComputeNet($Users->c1Se,$this->TrafficMissingLogsmodel->ComputeContractValue($Users->c1Se) ),2) ;
		
		$mytotcon += $mytotal;
		}		 
		 
	return $mytotcon;	 
		 }
	 
	 
	 function view($sitename,$bookedgross){
		 
		 $currentuser = $this->session->userdata('username');
		$astartdate = $this->TrafficMissingLogsmodel->get_billingstartdate($currentuser);
		$aenddate = $this->TrafficMissingLogsmodel->get_billingenddate($currentuser);
		
		 $data['title'] = 'Booked Revenue for '.$sitename;
		 $data['title1'] ='from '.$astartdate.' to '.$aenddate;
		 $data['gross'] = $bookedgross;
		// $data['net'] = "0.0";
		 $data['net'] = $this->TrafficMissingLogsmodel->computepersitenet($sitename);
		 
		 
		 $this->load->view('pages/template/header2');
		 $this->load->view('pages/bookingdetailgn_view', $data);
		 }
	 
	}

?>