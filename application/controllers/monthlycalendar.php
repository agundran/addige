<script>

window.onunload = function(){
  window.opener.location.reload();
};


</script>

<?php
require_once("system/core/Common.php");

class Monthlycalendar extends CI_Controller
{
	private $limit = 12;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('monthlycalendarmodel','',TRUE);
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
	 
	 
	function index($offset = 0, $order_column = 'Year', $order_type = 'desc')
	
	{
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'Year';
	if (empty($order_type)) $order_type = 'desc';
	
	
	$filter  = $this->input->post('Year');
	//TODO: check for valid column
	// load data
	$Users = $this->monthlycalendarmodel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/monthlycalendar/index');
	$config['total_rows'] = $this->monthlycalendarmodel->count_all();
	$config['per_page'] = $this->limit;
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'desc' ? 'desc' : 'asc');
	$this->table->set_heading(
	anchor('monthlycalendar/index/'.$offset.'/Year/'.$new_order, 'Year'),
	anchor('monthlycalendar/index/'.$offset.'/Month/'.$new_order, 'Month'),
	anchor('monthlycalendar/index/'.$offset.'/Start_Week/'.$new_order, 'Start Week'),
	anchor('monthlycalendar/index/'.$offset.'/End_Week/'.$new_order, 'End Week'),
	anchor('monthlycalendar/index/'.$offset.'/Start_Date/'.$new_order, 'Start Date'),
	anchor('monthlycalendar/index/'.$offset.'/End_Date/'.$new_order, 'End Date'),
	'Actions',"");
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
	$this->table->add_row(
	$Users->Year,
	$Users->Month,
	$Users->Start_Week,
	$Users->End_Week,
	$Users->Start_Date,
	$Users->End_Date,
	
	
	anchor_popup(array('monthlycalendar/update/'.$Users->Year,$Users->Month),'Update',array('class'=>'update'), $upd),
	anchor(array('monthlycalendar/delete/'.$Users->Year,$Users->Month),'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Calendar Entry?')"))
	);
	 
	}
	 
	$data['table'] = $this->table->generate();
	
	 $upd = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
			
	if ($this->uri->segment(3)=='delete_success')
	$data['message'] = 'The Data was successfully deleted';
	else if ($this->uri->segment(3)=='add_success')
	$data['message'] = 'The Data has been successfully added';
	else
	$data['message'] = '';
	 
	 $data['add_calendar'] = anchor_popup('monthlycalendar/validate_add','Add Calendar Entry',array('class'=>'addentry'),$upd);
	 
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/monthlycalendar_view', $data);
		$this->load->view('pages/template/footer');
	 }
	 
	
	function validate_add()
	{
	$data['title'] = 'Add Monthly Calendar';
	$data['action'] = site_url('monthlycalendar/validate_add');
	
	$this->_set_rules();

	// run validation
		if ($this->form_validation->run() === FALSE){
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Add new Monthly Calendar';
			$data['message'] = '';
			$data['Users']['Year']='';
			$data['Users']['Month']='';
			$data['Users']['Start_Week']='';
			$data['Users']['End_Week']='';
			$data['Users']['Start_Date']='';
			$data['Users']['End_Date']='';
			
			
			
			$data['Role']=$this->session->userdata('role');
			
				$this->load->view('pages/template/header2');
				$this->load->view('pages/monthlycalendaredit_view', $data);
			
		
		}else{
		
			// save data
		     
				$year = $this->input->post('Year');
				$month = $this->input->post('Month');
	 			$startweek = $this->input->post('Start_Week');
				$endweek = $this->input->post('End_Week');
				$startdate = $this->input->post('Start_Date');
				$enddate = $this->input->post('End_Date');
				
			
			$id = $this->monthlycalendarmodel->create_calendar($year,$month,$startweek,$endweek,$startdate,$enddate);
			
			$message = "New Calendar has been created";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
				 window.opener.location.reload();
				window.close ();
        		</script>';
			//redirect('manageoperatorlist/index/add_success','Refresh');
			 }
		}
	}
	
			
	
	function update($year,$month){
	 
	// set common properties
	 	$data['title'] = 'Update Operator';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('monthlycalendar/update/'.$year."/".$month);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	
	 	$data['Users'] = (array)$this->monthlycalendarmodel->get_by_id($year,$month)->row();
	 	$data['title'] = 'Update Calendar : ' .$year ." / ".$month;
		$data['message'] = '';
		 
	
	 	}else{
			
			$data['Users'] = $this->monthlycalendarmodel->get_by_id($year,$month)->row();
	 
	// save data
		$year = $this->input->post('Year');
		$month = $this->input->post('Month');
	 	
	 	$User = array(
				
	 			'Start_Week' => $this->input->post('Start_Week'),
				'End_Week' => $this->input->post('End_Week'),
				'Start_Date' => $this->input->post('Start_Date'),
				'End_Date' => $this->input->post('End_Date'),
				);
	 	var_dump($User);
		
	 	$this->monthlycalendarmodel->update($year,$month,$User);
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
	 		$this->load->view('pages/monthlycalendaredit_view', $data);
			//$this->load->view('pages/template/footer');
			
	 	}
		
		
		
	 
	function delete($year,$month){
	 // delete Operator
	 	$this->monthlycalendarmodel->delete($year,$month);
	 
	// redirect to Operator list page
	 	redirect('monthlycalendar/index/','Refresh');
		
	 	}
 
	// validation rules
	 
	function _set_rules(){
		$this->form_validation->set_rules('Year', 'Year', 'required|trim');
	}
	 
	 
	}
	
?>

