<?php
require_once("system/core/Common.php");

class Customerlist extends CI_Controller
{
	private $limit = 5;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('customerlistmodel','',TRUE);
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
	 
	 
	function index($offset = 0, $order_column = 'Seq', $order_type = 'asc')
	
	{
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'Seq';
	if (empty($order_type)) $order_type = 'asc';
	//TODO: check for valid column
	// load data
	$Users = $this->customerlistmodel->get_paged_list($this->limit, $offset, $order_column, $order_type)->result();
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/customerlist/index');
	$config['total_rows'] = $this->customerlistmodel->count_all();
	$config['per_page'] = $this->limit;
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
    $data['title'] = 'Adsystems Customers';
	
	
	
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
	$this->table->set_heading(
	anchor('customerlist/index/'.$offset.'/Seq/'.$new_order, 'Seq'),
	//anchor('customerlist/index/'.$offset.'/Operator/'.$new_order, 'Operator'),
	anchor('customerlist/index/'.$offset.'/Name/'.$new_order, 'Name'),
	anchor('customerlist/index/'.$offset.'/Address1/'.$new_order, 'Address'),
	//anchor('customerlist/index/'.$offset.'/Address2/'.$new_order, 'Address2'),
	anchor('customerlist/index/'.$offset.'/City/'.$new_order, 'City'),
	anchor('customerlist/index/'.$offset.'/State/'.$new_order, 'State'),
	anchor('customerlist/index/'.$offset.'/Zip/'.$new_order, 'Zip'),
	
	anchor('customerlist/index/'.$offset.'/Telephone/'.$new_order, 'Telephone'),
	//anchor('customerlist/index/'.$offset.'/EBill/'.$new_order, 'EBill'),
	//anchor('customerlist/index/'.$offset.'/Bonus/'.$new_order, 'Bonus'),
	anchor('customerlist/index/'.$offset.'/Discount/'.$new_order, 'Discount'),
	//anchor('manageoperatorlist/index/'.$offset.'/Zip/'.$new_order, 'Zip'),
	//anchor('manageoperatorlist/index/'.$offset.'/Country/'.$new_order, 'Country'),
	//anchor('manageoperatorlist/index/'.$offset.'/Telephone/'.$new_order, 'Telephone'),
	'Actions');
	 
	$i = 0 + $offset;
	foreach ($Users as $Users) {
	$this->table->add_row(
	$Users->Seq,
	//$Users->Operator,
	$Users->Name,
	$Users->Address1,
	//$Users->Address2,
	$Users->City,
	$Users->State,
	$Users->Zip,
	$Users->Telephone,
	//$Users->EBill,
	//$Users->Bonus,
	$Users->Discount,
	
	
	//anchor('manageoperatorlist/view/'.$Users->ShortName,'view',array('class'=>'view')).'   '.
	anchor('customerlist/update/'.$Users->Seq,'Update',array('class'=>'update')).'   '.
	anchor('customerlist/delete/'.$Users->Seq,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Operator?')"))
	);
	 
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
		$this->load->view('pages/customerlist_view', $data);
		$this->load->view('pages/template/footer');
	 }
	 
	

	
	function validate_add()
	{
	$data['title'] = 'Add New Operator';
	$data['action'] = site_url('customerlist/validate_add');
	$data['link_back'] = anchor('/customerlist/index/','Back to Customer list',array('class'=>'back'));
	
	$this->_set_rules();

	// run validation
		if ($this->form_validation->run() === FALSE){
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Add new Operator';
			$data['message'] = '';
			$data['Users']['Seq']='';
			$data['Users']['Operator']='';
			$data['Users']['Name']='';
			$data['Users']['Address1']='';
			$data['Users']['Address2']='';
			$data['Users']['City']='';
			$data['Users']['State']='';
			$data['Users']['Zip']='';
			$data['Users']['Telephone']='';
			$data['Users']['EBill']='';
			$data['Users']['Bonus']='';
			$data['Users']['Discount']='';
			
			$data['link_back'] = anchor('customerlist/index/','See List Of Customers',array('class'=>'back'));
			
			
			$data['Role']=$this->session->userdata('role');
			
				$this->load->view('pages/template/header');
				$this->load->view('pages/template/nav', $data);
				$this->load->view('pages/customerlistedit_view', $data);
				$this->load->view('pages/template/footer');

		
		}else{
		
			// save data
		     
			$User = array(
				'Seq' => $this->input->post('Seq'),
				'Operator' => $this->input->post('Operator'),
	 		    'Name' => $this->input->post('Name'),
				'Address1' => $this->input->post('Address1'),
				'Address2' => $this->input->post('Address2'),
				'City' => $this->input->post('City'),
				'State' => $this->input->post('State'),
				'Zip' => $this->input->post('Zip'),
				'Telephone' => $this->input->post('Telephone'),
	 			'EBill' => $this->input->post('Telephone'),
				'Bonus' => $this->input->post('Bonus'),
				'Discount' => $this->input->post('Discount'),				
				);
			
			$id = $this->customerlistmodel->create_operator($User);
			
			//$id = $this->manageoperatormodel->create_operator($Rolename, $Operator, $Username, $Password, $Email);

			// set form input name="id"
			//$this->validation->id = $id;

			redirect('customerlist/index/add_success','Refresh');
			
		}
	}
	
	function view($id){
		// set common properties
		$data['title'] = 'Customer Information';
		$data['link_back'] = anchor('customerlistview/index/','List Of Operators',array('class'=>'back'));

		// get Operators details
		$data['Users'] = $this->customerlistmodel->get_by_id($id)->row();

		// load view
		$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/customerlistedit_view', $data);
		$this->load->view('pages/template/footer');
			
		
		
	}
	 
	function update($id){
	 
	// set common properties
	 	$data['title'] = 'Update Customer Info';
		$data['link_back'] = anchor('/customerlist/index/','Back to Customer list',array('class'=>'back'));
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	//$this->_set_rules();
	 	$data['action'] = ('customerlist/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	
	 	$data['Users'] = (array)$this->customerlistmodel->get_by_id($id)->row();
	 	$data['title'] = 'Update Customer : '. $data['Users']['Name'] ;
		$data['message'] = '';
		 
	
	 	}else{
			
			$data['Users'] = $this->customerlistmodel->get_by_id($id)->row();
	 
	// save data
		$id = $this->input->post('Seq');
	 	
	 	$User = array(
				
	 			'Operator' => $this->input->post('Operator'),
	 		    'Name' => $this->input->post('Name'),
				'Address1' => $this->input->post('Address1'),
				'Address2' => $this->input->post('Address2'),
				'City' => $this->input->post('City'),
				'State' => $this->input->post('State'),
				'Zip' => $this->input->post('Zip'),
				'Telephone' => $this->input->post('Telephone'),
	 			'EBill' => $this->input->post('Telephone'),
				'Bonus' => $this->input->post('Bonus'),
				'Discount' => $this->input->post('Discount'),
	 			);
	 	var_dump($User);
	 	$this->customerlistmodel->update($id,$User);
	 	//$data['Users'] = (array)$this->manageoperatormodel->get_by_id($id)->row();
	 
	// set user message
	
		$message = "Operator Update successful";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
        		</script>';
   			 }
			 
	 	$data['message'] = 'update Customer Data success';
		redirect('customerlist/index/add_success','Refresh');
		
		//message
	
	 	}
	 	//$data['link_back'] = anchor('manageoperatorlist/index/','Back to Operator List',array('class'=>'back'));
	 
	// load view
	$data['Role']=$this->session->userdata('role');
	 		$this->load->view('pages/template/header');
			$this->load->view('pages/template/nav',$data);
	 		$this->load->view('pages/customerlistedit_view', $data);
			$this->load->view('pages/template/footer');
			
	 	}
		
		
		
	 
	function delete($id){
	 // delete Operator
	 	$this->customerlistmodel->delete($id);
	 
	// redirect to Operator list page
	 	redirect('customerlist/index/delete_success','refresh');
		
	 	}
 
	// validation rules
	 
	function _set_rules(){
	 	
		
		$this->form_validation->set_rules('ShortName', 'ShortName', 'required|trim');
		
		
	 	//$this->form_validation->set_rules('gender', 'Password', 'required');
	 	
		
		
		}
	 
	// date_validation callback
	 
	
	 
	}
	 

?>

