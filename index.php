<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/funcoes/splitPDF.php';

$arquivoTotal 	= isset($_POST['listagem']) ? $_POST['listagem'] : 'ponto.pdf' ;
$end_directory 	= __DIR__."/conteudo/documentos/";
$pdfFile 		= __DIR__."/conteudo/documentos/$arquivoTotal";
$ret 			= chmod($pdfFile, 0777);
$arquivos 		= splitCartaoPontoByEmployeeCode($pdfFile, $end_directory);