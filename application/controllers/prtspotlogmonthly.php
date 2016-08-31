


<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");

	
class Prtspotlogmonthly extends CI_Controller{	
	
	private $limit = 132;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('prtspotlogmonthlymodel','',TRUE);
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
		 
	
		
	function format_date($aED){
		 return date("M j, Y",(strtotime($aED)));		 
		 }	  
	 
	 function format_day($aED){
		 return date("l",(strtotime($aED)));		 
		 }	 
	 
	function index($ContractNo, $SD, $ED)
	
	{
	if (empty($offset)) $offset = 0;
	//if (empty($order_column)) $ContractNo = 'Seq';
	if (empty($order_type)) $order_type = 'asc';
	
	$currentuser = $this->session->userdata('username');
	$astartdate = $this->prtspotlogmonthlymodel->get_billingstartdate($currentuser);
	$aenddate = $this->prtspotlogmonthlymodel->get_billingenddate($currentuser);
	
	// load data
	$Users = $this->prtspotlogmonthlymodel->get_paged_list($ContractNo, $astartdate, $aenddate)->result();

	 //$Users2 = $this->prtspotlogmonthlymodel->get_spotnames($order_column);
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/prtspotlogmonthly/index/');
	//$config['total_rows'] = $this->prtspotlogmonthlymodel->count_all($ContractNo);
	
	//$config['per_page'] = $this->prtspotlogmonthlymodel->count_all($ContractNo);
	
	//$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	//$new_order = ($order_type == 'desc' ? 'desc' : 'asc');
	$this->table->set_heading(
	'Seq', 'Date', 'Weekday', 'Network', 'SysCode', 'Program Name','Air Time', 'Spot Name', 'Length','Price');
	
			
	
	$TotalOrders = 0;
	$TotalPrice = 0;
	$c = 0;
	$i = 0 + $offset;
	foreach ($Users as $Users) {
	
	
	 if (strpos($Users->siSp, ' ') == true) {
       	$sn = "<font color='red'>"."Check Spot Name!"."</font>";;
   					 } else {
			$sn = $Users->siSp;
					 }
					 
	$this->table->add_row(
	//Line Column
	$Users->siS,
	//Network Column
	date("M d, Y",strtotime($Users->siT)),
	//Start Date Column
	date("l",strtotime($Users->siT)),
	//End Date Column
	$Users->siN,
	//Distribution Column
	$this->prtspotlogmonthlymodel->get_syscode($Users->chS),
	//No of order Column
	$this->prtspotlogmonthlymodel->get_progname($Users->siN),
	SUBSTR($Users->siT,11),
	
	//$Users->siSp,
	$sn,
	$Users->siR,
	//Price Comlumn
	number_format($Users->siP,2)
	);
	 
	$c++; 
	}
	
	
	$this->table->add_row("","","","","","","","","","");
	$this->table->add_row("Total Spots","",$c,"","","","","",'',"");
	 
	//$data['totalprice'] = $TotalPrice;
	
//	$data['name'] =$Users->t3N;
	//$data['add1'] =$Users->t3A1;
	//$data['add2'] =$Users->t3A2;
	
	//$data['city'] =$Users->t3C;
	//$data['state'] =$Users->t3S;
	//$data['zip'] =$Users->t3Z;
	
	//$data['syscode'] =$Users->t4S;
	
	//$data['StartDate'] =$Users->t2SD;
	//$data['StartDate'] =$astartdate;
	//$data['EndDate'] =$Users->t2ED;
	//$data['EndDate'] =$aenddate;
	
	//$data['cn'] =$Users->t2CN;
	//$data['co'] =$Users->t2CO;
//		$data['contractno'] =$order_column;
	
	$data['name'] = $this->prtspotlogmonthlymodel->get_customer($ContractNo);
	//$data['syscode'] =$this->prtspotlogmonthlymodel->get_systemcode($ContractNo);
	//$data['StartDate'] =$Users->t2SD;
	$data['StartDate'] =$astartdate;
	//$data['EndDate'] =$Users->t2ED;
	$data['EndDate'] =$aenddate;
	
	//$data['sd'] =$this->prtspotlogmonthlymodel->get_sd($ContractNo);
	$data['sd'] =($astartdate);
	
	//$data['ed'] =$this->prtspotlogmonthlymodel->get_ed($ContractNo);
	$data['ed'] =($aenddate);
	
	$data['cc'] = $ContractNo;
	$data['cn'] =$this->prtspotlogmonthlymodel->get_contractname($ContractNo);
	$data['co'] =$this->prtspotlogmonthlymodel->get_custorder($ContractNo);
	
	$data['spotname'] =substr($this->prtspotlogmonthlymodel->get_spotnames($ContractNo),1,32);
	$data['table'] = $this->table->generate();
	
	 
	 
		// load view
		$data['Role']=$this->session->userdata('role');
		
		$this->load->view('pages/template/spotlog_header');
		$this->load->view('pages/prtspotlog_view', $data);
		
		
	 }
}

?>