
<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");


class Detailentryencode extends CI_Controller
{
 	
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('detailentryencodemodel','',TRUE);
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
	 
	 	 
	function index($contractno, $siteoperator) 
	{
		
	$mycontract = $contractno;
	$mysite =  $siteoperator;	
	$data['title'] = 'Order Entry';
	$data['subtitle'] = $mycontract;
	$data['mycontract']= $mycontract;
    
	//$data['subtitle'] = 'Contract Details';
    $data['message'] = '';
	$data['action'] = site_url('detailentryencode/index/'.$mycontract."/".$mysite);
	 $data['Users'] = (array)$this->detailentryencodemodel->get_by_id($contractno)->row();
	 //http://localhost/addige_alpha/index.php/detailentryencode/index/DAL0713110092/291223
	 $data['mysiteoperator']=$siteoperator;
	 
	$atts = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
	 		


    $this->_set_rules();
	if ($this->form_validation->run() === FALSE){
	
			//$data['Users']['NetworkName']='';
			$data['Users']['StartDate']='';
			$data['Users']['EndDate']='';
			$data['Users']['StartDay']='';
			$data['Users']['EndDay']='';
			$data['Users']['StartTime']='';
			
			$data['Users']['dmo']='';
			$data['Users']['dtu']='';
			$data['Users']['dwe']='';
			$data['Users']['dth']='';
			$data['Users']['dfr']='';
			$data['Users']['dsa']='';
			$data['Users']['dsu']='';
			
			$data['Users']['gdmo']='';
			$data['Users']['gdtu']='';
			$data['Users']['gdwe']='';
			$data['Users']['gdth']='';
			$data['Users']['gdfr']='';
			$data['Users']['gdsa']='';
			$data['Users']['gdsu']='';
			
			
	 	    $data['Users']['Bonus']='';
			$data['Users']['UnitPrice']='';
			$data['Users']['Priority']='';
			$data['Users']['ProgramName']='';
			
			
			/*if ($this->uri->segment(3)=='delete_success')
			$data['message'] = 'The Data was successfully deleted';
		else if ($this->uri->segment(3)=='add_success')
			$data['message'] = 'The Data has been successfully added';
		else if ($this->uri->segment(3)=='update_success')
			$data['message'] = 'The Data has been successfully updated';
		else
		$data['message'] = '';*/
			
	
					// set common properties
			//$data['Users'] = 'SiteName';
			
			$this->load->view('pages/template/header2');
			//$this->load->view('pages/template/nav');
			$this->load->view('pages/detailentryencode_view', $data);
			//$this->load->view('pages/template/footer');

	}else{
			//$SiteName= $siteoperator;
			$ContractNo = 	$mycontract;
			$NetworkName = $this->input->post('NetworkName');
			$StartDate = $this->input->post('StartDate');
			$EndDate = $this->input->post('EndDate');
			$StartDay = $this->input->post('StartDay');
			$EndDay = $this->input->post('EndDay');
			$TimeOn = $this->input->post('StartTime');
			$TimeOff = $this->input->post('EndTime');
			
			
			
			$dmo = $this->input->post('dmo');
			if ($dmo =="") { $dmo = 0;}
			$dtu = $this->input->post('dtu');
			if ($dtu =="") { $dtu = 0;}
			$dwe = $this->input->post('dwe');
			if ($dwe =="") { $dwe = 0;}
			$dth = $this->input->post('dth');
			if ($dth =="") { $dth = 0;}
			$dfr = $this->input->post('dfr');
			if ($dfr =="") { $dfr = 0;}
			$dsa = $this->input->post('dsa');
			if ($dsa =="") { $dsa = 0;}
			$dsu = $this->input->post('dsu');
			if ($dsu =="") { $dsu = 0;}
			
			$gdmo= $this->input->post('gdmo');
			$gdtu = $this->input->post('gdtu');
			$gdwe = $this->input->post('gdwe');
			$gdth = $this->input->post('gdth');
			$gdfr = $this->input->post('gdfr');
			$gdsa = $this->input->post('gdsa');
			$gdsu = $this->input->post('gdsu');
			
			$Distribution = $this->detailentryencodemodel->GetDistributionString($dmo,$dtu,$dwe,$dth,$dfr,$dsa,$dsu);
			//$totalDistribution = $this->detailentryencodemodel->AddDistribution($dmo,$dtu,$dwe,$dth,$dfr,$dsa,$dsu);
			
			
			
			$MakeGoodDays = $this->detailentryencodemodel->GetMakeGoodDays($gdmo,$gdtu,$gdwe,$gdth,$gdfr,$gdsa,$gdsu);
			
			
			//$Bonus = $this->input->post('Bonus');
			$Bonus = 0 ;
			
			$iUnitPrice = $this->input->post('UnitPrice');
			$UnitPrice  = $iUnitPrice * 100;
			
			$Priority= $this->input->post('Priority');
			$ProgramName= $this->input->post('ProgramName');
			
			if ($ProgramName == ""){
				   $ProgramName = "Various";
				}
			
			///Programname UPPERCASE
			$PNupper = strtoupper($ProgramName);
			
			
			

			$iValue = $this->detailentryencodemodel->CalculateLineValue($dmo,$dtu,$dwe,$dth,$dfr,$dsa,$dsu,$iUnitPrice,$StartDate,$EndDate,$StartDay,$EndDay);
           
		    //$Value = number_format((($totalDistribution * $UnitPrice)/100),2);
			$Value  = number_format($iValue,2);
			$nWeeks = $this->detailentryencodemodel->GetContractWeeks($StartDate,$EndDate);
			//$nWeeks = 1;
			
			
			$id = $this->detailentryencodemodel->create_networksched($ContractNo,$NetworkName,$StartDate,$EndDate, $TimeOn, $TimeOff, $Distribution, $MakeGoodDays, $UnitPrice, $Priority, $PNupper, $Value, $nWeeks);
			
						
		//$this->validation->id = $id;

		//redirect('pendingcontracts/index/'.$offset=0,$siteoperator,$order_type='asc', $contractno,'Refresh');
		
		
		$message = "Schedule entry for Contract #".$ContractNo." created";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
				 window.opener.location.reload();
				window.close ();
        		</script>';
   			 }

		//return "<a href='javascript:void(0);' onclick=\"window.open('".$site_url."', '_blank', '"._parse_attributes($atts, TRUE)."');\"$attributes>".$title."</a>";
		
		}





			}

 function _set_rules(){
		
		$this->form_validation->set_rules('NetworkName', 'NetworkName', 'required');
		$this->form_validation->set_rules('StartDate', 'StartDate', 'required');
		
	    //$this->form_validation->set_rules('Operator', 'operator');
		//$this->form_validation->set_rules('Username', 'Username', 'required|min_length[4]|max_length[20]|is_unique[users.Username]');
		//$this->form_validation->set_rules('Password', 'Password', 'trim|min_length[4]|max_length[32]');
		//$this->form_validation->set_rules('Email', 'Email Address', 'trim|valid_email');
			
	 	}


function update($line,$siteoperator){
	 
// set common properties
	 	$data['title'] = 'Update Schedule #'.$line;
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules();
	 	$data['action'] = ('detailentryencode/update/'.$line.'/'.$siteoperator);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
	 	$data['Users'] = (array)$this->detailentryencodemodel->get_by_id($line)->row();
		
		//$data['subtitle'] = $data['Users']['Distribution'];
		
		$varDis = 	$data['Users']['Distribution'];
		
		$var1 = (string)$varDis;
		
		//$xDist = str_replace("-", "", $var1);
		$pieces = explode("-", $var1);
		 // $aDist = str_split($xDist,7);
		
		//$SampleArr = $aDist[0];
		$data['mon'] = $pieces[0];
		$data['tue'] = $pieces[1];
		$data['wed'] = $pieces[2];
		$data['thurs'] = $pieces[3];
		$data['fri'] = $pieces[4];
		$data['sat'] = $pieces[5];
		$data['sun'] = $pieces[6];
		//$data['Userss'] = $this->detailentryencodemodel->get_by_distribution($line)->row();
	 	$data['subtitle'] = $line;
		
		//$splitDis = $data['Userss'];
		
		//$splitDistribution = $this->detailentryencodemodel->splitDistributionString($splitDis);
		
		//$data['distri']  = $splitDistribution;
		
	 	 
		$data['mysiteoperator']=$siteoperator;
		//$data['mycontract']= $line;
		


	}else{
			//$SiteName= $siteoperator;
			$ContractNo = 	$line;
			$NetworkName = $this->input->post('NetworkName');
			$StartDate = $this->input->post('StartDate');
			$EndDate = $this->input->post('EndDate');
			//$StartDay = $this->input->post('StartDay');
			//$EndDay = $this->input->post('EndDay');
			
			$TimeOn = $this->input->post('StartTime');
			$TimeOff = $this->input->post('EndTime');
			
			
			
			$dmo = $this->input->post('dmo');
			if ($dmo =="") { $dmo = 0;}
			$dtu = $this->input->post('dtu');
			if ($dtu =="") { $dtu = 0;}
			$dwe = $this->input->post('dwe');
			if ($dwe =="") { $dwe = 0;}
			$dth = $this->input->post('dth');
			if ($dth =="") { $dth = 0;}
			$dfr = $this->input->post('dfr');
			if ($dfr =="") { $dfr = 0;}
			$dsa = $this->input->post('dsa');
			if ($dsa =="") { $dsa = 0;}
			$dsu = $this->input->post('dsu');
			if ($dsu =="") { $dsu = 0;}
			
			$gdmo= $this->input->post('gdmo');
			$gdtu = $this->input->post('gdtu');
			$gdwe = $this->input->post('gdwe');
			$gdth = $this->input->post('gdth');
			$gdfr = $this->input->post('gdfr');
			$gdsa = $this->input->post('gdsa');
			$gdsu = $this->input->post('gdsu');
			
			$Distribution = $this->detailentryencodemodel->GetDistributionString($dmo,$dtu,$dwe,$dth,$dfr,$dsa,$dsu);
				
			$MakeGoodDays = $this->detailentryencodemodel->GetMakeGoodDays($gdmo,$gdtu,$gdwe,$gdth,$gdfr,$gdsa,$gdsu);
			
			//$Bonus = $this->input->post('Bonus');
			
			//$UnitPrice = $this->input->post('UnitPrice');
			$iUnitPrice = $this->input->post('UnitPrice');
			$UnitPrice  = $iUnitPrice * 100;
			
			$Priority= $this->input->post('Priority');
			$ProgramName= $this->input->post('ProgramName');
		
					if ($ProgramName == ""){
				   $ProgramName = "Various";
				}
			
			///Programname UPPERCASE
			$PNupper = strtoupper($ProgramName);
			
			//CODE WITH STARTDAY AND END DAY ACCORDING TO BOSS REMOVE STARTDAY AND END DAY
			//UPDATED BY: REYNAN
			//$Value = $this->detailentryencodemodel->CalculateLineValue($dmo,$dtu,$dwe,$dth,$dfr,$dsa,$dsu,$UnitPrice,$StartDate,$EndDate,$StartDay,$EndDay);
			
			//WITHOUT STARTDAY & ENDDAY
			//$iValue = $this->detailentryencodemodel->CalculateLineValue($dmo,$dtu,$dwe,$dth,$dfr,$dsa,$dsu,$iUnitPrice,$StartDate,$EndDate);
			
				$iValue = $this->detailentryencodemodel->CalculateLineValue($dmo,$dtu,$dwe,$dth,$dfr,$dsa,$dsu,$iUnitPrice,$StartDate,$EndDate);

				$Value  = number_format($iValue,2);
				$nWeeks = $this->detailentryencodemodel->GetContractWeeks($StartDate,$EndDate);
			
			//CODE WITH STARTDAY AND END DAY ACCORDING TO BOSS REMOVE STARTDAY AND END DAY
			//UPDATED BY: REYNAN
			
			//$id = $this->detailentryencodemodel->create_networksched($ContractNo,$NetworkName,$StartDate,$EndDate, $StartDay, $EndDay, $TimeOn, $TimeOff, $Distribution, $MakeGoodDays, $Bonus, $UnitPrice, $Priority, $ProgramName, $Value, $nWeeks);
			
			//WITHOUT STARTDATE & ENDDAY
			//$id = $this->detailentryencodemodel->create_networksched($ContractNo,$NetworkName,$StartDate,$EndDate, $TimeOn, $TimeOff, $Distribution, $MakeGoodDays, $UnitPrice, $Priority, $ProgramName, $Value, $nWeeks);
					
		
			
			
			
			
		//$this->validation->id = $id;

		//redirect('pendingcontracts/index/'.$offset=0,$siteoperator,$order_type='asc', $contractno,'Refresh');
		
		
		
		$id = $ContractNo;
				    	
		
			$myedit = array(
	 				'Network' => $NetworkName,
					'StartDate' => $StartDate,
					'EndDate' => $EndDate,
					'TimeOn'=>$TimeOn,
					'TimeOff' =>$TimeOff,
					'Distribution' =>$Distribution,
					'MakeGoodDays' =>$MakeGoodDays,
					'UnitPrice' =>$UnitPrice,
					'Priority' =>$Priority,
					'ProgramName' =>$PNupper,
					'nWeeks' =>$nWeeks,
					'Value' =>$Value
				 	
					
					);
	 		
			
		//var_dump($User);
	 	$this->detailentryencodemodel->update($id,$myedit);
		
		$message = "Schedule entry for Contract #".$ContractNo." updated successfully";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		
				 window.opener.location.reload();
				window.close ();
        		</script>';
   			 }

		//return "<a href='javascript:void(0);' onclick=\"window.open('".$site_url."', '_blank', '"._parse_attributes($atts, TRUE)."');\"$attributes>".$title."</a>";
		
		}
		
		// load view
	 		$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header2');
			//$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/detailentryencodeedit_view', $data);


	}


}
?>

