<?php
$listSelects=array(
"selects1"=>"clase1",
"selects2"=>"clase2",
"selects3"=>"clase3",
"selects4"=>"clase4",
"selects5"=>"clase5",
"selects6"=>"clase6");

function validaSelect($selectDestino)
{
	global $listSelects;
	if(isset($listSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcion($opcionSeleccionada)
{
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}
$selectDestino=$_GET["select"]; $opcionSeleccionada=$_GET["opcion"];
if(validaSelect($selectDestino))
{
	$tabla=$listSelects[$selectDestino];
	include '../connections/cn_on.php';
	$consulta='';
	if($selectDestino=='selects1')
	{
	$consulta=mysql_query("SELECT id, clase, nombre FROM $tabla' order by nombre asc") or die(mysql_error());
	include '../connections/cn_off.php';
		}else if($selectDestino=='selects2')
	{
	$consulta=mysql_query("SELECT id, clase, nombre FROM clase2 WHERE idc1='$opcionSeleccionada' order by id asc") or die(mysql_error());
	include '../connections/cn_off.php';
		}else if($selectDestino=='selects3')
	{
	$consulta=mysql_query("SELECT id, clase, nombre FROM clase3 WHERE idc2='$opcionSeleccionada' order by id asc") or die(mysql_error());
	include '../connections/cn_off.php';
		}else if($selectDestino=='selects4')
	{
	$consulta=mysql_query("SELECT id, clase, nombre FROM clase4 WHERE idc3='$opcionSeleccionada' order by id asc") or die(mysql_error());
	include '../connections/cn_off.php';
		}else if($selectDestino=='selects5')
	{
	$consulta=mysql_query("SELECT id, clase, nombre FROM clase5 WHERE idc4='$opcionSeleccionada' order by id asc") or die(mysql_error());
	include '../connections/cn_off.php';
		}else if($selectDestino=='selects6')
	{
	$consulta=mysql_query("SELECT id, clase, nombre FROM clase6 WHERE idc5='$opcionSeleccionada' order by id asc") or die(mysql_error());
	include '../connections/cn_off.php';
		}

	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargaContenido(this.id)'>";
	echo "<option value=''>Elige</option>";
	while($registro=mysql_fetch_row($consulta))
	{
		$registro[1]=htmlentities($registro[1]);
		echo "<option value='".$registro[0]."'>".$registro[1] ." ".$registro[2]."</option>";
	}			
	echo "</select>";
}else
{
	echo 'ERROR';
	}
?>

