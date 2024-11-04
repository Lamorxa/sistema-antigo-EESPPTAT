<?php
require('mysql_report.php');

$var_fechar= $_GET['data'];
$var_anio = substr($var_fechar, 0, 4);
$var_mes = substr($var_fechar, 4, 5 );
$pph=20*2;

$fechai = $ano . '-' . $mes . '-' . $dia;

//require('../connections/cn_on.php');
//require('../pdf/functionpdf.php');
//define('FPDF_FONTPATH','../fonts/');


$pdf = new PDF('L','pt','A4');
$fecha=date("m");

$pdf->SetFont('Arial','',10);
$pdf->connect('localhost','root','','caja');
$attr = array('titleFontSize'=>18, 'titleText'=>'Reporte de Recibos anulados durante el mes de '.$var_mes);
$pdf->mysql_report("select m.nroRecibo as Nro,m.fecha from movimiento m where idPersona=0 and importe=0 and tupa=0 and concepto='null'",false,$attr);
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
