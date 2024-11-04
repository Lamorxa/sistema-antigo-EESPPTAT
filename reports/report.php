<?php
require('mysql_reportz.php');
include "../connections/cn_on.php";    
$var_fechar= $_GET['dat'];
$var_desde = substr($var_fechar, 0, 10);
$var_hasta = substr($var_fechar, 10, 20 );
$pph=20*2;
$fechai = $ano . '-' . $mes . '-' . $dia;
$pdf = new PDF('P','pt','A4');
$fecha=date("m");
$vlmIzq = 30;
$lin = 8;

$pdf->SetFillColor(229, 229, 229); //Gris tenue de cada fila
$bandera = false;
$pdf->SetMargins(30,30,20);
$pdf->Open();
$pdf->AddPage();
$vlmSup += $lin+50;
$pdf->SetFont('arial','b',8);

$pdf->Cell(0,160,'REPORTE DE INGRESOS DESDE '.$var_desde.' HASTA '.$var_hasta,0,1,'C');
$pdf->SetXY($vlmIzq,$vlmSup+25);
$pdf->Cell(45,12,'CLASIF.',1,0,'C');
$pdf->Cell(55,12,'N° RECIBO',1,0,'C');
$pdf->Cell(110,12,'NOMBRES',1,0,'C'); 
$pdf->Cell(200,12,'TUPA',1,0,'C'); 
$pdf->Cell(30,12,'CANT.',1,0,'C'); 
$pdf->Cell(40,12,'PRECIO',1,0,'C'); 
$pdf->Cell(45,12,'TOTAL',1,0,'C'); 

$SQLquery = "SELECT c1.id as id1, c1.clase as class, c1.nombre as name, SUM(m.importe*m.cantidad) as suma FROM clase1 c1 inner join movimiento m where m.fecha BETWEEN '$var_desde' AND '$var_hasta'";
$SQLresult = mysql_query($SQLquery,$link);
$num=mysql_num_rows($SQLresult);    
$vlmIzq=30;
$vlmSup=95;
$pdf->SetFont('arial','',7);
while($SQLrow = mysql_fetch_array($SQLresult)){                                
    $pdf->SetXY($vlmIzq,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow['class'],1,'L');
    $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);           
    $pdf->MultiCell(365,9,$SQLrow['name'],1,'L');            
    $pdf->SetXY($vlmIzq=$vlmIzq+365,$vlmSup);
    $pdf->MultiCell(70,9,'Suma Total ('.$SQLrow['class'].'):',1,'R');
    $pdf->SetXY($vlmIzq=$vlmIzq+70,$vlmSup);
    $pdf->MultiCell(45,9,$SQLrow['suma'],1,'R');
    $id1=$SQLrow['id1'];
    $class=$SQLrow['class'];
    $SQLquery2 = "SELECT c2.id as id2,c2.clase as class2, c2.nombre as name2,SUM(m.importe*m.cantidad) as importe FROM movimiento m inner join tupa t on t.idtupa=m.tupa inner join clase6 c6 on t.idclasif=c6.id inner join clase2 c2 on c2.clase=SUBSTRING(c6.clase,1,3) where m.fecha BETWEEN '$var_desde' AND '$var_hasta'";
    $SQLresult2 = mysql_query($SQLquery2,$link);
    $num=mysql_num_rows($SQLresult2);    
    $vlmIzq=30;
    $vlmSup=$vlmSup+9;
    while($SQLrow2 = mysql_fetch_array($SQLresult2)){
        $pdf->SetXY($vlmIzq,$vlmSup);
        $pdf->MultiCell(45,9,$SQLrow2['class2'],1,'L');
        $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);           
        $pdf->MultiCell(365,9,$SQLrow2['name2'],1,'L');            
        $pdf->SetXY($vlmIzq=$vlmIzq+365,$vlmSup);
        $id2=$SQLrow2['id2'];
        $class2=$SQLrow2['class2'];
        
        /***************************/
        $SQLquery3 = "SELECT c3.id as id3,c3.clase as class3, c3.nombre as name3,SUM(m.importe*m.cantidad) as importe FROM movimiento m inner join tupa t on t.idtupa=m.tupa inner join clase6 c6 on t.idclasif=c6.id inner join clase3 c3 on c3.clase=SUBSTRING(c6.clase,1,5)  where m.fecha BETWEEN '$var_desde' AND '$var_hasta' GROUP BY C3.clase";
        $SQLresult3 = mysql_query($SQLquery3,$link);
        $num=mysql_num_rows($SQLresult3);            
        
        //$pdf->MultiCell(30,9,$SQLrow2['class2'],1,'L');
        //$pdf->SetXY($vlmIzq=$vlmIzq+30,$vlmSup);
        $pdf->MultiCell(70,9,'Suma ('.$SQLrow2['class2'].'): ',1,'R');
        $pdf->SetXY($vlmIzq=$vlmIzq+70,$vlmSup);
        $pdf->MultiCell(45,9,$SQLrow2['importe'],1,'R');        
        
        $vlmIzq=30;
        $vlmSup=$vlmSup+9;
        while($SQLrow3 = mysql_fetch_array($SQLresult3)){
            $pdf->SetXY($vlmIzq,$vlmSup);
            $pdf->MultiCell(45,9,$SQLrow3['class3'],1,'L');
            $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);           
            $pdf->MultiCell(365,9,$SQLrow3['name3'],1,'L');            
            $pdf->SetXY($vlmIzq=$vlmIzq+365,$vlmSup);
            
            $class3=$SQLrow3['class3'];
            /***************************/
            $SQLquery6 = "SELECT t.nombretupa as tupa,  SUM(m.importe*m.cantidad) as import,c6.clase as class6, c6.nombre as nombre6 "
                    . "FROM movimiento m inner join tupa t on m.tupa=t.idtupa inner join clase6 c6 on t.idclasif=c6.id "
                    . "where SUBSTRING(c6.clase,1,5)='$class3' and m.fecha BETWEEN '$var_desde' AND '$var_hasta'  GROUP BY C6.clase";
            $SQLresult6 = mysql_query($SQLquery6,$link);
            $num=mysql_num_rows($SQLresult6);            

                $pdf->MultiCell(70,9,'Suma ('.$SQLrow3['class3'].'): ',1,'R');
                $pdf->SetXY($vlmIzq=$vlmIzq+70,$vlmSup);
                $pdf->MultiCell(45,9,$SQLrow3['importe'],1,'R');


            $vlmIzq=30;
            $vlmSup=$vlmSup+9;
            while($SQLrow6 = mysql_fetch_array($SQLresult6)){
            $class6=$SQLrow6['class6'];    /***************/
            $pdf->SetXY($vlmIzq,$vlmSup);
            $pdf->MultiCell(45,9,$SQLrow6['class6'],1,'L');
            $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);           
            $pdf->MultiCell(365,9,$SQLrow6['nombre6'],1,'L');            
            $pdf->SetXY($vlmIzq=$vlmIzq+365,$vlmSup);
                $pdf->MultiCell(70,9,'Suma ('.$SQLrow6['class6'].'): ',1,'R');
                $pdf->SetXY($vlmIzq=$vlmIzq+70,$vlmSup);
                $pdf->MultiCell(45,9,$SQLrow6['import'],1,'R');

            
            /* ***************************/
                $SQLquery7 = "SELECT m.idmov, m.nrorecibo as recibo, p.nombres as name6,t.nombretupa as tupa, m.cantidad as cant, m.importe as import,c6.clase as class6, SUBSTRING(c6.clase,1,5) "
                    . "FROM movimiento m inner join persona p on m.idpersona=p.idpersona "
                    . "inner join tupa t on m.tupa=t.idtupa inner join clase6 c6 on t.idclasif=c6.id "
                    . "where c6.clase='$class6' and m.fecha BETWEEN '$var_desde' AND '$var_hasta'";
            $SQLresult7 = mysql_query($SQLquery7,$link);
            $num=mysql_num_rows($SQLresult7);         
            $vlmIzq=30;
            $vlmSup=$vlmSup+9;
            while($SQLrow7 = mysql_fetch_array($SQLresult7)){
 /*               
*/               $pdf->SetXY($vlmIzq,$vlmSup);
                $pdf->MultiCell(45,9,'',0,'L', $bandera );
                $pdf->SetXY($vlmIzq=$vlmIzq+45,$vlmSup);           
                $pdf->MultiCell(55,9,$SQLrow7['recibo'],0,'L', $bandera );
                $pdf->SetXY($vlmIzq=$vlmIzq+55,$vlmSup);           
                $pdf->MultiCell(110,9,$SQLrow7['name6'],0,'L', $bandera ); 
                $y1=$pdf->Gety();
                $pdf->SetXY($vlmIzq=$vlmIzq+110,$vlmSup);
                $pdf->MultiCell(200,9,$SQLrow7['tupa'],0,'L', $bandera );
                $y=$pdf->Gety();
                $pdf->SetXY($vlmIzq=$vlmIzq+200,$vlmSup);
                $pdf->MultiCell(30,9,$SQLrow7['cant'],0,'C', $bandera );
                $pdf->SetXY($vlmIzq=$vlmIzq+30,$vlmSup);
                $pdf->MultiCell(40,9,$SQLrow7['import'],0,'R', $bandera );
                $pdf->SetXY($vlmIzq=$vlmIzq+40,$vlmSup);
                $tot=$SQLrow7['import']*$SQLrow7['cant'];
                $pdf->MultiCell(45,9,$tot,0,'R', $bandera );
 //               $pdf->CellFitSpace(30,7, $y,1, 0 , 'L', $bandera );
                if($y1>$y) $y=$y1; 
                $vlmSup=$y;
                $vlmIzq=30; 
                //$pdf->Ln();//Salto de línea para generar otra fila
            $bandera = !$bandera;//Alterna el valor de la bandera
                }    
            }    
        }    
        /***************************/
    }    
}    
$pdf->Output();
?>
