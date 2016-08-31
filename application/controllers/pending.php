<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");

class Pending extends CI_Controller
{
	//private 
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('pendingmodel','',TRUE);
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
	function index($offset = 0, $order_type = 'asc')
	{
		
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column;
		if (empty($order_type)) $order_type = 'asc';
		
		
		$filter  = $this->input->post('SiteName');
		
		
				$atts = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		
		
		//TODO: check for valid column
		$limit =10;
		
			$upd = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
			
		// load data
		$Users = $this->pendingmodel->get_paged_list($limit, $offset, $order_type, $filter)->result();
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/pending/index/');
		
		//$config['total_rows'] = $this->pendingmodel2->count_all($order_column);
		$config['total_rows'] = 100;
		
		//$config['per_page'] = $limit;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
 		$data['title'] = "All Sites";
		$data['countpending'] =$this->pendingmodel->count_all();
		
		// generate table datav
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
	
		anchor('pending/index/'.$offset.'/Seq/'.$new_order, 'Seq'), 
		anchor('pending/index/'.$offset.'/SysCode/'.$new_order, 'SysCode'), 
		anchor('pending/index/'.$offset.'/SiteName/'.$new_order, 'Site Name'),
		anchor('pending/index/'.$offset.'/ContractName/'.$new_order, 'Contract Name'),
		anchor('pending/index/'.$offset.'/StartDate/'.$new_order, 'StartDate'),
		anchor('pending/index/'.$offset.'/EndDate/'.$new_order, 'EndDate'),
		'','', 'Actions','','');
	 
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			
			$this->table->add_row(
			
			$Users->Seq,
			$Users->SysCode,
			$Users->SiteName,
			$Users->ContractName,
			$Users->StartDate,
			$Users->EndDate,
				
		anchor((array('detailentry/index/'.$offset=0,$Users->SiteName,$order_type='asc', $Users->Seq )),'Schedule Entry',array('class'=>'detailentry')),
			
		anchor((array('copyentry/index/'.$offset=0,$Users->SiteName,$order_type='asc', $Users->Seq )),'Copy Entry',array('class'=>'copyentry')),	
		
				
		
		anchor('contractsview/update/'.$Users->Seq,'Update Contract',array('class'=>'edit'),$upd),
		//anchor('contractsview/update/'.$Users->Seq,'Update Contract',array('class'=>'edit')),		
				
		//anchor((array('contractsview/delete/'.$Users->Seq,$order_column)),'Delete Contract',array('class'=>'delete','onclick'=>"return confirm('WARNING! This will erase all data associated with the contract?  Are you sure you want to remove this Contract?')")));
	 	
		anchor('pending/update/'.$Users->Seq,'Clearflag','',array('class'=>'edit')));
		
		}
	 
		$data['table'] = $this->table->generate();

		//$clearf = $this->input->post('chkclear');
		$data['Clear_flag'] = anchor('pending/update/','Clearflag','',array('class'=>'edit'));
		// load view
		


	 	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/pending_view', $data);
		$this->load->view('pages/template/footer');	
	}
	function update($id)
	{
		
		
		
		$title = 256;
		
		$data = array
				(
               		'Attributes' => $title,
             
            	);

		$this->db->where('Seq', $id);
		$this->db->update('contract_header', $data); 
		redirect('pending/index','');

	}
	
	function clearflags()
	{
		
		
		
		}
	
	
	
  	function delete($id, $order_column)
	{
	 $data['Users'] = (array)$this->pendingmodel->get_by_id($id)->row();
	 
	 $id = $data['Users']['Seq'];
		
	 // delete all contract data
	 	$this->pendingmodel->delete($id);
	 	
		 $message = "Contract Deleted Successfully";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
				
         		</script>';
   	}
	  //redirect('pending/index/0/'.$order_column.'/asc','Refresh');
		redirect('pending/index/','Refresh');
	
	}
	
}

?>

