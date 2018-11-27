<?php
require_once "Classes/PHPExcel.php";
require_once "Classes/PHPExcel/IOFactory.php";
$filename = dirname(__FILE__).'/myexcel.xlsx';
$io = PHPExcel_IOFactory::createReader('Excel2007');

$objPHPExcel = $io->load($filename);

$sheet = $objPHPExcel -> getSheet(0);
$highestRow = $sheet -> getHighestRow();
for($i=2;$i<=$highestRow;$i++)
{
    $data['1'] = $objPHPExcel -> getActiveSheet() -> getCell("A".$i)->getValue();
    $data['2']   = $objPHPExcel -> getActiveSheet() -> getCell("B".$i)->getValue();
    $data['3']    = $objPHPExcel -> getActiveSheet() -> getCell("C".$i)->getValue();
    $data['4']  = $objPHPExcel -> getActiveSheet() -> getCell("D".$i)->getValue();
    $data['5']      = $objPHPExcel -> getActiveSheet() -> getCell("E".$i)->getValue();
    $data['6']      = $objPHPExcel -> getActiveSheet() -> getCell("F".$i)->getValue();
    $data['7']      = $objPHPExcel -> getActiveSheet() -> getCell("G".$i)->getValue();
    $data['8']      = $objPHPExcel -> getActiveSheet() -> getCell("H".$i)->getValue();
    $data['9']      = $objPHPExcel -> getActiveSheet() -> getCell("I".$i)->getValue();
    $allData[] = $data;
}

print_r($allData);exit;
