<script>


window.onunload = function(){
  window.opener.location.reload();
};


</script>
<?php
require_once("system/core/Common.php");

class clearflag extends CI_Controller
{
	private $limit = 10;
 	
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('clearflagmodel','',TRUE);
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
  

	function update($id){
	 
		
	 		$data['clear'] = $id;
 
	
	 		$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header2');
			//$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/clearflag_view', $data);
		}
	
	
	
	
		

}

?>

