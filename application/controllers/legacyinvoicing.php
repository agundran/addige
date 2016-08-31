<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");
    ini_set('memory_limit', '-1'); 
 ini_set ('max_execution_time', 10000);
	
class Legacyinvoicing extends CI_Controller{	
	
	private $limit = 5000;
 		
	function __construct()
 	{
		parent::__construct();
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url','file'));
		
	 	$this->load->model('legacyinvoicingmodel','',TRUE);
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
	 
	function index($syscode)
	
	{
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'Seq';
	if (empty($order_type)) $order_type = 'asc';
	
	$currentuser = $this->session->userdata('username');
	$aStartDate = $this->legacyinvoicingmodel->get_billingstartdate($currentuser); 
	$aEndDate = $this->legacyinvoicingmodel->get_billingenddate($currentuser);
	
	//$StartDate = date('Y/n/d',strtotime($aStartDate));
	$StartDate = date('Y-m-d',strtotime($aStartDate)) or date('Y/m/d',strtotime($aStartDate));
	//$EndDate = date('Y/n/d',strtotime($aEndDate));
	$EndDate = date('Y-m-d',strtotime($aEndDate)) or date('Y/m/d',strtotime($aEndDate));
	//$StartDate = str_replace("-", "/", $aStartDate);
	//$EndDate = str_replace("-", "/", $aEndDate);
	
	$filter  = $this->input->post('Seq');
	//config popup window
	 $upd = 
	 array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
	//TODO: check for valid column
	// load data
	
	//$limit = $this->legacyinvoicingmodel->count_all( $StartDate,$EndDate);
	$Users = $this->legacyinvoicingmodel->get_paged_list( $syscode, $StartDate,$EndDate)->result();
	
	// generate paginationthis
	$this->load->library('pagination');
	//$tc = $this->legacyinvoicingmodel->count_all( $StartDate,$EndDate );
	$config['base_url'] = site_url('/legacyinvoicing/index/');
	
	$config['total_rows'] = 10000;
	
	$config['per_page'] = 1000;
	
	$config['uri_segment'] = 3;
	$config['num_links']     = 4;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
    
	
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'desc' ? 'desc' : 'asc');
	
	$tmpl = array ( 'table_open'  => '<table id="table2excel" class="table2excel">' );
	$this->table->set_template($tmpl);
		$this->table->set_heading(
	'Contract#','SysCode','Customer Name','Contract Name','Sched','Billed','Gross','Net','Action','');
	 
	$tccv = 0;
	$tcn = 0;		
	$i = 0 + $offset;
		foreach ($Users as $Users) {
			
			$cs = $this->legacyinvoicingmodel->ComputeSpots($Users->c1Se);
			$cbs = $this->legacyinvoicingmodel->count_billed_spots($Users->c1Se,$StartDate,$EndDate);
			$ccv = $this->legacyinvoicingmodel->ComputeContractValue($Users->c1Se,$StartDate,$EndDate);
			$cn = $this->legacyinvoicingmodel->ComputeNet($Users->c1Se,$ccv);
			if ($cs <> 0){
			$this->table->add_row(
				$Users->c1Se,
				$Users->c1SN,
				$Users->c1CI,
				$Users->c1C,
				$cs,
	            $cbs,
				//'0.0',
				number_format($ccv,2),
				//'0.0',
				number_format($cn,2),	
				
				anchor_popup(array('invoicingprint/index/'.$Users->c1Se,$Users->c1S,$Users->c1E),'Invoice',array('class'=>'print_preview'), $upd),
				anchor_popup(array('prtspotlog/index/'.$Users->c1Se,$StartDate,$EndDate),'Spot Log',array('class'=>'print_preview'), $upd)
				);
				
			$tccv += $ccv;
			$tcn += $cn;	
				
		}
		
		}
	$this->table->add_row("","","Total","","","",number_format($tccv,2),number_format($tcn,2),"","");
	
		
    $data['filewrite'] =anchor_popup(array('/legacyinvoicing/writefile/'.$Users->c1Se,$aStartDate,$aEndDate),'Here',array('class'=>'export'),$upd);
	 $sysname = $this->legacyinvoicingmodel->get_sysname($syscode);
		
	$data['table'] = $this->table->generate();
	$data['title'] = 'SysCode: '.$syscode. ' -  ' .$sysname; 
	$data['title1'] = 'From '.$StartDate.' to '.$EndDate;
	$data['sc'] = $syscode;
	 
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/legacyinvoicing_view', $data);
		$this->load->view('pages/template/footer');
		
		
		
	 }
	
	
  function writefile($Seq,$sd,$ed){
	  
	  	ini_set('memory_limit', '2048M'); 
	    ini_set ( 'max_execution_time', 7000);
	
		$currentuser = $this->session->userdata('username');
		$month = $this->legacyinvoicingmodel->get_billingmonth($currentuser); 
		
		$aStartDate = $this->legacyinvoicingmodel->get_billingstartdate($currentuser); 
		$aEndDate = $this->legacyinvoicingmodel->get_billingenddate($currentuser);
	
	
			
	$query = $this->legacyinvoicingmodel-> filter_contractno($aStartDate,$aEndDate);
	
		
	//$date = '2015-07-01';	
	$filename = 'All.'.$aStartDate.'.txt';	
	//$data = "MONTH;".$month.";".$aStartDate.";".$aEndDate.";"."\r\n";
    $data = "MONTH;".$month.";".$sd.";".$ed.";"."\r\n";
    
	
	
	
	foreach($query->result() as $row){
             $data = $data. 
			 $this->legacyinvoicingmodel->get_customers_data($row->c1Se)."\r\n" 
			//;
			 .$this->legacyinvoicingmodel->get_agency_data($row->c1A)."\r\n" 
		 	//;
			 .$this->legacyinvoicingmodel->get_oper_data($row->c1SN)."\r\n" 
			
			 //."CONTRACT;" 
			 .$this->legacyinvoicingmodel->get_contract_data($row->c1C)."\r\n"
			 
			 ;
             
		//	 ."SCHED;" 
		//	 .$this->legacyinvoicingmodel->get_contract_detail($row->c1C)."\n";
			
               
       }
	
	
	
    if ( ! write_file('./downloads/'.$filename, $data))
    {
            $message = "file export error!";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           	window.close ();
        		</script>';
   			 }
    }
    else
    {
            
			$message = $filename." file successful exported";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
          	window.close ();
        		</script>';
   			 }
    }
		}		 
		
	
	
	


	
}

?>