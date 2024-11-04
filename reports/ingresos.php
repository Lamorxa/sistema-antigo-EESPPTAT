<?php
require('mysql_report.php');

$var_fechar= $_GET['dat'];
$var_anio = substr($var_fechar, 0, 4);
$var_mes = substr($var_fechar, 4, 5 );
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
$attr = array('titleFontSize'=>18, 'titleText'=>'Reporte de Ingresos Percibidos durante el mes de '.$var_mes);
$query = 'SET @pos:=1';
$pdf->mysql_report("(select  m.idmov as Nro, p.nombres AS Nombres, c.nombre as Clasificador, m.concepto as Concepto, m.fecha, 
        m.importe from movimiento m, persona p, tupa t, clase6 c ,(SELECT @rownum :=0)r 
        where m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id and  YEAR(m.fecha)='2014' and  MONTH(m.fecha)=$mesn order by m.fecha)
        UNION (select null, null,null,null,'Total', SUM(mov.importe) from movimiento mov)",false,$attr);
/*
 * $pdf->mysql_report("(select (@rownum := @rownum +1) as Row, m.nroRecibo as Nro, p.nombres AS Nombres, c.nombre as Clasificador, m.concepto as Concepto, m.fecha, 
        m.importe from movimiento m, persona p, tupa t, clase6 c ,(SELECT @rownum :=0)r 
        where m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id and  YEAR(m.fecha)='2014' and  MONTH(m.fecha)=$mesn order by m.fecha)
        UNION (select null, null,null,null,'Total', SUM(mov.importe) from movimiento mov)",false,$attr);
 * 
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
