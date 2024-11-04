<?php
require('mysql_reporty.php');

$var_bol= $_GET['dat'];
$dominio = stristr ($var_bol, ",");
$num=strrpos ( $var_bol, ",");
$var_desde = substr($var_bol, 0, $num);
$var_hasta = substr($var_bol, $num+1);
$pph=20*2;

$fechai = $ano . '-' . $mes . '-' . $dia;

if($var_mes=='Enero'){$mesn=1;}
if($var_mes=='Febrero'){$mesn=2;}
if($var_mes=='Marzo'){$mesn=3;}
if($var_mes=='Abril'){$mesn=4;}
if($var_mes=='Mayo'){$mesn=5;}
if($var_mes=='Junio'){$mesn=6;}
if($var_mes=='Julio'){$mesn=7;}
if($var_mes=='Agosto'){$mesn=8;}
if($var_mes=='Setiembre'){$mesn=9;}
if($var_mes=='Octubre'){$mesn=10;}
if($var_mes=='Nobiembre'){$mesn=12;}
if($var_mes=='Diciembre'){$mesn=12;}
//require('../connections/cn_on.php');
//require('../pdf/functionpdf.php');
//define('FPDF_FONTPATH','../fonts/');


$pdf = new PDF('L','pt','A4');
$fecha=date("m");

$pdf->SetFont('Arial','',10);
$pdf->connect('localhost','root','','caja');
$attr = array('titleFontSize'=>18, 'titleText'=>'Resumen de Ingresos Percibidos desde '.$var_desde.' hasta '.$var_hasta);
$pdf->mysql_report("select IF( class IS NULL AND nombre IS NULL,'',IF(nombre IS NULL AND class IS NOT NULL, '',class))  as CODIGO,
        IFNULL(nombre,'') AS  CLASIFICADOR,
        IF(class IS NULL and nombre IS NULL,'TOTAL', IF(tupa IS NULL and class IS NOT NULL,IF(class IS NOT NULL AND nombre IS NOT NULL AND tupa IS NULL,'SUB SUB TOTAL','SUB TOTAL'),tupa)) AS TUPA, total AS TOTAL FROM(
        Select  c.clase as class,
                c.nombre as nombre,
                t.nombreTupa as tupa,
                SUM(m.importe)  as total 
        from movimiento m, persona p, tupa t, clase6 c
    where m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id and  m.nroRecibo BETWEEN '$var_desde' AND '$var_hasta' 
GROUP BY c.clase, c.nombre,  t.nombreTupa WITH ROLLUP) as tabla",false,$attr);
/*
 * $pdf->mysql_report("select IF( class IS NULL AND nombre IS NULL,'',IF(nombre IS NULL AND class IS NOT NULL, '',class))  as Codigo,
        IFNULL(nombre,'') AS  Clasificador,
        IF(class IS NULL and nombre IS NULL,'TOTAL', IF(nombre IS NULL and class IS NOT NULL,'SUB TOTAL',tupa)) AS Tupa, total FROM(
        Select c.clase as class,
                c.nombre as nombre,
                t.nombreTupa as tupa,
                SUM(m.importe)  as total 
        from movimiento m, persona p, tupa t, clase6 c 
    where m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id and  m.fecha BETWEEN '$var_desde' AND '$var_hasta' 
GROUP BY c.clase,  c.nombre WITH ROLLUP) as tabla",false,$attr);
 * 
 * SELECT IF(anio IS NULL AND mes_num IS NULL, "",IF(mes_num IS NULL AND anio IS NOT NULL, "", anio)) AS "Año",
       IFNULL(mes_num, "") AS "mes",
       IF(anio IS NULL AND mes_num IS NULL, "GRAN TOTAL",
          IF(mes_num IS NULL AND anio IS NOT NULL, CONCAT("SubTotal (",anio,")"), mes)) AS "Mes",
       total FROM (
         SELECT DATE_FORMAT(fecha, "%Y") AS anio,
                DATE_FORMAT(fecha, "%m") AS mes_num,
                DATE_FORMAT(fecha, "%M") AS mes,
                FORMAT(SUM(`total`), 2) AS total
         FROM facturas
           GROUP BY anio DESC,
                    mes_num DESC WITH ROLLUP
) AS Tabla
 * 
 * $pdf->mysql_report("select IFNULL( c.clase,  'TOTAL' )  as Codigo, IFNULL( c.nombre,  'TOTAL SI' ) as Clasificador, IFNULL( t.nombreTupa,  'Sub Total' ) AS Tupa, SUM(m.importe) from movimiento m, persona p, tupa t, clase6 c 
    where m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id and  m.fecha BETWEEN '$var_desde' AND '$var_hasta' GROUP BY c.clase,  t.nombreTupa WITH ROLLUP",false,$attr);

$SQLquery = "SELECT SUM(importe) from movimiento";
    $SQLresult = mysql_query($SQLquery, $link);
    $SQLrow = mysql_fetch_row($SQLresult);
$pdf->Cell(1,15,'HORAS DE TRABAJO',0,1,'L',TRUE);
 
$pdf->mysql_report("select dc.idDC as id,m.nombre as modulo,c.nombre as curso,g.nombre as grupo,CONCAT( d.paterno,' ', d.materno,' ',d.nombres) as docente,dc.numStudent as numStudent,dc.mes as mes, dc.fechai as fechai,dc.fechaf as fechaf,dc.dias as dias,
    dc.hInicio as hInicio,dc.hFin as hFin, d.nombres as nombres,
        d.paterno as paterno, d.materno as materno
        from docentecurso dc
        inner join docentes d on d.idDocente=dc.idDocente
        inner join grupo g on g.idGrupo=dc.idGrupo
        inner join curso c on c.idCurso=g.idCurso
        inner join modulo m on m.idModulo=c.idModulo where year(DATE_ADD(dc.fechai, INTERVAL 15 DAY))=$var_anio and dc.mes=$var_mes order by $var_pagina",false,$attr);
*/
$pdf->Output();
?>
