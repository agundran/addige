
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once APPPATH."third_party/PHPExcel.php"; 
 
 class Excel extends PHPExcel { 
    public function __construct() { 
        parent::__construct(); 
    } 
	 public function generate(array $fields, array $data, $fileName = 'excelDbDump') {
       $objPHPExcel = new PHPExcel();
       $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
       $objPHPExcel->setActiveSheetIndex(0);
       // Field names in the first row
       $col = 0;
       foreach ($fields as $field) {
           $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
           $col++;
       }
       // Fetching the table data
       $row = 2;
       foreach ($data as $data) {
           $col = 0;
           foreach ($fields as $field) {
               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
               $col++;
           }
           $row++;
       }
       $objPHPExcel->setActiveSheetIndex(0);
       $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
       // Sending headers to force the user to download the file
       header('Content-Type: application/vnd.ms-excel');
       header('Content-Disposition: attachment;filename="' . $fileName . '_' . date('d-m-y') . '.xls"');
       header('Cache-Control: max-age=0');
       $objWriter->save('php://output');
    }
 
    public function excelToArray($filePath, $header = true) {
        //Create excel reader after determining the file type
        $inputFileName = $filePath;
        /**  Identify the type of $inputFileName  * */
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  * */
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        /** Set read type to read cell data onl * */
        $objReader->setReadDataOnly(true);
        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel = $objReader->load($inputFileName);
        //Get worksheet and built array with first row as header
        $objWorksheet = $objPHPExcel->getActiveSheet();
 
        //excel with first row header, use header as key
        if ($header) {
            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();
            $headingsArray = $objWorksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
            $headingsArray = $headingsArray[1];
 
            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true);
                if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                    ++$r;
                    foreach ($headingsArray as $columnKey => $columnHeading) {
                        $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
                    }
                }
            }
        } else {
            //excel sheet with no header
            $namedDataArray = $objWorksheet->toArray(null, true, true, true);
        }
 
        return $namedDataArray;
    }
 
	
}