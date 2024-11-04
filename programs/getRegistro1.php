<?php
    include '../connections/cn_on.php';
    
    
    $SQLquery = "select m.idMov, m.nroRecibo, p.nombres AS nombres, m.tipo,m.cantidad, m.fecha, SUM(m.importe) as importe, t.nombreTupa as tupas, m.concepto, c.clase as clasif from movimiento m, persona p, tupa t, clase6 c  where  m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id group by m.nroRecibo order by m.idMov desc limit 200";
    $SQLresult = mysql_query($SQLquery,$link);
  //  $total_registros = mysql_num_rows($SQLresult);
    $i = 0;
    while($SQLrow = mysql_fetch_array($SQLresult)){
        $recibo=$SQLrow['nroRecibo'];
        
        $SQLquerys = "select m.cantidad,m.importe, t.nombreTupa as tupas,m.concepto from movimiento m, tupa t where  m.tupa=t.idTupa and m.nroRecibo='$recibo' order by m.nroRecibo desc  limit 200";
    $SQLresults = mysql_query($SQLquerys,$link);
  //  $total_registros = mysql_num_rows($SQLresult);
    $SQLqueryto = "select SUM(importe) as imp from movimiento where nroRecibo='$recibo'";
    $SQLresultto = mysql_query($SQLqueryto,$link);
    $SQLrowzt = mysql_fetch_array($SQLresultto);
    $total=$SQLrowzt[0];
    
    $registross='';
    while($SQLrows = mysql_fetch_array($SQLresults)){
        $registross .= $SQLrows['tupas'].' '.$SQLrows['concepto'].'&nbsp;&nbsp;;&nbsp;&nbsp;'.$SQLrows['importe'].'&nbsp;&nbsp;;&nbsp;&nbsp;'.$SQLrows['cantidad'].'&nbsp;&nbsp;;&nbsp;&nbsp;'.$SQLrows['importe']*$SQLrows['cantidad'].'<br>';
        
    }
        
        $registros[$i] = array( numero =>$SQLrow['idMov'],
                                recibo =>$SQLrow['nroRecibo'],
                                nombres =>$SQLrow['nombres'],
                                fecha =>$SQLrow['fecha'],
                                todo =>$registross,
                                total =>$total,
                                cant =>$SQLrow['cantidad'],
                                clasif =>$SQLrow['clasif']
                          );
        $i++;
    }
    $output = json_encode($registros);
    print($output);
    mysql_free_result($SQLresult);
   
include '../connections/cn_off.php';
?>