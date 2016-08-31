
<?php
require_once("system/core/Common.php");

class TrafficManageCustomers extends CI_Controller
{
	private $limit = 20;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('TrafficManageCustomers_model','',TRUE);
		$this->is_logged_in();
 	}
	
	 function is_logged_in()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!isset($is_logged_in) || $is_logged_in != true){
		echo 'you don\'t have permission to access this page. <a href="'. redirect(site_url('/pages/login')).'>Login</a>';
		die();
		}	
	} 
	 
	function index($offset = 0, $order_column = 'Seq', $order_type = 'asc')
	{
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'Seq';
	if (empty($order_type)) $order_type = 'asc';
	
	$filter  = $this->input->post('Name');
	
	$Users = $this->TrafficManageCustomers_model->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/TrafficManageCustomers/index');
	$config['total_rows'] = $this->TrafficManageCustomers_model->count_all();
	$config['per_page'] = $this->limit;
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
	$this->table->set_heading(
	anchor('TrafficManageCustomers/index/'.$offset.'/Customer/'.$new_order, 'Customer'),
	//anchor('TrafficManageCustomers/index/'.$offset.'/Address1/'.$new_order, 'Address1'),
	anchor('TrafficManageCustomers/index/'.$offset.'/City/'.$new_order, 'City'),
	anchor('TrafficManageCustomers/index/'.$offset.'/State/'.$new_order, 'State'),
	
	//anchor('TrafficManageAgencies/index/'.$offset.'/City/'.$new_order, 'City'),
	//anchor('TrafficManageAgencies/index/'.$offset.'/State/'.$new_order, 'State'),
	//anchor('manageoperatorlist/index/'.$offset.'/Zip/'.$new_order, 'Zip'),
	//anchor('manageoperatorlist/index/'.$offset.'/Country/'.$new_order, 'Country'),
	//anchor('manageoperatorlist/index/'.$offset.'/Telephone/'.$new_order, 'Telephone'),
	'Actions');
	 
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
	$Users->Name,
	
	$Users->City,
	$Users->State,
	
	
	
	
	
	
	anchor_popup('TrafficManageCustomers/update/'.$Users->Seq,'Update',array('class'=>'update'), $upd).'   '.
	//anchor('manageoperatorlist/view/'.$Users->ShortName,'view',array('class'=>'view')).'   '.
//	anchor('TrafficManageCustomers/update/'.$Users->Seq,'update',array('class'=>'update')).'   '.
	//anchor('TrafficManageCustomers/select/'.$Users->Name,'select',array('class'=>'select')).'   '.
	anchor('TrafficManageCustomers/delete/'.$Users->Seq,'delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Customer?')"))
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
		$this->load->view('pages/TrafficManageCustomersList_view', $data);
		//$this->load->view('pages/template/footer');
	 }
	 
	

	
	function validate_add()
	{
	$data['title'] = 'Add New Agency';
	$data['action'] = site_url('TrafficManageCustomers/validate_add');
	$data['link_back'] = anchor('/TrafficManageCustomers/index/','Back to Operators list',array('class'=>'back'));
	
	$this->_set_rules();

	// run validation
		if ($this->form_validation->run() === FALSE){
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Add new Customer';
			$data['message'] = '';
			$data['Users']['Name']='';
			$data['Users']['Address1']='';
			$data['Users']['Address2']='';
			$data['Users']['City']='';
			$data['Users']['State']='';
			$data['Users']['Zip']='';
			$data['Users']['Telephone']='';
			$data['Users']['Discount']='';
			$data['Users']['EBill']='';
			$data['Users']['Bonus']='';
		
			
			$data['link_back'] = anchor('TrafficManageCustomers/index/','See List Of Users',array('class'=>'back'));
			
			
			 	$data['Role']=$this->session->userdata('role');
			
				$this->load->view('pages/template/header');
				//$this->load->view('pages/template/nav', $data);
				$this->load->view('pages/TrafficManageCustomersAdd_view', $data);
				//$this->load->view('pages/template/footer');

		
		}else{
		
			// save data
		    // $ShortName = $this->input->post('ShortName');
			 //$TrimShortName = preg_replace('/\s+/','',($ShortName));
			 
			//$User = array(
			//	'Name' => $this->input->post('Name'),
				//'Address1' => $this->input->post('Address1'),
				//'Address2' => $this->input->post('Address2'),
			//	'City' => $this->input->post('City'),
			//	'State' => $this->input->post('State'),
				//'Zip' => $this->input->post('Zip'),
				//'Telephone' => $this->input->post('Telephone'),
				//'Discount' => $this->input->post('Discount'),
				//'EBill' => $this->input->post('EBill'),
				//'Bonus' => $this->input->post('Bonus'),
	 		//	);
				
				
				$Cname = $this->input->post('Name');
				$Address1 = $this->input->post('Address1');
				$Address2 = $this->input->post('Address2');
				$City = $this->input->post('City');
				$State = $this->input->post('State');
				$Zip = $this->input->post('Zip');
				$Telephone = $this->input->post('Telephone');
				$iDiscount = $this->input->post('Discount');
				$EBill = $this->input->post('EBill');
				$Bonus = $this->input->post('Bonus');
				
				
					///State UPPERCASE
				$StateUpper = strtoupper($State);
				
				
				if ($iDiscount == "")
					{
						
						$Discount = 0.0;	
					}
				else
				{
					$Discount = $this->input->post('Discount');
				}
					
					
					
			$id = $this->TrafficManageCustomers_model->create_customers($Cname, $Address1, $Address2, $City, $StateUpper, $Zip, $Telephone, $Discount, $EBill, $Bonus);
			
			//$id = $this->manageoperatormodel->create_operator($Rolename, $Operator, $Username, $Password, $Email);

			// set form input name="id"
			//$this->validation->id = $id;

			
			
		$message = "Customer ".$Cname." successfully added!";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
				 window.opener.location.reload();
				window.close ();
        		</script>';
   			 }
			
			
		}
	}
	function view($id){
		// set common properties
		$data['title'] = 'Operator Details';
		$data['link_back'] = anchor('manageoperatorlist/index/','List Of Operators',array('class'=>'back'));

		// get Operators details
		$data['Users'] = $this->manageoperatormodel->get_by_id($id)->row();

		// load view
		$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/manageoperatoredit_view', $data);
		$this->load->view('pages/template/footer');
			
		
		
	}
	
	function select($id)
	{
		$myVar = $id;
		
		$this->load->library('session');
		$this->session->set_flashdata('variable_name', $myVar);
		
		
		
	}
	 
	function update($id){
	 
	// set common properties
	 	$data['title'] = 'Update Customer';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('TrafficManageCustomers/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	
	 	$data['Users'] = (array)$this->TrafficManageCustomers_model->get_by_id($id)->row();
	 	$data['title'] = $data['Users']['Name'] ;
		$data['message'] = '';
		 
	
	 	}else{
			
			$data['Users'] = $this->TrafficManageCustomers_model->get_by_id($id)->row();
	 
	// save data
		$id = $this->input->post('Seq');
	 	
	 	//$User = array(
			//	'Name' => $this->input->post('Name'),
				//'Address1' => $this->input->post('Address1'),
				//'Address2' => $this->input->post('Address2'),
				//'City' => $this->input->post('City'),
				//'State' => $this->input->post('State'),
				//'Zip' => $this->input->post('Zip'),
				//'Telephone' => $this->input->post('Telephone'),
				//'Discount' => $this->input->post('Discount'),
				
			//	'EBill' => $this->input->post('EBill'),
				
				
				//'Bonus' => $this->input->post('Bonus'),
	 			//);
	 	//var_dump($User);
		
				$Cname = $this->input->post('Name');
				$Address1 = $this->input->post('Address1');
				$Address2 = $this->input->post('Address2');
				$City = $this->input->post('City');
				$State = $this->input->post('State');
				$Zip = $this->input->post('Zip');
				$Telephone = $this->input->post('Telephone');
				$iDiscount = $this->input->post('Discount');
				$EBill = $this->input->post('EBill');
				$Bonus = $this->input->post('Bonus');
				
				
					///State UPPERCASE
				$StateUpper = strtoupper($State);
				
				
				if ($iDiscount == "")
					{
						
						$Discount = 0.0;	
					}
				else
				{
				$Discount = $this->input->post('Discount');
				}
			
			
		
	 	$this->TrafficManageCustomers_model->update($id,$Cname, $Address1, $Address2, $City, $StateUpper, $Zip, $Telephone, $Discount, $EBill, $Bonus);
		
	 	$data['Users'] = (array)$this->TrafficManageCustomers_model->get_by_id($id)->row();
	 
	// set user message
		$message = "Customer Updated successful";
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
	 		$this->load->view('pages/template/header');
			//$this->load->view('pages/template/nav',$data);
	 		$this->load->view('pages/TrafficManageCustomerEdit_view', $data);
			//$this->load->view('pages/template/footer');
			
	 	}
		
		
	
	 
	function delete($id){
	 // delete Operator
	 	$this->TrafficManageCustomers_model->delete($id);
	 
	// redirect to Operator list page
	 	redirect('TrafficManageCustomers/index/delete_success','refresh');
		
	 	}
 
	// validation rules
	 
	function _set_rules(){
	 	
		
		$this->form_validation->set_rules('Name', 'Name', 'required|trim');
		
		
	 	//$this->form_validation->set_rules('gender', 'Password', 'required');
	 	
		
		
		}
	 
	// date_validation callback
	 
	
	 
	}
	 

?>

