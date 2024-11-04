<!DOCTYPE html>
<html>
<head>
	<title>.::Sistema de Ingresos EESPPTA::.</title>
                <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1? />
	<link rel="stylesheet" media="screen" href="css/mystyle.css" >
	<link rel="stylesheet" media="screen" href="css/styles.css" >
</head>
<body  style=" background-image: url(img/fondo.png); background-repeat: no-repeat; background-position: center top; text-align: center;">
<div align="center" style="vertical-align: middle; margin-top: 13%; ">
<form class="contact_form" action="control.php" method="post" name="contact_form" style="vertical-align: central; width: 450px" >
    <ul align="center" style="background-color: rgba(227, 249, 152, 0.08); 
    -webkit-border-radius: 18;
    border-radius: 18;
    -moz-border-radius-bottomleft: 18px;
    -moz-border-radius-topleft: 18px;
    -webkit-border-bottom-left-radius: 18px;
    -webkit-border-top-left-radius: 18px;
    border-bottom-left-radius: 18px;
    border-top-left-radius: 18px; ">
        <li>
             <h2>Sistema de Ingresos del EESPPTA - Tinta</h2><br>
             <h3>Acceso al Sistema</h3>
        </li>
        <li>
            <label for="name">Usuario:</label>
            <input type="text" name="user" id="user" placeholder="Usuario" required />
        </li>
        <li>
            <label for="email">Password:</label>
            <input type="password" name="pass" id="pass" placeholder="Contrasenia" required />
            <span class="form_hint">Distincion entre mayscula y minusculas</span>
        </li>
       
    <?php // echo $pw=password_hash('29684724', PASSWORD_DEFAULT);?>
        <li>
        	<button class="submit" type="submit">Acceder</button>
        </li>
    </ul>
</form>
    </div>
    
    <div id='footer'>
        <a href="manual.pdf" target="_black" >Ayuda</a> | Copyright&copy;2022 Sitrav v1.2 <a href="http://www.innovasoftware.com.pe/"  target="_black">InnovaSoftware</a> Todos los derechos reservados<br>
    Diseño e Implementación de Software a medida | 935381784
    </div>
</body>
</html>