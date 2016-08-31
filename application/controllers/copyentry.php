
<?php
require_once("system/core/Common.php");

class Copyentry extends CI_Controller
{
	private $limit = 20;
 	
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('copyentrymodel','',TRUE);
 		$this->is_logged_in();
 	}
	 
 	function is_logged_in()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!isset($is_logged_in) || $is_logged_in != true){
		echo 'you don\'t have permission to access this page.';
		 redirect('pages/login');
		die();
		}	
	} 
	 
	 	 
	function index( $offset , $siteoperator, $order_type, $contractno)
	{
		if (empty($offset)) $offset = 0;
		if (empty($order_type)) $order_type = 'asc';
		
		
	    $filter1 = 	$this->input->post('myselect');
		$filter  = $this->input->post('myvalue');
		
		$atts = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		
		if (empty($view_sitename)) $view_sitename = $siteoperator;
		 
	//$Users = $this->contractsviewmodel->get_paged_list($this->limit, $offset, $order_column, $order_type,$filter, $filter1)->result();
	  $Users = $this->copyentrymodel->get_paged_list($this->limit, $offset, $contractno, $order_type)->result();
	   
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/copyentry/index/'.($offset+=10).'/'.$contractno.'/'.$order_type.'/');
		$config['total_rows'] = $this->copyentrymodel->count_all_results($contractno);
		$config['per_page'] = $this->limit;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 		$data['title'] = $siteoperator;
		$data['subtitle'] = $contractno;
		
		
		//$data['no_row'] = $this->copyentrymodel->count_all_results($contractno);
		//$data['filter'] = $filter;
		
		
		$Users1=$this->copyentrymodel->contractdetails($contractno)->result();
		$data['Seq1']=$contractno;
		//$data['CopyforContract'] = "Copy of Contract: ".$Users1->ContractName;
		
		foreach ($Users1 as $Users1){
			$data['Seq1']=$Users1->Seq;
			$data['CustOrder1']=$Users1->CustOrder;
			$data['Contractname1'] = $Users1->ContractName;
			$data['StartDate1']= $Users1->StartDate;
			$data['EndDate1']= $Users1->EndDate;
					
			} 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		anchor('copyentry/index/'.$offset.'/Seq/'.$new_order, 'Seq'),
		anchor('copyentry/index/'.$offset.'/Contract/'.$new_order, 'Contract'),
		anchor('copyentry/index/'.$offset.'/StartDate/'.$new_order, 'Start Date'),
		anchor('copyentry/index/'.$offset.'/EndDate/'.$new_order, 'EndDate'),
		anchor('copyentry/index/'.$offset.'/SpotName/'.$new_order, 'SpotName'),'Actions','');
	 
		$i = 0 + $offset;
		$replacesingleqoute = $Users1->ContractName;
		//$contractname = $Users1->ContractName;
		$replaceapostrophe = str_replace("'", "''", $replacesingleqoute);
		
		foreach ($Users as $Users) {
			$this->table->add_row(
			
			$Users->Seq,
			$Users->Contract,
			$Users->StartDate,			
			$Users->EndDate,
			$Users->SpotName,
			
		anchor_popup(array('copyentryencode/update/'.$Users->Seq,$siteoperator),'Update',array('class'=>'update'),$atts)
		,
		
		anchor(array('copyentry/delete/'.$Users->Seq,$siteoperator,$contractno),'Delete',array('class'=>'Delete','onclick'=>"return confirm('Are you sure you want to remove this copy?')")));
		
	 	}
	 
		$data['table'] = $this->table->generate();
	
		if ($this->uri->segment(3)=='delete_success')
			$data['message'] = 'The Data was successfully deleted';
		else if ($this->uri->segment(3)=='add_success')
			$data['message'] = 'The Data has been successfully added';
		else if ($this->uri->segment(3)=='update_success')
			$data['message'] = 'The Data has been successfully updated';
		else
		$data['NoCopytoDuplicate'] = 'No Copy!';
	    $data['link_back'] = anchor('pending/index/','Return to pending contracts',array('class'=>'back'));
	
		 
		 $data['add_sched'] = anchor_popup(array('copyentryencode/index/'.$siteoperator,$contractno),'Add',array('class'=>'copyentry'),$atts);
		 
	
		 
		 
		 		 $data['dup_copy'] = anchor(array('copyentryencode/Duplicateallcopy/'.$siteoperator,$replaceapostrophe,$Users1->Seq),'Duplicate Copy',array('class'=>'Duplicate'),$atts);
		 
		 
		 
		 
		 anchor_popup(array('copyentryencode/index/'.$siteoperator,$contractno),'Add Schedule',array('class'=>'copyentryencode'),$atts);
		 
		// load view
	 	 $data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/copyentry_view', $data);
		$this->load->view('pages/template/footer');
	 
	
	}
	
	function validate_add()
	{
	$data['title'] = 'Contract Details';
	$data['action'] = site_url('contractsview/validate_add');
	
	$data['link_back'] = anchor('selectsite/index/','Return to Select Site',array('class'=>'back'));
	//$this->_set_rules();

	// run validation
		if ($this->form_validation->run() === FALSE){
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Contract Details';
			$data['message'] = '';
			$data['Users']['SiteName']='';
			$data['Users']['Format']='';
			$data['Users']['Username']='';
			$data['Users']['Password']='';
			$data['Users']['Email']='';
			$data['link_back'] = anchor('selectsite/index/','Return to Select Site',array('class'=>'back'));
			
			
			$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header');
			$this->load->view('pages/template/nav', $data);	
			$this->load->view('pages/contractsdetail_view', $data);
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
	
	function update($contractno){
	 
	// set common properties
	 	$data['title'] = 'Update Contract';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	//$this->_set_rules();
	 	$data['action'] ='';
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
	 	$data['Users'] = (array)$this->copyentrymodel->get_by_id($id)->row();
	 	$data['title'] = 'Update Contract #: '.$id ;
	 	$data['message'] = '';
	 	
		}else{
	 
	
		$id = $data['Users']['Seq'];
		
		
			$User = array(
	 				'CIndex' => $this->input->post('CIndex'),
					'ContractName' => $this->input->post('ContractName'),
	 				'SiteName' => $this->input->post('SiteName'),
					'StartDate' => $this->input->post('StartDate'),
					'EndDate' => $this->input->post('EndDate'),
					'CustOrder' => $this->input->post('CustOrder'),
					'Discount' => $this->input->post('Discount'),
					'AIndex' => $this->input->post('AIndex'),
					'Seq' => $this->input->post('Seq'),
					'Email' => $this->input->post('Email'));
	

	 
	 
	// set user message
	 	$data['message'] = 'update Contract Data success';
	 	}
	 	$data['link_back'] = anchor('manageuserlist/index/','Cancel Update',array('class'=>'back'));
	 
	// load view
	 		$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header');
			$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/pendingsdetail_view', $data);
			$this->load->view('pages/template/footer');
	}



	 function delete($id,$siteoperator,$contractno){
	 	$data['Users'] = (array)$this->copyentrymodel->get_by_id($id)->row();
		  
	 	$this->copyentrymodel->delete($id);

	 	redirect('copyentry/index/0/'.$siteoperator.'/0/'.$contractno,'Refresh');
		
		//redirect('copyentry/index/'.$offset=0,$siteoperator,$order_type='asc', $contractno,'Refresh');

	 	}
		
}

?>

