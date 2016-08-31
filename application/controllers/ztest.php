<?php

//ini_set('memory_limit', '1024M');
 //   ini_set('max_execution_time', '900');
//		ini_set('post_max_size','32M');
//ini_set('upload_max_filesize','32M');

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");

	
class Ztest extends CI_Controller{	
	
	private $limit = 5;
	function __construct()
 	{
		parent::__construct();
	 	//$this->load->library(array('table','form_validation'));
	 	//$this->load->helper(array('form', 'url'));
	 	$this->load->model('ztestmodel','',TRUE);
		
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
	 
	 
		function index()
	
	
	
	{
	//$data['$phpinfo']=="phpinfo()";
	 
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav');
		$this->load->view('pages/ztest_view');
		$this->load->view('pages/template/footer');
	 }
	 


	
	
}

?>