


<?php
require_once("system/core/Common.php");

class CueEntrylist extends CI_Controller
{
	private $limit = 7;
 	
	
	function __construct()
 	{
		parent::__construct();
	 	#load library dan helper yang dibutuhkan
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('CueEntryModel','',TRUE);
 	}
	 
	function index($offset = 0, $order_column = 'Username', $order_type = 'asc')
	{
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'Username';
		if (empty($order_type)) $order_type = 'asc';
		//TODO: check for valid column
		// load data
		//Search
		$filter  = $this->input->post('Description');
		
		$Users = $this->CueEntryModel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
	 
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
		$config['base_url'] = site_url('/CueEntrylist/index');
		$config['total_rows'] = $this->CueEntryModel->count_all();
		$config['per_page'] = $this->limit;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		anchor('CueEntrylist/index/'.$offset.'/Name/'.$new_order, 'Name'),
		anchor('CueEntrylist/index/'.$offset.'/Description/'.$new_order, 'Description'),
		anchor('CueEntrylist/index/'.$offset.'/Number/'.$new_order, 'Num'),
		anchor('CueEntrylist/index/'.$offset.'/TimeAvail'.$new_order, 'Sec/Hour'),
		anchor('CueEntrylist/index/'.$offset.'/NCCAlias/'.$new_order, 'Alias'),'Action');
	 
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			
			$Users->Name,
			$Users->Description,			
			$Users->Number,
			$Users->TimeAvail,
			$Users->NCCAlias,
			
			
		anchor_popup('CueEntrylist/update/'.$Users->Name,'update',array('class'=>'update'),$upd).'   '.
		anchor('CueEntrylist/delete/'.$Users->Name,'delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Network?')")));
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
	 
	 
	    $data['add_networklink'] = anchor_popup('CueEntrylist/validate_add/','Add New Network',array('class'=>'AddNetwork'),$upd);
	 
		// load view
	 	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/CueEntrylist_view', $data);
		$this->load->view('pages/template/footer');
	 
	}
	 
		
	function validate_add()
	{
	$data['title'] = 'Network Entry';
	$data['action'] = site_url('CueEntrylist/validate_add');
	$data['link_back'] = anchor('/CueEntrylist/index/','Back to list of Users',array('class'=>'back'));
	
	$this->_set_rules();

	// run validation
		if ($this->form_validation->run() === FALSE){
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Network Entry';
			$data['message'] = '';
			$data['Users']['Priviledge_group']='';
			$data['Users']['Operator']='';
			$data['Users']['Username']='';
			$data['Users']['Password']='';
			$data['Users']['Email']='';
			
			$data['link_back'] = anchor('CueEntrylist/index/','See List Of Users',array('class'=>'back'));
			
			$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header');
			//$this->load->view('pages/template/nav', $data);	
			$this->load->view('pages/CueEntryedit_view', $data);
			//$this->load->view('pages/template/footer');

		
		}else{
		
			// save data
			/*
			
			$Rolename = $this->input->post('Priviledge_group');
			$Operator = $this->input->post('Operator');
			$Username = $this->input->post('Username');
			$Password = $this->input->post('Password');
			$Email = $this->input->post('Email');
			*/
			$Description = $this->input->post('Description');
			$Number = $this->input->post('Number');
 			$TimeAvail = $this->input->post('TimeAvail');
			$Preroll = $this->input->post('Preroll');
			$Contact = $this->input->post('Contact');
			$nCues = $this->input->post('nCues');
			$Min1 = $this->input->post('Min1');
					$Max1 = $this->input->post('Max1');
					$Length1 = $this->input->post('Length1');
					$Code1 = $this->input->post('Code1');
					$Min2 = $this->input->post('Min2');
					$Max2 = $this->input->post('Max2');
					$Length2 = $this->input->post('Length2');
					$Code2 = $this->input->post('Code2');
					$NCCAlias = $this->input->post('NCCAlias');
					$Exclusion = $this->input->post('Exclusion');
					$StartExclusion = $this->input->post('StartExclusion');
					$EndExclusion = $this->input->post('EndExclusion');
					$Name = $this->input->post('Name');
			
			
			
							
			//$id = $this->manageusermodel->create_user($Users);
			
			
			$id = $this->CueEntryModel->create_user($Description, $Number, $TimeAvail, $Preroll, $Contact, $nCues, $Min1, $Max1, $Length1, $Code1, $Min2, $Max2, $Length2, $Code2, $NCCAlias, $Exclusion, $StartExclusion, $EndExclusion, $Name);

			// set form input name="id"
			$this->validation->id = $id;

			redirect('CueEntrylist/index/add_success','Refresh');
			
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
	 	$data['title'] = 'Update Network';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('CueEntrylist/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
	 	$data['Users'] = (array)$this->CueEntryModel->get_by_id($id)->row();
	 	//$data['Users']['Password'] = $this->manageusermodel->decryptIt($data['Users']['Password']) ;
	 	$data['title'] = 'Update Network : '. $data['Users']['Name'] ;
		
	 	$data['message'] = '';
	 	
		}else{
	 
	// save data
	 	//$id = $this->input->post('id');
		$data['Users'] = (array)$this->CueEntryModel->get_by_id($id)->row();
	 	
		
		
		//$id = $data['Users']['Username'];
		$id = $data['Users']['Name'];
		//$id2 = $data['Users']['Username'];
			$User = array(
				
	 			'Description' => $this->input->post('Description'),
	 			'Number' => $this->input->post('Number'),
				'TimeAvail' => $this->input->post('TimeAvail'),
				'Preroll' => $this->input->post('Preroll'),
				'Contact' => $this->input->post('Contact'),
				'nCues' => $this->input->post('nCues'),
				'Min1' => $this->input->post('Min1'),
				'Max1' => $this->input->post('Max1'),
				'Length1' => $this->input->post('Length1'),
				'Code1' => $this->input->post('Code1'),
				'Min2' => $this->input->post('Min2'),
				'Max2' => $this->input->post('Max2'),
				'Length2' => $this->input->post('Length2'),
				'Code2' => $this->input->post('Code2'),
				'NCCAlias' => $this->input->post('NCCAlias'),
				'Exclusion' => $this->input->post('Exclusion'),
				'StartExclusion' => $this->input->post('StartExclusion'),
				'EndExclusion' => $this->input->post('EndExclusion'),
				'Name' => $this->input->post('Name'),
	 			);
	 	//var_dump($User);
	 	$this->CueEntryModel->update($id,$User);
		
		//var_dump($User);
	 	//$this->manageusermodel->update($id,$id2,$User1, $User2);
	 	$data['User'] = (array)$this->CueEntryModel->get_by_id($id)->row();
	 
	    $message = "Network Updated";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
				 window.opener.location.reload();
				window.close ();
        		</script>';
   			 }
	 
	 
	// set user message
	 	$data['message'] = 'update User Data success';
		//$this->load->view('CueEntrylist_view', $data);
		
	 	
		
		
		}
	 	
	 
	// load view
	 		$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header');
			//$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/CueEntryedit_view', $data);
			//$this->load->view('pages/template/footer');
	}
	 
	
	
	function delete($id){
	 $data['Users'] = (array)$this->CueEntryModel->get_by_id($id)->row();
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
			$this->form_validation->set_rules('Username', 'Username', 'callback_username_check');
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

