<?php include 'seguridad.php'; 

//$names=$_GET['name'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
        <title>.::Sistema de Ingresos EESPPTA::.</title>
        <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1? />
	<link rel="stylesheet" href="css/style.css" type="text/css" /><style type="text/css">._css3m{display:none}</style>
        <link rel="stylesheet" href="css/foundation.css" />
	<link rel="stylesheet" media="screen" href="css/styles.css" >
	<link rel="stylesheet" media="screen" href="css/mystyle.css" >
	<!-- End css3menu.com HEAD section -->
      <script type="text/javascript" src="js/funciones.js"></script>      
      <script src="js/jquery.js"></script>
	
</head>
<body style="background: rgba(227, 249, 152, 0.8) url(img/fond.png) no-repeat;">

<div class="row">
        <div style="float:left;"><img style="height:60px; width:60px; text-shadow:#90440D 1px 1px 1px;" src="img/admin.png" alt="User" /></div>
        <div style="text-align: center; font-size: 11px; "> <h2>
                Sistema de Ingresos del IESPP Túpac Amaru - Tinta</h2>.::SGI::. Bienvenido Usuario: <?php echo $_SESSION['nameuser']; ?><a href="closesession.php">
                <span style="color:red; line-height: 10px; float: right">Salir</span></a></div>
        <div id="menu" class="large-12 columns">
        <ul id="css3menu1" class="topmenu">
            <!--<li class="topmenu"><a href="javascript:$('#headmain').empty();$('#bodymain').empty();cargarContenido('#headmain', 'programs/newUs.php')" 
                                   style="height:32px;line-height:32px;"><span><img src="img/menu/agregar.png" alt=""/>Nuevo Usuario</span></a></li>-->
            <li class="topmenu"><a href="javascript:$('#headmain').empty();$('#bodymain').empty();cargarContenido('#bodymain', 'programs/registro.php')" 
                                   style="height:32px;line-height:32px;"><span><img src="img/menu/agregar.png" alt=""/>Nuevo Registro</span></a></li>
            <li class="topmenu"><a href="search.php"  onclick=cargarReg(); style="height:32px;line-height:32px;"><span><img src="img/menu/act.png" alt="">Cargar</a></li>
          
            <li class="topmenu"><a href="#" onclick=reportRes(0); style="height:32px;line-height:32px;"><span><img src="img/menu/mensual.png" alt="">Reporte Mensual</a></li>
            <li class="topmenu"><a href="#" onclick=reportBoleta(0); style="height:32px;line-height:32px;"><span><img src="img/menu/mensual.png" alt="">Reporte por boletas</a></li>
            <li class="topmenu"><a href="#"  onclick=reportIng(0); style="height:32px;line-height:32px;"><span><img src="img/menu/repor.png" alt="">Resumen Anual</a></li>
            <li class="topmenu"><a href="manual.pdf" target="_black" style="height:32px;line-height:32px;"><span><img src="img/help.png" alt="">Ayuda</a></li>
            
        </ul>
        </div>    
        <br>
    <div class="large-12 columns">
       <div class="wrapper row">            
		<div class="col-lg-1"></div>
		<div class="col-lg-4 col-md-4">
                    
        <br>
        <br>
                    <div class="input-group">
                        <div class="form-outline" style="width: 80% !important ">
                          <input type="search" id="form1" name="form1" class="form-control" />
                        </div>
                        <button type="button" onclick="buscarper();" class="btn btn-primary">
                            <i class="zmdi zmdi-search" style="font-size: 24px !important; "></i>
                        </button> 
                      </div> 
		</div>
		<div class="col-lg-4">
       
		<div class="col-lg-2">
                    <input id="sb" style=" display: none " value="<?php echo $sb;?>">
                    <a onclick="solobuscar();"><i class='fas fa-search' style='font-size:30px;color:blue;'></i></a>
                    <a onclick="home();"><i class='fas fa-home' style='font-size:30px;color:blue;'></i></a>
                 
		</div>
               <!-- <div class="col-lg-2"><button class="btn btn-inf" data-toggle="modal" data-target="#miModal" style="background: #4787BE; color:white;"><a ><i class='fas fa-plus' style='font-size:30px;color:white;padding: 2px'>  </i>Nuevo trámite</a></button> -->
		</div>
		<div class="col-lg-1"></div>		 
            <hr>
            
            
	
            
            
    <div class="container">
    
    <hr>
    <?php
    
include('programs/paginator.class.php'); 
include('connections/cn_on.php');
    if($names=='')
        $namess=" ";//oficina convenios 19-25, 26 llamar, anexos 1674,4031,1135,1622
    else $namess=" and p.nombres like '%$names%' or p.Doc like '%$names%' ";
        $pages = new Paginator;
        $pages->default_ipp = 15;
       
        $sql_forms =$db->prepare("select m.idMov, m.nroRecibo, p.nombres AS nombres, m.tipo,m.cantidad, m.fecha, SUM(m.importe) as importe, t.nombreTupa as tupas, m.concepto, c.clase as clasif from movimiento m, persona p, tupa t, clase6 c  where  m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id ". $namess ." group by m.nroRecibo order by m.idMov desc limit 100");        
        $sql_forms->execute();
        $pages->items_total = $sql_forms->rowCount();
        $pages->mid_range = 9;
        $pages->paginate();  
                  
        //$result =  $db->prepare("SELECT d.idUsuario as idus, d.idDocumento as id,if(d.tipo<=100,'FUT',t.nameTipo) as tipo,nro,asunto, folios,fundamentacion,fechaMov as fecha,concat(p.nombres,' ',p.apellidos) as name,dni,celular,m.fechaop,reg,email, operacion  FROM documento d LEFT JOIN tipotram t on t.idTipo=d.tipo inner join usuario u on u.idUsuario=d.idUsuario inner join persona p on p.idPersona=u.idPersona inner join movimiento m on m.idDocumento=d.idDocumento where m.destino=:idus  and d.idDocumento not in (select z.idDocumento from movimiento z where z.origen=:idus) ". $namess ."   group by d.idDocumento ORDER BY m.fechaMov desc,m.estado asc ".$pages->limit."");
            $result =  $db->prepare("select m.idMov, m.nroRecibo, p.nombres AS nombres, m.tipo,m.cantidad, m.fecha, SUM(m.importe) as importe, t.nombreTupa as tupas, m.concepto, c.clase as clasif from movimiento m, persona p, tupa t, clase6 c  where  m.idPersona=p.idPersona and m.tupa=t.idTupa and t.idClasif=c.id ". $namess ." group by m.nroRecibo order by m.idMov desc ".$pages->limit." ");
        $result->execute();
        
   // and idMov=(SELECT MAX(x.idMov) FROM movimiento x)
    ?>
    <div class="clearfix"></div>
     
    <div class="row marginTop">
        <div class="col-sm-12 paddingLeft pagerfwt">
            <?php if($pages->items_total > 0) { ?>
                <?php echo $pages->display_pages();?>
                <?php echo $pages->display_items_per_page();?>
                <?php echo $pages->display_jump_menu(); ?>
            <?php }?>
        </div>
        <div class="clearfix"></div>
    </div>
 
    <div class="clearfix"></div>
     
    <table class="table table-bordered table-striped">
        <thead>
            <tr><th>Fecha</th><th>Nro de Recibo</th><th>Clasificador</th><th>Detalle de pagos</th><th>Nombre y Apellidos</th><th>Total</th>
        </thead>
        <tbody>
            <?php
            if($pages->items_total>0){
                $n  =   1;
                while($SQLrow =   $result->fetch(PDO::FETCH_ASSOC)){
                     $recibo=$SQLrow['nroRecibo'];
     
    
                    $sq02="select m.cantidad,m.importe, t.nombreTupa as tupas,m.concepto from movimiento m, tupa t where  m.tupa=t.idTupa and m.nroRecibo=:recibo order by m.nroRecibo desc limit 100";
                    $resu02=$db->prepare($sq02);
                    $resu02->execute([':recibo'=>$recibo]);
                   // $row02=$resu02->rowCount();
                    
                    $sq03="select SUM(importe) as imp from movimiento where nroRecibo=:recibo";
                    $resu03=$db->prepare($sq03);
                    $resu03->execute([':recibo'=>$recibo]);
                    $m02 = $resu03->fetch(PDO::FETCH_ASSOC);                    
                   $total=$m02['imp'];
                   while($SQLrows  =   $resu02->fetch(PDO::FETCH_ASSOC)){
                       $registross .= $SQLrows['tupas'].' '.$SQLrows['concepto'].'&nbsp;&nbsp;;&nbsp;&nbsp;'.$SQLrows['importe'].'&nbsp;&nbsp;;&nbsp;&nbsp;'.$SQLrows['cantidad'].'&nbsp;&nbsp;;&nbsp;&nbsp;'.$SQLrows['importe']*$SQLrows['cantidad'].'<br>';
                   }
                   
                   
                   
            ?>
            <tr>
                <td><?php echo $SQLrow['fecha']; ?> </td>
                <td><?php echo $SQLrow['nroRecibo']; ?></td>
                <td><?php echo $SQLrow['clasif']; ?></td>
                <td><?php echo $registross; ?></td>
                <td><?php echo $SQLrow['nombres']; ?></td>
                <td><?php echo $total; ?></td>
                <td><?php //echo mb_strtoupper($val['name']); ?></td>
               
                
            </tr>
            <?php
                }
            }else{?>
            <tr>
                <td colspan="6" align="center"><strong>Ningún trámite realizado</strong></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
                                   	
    <div id="det"></div>
    <div class="clearfix"></div>
     
    <div class="row marginTop">
        <div class="col-sm-12 paddingLeft pagerfwt">
            <?php if($pages->items_total > 0) { ?>
                <?php echo $pages->display_pages();?>
                <?php echo $pages->display_items_per_page();?>
                <?php echo $pages->display_jump_menu(); ?>
            <?php }?>
        </div>
        <div class="clearfix"></div>
    </div>
 
    <div class="clearfix"></div>
     
</div> <!--/.container-->
        
    </div>
</div>
    <div id='footer'>
        Copyright&copy;2020 <a href="http://www.innovasoftware.com.pe/"  target="_black">InnovaSoftware</a> Todos los derechos reservados | Diseño e Implementación de Software a medida | 935381784
    </div>
</div>
</body>
</html>
