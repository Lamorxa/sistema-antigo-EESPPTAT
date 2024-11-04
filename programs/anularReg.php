<?php
    include '../connections/cn_on.php';
   $var_num = $_POST['cod'];
   if($var_num ==0)  $recibo=$_POST['rec'];
    else{
    $SQLqueryt = $db->prepare("select n.nroRecibo as nro from movimiento n where n.idMov=:num");
    $SQLqueryt->execute([':num'=>$var_num]);
    $SQLrowz = $SQLqueryt->fetch(PDO::FETCH_ASSOC);
    $recibo=$SQLrowz['nro'];
    }
    
   $SQLqueryq =  $db->prepare("delete from movimiento where idMov=:num");
   $SQLqueryq->execute([':num'=>$var_num]);
   
    $SQLquery =  $db->prepare("select m.idMov as idMov, m.nroRecibo as nroRecibo,m.cantidad as cantidad, m.importe as importe, t.nombreTupa as tupas,m.concepto from movimiento m,  tupa t where m.tupa=t.idTupa and m.nroRecibo=:rec");
    $SQLquery->execute([':rec'=>$recibo]);
  //  $total_registros = mysql_num_rows($SQLresult);
    $i = 0;
    
    while($SQLrow = $SQLquery->fetch(PDO::FETCH_ASSOC)){
        $registros[$i] = array( "numero" =>$SQLrow['idMov'],
                                "recibo" =>$SQLrow['nroRecibo'],
                                "cant" =>$SQLrow['cantidad'],
                                "importe" =>$SQLrow['importe'],
                                "obs" =>$SQLrow['concepto'],
                                "tupa" =>$SQLrow['tupas']
                          );
        $i++;
    }

    $output = json_encode($registros);
    print($output);
    
    
//include '../connections/cn_off.php';
?>