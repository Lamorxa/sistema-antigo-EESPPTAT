<?php
include 'connections/cn_on.php';

$username=$_POST['user'];
//$password=md5($_POST['pass']);
$password=$_POST['pass'];
$pass_encriptada1 = md5 ($password); //Encriptacion nivel 1
$pass_encriptada2 = crc32($pass_encriptada1); //Encriptacion nivel 1
$pass_encriptada3 = crypt($pass_encriptada2, "xtemp"); //Encriptacion nivel 2
$pass_encriptada4 = sha1("xtemp".$pass_encriptada3); //Encriptacion nivel 3


if ($password==NULL) {
                        $html = "";
                        $html .= "<script language='javascript' type='text/javascript'>";
                        $html .= "alert('No a introducido una contrase&ntilde;a');";
                        $html .= "location.assign('index.php');</script>";
                        echo $html;
}else{
$r1 = $db->prepare("SELECT login,clave FROM usuario WHERE login=:user") or die(mysql_error());
$r1->execute([":user"=>$username]);
$data = $r1->fetch(PDO::FETCH_ASSOC);
if(password_verify($password, $data['clave'])==TRUE){
    
    $r2 = $db->prepare("select idUsuario, login, clave, nombre from usuario where login=:user");
    $r2->execute([":user"=>$username]);
    $SQLrow = $r2->fetch(PDO::FETCH_ASSOC);
   // $username2 = $SQLrow['u'];
    session_start();
    $_SESSION['autenticado'] = 'SI';
    $_SESSION['ultimoAcceso'] = date('Y-n-j H:i:s');
    $_SESSION['codigouser'] = $SQLrow['idUsuario'];
    $_SESSION['nameuser'] = $SQLrow['nombre'];
    $_SESSION['s_username'] = $SQLrow['login'];
    $_SESSION['pc_year'] = date("Y");
    $_SESSION['pc_mes'] = date("m");
        header ('Location: inicio.php');
}
else {
                        $html = "";
                        $html .= "<script language='javascript' type='text/javascript'>";
                        $html .= "alert('No a introducido una contrasenia correcta para ".$username." ');";
                        $html .= "location.assign('index.php');</script>";
                        echo $html;
}
}
?>