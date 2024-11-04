<?php
require('mysql_reportb.php');
$nro= $_GET['nro'];
$var_fechar= date("m");
$var_anio = substr($var_fechar, 0, 4);
$var_mes = date("M");
$pph=20*2;
//$fechai = $ano . '-' . $mes . '-' . $dia;
require('../connections/cn_on.php');
require('../programas/prubeolvidar.php');
//require('../pdf/functionpdf.php');
//define('FPDF_FONTPATH','../fonts/');
$SQLquerys = "select DATE_FORMAT(v.fecha, '%d  %l  %y'), c.nombres, c.direccion, IF(c.idDocumento=1,'',c.doc), SUM(pr.cantidad*pr.precio),pro.acta  from venta v 
        inner join cliente c on c.idCliente=v.idcliente 
        inner join proforma pro on pro.idventa=v.idventa
	inner join proventa pr on pr.nro=v.nro where v.nro='$nro' GROUP BY v.nro";
    $SQLresults = mysql_query($SQLquerys,$link);
    $num=mysql_num_rows($SQLresults);    
    $SQLrows = mysql_fetch_array($SQLresults);
    $date = $SQLrows[0];
    $name = $SQLrows[1];
    $stotal = $SQLrows[4];
    $cta = $SQLrows[5];
    $saldo=$stotal-$cta;
    
$pdf = new PDF('P','pt','A6');
$fecha=date("m");
$seal=1;
$pdf->SetFont('Arial','',7);
$pdf->connect('localhost','root','d1a','dbecom&ser');
$attr = array('titleFontSize'=>10, 'name'=>$name,'date'=>$date,'nro'=>$nro,
    'stotal'=>$stotal,'cta'=>$cta,'saldo'=>$saldo);
$pdf->mysql_report("select pr.cantidad as Cant, p.descripcion as Descripcion, pr.precio as 'P.U.',"
        . " pr.cantidad*pr.precio as 'Total' from proventa pr inner join producto p on p.idProducto=pr.idProducto "
        . "where pr.nro=$nro",
        false,$attr);
$pdf->Output();
?>
