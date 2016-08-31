<?php 

class sitemap extends CI_Controller		 
{
	
	
		function __construct()
 		{
			parent::__construct();
			#load library dan helper yang dibutuhkan
			$this->load->library(array('table','form_validation'));
			$this->load->helper(array('form', 'url'));
			///$this->load->model('manageusermodel','',TRUE);
 		}
		
	function Administrators()
	{
		$this->load->helper('url');
		
		$data['Role']="Administrators";
		$data['Permission']="Admin";
				
		$this->load->view('pages/template/header',$data);
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/sitemapAdmin',$data);
		$this->load->view('pages/template/footer',$data);
		///ADMIN		
	}


	function Operators()
	{
		$this->load->helper('url');
		
		$data['Role']="Operators";
		$data['Permission']="Operator";
		$this->load->view('pages/template/header',$data);
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/sitemapOperators',$data);
		$this->load->view('pages/template/footer',$data);
		///OPERATOR
	}
	
	function CableSystems()
	{
		$this->load->helper('url');
		
		$data['Role']="Cablesystem";
		$data['Permission']="CableSystem";
			
		$this->load->view('pages/template/header',$data);
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/sitemapCableSystems',$data);
		$this->load->view('pages/template/footer',$data);
		///CABLESYSTEM
		
	}
		
		///LOGIN VALIDATion
	
	}

?>