<?php
    include '../connections/cn_on.php';
   $var_num = $_POST['rec'];
  
    $SQLqueryto = $db->prepare("select SUM(importe*cantidad) as imp from movimiento where nroRecibo=:num");
    $SQLqueryto->execute([':num'=>$var_num]);
    $SQLrowzt = $SQLqueryto->fetch(PDO::FETCH_ASSOC);
    $total=$SQLrowzt['imp'];
    
    $output = json_encode($total);
    print($output);
    
include '../connections/cn_off.php';
?>