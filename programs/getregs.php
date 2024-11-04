<?php
    include '../connections/cn_on.php';
   $recibo=$_POST['rec'];
    $SQLquery = $db->prepare("select m.idMov as idMov, m.nroRecibo as nroRecibo,m.cantidad as cantidad, m.importe as importe, concat(t.nombreTupa,' ',m.concepto) as tupas, m.concepto from movimiento m,  tupa t where m.tupa=t.idTupa and m.nroRecibo=:rec");
    $SQLquery ->execute([":rec"=>$recibo]);
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
    
    
include '../connections/cn_off.php';
?>