<script>

window.onunload = function(){
  window.opener.location.reload();
};


</script>

<?php
require_once("system/core/Common.php");

class Legacysetcontractname extends CI_Controller
{
	private $limit = 12;
 		
	function __construct()
 	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	 	$this->load->model('legacysetcontractnamemodel','',TRUE);
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
	 
	 
	function index(){
	
	
	
	
	
	$data['action'] = site_url('legacysetcontractname/index/');
	

	$data['currentuser'] = $this->session->userdata('username');
	$myuser = $data['currentuser'];
	$astartdate = $this->legacysetcontractnamemodel->get_billingstartdate($myuser);
	$aenddate = $this->legacysetcontractnamemodel->get_billingenddate($myuser);
	$cm = $this->legacysetcontractnamemodel->get_currentmonth($myuser);
	$StartDate = date('Y-m-d',strtotime($astartdate));
	$EndDate = date('Y-m-d',strtotime($aenddate));
	 
	
	$upd = 
	 array(
              'width'      => '1300',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );

    //Put the value in an array to pass to the view. 
   // $data['sc'] = "9129";
	
	
    $data['sysname'] =0 ;
    //Pass to the value to the view. Access it as '$search' in the view.
    //$this->load->view("about", $view_data);
	
	
	
	$data['title1'] = 'Current Billing Period is: '.$cm." ".'('.$StartDate." "."to"." ".$EndDate.")";		
	//$data['setbm'] = anchor('BillingSetInvoicingMonth/index/'.$syscode,'(change)',array('class'=>'changebillingmonth'));
	$data['setbm'] = anchor_popup('BillingSetUpdate/index/','(change)',array('class'=>'changebillingmonth'),$upd);
	
	
	  
	   $data['pagination'] = "";
	   $data['table'] = "";
	// redirect('legacyinvoicing/index/'.$syscode,'Refresh');
	// load view
		$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/legacysetcontractname_view', $data);
		
		
		
		//$this->load->view('pages/template/footer');
		
	 }
	 
	
	
	function search()
{
	
	    $offset = 0;
		$order_type = 'asc';
		
		$order_column = $this->input->post('cn');
		if ($order_column == ""){
			$message = "Please input Contract Name!";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		window.history.back();
				
        		</script>';
   			 }
		}
		
		
		$currentuser = $this->session->userdata('username');
		
		$upd = 
	 array(
              'width'      => '1300',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		
		$data['currentuser'] = $this->session->userdata('username');
	$myuser = $data['currentuser'];
	$astartdate = $this->legacysetcontractnamemodel->get_billingstartdate($myuser);
	$aenddate = $this->legacysetcontractnamemodel->get_billingenddate($myuser);
	$cm = $this->legacysetcontractnamemodel->get_currentmonth($myuser);
	$StartDate = date('Y-m-d',strtotime($astartdate));
	$EndDate = date('Y-m-d',strtotime($aenddate));
		
		
		
		//$sd = $this->legacysetcontractnamemodel->get_billingstartdate($currentuser);
	//	$ed= $this->legacysetcontractnamemodel->get_billingenddate($currentuser);  
	
		$data['title1'] = 'Current Billing Period is: '.$cm." ".'('.$StartDate." "."to"." ".$EndDate.")";	
		$data['setbm'] = anchor_popup('BillingSetUpdate/index/','(change)',array('class'=>'changebillingmonth'),$upd);
		
		$Users = $this->legacysetcontractnamemodel->get_paged_list($this->limit, $offset, $order_column, $order_type)->result();
	
	$this->load->library('pagination');
		$config['base_url'] = site_url('/legacysetcontractname/search/');
		
		//$config['total_rows'] = $this->selectsitemodel->count_all($order_column);
		$config['total_rows'] = $this->legacysetcontractnamemodel->count_all($order_column, $astartdate, $aenddate);
		
		$config['per_page'] = $this->limit;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 		$data['title'] = "Contracts";
		//$data['setbm'] = "";
		
		// generate table datav
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading('Contract No','SycCode','Contract Name','Start Date','End Date' , 'Action');
		//anchor('selectsite/index/'.$offset.'/SysCode/'.$new_order, 'SysCode'),
		//anchor('selectsite/index/'.$offset.'/SiteName/'.$new_order, 'Site Name'), //'Actions'),
		//anchor('selectsite/index/'.$offset.'/City/'.$new_order, 'City'),
		//anchor('selectsite/index/'.$offset.'/State/'.$new_order, 'State'),
		
		//anchor('selectsite/index/'.$offset.'/HENumber/'.$new_order, ' HE'),
		
		//'Actions');
	 
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			$Users->c1Se,
			$Users->c1SN,
			$Users->c1C,
			$Users->c1S,
			$Users->c1E,
			
			//$Users->HENumber,
			
		
	
		anchor((array('legacyinvoicingcn/index',$Users->c1Se))   ,'Select',array('class'=>'contractsview')));
		
		//anchor('selectsite/copy/'.$Users->SiteName,'Copy Entry',array('class'=>'copy') ) 
		//.'   '.
		
		//anchor('selectsite/delete/'.$Users->SiteName,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Contract?')")))
		
	 	}
	 
		$data['table'] = $this->table->generate();
	
	 
		// load view
	 	 $data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/legacysetcontractname_view', $data);
		
	 
	}	
		
		
	 
	 
	}
	
?>

