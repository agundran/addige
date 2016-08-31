<script>

window.onunload = function(){
  window.opener.location.reload();
};


</script>

<?php


    ini_set('memory_limit', '4000M');
    ini_set('max_execution_time', '180000');
	set_time_limit(180000);
	ini_set("display_errors", "on");
	
	
require_once("system/core/Common.php");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
	
     
	  
	//  ignore_user_abort(false);
	  
class Generatebillingbycust extends CI_Controller
{
	private $limit = 12;
 		
	function __construct()
 	{
		parent::__construct();
		$this->load->helper(array('form', 'url','file'));
	 	$this->load->model('generatebillingbycustmodel','',TRUE);
 		$this->is_logged_in();
 	}
	 
	 function is_logged_in()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!isset($is_logged_in) || $is_logged_in != true){
		echo 'you don\'t have permission to access this page.';
		 redirect(site_url('/pages/login'));
		die();
		}	
	} 
	 
	 
	function index(){
	
	
	if (empty($syscode)) $syscode =null;
	$syscode = $this->input->post('syscode');
	
	$data['action'] = site_url('generatebillingbycust/index/'.$syscode);
	

	$data['currentuser'] = $this->session->userdata('username');
	$myuser = $data['currentuser'];
	$astartdate = $this->generatebillingbycustmodel->get_billingstartdate($myuser);
	$aenddate = $this->generatebillingbycustmodel->get_billingenddate($myuser);
	$cm = $this->generatebillingbycustmodel->get_currentmonth($myuser);
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
	

    //Put the value in an array to pass to the view. 
   // $data['sc'] = "9129";
	$data['syscode']= $syscode;

    //Pass to the value to the view. Access it as '$search' in the view.
    //$this->load->view("about", $view_data);
	
	
	
	$data['title1'] = 'Current Billing Period is: '.$cm." ".'('.$StartDate." "."to"." ".$EndDate.")";		
	$data['setbm'] = anchor_popup('BillingSetUpdate/index/','(change)',array('class'=>'changebillingmonth'),$upd);
	
	if ($syscode == null){
		$data['generatebill'] ="";
		}else{
	
	   //$data['createinvoice'] = anchor('legacyinvoicing/index/'.$syscode,'&#10152  Generate ',array('class'=>'createinvoice'));
	   $data['generatebill'] = anchor_popup((array('generatebillingbycust/generatebill/'.$syscode,$StartDate,$EndDate,$cm)),'&#10152  Generate ',array('class'=>'generatebill'),$upd);
	   
		}
	
	 
	// redirect('legacyinvoicing/index/'.$syscode,'Refresh');
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header2');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/generatebillingbycust_view', $data);

	 }
	 

	function generatebill($Seq,$aStartDate,$aEndDate,$cm){
	
		$this->output->enable_profiler(TRUE);
		$currentuser = $this->session->userdata('username');
		
		//$aStartDate = $this->generatebillingbycustmodel->get_billingstartdate($currentuser);
		//$aEndDate = $this->generatebillingbycustmodel->get_billingenddate($currentuser);
		
		$customername = $this->generatebillingbycustmodel->get_customer_name($Seq);
		$month = $this->generatebillingbycustmodel->get_currentmonth($currentuser); 
		
		$filename = 'All.'.$aStartDate."for".substr((str_replace(' ','',$customername)),0,7).'.txt';	
		//$datab = "MONTH;".$cm.";".$aStartDate.";".$aEndDate.";".PHP_EOL;
		$datab = "MONTH;".$cm.";".$aStartDate.";".$aEndDate.";".PHP_EOL;
		echo nl2br($datab);
		$query = $this->generatebillingbycustmodel->filter_contractno($Seq,$aStartDate,$aEndDate);
		
		//$this->generatebillingbycustmodel->get_current();
	  
	  
	  write_file2('./downloads/'.$filename, $datab,'c');
		foreach($query->result() as $row){
             
		//  if ($this->generatebillingbycustmodel->get_detail_new($row->c1C,$aStartDate,$aEndDate) != null){	 
			 $data1 = 'CUST;'.$this->generatebillingbycustmodel->get_customers_data($row->c1Se);
		 	 echo nl2br($data1."\n");
			 $data2 = 'AGENCY;'.$this->generatebillingbycustmodel->get_agency_data($row->c1A);
			 echo nl2br($data2."\n");
			 $data3 = 'OPER;'.$this->generatebillingbycustmodel->get_oper_data($row->c1SN);
			 echo nl2br($data3."\n");
			 $data4 =  'CONTRACT;'.$this->generatebillingbycustmodel->get_contract_data($row->c1C,$aStartDate,$aEndDate);  echo nl2br($data4."\n");
			// $data5 = $this->generatebillingbycustmodel->get_detail_new1($row->c1C,$aStartDate,$aEndDate);
			$data5 = $this->generatebillingbycustmodel->get_detail_new($row->c1C,$aStartDate,$aEndDate);
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

