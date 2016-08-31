<?php
require_once("system/core/Common.php");

class Mappinglistupdate extends CI_Controller
{
	private $limit = 10;
 	
	
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('mappinglistupdatemodel','',TRUE);
 	}
	 
	function index($offset = 0, $order_column = 'SiteName', $order_type = 'asc')
	{
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'SiteName';
		if (empty($order_type)) $order_type = 'asc';
		//TODO: check for valid column
		// load data
		$Users = $this->mappinglistupdatemodel->get_by_id($order_column)->result();
		
		
		 $upd = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		$this->load->library('pagination');
		$config['base_url'] = site_url('/mappinglistupdate/index');
		$config['total_rows'] = $this->mappinglistupdatemodel->count_all();
		$config['per_page'] = $this->limit;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();	
		
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		anchor('mappinglistupdate/index/'.$offset.'/Network/'.$new_order, 'Network'),
		anchor('mappinglistupdate/index/'.$offset.'/HENumber/'.$new_order, 'Head End'),
		anchor('mappinglistupdate/index/'.$offset.'/NetworkNum/'.$new_order, 'Network'),'Actions');
		
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			
			$Users->Network,
			$Users->HENumber,			
			$Users->NetworkNum,
			
			
			
		anchor_popup(array('mappinglistupdate/update/'.$order_column,$Users->Network),'update',array('class'=>'update'),$upd)
		//.'   '.
		//anchor('mappinglist/delete/'.$Users->SiteName,'delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this User?')"))
		
		);
		
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
	 	$data['SiteName'] = $order_column;
		$data['link_back'] =  anchor('mappinglist/index/','Back to Site List',array('class'=>'Back'));
		
		
		 $data['add_network'] =  anchor_popup('mappinglist/validate_add/','Add New Network',array('class'=>'AddNetwork'),$upd);
		 
		 
		 
	 
		//$data['SSID'] = $Users->SSID;
		// load view
	 	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/mappinglistupdate_view', $data);
		$this->load->view('pages/template/footer');
	 
	 	
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
	
	

	 
	function update($SiteName, $Network){
	 
		// set common properties
	 	$data['title'] = 'Update Network';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('mappinglistupdate/update/'.$SiteName.'/'.$Network);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	
	 	$data['Users'] = (array)$this->mappinglistupdatemodel->get_by_site_network($SiteName, $Network)->row();
	 	$data['title'] = 'Update Network:'.$Network;
		$data['message'] = '';
		 
	
	 	}else{
			
			$data['Users'] = $this->mappinglistupdatemodel->get_by_id($Network)->row();
	 
	// save data
		//$id = $this->input->post('ShortName');
	 			
	 			$HENumber = $this->input->post('HENumber');
				$NetworkNum = $this->input->post('NetworkNum');
				
	 			
	 	//var_dump($User);
	 	
		$this->mappinglistupdatemodel->update($SiteName, $Network,$HENumber,$NetworkNum);
	 
	
		$message = "Network Info Update successful";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		 window.opener.location.reload();
				window.close ();
        		</script>';
   			 }
			 
	 
	 	}
	 	
	 
	// load view
	$data['Role']=$this->session->userdata('role');
	 		$this->load->view('pages/template/header');
			//$this->load->view('pages/template/nav',$data);
	 		$this->load->view('pages/mappinglistedit_view', $data);
			//$this->load->view('pages/template/footer');
			
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

