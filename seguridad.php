<?php
session_start();
if ($_SESSION["autenticado"] != "SI") {
    $html = "";
                        $html .= "<script language='javascript' type='text/javascript'>";
                        $html .= "alert('Inicie Session');";
                        $html .= "location.assign('index.php');</script>";
                        echo $html;
    header("Location: index.php");
	exit();
} else {
    $fechaGuardada = $_SESSION["ultimoAcceso"];
    $ahora = date("Y-n-j H:i:s");
    $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));

     if($tiempo_transcurrido >= 1800) {
      session_destroy();
      $html = "";
                        $html .= "<script language='javascript' type='text/javascript'>";
                        $html .= "alert('Su Session ha expirado\n Inicie Nuevamente');";
                        $html .= "location.assign('index.php');</script>";
                        echo $html;
      header("Location: index.php");
    }else {
    $_SESSION["ultimoAcceso"] = $ahora;
   }
}
?> 