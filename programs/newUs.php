<?php
    include '../connections/cn_on.php';
    $SQLquery = "select max(idUsuario) from usuario";
    $SQLresult = mysql_query($SQLquery, $link);
    $SQLrow=mysql_fetch_array($SQLresult);
    $id=$SQLrow[0]+1;
    $html = "";
    $html .= "<form action='javascript:guardaUs();'><div class='contact_form' name='contact_form'>
    <ul><br>
        
        <h3>Nuevo Usuario del Sistema</h3>
        <span class='required_notification'>* Campos Obligatorios</span><br>
        Id: <input size='2' type='text' name='id' id='id' value='$id' placeholder='' readonly/>
        <br>Nombres y Apellidos:
        <input type='text' id='name' size='50' value='' placeholder='Diana Huaylla Tunti' required />
        <span class='form_hint'>Formato 'Diana Huaylla Tunti'</span>
        <br>login:
            <input type='text' id='login' placeholder='nadita' size='30' required/>
            <span class='form_hint'>Formato 'nadita'</span>
        <br>Password: 
            <input type='password' id='pass' placeholder='123Rfd*' size='30' required/>
            <span class='form_hint'>Formato 'Debe contener letras numeros y difencia entre mayuscula y minuscula'</span>
        <br>  
                <button class='submit' type='submit'>Guardar</button>
                <button class='submit' type='reser' formnovalidate>Cancelar</button>
        
    </ul><div/><form/>
";
    echo $html;

    

    include '../connections/cn_off.php';
?>
