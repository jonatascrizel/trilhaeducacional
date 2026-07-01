<?php
//https://github.com/mk-j/PHP_XLSXWriter

include_once APPPATH . 'ThirdParty/PHP_XLSXWriter/xlsxwriter.class.php';

function gravaXLS($data, $filename = 'export.xlsx',$sheetheader=null) {

  //echo '<pre>';print_r($data);die;
  header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
  header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
  header('Content-Transfer-Encoding: binary');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');

  $writer = new XLSXWriter();
  $writer->setAuthor('Que não se dê por passado');
  if($sheetheader != ''){
  $writer->writeSheetHeader('planilha',$sheetheader);
  }
  foreach($data as $row)
    $writer->writeSheetRow('planilha', $row);
  $writer->writeToStdOut();
  //echo '#'.floor((memory_get_peak_usage())/1024/1024)."MB"."\n";
  exit(0);
}
