<?php
include('../connections/cn_on.php');
    $valor= $_POST['valor'];
    
    $consulta=$db->prepare("SELECT monto FROM tupa WHERE nombreTupa=:tupa");
    $consulta->execute([':tupa'=>$valor]);
    $fila = $consulta->fetch(PDO::FETCH_ASSOC);
    $output =$fila['monto'];
    print($output);
    include '../connections/cn_off.php';
?>