
<?php
require_once("system/core/Common.php");

class detailcontracttocopy extends CI_Controller
{
	private $limit = 25;
 	
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('detailcontracttocopy_model','',TRUE);
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
	function index($offset , $siteoperator, $order_type, $contractno)
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
	  $Users = $this->detailcontracttocopy_model->get_paged_list($this->limit, $offset, $contractno, $order_type, $filter, $filter1)->result();
	   
	   
	   $this->load->library('pagination');
		//Contract Data
		
		
		
		// generate pagination
		
		$config['base_url'] = site_url('/detailcontracttocopy/index/'.($offset+=10).'/'.$contractno.'/'.$order_type.'/');
		//$config['total_rows'] = $this->detailentrymodel->count_all_results($contractno);
		//$config['per_page'] = $this->limit;
		$config['uri_segment'] = 6;
		//$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 		$data['title'] = $contractno;
		$data['subtitle'] = $siteoperator;
		
		$Users1=$this->detailcontracttocopy_model->contractdetails($contractno)->result();
		$data['Seq1']=$contractno;
		
		foreach ($Users1 as $Users1){
			
			$data['CustOrder1']=$Users1->CustOrder;
			$data['Contractname1'] = $Users1->ContractName;
			$data['StartDate1']= $Users1->StartDate;
			$data['EndDate1']= $Users1->EndDate;
					
			} 
		
		
		$data['no_row'] = $this->detailcontracttocopy_model->count_all_results($contractno);
		$data['filter'] = $filter;
		
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		anchor('detailcontracttocopy/index/'.$offset.'/Seq/'.$new_order, 'Seq'),
		anchor('detailcontracttocopy/index/'.$offset.'/ContractName/'.$new_order, 'ContractName'),
		anchor('detailcontracttocopy/index/'.$offset.'/StartDate/'.$new_order, 'Start Date'),
		anchor('detailcontracttocopy/index/'.$offset.'/EndDate/'.$new_order, 'EndDate'),
		anchor('detailcontracttocopy/index/'.$offset.'/CustOrder/'.$new_order, 'CustOrder'),'Actions','');
	 
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			
			$Users->Seq,
		
			$Users->ContractName,
			$Users->StartDate,			
			$Users->EndDate,
			$Users->CustOrder,
			//$Users->Attributes,
		
		//anchor('contractsview/index/'.$Users->SiteName,'Contract'.'&nbsp|&nbsp',array('class'=>'contract')).'   '.
		//anchor('selectsite/schedule/'.$Users->SiteName,'Schedule&nbsp|&nbsp',array('class'=>'schedule')).'   '.
		anchor(array('detailcontracttocopy/update/'.$Users->Seq),'Select',array('class'=>'update'))
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
	    $data['link_back'] = '';

		 
		 $data['add_sched'] = anchor_popup(array('detailentryencode/index/'.$contractno,$siteoperator),'Add Schedule',array('class'=>'detailentry'),$atts);
		 
	
		 
		// load view
	 	 $data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/detailcontracttocopy_view', $data);
		$this->load->view('pages/template/footer');
	 
	
	}
	
	function insert()
{
//$this->detailcontracttocopy_model->insert();
//$this->load->view(‘success.php’);//loading success view

					//'Seq' => $this->input->post('Seq'),
					$CIndex = $this->input->post('CIndex');
	 				$ContractName = $this->input->post('ContractName');
					//$SiteName = $this->input->post('SiteName');
					$StartDate = $this->input->post('StartDate');
					$EndDate = $this->input->post('EndDate');
					$AgencyComm = $this->input->post('AgencyComm');
					$Discount = $this->input->post('Discount');
					$AIndex = $this->input->post('AIndex');
					$TotalValue = $this->input->post('TotalValue');
					
					$Attributes = $this->input->post('Attributes');
					$CustOrder = $this->input->post('CustOrder');
					$SIndex = $this->input->post('SIndex');
					$SalesComm = $this->input->post('SalesComm');
					$MinSeparation = $this->input->post('MinSeparation');
					$Revision = $this->input->post('Revision');

		foreach ($_POST['siteoperator'] as $SSiteName)
			{
			//$Sinput = $SSiteName;
			//$Sres=substr($Sinput, -14 ,(strrpos($Sinput,'-'))+15);
			$SiteName = $SSiteName;
		
			$id = $this->detailcontracttocopy_model->insert($CIndex,$ContractName,$StartDate, $EndDate, $AgencyComm, $Discount, $AIndex, $TotalValue, $Attributes , $CustOrder, $SIndex, $SalesComm,$MinSeparation, $Revision, $SiteName);
			
			 			
			}
			
			///$this->validation->id = $id;

			
		redirect('selectsite/index/','Refresh');
		$message = "Contract ".$ContractName." duplicated to site ".$SiteName." ";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
				
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
				
        		</script>';
   			 }
		
}
	
	
	function update($id){
	 
	// set common properties
	 	$data['title'] = 'Update Contract';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	//$this->_set_rules();
	 
	 	$data['action'] = site_url('detailcontracttocopy/insert');
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
	 	$data['Users'] = (array)$this->detailcontracttocopy_model->get_by_id($id)->row();
	 	$data['title'] = $id ;
	 	$data['message'] = $data['Users']['SiteName'];
	 	
		}else
		
		{
	 
	
		//$id = $data['Users']['Seq'];
		
		
			$Users = array(
	 				'Seq' => $this->input->post('Seq'),
					'CIndex' => $this->input->post('CIndex'),
	 				'ContractName' => $this->input->post('ContractName'),
					'SiteName' => $this->input->post('SiteName'),
					'StartDate' => $this->input->post('StartDate'),
					'EndDate' => $this->input->post('EndDate'),
					'AgencyComm' => $this->input->post('AgencyComm'),
					'Discount' => $this->input->post('Discount'),
					'AIndex' => $this->input->post('AIndex'),
					'TotalValue' => $this->input->post('TotalValue'),
					
					'Attributes' => $this->input->post('Attributes'),
					'CustOrder' => $this->input->post('CustOrder'),
					'SIndex' => $this->input->post('SIndex'),
					'SalesComm' => $this->input->post('SalesComm'),
					'MinSeparation' => $this->input->post('MinSeparation'),
					'Revision' => $this->input->post('Revision'),
					);
	

	 
	 	//$Users2 = array(
	 				//'Name' => $this->input->post('CIndex'));
			

			// set form input name="id"
			$this->validation->id = $id;
	 
	 
	// set user message
	 			$data['message'] = 'update Contract Data success';
	 	}
	 	$data['link_back'] = anchor('manageuserlist/index/','Cancel Update',array('class'=>'back'));
	 
	// load view
	 		$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header');
			$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/SelectedContractCopy_view', $data);
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

