<?php
    include '../connections/cn_on.php';
    
   $recibo = $_POST['recibo'];
     $SQLquery = "select m.cantidad,m.importe, t.nombreTupa as tupas from movimiento m, tupa t where  m.tupa=t.idTupa and m.nroRecibo='$recibo' order by m.idMov desc";
    $SQLresult = mysql_query($SQLquery,$link);
  //  $total_registros = mysql_num_rows($SQLresult);
    $i = 0;
    $registros='';
    while($SQLrow = mysql_fetch_array($SQLresult)){
        /*$registros[$i] = array( importe =>$SQLrow['importe'],
                                tupa =>$SQLrow['tupas'],
                                cant =>$SQLrow['cantidad']
                          );*/
        $registros .= $SQLrow['tupas'].'/'.$SQLrow['importe'].'/'.$SQLrow['cantidad'].'/'.$SQLrow['importe']*$SQLrow['cantidad'].'<br>';
        
        $i++;
    }
    $output = json_encode($registros);
    print($output);
    mysql_free_result($SQLresult);
   
include '../connections/cn_off.php';
?>