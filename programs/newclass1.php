<?php
    include '../connections/cn_on.php';
    $SQLquery = "select max(id) from clase1";
    $SQLresult = mysql_query($SQLquery, $link);
    $SQLrow=mysql_fetch_array($SQLresult);
    $id=$SQLrow[0]+1;
    $html = "";
    $html .= "<div class='contact_form' name='contact_form'>
    <ul>
        <h2>Nuevo Clasificador de Nivel 1</h2>
        <span class='required_notification'>* Campos Obligatorios</span><br>
        Id: <input size='2' type='text' name='id' id='id' value='$id' placeholder='' readonly/>
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
        
    </ul>
";
    echo $html;

    

    include '../connections/cn_off.php';
?>
