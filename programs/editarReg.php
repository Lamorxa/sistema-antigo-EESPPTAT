<?php
    session_start();
include '../connections/cn_on.php';
    $var_codigo = $_GET['cod'];
  $hoy=date("Y-m-d");

    $SQLquery = "select m.idMov as id, m.nroRecibo as nro, p.nombres AS nombres, m.tipo as tipo, m.fecha as fecha, m.importe as importe,
    t.nombreTupa as tupas, m.concepto as concepto, c.nombre as clasif,m.cantidad,p.doc from movimiento m, persona p, tupa t, clase6 c 
    where m.idMov='$var_codigo' and m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id";
    $SQLresult = mysql_query($SQLquery, $link);
    $SQLrow=mysql_fetch_array($SQLresult);

    $total=$SQLrow[5]*$SQLrow[9];
    $html = "";
    $html .= "<script language='javascript' type='text/javascript'>";
    $html .= "$('#txtFechaNac').datepicker(); $('#txtFechaNac').datepicker();";
    $html .= "</script>";
    $html .= "
    <form action='javascript:actualizarRegistro();'>
    <br><div class='contact_form' name='contact_form'>
    <ul>
        <h2>Modificar Registro</h2><br>
        <span class='required_notification'>* Campos requeridos</span><br>
            <input size='2' type='hidden' name='num' id='num' value='$SQLrow[0]' placeholder='1'required/>
        Numero de Recibo: 
        <input type='number' id='nrecibo' value='$SQLrow[1]' placeholder='0000001' required/>
        <span class='form_hint'>Formato '00000001'</span>";
      $nombres=mysql_query("select nombres as nombre, Doc as dni from persona");
        $html .= "<br>Nombres y Apellidos: 
            <input type='text' id='nombre' list='nombres' value='$SQLrow[2]' placeholder='HUAYLLA TUNTI DIANA' size='50' onchange='dniload();' onkeyup=javascript:this.value=this.value.toUpperCase();' required/>
            <span class='form_hint'>Formato 'Apellidos y Nombres'</span>
      <datalist id='nombres' name='nombres'>
            <select  >
                ";
	while($regis=mysql_fetch_row($nombres))
	{
		$html .= "<option value='$regis[0]' label='$regis[0]'></option>";
	}        
    $html .= "</select></datalist><br>
        DNI/RUC: <input type='number' id='dnis' value='$SQLrow[10]' name='dnis' />
            <span class='form_hint'>Formato 'DNI de 8 digitos y RUC de 11 digitos'</span>
        Fecha: <input type='date' value='$hoy' id='fecha' required/>
            <span class='form_hint'>Formato 'dd/mm/aaaa'</span>
            ";    
    $consulta=mysql_query("select idTupa, nombreTupa,monto,clase6.clase  from tupa, clase6 where tupa.idClasif=clase6.id");
	$html .= "<br>TUPA: 
            <input type='text' id='tupa' size='70' list='select1' value='$SQLrow[6]' onchange='cargaMonto(this.value); totalload();' required/>
            <datalist id='select1' name='select1'>
            <select>";
	while($registro=mysql_fetch_row($consulta))
	{
		$html .= "<option value='$registro[1]' label='$registro[3]'></option>";
	}        
    $html .= "</select></datalist><br>";  
    $html .= "Cantidad <input  type='number'id='cant' size='1'  onchange='totalload();' placeholder='3' value='$SQLrow[9]' required/>
        <span class='form_hint'>Formato '200.00'</span>
        Importe S/. <input  type='text' value='$SQLrow[5]' id='monto' size='10' placeholder='200'  onchange='totalload();' required/>
        <span class='form_hint'>Formato '200.00'</span>
        Total S/. <input  type='text'id='total' size='10' placeholder='200' value='$total' disabled/>
        <br>
        Concepto:<br>
            <textarea  id='concepto' name='concepto' cols='100' rows='3' required>$SQLrow[7]</textarea>
        </li>
        <br> 
        <div align='center'> 
        	<button class='trans' type='submit'><img src='img/save2.png' title='Guardar'></button>
        	<button class='trans' type='reset'><img src='img/reset.png' title='Resetear'></button>
        	<button class='trans' type='cancel'><img src='img/cancel2.png' title='Cancel'></button>
        </div> 
    </ul>
</div><form/>
";
    echo $html;

    
    include '../connections/cn_off.php';
?>
