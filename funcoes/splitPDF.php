<?php
function splitPdfByEmployeeCode($pdfFile, $end_directory)
{
	$fpdi 				= new \setasign\Fpdi\Fpdi();
	$pdfParser 			= new \Smalot\PdfParser\Parser();
	$parseFile 			= $pdfParser->parseFile($pdfFile);
	$pagesPF  			= $parseFile->getPages();
	$return 			= [];
	$employees 			= [];

	for ($currentPage = 1; $currentPage <= count($pagesPF); $currentPage++)
	{
		$pageParsed 	= $pagesPF[$currentPage-1]; 
		$pageText 		= preg_replace('/(\s)/', '', $pageParsed->getText());
		$employeeCode 	= getEmployeeCode($pageText);

		$employees[$employeeCode][] = $currentPage;

		
		if(!is_null($employeeCode))
		{
			$new_pdf 	= new \setasign\Fpdi\Fpdi();

			$new_pdf->setSourceFile($pdfFile);

			$pageId 	= $new_pdf->importPage($currentPage);
			$size 		= $new_pdf->getTemplatesize($pageId);
			$new_pdf->AddPage($size['orientation'], $size);
			$new_pdf->useTemplate($pageId); 

			try
			{

				$employeeFile	= $employeeCode.'_'.count($employees[$employeeCode]).".pdf";
                //$employeeFile	= $employeeCode.".pdf";
				$return[]		= $employeeFile;
				$new_filename 	= $end_directory.$employeeFile;

				$new_pdf->Output($new_filename, "F");
			}
			catch (Exception $e)
			{
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		}
	}

	return $return;
}

function getEmployeeCode($pageText)
{
	$regex1 = '/((reg.)|(c(o|ó|Ó)d.)|(admiss(a|A|ã|Ã)o\d{4}\/))(\d{1,9})/i';

	preg_match($regex1, $pageText, $pdfSearch);

	if(count($pdfSearch) >= 3)
		return end($pdfSearch);
	else
		return null;
}

function splitCartaoPontoByEmployeeCode($pdfFile, $end_directory)
{
	$fpdi 				= new \setasign\Fpdi\Fpdi();
	$pdfParser 			= new \Smalot\PdfParser\Parser();
	$parseFile 			= $pdfParser->parseFile($pdfFile);
	$pagesPF  			= $parseFile->getPages();
	$return 			= [];
	$employees 			= [];

	for ($currentPage = 1; $currentPage <= count($pagesPF); $currentPage++)
	{
		$pageParsed 	= $pagesPF[$currentPage-1]; 
		$pageText 		= preg_replace('/(\s)/', '', $pageParsed->getText());
		$employeeCode 	= getCartaoPontoEmployeeCode($pageText);

		$employees[$employeeCode][] = $currentPage;

		
		if(!is_null($employeeCode))
		{
			$new_pdf 	= new \setasign\Fpdi\Fpdi();

			$new_pdf->setSourceFile($pdfFile);

			$pageId 	= $new_pdf->importPage($currentPage);
			$size 		= $new_pdf->getTemplatesize($pageId);
			$new_pdf->AddPage($size['orientation'], $size);
			$new_pdf->useTemplate($pageId); 

			try
			{

				$employeeFile	= $employeeCode.'_'.count($employees[$employeeCode]).".pdf";
                //$employeeFile	= $employeeCode.".pdf";
				$return[]		= $employeeFile;
				$new_filename 	= $end_directory.$employeeFile;

				$new_pdf->Output($new_filename, "F");
			}
			catch (Exception $e)
			{
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		}
	}

	return $return;
}

function getCartaoPontoEmployeeCode($pageText)
{
	$regex1 = '/((L|l)ocaliza(ç|Ç|c|C)(a|A|ã|Ã)o\:)(\d+)/i';

	preg_match($regex1, $pageText, $pdfSearch);

	if(count($pdfSearch) >= 3)
		return end($pdfSearch);
	else
		return null;	
}

?>
