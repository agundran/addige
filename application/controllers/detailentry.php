
<?php
require_once("system/core/Common.php");

class Detailentry extends CI_Controller
{
	private $limit = 100;
 	
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('detailentrymodel','',TRUE);
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
	  $Users = $this->detailentrymodel->get_paged_list($this->limit, $offset, $contractno, $order_type, $filter, $filter1)->result();
	   
	   
	   $this->load->library('pagination');
		//Contract Data
		
		
		
		// generate pagination
		
		$config['base_url'] = site_url('/detailentry/index/'.($offset+=10).'/'.$contractno.'/'.$order_type.'/');
		//$config['total_rows'] = $this->detailentrymodel->count_all_results($contractno);
		//$config['per_page'] = $this->limit;
		$config['uri_segment'] = 6;
		//$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 		$data['title'] = "Schedule for contract #".$contractno;
		$data['subtitle'] = "Site: ".$siteoperator;
		
		$Users1=$this->detailentrymodel->contractdetails($contractno)->result();
		$data['Seq1']=$contractno;
		
		foreach ($Users1 as $Users1){
			
			$data['CustOrder1']=$Users1->CustOrder;
			$data['Contractname1'] = $Users1->ContractName;
			$data['StartDate1']= $Users1->StartDate;
			$data['EndDate1']= $Users1->EndDate;
					
			} 
		
		
		$data['no_row'] = $this->detailentrymodel->count_all_results($contractno);
		$data['filter'] = $filter;
		
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		anchor('detailentry/index/'.$offset.'/Line/'.$new_order, 'Line'),
		anchor('detailentry/index/'.$offset.'/Network/'.$new_order, 'Network'),
		anchor('detailentry/index/'.$offset.'/StartDate/'.$new_order, 'Start Date'),
		anchor('detailentry/index/'.$offset.'/EndDate/'.$new_order, 'EndDate'),
		anchor('detailentry/index/'.$offset.'/Value/'.$new_order, 'Value'),'Actions','');
	 	
		$i = 0 + $offset;
	
		$tcsv = 0;
		//$csv = 0;	
		foreach ($Users as $Users) {
			
			//$csv = $this->detailentrymodel->ComputeSchedValue($contractno);
			
			//if ($csv = "")
			//{
				//$csv = $csv2; 
				//$csv2 = $csv3;
				//}
			
			$this->table->add_row(
			
			$Users->Line,
			$Users->Network,
			$Users->StartDate,			
			$Users->EndDate,
			$Users->Value,
			//$Users->Attributes,
		
		//anchor('contractsview/index/'.$Users->SiteName,'Contract'.'&nbsp|&nbsp',array('class'=>'contract')).'   '.
		//anchor('selectsite/schedule/'.$Users->SiteName,'Schedule&nbsp|&nbsp',array('class'=>'schedule')).'   '.
		anchor_popup(array('detailentryencode/update/'.$Users->Line,$siteoperator),'Update',array('class'=>'update'),$atts)
		,
		
		anchor(array('detailentry/delete/'.$Users->Line,$siteoperator,$contractno),'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Schedule?')")));
		
		$tcsv +=$Users->Value;
	 	}
		
		$this->table->add_row("","","Total","",number_format($tcsv,2),"","");
	 
		$data['table'] = $this->table->generate();
	
		if ($this->uri->segment(3)=='delete_success')
			$data['message'] = 'The Data was successfully deleted';
		else if ($this->uri->segment(3)=='add_success')
			$data['message'] = 'The Data has been successfully added';
		else if ($this->uri->segment(3)=='update_success')
			$data['message'] = 'The Data has been successfully updated';
		else
		$data['message'] = '';
	    $data['link_back'] = '';
		//$data['add_sched'] = anchor_popup(array('detailentry/index/'.$siteoperator,$order_column),'Add Schedule',array('class'=>'detailentry'),$atts);
		 
		 
		 $data['add_sched'] = anchor_popup(array('detailentryencode/index/'.$contractno,$siteoperator),'Add Schedule',array('class'=>'detailentry'),$atts);
		 
		 //anchor_popup(array('detailentryencode/index/'.$siteoperator,$contractno),'Add Schedule',array('class'=>'detailentryencode'),$atts);
		 
		// load view
	 	 $data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/detailentry_view', $data);
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
	 	$data['Users'] = (array)$this->detailentrymodel->get_by_id($id)->row();
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
	

	 
	 	//$Users2 = array(
	 				//'Name' => $this->input->post('CIndex'));
			
	 
	 
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



	function delete($id, $siteoperator,$contractno){
	 	$data['Users'] = (array)$this->detailentrymodel->get_by_id($id)->row();
		 $id = $data['Users']['Line'];
		 
		
	 
	 	$this->detailentrymodel->delete($id);

	 	redirect('detailentry/index/0/'.$siteoperator.'/0/'. $contractno,'Refresh');
		
		//redirect('detailentry/index/'.$offset=0,$siteoperator,$order_type='asc', $contractno,'Refresh');

	 	}
		
}

?>

