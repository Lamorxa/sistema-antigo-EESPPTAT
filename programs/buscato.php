<?php
    include '../connections/cn_on.php';
   $var_num = $_POST['cod'];
  
    $SQLqueryt = $db->prepare("select n.nroRecibo as rec from movimiento n where n.idMov=:num");    
    $SQLqueryt->execute([':num'=>$var_num]);
    $SQLrowz = $SQLqueryt->fetch(PDO::FETCH_ASSOC);
    $recibo=$SQLrowz['rec'];
    
    $SQLresulto= $db->prepare("select SUM(importe*cantidad) as imp from movimiento where nroRecibo=:rec");
    $SQLresulto->execute([':rec'=>$recibo]);
    $SQLrowzt =$SQLresulto->fetch(PDO::FETCH_ASSOC);
    $total=$SQLrowzt['imp'];
    $output = json_encode($total);
    print($output);
    
include '../connections/cn_off.php';
?>