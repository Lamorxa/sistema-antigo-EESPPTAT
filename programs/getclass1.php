<?php
    include '../connections/cn_on.php';

    $var_pagina = $_POST['pagina'];
    $SQLquery = "select id,clase,nombre from clase1 order by id";
    $SQLresult = mysql_query($SQLquery,$link);
    $i = 0;
    while($SQLrow = mysql_fetch_array($SQLresult)){
        $registros[$i] = array( id =>$SQLrow['id'],
                                clase =>$SQLrow['clase'],
                                nombre =>$SQLrow['nombre']
                          );
        $i++;
    }

    $output = json_encode($registros);
//}
    print($output);

    mysql_free_result($SQLresult);

    include '../connections/cn_off.php';
?>