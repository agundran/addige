<?php

if(! defined('BASEPATH')) exit ('no direct script allowed');

required_once('system/core/Common.php');


class Ebillbycustomer extends CI_Controller{
	
	
	function __construct(){
		parent::construct();
		$this->load->library(array('table','form_validation'));
		$this->load->helper(array('form','url'));
		$this->load->model('ebillbycustomermodel','',TRUE);
		}
		
	function is_logged_in(){
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if (!isset($is_logged_in) || $is_logged_in != true){
		echo 'you don\'t have permission to access this page. <a href="pages/login">Login</a>';
		die();
		}	
		}	
		
	function index(){}
	
	
	
	
	}
?>
