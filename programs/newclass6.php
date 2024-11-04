<?php
    include '../connections/cn_on.php';
    $html = "";
    $html .= "    <ul>
        <h2>Nuevo Clasificador de Nivel 6</h2>
        <span class='required_notification'>* Campos Obligatorios</span><br>
        Id: <input size='2' type='text' name='id' id='id' value='$id' placeholder='' readonly/>
        Clasificador n1";
    $consulta=mysql_query("SELECT id,clase, nombre FROM clase1");
	$html .= "<select name='selects1' id='selects1' onChange='cargaConClass(this.id)'>";
	$html .= "<option value=''>Elige</option>";
	while($registro=mysql_fetch_row($consulta))
	{
		$html .= "<option value='".$registro[0]."'>".$registro[1]." ".$registro[2]."</option>";
	}
    $html .= "</select></div>
	<div><select disabled='disabled' name='selects2' id='selects2'><option value=''>Clasificador2</option></select></div>
	<div><select disabled='disabled' name='selects3' id='selects3'><option value=''>Clasificador3</option></select></div>
	<div><select disabled='disabled' name='selects4' id='selects4'><option value=''>Clasificador4</option></select></div>
	<div><select disabled='disabled' name='selects5' id='selects5'><option value=''>Clasificador5</option></select></div>
	<div><select disabled='disabled' name='selects6' id='selects6'><option value=''>Clasificador6</option></select></div>
        Clase:
        <input type='text' id='class' value='' placeholder='1' required />
        <span class='form_hint'>Formato '1'</span>
        <br>Nombre:
            <input type='text' id='nombre' placeholder='INGRESOS RESUPUESTARIOS' size='50' required/>
            <span class='form_hint'>Formato 'INGRESOS RESUPUESTARIOS'</span>
        <br>  
            	<button class='submit' type='submit' onClick=guardaclass1();>Registrar</button>
                <button class='submit' type='reset'>Borrar</button>
                <button class='submit' type='submit' formnovalidate>Cancelar</button>
        
    </ul>";

    echo $html;

    

    include '../connections/cn_off.php';
?>
