<?php
require('morepagestable.php');
require('conexion.php');
$var_fechar= $_GET['dat'];
$var_desde = substr($var_fechar, 0, 10);
$var_hasta = substr($var_fechar, 10, 20 );

function GenerateWord()
{
	// Get a random word
	$nb = rand(3,10);
	$w = '';
	for($i=1;$i<=$nb;$i++)
		$w .= chr(rand(ord('a'),ord('z')));
	return $w;
}

function GenerateSentence($words=500)
{
	// Get a random sentence
	$nb = rand(20,$words);
	$s = '';
	for($i=1;$i<=$nb;$i++)
		$s .= GenerateWord().' ';
	return substr($s,0,-1);
}

$pdf = new PDF('P','pt');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('arial','B',11);
$pdf->MultiCell(0,20,'REPORTE DE INGRESOS DESDE '.$var_desde.' HASTA '.$var_hasta,0,'C');
$pdf->SetFont('Arial','',7);
$pdf->tablewidths = array(45,40, 170, 200, 15, 35, 40);

$data1[] = array('CLASIF.','N°RECIB','NOMBRES','TUPA','#','PRECIO','TOTAL');

$pdf->morepagestable($data1,9,true);

$SQLquery = "SELECT c1.id as id1, c1.clase as class, c1.nombre as name, SUM(m.importe*m.cantidad) as suma FROM clase1 c1 inner join movimiento m where m.estado=1 and m.fecha BETWEEN '$var_desde' AND '$var_hasta'";
$resultado1 = $mysqli->query($SQLquery);
//$num=mysql_num_rows($SQLresult);    
while($row1 = $resultado1->fetch_assoc())
{
    $data2[] = array(utf8_decode($row1['class']),'',utf8_decode($row1['name']),'','','Total: ',utf8_decode($row1['suma']));

    $id1=$row1['id1'];
    $class=$row1['class'];
    $SQLquery2 = "SELECT c2.id as id2,c2.clase as class2, c2.nombre as name2,SUM(m.importe*m.cantidad) as importe FROM movimiento m inner join tupa t on t.idtupa=m.tupa inner join clase6 c6 on t.idclasif=c6.id inner join clase2 c2 on c2.clase=SUBSTRING(c6.clase,1,3) where m.estado=1 and m.fecha BETWEEN '$var_desde' AND '$var_hasta'";
    $resultado2 = $mysqli->query($SQLquery2);
    while($SQLrow2 = $resultado2->fetch_assoc()){
        $data2[] = array(utf8_decode($SQLrow2['class2']),'',utf8_decode($SQLrow2['name2']),'','','Total: ',utf8_decode($SQLrow2['importe']));
        $id2=$SQLrow2['id2'];
        $class2=$SQLrow2['class2'];
        
        /***************************/
        $SQLquery3 = "SELECT c3.id as id3,c3.clase as class3, c3.nombre as name3,SUM(m.importe*m.cantidad) as importe FROM movimiento m inner join tupa t on t.idtupa=m.tupa inner join clase6 c6 on t.idclasif=c6.id inner join clase3 c3 on c3.clase=SUBSTRING(c6.clase,1,5) where m.estado=1 and m.fecha BETWEEN '$var_desde' AND '$var_hasta' GROUP BY C3.clase";
        $resultado3 = $mysqli->query($SQLquery3);
        while($SQLrow3 = $resultado3->fetch_assoc()){
            $data2[] = array(utf8_decode($SQLrow3['class3']),'',utf8_decode($SQLrow3['name3']),'','','Total: ',utf8_decode($SQLrow3['importe']));
            $class3=$SQLrow3['class3'];
            
            $SQLquery6 = "SELECT t.nombretupa as tupa,  SUM(m.importe*m.cantidad) as import,c6.clase as class6, c6.nombre as nombre6 "
                    . "FROM movimiento m inner join tupa t on m.tupa=t.idtupa inner join clase6 c6 on t.idclasif=c6.id "
                    . "where m.estado=1 and SUBSTRING(c6.clase,1,5)='$class3' and m.fecha BETWEEN '$var_desde' AND '$var_hasta'  GROUP BY C6.clase";
            $resultado6 = $mysqli->query($SQLquery6);
            while($SQLrow6 = $resultado6->fetch_assoc()){
                $data2[] = array(utf8_decode($SQLrow6['class6']),'',utf8_decode($SQLrow6['nombre6']),'','','Total: ',utf8_decode($SQLrow6['import']));
                $class6=$SQLrow6['class6'];    /***************/
            
            $query = "SELECT m.idmov, m.nrorecibo as recibo, p.nombres as name6,t.nombretupa as tupa, m.cantidad as cant, m.importe as import,m.importe*m.cantidad as tot,c6.clase as class6, SUBSTRING(c6.clase,1,5) "
                        . "FROM movimiento m inner join persona p on m.idpersona=p.idpersona "
                        . "inner join tupa t on m.tupa=t.idtupa inner join clase6 c6 on t.idclasif=c6.id where m.estado=1 and c6.clase='$class6'  and m.fecha BETWEEN '$var_desde' AND '$var_hasta'";
            $resultado = $mysqli->query($query);
    
            while($row = $resultado->fetch_assoc())
            {
                $data2[] = array('',utf8_decode($row['recibo']),utf8_decode($row['name6']),utf8_decode($row['tupa']),utf8_decode($row['cant']),utf8_decode($row['import']),utf8_decode($row['tot']));
            }
}
}
}

$pdf->morepagestable($data2,9,false);
//$pdf->morepagestable($data);
}
/*for($i=0;$i<4;$i++) {
	$data[] = array('Example to build a table over more than one page','Example to build a table over more than one page','Example to build a table over more than one page','Example to build a table over more than one page','Example to build a table over more than one page','Example to build a table over more than one page');
}*/
$pdf->Output();
?>
