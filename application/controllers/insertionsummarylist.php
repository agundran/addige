<?php
require_once("system/core/Common.php");

class Insertionsummarylist extends CI_Controller
{
	private $limit = 200;
 	
	
	function __construct()
 	{
		parent::__construct();
	 	#load library  helper 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('insertionsummarymodel','',TRUE);
 	}
	 
	function index($offset = 0, $order_column = 'SiteName', $order_type = 'asc')
	{
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'SiteName';
		if (empty($order_type)) $order_type = 'asc';
		//TODO: check for valid column
		// load data
		$Users = $this->insertionsummarymodel->get_paged_list($this->limit, $offset, $order_column, $order_type)->result();
	 
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/insertionsummarylist/index');
		$config['total_rows'] = $this->insertionsummarymodel->count_all();
		$config['per_page'] = $this->limit;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		anchor('insertionsummarylist/index/'.$offset.'/SiteName/'.$new_order, 'Site Name'),
		anchor('insertionsummarylist/index/'.$offset.'/SSID/'.$new_order, 'SSID'),
		anchor('insertionsummarylist/index/'.$offset.'/City/'.$new_order, 'City'),
		anchor('insertionsummarylist/index/'.$offset.'/State/'.$new_order, 'State'),
		anchor('insertionsummarylist/index/'.$offset.'/SysCode/'.$new_order, 'SysCode'),
		anchor('insertionsummarylist/index/'.$offset.'/LastLogDate/'.$new_order, 'LastLogDate'),
		anchor('insertionsummarylist/index/'.$offset.'/RegExpiry/'.$new_order, 'RegExpiry'),
		anchor('insertionsummarylist/index/'.$offset.'/IPAddress/'.$new_order, 'IPAddress'));
	 	$data['CompDate'] = date("Y-m-d");
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			
			$Users->SiteName,
			$Users->SSID,			
			$Users->City,
			$Users->State,
			$Users->SysCode,
			$Users->LastLogDate,
			$Users->RegExpiry,
			$Users->IPAddress			
			
			
		
			
	
	 		
		//anchor('sitetooperator/view/'.$Users->SiteName,'view',array('class'=>'view')).'   '.
		//anchor('insertionsummarylist/update/'.$Users->SiteName,'update',array('class'=>'update')).'   '.
		//anchor('insertionsummarylist/delete/'.$Users->SiteName,'delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Site Operator?')"

		);
			//if ($Users->LastLogDate != $data['CompDate'])
			//$data['Log'] = 'Reynan';
			//$Users['LastLogDate'] == '*';
			
			
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
		$this->load->view('pages/insertionsummarylist_view', $data);
		$this->load->view('pages/template/footer');
	 
	}
	 
		
	function validate_add()
	{
	$data['title'] = 'Add New Site Operator';
	$data['action'] = site_url('sitetooperator/validate_add');
	//$data['link_back'] = anchor('/manageuserlist/index/','Back to list of Users',array('class'=>'back'));
	
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
			$data['link_back'] = anchor('sitetooperator/index/','Back Site Operator List',array('class'=>'back'));
			$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header');
			$this->load->view('pages/template/nav',$data);
			$this->load->view('pages/sitetooperator_view', $data);
			$this->load->view('pages/template/footer');

		
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
			$this->load->view('pages/template/nav',$data);
			$this->load->view('pages/sitetooperator_view', $data);
			$this->load->view('pages/template/footer');
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
		
		
	 
	 
	 
	 
	// set user message
	 	//$data['message'] = 'update User Data success';
	 	redirect('sitetooperator/index/add_success','Refresh');
		}
	 	$data['link_back'] = anchor('sitetooperator/index/','Back to Site Operator List',array('class'=>'back'));
	 
	// load view
	 	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
			$this->load->view('pages/template/nav',$data);
			$this->load->view('pages/sitetooperator_view', $data);
			$this->load->view('pages/template/footer');
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

