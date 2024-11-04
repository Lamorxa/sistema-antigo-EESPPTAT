<?php session_start();  ?> <?php
require('mysql_report.php');
//$fechai = $ano . '-' . $mes . '-' . $dia;
require('../connections/cn_on.php');
//require('../programas/prubeolvidar.php');
//require('../pdf/functionpdf.php');
//define('FPDF_FONTPATH','../fonts/');
$pdf = new PDF('P','pt','A4');
$pdf->SetMargins(50,4,50);
$pdf->Open();
$pdf->AddPage();
$fecha=date("m");
$pdf->SetFont('courier','',11);
$sey=210;  $pdf->SetXY(30,$sey);
		$pdf->Cell(385,0,'        '."sadvfbghj",0,1,'L');

$pdf->Output();
?>
