
<?php  

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");

class ClearCache extends CI_Controller
{
	
	
	
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('manageusermodel','',TRUE);
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
		
		$this->db->cache_delete_all();
		$data['message'] = 'Database Cache has been cleared!';
	 
		// load view
	 	$data['Role']=$this->session->userdata('role');
		
		
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/clearcache_view', $data);
		$this->load->view('pages/template/footer');
	 
	}
	 
		
	
	} 

?>

