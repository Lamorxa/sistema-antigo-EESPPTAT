<?php session_start();  ?>
<?php
    include '../connections/cn_on.php';
  
    $var_codigo = $_POST['codigo'];


    $SQLquery = "delete from clase1 where id='$var_codigo'";
    mysql_query($SQLquery,$link);

    include '../connections/cn_on.php';
?>