
<?php
require_once("system/core/Common.php");

class ControllerAuditTrail extends CI_Controller
{
	private $limit = 20;
 		
	function __construct()
 	{
		parent::__construct();
	 
	#load library dan helper yang dibutuhkan
	 
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('AuditTrail','',TRUE);
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
	
	
	function print_hello_world()
	{
				
	$this->load->library('cezpdf');
	
		//$this->cezpdf->ezText('Hello World', 12, array('justification' => 'center'));
		//$this->cezpdf->ezSetDy(-10);
 
		$query = $this->db->select('*')
                        ->from('audittrail')
						->get();
			
		
		$col_names = array(
			'User' => 'Username',
			'Role' => 'Role',
			'Action' => 'Action',
			'Date' => 'Date',
			'IPAddress'=> 'IP Address',
			
			
		);
		
		foreach ($query->result_array() as $row)
			{
		$db_data[] = array('User' => $row['User'],
							'Role'=>$row['Role'], 
							'Action'=>$row['Action'], 
							'Date'=>$row['Date'], 
							'IPAddress'=> $row['IPAddress']);
		
			}
		
		$options = array(
		'width'=>550,
		'fontSize'=>8,
		'showLines'=>0
				);
		
		$this->cezpdf->ezTable($db_data, $col_names, 'Audit Trail List', $options);
		$this->cezpdf->ezStream();
	}
	 
	function index($offset = 0, $order_column = 'Date', $order_type = 'asc')
	{
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'Date';
	if (empty($order_type)) $order_type = 'asc';
	
	
	$filter  = $this->input->post('Name');
	
	$Users = $this->AuditTrail->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
	 
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/ControllerAuditTrail/index');
	$config['total_rows'] = $this->AuditTrail->count_all();
	$config['per_page'] = $this->limit;
	$config['uri_segment'] = 3;
	$this->pagination->initialize($config);
	$data['pagination'] = $this->pagination->create_links();
 
	// generate table data
	$this->load->library('table');
	$this->table->set_empty("");
	$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
	$this->table->set_heading(
	anchor('ControllerAuditTrail/index/'.$offset.'/User/'.$new_order, 'User'),
	anchor('ControllerAuditTrail/index/'.$offset.'/Role/'.$new_order, 'Role'),
	anchor('ControllerAuditTrail/index/'.$offset.'/Action/'.$new_order, 'Action'),
	anchor('ControllerAuditTrail/index/'.$offset.'/Date/'.$new_order, 'Date'),
	anchor('ControllerAuditTrail/index/'.$offset.'/IPAddress/'.$new_order, 'IPAddress'),
	//anchor('manageoperatorlist/index/'.$offset.'/Address2/'.$new_order, 'Address2'),
	//anchor('TrafficManageAgencies/index/'.$offset.'/City/'.$new_order, 'City'),
	//anchor('TrafficManageAgencies/index/'.$offset.'/State/'.$new_order, 'State'),
	//anchor('manageoperatorlist/index/'.$offset.'/Zip/'.$new_order, 'Zip'),
	//anchor('manageoperatorlist/index/'.$offset.'/Country/'.$new_order, 'Country'),
	//anchor('manageoperatorlist/index/'.$offset.'/Telephone/'.$new_order, 'Telephone'),
	'Actions');
	 
	$i = 0 + $offset;
	foreach ($Users as $Users) {
	$this->table->add_row(
	$Users->User,
	$Users->Role,
	$Users->Action,
	$Users->Date,
	$Users->IPAddress,
	
	
	//anchor('manageoperatorlist/view/'.$Users->ShortName,'view',array('class'=>'view')).'   '.
	//anchor('ControllerAuditTrail/update/'.$Users->User,'update',array('class'=>'update')).'   '.
	anchor('ControllerAuditTrail/delete/'.$Users->User,'delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Operator?')"))
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

		
		$atts = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		
		$data['print_me'] = anchor_popup('/ControllerAudittrail/print_hello_world/','Print Audit Trail List',array('class'=>'print_hello_world'),$atts);
		
		
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/AuditTrailList', $data);
		$this->load->view('pages/template/footer');
		
	 }
	 
	

	
	function validate_add()
	{
	$data['title'] = 'Add New Agency';
	$data['action'] = site_url('TrafficManageAgencies/validate_add');
	$data['link_back'] = anchor('/TrafficManageAgencies/index/','Back to Operators list',array('class'=>'back'));
	
	$this->_set_rules();

	// run validation
		if ($this->form_validation->run() === FALSE){
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Add new Agency';
			$data['message'] = '';
			$data['Users']['Name']='';
			$data['Users']['Rate']='';
			$data['Users']['Address1']='';
			$data['Users']['Address2']='';
			$data['Users']['City']='';
			$data['Users']['State']='';
			$data['Users']['Zip']='';
			$data['Users']['Country']='';
			$data['Users']['Telephone']='';
		
			
			$data['link_back'] = anchor('TrafficManageAgencies/index/','See List Of Users',array('class'=>'back'));
			
			
			 	$data['Role']=$this->session->userdata('role');
			
				$this->load->view('pages/template/header');
				//$this->load->view('pages/template/nav', $data);
				$this->load->view('pages/TrafficManageAgencyEdit_view', $data);
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
				'Country' => $this->input->post('Country'),
				'Telephone' => $this->input->post('Telephone'),
	 			);
			
			$id = $this->TrafficManageAgencies_model->create_agencies($User);
			
			//$id = $this->manageoperatormodel->create_operator($Rolename, $Operator, $Username, $Password, $Email);

			// set form input name="id"
			//$this->validation->id = $id;

			redirect('TrafficManageAgencies/index/add_success','Refresh');
			
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
	 	$data['title'] = 'Update Operator';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('TrafficManageAgencies/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	
	 	$data['Users'] = (array)$this->TrafficManageAgencies_model->get_by_id($id)->row();
	 	$data['title'] = 'Update Agency : '. $data['Users']['Name'] ;
		$data['message'] = '';
		 
	
	 	}else{
			
			$data['Users'] = $this->TrafficManageAgencies_model->get_by_id($id)->row();
	 
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
				'Country' => $this->input->post('Country'),
				'Telephone' => $this->input->post('Telephone'),
	 			);
	 	//var_dump($User);
	 	$this->TrafficManageAgencies_model->update($id,$User);
	 	$data['Users'] = (array)$this->TrafficManageAgencies_model->get_by_id($id)->row();
	 
	// set user message
	$data['message'] = 'Operator Update successful';
		//$message = "Operator Update successful";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
        		</script>';
   			 }
			 
	 	$data['message'] = 'update Agency Data success';
		redirect('TrafficManageAgencies/index/add_success','Refresh');
		
		//message
	
	 	}
	 	//$data['link_back'] = anchor('manageoperatorlist/index/','Back to Operator List',array('class'=>'back'));
	 
	// load view
	 	$data['Role']=$this->session->userdata('role');
	 		$this->load->view('pages/template/header');
		//	$this->load->view('pages/template/nav',$data);
	 		$this->load->view('pages/TrafficManageAgencyEdit_view', $data);
			$this->load->view('pages/template/footer');
			
	 	}
		
		
		
	 
	function delete($id){
	 // delete Operator
	 	$this->TrafficManageAgencies_model->delete($id);
	 
	// redirect to Operator list page
	 	redirect('TrafficManageAgencies/index/delete_success','refresh');
		
	 	}
 
	// validation rules
	 
	function _set_rules(){
	 	
		
		$this->form_validation->set_rules('Name', 'Name', 'required|trim');
		
		
	 	//$this->form_validation->set_rules('gender', 'Password', 'required');
	 	
		
		
		}
	 
	// date_validation callback
	 
	
	 
	}
	 

?>

