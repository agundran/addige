<?php
require_once("system/core/Common.php");

class Managesiteissueview extends CI_Controller
{
	private $limit = 15;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library helper 	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('managesiteissueviewmodel','',TRUE);
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
	 
	function index($order_by, $offset = 0, $order_column='SiteName', $order_type = 'asc' )
	{
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'SiteName';
	if (empty($order_type)) $order_type = 'asc';
	
	$filter  = $this->input->post('ShortName');
	// load data
	$Users = $this->managesiteissueviewmodel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter, $order_by )->result();
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/managesiteissueview/index/'.$order_by.'/');
	$config['total_rows'] = $this->managesiteissueviewmodel->count_all_open($order_by);
	$config['per_page'] = $this->limit;
	$config['uri_segment'] = 3;
	 
	
	
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
	$data['title'] = $order_by;
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
	$this->table->set_heading(
	anchor('managesiteissueview/index/'.$offset.'/Seq/'.$new_order, 'Number'),
	anchor('managesiteissueview/index/'.$offset.'/Date/'.$new_order, 'Date'),
	anchor('managesiteissueview/index/'.$offset.'/Originator/'.$new_order, 'Originator'),
	anchor('managesiteissueview/index/'.$offset.'/Status/'.$new_order, 'Status'),
	'Actions');
	
	$i = 0 + $offset;
	foreach ($Users as $Users) {
	$this->table->add_row(
	$Users->Seq,
	$Users->Date,
	$Users->Originator,
	$this->managesiteissueviewmodel->status_change($Users->Status),
	anchor('managesiteissueview/update/'.$Users->Seq, 'Select',array('class'=>'update')));
	}
	 
	$data['table'] = $this->table->generate();
	
		if ($this->uri->segment(3)=='delete_success')
			$data['message'] = 'The Data was successfully deleted';
		
		else if ($this->uri->segment(3)=='save_create_case')
			$data['message'] = 'Case has been successfully added';
		else
		$data['message'] = '';
	 
	// load view
	
	$data['create_case'] = anchor('managesiteissueview/create_case/'.$order_by,'Create Cases',array('class'=>'create_case'));
	$data['link_back'] = anchor( site_url('managesiteissue'),'Back to Site Cases',array('class'=>'back'));
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/managesiteissueview_view', $data);
		$this->load->view('pages/template/footer');
	 }
	 
	function create_case($order_by)
	{
	$data['title'] = 'Create case for ' .$order_by;
	$data['action'] = site_url('managesiteissueview/create_case/'.$order_by);
	$data['link_back'] = anchor('managesiteissue/index/','Back to Site Cases',array('class'=>'back'));
	
	$this->_set_rules();

	// run validation
		if ($this->form_validation->run() === FALSE){
			// set common properties
			$data['title'] = 'Create case for ' .$order_by;
			$data['message'] = '';
			$creationdate =  date("Y-m-d H:i:s");
			
			$data['Users']['Date']= $creationdate;
			$data['Users']['Originator']=$this->session->userdata('username');
			$data['Users']['SiteName'] = $order_by;
			$data['Users']['Status']='';
			$data['Users']['Description']='';
			
			$data['link_back'] = anchor('managesiteissue/index/','Back to Site Cases',array('class'=>'back'));
			$data['Role']=$this->session->userdata('role');
		
			$this->load->view('pages/template/header');
			$this->load->view('pages/template/nav',$data);
	 		$this->load->view('pages/managesiteissueadd_view', $data);
			$this->load->view('pages/template/footer');

		}else{
		
			// save data
			
				$Date = $this->input->post('Date');
				$Originator = $this->input->post('Originator');
				$Status = $this->input->post('Status');
				//$Sitename => $data['Users']['SiteName'],
				$Sitename = $order_by;
				$Description = '*** '.'last updated by '.$Originator.' on '. $Date.' '. $this->input->post('Description');
							
			$id = $this->managesiteissueviewmodel->save_create_case($Date, $Originator,$Status, $Sitename,$Description);

			// set form input name="id"
			//$this->validation->id = $id;
			redirect('managesiteissueview/index/save_create_case','Refresh');
			
		}
	}
	
	function update($id){
	 // set common properties
	 	$data['title'] = 'Update Machine';
		$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('managesiteissueview/update/'.$id);
	   $data['close_case_button'] = anchor('managesiteissueview/close_case/'. $id,'Close Case',array('class'=>'close_case'));
	   
	   
	// run validation
	 	if ($this->form_validation->run() == FALSE){
	 	
	 	$data['Users'] = (array)$this->managesiteissueviewmodel->get_by_id_edit($id)->row();
	 	$data['title'] = 'Cases for : '. $data['Users']['SiteName'];
		$data['message'] = '';
		$data['Users']['Date']= date("Y-m-d H:i:s");
	$OldDescription = $data['Users']['Description'];
		$mysite = $data['Users']['SiteName'];
			
		
	
	
	 	}else{
			
			$data['Users'] = $this->managesiteissueviewmodel->get_by_id($id)->row();
	 
	// save data
		$id = $this->input->post('Seq');
	 	
	 	
				$Date = date("Y-m-d H:i:s");
				$Originator = $this->input->post('Originator');
				$Status = $this->input->post('Status');
				//$SiteName = $mysite;
				$Description = $OldDescription . "           ". '*** '.'last updated by '.$Originator.' on '. $Date.' '.$this->input->post('Description');
	 	
		var_dump($User);
	 	$this->managesiteissueviewmodel->update_case($id,$Date,$Originator, $Status, $Description);
		
	 	$data['Users'] = (array)$this->managesiteissueviewmodel->get_by_id($id)->row();
	 
	    // set user message
		$data['message'] = 'update Issue successful';
		redirect(site_url('/managesiteissueview/'),'Refresh');
		
		//message
	
	 	}
	 	
	// load view
			$data['Role']=$this->session->userdata('role');
			$data['link_back'] = anchor('managesiteissue/index/','Back to Site Cases',array('class'=>'back'));
	 		
			$this->load->view('pages/template/header');
			$this->load->view('pages/template/nav',$data);
	 		$this->load->view('pages/managesiteissueedit_view', $data);
			$this->load->view('pages/template/footer');
	 	}
		
	
	function close_case($Seq){
	   // set common properties
	 	$data['title'] = 'Update Machine';
		$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = (' ');
	  
	    $data['close_case_button'] = anchor('managesiteissueview/close_case/'. $Seq,'Close Case',array('class'=>'close_case'));

	   
	// run validation
	 	if ($this->form_validation->run() == FALSE){
	 	
	 	$data['Users'] = (array)$this->managesiteissueviewmodel->get_by_id_edit($Seq)->row();
	 	$data['title'] = 'Cases for : '. $data['Users']['SiteName'];
		$data['message'] = '';
		$data['Users']['Date']= date("Y-m-d H:i:s");
	$OldDescription = $data['Users']['Description'];
		$mysite = $data['Users']['SiteName'];
			
		
	
	
	 	}else{
			
			$data['Users'] = $this->managesiteissueviewmodel->get_by_id($Seq)->row();
	 
	// save data
		$id = $this->input->post('Seq');
	 	
	 	
				$Date = date("Y-m-d H:i:s");
				$Originator = $this->input->post('Originator');
				$Status = '1';
				//$SiteName = $mysite;
				$Description = $OldDescription . "           ". '*** '.'Case Close by '.$Originator.' on '. $Date.' '.$this->input->post('Description');
	 	
		var_dump($User);
	 	$this->managesiteissueviewmodel->update_case($Seq,$Date,$Originator, $Status, $Description);
		
	 	$data['Users'] = (array)$this->managesiteissueviewmodel->get_by_id($id)->row();
	 
	    // set user message
		$data['message'] = 'update case successful';
		redirect(site_url('/managesiteissueview/'),'Refresh');
		
		//message
	
	 	}
	 	
	// load view
			$data['Role']=$this->session->userdata('role');
			$data['link_back'] = anchor('managesiteissue/index/','Back to Site Cases',array('class'=>'back'));
	 		
			$this->load->view('pages/template/header');
			$this->load->view('pages/template/nav',$data);
	 		$this->load->view('pages/managesiteissueedit_view', $data);
			$this->load->view('pages/template/footer');
		}	
		
	function delete($id){
	 // delete Operator
	 	$this->portoffsetmodel->delete($id);
	// redirect to Operator list page
	 	redirect('managesiteissueview/index/delete_success','refresh');
	 	}
 
	// validation rules
	function _set_rules(){
	 	
		$this->form_validation->set_rules('Description', 'Description', 'required|trim');
				
		}
	 
	}
	
?>

