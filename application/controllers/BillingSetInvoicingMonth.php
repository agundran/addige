
<?php
require_once("system/core/Common.php");

class BillingSetInvoicingMonth extends CI_Controller
{
	private $limit = 12;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('BillingSetInvoicingMonth_model','',TRUE);
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
	
	function index($offset = 0, $order_column = 'Year', $order_type = 'desc')
	{
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'Year';
	if (empty($order_type)) $order_type = 'desc';
	//TODO: check for valid column
	// load data
	
		$atts = array(
        'width'       => 800,
        'height'      => 600,
        'scrollbars'  => 'yes',
        'status'      => 'yes',
        'resizable'   => 'yes',
        'screenx'     => 0,
        'screeny'     => 0,
	     'window_name' => '_blank'
		);

			
	$Users = $this->BillingSetInvoicingMonth_model->get_paged_list($this->limit, $offset, $order_column, $order_type)->result();
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/BillingSetInvoicingMonth/index');
	$config['total_rows'] = $this->BillingSetInvoicingMonth_model->count_all();
	$config['per_page'] = $this->limit;
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
    $data['username']=$this->session->userdata('username');
	
    $user1 = $data['username'];
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
	$this->table->set_heading('Year','Month','Start Date','End Date','Action');
	
	
	$i = 0 + $offset;
	foreach ($Users as $Users) {
	$this->table->add_row(
	
	$Users->Year,
	$Users->Month,
	$Users->Start_Date,
	$Users->End_Date,
	
	
	anchor_popup(array('BillingSetInvoicingMonth/update/'.$user1,$Users->Year,$Users->Month,$Users->Start_Date, $Users->End_Date),'Select',array('class'=>'update'),$atts));
	 
	}
	
	$data['currentuser'] = $this->session->userdata('username');
	$myuser = $data['currentuser'];
	$astartdate = $this->BillingSetInvoicingMonth_model->get_billingstartdate($myuser);
	$aenddate = $this->BillingSetInvoicingMonth_model->get_billingenddate($myuser);
	$cm = $this->BillingSetInvoicingMonth_model->get_currentmonth($myuser);
	$StartDate = date('Y-m-d',strtotime($astartdate));
	$EndDate = date('Y-m-d',strtotime($aenddate));
	 
	
	$data['table'] = $this->table->generate();
	$data['title'] = 'Broadcast Calendar';
	$data['title1'] = 'Current Month is: '.$cm." ".'('.$StartDate." "."to"." ".$EndDate.")";
	
	
	if ($this->uri->segment(3)=='delete_success')
	$data['message'] = 'The Data was successfully deleted';
	else if ($this->uri->segment(3)=='update_success')
	$data['message'] = 'Invoicing Month Successfully Updated';
	else
	$data['message'] = '';
	 
	// load view
	$data['Role']=$this->session->userdata('role');
	
	
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/BillingSetInvoicingMonthList_view', $data);
		$this->load->view('pages/template/footer');
	 }
	 
	 
	 
	 
	 
function update($id,$year,$month, $sd, $ed){
	 
	// set common properties
	 	$data['title'] = 'Set Broadcast Calendar ';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('BillingSetInvoicingMonth/update/'.$id."/".$year."/".$month."/".$sd."/".$ed);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	
	 	//$data['Users'] = (array)$this->broadcastcalendarmodel->get_by_id($year,$month)->row();
	 	
		$data['title'] = 'Set Broadcast Calendar';
		$data['Users']['UserName'] = $id;
	 	$data['Users']['Year'] = $year;
		$data['Users']['Month'] = $month;
		$data['Users']['Start_Date'] = $sd;
		$data['Users']['End_Date'] = $ed;
		
		 	
		$data['message'] = '';
		 
	
	 	}else{
			
			//$data['Users'] = $this->broadcastcalendarmodel->get_by_id($year,$month)->row();
	 
	// save data
	    //$id =$this->session->userdata('username');
	 		
		//$year = $this->input->post('Year');
		//$month = $this->input->post('Month');
	 	
	 	$User = array(
				
	 			'Year' => $this->input->post('Year'),
				'Month' => $this->input->post('Month')
				);
	 	//var_dump($User);
		
	 	$this->BillingSetInvoicingMonth_model->update($id,$User);
	 	//$data['Users'] = (array)$this->manageoperatormodel->get_by_id($id)->row();
	 
	// set user message
	
		$message = "Calendar Updated successful";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		 window.opener.location.reload();
				window.close ();
        		</script>';
   			 }
			 
	 	
		
		//message
	
	 	}
	 	//$data['link_back'] = anchor('manageoperatorlist/index/','Back to Operator List',array('class'=>'back'));
	 
	// load view
	$data['Role']=$this->session->userdata('role');
	 		$this->load->view('pages/template/header2');
			//$this->load->view('pages/template/nav',$data);
	 		$this->load->view('pages/broadcastcalendarset_view', $data);
			//$this->load->view('pages/template/footer');
			
	 	}
		
		

	 

	// validation rules
	 function _set_rules(){
			$this->form_validation->set_rules('UserName', 'UserName','required|trim'); 
	 }
	 
	function user_exists($username){
    	$this->BillingSetInvoicingMonth_model->user_exists($username);
	}
	 
	 
	 
	 
	}
	 

?>

