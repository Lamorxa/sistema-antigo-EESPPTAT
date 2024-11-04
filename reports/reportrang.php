<?php
require('mysql_report.php');

$var_fechar= $_GET['dat'];
$var_desde = substr($var_fechar, 0, 10);
$var_hasta = substr($var_fechar, 10, 20 );
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
$pdf->mysql_report("select m.nroRecibo as Nro, p.nombres AS Nombres, c.nombre as Clasificador, m.concepto as Concepto, m.fecha, m.importe from movimiento m, persona p, tupa t, clase6 c 
    where m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id and  m.fecha BETWEEN '$var_desde' AND '$var_hasta'",false,$attr);
/*
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
