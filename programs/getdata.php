<?php
    include '../connections/cn_on.php';
   $recibo=$_POST['rec'];
    
        
    $SQLquery = $db->prepare("select p.nombres as nombres, p.Doc as Doc ,m.fecha as fecha from movimiento m inner join persona p on p.idPersona=m.idPersona where m.nroRecibo=:rec order by m.fecha desc limit 1");
    $SQLquery ->execute([":rec"=>$recibo]);
  //  $total_registros = mysql_num_rows($SQLresult);
    $i = 0;
    while($SQLrow = $SQLquery->fetch(PDO::FETCH_ASSOC)){
        //$message[0]= array("m"=>"5","apellidos"=>utf8_encode($apellidos),"nombres"=>utf8_encode($nombres),"celular"=>$celular,"direccion"=>utf8_encode($direccion),"email"=>utf8_encode($email),"depen"=>utf8_encode($depen),"cargo"=>utf8_encode($cargo));
        $registros[$i] = array( "nombres" =>utf8_encode($SQLrow['nombres']),
                                "dni" =>$SQLrow['Doc'],
                                "fecha" =>$SQLrow['fecha']
                          );
        $i++;
    }

    $output = json_encode($registros);
    print($output);
    
    
include '../connections/cn_off.php';
?>