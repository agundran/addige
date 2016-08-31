<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

    //  ini_set('memory_limit', '-1'); 
	//  ini_set ('max_execution_time', 10000);
	
class Generatebilling extends CI_Controller{	
			
	function __construct()
 	{
		parent::__construct();
		$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url','file'));
		
	 	$this->load->model('generatebillingmodel','',TRUE);
 		$this->is_logged_in();
 	}
	 
	function is_logged_in()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!isset($is_logged_in) || $is_logged_in != true){
		echo 'you don\'t have permission to access this page.';
		 redirect('pages/login');
		die();
		}	
	} 
	 
	function index()
	{
	if (empty($offset)) $offset = 0;
	if (empty($order_column)) $order_column = 'Seq';
	if (empty($order_type)) $order_type = 'asc';
	
	
	
	$data['currentuser'] = $this->session->userdata('username');
	$myuser = $data['currentuser'];
	
	$astartdate = $this->generatebillingmodel->get_billingstartdate($myuser);
	$aenddate = $this->generatebillingmodel->get_billingenddate($myuser);
	$cm = $this->generatebillingmodel->get_currentmonth($myuser);
	$StartDate = date('Y-m-d',strtotime($astartdate));
	$EndDate = date('Y-m-d',strtotime($aenddate));
	 $upd = 
	 array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
	
	$data['title1'] = 'Current Billing Period is: '.$cm." ".'('.$StartDate." "."to"." ".$EndDate.")";		
	$data['setbm'] = anchor_popup('BillingSetUpdate/index/','(change)',array('class'=>'changebillingmonth'),$upd);
		
   $data['generatebill'] = anchor_popup((array('generatebilling/generatebill/'.$StartDate,$EndDate,$cm)),'&#10152  Generate ',array('class'=>'generatebill'),$upd);
	
	
	//$data['filewrite'] =anchor(array('/generatebilling/writefile/'.$aStartDate,$aEndDate),'Here',array('class'=>'export'));
	$data['title'] = 'Generate Electronic Billing'; 
	//$data['title1'] = 'From '.$aStartDate.' to '.$aEndDate;
	//$data['sc'] = $syscode;
	 
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/generatebilling_view', $data);
		$this->load->view('pages/template/footer');
		
	 }
	
 function generatebill($aStartDate,$aEndDate,$cm){
	
		$this->output->enable_profiler(TRUE);
		$currentuser = $this->session->userdata('username');
		
		//$aStartDate = $this->generatebillingbycustmodel->get_billingstartdate($currentuser);
		//$aEndDate = $this->generatebillingbycustmodel->get_billingenddate($currentuser);
		
		//$customername = $this->generatebillingmodel->get_customer_name($Seq);
		$month = $this->generatebillingmodel->get_currentmonth($currentuser); 
		
		$filename = 'All.'.$aStartDate.'.txt';	
		
		//$datab = "MONTH;".$cm.";".$aStartDate.";".$aEndDate.";".PHP_EOL;
		$datab = "MONTH;".$cm.";".$aStartDate.";".$aEndDate.";".PHP_EOL;
		echo nl2br($datab);
		$query = $this->generatebillingmodel->filter_contractno($aStartDate,$aEndDate);
		
		//$this->generatebillingbycustmodel->get_current();
	  
	  
	  write_file2('./downloads/'.$filename, $datab,'c');
		foreach($query->result() as $row){
             
		//  if ($this->generatebillingbycustmodel->get_detail_new($row->c1C,$aStartDate,$aEndDate) != null){	 
			 $data1 = 'CUST;'.$this->generatebillingmodel->get_customers_data($row->c1Se);
		 	 echo nl2br($data1."\n");
			 $data2 = 'AGENCY;'.$this->generatebillingmodel->get_agency_data($row->c1A);
			 echo nl2br($data2."\n");
			 $data3 = 'OPER;'.$this->generatebillingmodel->get_oper_data($row->c1SN);
			 echo nl2br($data3."\n");
			 $data4 =  'CONTRACT;'.$this->generatebillingmodel->get_contract_data($row->c1C,$aStartDate,$aEndDate);  echo nl2br($data4."\n");
			// $data5 = $this->generatebillingbycustmodel->get_detail_new1($row->c1C,$aStartDate,$aEndDate);
			$data5 = $this->generatebillingmodel->get_detail_new($row->c1C,$aStartDate,$aEndDate);
			 echo nl2br($data5);
			$mydata = $data1.PHP_EOL.$data2.PHP_EOL.$data3.PHP_EOL.$data4.PHP_EOL.$data5;
			 
			//echo "mem used: ". number_format(memory_get_peak_usage()/1000000,2). '  MB' ."<br />"; 
			 	
			write_file2('./downloads/'.$filename, $mydata,'a');
			
		//  }
			//echo "mem used: ". number_format(memory_get_peak_usage()/1000000,2). '  MB'; 
			
			$mydata = null;
			
			
		}
		
		//echo phpinfo();
		
		//("."mem used: ". number_format(memory_get_peak_usage()/1000000,2). '  MB' .")";
		
		$message = $filename."  Billing file successful generated";
			echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           	   
       		   </script>';
		//$this->output->enable_profiler(FALSE);	
		//window.close ();
	 // $mydata = $datab.$data1.$data2.$data3.$data4.$data5;
			
	//	$forprintdata = $mydata;
				
		/* if ( ! write_file('./downloads/'.$filename, $forprintdata))
    		{
           $message = "file export error!";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           	window.close ();
       		</script>';
							//echo "<br />";
//			  //echo "mem used: ". number_format(memory_get_peak_usage()/1000000,2). '  MB';
	 		}
		 			return ;		 
   		}
   			else
    		{
            $message = $filename." file successful exported";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
         	window.close ();
        		</script>';
   			 }
    		}
//		
		*/
      }
	 
	}
	
		
	
	
	

	


?>