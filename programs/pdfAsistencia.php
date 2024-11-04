<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

$var_fechar= $_GET['dat'];
$dia = substr($fechar, 0, 2);
$mes   = substr($fechar, 3, 2);
$ano = substr($fechar, -4);
$pph=20*2;

$fechai = $ano . '-' . $mes . '-' . $dia;

require('../connections/cn_on.php');
require('../pdf/functionpdf.php');
define('FPDF_FONTPATH','../fonts/');


$fecha=date("Y-m-d");


$vlmSup = 5;
$vlmIzq = 50;
$vliLin = 4;
$pdf=new PDF('P');
$pdf->SetMargins(50,4,50);
$pdf->Open();
$pdf->AddPage();

$pdf->AddFont('arialn','B','arialn.php');
$pdf->AddFont('arialnb','B','arialnb.php');

$vlmSup += $vliLin+6;
$pdf->Image('../img/unap.jpg',30,11,31,30);
$pdf->Image('../img/cci.jpg', 195,11,31,30);

$pdf->SetFont('arial','B',12);
$pdf->SetXY($vlmIzq+14,$vlmSup+5);
$pdf->Cell(0,5,'UNIVERSISDAD NACIONAL DEL ALTIPLANO PUNO',0,1,'L');
$pdf->SetFont('arialnb','B',8);
$pdf->SetXY($vlmIzq+48,$vlmSup+10);
$pdf->Cell(0,6,'CENTRO DE CÓMPUTO E INFORMÁTICA',0,1,'L');
$pdf->SetFont('arialnb','B',10);
$pdf->SetXY($vlmIzq+65,$vlmSup+15);
$pdf->Cell(0,6,'PUNO-PERÚ',0,1,'L');
$pdf->SetXY($vlmIzq+55,$vlmSup+22);
$pdf->Cell(43,0,'',1,1,'C');

$vlmSup += $vliLin+1;
//$pdf->SetFont('arialnb','B',10);
//$pdf->SetXY($vlmIzq-10,$vlmSup+29);
//$pdf->Cell(0,5,'NOMBRE DEL DOCUMENTO:',0,1,'L');
$pdf->SetFont('arial','B',16);
$pdf->SetXY($vlmIzq+2,$vlmSup+29);
$pdf->Cell(0,5,'ASISTENCIA DE DOCENTES'.$var_fechai.' HASTA '.date("Y/m/d"),0,1,'L');
$vlmSup += $vliLin+4;

$pdf->SetFont('arial','B',10);
$pdf->SetXY($vlmIzq+2,$vlmSup+30);
$pdf->Cell(0,5,'Nº         :     01'.$var_num,0,1,'L');
$pdf->SetXY($vlmIzq+2,$vlmSup+36);
$pdf->Cell(0,5,'FECHA :     '.date("Y-m-d H:i:s"),0,1,'L');
$vlmSup += $vliLin+10;
$pdf->SetXY($vlmIzq-30,$vlmSup+30);
$pdf->Cell(210,0,'',1,1,'C');

$pdf->SetXY($vlmIzq,$vlmSup);
$pdf->SetFont('arialnb','B',8);
$vlmSup += $vliLin;
$pdf->SetXY($vlmIzq-25,$vlmSup+33);
$pdf->SetFillColor(205,205,205);
$pdf->SetTextColor(20); // color del texto
$pdf->Cell(6,5,'Nº',0,1,'L',true);
$pdf->SetXY($vlmIzq-18,$vlmSup+33);
//$pdf->Cell(13,5,'Nº PREST.',0,1,'L',TRUE);
//$pdf->SetXY($vlmIzq-11,$vlmSup);
//$pdf->Cell(17,5,'COD LECTOR',0,1,'L',TRUE);
//$pdf->SetXY($vlmIzq+7,$vlmSup);
$pdf->Cell(75,5,'APELLIDOS Y NOMBRES',0,1,'L',TRUE);
$pdf->SetXY($vlmIzq+58,$vlmSup+33);
//$pdf->Cell(15,5,'COD TEXTO',0,1,'L',TRUE);
//$pdf->SetXY($vlmIz+124,$vlmSup);
$pdf->Cell(71,5,'CURSO',0,1,'L',TRUE);
$pdf->SetXY($vlmIz+180,$vlmSup+33);
//$pdf->Cell(44,5,'AUTOR',0,1,'L',TRUE);
//$pdf->SetXY($vlmIzq+160,$vlmSup);
//$pdf->Cell(18,5,'F. PRESTAMO',0,1,'L',TRUE);
//$pdf->SetXY($vlmIzq+179,$vlmSup);
$pdf->Cell(35,5,'HORAS DE TRABAJO',0,1,'L',TRUE);
$pdf->SetXY($vlmIzq+270,$vlmSup+33);
//$pdf->Cell(25,5,'COD. PERSONAL',0,1,'L',TRUE);


$pdf->SetFont('arialn','B',8);
            $vlmSup +=3;
$pdf->MultiCell(0,6,'diana',0,1,'L',10);
$pdf->SetTextColor(100); // color del texto
$SQLquery = "SELECT * from tupa";
    $SQLresult = mysql_query($SQLquery, $link);
    $i = 0;
    $vlmIzq-=25;
    while($SQLrow = mysql_fetch_array($SQLresult)){

            $vlmSup += $vliLin+1;
            $pdf->SetXY($vlmIzq,$vlmSup+34);
            $pdf->Cell(8,3,($i+1));
            $pdf->SetXY($vlmIzq+5,$vlmSup+34);
            $pdf->Cell(35,3,$SQLrow[1].' '.$SQLrow[0].' '.$SQLrow[1],0,1,'L');
            $pdf->SetXY($vlmIzq+83,$vlmSup+34);
            $pdf->Cell(8,3,$SQLrow[2]);
            $pdf->SetXY($vlmIzq+155,$vlmSup+34);

            $i++;
    }
$pdf->SetXY($vlmIzq+50,$vlmSup);
$pdf->Cell(35,3, $var_paterno . ' ' . $var_materno . ', ' . $var_nombres,0,1,'L');
$pdf->SetFont('arialnb','B',10);
$vlmSup += $vliLin+1;

//----------------------------------------------------------------------------------------------------

$pdf->SetXY($vlmIzq,318);
$pdf->Cell(210,0,'',1,1,'C');
$pdf->SetFont('arialn','B',8);
$pdf->SetXY($vlmIzq,320);
$pdf->Cell(0,1,'CCI , '.date("F  D  Y").'                                                                       '.'Hora de Impresion: '.date("Y-m-d H:i:s").'',0,1,'L');

$pdf->Output();
?>
