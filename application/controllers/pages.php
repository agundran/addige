<?php 

class Pages extends CI_Controller		 
{
	
	
		function __construct()
 		{
			parent::__construct();
	 		#load library dan helper yang dibutuhkan
	 		$this->load->library(array('table','form_validation'));
	 		$this->load->helper(array('form', 'url'));
	 		$this->load->model('manageusermodel','',TRUE);
 		}
		
		
		
	
		function index()
		{
			
			$this->load->helper('url');
			
		
		
			$data['title']="";
					
			$this->load->view('pages/template/header',$data);
			$this->load->view('pages/login',$data);
			$this->load->view('pages/template/content',$data);
			$this->load->view('pages/template/footer',$data);
			///When Admin Logged in 
		

		 
		}
		///LOGIN VALIDATion
	public function login()
	{
		//VALIDATION IF USERNAME AND PASSWORD TEXTBOX IS EMPTY!
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
		
		if($this->form_validation->run() == FALSE)
			{
			//Field validation failed.  User redirected to login page

     			
				 $this->load->view('pages/template/header');
							 	$this->load->view('pages/login');
									
			//$this->load->view('pages/login',$data);
			$this->load->view('pages/template/content');
			$this->load->view('pages/template/footer');

   			}
			//IF LOGIN USERNAME AND PASSWORD IS CORRECT WILL PROCEED TO GET THE ROLE OF THE USER.
		else
			{
				
				$username = $this->input->post('username');
				
				$pass= $this->input->post('password');
				//$password = $pass;
				$password = $this->manageusermodel->encryptIt($pass);
				
				
				$this->load->model('membership_model');
				$result=$this->membership_model->getRoles()->row();
					if($result==TRUE)
					{
						$role=$result->Rolename;///AFTER GETTING THE ROLE THE RESULT WILL PASS THE ROLENAME TO THE Role variable.
					
					///
					
						$result = $this->membership_model->login($role,$username,$password);
		
						if($result==true) //IF THE USERNAME AND PASSWORD IS CORRECT.
						{
							if($role == 'Administrators') //THEN ANOTHER IF STATEMENT TO DETERMINE THE PRIVEILEDGE OF THE USER.EX. ADMINISTRATOR.
								{
							// IF USER IS ADMINISTRATOR IT WILL GO TO Admin_AreaHome
								$data = array(
										'username' => $this->input->post('username'),
										'role' =>$role,
										'is_logged_in' => true);
										$this->session->set_userdata($data);
										$this->membership_model->LastLogin();///To log the LASTLOGIN
										redirect('site/Administrators');
										$this->load->view('nav', $data);
										
										
										
										 
								}
						else if($role == 'Operators') 
						
								{
							// IF USER IS OPERATOR IT WILL GO TO Operators_Area
								$data = array(
										'username' => $this->input->post('username'),
										'role' =>$role,
										'is_logged_in' => true);
										$this->session->set_userdata($data);
										$this->membership_model->LastLogin();///To log the LASTLOGIN
										redirect('site/Operators');
										$this->load->view('nav', $data);
										
										
								}
						else if($role == 'Cablesystems')
								{
							// IF USER IS CABLE SYSTEM IT WILL GO TO CS_Area
								$data = array(
										'username' => $this->input->post('username'),
										'role' =>$role,
										'is_logged_in' => true);
										$this->session->set_userdata($data);
										$this->membership_model->LastLogin();///To log the LASTLOGIN
										redirect('site/CableSystems');
										$this->load->view('navAdmin', $data);
								}
						}
				else if($result==FALSE)
				{
				///IF THE USERNAME AND PASSWORD THE SYSTEM WILL PROMPT THE USER.
					$this->load->library('form_validation');
					$this->form_validation->set_rules('username', 'Username', 'trim|matches|xss_clean');
					$this->form_validation->set_rules('password', 'Password', 'trim|matches|xss_clean|callback_check_database');
				
				
						if($this->form_validation->run() == FALSE)
						{
						 //Field validation failed.  User redirected to login page
							$this->load->view('pages/template/header');
							 	$this->load->view('pages/login');
									
			//$this->load->view('pages/login',$data);
			$this->load->view('pages/template/content');
			$this->load->view('pages/template/footer');
							 
							 
						}
		
		
				}
					//
			}
						else
						{
							
							$this->load->library('form_validation');
							$this->form_validation->set_rules('username', 'Username', 'trim|matches|xss_clean');
							$this->form_validation->set_rules('password', 'Password', 'trim|matches|xss_clean|callback_check_database');
							
							
								if($this->form_validation->run() == FALSE)
								{
						 //Field validation failed.  User redirected to login page
						 $this->load->view('pages/template/header');
							 		$this->load->view('pages/login');
									
			//$this->load->view('pages/login',$data);
			$this->load->view('pages/template/content');
			$this->load->view('pages/template/footer');
								}
						}
				
		}
		
		
			
		
		
	}
	
	
	////end of validation
	
	
		
	function main(){
		
		$this->load->helper('url');
		
		$data['title']="";
				
		$this->load->view('pages/template/header',$data);
		
		$this->load->view('pages/template/navAdmin',$data);
		$this->load->view('pages/template/content',$data);
		
		$this->load->view('pages/template/footer',$data);
		
		}
	
	function aboutus(){
			$this->load->helper('url');
				$data['title']="";	
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/navAdmin',$data);
		
		$this->load->view('pages/aboutus');
		
		$this->load->view('pages/template/footer');
		
		
		}
	
	
	function mylink(){
		$this->load->helper('url');
					$data['title']="";
			$this->load->view('pages/template/header',$data);
		
			$this->load->view('pages/template/nav',$data);
			$this->load->view('pages/mylink',$data);
		
			$this->load->view('pages/template/footer',$data);
		
		
		
		}
		
		function manageuser(){
			
				$this->load->helper('url');
						$data['title']="Manage Users";
				$this->load->view('pages/template/header',$data);
		
				$this->load->view('Admin/navAdminManageUser',$data);
			
		
			
		
		
		}
	}

?>