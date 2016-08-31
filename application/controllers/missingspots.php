

<?php
require_once("system/core/Common.php");

class Missingspots extends CI_Controller
{
	private $limit = 25;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('missingspotsmodel','',TRUE);
 		$this->is_logged_in();
 	}
	 
	 function is_logged_in()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!isset($is_logged_in) || $is_logged_in != true){
		echo 'you don\'t have permission to access this page. <a href="'. redirect(site_url('/pages/login')).'>Login</a>';
		die();
		}	
	} 
	 
	 
	function index($offset = 0, $order_column = 'SysCode', $order_type = 'asc')
	//function index()
	
	{ 
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'SysCode';
	if (empty($order_type)) $order_type = 'asc';
	
	
	$filter  = $this->input->post('CalendarType');
	//TODO: check for valid column
	// load data
	$Users = $this->missingspotsmodel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
	//$Users = $this->missingspotsmodel->get_paged_list()->result();
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/missingspots/index/');
	
	$config['total_rows'] = $this->missingspotsmodel->count_all();
	
	$config['per_page'] = $this->limit;
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	//$data['pagination'] = $this->pagination->create_links();
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
	$this->table->set_heading('MIS ID','SiteName','SysCode','Date','SpotName', 'Attempts','Contract');
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
	foreach ($Users as $Users) {
	 	if ($Users->mid != null){
	     	
	$this->table->add_row(
	$Users->mid,
	
	$Users->ams,
	
	$Users->sos,
	$Users->amd,
	//'',
	$Users->amsn,
	$Users->ama,
	//'',
	//''
	$Users->amc
	//$Users->hec
	
	
	//anchor_popup('missingspots/update/'.$Users->ShortName,'Update',array('class'=>'update'), $upd),
	//anchor('missingspots/delete/'.$Users->ShortName,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Operator?')"))
	);
		}
		
		else {
			$this->table->add_row("","No Missing Spots!","");
			
			}
	}
	 
	$data['table'] = $this->table->generate();
	//$data['title'] = 'Missing Spots '.date("Y-m-d");
	$data['title'] = 'Missing Spots ';
	 
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/missingspots_view', $data);
		$this->load->view('pages/template/footer');
	 }
	 
	
	
	 
	 
	}
	
?>

