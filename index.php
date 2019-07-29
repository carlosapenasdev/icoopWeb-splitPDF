<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/funcoes/splitPDF.php';

//$arquivoTotal 	= isset($_POST['listagem']) ? $_POST['listagem'] : 'Contracheques.pdf' ;
$arquivoTotal 	= isset($_POST['listagem']) ? $_POST['listagem'] : 'ponto.pdf' ;
$end_directory 	= __DIR__."/conteudo/documentos/ponto_";
$pdfFile 		= __DIR__."/conteudo/documentos/$arquivoTotal";
$ret 			= chmod($pdfFile, 0777);

//$arquivos 		= splitPdfbyText('((reg.)|(c(o|ó|Ó)d.)|(admiss(a|A|ã|Ã)o\d{4}\/))(\d{1,9})',$pdfFile, $end_directory);
$arquivos 		= splitPdfbyText('((L|l)ocaliza(ç|Ç|c|C)(a|A|ã|Ã)o\:)(\d+)',$pdfFile, $end_directory);

echo "<pre>";print_r($arquivos);echo "</pre>";