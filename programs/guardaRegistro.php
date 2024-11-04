<?php
session_start();
    include '../connections/cn_on.php';
    $var_num = $_POST['numero'];
    $var_nrecibo = $_POST['nrecibo'];
    $nombre = $_POST['nombre'];
    $dnis = $_POST['doc'];
    //$dn = $_POST['dnis'];
    $var_fecha = $_POST['fecha'];    
    $var_monto = $_POST['monto'];
    $cant = $_POST['cant'];
    $var_tupa = $_POST['tupa'];
    $var_concepto = $_POST['concepto'];
    $tupaa = "select idTupa from tupa where nombreTupa='$var_tupa'";
        $SQLresul = mysql_query($tupaa, $link);
        $SQLr=mysql_fetch_row($SQLresul);
        $tupa=$SQLr[0];
     
         
    $consulta=mysql_query("select idPersona, Doc from persona where nombres='$nombre'") or die(mysql_error());
    
    if($row=mysql_fetch_array($consulta)){                
    $id=$row[0];    
        if($row[1]!=$dnis){
          $SQLquery = "update persona set Doc='$dnis' WHERE nombres='$nombre'";
          mysql_query($SQLquery,$link) or die('Could not connect: ' . mysql_error());
        }
    }
    else{             
        $busca = "select max(idPersona) from persona";
        $SQLresult = mysql_query($busca, $link);
        $SQLrowp=mysql_fetch_array($SQLresult);
        $id=$SQLrowp[0]+1;
        $INSERTA = "insert into persona(idPersona,nombres,Doc)values('$id','$nombre','$dnis')";
        mysql_query($INSERTA,$link) or die('Could not connect: ' . mysql_error());        
        }    
    $tipo=1;
    $user=$_SESSION['codigouser'];
    $SQLquerys = "insert into movimiento(idMov, nroRecibo, idPersona, idUser, tipo, fecha,cantidad, importe, tupa, concepto)
    values('$var_num','$var_nrecibo','$id','$user','$tipo','$var_fecha','$cant','$var_monto','$tupa','$var_concepto')";
    mysql_query($SQLquerys,$link) or die('Could not connect: ' . mysql_error());

    $SQLquery = "select m.idMov, m.nroRecibo, p.nombres AS nombres, m.tipo, m.fecha,m.cantidad as cantidad, m.importe, t.nombreTupa as tupas, m.concepto, c.nombre as clasif from movimiento m, persona p, tupa t, clase6 c where m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id";
    $SQLresult = mysql_query($SQLquery,$link);
  //  $total_registros = mysql_num_rows($SQLresult);
    $i = 0;
    while($SQLrow = mysql_fetch_array($SQLresult)){
        $registros[$i] = array( numero =>$SQLrow['idMov'],
                                recibo =>$SQLrow['nroRecibo'],
                                nombres =>$SQLrow['nombres'],
                                fecha =>$SQLrow['fecha'],
                                cantidad =>$SQLrow['cantidad'],
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