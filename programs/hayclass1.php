<?php
    include '../connections/cn_on.php';

    $clase = $_POST['clase'];
    $nombre = $_POST['nombre'];

    $SQLquery = "select clase,nombre from clase1 where clase='$clase' OR nombre='$nombre'";
    $SQLresult = mysql_query($SQLquery,$link);
    $total_registros = mysql_num_rows($SQLresult);

    $output =$total_registros;
    print($output);
    include '../connections/cn_off.php';
?>