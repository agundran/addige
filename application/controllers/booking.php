<script>

window.onunload = function(){
  window.opener.location.reload();
};


</script>

<?php
require_once("system/core/Common.php");

class Booking extends CI_Controller
{
	private $limit = 12;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('bookingmodel','',TRUE);
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
	 
	 
	function index($offset = 0, $order_column = 'Year', $order_type = 'desc')
	
	{
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'Year';
	if (empty($order_type)) $order_type = 'desc';
	
	 $upd = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
	$filter  = $this->input->post('Year');
	//TODO: check for valid column
	// load data
	$Users = $this->bookingmodel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/booking/index');
	$config['total_rows'] = $this->bookingmodel->count_all();
	$config['per_page'] = $this->limit;
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'desc' ? 'desc' : 'asc');
	$this->table->set_heading('Year','Month','Start Date','End Date','Select');
	
	$i = 0 + $offset;
	foreach ($Users as $Users) {
	$this->table->add_row(
	$Users->Year,
	$Users->Month,
	$Users->Start_Date,
	$Users->End_Date,
	
	
	anchor(array('bookingdetail/index/'.$Users->Year,$Users->Month),'Select',array('class'=>'select')));
	 
	}
	 
	$data['title'] = 'Broadcast Calendar'; 
	$data['table'] = $this->table->generate();
	
			
	
	 
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/booking_view', $data);
		$this->load->view('pages/template/footer');
	 }
	 
	
	
		
		
		
	 
	 
	}
	
?>

