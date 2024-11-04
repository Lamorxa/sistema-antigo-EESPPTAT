<?php
    include '../connections/cn_on.php';
    //$var_anioactual = $_SESSION['pc_year'];
  //  $var_fechaactual = date(Y."-".m."-".d."  /  ".h.":".i.":".s);
    $SQLquery = "select max(idMov) from movimiento";
    $SQLresult = mysql_query($SQLquery, $link);
    $SQLrow=mysql_fetch_array($SQLresult);
    $id=$SQLrow[0]+1;
    $SQLquery = "select max(nroRecibo) from movimiento";
    $SQLresult = mysql_query($SQLquery, $link);
    $SQLrow=mysql_fetch_array($SQLresult);
    $recibo=$SQLrow[0]+1;
    date_default_timezone_set('UTC');
        //Imprimimos la fecha actual dandole un formato
    $hoy=date("Y-m-d");
    $html = "";
    $html .= "<script language='javascript' type='text/javascript'>";
    $html .= "$('#txtFechaNac').datepicker(); $('#txtFechaNac').datepicker();";
    $html .= "</script>";
    $html .= "<div class='contact_form' name='contact_form'>
    <ul>
        <h2>Ingresar Nuevas Clases</h2>
        <span class='required_notification'>* Denotes Required Field</span><br>
        Nro: <input size='2' type='text' name='num' id='num' value='$id' placeholder='' readonly/>
        Numero de Recibo:
        <input type='number' id='nrecibo' value='$recibo' placeholder='01' required />
        <span class='form_hint'>Formato '00000001'</span>
        <br>Nombres y Apellidos:
            <input type='text' id='nombre' placeholder='Dia System' size='50' required/>
            <span class='form_hint'>Formato 'Nombres y Apellidos'</span>
        <br>    
        Fecha:<input type='date' value='$hoy' id='fecha' required />
            <span class='form_hint'>Formato 'dd/mm/aaaa'</span>
            ";    
    $consulta=mysql_query("select idClasif, nombreClasif from clasificador");
	$html .= "<br>Clasificador:<select id='select1' name='select1' onChange='cargaContenido(this.id)'>";
	$html .= "<option value=''>Elige</option>";
	while($registro=mysql_fetch_row($consulta))
	{
		$html .= "<option value='$registro[0]'>$registro[1]</option>";
	}

    $html .= "</select><br>";
    $html .= "<div id='demoMed'>Tupa<select disabled='disabled' id='select2' name='select2'><option value=''>Elige</option></select>
	</div></div><div id='demoMed2'>
        Monto S/.<input disabled='disabled' type='number'id='select3' size='2' placeholder='200' required/>
        <span class='form_hint'>Formato '200'</span>
	</div>
        Concepto:<br>
            <textarea id='concepto' cols='120' rows='3' required></textarea>
        </li>
        <br> 
        	<button class='submit' type='submit' onClick=guardaRegistro();>Registrar</button>
                <button class='submit' type='reset'>Borrar</button>
                <button class='submit' type='submit' formnovalidate>Cancelar</button>
        
    </ul>
</div>";
    echo $html;

    include '../connections/cn_off.php';
?>