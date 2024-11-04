<?php include '../seguridad.php'; 
session_start(); 
include('../connections/cn_on.php');
    $SQLquery = $db->prepare("select max(idMov) as id from movimiento");
    $SQLquery -> execute();
    $SQLrow=$SQLquery->fetch(PDO::FETCH_ASSOC);
    $id=$SQLrow['id']+1;
    $SQLquery2 = $db->prepare("select max(nroRecibo) as nro from movimiento");
    $SQLquery2 ->execute();
    $SQLrow2=$SQLquery2->fetch(PDO::FETCH_ASSOC);
    $recibos=$SQLrow2['nro']+1;
    $recibo=str_pad($recibos, 7, "0", STR_PAD_LEFT);
    date_default_timezone_set('UTC');
        //Imprimimos la fecha actual dandole un formato
    $hoy=date("Y-m-d");
    $html = "";
    $html .= "<script language='javascript' type='text/javascript'>";
    $html .= "$('#txtFechaNac').datepicker(); $('#txtFechaNac').datepicker();";
    $html .= " </script>";
    $html .= "
    <form action='javascript:addconceptos();'><br>
    <div class='contact_form' name='contact_form'>
    <ul>
        <h3>Nuevo Registro</h3>
        <span class='required_notification'>* Campos requeridos</span>    
    <div style='float:left; width:54%'>
        <input size='2' type='hidden' name='num' id='num' value='$id' placeholder='1'required/>
        Numero de Recibo: 
        <input type='number' id='nrecibo' value='$recibo' placeholder='0000001' required/>
        ";
      $nombres=$db->prepare("select nombres as nombre, Doc as dni from persona");
      $nombres->execute();
        $html .= "<br>Nombres y Apellidos: 
            <input type='text' id='nombre' list='nombres' placeholder='' size='50' onchange='dniload();' onkeyup=javascript:this.value=this.value.toUpperCase();' required/>
            
      <datalist id='nombres' name='nombres'>
            <select  >
                ";
	while($regis=$nombres->fetch(PDO::FETCH_ASSOC))
	{
            $name=$regis['nombre'];
		$html .= "<option value='$name' label='$name'></option>";
	}        
    $html .= "</select></datalist><br>
        DNI/RUC: <input type='number' id='dnis' name='dnis' />
        
        Fecha: <input type='date' value='$hoy' id='fecha' required/>
        
            ";    
    $consulta=$db->prepare("select idTupa, nombreTupa,monto,clase6.clase as clase  from tupa, clase6 where tupa.idClasif=clase6.id");
    $consulta->execute();
    /***************/
	$html .= "<br>
            <pre>TUPA:    <span style='color:red'>(No modificar este dato despues de elegir)</span>                     </pre>
            <input type='text' id='tupa' size='100' style='font-size: 10px;' list='select1' value='' onchange='cargaMonto(this.value);' required/>
            <datalist id='select1' name='select1'  style='font-size: 10px;'>
            <select>";
	while($registro=$consulta->fetch(PDO::FETCH_ASSOC))
	{
            $tupa=$registro['nombreTupa'];
            $class=$registro['clase'];
		$html .= "<option value='$tupa' label='$class'></option>";
	}        
    $html .= "</select></datalist><br><pre> Observaci&oacute;n:                  Importe:         Cantidad:</pre>";  
    $html .= "<input  type='text' id='obs' size='25' placeholder='' />
               <input  type='text' id='monto' size='8' placeholder=''  onchange='totalload();' required/>
              <input  type='number' id='cant' size='5' placeholder='' value='1' required/>
              <button type='submit' id='btAdd'  name='btAdd'>Add</button><br>";
        $html .= "</div><div id='conceptos' style='float:left;width:46%; '>";
  
    $SQLquerya = $db->prepare("select importe*cantidad as i from movimiento where nrorecibo=:recibo");
    $SQLquerya ->execute([":recibo"=>$id]);
    while($SQLrowa=$SQLquerya->fetch(PDO::FETCH_ASSOC)) {
        $var_total=$SQLrowa["i"]+$var_total;
     }//<table><tr><th style='width:60%'>Total</th><th style='width:35%'><input type='number' id='total' size='5'  disabled/></th><th style='width:5%'> </th></tr></table>
     $html .= "<table  align='center' class='data'><tr><th style='width:62%'>Concepto</th><th style='width:12%'>Importe</th><th style='width:6%'>Cant.</th><th style='width:15%'>Total</th><th style='width:5%'> </th></tr></table>
             <table  id='tablas' style='width:100%'>";
    $html .= "</table>
        
        <table><tr><th style='width:62%'>Total</th><th style='width:12%'> </th><th style='width:6%'> </th><th id='total' style='width:20%'></th></tr></table>
        </div>    
        <br> 
       </li><div align='center' style='float:none;  clear:both'> 
        	<button class='trans' type='button' onclick='imprimir($recibos);'><img src='img/print.png' title='Imprimir'></button>
        	<!-- <button class='trans' type='reset' onclick='cancel(0);'><img src='img/reset.png' title='Resetear'></button>
        	<button class='trans' type='cancel' onclick='cancel(0);'><img src='img/cancel2.png' title='Cancelar Todo'></button> 
        	<input  type='button' onclick='anularRecibo();' value='ANULAR'/> -->
       <br><br>
        </div> 
    </ul>
</div><form/><div id='datimp' style='float:left;width:100%'></div>
";
    echo $html;
//         <button class='trans' type='cancel'><img src='img/anul.jpg' onclick=anularRegistro(); title='Anular'></img></button>
    include '../connections/cn_off.php';
?>