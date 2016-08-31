<?php
require_once("system/core/Common.php");

class mappinglist extends CI_Controller
{
	private $limit = 20;
 	
	
	function __construct()
 	{
		parent::__construct();
	 	#load library dan helper yang dibutuhkan
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('mappingmodel','',TRUE);
 	}
	 
	function index($offset = 0, $order_column = 'Username', $order_type = 'asc')
	{
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'Username';
		if (empty($order_type)) $order_type = 'asc';
		//TODO: check for valid column
		// load data
		
		$filter  = $this->input->post('ShortName');
		
		$Users = $this->mappingmodel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
	 
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/mappinglist/index');
		//$config['base_url'] = $myhostname.'/index.php/manageuserlist/index';
		$config['total_rows'] = $this->mappingmodel->count_all();
		$config['per_page'] = $this->limit;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		anchor('mappinglist/index/'.$offset.'/SiteName/'.$new_order, 'Site Name'),
		anchor('mappinglist/index/'.$offset.'/SSID/'.$new_order, 'SSID'),
		anchor('mappinglist/index/'.$offset.'/SysCode/'.$new_order, 'SysCode'),
		anchor('mappinglist/index/'.$offset.'/City/'.$new_order, 'City'),
		anchor('mappinglist/index/'.$offset.'/State/'.$new_order, 'State'),'Actions');
		
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			
			$Users->SiteName,
			$Users->SSID,			
			$Users->SysCode,
			$Users->City,
			$Users->State,
			
			
		anchor(array('mappinglistupdate/index/'.$offset,$Users->ShortName,$order_type),'Select',array('class'=>'update')));
	 	}
	 
		$data['table'] = $this->table->generate();
	
		
	   
		// load view
	 	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/mappinglist_view', $data);
		$this->load->view('pages/template/footer');
	 	
	}
	 
		
	
	

	
	 
	
	} 

?>

