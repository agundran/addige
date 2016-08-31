
<script>

window.onunload = function(){
  window.opener.location.reload();
};


</script>

<?php
require_once("system/core/Common.php");

class Viewclientinfo extends CI_Controller
{
	private $limit = 9;
 	
	
	function __construct()
 	{
		parent::__construct();
	 	#load library dan helper yang dibutuhkan
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('viewclientinfomodel','',TRUE);
		$this->load->library('pagination');
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
	 
	 
	function index( $offset = 0, $order_column = 'SiteName', $order_type = 'asc'){
	
		
		
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'ShortName';
		if (empty($order_type)) $order_type = 'asc';
		if (empty($filter)) $filter= 0;
		
		
		 $upd = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		
		//TODO: check for valid column
		// load data
		$filter  = $this->input->post('ShortName');
		
		$Users = $this->viewclientinfomodel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
	 
	 
	 
	 	// generate pagination
		$config['base_url'] = site_url('/viewclientinfo/index');
		$config['total_rows'] = $this->viewclientinfomodel->count_all();
		$config['per_page'] = $this->limit;
		$config['uri_segment'] = 3;
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 		$data['title'] = "Site Table";
		
		
		
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		
		 //PHRASE
    	anchor('viewclientinfo/index/'.$offset.'/ShortName/'.$new_order, 'Site Name'),
		anchor('viewclientinfo/index/'.$offset.'/Operator/'.$new_order, 'Operator'),
		anchor('viewclientinfo/index/'.$offset.'/HENumber/'.$new_order, 'HE'),
		anchor('viewclientinfo/index/'.$offset.'/Syscode/'.$new_order, 'Syscode'),'Actions');
	 
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			
			$Users->ShortName,
			$Users->Operator,			
			$Users->HENumber,
			$Users->SysCode,
		anchor_popup('viewclientinfo/update/'.$Users->ShortName,'select',array('class'=>'update'),$upd));
		//.'   '.
		//anchor('viewclientinfo/delete/'.$Users->ShortName,'delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Client?')")))
		//;
	 	}
	 
		$data['table'] = $this->table->generate();
	
		if ($this->uri->segment(3)=='delete_success')
			$data['message'] = 'The Data was successfully deleted';
		else if ($this->uri->segment(3)=='add_success')
			$data['message'] = 'The Data has been successfully added';
		else if ($this->uri->segment(3)=='update_success')
			$data['message'] = 'The Data has been successfully updated';
		else
		$data['message'] = '';
	 
		// load view
	 	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/viewclientinfo_view', $data);
		$this->load->view('pages/template/footer');
	 
	
	}
	



	
		 
		
	

	 
	function update($id){
	 
	// set common properties
	 	$data['title'] = 'Update Client';
	 	$this->load->library('form_validation');
		//$this->load->model->manageusermodel;
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('viewclientinfo/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
	 	$data['Users'] = (array)$this->viewclientinfomodel->get_by_id($id)->row();
	 	$data['title'] = 'Update Client: '. $data['Users']['ShortName'] .'| '.' Operator: '. $data['Users']['Operator'].'| '.'  HE: '. $data['Users']['HENumber'].'| '.'  SysCode: '. $data['Users']['SysCode']       ;
	 	$data['message'] = '';
	 	
		}else{
	 
	// save data
	 	//$id = $this->input->post('id');
		$data['Users'] = (array)$this->viewclientinfomodel->get_by_id($id)->row();
			
		//$id = $data['Users']['Username'];
		$id = $data['Users']['ShortName'];
		
		
			$User1 = array(
	 				'EmailAddress' => $this->input->post('EmailAddress'),
					'Address1' => $this->input->post('Address1'),
					'Address2' => $this->input->post('Address2'),
					'City' => $this->input->post('City'),
					'State' => $this->input->post('State'),
					'Zip' => $this->input->post('Zip'),
					'Country' => $this->input->post('Country'),
					'Region' => $this->input->post('Region'),
					'Telephone' => $this->input->post('Telephone'),
					'IPAddress' => $this->input->post('IPAddress'),
					'SubCount' => $this->input->post('SubCount'),
					'Resources' => $this->input->post('Resources')
					
					);
	 		
		//var_dump($User);
	 	$this->viewclientinfomodel->update($id,$User1);
	 	$data['Users'] = (array)$this->viewclientinfomodel->get_by_id($id)->row();
	 
	 
	  	$message = "Update Client Info Successfully";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
				 window.opener.location.reload();
				window.close ();
        		</script>';
   			 }
	 
	// set user message
	 	//$data['message'] = 'update User Data success';
	 	
		}
	 	
		
	 
	// load view
	 	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
			//$this->load->view('pages/template/nav',$data);
			$this->load->view('pages/viewclientinfoedit_view', $data);
			//$this->load->view('pages/template/footer');
	}
	 
		 
	function _set_rules(){
		
			$this->form_validation->set_rules('EmailAddress', 'EmailAddress', 'trim|valid_email');
			
	 	}
	 

	 
	}
	

	
?>

