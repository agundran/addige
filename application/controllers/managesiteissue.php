<?php
require_once("system/core/Common.php");

class Managesiteissue extends CI_Controller
{
	private $limit = 10;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('managesiteissuemodel','',TRUE);
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
	 
	 
	function index($offset = 0, $order_column = 'ShortName', $order_type = 'asc')
	{
	if (empty($offset)) $offset = 0;
	//if (empty($order_column)) $order_column = 'ShortName';
	if (empty($order_type)) $order_type = 'asc';
	
	$filter  = $this->input->post('ShortName');
	//TODO: check for valid column
	// load data
	$Users = $this->managesiteissuemodel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/managesiteissue/index');
	$config['total_rows'] = $this->managesiteissuemodel->count_all();
	$config['per_page'] = $this->limit;
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
	$data['title'] = "All Cients";
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
	$this->table->set_heading(
	//anchor('managesiteissue/index/'.$offset.'/Seq/'.$new_order, 'Seq'),
		anchor('managesiteissue/index/'.$offset.'/ShortName/'.$new_order, 'Site Name'),
	anchor('managesiteissue/index/'.$offset.'/City/'.$new_order, 'City'),
	anchor('managesiteissue/index/'.$offset.'/State/'.$new_order, 'State'),
	
	'Actions');
	 //PortOffset,ShortName,SSID
	$i = 0 + $offset;
	foreach ($Users as $Users) {
	$this->table->add_row(
	
	$Users->ShortName,
	$Users->City,
	$Users->State,
	//$Users->Status,
	
	
	anchor((array('managesiteissueview/index/'.$Users->ShortName ,$Users->$offset=0,$Users->$order_column='',$Users->$order_type='asc' )),'select',array('class'=>'select')));
	//.'   '.
	//anchor('portoffset/delete/'.$Users->ShortName,'delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this machine?')"))	);
	 
	}
	 
	$data['table'] = $this->table->generate();
	
	if ($this->uri->segment(3)=='delete_success')
	$data['message'] = 'The Data was successfully deleted';
	else if ($this->uri->segment(3)=='add_success')
	$data['message'] = 'The Data has been successfully added';
	else
	$data['message'] = '';
	 
	// load view
	$data['Role']=$this->session->userdata('role');
	
	
	$data['link_back'] = anchor('managesiteissue/index/','  ',array('class'=>'back'));
	$data['showopencases'] = anchor('managesiteissue/showopencases/','Show Open Cases',array('class'=>'showopencases')); 
	
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/managesiteissue_view', $data);
		$this->load->view('pages/template/footer');
	 }
	 
	
	function showopencases($offset = 0, $order_column = 'ShortName', $order_type = 'asc'){
//		($offset = 0, $order_column = 'ShortName', $order_type = 'asc')
	
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'ShortName';
	if (empty($order_type)) $order_type = 'asc';
	
	//$filter  = $this->input->post('ShortName');
	//TODO: check for valid column
	// load data
	$Users = $this->managesiteissuemodel->get_paged_open($this->limit, $offset, $order_column, $order_type)->result();
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/managesiteissue/showopencases');
	$config['total_rows'] = $this->managesiteissuemodel->count_all_open();
	$config['per_page'] = $this->limit;
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
	$data['title'] = "All Open Cases";
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
	$this->table->set_heading(
	anchor('managesiteissue/index/'.$offset.'/Seq/'.$new_order, 'Number'),
	anchor('managesiteissue/index/'.$offset.'/Date/'.$new_order, 'Date'),
	anchor('managesiteissue/index/'.$offset.'/Originator/'.$new_order, 'Originator'),
	anchor('managesiteissue/index/'.$offset.'/Status/'.$new_order, 'Status'),
	anchor('managesiteissue/index/'.$offset.'/SiteName/'.$new_order, 'Site Name'),
	'Actions');
	
	$i = 0 + $offset;
	foreach ($Users as $Users) {
		if ($Users->Status == 0)
		
	$this->table->add_row(
	$Users->Seq,
	$Users->Date,
	$Users->Originator,
	
	$this->managesiteissuemodel->status_change($Users->Status),
	$Users->SiteName,
	
	
	anchor(array('managesiteissueview/update/'.$Users->Seq, $Users->SiteName),'select',array('class'=>'select')));
	 
	}
	 
	$data['table'] = $this->table->generate();
	
	 
	// load view
	$data['Role']=$this->session->userdata('role');
	$data['link_back'] = anchor('managesiteissue/index/','Back to Site Cases',array('class'=>'back'));
	$data['showopencases'] = anchor('managesiteissue/showopencases/',' ',array('class'=>'showopencases')); 
	
	
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/managesiteissue_view', $data);
		$this->load->view('pages/template/footer');
		
		}
		
	
	
	function view($id){
		// set common properties
		$data['title'] = 'Operator Details';
		$data['link_back'] = anchor('managesiteissue/index/','All Machines',array('class'=>'back'));

		// get Operators details
		$data['Users'] = $this->managesiteissuemodel->get_by_id($id)->row();

		// load view
		$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/managesiteissue_view', $data);
		$this->load->view('pages/template/footer');
			
		
		
	}
	 
	

	function update($id){
	 
	// set common properties
	 	$data['title'] = 'Update Machine';
		
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('managesiteissue/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	
	 	$data['Users'] = (array)$this->managesiteissuemodel->get_by_id($id)->row();
	 	$data['title'] = 'Update Machine : '. $data['Users']['ShortName'] ;
		$data['message'] = '';
		 
	
	 	}else{
			
			$data['Users'] = $this->managesiteissuemodel->get_by_id($id)->row();
	 
	// save data
		$id = $this->input->post('ShortName');
	 	
	 	$User = array(
				
	 			'PortOffset' => $this->input->post('PortOffset'),
	 			'ShortName' => $this->input->post('ShortName'),
				'SSID' => $this->input->post('SSID'),
				//PortOffset,ShortName,SSID
	 			);
	 	var_dump($User);
	 	$this->managesiteissuemodel->update($id,$User);
	 	//$data['Users'] = (array)$this->manageoperatormodel->get_by_id($id)->row();
	 
	// set user message
	
		$message = "Machine Update successful";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
        		</script>';
   			 }
			 
	 	$data['message'] = 'update Machine Data success';
		redirect('portoffset/index/add_success','Refresh');
		
		//message
	
	 	}
	 	//$data['link_back'] = anchor('manageoperatorlist/index/','Back to Operator List',array('class'=>'back'));
	 
	// load view
	$data['Role']=$this->session->userdata('role');
	 		$this->load->view('pages/template/header');
			$this->load->view('pages/template/nav',$data);
	 		$this->load->view('pages/portoffsetedit_view', $data);
			$this->load->view('pages/template/footer');
			
	 	}
		
		
		
	 
	function delete($id){
	 // delete Operator
	 	$this->portoffsetmodel->delete($id);
	 
	// redirect to Operator list page
	 	redirect('managesiteissue/index/delete_success','refresh');
		
	 	}
 
	// validation rules
	 
	function _set_rules(){
	 	
		
		$this->form_validation->set_rules('ShortName', 'ShortName', 'required|trim');
		
		
	 	//$this->form_validation->set_rules('gender', 'Password', 'required');
	 	
		
		
		}
	 
	// date_validation callback
	 
	
	
	 
	}
	 

?>

