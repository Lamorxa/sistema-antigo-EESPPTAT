<?php
    include '../connections/cn_on.php';

    $var_nombre = $_POST['nombre'];
    $SQLquery = "select m.idMov as id, m.nroRecibo as nro, p.nombres AS nombres, m.tipo as tipo, m.fecha as fecha, m.importe as importe, t.nombreTupa as tupas, m.concepto as concepto, c.Clasif as clasif from movimiento m, persona p, tupa t, clasificador c where m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.idClasif and p.nombres like '%$var_nombre%'";
    $SQLresult = mysql_query($SQLquery,$link);
    $total_registros = mysql_num_rows($SQLresult);
    if($total_registros==0)
    {$output = 0;}
    
 else {
    $i = 0;
    while($SQLrow = mysql_fetch_array($SQLresult)){
        $registros[$i] = array( num =>$SQLrow['id'],
                                recibo =>$SQLrow['nro'],
                                nombres =>$SQLrow['nombres'],
                                fecha =>$SQLrow['fecha'],
                                importe =>$SQLrow['importe'],
                                tupa =>$SQLrow['tupas'],
                                concepto =>$SQLrow['concepto'],
                                clasif =>$SQLrow['clasif']
                          );        
        $i++;        
    }
        $output = json_encode($registros);
}

    print($output);
    mysql_free_result($SQLresult);
?>