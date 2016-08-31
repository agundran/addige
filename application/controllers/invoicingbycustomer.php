<?php


    ini_set('max_execution_time', '1500');
	set_time_limit(1500);
	ini_set("display_errors", "on");
	
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");
   

	
class Invoicingbycustomer extends CI_Controller{	
	
	private $limit = 132;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('invoicingbycustomermodel','',TRUE);
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
	$BMStartDate = $this->invoicingbycustomermodel->get_billingstartdate($currentuser);
	$BMEndDate = $this->invoicingbycustomermodel->get_billingenddate($currentuser);
		
		 $show = false;
		
		 $upd = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		
		//$filter1 = 	$this->input->post('myselect');
		//$filter  = $this->input->post('myvalue');
		
		$limit =  $this->invoicingbycustomermodel->count_all();
		//$Users = $this->invoicingbycustomermodel->get_paged_list($limit, $offset, $order_column, $order_type, $filter, $filter1)->result();
	 $Users = $this->invoicingbycustomermodel->get_paged_list($limit, $offset, $order_column, $order_type)->result();
	 	 
	 	// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/billingelectronic/index');
		
		$config['total_rows'] = $this->invoicingbycustomermodel->count_all();
		$config['per_page'] =  $this->invoicingbycustomermodel->count_all();
		
		$config['uri_segment'] = 3;
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 		$data['title'] = "All Customers";
	    $currentuser = $this->session->userdata('username');
		$data['sd'] = $BMStartDate;
		$data['ed'] = $BMEndDate;
		
	
		
		// generate table datav
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		
		$tmpl = array ( 'table_open'  => '<table id="table2excel" class="table2excel">' );
		$this->table->set_template($tmpl);
	
		$this->table->set_heading('ID','Name','Booked','Net','Select');
	 
		$i = 0 + $offset;
		$totalcontracts = 0;
		
		foreach ($Users as $Users) {
			//if ($Users->Name != ""){
			$gch = $this->invoicingbycustomermodel->computepercust($Users->Seq, $BMStartDate, $BMEndDate);
			
			if ($gch > 0){
			$this->table->add_row(
			$Users->Seq,
			$Users->Name,
			
			
			number_format($gch,2),
			'0.0',
		//	anchor_popup(array('invoicingbycustomer/view/'.$Users->Seq),'View Details',array('class'=>'view'),$upd),
			
			
			
			
		
	
		//anchor_popup('ebilldetail/index/'.$Users->Seq,'View Contracts',array('class'=>'billingview'),$upd));
		
		anchor_popup(array('legacyinvoicingcust/index/'.$Users->Seq),'View Details',array('class'=>'view'),$upd)
			
		);
		 $totalcontracts += $gch;
		
		if (count($Users) == 0){
			$show = true;
			}
		 
		//anchor('selectsite/copy/'.$Users->SiteName,'Copy Entry',array('class'=>'copy') ) 
		//.'   '.
		
		//anchor('selectsite/delete/'.$Users->SiteName,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Contract?')")))
			//}
	 	}
		}
	     
		 if ($show == false){
			$this->table->add_row("Total","",number_format($totalcontracts,2),"","");
		
			}else{ 
	 		$this->table->add_row("","No Existing Contracts!","","","");
			}
		
		$data['table'] = $this->table->generate();
	
	 
		// load view
	 	 $data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/invoicingbycustomer_view', $data);
		$this->load->view('pages/template/footer');
	 
		
		}
		
		
		function view($seq){
		 
		 $currentuser = $this->session->userdata('username');
		$astartdate = $this->invoicingbycustomermodel->get_billingstartdate($currentuser);
		$aenddate = $this->invoicingbycustomermodel->get_billingenddate($currentuser);
		$cn = $this->invoicingbycustomermodel->get_customername($seq);
		
		 $data['title'] = 'Booked Revenue for '.$cn."(".$seq.")";
		 $data['title1'] ='from '.$astartdate.' to '.$aenddate;
		 $data['gross'] = $this->invoicingbycustomermodel-> get_contract_header($seq);
		// $data['net'] = "0.0";
		 $data['net'] = $this->invoicingbycustomermodel->computepercustomernet($seq);
		 
		 
		 $this->load->view('pages/template/header2');
		 $this->load->view('pages/bookingdetailgn_view', $data);
		 }
	 	 
		
		
	
	}

?>