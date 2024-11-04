$(document).ready(function() {
		$("#concept").click(function(event) {
			$("tabla").remove();
		});
	});
document.oncontextmenu = function(){return false}
var txt=" .:: SGI ::. Caja ";
var espera=250;
var refresco=null;

function rotulo_title() {
document.title=txt;
txt=txt.substring(1,txt.length)+txt.charAt(0);
refresco=setTimeout("rotulo_title()",espera);
}

function nuevoAjax()
{var xmlhttp=false;
	try{xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");}
	catch(e){
		try{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
		catch(E){if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();}
	}
	return xmlhttp;
}

function cargarContenido(idContenedor, strUrl) {
respuesta = "";
        $.ajax({
            type: "POST",
            url: strUrl,
            async:false,
            success: function(respuesta){
                $(idContenedor).empty();
                $(idContenedor).append(respuesta);
            }
          }
    );
}

var listadoSelects=new Array();
listadoSelects[0]="select1";
listadoSelects[1]="select2";
listadoSelects[2]="select3";

var listSelects=new Array();
listSelects[0]="selects1";
listSelects[1]="selects2";
listSelects[2]="selects3";
function buscarEnArray(array, dato)
{var x=0;
	while(array[x])
	{
		if(array[x]==dato) return x;
		x++;
	}
	return null;
}

function cargarContenido(idContenedor, strUrl) {
respuesta = "";
        $.ajax({
            type: "POST",
            url: strUrl,
            async:false,
            success: function(respuesta){
                $(idContenedor).empty();
                $(idContenedor).append(respuesta);
            }
          }
    );
}

var listadoSelects=new Array();
listadoSelects[0]="select1";
listadoSelects[1]="select2";
listadoSelects[2]="select3";

var listSelects=new Array();
listSelects[0]="selects1";
listSelects[1]="selects2";
listSelects[2]="selects3";
function buscarEnArray(array, dato)
{var x=0;
	while(array[x])
	{
		if(array[x]==dato) return x;
		x++;
	}
	return null;
}

function cargaMonto(value)
{
        $.ajax({
      type: "POST",
      url: "programs/monto.php",
      data:"valor="+value,
      success: function(datos){
          registro = eval(datos);
          document.getElementById('monto').value=registro;
          document.getElementById('concepto').value=value;
          document.getElementById('total').value=registro*1;
      }
   });
 
}


function cargaConClass(idSelectOrigen)
{elemento = document.getElementById("selects1");
   var var_clase1 = elemento.options[elemento.selectedIndex].value;
               
    var posicionSelectDestino=buscarEnArray(listSelects, idSelectOrigen)+1;
	var selectOrigen=document.getElementById(idSelectOrigen);
	var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;

 if(opcionSeleccionada==0)
	{
		var x=posicionSelectDestino, selectActual=null;
		while(listSelects[x])
		{
			selectActual=document.getElementById(listSelects[x]);
			selectActual.length=0;
			var nuevaOpcion=document.createElement("option");nuevaOpcion.value=0;nuevaOpcion.innerHTML="Selecciona una Opci&oacute;n...";
			selectActual.appendChild(nuevaOpcion);selectActual.disabled=true;
			x++;
		}
	}
	else if(idSelectOrigen!=listSelects[listSelects.length-1])
	{var idSelectDestino=listSelects[posicionSelectDestino];
		var selectDestino=document.getElementById(idSelectDestino);
		var ajax=nuevoAjax();

		ajax.open("GET", "programs/clasifnivel.php?select="+idSelectDestino+"&opcion="+opcionSeleccionada, true);
		ajax.onreadystatechange=function()
		{

			if (ajax.readyState==1)
			{
				selectDestino.length=0;
				var nuevaOpcion=document.createElement("option");nuevaOpcion.value=0;nuevaOpcion.innerHTML="Cargando...";
				selectDestino.appendChild(nuevaOpcion);selectDestino.disabled=true;
			}
			if (ajax.readyState==4)
			{
				selectDestino.parentNode.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null);
	}
           
           
}


function direccionar(strUrl) {
    alert('uff');
    respuesta = "";
    location.assign("http://www.ejemplo.com");
    $.ajax({
            type: "POST",
            url: strUrl


          }
    );
}


function cargaRegistro(flag){

    if (flag == 0){
        $('#headmain').empty();
        $('#bodymain').empty();
        texto = "";
        texto += "<table align='center'>";
        texto +=  "<tr><td>&nbsp;</td></tr>";
        texto +=  "<tr><td class='tituloform' colspan='2'>Registro de Ingresos</td></tr>";
        //texto +=  "<tr><td>Codigo</td><td><input id='txtCodigo' type='text' name='txtCodigo' size='10' onBlur=cargarEstudiantes(1); /></td></tr>";
        texto +=  "<tr><td>Paterno</td><td><input id='txtPaterno' type='text' name='txtPaterno' size='15' onBlur=cargarEstudiantes(1); /> Materno <input id='txtMaterno' type='text' name='txtMaterno' size='15' onBlur=cargarEstudiantes(1); /> Nombres <input id='txtNombres' type='text' name='txtNombres' size='20' onBlur=cargarEstudiantes(1); /></td></tr>";
        texto +=  "<tr><td>&nbsp;</td></tr>";
        texto += "</table>";
        $('#headmain').append(texto);
    }

    var_codigo = $('#txtCodigo').val();
    var_paterno = $('#txtPaterno').val();
    var_materno = $('#txtMaterno').val();
    var_nombres = $('#txtNombres').val();

    
    if(var_codigo == '' && var_paterno == '' && var_nombres == ''){
        return;
    }

    pagina = 1;
    $.ajax({
            type: "POST",
            url: "programas/getRegistro.php",
            data: "pagina="+pagina,
            success: function(datos){
                $('#bodymain').empty();
                texto = "";
                texto += "<table align='center' class='data'>";
                texto += "<tr><th colspan='11' style='text-align:left; background:#ffffff'><img src='img/edit_add.gif' alt='Nuevo' border=0, style='cursor:pointer' onclick=javascript:registro();></th></tr>";
                texto += "<tr><th>Nro de Registro</th><th>Nro de Recibo</th><th>Nombre y Apellidos</th><th>Fecha</th><th>Importe</th><th>Clasificador</th><th>Concepto</th><th>&nbsp;</th><th>&nbsp;</th></tr>";
                
                registros = eval(datos);
                
                for (var i=0; i < registros.length-3; i++) {
                        texto += "<tr><td align='center'>"+registros[i].codigo+"</td>";
                        texto += "<td>"+registros[i].paterno+"</td>";
                        texto += "<td>"+registros[i].materno+"</td>";
                        texto += "<td>"+registros[i].nombres+"</td>";
                        texto += "<td align='center'><img src='img/b_edit.png' alt='' border=0 style='cursor:pointer;' onClick=editarEstudiante('"+registros[i].codigo+"');></td>";
                        texto += "<td align='center'><img src='img/b_drop.png' alt='' border=0 style='cursor:pointer;' onClick=eliminarEstudiante('"+registros[i].codigo+"');></td></tr>";
                }
                texto += "<tr><th colspan='10' style='text-align:right'></th></tr>";
                texto += "</table>";
                texto += "<table>";
                texto += "<tr><td colspan='7' align='center'>";
                
                if((registros[i+1].actual - 1) > 0) {
			texto += "<label class='labelpagina' onClick=cargarUsuariospoa(1,"+(registros[i+1].actual-1)+");>Anterior</label>";
		}

                for (var j=0; j < registros[i].length-1; j++) {
                    if (registros[i+1].actual == j+1)
                        texto += "&nbsp;<label class='labelpagina' Style='color:red' onClick=cargarUsuariospoa(1,"+registros[i][j].p+");>"+registros[i][j].p+"</label>&nbsp;";
                    else
                        texto += "&nbsp;<label class='labelpagina' onClick=cargarUsuariospoa(1,"+registros[i][j].p+");>"+registros[i][j].p+"</label>&nbsp;";
                }

                if((registros[i+1].actual + 1) <= registros[i+2].total) {
			texto += "<label class='labelpagina' onClick=cargarUsuariospoa(1,"+(registros[i+1].actual+1)+");>Siguiente</label>";
		}

                texto += "</td></tr>";
                texto += "</table>";
                $('#bodymain').append(texto);

                // Data Table ---------------------------------------------------------------------------------------------------------
                  $(".data tr").mouseover(function() {$(this).addClass("over");}).mouseout(function() {$(this).removeClass("over");});
                  $(".data tr:even").addClass("alt");
                //---------------------------------------------------------------------------------------------------------

          }
    });


}
/*

function imprimir(){
   var var_recibo = $('#nrecibo').val();
   var nombre = $('#nombre').val();
   var doc = $('#dnis').val();
   var var_fecha = $('#fecha').val();
   var codigo=0;
   var texto = "";
   texto += "<div id='ocult' style='display:none; width:40%; float:left; text-align: center; font-size:0.5em;'>INSTITUTO DE EDUCACIÓN SUPERIOR PEDAGÓGICO PÚBLICO<br> TUPAC AMARU - TINTA";
   texto += "</div><div style='width:60%; font-size:1.5em; float:left;text-align: center;'> RECIBO DE CAJA</div><br><br>";
   texto += "<div style='width:70%; float:left; text-align: left;font-size:1em;clear:both;margin-top=50px;'>\n\
   <br>Nombres: "+nombre;
   texto += "<br>DNI:&nbsp;&nbsp;&nbsp;&nbsp; "+doc;
   texto += "<br>Fecha:&nbsp;&nbsp;&nbsp; "+var_fecha;
   texto += "</div><div style='width:30%; font-size:1em; float:left;'>RECIBO N°: "+var_recibo+"</div><br><br>";
   texto += "<table  align='center' style='border: solid 1px;'><tr><th style='width:62%'>Concepto</th><th style='width:12%'>Importe</th><th style='width:6%'>Cant.</th><th style='width:15%'>Total</th><th style='width:5%'> </th></tr>";
   
      $.ajax({
      type: "POST",
      url: "programs/anularReg.php",
      data: "cod="+codigo+"&rec="+var_recibo,
      success: function(datos){
          texto += "cccc"; 
            registros = eval(datos);
                for (var i=0; i < registros.length; i++) {
                        cantt=registros[i].importe*registros[i].cant;
                        texto += "<tr><td style='width:59%' align='center'>"+registros[i].tupa+"</td>";
                        texto += "<td style='width:12%'>"+registros[i].importe+"</td>";
                        texto += "<td style='width:6%'>"+registros[i].cant+"</td>";
                        texto += "<td style='width:18%'>"+cantt+"</td>";
                        texto += "</tr>";            
                }
                      $.ajax({
                      type: "POST",
                      url: "programs/buscatos.php",
                      data: "cod="+var_recibo,
                      success: function(datos){
                          
                            registro = eval(datos);
                            if(registro==null) registro=0;
                        texto += "<tr><th style='width:62%'>Total</th><th style='width:12%'> </th><th style='width:6%'> </th><th id='total' style='width:20%'>"+registro+"</th></tr>";
                    }
                   });
            }
   });
   
texto += "</table>";                                 
   //texto +="<table  id='tablas' style='width:100%'>";
   //texto += "</table><table><tr><th style='width:62%'>Total</th><th style='width:12%'> </th><th style='width:6%'> </th><th id='total' style='width:20%'></th></tr></table>   </div>";
    //      $('#datimp').append(texto);
  var ficha=document.getElementById('datimp');
  //var ventimp=window.open(' ','popimpr');
  //ventimp.document.write(ficha.innerHTML);
  //ventimp.document.close();
  //ventimp.print();
  //ventimp.close();
  javascript:$('#headmain').empty();$('#bodymain').empty();cargarContenido('#bodymain', 'programs/registro.php');
  }
*/
function cancel(x){
    if(x==0)
    var var_recibo = $('#nrecibo').val();
   else var_recibo=x;
    if (!confirm("Esta Seguro que desea cancelar Todos")) return;
    $.ajax({
      type: "POST",
      url: "programs/anularTodo.php",
      data: "cod="+var_recibo,
      success: function(){
          $('#tablas').empty();          
          $('#total').empty();          
          $('#total').append('0');
          if(x!=0){
              cargarReg();
          }
        }
   });
  }
function eliminarReg(codigo){
    if (!confirm("Esta Seguro que desea quitar el concepto?")) return;
    $.ajax({
      type: "POST",
      url: "programs/anularReg.php",
      data: "cod="+codigo,
      success: function(datos){
                alert("registros");
          $('#tablas').empty();          
            var texto = "";
                texto += "<table align='center' class='data'>";
                registros = eval(datos);
                alert(registros);
                if(registros==null){
                            $('#total').empty();
                            $('#total').append(0);
                }
                for (var i=0; i < registros.length; i++) {
                        cant=registros[i].importe*registros[i].cant;
                        texto += "<tr><td style='width:59%' align='center'>"+registros[i].tupa+" "+registros[i].obs+"</td>";
                        texto += "<td style='width:12%'>"+registros[i].importe+"</td>";
                        texto += "<td style='width:6%'>"+registros[i].cant+"</td>";
                        texto += "<td style='width:18%'>"+cant+"</td>";
                        texto += "<td style='width:5%'><img style='height:10px;' src='img/cancel.png' border=0 style='cursor:pointer;' id='concept' onClick=eliminarReg('"+registros[i].numero+"');></td></tr>";                       
                        
                }
                texto += "</table>";                
                    rec=$('#nrecibo').val();
                      $.ajax({
                      type: "POST",
                      url: "programs/buscatos.php",
                      data: "cod="+rec,
                      success: function(datos){
                          
                            registro = eval(datos);
                            if(registro==null) registro=0;
                            $('#total').empty();
                            $('#total').append(registro);
                    }
                   });

                
                $('#tablas').append(texto);
        
  }
   });


}


function addconceptos(){   
 var var_num= $('#num').val();
   var var_recibo = $('#nrecibo').val();
   var nombre = $('#nombre').val();
   var doc = $('#dnis').val();
   var var_fecha = $('#fecha').val();
   var var_tupa = $('#tupa').val();
   var var_monto = $('#monto').val();
   var cant = $('#cant').val();   
   var obs = $('#obs').val();   
   var num=parseInt(var_num)+1;
   var sum=parseFloat(var_monto)*parseInt(cant);
   //var tot = document.getElementById("total").value;
   //if(tot=='')tot=0;
   //alert(tot);
   //var total=parseFloat(tot)+sum;
   $.ajax({
      type: "POST",
      url: "programs/addpago.php",
      data: "numero="+var_num+"&nrecibo="+var_recibo+"&nombre="+nombre+"&doc="+doc+"&fecha="+var_fecha+"&monto="+var_monto+"&cant="+cant+"&tupa="+var_tupa+"&obs="+obs,
      success: function(){
        document.getElementById('tupa').value='';
        document.getElementById('monto').value=0;
        document.getElementById('cant').value=1;
        document.getElementById('obs').value='';
        document.getElementById('num').value=num;
        
          $.ajax({
                      type: "POST",
                      url: "programs/buscato.php",
                      data: "cod="+var_num,
                      success: function(datos){
                          
                            registro = eval(datos);
                            $('#total').empty();
                            $('#total').append(registro);
                  }
                   });

        $('#tablas').append("<tr style='width:100%'><td style='width:59%'>"+ var_tupa+" "+obs+"</td><td style='width:12%;text-align:right;'>" + var_monto + "</td><td style='width:6%;text-align:right;'>" + cant + "</td><td style='width:18%;text-align:right;'>" + var_monto*cant + "</td><td style='width:5%'><img style='height:10px;' src='img/cancel.png' border=0 style='cursor:pointer;' id='concept' onClick=eliminarReg('"+var_num+"');></td></tr>");
        
   }
   });

 
}

function guardaRegistro(){
   var var_num= $('#num').val();
   var var_recibo = $('#nrecibo').val();
   var nombre = $('#nombre').val();
   //nombre=nombre.toUpperCase;
   var doc = $('#dnis').val();
   var var_fecha = $('#fecha').val();
   var var_tupa = $('#tupa').val();
   var var_monto = $('#monto').val();
   var cant = $('#cant').val();
   var var_concepto = $('#obs').val();
   //var_concepto=var_concepto.toUpperCase;
  if (!confirm("Esta seguro que desea Guardar.?")) return;
    $.ajax({
      type: "POST",
      url: "programs/guardaRegistro.php",
      data:"numero="+var_num+"&nrecibo="+var_recibo+"&nombre="+nombre+"&doc="+doc+"&fecha="+var_fecha+"&monto="+var_monto+"&cant="+cant+"&tupa="+var_tupa+"&concepto="+var_concepto,
      success: function(datos){
          alert('.:: Guardado ::.');
      $('#headmain').empty();$('#bodymain').empty();cargarContenido('#headmain', 'programs/registro.php');      
      }
   });

}

function guardaUs(){
   var id= $('#id').val();
   var name = $('#name').val();
   var login = $('#login').val();
   var pass = $('#pass').val();
   alert(id+name+login+pass);
  if (!confirm("Esta seguro que desea Guardar.?")) return;
    $.ajax({
      type: "POST",
      url: "programs/guardaUs.php",
      data:"id="+id+"&names="+name+"&login="+login+"&passs="+pass,
      success: function(datos){
          alert('.:: Guardado ::.');
            
      }
   });

}

function delreg(reg){
    alert(reg);
   var var_num= $('#num').val();
   var var_recibo = $('#nrecibo').val();
   var nombre = $('#nombre').val();
   var var_fecha = $('#fecha').val();
   var var_tupa = $('#tupa').val();
   var var_monto = $('#monto').val();
   var var_concepto = $('#concepto').val();
  if (!confirm("Esta seguro que desea Guardar Cambios.?")) return;
    $.ajax({
      type: "POST",
      url: "programs/actualizarRegistro.php",
      data:"numero="+var_num+"&nrecibo="+var_recibo+"&nombre="+nombre+"&fecha="+var_fecha+"&monto="+var_monto+"&tupa="+var_tupa+"&concepto="+var_concepto,
      success: function(datos){
          alert('.:: Cambios Guardados Correctamente ::.');
cargarReg();
      }
   });

}

function actualizarRegistro(){
    
   var var_num= $('#num').val();
   var var_recibo = $('#nrecibo').val();
   var nombre = $('#nombre').val();
   //nombre=nombre.toUpperCase;
   var doc = $('#dnis').val();
   var var_fecha = $('#fecha').val();
   var var_tupa = $('#tupa').val();
   var var_monto = $('#monto').val();
   var cant = $('#cant').val();
   var var_concepto = $('#concepto').val();
   
  if (!confirm("Esta seguro que desea Guardar Cambios.?")) return;
    $.ajax({
      type: "POST",
      url: "programs/actualizarRegistro.php",
      data:"numero="+var_num+"&nrecibo="+var_recibo+"&nombre="+nombre+"&doc="+doc+"&fecha="+var_fecha+"&monto="+var_monto+"&cant="+cant+"&tupa="+var_tupa+"&concepto="+var_concepto,
      success: function(datos){
          alert('.:: Cambios Guardados Correctamente ::.');
    cargarReg(); 
      }
   });

}

function anularRegistro(){
  alert('si');
   var var_num= $('#num').val();
   var var_recibo = $('#nrecibo').val();
   var var_fecha = $('#fecha').val();
  if (!confirm("Esta seguro que desea Anular?")) return;
    $.ajax({
      type: "POST",
      url: "programs/anularRegistro.php",
      data:"numero="+var_num+"&nrecibo="+var_recibo+"&fecha="+var_fecha,
      success: function(datos){
          alert('.:: Guardado ::.');
               $('#headmain').empty();
               cargarContenido('#headmain', 'programs/registro.php');
               $('#bodymain').empty();
                
      }
   });

}

function getRegistro(flag){
    
    if (flag == 0){
        $('#headmain').empty();
        texto = "";
        texto += "<table align='center'>";
        texto +=  "<tr><td>&nbsp;</td></tr>";
        texto +=  "<tr><td class='tituloform' colspan='2'>Registro de Ingresos</td></tr>";
        texto +=  "<tr><td>Nro Recibo: Del </td><td><input id='txtCodigo' type='text' name='txtCodigo' size='10'/> Hasta <input id='txtPaterno' type='text' name='txtPaterno' size='15' onBlur=getRegistro(1); /></td></tr>";
        texto +=  "<tr><td>Nombres</td><td><input id='nombres' type='text' name='nombres' size='35' onBlur=getRegistro(1); /></td></tr>";
        texto +=  "<tr><td>Fecha: Desde </td><td><input id='fechai' type='date' name='fechai'/> Hasta <input id='fechaf' type='date' name='fechaf' size='15' onBlur=getRegistro(1); /></td></tr>";
        texto +=  "<tr><td>&nbsp;</td></tr>";
        texto += "</table>";
        $('#headmain').append(texto);
    }

    else{
    $.ajax({
      type: "POST",
      url: "programs/getRegistro.php",
      success: function(datos){
               $('#bodymain').empty();               
                texto = "";
                texto += "<table align='center' class='data'>";
                texto += "<tr><th>Nro de Registro</th><th>Nro de Recibo</th><th>Nombre y Apellidos</th><th>Fecha</th><th>Importe</th>\n\
                          <th>Clasificador</th><th>Tupa</th><th>Concepto</th><th>&nbsp;</th><th>&nbsp;</th></tr>";
                registros = eval(datos);
                for (var i=0; i < (registros.length-4)+4; i++) {
                        texto += "<tr><td style='width:50px' align='center'>"+registros[i].numero+"</td>";
                        texto += "<td style='padding-left:5px'>"+registros[i].recibo+"</td>";
                        texto += "<td style='padding-left:5px'>"+registros[i].nombres+"</td>";
                        texto += "<td style='padding-left:5px'>"+registros[i].fecha+"</td>";
                        texto += "<td style='padding-left:5px'>"+registros[i].importe+"</td>";
                        texto += "<td style='padding-left:5px'>"+registros[i].clasif+"</td>";
                        texto += "<td style='padding-left:5px'>"+registros[i].tupa+"</td>";
                        texto += "<td style='padding-left:5px'>"+registros[i].concepto+"</td>";
                        //texto += "<td align='center'><img style='height:15px;' src='img/Edit.png' border=0 style='cursor:pointer;' onClick=editarPersonal('"+registros[i].codigo+"');></td></tr>";
                        //style='cursor:pointer;'
                }
                texto += "<tr><th colspan='10' style='text-align:right'></th></tr>";
                texto += "</table>";
                texto += "<table>";
                texto += "</table>";
                $('#bodymain').append(texto);
      }
   });
    }
}



function newClass(){
$('#headmain').empty();
$('#bodymain').empty();
        texto = "";
        texto += "<table align='center'>";
        texto +=  "<tr><td class='tituloform' colspan='2'><h2>Ingresar Nuevas Clases</h2></td></tr>";
        texto += "<tr><th background:transparent'><img src='img/edit_add.gif' alt='Clase1' border=0, style='cursor:pointer' onclick=javascript:newclass1();></th>\n\
<th background:transparent'><img src='img/edit_add.gif' alt='Clase2' border=0, style='cursor:pointer' onclick=javascript:newclass2();></th>\n\
<th background:transparent'><img src='img/edit_add.gif' alt='Clase3' border=0, style='cursor:pointer' onclick=javascript:newclass3();></th>\n\
<th background:transparent'><img src='img/edit_add.gif' alt='Clase4' border=0, style='cursor:pointer' onclick=javascript:newclass4();></th>\n\
<th background:transparent'><img src='img/edit_add.gif' alt='Clase5' border=0, style='cursor:pointer' onclick=javascript:newclass5();></th>\n\
<th background:transparent'><img src='img/edit_add.gif' alt='Clase6' border=0, style='cursor:pointer' onclick=javascript:newclass6();></th>    </tr>";
        texto +=  "<tr><td>&nbsp;</td></tr>";
        texto += "</table>";
$('#headmain').append(texto);
}

function newclass1() {
    $('#bodymain').empty();
    cargarContenido("#bodymain","programs/newclass1.php");
}
function newclass2() {
    $('#bodymain').empty();
    cargarContenido("#bodymain","programs/newclass2.php");
}
function newclass3() {
    $('#bodymain').empty();
    cargarContenido("#bodymain","programs/newclass3.php");
}
function newclass4() {
    $('#bodymain').empty();
    cargarContenido("#bodymain","programs/newclass4.php");
}
function newclass5() {
    $('#bodymain').empty();
    cargarContenido("#bodymain","programs/newclass5.php");
}
function newclass6() {
    $('#bodymain').empty();
    cargarContenido("#bodymain","programs/newclass6.php");
}

function guardaclass1(){

   var flag = 0;
   var id= $('#id').val();
   var clase = $('#class').val();
   var nombre= $('#nombre').val();

   if (!confirm("Esta seguro que desea Guardar.?")) return;

    $.ajax({
      type: "POST",
      url: "programs/hayclass1.php",
      data:"flag="+flag+"&clase="+clase+"&nombre="+nombre,
      success: function(datos){
          
                var total= eval(datos);
                if(total!=0)
                   {
                        alert('.:: SysCaja ::.\n Clase o Nombre de Clasificador ya esta Registrado...');
                        cargaclass1();
                   }
                else{


    $.ajax({
      type: "POST",
      url: "programs/guardaclass1.php",
      data:"id="+id+"&clase="+clase+"&nombre="+nombre,
      success: function(){
alert('Guardado Correctamente');
          cargaclass1();}
   });
               }
          }
   });

}

function cargaclass1(){

    $.ajax({
            type: "POST",
            url: "programs/getclass1.php",
            success: function(datos){
                            
                $('#bodymain').empty();
                texto = "";
                texto += "<table>";
                texto +=  "<tr><br><h2>Clasificador Nivel 1</t1><hr></h2";
                texto += "<tr><th>N&deg;</th><th><div style='cursor:pointer' onclick=javascript:cargaclass1();>Clase</div></th><th><div style='cursor:pointer' onclick=javascript:cargarclass1();>Nombre</div></th><th>Edit</th><th>Del</th></tr>";
                registros = eval(datos);
                if(registros==-1){alert('No hay ningun registro\n Ingrese nuevo registro');alert(registros);}
                else if(registros!=-1){
                //alert(registros.length);
                for (var i=0; i < registros.length; i++) {
                        texto += "<tr><td align='center'>"+registros[i].id+"</td>";
                        texto += "<td>"+registros[i].clase+"</td>";
                        texto += "<td align='center'>"+registros[i].nombre+"</td>";
                        texto += "<td align='center'><img src='img/b_edit.png' alt='' border=0 style='cursor:pointer;' onClick=editarclass1('"+registros[i].id+"');></td>";
                        texto += "<td align='center'><img src='img/b_drop.png' alt='' border=0 style='cursor:pointer;' onClick=eliminarclass1('"+registros[i].id+"');></td></tr>";
                }
                }
                texto += "</table>";
                $('#bodymain').append(texto);

          }
    });
}
function eliminarclass1(codigo){
    if (!confirm("Esta Seguro que desea Eliminar?")) return;

    $.ajax({
      type: "POST",
      url: "programs/eliminarclass1.php",
      data: "codigo="+codigo,
      success: function(){alert('Eliminado correctamente...');cargaclass1();}
   });


}

function guardaclass2(){

   var flag = 0;
   var id= $('#id').val();
   var clase = $('#class').val();
   var nombre= $('#nombre').val();

   if (!confirm("Esta seguro que desea Guardar.?")) return;

    $.ajax({
      type: "POST",
      url: "programs/hayclass2.php",
      data:"flag="+flag+"&clase="+clase+"&nombre="+nombre,
      success: function(datos){
          
                var total= eval(datos);
                if(total!=0)
                   {
                        alert('.:: SysCaja ::.\n Clase o Nombre de Clasificador ya esta Registrado...');
                        cargaclass2();
                   }
                else{


    $.ajax({
      type: "POST",
      url: "programs/guardaclass2.php",
      data:"id="+id+"&clase="+clase+"&nombre="+nombre,
      success: function(){
alert('Guardado Correctamente');
          cargaclass2();}
   });
               }
          }
   });

}

function cargaclass2(){

    $.ajax({
            type: "POST",
            url: "programs/getclass2.php",
            success: function(datos){
                            
                $('#bodymain').empty();
                texto = "";
                texto += "<table>";
                texto +=  "<tr><br><h2>Clasificador Nivel 1</t1><hr></h2";
                texto += "<tr><th>N&deg;</th><th><div style='cursor:pointer' onclick=javascript:cargaclass1();>Clase</div></th><th><div style='cursor:pointer' onclick=javascript:cargarclass1();>Nombre</div></th><th>Edit</th><th>Del</th></tr>";
                registros = eval(datos);
                if(registros==-1){alert('No hay ningun registro\n Ingrese nuevo registro');alert(registros);}
                else if(registros!=-1){
                //alert(registros.length);
                for (var i=0; i < registros.length; i++) {
                        texto += "<tr><td align='center'>"+registros[i].id+"</td>";
                        texto += "<td>"+registros[i].clase+"</td>";
                        texto += "<td align='center'>"+registros[i].nombre+"</td>";
                        texto += "<td align='center'><img src='img/b_edit.png' alt='' border=0 style='cursor:pointer;' onClick=editarclass1('"+registros[i].id+"');></td>";
                        texto += "<td align='center'><img src='img/b_drop.png' alt='' border=0 style='cursor:pointer;' onClick=eliminarclass1('"+registros[i].id+"');></td></tr>";
                }
                }
                texto += "</table>";
                $('#bodymain').append(texto);

          }
    });
}
function eliminarclass2(codigo){
    if (!confirm("Esta Seguro que desea Eliminar?")) return;

    $.ajax({
      type: "POST",
      url: "programs/eliminarclass2.php",
      data: "codigo="+codigo,
      success: function(){alert('Eliminado correctamente...');cargaclass2();}
   });


}


function cargaHora(idSelectOrigen)
{
	var selectOrigen=document.getElementById(idSelectOrigen);
	var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
        document.getElementById('hour').value=opcionSeleccionada;

}

function reportIng(flag){
    if (flag == 0){
        $('#headmain').empty();
        $('#bodymain').empty();
        texto = "<br>";
        texto += "<div class='contact_form' name='contact_form'><ul>";
        texto +=  "<h3>Reporte de Ingresos Anual</h3><br>";
        texto +=  "A&nacute;o: <select name='anio' id='anio'>";
        texto +=  "<option value=''>Elige el A&nacute;o</option>";
        texto +=  "<option value='2018'>2018</option>";
        texto +=  "<option value='2019'>2019</option>";
        texto +=  "<option value='2020' selected>2020</option>";
        texto +=  "<option value='2021'>2021</option>";
        texto +=  "<option value='2022'>2022</option>";
        texto +=  "<option value='2023'>2023</option>";
        texto +=  "<option value='2024'>2025</option>";
        texto +=  "<option value='2025'>2025</option>";
        texto +=  "</select>";
        texto +=  "</select> <button class='trans' type='submit'><img src='img/save.png' title='VER' onClick=reportIng(1);></button>";
        $('#headmain').append(texto);
}
    if (flag == 1){       
        elemento = document.getElementById("anio");
        var dato = elemento.options[elemento.selectedIndex].value;
        window.open("reports/anual.php?dat="+dato+"");
    }
}

function reportResBol(flag){
    if (flag == 0){
        
    var date=new Date();
    var d=date.getDate();
    var m=date.getMonth()+1;
    var a=date.getFullYear();
    var dl=date.toLocaleString();
    var fechahoy=a+"-"+m+"-"+d;
        $('#headmain').empty();
        $('#bodymain').empty();
        texto = "";
        texto += "<div class='contact_form' name='contact_form'><ul>";
        texto +=  "<h2>Resumen de Ingresos por Nro de Boletas</h2><br>";
        texto +=  "Desde<input id='desde' type='number' name='desde' value='1' size='5'/>";
        texto +=  "Hasta<input id='hasta' type='number' name='hasta' value='50' size='5'/>";
        texto +=  "<button class='trans' type='submit'><img src='img/save.png' title='VER' onClick=reportResBol(1);></button>";
        $('#headmain').append(texto);
}
    if (flag == 1){       
        var var_desde = $('#desde').val();
        var var_hasta = $('#hasta').val();
        var dato=var_desde+','+var_hasta;
        window.open("reports/resumenbol.php?dat="+dato+"");
    }
}


function reportRes(flag){
    if (flag == 0){
        
    var date=new Date();
    var d=date.getDate();
    var m=date.getMonth()+1;
    var a=date.getFullYear();
    var dl=date.toLocaleString();
    var fechahoy=a+"-"+m+"-"+d;
        $('#headmain').empty();
        $('#bodymain').empty();
        texto = "<br>";
        texto += "<div class='contact_form' name='contact_form'><ul>";
        texto +=  "<h3>Reporte de Ingresos Mensual</h3><br>";
        texto +=  "Desde: <input id='desde' type='date' name='desde' step='2014/03/12' value='' size='15'/>";
        texto +=  "Hasta: <input id='hasta' type='date' name='hasta' step='2014/03/12' value='' size='15'/>";
        texto +=  "<button class='trans' type='submit'><img src='img/save.png' title='VER' onClick=reportRes(1);></button>";
        $('#headmain').append(texto);
}
    if (flag == 1){       
        var var_desde = $('#desde').val();
        var var_hasta = $('#hasta').val();
        var dato=var_desde+var_hasta;
        window.open("Tablabien/ex.php?dat="+dato+"");
    }
}
function reportBoleta(flag){
    if (flag == 0){
        
    var date=new Date();
    var d=date.getDate();
    var m=date.getMonth()+1;
    var a=date.getFullYear();
    var dl=date.toLocaleString();
    var fechahoy=a+"-"+m+"-"+d;
        $('#headmain').empty();
        $('#bodymain').empty();
        texto = "<br>";
        texto += "<div class='contact_form' name='contact_form'><ul>";
        texto +=  "<h3>Reporte de Ingresos por rango de Boletas</h3><br>";
        texto +=  "Desde: <input id='desde' type='text' name='desde' step='000001' value='' size='15'/>";
        texto +=  "Hasta: <input id='hasta' type='text' name='hasta' step='000023' value='' size='15'/>";
        texto +=  "<button class='trans' type='submit'><img src='img/save.png' title='VER' onClick=reportBoleta(1);></button>";
        $('#headmain').append(texto);
}
    if (flag == 1){       
        var var_desde = $('#desde').val();
        var var_hasta = $('#hasta').val();
        var dato=var_desde+var_hasta;
        window.open("Tablabien/exbol.php?dat="+dato+"");
    }
}

function BuscarBoleta(flag){
    $('#bodymain').empty();
    var date=new Date();
    var d=date.getDate();
    var m=date.getMonth()+1;
    var a=date.getFullYear();
    var dl=date.toLocaleString();
    var fechahoy=a+"-"+m+"-"+d;

    if (flag == 0){
        $('#headmain').empty();
        $('#bodymain').empty();
        texto = "";
        texto += "<div class='contact_form' name='contact_form'><ul><br>";
        texto +=  "<h2>Buscar Por Numero de Boleta</h2><br>";
        texto +=  "Nro de Boleta <input id='boleta' type='number' name='boleta' size='15' onBlur=BuscarBoleta(1); />";
        texto +=  "<button class='trans' type='submit'><img src='img/menu/buscar.png' title='Buscar' onClick=BuscarBoleta(1);></button>";
        texto +=  "<img src='img/menu/agregar.png' title='Nuevo' border=0, style='cursor:pointer' onclick='javascript:$('#headmain').empty();$('#bodymain').empty();cargarContenido('#headmain', 'programs/registro.php')'>";
        $('#headmain').append(texto);
    }
    if (flag == 1){
    var boleta = $('#boleta').val();
    if(boleta == ''){
        return;
    }

    pagina = 1;
    $.ajax({
            type: "POST",
            url: "programs/buscarbol.php",
            data: "pagina="+pagina+"&boleta="+boleta,
            success: function(datos){
                $('#bodymain').empty();
                texto = "";
                texto += "<table align='center' class='data'>";
                texto += "<tr><th>N&deg;</th><th>Nombres</th><th>Importe</th><th>Clasificador</th><th>TUPA</th><th>Concepto</th><th>Fecha</th><th>Edit</th><th>Del</th></tr>";
                registros = eval(datos);
                if(registros==0){alert('El Nro de Recibo\nNo Se Registro nunca o Fue Anulada');}
                for (var i=0; i < registros.length; i++) {
                    var recibo=registros[i].recibo;
                    var nombres=registros[i].nombres;
                    var importe=registros[i].importe;
                    var clasif=registros[i].clasif;
                    var tupa=registros[i].tupa;
                    var concepto=registros[i].concepto;
                    var fecha=registros[i].fecha;
                    var num =registros[i].num;
                        texto += "<tr><td align='center'>"+recibo+"</td>";
                        texto += "<td>"+nombres+"</td>";
                        texto += "<td>"+importe+"</td>";
                        texto += "<td>"+clasif+"</td>";
                        texto += "<td>"+tupa+"</td>";
                        texto += "<td>"+concepto+"</td>";
                        texto += "<td>"+fecha+"</td>";
                        texto += "<td align='center'><img src='img/edit.png' alt='' border=0 style='cursor:pointer;width:30px' onClick=editarReg('"+num+"');></td>";
                        texto += "<td align='center'><img src='img/del.png' alt='' border=0 style='cursor:pointer; width:30px' onClick=eliminarReg('"+num+"');></td></tr>";
                }
                texto += "<tr><th colspan='10' style='text-align:right'></th></tr>";
                texto += "</table>";
                texto += "<table>";
                texto += "<tr><td colspan='7' align='center'>";

                texto += "</td></tr>";
                texto += "</table>";
                $('#bodymain').append(texto);

          }
    });
    }
}

function BuscarFecha(flag){
    $('#bodymain').empty();
    var date=new Date();
    var d=date.getDate();
    var m=date.getMonth()+1;
    var a=date.getFullYear();
    var dl=date.toLocaleString();
    var fechahoy=a+"-"+m+"-"+d;

    if (flag == 0){
        $('#headmain').empty();
        $('#bodymain').empty();
        texto = "";
        texto += "<div class='contact_form' name='contact_form'><ul><br>";
        texto +=  "<h2>Buscar Por Fecha de Registro</h2><br>";
        texto +=  "Fecha de Registro <input id='fecha' type='date' name='fecha' size='15' onBlur=BuscarFecha(1); />";
        texto +=  "<button class='trans' type='submit'><img src='img/menu/buscar.png' title='Buscar' onClick=BuscarFecha(1);></button>";
        texto +=  "<img src='img/menu/agregar.png' title='Nuevo' border=0, style='cursor:pointer' onclick=javascript:newBoleta();>";
        $('#headmain').append(texto);
    }
    if (flag == 1){
    fecha = $('#fecha').val();
    alert(fecha);
    if(fecha == ''){
        return;
    }

    pagina = 1;
    $.ajax({
            type: "POST",
            url: "programs/buscarfech.php",
            data: "pagina="+pagina+"&fecha="+fecha,
            success: function(datos){
                $('#bodymain').empty();
                texto = "";
                texto += "<table align='center' class='data'>";
                texto += "<tr><th>N&deg;</th><th>Nombres</th><th>Importe</th><th>Clasificador</th><th>TUPA</th><th>Concepto</th><th>Fecha</th><th>Edit</th><th>Del</th></tr>";
                registros = eval(datos);
                if(registros==0){alert('En esta Fecha no fue registrado ningun boleto');}
                for (var i=0; i < registros.length; i++) {
                    var recibo=registros[i].recibo;
                    var nombres=registros[i].nombres;
                    var importe=registros[i].importe;
                    var clasif=registros[i].clasif;
                    var tupa=registros[i].tupa;
                    var concepto=registros[i].concepto;
                    var fecha=registros[i].fecha;
                    var num =registros[i].num;
                        texto += "<tr><td align='center'>"+recibo+"</td>";
                        texto += "<td>"+nombres+"</td>";
                        texto += "<td>"+importe+"</td>";
                        texto += "<td>"+clasif+"</td>";
                        texto += "<td>"+tupa+"</td>";
                        texto += "<td>"+concepto+"</td>";
                        texto += "<td>"+fecha+"</td>";
                        texto += "<td align='center'><img src='img/edit.png' alt='' border=0 style='cursor:pointer;width:30px' onClick=editarReg('"+num+"');></td>";
                        texto += "<td align='center'><img src='img/del.png' alt='' border=0 style='cursor:pointer; width:30px' onClick=eliminarReg('"+num+"');></td></tr>";
                }
                texto += "<tr><th colspan='10' style='text-align:right'></th></tr>";
                texto += "</table>";
                texto += "<table>";
                texto += "<tr><td colspan='7' align='center'>";

                texto += "</td></tr>";
                texto += "</table>";
                $('#bodymain').append(texto);

          }
    });
    }
}


function BuscarNombre(flag){
    $('#bodymain').empty();
    var date=new Date();
    var d=date.getDate();
    var m=date.getMonth()+1;
    var a=date.getFullYear();
    var dl=date.toLocaleString();
    var fechahoy=a+"-"+m+"-"+d;

    if (flag == 0){
        $('#headmain').empty();
        $('#bodymain').empty();
        texto = "";
        texto += "<div class='contact_form' name='contact_form'><ul><br>";
        texto +=  "<h2>Buscar Por Nombres</h2><br>";
        texto +=  "Nombres y Apellidos <input id='nombre' type='text' name='nombre' size='35' onBlur=BuscarNombre(1); />";
        texto +=  "<button class='trans' type='submit'><img src='img/menu/buscar.png' title='Buscar' onClick=BuscarNombre(1);></button>";
        texto +=  "<img src='img/menu/agregar.png' title='Nuevo' border=0, style='cursor:pointer' onclick=javascript:newBoleta();>";
        $('#headmain').append(texto);
    }
    if (flag == 1){
    nombre = $('#nombre').val();
    alert(nombre);
    if(nombre == ''){
        return;
    }

    pagina = 1;
    $.ajax({
            type: "POST",
            url: "programs/buscarnom.php",
            data: "pagina="+pagina+"&nombre="+nombre,
            success: function(datos){
                $('#bodymain').empty();
                texto = "";
                texto += "<table align='center' class='data'>";
                texto += "<tr><th>N&deg;</th><th>Nombres</th><th>Importe</th><th>Clasificador</th><th>TUPA</th><th>Concepto</th><th>Fecha</th><th>Edit</th><th>Del</th></tr>";
                registros = eval(datos);
                if(registros==0){alert('En el Registro no se encuantra Ningun nombre parecido al ingresado');}
                for (var i=0; i < registros.length; i++) {
                    var recibo=registros[i].recibo;
                    var nombres=registros[i].nombres;
                    var importe=registros[i].importe;
                    var clasif=registros[i].clasif;
                    var tupa=registros[i].tupa;
                    var concepto=registros[i].concepto;
                    var fecha=registros[i].fecha;
                    var num =registros[i].num;
                        texto += "<tr><td align='center'>"+recibo+"</td>";
                        texto += "<td>"+nombres+"</td>";
                        texto += "<td>"+importe+"</td>";
                        texto += "<td>"+clasif+"</td>";
                        texto += "<td>"+tupa+"</td>";
                        texto += "<td>"+concepto+"</td>";
                        texto += "<td>"+fecha+"</td>";
                        texto += "<td align='center'><img src='img/edit.png' alt='' border=0 style='cursor:pointer;width:30px' onClick=editarReg('"+num+"');></td>";
                        texto += "<td align='center'><img src='img/del.png' alt='' border=0 style='cursor:pointer; width:30px' onClick=eliminarReg('"+num+"');></td></tr>";
                }
                texto += "<tr><th colspan='10' style='text-align:right'></th></tr>";
                texto += "</table>";
                texto += "<table>";
                texto += "<tr><td colspan='7' align='center'>";

                texto += "</td></tr>";
                texto += "</table>";
                $('#bodymain').append(texto);

          }
    });
    }
}


//-------------------------------------------------------------------------------------------------------------------------------

//-------------------------------------------------------------------------------------------------------------------------------

function editarReg(codigo){

    if (!confirm("Esta Seguro que desea Editar?")) return;

    $('#headmain').empty();
    $('#bodymain').empty();
    cargarContenido("#headmain","programs/editarReg.php?cod="+codigo+"");
}
function dniload(){var nom = $('#nombre').val();  
        $.ajax({
      type: 'POST',
      url: 'programs/buscadni.php',
      data:'nom='+nom,
      success: function(datos){
                registros = eval(datos);
  document.getElementById('dnis').value=registros;
  }
   });
  } 
function totalload(){
    
    var cant = $('#cant').val();  var monto = $('#monto').val();  
           document.getElementById('total').value=cant*monto;
  }

function cargarReg(){
       $.ajax({
            type: "POST",
            url: "programs/getRegistro1.php",
            success: function(datos){
                $('#headmain').empty();
            $('#bodymain').empty();
            texto = "";
                texto += "<br><h3>Registro de Ingresos</h3><table align='center' class='data'>";
                texto += "<tr><th>Fecha</th><th>Nro de Recibo</th><th>Clasificador</th><th>Detalle de pagos</th><th>Nombre y Apellidos</th><th>Total</th>\n\
                          <th>&nbsp;</th><th>&nbsp;</th></tr>";
                registros = eval(datos);
                for (var i=0; i < registros.length; i++) {
                    
                        texto += "<tr>";
                        texto += "<td style='padding-left:5px'>"+registros[i].fecha+"</td>";
                        texto += "<td style='padding-left:5px'>"+registros[i].recibo+"</td>";
                        texto += "<td style='padding-left:5px'>"+registros[i].clasif+"</td>";
                        texto += "<td style='padding-left:5px'>"+registros[i].todo+"</td>";
                        texto += "<td style='padding-left:5px'>"+registros[i].nombres+"</td>";
                        texto += "<td style='padding-left:5px'>"+registros[i].total+"</td>";
                        //texto += "<td style='padding- left:5px'>"+todo+"</td>";
                        //texto += "<td align='center'><img style='height:15px;' src='img/Edit.png' border=0 style='cursor:pointer;' onClick=editarReg('"+registros[i].numero+"');></td>";
                        texto += "<td align='center'><img style='height:15px;' src='img/del.png' border=0 style='cursor:pointer;' onClick=cancel('"+registros[i].recibo+"');></td></tr>";
                        //style='cursor:pointer;'
                }
                texto += "<tr><th colspan='10' style='text-align:right'></th></tr>";
                texto += "</table>";
                texto += "<table>";
                texto += "</table>";
                $('#bodymain').append(texto);

          }
    });


}

function anularRecibo(var_recibo){
   //var var_recibo = $('#nrecibo').val();
   //var fecha = $('#fecha').val();
   var ms="Esta seguro que desea Anular el recibo Nro "+var_recibo+" ? ";
  if (!confirm(ms)) return;
    $.ajax({
      type: "POST",
      url: "programs/anularRecibo.php",
      data:"nrecibo="+var_recibo,
      success: function(datos){
          registros = eval(datos);
          
          //alert('.:: Recibo Anulado Correctamente ::.');
          /*alert(registros);
          if(registros==1)
          alert('.:: Recibo Anulado Correctamente ::.');
      
          if(registros==0)
          alert('.:: El Recibo aun no esta registrado ::.');*/
               $('#headmain').empty();               
               $('#bodymain').empty();
               cargarContenido('#bodymain', 'programs/registro.php');
                
      }
   });

}

function buscarper(){
        var name=$('#form1').val();
    //alert(name);
        location.href="inicio.php?"+"&name="+name;
}
function solobuscar(){
    
     //   var name=$('#sb').val();
        location.href="../personal/personal_portada.php?sb=0";
     $('#sb').val('0'); 
}
function home(){
    
     //   var name=$('#sb').val();
        location.href="../personal/personal_portada.php?sb=1";
     $('#sb').val('1'); 
}

function imprimir(recibo){
    
        $.ajax({
      type: "POST",
      url: "programs/getdata.php",
      data: "rec="+recibo,
      success: function(datos){
          
            registross = eval(datos);
            
      $.ajax({
      type: "POST",
      url: "programs/getregs.php",
      data: "rec="+recibo,
      success: function(datos){
            registros = eval(datos);
             
          $.ajax({
          type: "POST",
          url: "programs/buscatos.php",
          data: "rec="+recibo,
          success: function(datosa){
                          
                registrod = eval(datosa); 
                  var texto="<div style='height: 25.67cm; background: url(../img/logo1.png)  no-repeat;'>";
                  texto += "<div style='height: 8.2cm'><div style='width:40%; float:left; text-align: center; font-size:0.5em;'>ESCUELA DE EDUCACIÓN SUPERIOR PEDAGÓGICA PÚBLICA<br> TUPAC AMARU - TINTA</div>";
                  texto += "<div style='width:60%; font-size:1.5em; float:left;text-align: center;'> RECIBO DE CAJA</div><br><br>";
                  texto += "<div style='width:70%; float:left; text-align: left;font-size:1em;clear:both;margin-top=50px;'>\n\
                  <br>Nombres: "+registross[0].nombres;
                  texto += "<br>DNI:&nbsp;&nbsp;&nbsp;&nbsp; "+registross[0].dni;
                  texto += "<br>Fecha:&nbsp;&nbsp;&nbsp; "+registross[0].fecha;
                  texto += "</div><div style='width:30%; font-size:1em; float:left;'>RECIBO N°: "+recibo+"</div><br><br>";
                  texto += "<table  align='center'><tr><th style='width:59%;border-bottom: solid 1px;'>Concepto</th><th style='width:15%;border-bottom: solid 1px;border-left: solid 1px;'>Importe</th><th style='width:6%;border-bottom: solid 1px;border-left: solid 1px;'>Cant.</th><th style='width:20%;border-bottom: solid 1px;border-left: solid 1px;'>Total</th></tr>";

                    for (var i=0; i < registros.length; i++) {
                    cantt=registros[i].importe*registros[i].cant;
                    texto += "<tr><td style='width:59%;' align='left'>"+registros[i].tupa+"</td>";
                    texto += "<td style='width:12%;border-left: solid 1px;' align='right'>"+registros[i].importe+"</td>";
                    texto += "<td style='width:6%;border-left: solid 1px;' align='right'>"+registros[i].cant+"</td>";
                    texto += "<td style='width:18%;border-left: solid 1px;' align='right'>"+cantt+"</td>";
                    texto += "</tr>";            
                     }
                     
                    if(registrod==null) registrod=0;
                    texto += "<tr><td style='width:80%;border-top: solid 1px;'>Total</td><td style='border-top: solid 1px;'></td><td style='border-top: solid 1px;'></td><td id='total' style='width:20%;border-top: solid 1px;border-left: solid 1px;' align='right'>"+registrod+"</td></tr>";
                    texto += "</table></div>";    
                    
                        
                  texto += "<div style='height: 9.2cm'><hr><br><div style='width:40%; float:left; text-align: center; font-size:0.5em;'>ESCUELA DE EDUCACIÓN SUPERIOR PEDAGÓGICA PÚBLICA<br> TUPAC AMARU - TINTA</div>";
                  texto += "<div style='width:60%; font-size:1.5em; float:left;text-align: center;'> RECIBO DE CAJA</div><br><br>";
                  texto += "<div style='width:70%; float:left; text-align: left;font-size:1em;clear:both;margin-top=50px;'>\n\
                  <br>Nombres: "+registross[0].nombres;
                  texto += "<br>DNI:&nbsp;&nbsp;&nbsp;&nbsp; "+registross[0].dni;
                  texto += "<br>Fecha:&nbsp;&nbsp;&nbsp; "+registross[0].fecha;
                  texto += "</div><div style='width:30%; font-size:1em; float:left;'>RECIBO N°: "+recibo+"</div><br><br>";
                  texto += "<table  align='center'><tr><th style='width:59%;border-bottom: solid 1px;'>Concepto</th><th style='width:15%;border-bottom: solid 1px;border-left: solid 1px;'>Importe</th><th style='width:6%;border-bottom: solid 1px;border-left: solid 1px;'>Cant.</th><th style='width:20%;border-bottom: solid 1px;border-left: solid 1px;'>Total</th></tr>";

                    for (var i=0; i < registros.length; i++) {
                    cantt=registros[i].importe*registros[i].cant;
                    texto += "<tr><td style='width:59%;' align='left'>"+registros[i].tupa+"</td>";
                    texto += "<td style='width:12%;border-left: solid 1px;' align='right'>"+registros[i].importe+"</td>";
                    texto += "<td style='width:6%;border-left: solid 1px;' align='right'>"+registros[i].cant+"</td>";
                    texto += "<td style='width:18%;border-left: solid 1px;' align='right'>"+cantt+"</td>";
                    texto += "</tr>";            
                     }
                     
                    if(registrod==null) registrod=0;
                    texto += "<tr><td style='width:80%;border-top: solid 1px;'>Total</td><td style='border-top: solid 1px;'></td><td style='border-top: solid 1px;'></td><td id='total' style='width:20%;border-top: solid 1px;border-left: solid 1px;' align='right'>"+registrod+"</td></tr>";
                    texto += "</table></div>";  
                    
                        
                  texto += "<div style='height: 8.2cm'><hr><br><div style='width:40%; float:left; text-align: center; font-size:0.5em;'>ESCUELA DE EDUCACIÓN SUPERIOR PEDAGÓGICA PÚBLICA<br> TUPAC AMARU - TINTA</div>";
                  texto += "<div style='width:60%; font-size:1.5em; float:left;text-align: center;'> RECIBO DE CAJA</div><br><br>";
                  texto += "<div style='width:70%; float:left; text-align: left;font-size:1em;clear:both;margin-top=50px;'>\n\
                  <br>Nombres: "+registross[0].nombres;
                  texto += "<br>DNI:&nbsp;&nbsp;&nbsp;&nbsp; "+registross[0].dni;
                  texto += "<br>Fecha:&nbsp;&nbsp;&nbsp; "+registross[0].fecha;
                  texto += "</div><div style='width:30%; font-size:1em; float:left;'>RECIBO N°: "+recibo+"</div><br><br>";
                  texto += "<table  align='center'><tr><th style='width:59%;border-bottom: solid 1px;'>Concepto</th><th style='width:15%;border-bottom: solid 1px;border-left: solid 1px;'>Importe</th><th style='width:6%;border-bottom: solid 1px;border-left: solid 1px;'>Cant.</th><th style='width:20%;border-bottom: solid 1px;border-left: solid 1px;'>Total</th></tr>";

                    for (var i=0; i < registros.length; i++) {
                    cantt=registros[i].importe*registros[i].cant;
                    texto += "<tr><td style='width:59%;' align='left'>"+registros[i].tupa+"</td>";
                    texto += "<td style='width:12%;border-left: solid 1px;' align='right'>"+registros[i].importe+"</td>";
                    texto += "<td style='width:6%;border-left: solid 1px;' align='right'>"+registros[i].cant+"</td>";
                    texto += "<td style='width:18%;border-left: solid 1px;' align='right'>"+cantt+"</td>";
                    texto += "</tr>";            
                     }
                     
                    if(registrod==null) registrod=0;
                    texto += "<tr><td style='width:80%;border-top: solid 1px;'>Total</td><td style='border-top: solid 1px;'></td><td style='border-top: solid 1px;'></td><td id='total' style='width:20%;border-top: solid 1px;border-left: solid 1px;' align='right'>"+registrod+"</td></tr>";
                    texto += "</table></div>";  
                   texto += "</div>";
                   
                   $('#datimp').append(texto);
                  var ficha=document.getElementById('datimp');
                  
                 var ventimp=window.open(' ','popimpr');
                 ventimp.document.write(ficha.innerHTML);
                  ventimp.document.close();
                 ventimp.print();
                  ventimp.close();
                  javascript:$('#headmain').empty();$('#bodymain').empty();cargarContenido('#bodymain', 'programs/registro.php');
                        
                    }
                   });
            }
   });
            
          }
   });
   /****/
/****/
  }
 