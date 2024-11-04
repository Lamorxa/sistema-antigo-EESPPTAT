<?php
    include '../connections/cn_on.php';
    $var_num = $_POST['numero'];
    $var_nrecibo = $_POST['nrecibo'];
    $var_fecha = $_POST['fecha'];    
    $tipo=1;
    $user=$_SESSION['codigouser'];
   
    $SQLquery = "insert into movimiento(idMov, nroRecibo, idPersona, idUser, tipo, fecha, importe, tupa, concepto)
    values('$var_num','$var_nrecibo',0,'$user','$tipo','$var_fecha',0,0,'null')";
    mysql_query($SQLquery,$link) or die('Could not connect: ' . mysql_error());

    $SQLquery = "select m.idMov, m.nroRecibo, p.nombres AS nombres, m.tipo, m.fecha, m.importe, t.nombreTupa as tupas, m.concepto, c.nombre as clasif from movimiento m, persona p, tupa t, clase6 c where m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id";
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