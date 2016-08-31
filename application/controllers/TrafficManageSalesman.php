
<?php
require_once("system/core/Common.php");

class TrafficManageSalesman extends CI_Controller
{
	private $limit = 20;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('TrafficManageSalesman_model','',TRUE);
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
	
	$filter  = $this->input->post('Name');
	
	$Users = $this->TrafficManageSalesman_model->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/TrafficManageSalesman/index');
	$config['total_rows'] = $this->TrafficManageSalesman_model->count_all();
	$config['per_page'] = $this->limit;
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
	$this->table->set_heading(
	anchor('TrafficManageSalesman/index/'.$offset.'/Sales/'.$new_order, 'Sales'),
	anchor('TrafficManageSalesman/index/'.$offset.'/City/'.$new_order, 'City'),
	anchor('TrafficManageSalesman/index/'.$offset.'/State/'.$new_order, 'State'),
	//anchor('manageoperatorlist/index/'.$offset.'/Address2/'.$new_order, 'Address2'),
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
	
	anchor_popup('TrafficManageSalesman/update/'.$Users->Seq,'Update',array('class'=>'update'), $upd).'   '.
	//anchor('manageoperatorlist/view/'.$Users->ShortName,'view',array('class'=>'view')).'   '.
	//anchor('TrafficManageSalesman/update/'.$Users->Seq,'update',array('class'=>'update')).'   '.
	anchor('TrafficManageSalesman/delete/'.$Users->Seq,'delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Operator?')"))
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
		$this->load->view('pages/TrafficManageSalesmanList_view', $data);
		$this->load->view('pages/template/footer');
	 }
	 
	

	
	function validate_add()
	{
	$data['title'] = 'Add New Agency';
	$data['action'] = site_url('TrafficManageSalesman/validate_add');
	$data['link_back'] = anchor('/TrafficManageSalesman/index/','Back to Operators list',array('class'=>'back'));
	
	$this->_set_rules();

	// run validation
		if ($this->form_validation->run() === FALSE){
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Add new Salesman';
			$data['message'] = '';
			$data['Users']['Name']='';
			$data['Users']['Rate']='';
			$data['Users']['Address1']='';
			$data['Users']['Address2']='';
			$data['Users']['City']='';
			$data['Users']['State']='';
			$data['Users']['Zip']='';
			$data['Users']['Telephone']='';
			
		
			
			$data['link_back'] = anchor('TrafficManageSalesman/index/','See List Of Users',array('class'=>'back'));
			
			
			 	$data['Role']=$this->session->userdata('role');
			
				$this->load->view('pages/template/header');
				//$this->load->view('pages/template/nav', $data);
				$this->load->view('pages/TrafficManageSalesmanEdit_view', $data);
				$this->load->view('pages/template/footer');

		
		}else{
		
			// save data
		    // $ShortName = $this->input->post('ShortName');
			 //$TrimShortName = preg_replace('/\s+/','',($ShortName));
			 
			$User = array(
				'Name' => $this->input->post('Name'),
				'Rate' => $this->input->post('Rate'),
				'Address1' => $this->input->post('Address1'),
				'Address2' => $this->input->post('Address2'),
				'City' => $this->input->post('City'),
				'State' => $this->input->post('State'),
				'Zip' => $this->input->post('Zip'),
				'Telephone' => $this->input->post('Telephone'),
	 			);
			
			$id = $this->TrafficManageSalesman_model->create_salesman($User);
			
			//$id = $this->manageoperatormodel->create_operator($Rolename, $Operator, $Username, $Password, $Email);

			// set form input name="id"
			//$this->validation->id = $id;

			//redirect('TrafficManageSalesman/index/add_success','Refresh');
			
			
			$message = "Salesman ".$User['Name']." successfully added!";
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
	 
	function update($id){
	 
	// set common properties
	 	$data['title'] = 'Update Salesman';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('TrafficManageSalesman/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	
	 	$data['Users'] = (array)$this->TrafficManageSalesman_model->get_by_id($id)->row();
	 	$data['title'] = 'Update Salesman : '. $data['Users']['Name'] ;
		$data['message'] = '';
		 
	
	 	}else{
			
			$data['Users'] = $this->TrafficManageSalesman_model->get_by_id($id)->row();
	 
	// save data
		$id = $this->input->post('Seq');
	 	
	 		$User = array(
				'Name' => $this->input->post('Name'),
				'Rate' => $this->input->post('Rate'),
				'Address1' => $this->input->post('Address1'),
				'Address2' => $this->input->post('Address2'),
				'City' => $this->input->post('City'),
				'State' => $this->input->post('State'),
				'Zip' => $this->input->post('Zip'),
				'Telephone' => $this->input->post('Telephone'),
	 			);
	 	//var_dump($User);
	 	$this->TrafficManageSalesman_model->update($id,$User);
	 	$data['Users'] = (array)$this->TrafficManageSalesman_model->get_by_id($id)->row();
	 
	// set user message
		$message = "Salesman Updated successful";
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
	 		$this->load->view('pages/TrafficManageSalesmanEdit_view', $data);
			//$this->load->view('pages/template/footer');
			
	 	}
		
		
		
	 
	function delete($id){
	 // delete Operator
	 	$this->TrafficManageSalesman_model->delete($id);
	 
	// redirect to Operator list page
	 	redirect('TrafficManageSalesman/index/delete_success','refresh');
		
	 	}
 
	// validation rules
	 
	function _set_rules(){
	 	
		
		$this->form_validation->set_rules('Name', 'Name', 'required|trim');
		
		
	 	//$this->form_validation->set_rules('gender', 'Password', 'required');
	 	
		
		
		}
	 
	// date_validation callback
	 
	
	 
	}
	 

?>

