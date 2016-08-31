<?php


    ini_set('memory_limit', '2048M');
    ini_set('max_execution_time', '5000');
	set_time_limit(5000);
	ini_set("display_errors", "on");
	
	
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");


class Ebillsummary extends CI_Controller{	
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('table','form_validation'));
		$this->load->helper(array('form','url'));
		$this->load->model('ebillsummarymodel','',TRUE);
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
	
	
	function index($offset=0,$order_column='',$order_type='asc'){
		
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'ShortName';
		if (empty($order_type)) $order_type = 'asc';
		if (empty($filter)) $filter= 0;
		
	$currentuser = $this->session->userdata('username');
	$BMStartDate = $this->ebillsummarymodel->get_billingstartdate($currentuser);
	$BMEndDate = $this->ebillsummarymodel->get_billingenddate($currentuser);
	
		 $upd = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		
		
		$filter  = $this->input->post('Name');
		
		$limit =  $this->ebillsummarymodel->count_all();
		$Users = $this->ebillsummarymodel->get_paged_list($limit, $offset, $order_column, $order_type, $filter)->result();
	 
	 	 
	 	// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/billingelectronic/index');
		
		$config['total_rows'] = $this->ebillsummarymodel->count_all();
		$config['per_page'] =  $this->ebillsummarymodel->count_all();
		
		$config['uri_segment'] = 3;
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 		$data['title'] = "All Customers";
		$data['title2'] = "From"." ".$BMStartDate." "."to"." ".$BMEndDate;
	
		
		// generate table datav
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		
		$tmpl = array ( 'table_open'  => '<table id="table2excel" class="table2excel">' );
		$this->table->set_template($tmpl);
	
		$this->table->set_heading('Customer','Gross Booked', 'Gross Earned',
	
		'Select');
	 
		$i = 0 + $offset;
		$totalgch = 0;
		foreach ($Users as $Users) {
			
			$gch = $this->ebillsummarymodel->computepercust($Users->Seq, $BMStartDate, $BMEndDate);
			
			$this->table->add_row(
			
			$Users->Name,
			
			//'0.0',
			number_format($gch,2),
			'0.0',
			//anchor_popup(array('ebillsummary/view/'.$Users->Seq),'View Details',array('class'=>'view'),$upd)
			anchor_popup(array('legacyinvoicingcust/index/'.$Users->Seq),'View Details',array('class'=>'view'),$upd)
			
		);
		 $totalgch += $gch;
		
		
		
	 	}
	 
	 	$this->table->add_row("Total",number_format($totalgch,2),"0.00","");
		$data['table'] = $this->table->generate();
	
	 
		// load view
	 	 $data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/ebillsummary_view', $data);
		$this->load->view('pages/template/footer');
	 
		
		}
		
		
		function view($seq){
		 
		 $currentuser = $this->session->userdata('username');
		$astartdate = $this->ebillsummarymodel->get_billingstartdate($currentuser);
		$aenddate = $this->ebillsummarymodel->get_billingenddate($currentuser);
		$cn = $this->ebillsummarymodel->get_customername($seq);
		
		 $data['title'] = 'Booked Revenue for '.$cn."(".$seq.")";
		 $data['title1'] ='from '.$astartdate.' to '.$aenddate;
		 $data['gross'] = $this->ebillsummarymodel-> get_contract_header($seq);
		// $data['net'] = "0.0";
		 $data['net'] = $this->ebillsummarymodel->computepercustomernet($seq);
		 
		 
		 $this->load->view('pages/template/header2');
		 $this->load->view('pages/bookingdetailgn_view', $data);
		 }
	 	 
		
		
	
	}

?>