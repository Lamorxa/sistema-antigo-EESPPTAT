<?php
session_start();
    include '../connections/cn_on.php';
    $var_num = $_POST['numero'];
    $var_nrecibo = $_POST['nrecibo'];
    $nombre = $_POST['nombre'];
    $var_fecha = $_POST['fecha'];    
    $var_monto = $_POST['monto'];
    $var_tupa = $_POST['tupa'];
    $var_concepto = $_POST['concepto'];
    $dnis = $_POST['doc'];
    $cant = $_POST['cant'];
     $tupaa = "select idTupa from tupa where nombreTupa='$var_tupa'";
        $SQLresul = mysql_query($tupaa, $link);
        $SQLr=mysql_fetch_row($SQLresul);
        $tupa=$SQLr[0];
     
         
    $consulta=mysql_query("select idPersona from persona where nombres='$nombre'") or die(mysql_error());
    
    if($row=mysql_fetch_array($consulta)){                
    $id=$row[0];    
        if($row[1]!=$dnis){
          $SQLquery = "update persona set Doc='$dnis' WHERE nombres='$nombre'";
          mysql_query($SQLquery,$link) or die('Could not connect: ' . mysql_error());
        }
    }
    else{             
        $busca = "select max(idPersona) from persona";
        $SQLresult = mysql_query($busca, $link);
        $SQLrowp=mysql_fetch_array($SQLresult);
        $id=$SQLrowp[0]+1;
        $INSERTA = "insert into persona(idPersona,nombres,Doc)values('$id','$nombre','$dnis')";
        mysql_query($INSERTA,$link) or die('Could not connect: ' . mysql_error());        
        }    
    $tipo=1;
    $user=$_SESSION['codigouser'];
    
    $SQLquery = "update movimiento set nroRecibo='$var_nrecibo', idPersona='$id', cantidad='$cant',idUser='$user', tipo='$tipo', fecha='$var_fecha', importe='$var_monto', tupa='$tupa', concepto='$var_concepto' where idMov='$var_num'";
    
    mysql_query($SQLquery,$link) or die('Could not connect: ' . mysql_error());
    mysql_free_result($SQLresult);
   
include '../connections/cn_off.php';
?>