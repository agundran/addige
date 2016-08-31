<?php

/**
* SENDS EMAIL WITH GMAIL
*/
class email extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index() 
	{	
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'reynan.macasaquit25@gmail.com',
			'smtp_pass' => 'mylove25'		
		);
		
		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		
		
		$this->email->from('reynan.macasaquit25@gmail.com', 'Jeffrey Way');
		$this->email->to('reynan.macasaquit25@gmail.com');
		$this->email->subject('This is an email test');
		$this->email->message('It is working Great!');
		
		
		
		if($this->email->send())
		{
			echo 'Your email was not sent!';
			
		}
		else
		{
			show_error($this->email->print_debugger());	
			
		}
		
		
		
	}
}


      