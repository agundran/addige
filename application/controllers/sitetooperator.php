<script>

window.onunload = function(){
  window.opener.location.reload();
};


</script>

<?php
require_once("system/core/Common.php");

class Sitetooperator extends CI_Controller
{
	//private $limit = 15;
 	
	
	function __construct()
 	{
		parent::__construct();
	 	#load library  helper 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('sitetooperatormodel','',TRUE);
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
	
	
	function index($offset = 0, $order_column = 'SiteName', $order_type = 'asc')
	{
		
		
		
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'SiteName';
		if (empty($order_type)) $order_type = 'asc';
		$filter  = $this->input->post('ShortName');
		
		
		//$num  = $this->input->post('limit');
		
		//$limit =  = $this->sitetooperatormodel->count_all();
		
		$limit = 20;
		
		
		//TODO: check for valid column
		// load data
		$Users = $this->sitetooperatormodel->get_paged_list($limit, $offset, $order_column, $order_type, $filter)->result();
		
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
		$config['base_url'] = site_url('/sitetooperator/index');
		$config['total_rows'] = $this->sitetooperatormodel->count_all();
		
		$config['per_page'] = $limit;
		//$config['per_page'] = $this->sitetooperatormodel->count_all();
		
		
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		anchor('sitetooperator/index/'.$offset.'/SiteName/'.$new_order, 'Site Name'),
		anchor('sitetooperator/index/'.$offset.'/Operator/'.$new_order, 'Operator'),
		anchor('sitetooperator/index/'.$offset.'/HENumber/'.$new_order, 'HE Number'),
		anchor('sitetooperator/index/'.$offset.'/SysCode/'.$new_order, 'System Code'),'Actions');
	 
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			
			$Users->SiteName,
			$Users->Operator,			
			$Users->HENumber,
			$Users->SysCode,
	
	 
		//anchor('sitetooperator/view/'.$Users->SiteName,'view',array('class'=>'view')).'   '.
		anchor_popup('sitetooperator/update/'.$Users->SiteName,'update',array('class'=>'update'),$upd).'   '.
		anchor('sitetooperator/delete/'.$Users->SiteName,'delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Site Operator?')")));
	 	}
	 
	    $data['link_add'] = anchor_popup('sitetooperator/validate_add/','Add New Site Operator',array('class'=>'validate_add'),$upd);
		
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
		$this->load->view('pages/sitetooperatorlist_view', $data);
		$this->load->view('pages/template/footer');
	 
	}
	 
		
	function validate_add()
	{
	$data['title'] = 'Add New Site Operator';
	$data['action'] = site_url('sitetooperator/validate_add');
	//$data['link_back'] = anchor('/manageuserlist/index/','Back to list of Users',array('class'=>'back'));
	
	 $upd = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
	
	$this->_set_rules();

	// run validation
		if ($this->form_validation->run() === FALSE) {
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Add new Operator';
			$data['message'] = '';
			$data['Users']['SiteName']='';
			$data['Users']['Operator']='';
			$data['Users']['Format']='';
			$data['Users']['UseFTP']='';
			$data['Users']['SiteKey']='';
			$data['Users']['SysCode']='';
			$data['Users']['Contact']='';
			$data['Users']['Address1']='';
			$data['Users']['Address2']='';
			
			$data['Users']['City']='';
			$data['Users']['State']='';
			$data['Users']['Zip']='';
			$data['Users']['RevSplit']='';
			
			$data['Users']['Email']='';
			//$data['link_back'] = anchor('sitetooperator/index/','Back Site Operator List',array('class'=>'back'));
			$data['Role']="Admin";
			$this->load->view('pages/template/header');
			//$this->load->view('pages/template/nav',$data);
			$this->load->view('pages/sitetooperator_view', $data);
			//$this->load->view('pages/template/footer');

		
		}else{
		
			// save data
			$User = array(
				'SiteName' => $this->input->post('SiteName'),
				'Operator' => $this->input->post('Operator'),
	 		    'HENumber' => $this->input->post('HENumber'),
				'Format' => $this->input->post('Format'),
	 		   'UseFTP' => $this->input->post('useFTP'),
			    'SiteKey' => $this->input->post('SiteKey'),
	 		    'SysCode'=> $this->input->post('SysCode'),
				'Contact' => $this->input->post('Contact'),
				'Address1' => $this->input->post('Address1'),
				'Address2' => $this->input->post('Address2'),
				'City' => $this->input->post('City'),
				'State' => $this->input->post('State'),
				'Zip' => $this->input->post('Zip'),
				'RevSplit' => $this->input->post('RevSplit'),
								);
			
							
			//$id = $this->manageusermodel->create_user($Users);
			$id = $this->sitetooperatormodel->create_siteoperator($User);
			
			// set form input name="id"
			$this->validation->id = $id;
			redirect('sitetooperator/index/add_success','Refresh');
					
		}
	}


	 function view($id){
		// set common properties
		$data['title'] = 'Site Operator Details';
		$data['link_back'] = anchor('sitetooperator/index/','Back Site Operator List',array('class'=>'back'));

		// get Student details
		$data['Users'] = $this->sitetooperatormodel->get_by_id($id)->row();
		$data['message']='';
			$data['action']='';
		// load view
		$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header');
			//$this->load->view('pages/template/nav',$data);
			$this->load->view('pages/sitetooperator_view', $data);
			//$this->load->view('pages/template/footer');
	}
	
	
	
	function update($id){
	 
	// set common properties
	 	$data['title'] = 'Update Site Operator';
	 	$this->load->library('form_validation');
		//$this->load->model->manageusermodel;
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('sitetooperator/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	
	 	$data['Users'] = (array)$this->sitetooperatormodel->get_by_id($id)->row();
	 	$data['title'] = 'Update Site Operator : '. $data['Users']['SiteName'] ;
	 	$data['message'] = '';
	 	
		}else{
	 
	// save data
	 	//$id = $this->input->post('id');
		$data['Users'] = (array)$this->sitetooperatormodel->get_by_id($id)->row();
	 	
				
		//$id = $data['Users']['Username'];
		$id = $data['Users']['SiteName'];
	
		
			$User = array(
				
				'Operator' => $this->input->post('Operator'),
	 		    'HENumber' => $this->input->post('HENumber'),
	 		    'Format' => $this->input->post('Format'),
	 		    'UseFTP' => $this->input->post('useFTP'),
				'SiteKey' => $this->input->post('SiteKey'),
				'SysCode'=> $this->input->post('SysCode'),
				'Contact' => $this->input->post('Contact'),
				'Address1' => $this->input->post('Address1'),
				'Address2' => $this->input->post('Address2'),
				'City' => $this->input->post('City'),
				'State' => $this->input->post('State'),
				'Zip' => $this->input->post('Zip'),
				'RevSplit' => $this->input->post('RevSplit'),
								);
	 		
		
		//var_dump($User);
	 	$this->sitetooperatormodel->update($id,$User);
		
		
	 
	 $message = "Update Site Successfully";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
				 window.opener.location.reload();
				window.close ();
        		</script>';
   			 }
	 
	 
	// set user message
	 	//$data['message'] = 'update User Data success';
	 	//redirect('sitetooperator/index/add_success','Refresh');
		}
	 	$data['link_back'] = anchor('sitetooperator/index/','Back to Site Operator List',array('class'=>'back'));
	 
	// load view
	 	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
			//$this->load->view('pages/template/nav',$data);
			$this->load->view('pages/sitetooperator_view', $data);
			//$this->load->view('pages/template/footer');
	}
	 
	function delete($id){
		 // delete user
	 	$this->sitetooperatormodel->delete($id);
	 	// redirect to Student list page
	 	redirect('sitetooperator/index/','Refresh');
	 	}
 
	// validation rules
	 
	function _set_rules(){
			//$this->form_validation->set_rules('SiteName', 'SiteName',  'min_length[4]|max_length[30]|is_unique[site_operators.SiteName]');
			$this->form_validation->set_rules('SiteName', 'SiteName',  'min_length[4]|max_length[30]');
			
	 	}
	 
	 
	 
	 
	 
	
	}
	
	
	 

?>

