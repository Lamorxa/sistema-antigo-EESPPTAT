<?php
require('morepagestable.php');
require('conexion.php');
$var_fechar= $_GET['dat'];
$var_desde = substr($var_fechar, 0, 7);
$var_hasta = substr($var_fechar, 7, 14 );


$pdf = new PDF('L','pt');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('arial','B',11);
$pdf->MultiCell(0,20,'REPORTE DE INGRESOS DESDE '.$var_desde.' HASTA '.$var_hasta,0,'C');
$pdf->SetFont('Arial','',7);
$pdf->tablewidths = array(25,40,40,40, 50, 400, 200);

$data1[] = array('Nro.','N°RECIB','FECHA','DETALLE','ESTADO','NOMBRES','TOTAL');

$pdf->morepagestable($data1,9,true);
$SQLquery5 = "select SUM(m.importe*m.cantidad) as importe from movimiento m, persona p, tupa t, clase6 c  where  m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id and m.estado=1 and m.nroRecibo BETWEEN '$var_desde' AND '$var_hasta'";
$resultado5 = $mysqli->query($SQLquery5);
mysqli_data_seek ($resultado5, 0);
$totall= mysqli_fetch_array($resultado5);
//$totall=0;    
$data0[] = array('','','','','TOTAL : ',$totall['importe']);      

$pdf->morepagestable($data0,9,true);
$SQLquery = "select m.idMov, m.nroRecibo, p.nombres AS nombres, m.tipo,m.cantidad, m.fecha, SUM(m.importe*m.cantidad) as importe, t.nombreTupa as tupas, m.concepto, c.clase as clasif,m.estado from movimiento m, persona p, tupa t, clase6 c  where  m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id and m.nroRecibo BETWEEN '$var_desde' AND '$var_hasta'  group by m.nroRecibo order by m.nroRecibo asc";
$resultado1 = $mysqli->query($SQLquery);

$i=1;
while($row1 = $resultado1->fetch_assoc())
{
    $recibo=$row1['nroRecibo'];
    $registross=''; 
    $total=$row1['importe'];
    $st=$row1['estado'];
    
    $SQLquerys = "select m.cantidad,m.importe, t.nombreTupa as tupas,m.concepto,m.fecha from movimiento m, tupa t where  m.tupa=t.idTupa and m.nroRecibo='$recibo' order by m.nroRecibo desc";
    $SQLresults = $mysqli->query($SQLquerys);
    while($SQLrows = $SQLresults->fetch_assoc()){
       $registross .= $SQLrows['tupas'].' | '.$SQLrows['concepto'].' | '.$SQLrows['importe'].' | '.$SQLrows['cantidad'].' | '.$SQLrows['importe']*$SQLrows['cantidad'];       
    }
    if($st==0)        $estado='ANULADO';
    ELSE         $estado='';
    $data2[] = array($i,$recibo, $estado,utf8_decode($row1['importe']),utf8_decode($row1['fecha']),$registross, utf8_decode($row1['nombres']));        
$i++;
}
$pdf->morepagestable($data2,9,false);
$pdf->Output();
?>
