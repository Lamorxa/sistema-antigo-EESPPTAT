<?php
    include '../connections/cn_on.php';
    $id = $_POST['id'];
    $name = $_POST['names'];
    $loguin = $_POST['login'];
    $pass = $_POST['passs'];
    
$pass_encriptada1 = md5 ($pass);
$pass_encriptada2 = crc32($pass_encriptada1);
$pass_encriptada3 = crypt($pass_encriptada2, "xtemp"); 
$pass_encriptada4 = sha1("xtemp".$pass_encriptada3); 

        $INSERTA = "insert into usuario(idUsuario,nombre,login,clave)values('$id','$name','$loguin','$pass_encriptada4')";
        mysql_query($INSERTA,$link) or die('Could not connect: ' . mysql_error());        
     
include '../connections/cn_off.php';
?>