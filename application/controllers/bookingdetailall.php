<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

  ini_set('memory_limit', '-1'); 
	  ini_set ('max_execution_time', 10000);
	  
require_once("system/core/Common.php");

class Bookingdetailall extends CI_Controller{	
	
	private $limit = 5000;
 		
	function __construct()
 	{parent::__construct();
	 
	#load library 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('bookingdetailallmodel','',TRUE);
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
	 
	 
	function index($SiteName, $SysCode)
	{
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'SiteName';
	if (empty($order_type)) $order_type = 'asc';
	
	$currentuser = $this->session->userdata('username');
	$astartdate = $this->bookingdetailallmodel->get_billingstartdate($currentuser);
	$aenddate = $this->bookingdetailallmodel->get_billingenddate($currentuser);
	
	$StartDate = date('Y/m/d',strtotime($astartdate));
	$EndDate = date('Y/m/d',strtotime($aenddate));
	
	
	$Users = $this->bookingdetailallmodel->get_paged_list($SiteName,$StartDate, $EndDate)->result();
	 
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/bookingdetailall/index/');
	$config['total_rows'] = $this->limit;
	//$this->bookingdetailallmodel->count_all($order_column, $StartDate, $EndDate);
	$config['per_page'] = $this->limit;
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
 
    
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'desc' ? 'desc' : 'asc');
	$tmpl = array ( 'table_open'  => '<table id="table2excel" class="table2excel">' );
	$this->table->set_template($tmpl);
	
	$this->table->set_heading('Num','Contract Name','Start Date','End Date','Contract Spots','Gross','Net');
	
	$TotalOrders = 0;
	$TotalNet = 0;
	$i = 0 + $offset;
	
	foreach ($Users as $Users) {
		
	$cs = $this->bookingdetailallmodel->ComputeSpots($Users->c1Se);	
	$ccv =$this->bookingdetailallmodel->ComputeContractValue($Users->c1Se);	
	$cn = $this->bookingdetailallmodel->ComputeNet($Users->c1Se,$ccv);
	
	if ($cs<>0){
	$this->table->add_row(

	$Users->c1Se,
	
	$Users->c1C,
	
	$Users->c1S,

	$Users->c1E,
	
	$cs,
	number_format($ccv,2),
	number_format($cn ,2) 	
	
	);}
	
	 $TotalOrders = $TotalOrders + $ccv;
    	$TotalNet =  $TotalNet + $cn;
	
	}
	 
	 $this->table->add_row("Total","","","","",number_format($TotalOrders,2),number_format($TotalNet,2) );
	 
	$data['table'] = $this->table->generate();
	
	 $upd = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
	
	 
	$data['title'] = 'All Contracts for '.$SiteName .' '.'('.$SysCode.')'; 
	$data['title1'] = 'From '.$StartDate." to ".$EndDate; 
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/bookingdetailall_view', $data);
		$this->load->view('pages/template/footer');
	 }
	}

?>