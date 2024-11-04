<?php
    include '../connections/cn_on.php';
   $rec = $_POST['cod'];
  
   $SQLqueryq = "delete from movimiento where nroRecibo='$rec'";
    mysql_query($SQLqueryq,$link) or die('No es posible Eliminar: ' . mysql_error());
  
    mysql_free_result($SQLresult);
    
include '../connections/cn_off.php';
?>