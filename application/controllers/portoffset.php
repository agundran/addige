
<script>

window.onunload = function(){
  window.opener.location.reload();
};


</script>

<?php
require_once("system/core/Common.php");

class Portoffset extends CI_Controller
{
	private $limit = 20;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('portoffsetmodel','',TRUE);
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
	if (empty($order_column)) $order_column = 'ShortName';
	if (empty($order_type)) $order_type = 'asc';
	
	
	$filter  = $this->input->post('ShortName');
	
	//TODO: check for valid column
	// load data
	$Users = $this->portoffsetmodel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
	 
	 $upd = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
			
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/portoffset/index');
	$config['total_rows'] = $this->portoffsetmodel->count_all();
	$config['per_page'] = $this->limit;
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
	$data['title'] = "All Machines";
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
	$this->table->set_heading(
	anchor('portoffset/index/'.$offset.'/PortOffset/'.$new_order, 'PortOffset'),
	anchor('portoffset/index/'.$offset.'/ShortName/'.$new_order, 'Site Name'),
	anchor('portoffset/index/'.$offset.'/SSID/'.$new_order, 'SSID'),
	//anchor('manageoperatorlist/index/'.$offset.'/Telephone/'.$new_order, 'Telephone'),
	'Actions');
	 //PortOffset,ShortName,SSID
	$i = 0 + $offset;
	foreach ($Users as $Users) {
	$this->table->add_row(
	$Users->PortOffset,
	$Users->ShortName,
	$Users->SSID,
		
	//anchor('manageoperatorlist/view/'.$Users->ShortName,'view',array('class'=>'view')).'   '.
	anchor_popup('portoffset/update/'.$Users->ShortName,'select',array('class'=>'update'),$upd));
	
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
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/portoffset_view', $data);
		$this->load->view('pages/template/footer');
	 }
	 
	

	
	function validate_add()
	{
	$data['title'] = 'Add New Operator';
	$data['action'] = site_url('portoffset/validate_add');
	$data['link_back'] = anchor('/portoffset/index/','Back to All Machine List',array('class'=>'back'));
	
	$this->_set_rules();

	// run validation
		if ($this->form_validation->run() === FALSE){
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Add new Operator';
			$data['message'] = '';
			$data['Users']['PortOffset']='';
			$data['Users']['ShortName']='';
			$data['Users']['SSID']='';
					
			$data['link_back'] = anchor('portoffset/index/','See List Of Users',array('class'=>'back'));
			
			
			$data['Role']=$this->session->userdata('role');
			
				$this->load->view('pages/template/header');
				$this->load->view('pages/template/nav', $data);
				$this->load->view('pages/portoffset_view', $data);
				$this->load->view('pages/template/footer');

		
		}else{
		
			// save data
		     $ShortName = $this->input->post('ShortName');
			 $TrimShortName = preg_replace('/\s+/','',($ShortName));
			 
			$User = array(
				'Portoffset' => $this->input->post('Portoffset'),
				'ShortName' => $this->input->post('ShortName'),
	 		    //remove spaces in between for Operator's Name
				//'ShortName' => preg_replace('/\s+/','',($this->input->post('ShortName'))),
				'SSID' => $this->input->post('SSID'),
	 		    
				
				);
			
			$id = $this->portoffsetmodel->create_operator($User);
			
			//$id = $this->manageoperatormodel->create_operator($Rolename, $Operator, $Username, $Password, $Email);

			// set form input name="id"
			//$this->validation->id = $id;

			redirect('portoffset/index/add_success','Refresh');
			
		}
	}
	function view($id){
		// set common properties
		$data['title'] = 'Operator Details';
		$data['link_back'] = anchor('portoffset/index/','All Machines',array('class'=>'back'));

		// get Operators details
		$data['Users'] = $this->portoffsetmodel->get_by_id($id)->row();

		// load view
		$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/portoffset_view', $data);
		$this->load->view('pages/template/footer');
			
		
		
	}
	 
	function update($id){
	 
	// set common properties
	 	$data['title'] = 'Update Machine';
		
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('portoffset/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	
	 	$data['Users'] = (array)$this->portoffsetmodel->get_by_id($id)->row();
	 	$data['title'] = 'Update Machine : '. $data['Users']['ShortName'] ;
		$data['message'] = '';
		 
	
	 	}else{
			
			$data['Users'] = $this->portoffsetmodel->get_by_id($id)->row();
	 
	// save data
		$id = $this->input->post('ShortName');
	 	
	 	$User = array(
				
	 			'PortOffset' => $this->input->post('PortOffset'),
	 			'ShortName' => $this->input->post('ShortName'),
				'SSID' => $this->input->post('SSID'),
				//PortOffset,ShortName,SSID
	 			);
	 	var_dump($User);
	 	$this->portoffsetmodel->update($id,$User);
	 	//$data['Users'] = (array)$this->manageoperatormodel->get_by_id($id)->row();
	 
	// set user message
	
		$message = "Machine Update successful";
   	;
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
				 window.opener.location.reload();
				window.close ();
        		</script>';
   			 }
			 
	 	$data['message'] = 'update Machine Data success';
		//redirect('portoffset/index/add_success','Refresh');
		
		//message
	
	 	}
	 	//$data['link_back'] = anchor('manageoperatorlist/index/','Back to Operator List',array('class'=>'back'));
	 
	// load view
	$data['Role']=$this->session->userdata('role');
	 		$this->load->view('pages/template/header');
			//$this->load->view('pages/template/nav',$data);
	 		$this->load->view('pages/portoffsetedit_view', $data);
			//$this->load->view('pages/template/footer');
			
	 	}
		
		
		
	 
	function delete($id){
	 // delete Operator
	 	$this->portoffsetmodel->delete($id);
	 
	// redirect to Operator list page
	 	redirect('portoffset/index/delete_success','refresh');
		
	 	}
 
	// validation rules
	 
	function _set_rules(){
	 	
		
		$this->form_validation->set_rules('ShortName', 'ShortName', 'required|trim');
		
		
	 	//$this->form_validation->set_rules('gender', 'Password', 'required');
	 	
		
		
		}
	 
	// date_validation callback
	 
	
	 
	}
	 

?>

