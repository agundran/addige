<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");

class Viewclientheader extends CI_Controller
{
	private $limit = 10;
 	
	
	function __construct()
 	{
		parent::__construct();
	 	#load library dan helper yang dibutuhkan
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('viewclientheadermodel','',TRUE);
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
	function index($offset = 0, $order_column = 'Username', $order_type = 'asc')
	//function index()
	{
		//$offset = 0; 
		//$order_column = 'Username';
		//$order_type = 'asc';
		
		
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'Username';
		if (empty($order_type)) $order_type = 'asc';
		
		
	
		$filter  = $this->input->post('ShortName');
		
		
		//TODO: check for valid column
		// load data
		//$Users = $this->manageusermodel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter )->result();
	    $Users = $this->viewclientheadermodel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/viewclientheader/index');
		//$config['base_url'] = $myhostname.'/index.php/manageuserlist/index';
		$config['total_rows'] = $this->viewclientheadermodel->count_all();
		$config['per_page'] = $this->limit;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['title'] = "View Client Header";
 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		anchor('viewclientheader/index/'.$offset.'/Seq/'.$new_order, 'Seq'),
		
		anchor('viewclientheader/index/'.$offset.'/ContractName/'.$new_order, 'Operator'),
		anchor('viewclientheader/index/'.$offset.'/SiteName/'.$new_order, 'Site Name'),
		anchor('viewclientheader/index/'.$offset.'/StartDate/'.$new_order, 'Start Date'),
		anchor('viewclientheader/index/'.$offset.'/EndDate/'.$new_order, 'End Date'),
		
		anchor('viewclientheader/index/'.$offset.'/CustOrder/'.$new_order, 'Customer Order'),'Actions');
	 
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			
			$Users->Seq,
			$Users->ContractName,			
		
			$Users->SiteName,
			$Users->StartDate,
			$Users->EndDate,
			$Users->CustOrder,
	 
		anchor('viewclientheader/view/'.$Users->SiteName,'View'.'&nbsp|&nbsp',array('class'=>'view')).'   '.
		//anchor('manageuserlist/update/'.$Users->PKID,'Update'.'&nbsp|&nbsp',array('class'=>'update')).'   '.
		anchor('viewclientheader/delete/'.$Users->SiteName,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this User?')")));
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
		$this->load->view('pages/viewclientheader_view', $data);
		$this->load->view('pages/template/footer');
	 
	}
	 
		
	function validate_add()
	{
	$data['title'] = 'Add New User';
	$data['action'] = site_url('manageuserlist/validate_add');
	$data['link_back'] = anchor('/manageuserlist/index/','Back to list of Users',array('class'=>'back'));
	
	$this->_set_rules();

	// run validation
		if ($this->form_validation->run() === FALSE){
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Add new User';
			$data['message'] = '';
			$data['Users']['Priviledge_group']='';
			$data['Users']['Operator']='';
			$data['Users']['Username']='';
			$data['Users']['Password']='';
			$data['Users']['Email']='';
			$data['link_back'] = anchor('manageuserlist/index/','See List Of Users',array('class'=>'back'));
			
			
			$data['Role']="Admin";
			$this->load->view('pages/template/header');
			$this->load->view('pages/template/nav', $data);	
			$this->load->view('pages/manageuseredit_view', $data);
			$this->load->view('pages/template/footer');

		
		}else{
		
			// save data
			$Rolename = $this->input->post('Priviledge_group');
			$Operator = $this->input->post('Operator');
			$Username = $this->input->post('Username');
			$Password = $this->input->post('Password');
			$Email = $this->input->post('Email');
			
							
			//$id = $this->manageusermodel->create_user($Users);
			
			
			$id = $this->manageusermodel->create_user($Rolename, $Operator, $Username, $Password, $Email);

			// set form input name="id"
			$this->validation->id = $id;

			redirect('manageuserlist/index/add_success','Refresh');
			
		}
	}


	function username_check($str){
		
		$this->db->select('Username');
		$this->db->from('users');
		$str1 = $this->db->get();
		
			if($str1 == $str)
			{
			$this->form_validation->set_message('Username already exist!');
			return false;
			}
			else
			{
				return true;
				
				
			}
		
	}
	
	

	 
	function update($id){
	 
	// set common properties
	 	$data['title'] = 'Update User';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('manageuserlist/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
	 	$data['Users'] = (array)$this->manageusermodel->get_by_id($id)->row();
	 	$data['Users']['Password'] = $this->manageusermodel->decryptIt($data['Users']['Password']) ;
	 	$data['title'] = 'Update User : '. $data['Users']['Username'] ;
	 	$data['message'] = '';
	 	
		}else{
	 
	// save data
	 	//$id = $this->input->post('id');
		$data['Users'] = (array)$this->manageusermodel->get_by_id($id)->row();
	 	
		
		
		//$id = $data['Users']['Username'];
		$id = $data['Users']['PKID'];
		$id2 = $data['Users']['Username'];
		
			$User1 = array(
	 				'Operator' => $this->input->post('Operator'),
	 				'Password' => $this->manageusermodel->encryptIt($this->input->post('Password')),
					'Email' => $this->input->post('Email'));
	 		$User2 = array('Rolename' => $this->input->post('Priviledge_group'),
	 				);
		
		//var_dump($User);
	 	$this->manageusermodel->update($id,$id2,$User1, $User2);
	 	$data['User'] = (array)$this->manageusermodel->get_by_id($id)->row();
	 
	 
	 
	 
	// set user message
	 	$data['message'] = 'update User Data success';
	 	}
	 	$data['link_back'] = anchor('manageuserlist/index/','Cancel Update',array('class'=>'back'));
	 
	// load view
	 		$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header');
			$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/manageuserupdate_view', $data);
			$this->load->view('pages/template/footer');
	}
	 
	function delete($id){
	 $data['Users'] = (array)$this->manageusermodel->get_by_id($id)->row();
	 $id = $data['Users']['PKID'];
	 $id2 = $data['Users']['Username'];
		
	 // delete user
	 	$this->manageusermodel->delete($id, $id2);
	 	
	// redirect to Student list page
	 	redirect('manageuserlist/index/delete_success','refresh');
	 	}
 
	// validation rules
	 
	function _set_rules(){
		
		$this->form_validation->set_rules('Rolename', 'priviledge_group');
			$this->form_validation->set_rules('Operator', 'operator');
			$this->form_validation->set_rules('Username', 'Username', 'required|min_length[4]|max_length[20]|is_unique[users.Username]');
			$this->form_validation->set_rules('Password', 'Password', 'trim|min_length[4]|max_length[32]');
			$this->form_validation->set_rules('Email', 'Email Address', 'trim|valid_email');
			
	 	}
	 
	// date_validation callback
	 
	function valid_date($str)
	{
	 	if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $str))
	 	{
	 		$this->form_validation->set_message('valid_date', 'date format is not valid. yyyy-mm-dd');
	 		return false;
	 	}
	 	else
	 	{
	 	return true;
	 	}
	 }
	 
	
	} 

?>

