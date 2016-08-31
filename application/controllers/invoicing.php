<?php


  
    ini_set('max_execution_time', '1500');
	set_time_limit(1500);
	ini_set("display_errors", "on");
	
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");
   

	
class Invoicing extends CI_Controller{	
	
	private $limit = 200;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('invoicingmodel','',TRUE);
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
	 
	 
	function index($offset = 0, $order_column='SiteName', $order_type = 'asc')
	
	{
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'SiteName';
	if (empty($order_type)) $order_type = 'asc';
	
	$currentuser = $this->session->userdata('username');
	$astartdate = $this->invoicingmodel->get_billingstartdate($currentuser);
	$aenddate = $this->invoicingmodel->get_billingenddate($currentuser);
	
	$StartDate = date('Y-m-d',strtotime($astartdate));
	$EndDate = date('Y-m-d',strtotime($aenddate));
	
	
	$filter  = $this->input->post('SiteName');
	//TODO: check for valid column
	// load data
	$Users = $this->invoicingmodel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter, $StartDate, $EndDate)->result();
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/invoicing/index/');
	$config['total_rows'] = $this->invoicingmodel->count_all();
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
	
	$this->table->set_heading('Site Name','SysCode','Gross','Net','Select');
	
	 $upd = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
			
	$i = 0 + $offset;
	$total  = 0;
	foreach ($Users as $Users) {
		
	$gross = $this->invoicingmodel->get_contracts($Users->t2SN, $astartdate, $aenddate);
		
	$this->table->add_row(
	$Users->t2SN,
	$Users->t2SC,
	//'0.0',	
	
	number_format($gross,2),
	
	
	//number_format($this->invoicingmodel->get_totalamt($Users->t2SN),2),
	'0.0',	
	
	anchor_popup(array('invoicingbysite/index/'.$Users->t2SN,$Users->t2SC),'View Details',array('class'=>'view'),$upd));
	//anchor(array('invoicingbysite/index/'.$Users->t2SN,$Users->t2SC),'View Details',array('class'=>'view')));
	$total = $total + $gross; 
	}
	 
	// $this->table->add_row("TOTAL","",number_format($total,2));
	$data['table'] = $this->table->generate();
	


	
			
	if ($this->uri->segment(3)=='delete_success')
	$data['message'] = 'The Data was successfully deleted';
	else if ($this->uri->segment(3)=='add_success')
	$data['message'] = 'The Data has been successfully added';
	else
	$data['message'] = '';
	 
	$data['title'] = 'All Sites'; 
	$data['title1'] = 'From '.$StartDate." to ".$EndDate; 
	 
	 
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/invoicing_view', $data);
		$this->load->view('pages/template/footer');
	 }
	}

?>