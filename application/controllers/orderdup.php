
<?php  

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");

class orderdup extends CI_Controller
{
	
	
	
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('orderdupmodel','',TRUE);
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
	function get_discount($Cinput)	{
			$limit = $Cinput;
	        echo json_encode($limit);
			  
			}
	
	function index($offset = 0, $order_column = 'SiteName', $order_type = 'asc')
	{
		
		
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'SiteName';
		if (empty($order_type)) $order_type = 'asc';
		
		$filter  = $this->input->post('ShortName');
	
	
		$limit = 10;
		
		//$limit = $this->input->post('hours');		
		
		//TODO: check for valid column
		// load data
		$Users = $this->orderdupmodel->get_paged_list($limit, $offset, $order_column, $order_type, $filter)->result();
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/orderdup/index');
		$config['total_rows'] = $this->orderdupmodel->count_all();
		
		
				
		//$config['per_page'] =$limit;
		
		$config['uri_segment'] =3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		$data['title'] = "AdSystems Site";
		$data['ContractsTobeCopy'] = "Contracts to be copied";
		$data['targetSite'] = "Target Site";
		$data['ContractsOnTargetSite'] = "Contract on target site  ";
		
		
		$data['print_them'] = site_url('/orderdup/print_user');
		
 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		anchor('orderdup/index/'.$offset.'/SiteName/'.$new_order, 'SiteName'),
		anchor('orderdup/index/'.$offset.'/City/'.$new_order, 'City'),
		anchor('orderdup/index/'.$offset.'/HENumber/'.$new_order, 'HENumber'),
		anchor('orderdup/index/'.$offset.'/SysCode/'.$new_order, 'SysCode'),'Actions','');
	 
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
			$Users->SiteName,
			$Users->City,			
			$Users->HENumber,
			$Users->SysCode,
		
			//Set Different Date Format 
			//date('d-m-Y',strtotime($Student->date_of_birth)),
			//date("F j, Y, g:i a")
			//date("Y-m-d H:i:s")
		//anchor('orderdup/update/'.$Users->SiteName,'Select',array('class'=>'update'), $upd));
		//anchor('orderdup/delete/'.$Users->SiteName,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this User?')"
		
		anchor((array('contracttobecopied/index/'.$Users->$offset=0,$Users->SiteName,$Users->$order_type='asc' ))   ,'Select',array('class'=>'contracttobecopied')));
		
		
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
		
		$atts = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		
		$data['print_me'] = anchor_popup('/orderdup/print_user/','Print User List',array('class'=>'print_hello_world'),$atts);
		
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/orderdup_view', $data);
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
			
			
			$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header');
			$this->load->view('pages/manageuseredit_view', $data);
		
		
		}else{
		
			// save data
			$Rolename = $this->input->post('Priviledge_group');
			$Operator = $this->input->post('Operator');
			$Username = $this->input->post('Username');
			$Password = $this->input->post('Password');
			$Email = $this->input->post('Email');
			
							
			
			$id = $this->manageusermodel->create_user($Rolename, $Operator, $Username, $Password, $Email);

			// set form input name="id"
			//$this->validation->id = $id;

		
		
			//redirect('manageuserlist/index/add_success','Refresh');
		 $message = "New User Added Successfully";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		window.close ();
        		</script>';
				}	
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
	 	$data['title'] = 'Contracts to be copied';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules_edit();
	 	$data['action'] = ('orderdup/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	//$data['message'] = '';
	 	$data['Users'] = (array)$this->orderdupmodel->get_by_id($id)->row();
	 	//$data['Users']['Password'] = $this->orderdupmodel->decryptIt($data['Users']['Password']) ;
	 	//$data['title'] = 'Update User : '. $data['Users']['Username'] ;
	 	//$data['message'] = '';
	 	
		}else{
	 
	// save data
	 	//$id = $this->input->post('id');
		$data['Users'] = (array)$this->orderdupmodel->get_by_id($id)->row();
	 	
		
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		anchor('orderdup/index/'.$offset.'/Seq/'.$new_order, 'Seq'),
		anchor('orderdup/index/'.$offset.'/ContractName/'.$new_order, 'ContractName'),
		anchor('orderdup/index/'.$offset.'/StartDate/'.$new_order, 'StartDate'),
		anchor('orderdup/index/'.$offset.'/EndDate/'.$new_order, 'EndDate'),'Actions','');
	 
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
			$Users->Seq,
			$Users->ContractName,			
			$Users->StartDate,
			$Users->EndDate,
		
			//Set Different Date Format 
			//date('d-m-Y',strtotime($Student->date_of_birth)),
			//date("F j, Y, g:i a")
			//date("Y-m-d H:i:s")
		anchor('orderdup/update/'.$Users->SiteName,'Select',array('class'=>'update'), $upd));
		//anchor('orderdup/delete/'.$Users->SiteName,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this User?')"
		
		
		
		
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
		
		$atts = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		//$id = $data['Users']['Username'];
		//$id = $data['Users']['PKID'];
		//$id2 = $data['Users']['Username'];
		
		//	$User1 = array(
	 		//		'Operator' => $this->input->post('Operator'),
	 			//	'Password' => $this->orderdupmodel->encryptIt($this->input->post('Password')),
					//'Email' => $this->input->post('Email'));
	 		//$User2 = array('Rolename' => $this->input->post('Priviledge_group'),
	 			//	);
		
		//var_dump($User);
	 	//$this->orderdupmodel->update($id,$id2,$User1, $User2);
	 	//$data['User'] = (array)$this->orderdupmodel->get_by_id($id)->row();
	 
	 	// set user message
	 	//$data['message'] = 'update User Data success';
	 	
		}
	 	///$data['link_back'] = anchor('manageuserlist/index/','Cancel Update',array('class'=>'back'));
	 
	// load view//
	 		$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header');
			$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/contractstobecopied_view', $data);
		//	$this->load->view('pages/template/footer');
	}
	 
	function delete($id){
	 $data['Users'] = (array)$this->manageusermodel->get_by_id($id)->row();
	 $id = $data['Users']['PKID'];
	 $id2 = $data['Users']['Username'];
		
	 // delete user
	 	$this->manageusermodel->delete($id, $id2);
	 	
	// redirect to Student list page
	 	redirect('manageuserlist/index/delete_success','Refresh');
	 	}
 
	// validation rules
	 
	function _set_rules(){
		
		$this->form_validation->set_rules('Rolename', 'priviledge_group');
			$this->form_validation->set_rules('Operator', 'operator');
			$this->form_validation->set_rules('Username', 'Username', 'required|min_length[4]|max_length[20]|is_unique[users.Username]');
			$this->form_validation->set_rules('Password', 'Password', 'trim|min_length[4]|max_length[32]');
			$this->form_validation->set_rules('Email', 'Email Address', 'trim|valid_email');
			
	 	}
	 
	 	function _set_rules_edit(){
		
		$this->form_validation->set_rules('Rolename', 'priviledge_group');
			$this->form_validation->set_rules('Operator', 'operator');
			//$this->form_validation->set_rules('Username', 'Username', 'required|min_length[4]|max_length[20]|is_unique[users.Username]');
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
	 
	 
	function print_user()
	{
				
	$this->load->library('cezpdf');
	
		//$this->cezpdf->ezText('Hello World', 12, array('justification' => 'center'));
		//$this->cezpdf->ezSetDy(-10);
 
		$query = $this->db->select('*')
                        ->from('users')
                        ->join('usersinroles', 'users.Username= usersinroles.Username')
						->get();
			
		
		$col_names = array(
			'Username' => 'Username',
			'Operator' => 'Operator',
			'Email' => 'Email',
			'Rolename'=> 'User Access',
			'LastLoginDate'=> 'Last Login',
			'LastActivityDate'=> 'Last Activity'
			
		);
		
		foreach ($query->result_array() as $row)
			{
		$db_data[] = array('Username' => $row['Username'],
							'Operator'=>$row['Operator'], 
							'Email'=>$row['Email'], 
							'Rolename'=> $row['Rolename'], 
							'LastLoginDate'=>$row['LastLoginDate'], 
							'LastActivityDate'=>$row['LastActivityDate']);
		
			}
		
		$options = array(
		'width'=>550,
		'fontSize'=>8,
		'showLines'=>0
				);
		
		$this->cezpdf->ezTable($db_data, $col_names, 'Addige User List', $options);
		$this->cezpdf->ezStream();
	}
	
	} 

?>

