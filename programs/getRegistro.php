<?php
    include '../connections/cn_on.php';
    $SQLquery = "select m.idMov, m.nroRecibo, p.nombres AS nombres, m.tipo,m.cantidad, m.fecha, SUM(m.importe) as importe, t.nombreTupa as tupas, m.concepto, c.clase as clasif from movimiento m, persona p, tupa t, clase6 c  where  m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id group by m.nroRecibo order by m.idMov desc";
    $SQLresult = mysql_query($SQLquery,$link);
  //  $total_registros = mysql_num_rows($SQLresult);
    $i = 0;
    while($SQLrow = mysql_fetch_array($SQLresult)){
        $registros[$i] = array( numero =>$SQLrow['idMov'],
                                recibo =>$SQLrow['nroRecibo'],
                                nombres =>$SQLrow['nombres'],
                                fecha =>$SQLrow['fecha'],
                                importe =>$SQLrow['importe'],
                                tupa =>$SQLrow['tupas'],
                                cant =>$SQLrow['cantidad'],
                                concepto =>$SQLrow['concepto'],
                                clasif =>$SQLrow['clasif']
                          );
        $i++;
    }
    $output = json_encode($registros);
    print($output);
    mysql_free_result($SQLresult);
   
include '../connections/cn_off.php';
?>