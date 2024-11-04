<?php

require('mysql_reportz.php');
include "../connections/cn_on.php";    
$anio= $_GET['dat'];
$var_desde = substr($var_fechar, 0, 10);
$var_hasta = substr($var_fechar, 10, 20 );
$pph=20*2;
$fechai = $ano . '-' . $mes . '-' . $dia;
$pdf = new PDF('L','pt','A4');
$fecha=date("m");
$vlmIzq = 30;
$lin = 8;

$pdf->SetFillColor(229, 229, 229); //Gris tenue de cada fila
$bandera = false;
$pdf->SetMargins(30,30,20);
$pdf->Open();
$pdf->AddPage();
$vlmSup += $lin+50;
$pdf->SetFont('arial','b',7);

$pdf->Cell(0,160,'REPORTE DE INGRESOS ANUAL CORRESPONDIENTE AL AÑO '.$anio,0,1,'C');
$pdf->SetXY($vlmIzq,$vlmSup+25);
$pdf->Cell(45,12,'CLASIF.',1,0,'C');
$pdf->Cell(155,12,'DESCRIPCION',1,0,'C');
$pdf->Cell(45,12,'ENERO',1,0,'C'); 
$pdf->Cell(45,12,'FEBRERO',1,0,'C'); 
$pdf->Cell(45,12,'MARZO',1,0,'C'); 
$pdf->Cell(45,12,'ABRIL',1,0,'C'); 
$pdf->Cell(45,12,'MAYO',1,0,'C'); 
$pdf->Cell(45,12,'JUNIO',1,0,'C'); 
$pdf->Cell(45,12,'JULIO',1,0,'C'); 
$pdf->Cell(45,12,'AGOSTO',1,0,'C'); 
$pdf->Cell(45,12,'SETIEMBRE',1,0,'C'); 
$pdf->Cell(45,12,'OCTUBRE',1,0,'C'); 
$pdf->Cell(45,12,'NOVIEMBRE',1,0,'C'); 
$pdf->Cell(45,12,'DICIEMBRE',1,0,'C'); 
$pdf->Cell(45,12,'TOTAL',1,0,'C'); 

$vlmIzq=30;
$vlmSup=95;
$pdf->SetFont('arial','',7);

$SQLquery6 = "SELECT  c6.clase as class6, c6.nombre as nombre6 , MONTH(m.fecha) AS mes, SUM(IF(MONTH(m.Fecha)=1,m.importe*m.cantidad,0)) As 'enero'
, SUM(IF(MONTH(m.Fecha)=2,m.importe*m.cantidad,0)) As 'febrero'
, SUM(IF(MONTH(m.Fecha)=3,m.importe*m.cantidad,0)) As 'marzo'
, SUM(IF(MONTH(m.Fecha)=4,m.importe*m.cantidad,0)) As 'abril'
, SUM(IF(MONTH(m.Fecha)=5,m.importe*m.cantidad,0)) As 'mayo'
, SUM(IF(MONTH(m.Fecha)=6,m.importe*m.cantidad,0)) As 'junio'
, SUM(IF(MONTH(m.Fecha)=7,m.importe*m.cantidad,0)) As 'julio'
, SUM(IF(MONTH(m.Fecha)=8,m.importe*m.cantidad,0)) As 'agosto'
, SUM(IF(MONTH(m.Fecha)=9,m.importe*m.cantidad,0)) As 'setiembre'
, SUM(IF(MONTH(m.Fecha)=10,m.importe*m.cantidad,0)) As 'octubre'
, SUM(IF(MONTH(m.Fecha)=11,m.importe*m.cantidad,0)) As 'noviembre'
, SUM(IF(MONTH(m.Fecha)=12,m.importe*m.cantidad,0)) As 'diciembre'
, SUM(m.importe*m.cantidad) As 'TOTAL'
 FROM movimiento m inner join tupa t on m.tupa=t.idtupa inner join clase6 c6 on t.idclasif=c6.id
 WHERE m.estado=1 and YEAR(m.fecha)=:anio GROUP BY C6.clase ";
$SQLresult6 = $db->prepare($SQLquery6);
$SQLresult6  -> execute([":anio"=>$anio]);  
$SQLquery = "SELECT  SUM(IF(MONTH(m.Fecha)=1,m.importe*m.cantidad,0)) As 'enero'
, SUM(IF(MONTH(m.Fecha)=2,m.importe*m.cantidad,0)) As 'febrero'
, SUM(IF(MONTH(m.Fecha)=3,m.importe*m.cantidad,0)) As 'marzo'
, SUM(IF(MONTH(m.Fecha)=4,m.importe*m.cantidad,0)) As 'abril'
, SUM(IF(MONTH(m.Fecha)=5,m.importe*m.cantidad,0)) As 'mayo'
, SUM(IF(MONTH(m.Fecha)=6,m.importe*m.cantidad,0)) As 'junio'
, SUM(IF(MONTH(m.Fecha)=7,m.importe*m.cantidad,0)) As 'julio'
, SUM(IF(MONTH(m.Fecha)=8,m.importe*m.cantidad,0)) As 'agosto'
, SUM(IF(MONTH(m.Fecha)=9,m.importe*m.cantidad,0)) As 'setiembre'
, SUM(IF(MONTH(m.Fecha)=10,m.importe*m.cantidad,0)) As 'octubre'
, SUM(IF(MONTH(m.Fecha)=11,m.importe*m.cantidad,0)) As 'noviembre'
, SUM(IF(MONTH(m.Fecha)=12,m.importe*m.cantidad,0)) As 'diciembre'
, SUM(m.importe*m.cantidad) As 'TOTAL'
 FROM movimiento m inner join tupa t on m.tupa=t.idtupa inner join clase6 c6 on t.idclasif=c6.id
 WHERE m.estado=1 and YEAR(m.fecha)='$anio'";
        //. "SELECT t.nombretupa as tupa,  SUM(m.importe*m.cantidad) as import,c6.clase as class6, c6.nombre as nombre6 "
          //  . "FROM movimiento m inner join tupa t on m.tupa=t.idtupa inner join clase6 c6 on t.idclasif=c6.id "
            //. "where YEAR(m.fecha)='2020'  GROUP BY C6.clase";
$SQLresult = $db->prepare($SQLquery);
$SQLresult -> execute([":anio"=>$anio]); 
$SQLrow = $SQLresult->fetch(PDO::FETCH_ASSOC);

while($SQLrow6 =  $SQLresult6->fetch(PDO::FETCH_ASSOC)){
    $class6=$SQLrow6['class6'];    /***************/
    $pdf->SetXY($vlmIzq,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['class6'],1,'L');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);           
    $pdf->MultiCell(155,9,$SQLrow6['nombre6'],1,'L');            
                $y=$pdf->Gety();
    
    $pdf->SetXY($vlmIzq=$vlmIzq+155,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['enero'],1,'R');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['febrero'],1,'R');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['marzo'],1,'R');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['abril'],1,'R');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['mayo'],1,'R');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['junio'],1,'R');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['julio'],1,'R');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['agosto'],1,'R');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['setiembre'],1,'R');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['octubre'],1,'R');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['noviembre'],1,'R');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['diciembre'],1,'R');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow6['TOTAL'],1,'R');
    $vlmIzq=30;
    $vlmSup=$y;
}    
$pdf->Cell(200,12,'TOTAL INGRESOS',1,0,'C');
$pdf->Cell(45,12,$SQLrow['enero'],1,0,'R'); 
$pdf->Cell(45,12,$SQLrow['febrero'],1,0,'R'); 
$pdf->Cell(45,12,$SQLrow['marzo'],1,0,'R'); 
$pdf->Cell(45,12,$SQLrow['abril'],1,0,'R'); 
$pdf->Cell(45,12,$SQLrow['mayo'],1,0,'R'); 
$pdf->Cell(45,12,$SQLrow['junio'],1,0,'R'); 
$pdf->Cell(45,12,$SQLrow['julio'],1,0,'R'); 
$pdf->Cell(45,12,$SQLrow['agosto'],1,0,'R'); 
$pdf->Cell(45,12,$SQLrow['setiembre'],1,0,'R'); 
$pdf->Cell(45,12,$SQLrow['octubre'],1,0,'R'); 
$pdf->Cell(45,12,$SQLrow['noviembre'],1,0,'R'); 
$pdf->Cell(45,12,$SQLrow['diciembre'],1,0,'R'); 
$pdf->Cell(45,12,$SQLrow['TOTAL'],1,0,'R'); 

$pdf->Output();
?>
