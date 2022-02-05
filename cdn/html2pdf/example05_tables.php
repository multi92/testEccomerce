<?php

$file = file_get_contents('file.html');

$html = $file;

//==============================================================
//==============================================================
//==============================================================
include("mpdf.php");

$mpdf=new mPDF('c','A4','','',5,5,5,5,0,0); 

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,2);

$mpdf->Output('mpdf.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================


?>