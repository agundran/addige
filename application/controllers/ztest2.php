<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("system/core/Common.php");

	
class Ztest2 extends CI_Controller{	
	
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
	
	// load view
	$data['Role']=$this->session->userdata('role');
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav', $data);
		$this->load->view('pages/ztest2_view', $data);
		$this->load->view('pages/template/footer');
	 }
	 


	
	
function excel()
    {			$this->load->library('PHPExcel');
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle('Operator List');
                //set cell A1 content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', 'Short Name');
                
				 $this->excel->getActiveSheet()->setCellValue('A4', 'Short Name');
                $this->excel->getActiveSheet()->setCellValue('B4', 'FTP');
                $this->excel->getActiveSheet()->setCellValue('C4', 'Address');
				$this->excel->getActiveSheet()->setCellValue('D4', 'City');
				
                //merge cell A1 until C1
                $this->excel->getActiveSheet()->mergeCells('A1:C1');
                //set aligment to center for that merged cell (A1 to C1)
                $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //make the font become bold
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
                $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       for($col = ord('A'); $col <= ord('C'); $col++){
                //set column dimension
                $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
                $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                 
                $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
		$offset = 0;
		$filter="";
		$order_column ='ShortName';
		$order_type = 'asc';
		
		
		
                //retrive contries table data
                $rs =  $this->ztestmodel->get_paged_list($this->limit, $offset, $order_column, $order_type, $filter)->result();
	 
               
			    $exceldata="";
        foreach ($rs->result_array() as $row){
                $exceldata[] = $row;
        
		
		
		
		}
                //Fill data 
                $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
                 
                $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 $this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				 
                $filename='PHPExcelDemo.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
 
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                //force user to download the Excel file without writing it to server's HD
                $objWriter->save('php://output');
                 
    }
	

	
}

?>