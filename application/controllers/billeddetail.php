

<?php

    ini_set('memory_limit', '2048M');
    ini_set('max_execution_time', '6000');
	set_time_limit(6000);
	ini_set("display_errors", "on");
	//ini_set('memory_limit', '-1');


if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");
     
      // sets memory size/limit for this controller and execution time
 

class Billeddetail extends CI_Controller{	
	
	function __construct()
 	{
		parent::__construct();
	   //loads library and , helper, model
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('billeddetailmodel','',TRUE);
		$this->is_logged_in();
 	}
	  //check if the user has user permission or login timeout
	function is_logged_in()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!isset($is_logged_in) || $is_logged_in != true){
		echo 'you don\'t have permission to access this page.';
		//echo '<a href="'.site_url(/pages/login)'">Login</a>';
		die();
		}	
	} 
	 
	//function index($yr, $mo)
	function index()
	{
    // ob_start();
	
	$currentuser = $this->session->userdata('username');
	$astartdate = $this->billeddetailmodel->get_billingstartdate($currentuser);
	$aenddate = $this->billeddetailmodel->get_billingenddate($currentuser);
	
	$StartDate = date('Y-m-d',strtotime($astartdate));
	$EndDate = date('Y-m-d',strtotime($aenddate));
	
	//popup attributes
	 $upd = array(
    'class'     =>  'blue-button',
    'width'     =>  '900',
    'height'    =>  '600',
    'screenx'   =>  '\'+((parseInt(screen.width) - 800)/2)+\'',
    'screeny'   =>  '\'+((parseInt(screen.height) - 600)/2)+\'',
);
			
	
	
	// load data
	
	$id = $this->session->userdata('username');
	$Users = $this->billeddetailmodel->get_paged_list()->result();
	
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/billeddetail/index/');
	$config['total_rows'] = $this->billeddetailmodel->count_sitename_active();
	$config['per_page'] =  $this->billeddetailmodel->count_sitename_active();
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
 
    
 
	// generate table data
	
	
	$this->load->library('table');
	$this->table->set_empty("");
	//$new_order = ($order_type == 'desc' ? 'desc' : 'asc');
	
	$tmpl = array ( 'table_open'  => '<table id="table2excel" class="table2excel">' );
	$this->table->set_template($tmpl);
	
	$this->table->set_heading('Num','SysCode','Customer','ContractName','Sched', 'Billed','Gross','Net','Select');
		
	//$i = 0 + $offset;
	$TotalNet = 0;
	foreach ($Users as $Users) {
	
	//$sb= $this->billeddetailmodel->get_spotbilled($Users->t2S,$astartdate, $aenddate);
    
	$booked = $this->billeddetailmodel->get_contract_details($Users->t2S, $StartDate, $EndDate);
	$sb = $this->billeddetailmodel->count_billed_spots($Users->t2S,$astartdate, $aenddate);
	
	//$sb = $this->billeddetailmodel->get_spotbilled($Users->t2S,$astartdate, $aenddate);
	if ($sb >= $booked){
	$spotbilled = $booked;	
		} else {
		$spotbilled	= $sb;
			}
	
	$grossbilled = $this->billeddetailmodel->get_gross($Users->t2S,$astartdate, $aenddate);
	$netbilled = $this->billeddetailmodel->ComputeNet($Users->t2S, $grossbilled);
	$this->table->add_row(
	
	//anchor(array('bookingdetailall/index/'.$Users->t2SN,$Users->t2SC),$Users->t2SN,array('class'=>'viewdetails')),
	$Users->t2S,
	$Users->sCO,
	$Users->t2SC,
	$Users->chCN,
	//
	//'click Select',//,
	$booked,
	//number_format($billedgross,2),
	//'to view',//,
	$spotbilled,
	
	//0.0,//,
	number_format($grossbilled,2),
	
	//0.0,//
	number_format($netbilled,2),
	anchor_popup((array('legacyinvoicingcn/index',$Users->t2S)),'Select',array('class'=>'contractsview'),$upd)
	//anchor('legacyinvoicingcn/index', 'title="legacyinvoicing"', array('target' => '_blank', 'class' => 'new_window'))
	
	);
	
	$TotalNet =  $TotalNet + $netbilled;
	
	}
	$this->table->add_row("","","","TOTAL","","","",number_format($TotalNet,2),"");
	$data['table'] = $this->table->generate();
	
	$data['title'] = 'All Sites'; 
	$data['title1'] = 'From '.$astartdate." to ".$aenddate; 
	 
	 
	 
	 
	// load view
	$data['Role']=$this->session->userdata('role');
	
	// $data['output'] = ob_get_clean();
		
		
	
	
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/billeddetail_view', $data);
		$this->load->view('pages/template/footer');
		
		//$this->db->cache_delete_all();
	//	$this->db->cache_delete('billeddetail', 'index');
		//$this->db->cache_delete('blog', 'comments');
		//$this->db->cache_delete('blog', 'comments');
	 }
	 
	
	 
	}




?>