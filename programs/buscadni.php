<?php
    include '../connections/cn_on.php';

    $nom = $_POST['nom'];
        $SQLquery = $db->prepare("select Doc from persona where nombres=:nom");
        $SQLquery->execute([':nom'=>$nom]);
    $SQLrow = $SQLquery->fetch(PDO::FETCH_ASSOC);
    $var_total = $SQLrow['Doc'];
    $output = json_encode($var_total);
    print($output);


  //  include '../connections/cn_off.php';
?>