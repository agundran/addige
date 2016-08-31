<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");

	
class Ebilldetailmonthly extends CI_Controller{	
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('table','form_validation'));
		$this->load->helper(array('form','url'));
		$this->load->model('ebilldetailmonthlymodel','',TRUE);
		$this->is_logged_in();
		}
		
	function is_logged_in()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!isset($is_logged_in) || $is_logged_in != true){
		echo 'you don\'t have permission to access this page.';
		 redirect('pages/login');
		die();
		}	
	} 
	private $limit = 25;
	
	function index($seq){
		
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'Seq';
		if (empty($order_type)) $order_type = 'asc';
		if (empty($filter)) $filter= 0;
		
		$currentuser = $this->session->userdata('username');
		$StartDate = $this->ebilldetailmonthlymodel->get_billingstartdate($currentuser);
		$EndDate = $this->ebilldetailmonthlymodel->get_billingenddate($currentuser);
		
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
		
		$Users = $this->ebilldetailmonthlymodel->get_contract_detail($seq)->result();
	 
	 	 
	 	// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/ebilldetailmonthly/index');
		
		//$config['total_rows'] = $this->ebilldetailmonthlymodel->count_all();
		//$config['total_rows'] = 2000;
		$config['total_rows'] = $this->ebilldetailmonthlymodel->count_all($seq);
		;
		
		//$config['per_page'] = $this->limit;
		$config['per_page'] = 20;
		
		$config['uri_segment'] = 3;
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 		$data['title'] = "Contracts for:  ".$this->ebilldetailmonthlymodel->get_customer_name($seq);
		$data['title1'] = 'Billing Date from '.$StartDate.' to '.$EndDate;
	
		
		// generate table datav
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading('Contract','SysCode','SiteName','ContractName','StartDate','EndDate','Invoice','Spot Log');
	 
		$i = 0 + $offset;
		$data['tblmsg'] = "";
		foreach ($Users as $Users) {
			
			if ($Users->c1Se == null){
			$data['tblmsg'] = "No Contracts were found";
				
				}else{
			$this->table->add_row(
			$Users->c1Se,
			$Users->c4S,
			$Users->c1SN,
			$Users->c1C,
			$Users->c1S,
			$Users->c1E,
			//$Users->c2D,
			//anchor_popup(array('ebilldetailmonthly/view/'.$Users->c1Se),'View',array('class'=>'view'),$upd),
			anchor_popup(array('invoicingprintmonthly/index/'.$Users->c1Se,$Users->c1S,$Users->c1E),'Print Invoice',array('class'=>'print_preview'), $upd),
			anchor_popup(array('prtspotlogmonthly/index/'.$Users->c1Se,$Users->c1S,$Users->c1E),'Print Log',array('class'=>'prtspotlog'), $upd)
			//$Users->c2P
				)
				;
		
		//anchor('selectsite/copy/'.$Users->SiteName,'Copy Entry',array('class'=>'copy') ) 
		//.'   '.
		
		//anchor('selectsite/delete/'.$Users->SiteName,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Contract?')")))
				}
	 	
	 
			}
		$data['table'] = $this->table->generate();
	
	 
		// load view
	 	 $data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/ebilldetail_view', $data);
		$this->load->view('pages/template/footer');
	 
		
		}
	
	
	
	 function view($contractno){
		 
		 $currentuser = $this->session->userdata('username');
		$astartdate = $this->ebilldetailmonthlymodel->get_billingstartdate($currentuser);
		$aenddate = $this->ebilldetailmonthlymodel->get_billingenddate($currentuser);
		
		 $data['title'] = 'Invoice Summary for '.$contractno;
		 $data['title1'] ='from '.$astartdate.' to '.$aenddate;
		 $data['gross'] = $this->ebilldetailmonthlymodel->ComputeContractValue($contractno);
		 $data['net'] = "0.0";
		// $data['net'] = $this->ebilldetailmonthlymodel->computepersitenet($sitename);
		 
		 
		 $this->load->view('pages/template/header2');
		 $this->load->view('pages/bookingdetailgn_view', $data);
		 }
		 
	
	}

?>