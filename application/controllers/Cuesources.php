<?php
require_once("system/core/Common.php");

class Cuesources extends CI_Controller
{
	private $limit = 30;
 
 	function __construct(){
		parent::__construct();
	 	#load library  helper 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('CueSourcesmodel','',TRUE);
 	}
	 
	function index($offset = 0, $order_column = '', $order_type = 'asc'){
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = '';
		if (empty($order_type)) $order_type = 'asc';
		//TODO: check for valid column
		// load data
		$Users = $this->CueSourcesmodel->get_paged_list($this->limit, $offset, $order_column, $order_type)->result();
	 
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/Cuesources/index');
		$config['total_rows'] = $this->CueSourcesmodel->count_all_results();
		$config['per_page'] = $this->limit;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		
		//foreach ($subs as $subs){
		//$subs = strstr($Users->Network,'*',true);
		
		//}
		
		$this->table->set_heading(
		anchor('Cuesources/index/'.$offset.'/Networks/'.$new_order, 'Network'),
		anchor('Cuesources/index/'.$offset.'/SiteName/'.$new_order, 'Site Name'),
		anchor('Cuesources/index/'.$offset.'/SSID/'.$new_order, 'SSID'),
		anchor('Cuesources/index/'.$offset.'/SysCode'.$new_order, 'SysCode'),
		anchor('Cuesources/index/'.$offset.'/City'.$new_order, 'Location')
		
		);
	
	    
	 
		$i = 0 + $offset;
		foreach ($Users as $Users) {
	
		 	
			$this->table->add_row(
			
			$Users->net,
			$Users->SiteName,			
			$Users->SSID,
			$Users->SysCode,
			$Users->loc,
			'');
			
	 	}
	 
		$data['table'] = $this->table->generate();
	
		 
		// load view
	 	 $data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/Cuesources_view', $data);
		$this->load->view('pages/template/footer');
	 
		}
	
	}
	
?>

