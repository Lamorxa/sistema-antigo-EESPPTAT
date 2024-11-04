<?php
include '../connections/cn_on.php';
   $var_num = $_POST['nrecibo'];
   
   $SQLquery = $db->prepare("update movimiento set estado=0, concepto='ANULADO' where nroRecibo=:rec");
   $SQLquery -> execute([":rec"=>$var_num]);   
   //$row = $SQLquery->fetch(PDO::FETCH_ASSOC);
   //$id=$row['id'];
   $output = json_encode($id);
    print($output);
   
include '../connections/cn_off.php';
?>