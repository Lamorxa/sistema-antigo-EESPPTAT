<?php
	
	$mysqli = new mysqli('localhost', 'root', 'DBt3s0r0', 'caja');
	
	if($mysqli->connect_error){
		
		die('Error en la conexion' . $mysqli->connect_error);
		
	}
?>