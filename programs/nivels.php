<?php
$listadoSelects=array(
"select1"=>"CLASIFICADOR",
"select2"=>"TUPA",
"select3"=>"GRUPO");

function validaSelect($selectDestino)
{
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
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
	$tabla=$listadoSelects[$selectDestino];
	include '../connections/cn_on.php';
	$consulta='';
        if($selectDestino=='select3')
	{
	$consulta=mysql_query("SELECT idTupa, monto FROM tupa WHERE idTupa='$opcionSeleccionada'") or die(mysql_error());
        $SQLrow=mysql_fetch_array($consulta);
        echo "Monto S/.<input name='select3' id='select3' value='$SQLrow[1]' size='2'/>";
	include '../connections/cn_off.php';        
        }
                
	else{
            
            if($selectDestino=='select1')
	{
	$consulta=mysql_query("SELECT idClasif, nombreClasif FROM $tabla' order by nombreClasif desc") or die(mysql_error());
	include '../connections/cn_off.php';
		}else if($selectDestino=='select2')
	{
	$consulta=mysql_query("SELECT idTupa, nombreTupa FROM tupa WHERE idClasif='$opcionSeleccionada' order by nombreTupa asc") or die(mysql_error());
	include '../connections/cn_off.php';
		}

	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargaContenido(this.id)'>";
	echo "<option value=''>Elige</option>";
	while($registro=mysql_fetch_row($consulta))
	{
		$registro[1]=htmlentities($registro[1]);
		echo "<option value='".$registro[0]."'>".$registro[1]."</option>";
	}			
	echo "</select>";
}
}
 else{   echo 'ERROR';}
?>