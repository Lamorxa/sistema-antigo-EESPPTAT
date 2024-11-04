<?php
    include '../connections/cn_on.php';
    $html = "";
    $html .= "<table>";
    $html .= "<tr><br/><t1>NUEVO GRUPO</t1><hr></tr>";
    $html .= "<form name='fvalida' id='fvalida' action='post.php' method='post'>";$html .= "<tr><td class='small'>M&oacute;dulo</td><td class='small'>";
    $consulta=mysql_query("SELECT id,clase, nombre FROM clase3");
	$html .= "<select name='select1' id='select1' onChange='cargaConClass(this.id)'>";
	$html .= "<option value=''>Elige</option>";
	while($registro=mysql_fetch_row($consulta))
	{
		$html .= "<option value='".$registro[0]."'>".$registro[1]." ".$registro[2]."</option>";
	}
    $html .= "</select></td></tr>";

    $html .= "<tr><td class='small'>Curso</td><td class='small'></div>
			<div id='demoMed'><select disabled='disabled' name='select2' id='select2'><option value=''>Cursos</option></select>
	</div>";
    $html .= "</td></tr>";

    $html .= "<tr><td class='small'>Nombre</td><td class='small'><input name='nombre' id='nombre' size=25 onchange='this.value=this.value.toUpperCase();'></input></td></tr>";
    $html .= "<tr><td colspan='7' align='center'><input type='button' Value='Guardar' onClick=guardarGrupo();></input>&nbsp;<input id='borrar' name='borrar' type='reset' value='Borrar campos'>&nbsp;<input type='button' Value='Cancelar' onclick=javascript:cargargrupos();></input></td></tr>";
    $html .= "</form></table>";
    echo $html;

    

    include '../connections/cn_off.php';
?>
