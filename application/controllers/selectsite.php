<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");

class Selectsite extends CI_Controller
{
	private $limit = 20;
 	
	
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('selectsitemodel','',TRUE);
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
 
	function index($offset = 0, $order_column = 'SysCode', $order_type = 'asc'){
		
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'SysCode';
		if (empty($order_type)) $order_type = 'asc';
		
		$currentuser = $this->session->userdata('username');
	$data['StartDate'] = $this->selectsitemodel->get_billingstartdate($currentuser);
	$data['EndDate'] = $this->selectsitemodel->get_billingenddate($currentuser);  
	
	
		$filter  = $this->input->post('SysCode');
		//TODO: check for valid column
		
			$atts = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
			
		// load data
		$Users = $this->selectsitemodel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/selectsite/index/');
		
		//$config['total_rows'] = $this->selectsitemodel->count_all($order_column);
		$config['total_rows'] = $this->selectsitemodel->count_all($order_column);;
		
		$config['per_page'] = $this->limit;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 		$data['title'] = "Per Site Table";
		
		
		// generate table datav
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		anchor('selectsite/index/'.$offset.'/SysCode/'.$new_order, 'SysCode'),
		anchor('selectsite/index/'.$offset.'/SiteName/'.$new_order, 'Site Name'), //'Actions'),
		anchor('selectsite/index/'.$offset.'/City/'.$new_order, 'City'),
		anchor('selectsite/index/'.$offset.'/State/'.$new_order, 'State'),
		
		//anchor('selectsite/index/'.$offset.'/HENumber/'.$new_order, ' HE'),
		
		'Actions');
	 
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			$Users->SysCode,
			$Users->SiteName,
			$Users->City,
			$Users->State,
			
			//$Users->HENumber,
			
		
	
		anchor((array('contractsview/index/'.$Users->$offset=0,$Users->SiteName,$Users->SysCode,$Users->$order_type='asc'))   ,'Select',array('class'=>'contractsview')));
		
		//anchor('selectsite/copy/'.$Users->SiteName,'Copy Entry',array('class'=>'copy') ) 
		//.'   '.
		
		//anchor('selectsite/delete/'.$Users->SiteName,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Contract?')")))
		
	 	}
	 
		$data['table'] = $this->table->generate();
	
	 
		// load view
	 	 $data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/selectsite_view', $data);
		$this->load->view('pages/template/footer');
	 
	
	}
	
	
}

?>

