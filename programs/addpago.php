<?php session_start();  ?>
<?php
    include '../connections/cn_on.php';
    $var_num = $_POST['numero'];
    $var_nrecibo = $_POST['nrecibo'];
    $nombre = $_POST['nombre'];
    $dnis = $_POST['doc'];
    $var_fecha = $_POST['fecha'];    
    $var_monto = $_POST['monto'];
    $cant = $_POST['cant'];
    $var_tupa = $_POST['tupa'];
    $obs = $_POST['obs'];
    $tupaa = $db->prepare("select idTupa from tupa where nombreTupa=:tupa");
    $tupaa->execute([':tupa'=>$var_tupa]);
        $SQLr=$tupaa->fetch(PDO::FETCH_ASSOC);
        $tupa=$SQLr['idTupa'];
    $consulta=$db->prepare("select idPersona, Doc from persona where nombres=:nombre");
    $consulta->execute([':nombre'=>$nombre]);
    if($row=$consulta->fetch(PDO::FETCH_ASSOC)){                
    $id=$row['idPersona'];    
        if($row['Doc']!=$dnis){
          $SQLquery = $db->prepare("update persona set Doc=:doc WHERE nombres=:nombre");
          $SQLquery->execute([':doc'=>$dnis,':nombre'=>$nombre]);
         // mysql_query($SQLquery,$link) or die('Could not connect: ' . mysql_error());
        }
    }
    else{             
        $busca = $db->prepare("select max(idPersona) as id from persona");
        $busca ->execute();
        $SQLrowp=$busca->fetch(PDO::FETCH_ASSOC);
        $id=$SQLrowp['id']+1;
        $inserta = $db->prepare("insert into persona(idPersona,nombres,Doc)values(:id,:nombre,:dni)");
        $inserta->execute([':id'=>$id,':nombre'=>$nombre,':dni'=>$dnis]);
       // mysql_query($INSERTA,$link) or die('Could not connect: ' . mysql_error());        
        }    
    $tipo=1;
    $user=$_SESSION['codigouser'];
    $SQLquerys = $db->prepare("insert into movimiento(idMov, nroRecibo, idPersona, idUser, tipo, fecha,cantidad, importe, tupa,concepto,estado)
    values(:num,:nro,:id,:us,:tipo,:fecha,:cant,:monto,:tupa,:obs,1)");
    $SQLquerys->execute([':num'=>$var_num,':nro'=>$var_nrecibo,':id'=>$id,':us'=>$user,':tipo'=>$tipo,':fecha'=>$var_fecha,':cant'=>$cant,':monto'=>$var_monto,':tupa'=>$tupa,':obs'=>$obs]);
   // mysql_query($SQLquerys,$link) or die('Could not connect: ' . mysql_error());

  //  mysql_free_result($SQLresult);
  
    include '../connections/cn_off.php';
?>