<?php session_start();  ?>
<?php
    include '../connections/cn_on.php';

    $id = $_POST['id'];
    $clase = $_POST['clase'];
    $nombre = $_POST['nombre'];

    $SQLquery = "insert into clase1(id,clase,nombre) values('$id','$clase','$nombre')";
    mysql_query($SQLquery,$link);
    
    include '../connections/cn_off.php';
?>



