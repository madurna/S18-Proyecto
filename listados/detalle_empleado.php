<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	//require_once('listados.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	//require_once(AUTHFILE);
	$_SESSION['menu_principal'] = 5;
	//DB_DataObject::debugLevel(5); 
	
	//creo template
	$tpl = new tpl();
	//
	
	//GET
	$empleado_id=$_GET['contenido'];

	//arreglos
	$do_empresa = DB_DataObject::factory('empresa');
	$v_empresa = $do_empresa -> get_empresa_todas();

	$do_convenio = DB_DataObject::factory('convenio');
	$v_convenio = $do_convenio -> get_convenio_todos();

	$do_puesto = DB_DataObject::factory('puesto');
	$v_puesto = $do_puesto -> get_puesto_todos();

	$do_ubicacion_laboral = DB_DataObject::factory('ubicacion_laboral');
	$v_ubicacion_laboral = $do_ubicacion_laboral -> get_ubicacion_todos();

	//armo consulta con los datos del filtro
	$do_view_empleado = DB_DataObject::factory('view_empleado');
	$do_view_empleado -> whereAdd("empleado_id = $empleado_id");
	$do_view_empleado -> find(true);

	$empleado_nombre = $do_view_empleado -> empleado_nombre;                 
	$empleado_apellido = $do_view_empleado -> empleado_apellido;               
	$empleado_legajo = $do_view_empleado -> empleado_legajo;                 
	$empleado_numero_documento = $do_view_empleado -> empleado_numero_documento;       
	$empleado_domicilio_calle = $do_view_empleado -> empleado_domicilio_calle;        
	$empleado_domicilio_numero = $do_view_empleado -> empleado_domicilio_numero;       
	$empleado_domicilio_piso = $do_view_empleado -> empleado_domicilio_piso;         
	$empleado_domicilio_departamento = $do_view_empleado -> empleado_domicilio_departamento;    
	$empleado_domicilio_localidad_id = $do_view_empleado -> empleado_domicilio_localidad_id;    
	$empleado_empresa_id = $do_view_empleado -> empleado_empresa_id;             
	$empleado_sexo_id = $do_view_empleado -> empleado_sexo_id;                
	$empleado_nacionalidad_id = $do_view_empleado -> empleado_nacionalidad_id;        
	$empleado_fecha_nacimiento = $do_view_empleado -> empleado_fecha_nacimiento;       
	$empleado_fecha_ingreso = $do_view_empleado -> empleado_fecha_ingreso;          
	$empleado_fecha_antiguedad = $do_view_empleado -> empleado_fecha_antiguedad;        
	$empleado_cuil = $do_view_empleado -> empleado_cuil;                   
	$empleado_afiliado = $do_view_empleado -> empleado_afiliado;               
	$empleado_categoria_id = $do_view_empleado -> empleado_categoria_id;             
	$convenio_empresa_empresa_id = $do_view_empleado -> convenio_empresa_empresa_id;     
	$convenio_empresa_convenio_id = $do_view_empleado -> convenio_empresa_convenio_id;    
	$nacionalidad_id = $do_view_empleado -> nacionalidad_id;
	$nacionalidad_nombre = $do_view_empleado -> nacionalidad_nombre;             
	$puesto_nombre = $do_view_empleado -> puesto_nombre;                   
	$tipo_documento_nombre = $do_view_empleado -> tipo_documento_nombre;           
	$ubicacion_laboral_nombre = $do_view_empleado -> ubicacion_laboral_nombre;            
	$estudio_nombre = $do_view_empleado -> estudio_nombre;                  
	$estado_civil_nombre = $do_view_empleado -> estado_civil_nombre;            
	$datos='

		<div class="panel-heading">
			<span class="panel-title">Empleado</span>
		</div>
		<div class="panel-body">
			<table style="text-align:center; border: 1px solid">
			
			<tr align="center" bgcolor="#FFFFFF">
				<td><b>Empresa</b></td><td>'.$v_empresa[$empleado_empresa_id].'</td>
			</tr>
			<tr align="center" bgcolor="#EEEEEE">
				<td><b>Legajo</b></td><td>'.$empleado_legajo.'</td>
			</tr>
			<tr align="center" bgcolor="#FFFFFF">		
				<td><b>Apellido</b></td><td>'.$empleado_apellido.'</td>
			</tr>
			<tr align="center" bgcolor="#EEEEEE">		
				<td><b>Nombre</b></td><td>'.$empleado_nombre.'</td>
			</tr>
			<tr align="center" bgcolor="#FFFFFF">		
				<td><b>CUIL</b></td><td>'.$empleado_cuil.'</td>
			</tr>
			<tr align="center" bgcolor="#EEEEEE">		
				<td><b>Tipo de documento</b></td><td>'.$tipo_documento_nombre.'</td>
			</tr>
			<tr align="center" bgcolor="#FFFFFF">		
				<td><b>Documento</b></td><td>'.$empleado_numero_documento.'</td>
			</tr>
			<tr align="center" bgcolor="#EEEEEE">		
				<td><b>Nacionalidad</b></td><td>'.$nacionalidad_nombre.'</td>
			</tr>
			<tr align="center" bgcolor="#FFFFFF">		
				<td><b>Provincia</b></td><td>'.'</td>
			</tr>
			<tr align="center" bgcolor="#EEEEEE">		
				<td><b>Localidad</b></td><td>'.$empleado_domicilio_localidad_id.'</td>
			</tr>
			<tr align="center" bgcolor="#FFFFFF">		
				<td><b>Calle</b></td><td>'.$empleado_domicilio_calle.'</td>
			</tr>
			<tr align="center" bgcolor="#EEEEEE">		
				<td><b>N&uacute;mero</b></td><td>'.$empleado_domicilio_numero.'</td>
			</tr>
			<tr align="center" bgcolor="#FFFFFF">		
				<td><b>Piso</b></td><td>'.$empleado_domicilio_piso.'</td>
			</tr>
			<tr align="center" bgcolor="#EEEEEE">		
				<td><b>Departamento</b></td><td>'.$empleado_domicilio_departamento.'</td>
			</tr>
			<tr align="center" bgcolor="#FFFFFF">		
				<td><b>Estudios</b></td><td>'.$estudio_nombre.'</td>
			</tr>
			<tr align="center" bgcolor="#EEEEEE">		
				<td><b>Estado civil</b></td><td>'.$estado_civil_nombre.'</td>
			</tr>
			<tr align="center" bgcolor="#FFFFFF">		
				<td><b>Fecha de nacimiento</b></td><td>'.$empleado_fecha_nacimiento.'</td>
			</tr>
			<tr align="center" bgcolor="#EEEEEE">		
				<td><b>Sexo</b></td><td>'.$empleado_sexo_id.'</td>
			</tr>
			<tr> 
			</tr>
			<tr align="center" bgcolor="#FFFFFF">		
				<td><b>Convenio</b></td><td>'.$convenio_empresa_convenio_id.'</td>
			</tr>
			<tr align="center" bgcolor="#EEEEEE">		
				<td><b>Catego&iacute;a</b></td><td>'.$empleado_categoria_id.'</td>
			</tr>
			<tr align="center" bgcolor="#FFFFFF">		
				<td><b>Ubicacion laboral</b></td><td>'.$ubicacion_laboral_nombre.'</td>
			</tr>
			<tr align="center" bgcolor="#EEEEEE">		
				<td><b>Puesto</b></td><td>'.$puesto_nombre.'</td>
			</tr>
			<tr align="center" bgcolor="#FFFFFF">		
				<td><b>Afiliado</b></td><td>'.$empleado_afiliado.'</td>
			</tr>
			<tr align="center" bgcolor="#EEEEEE">
				<td><b>Fecha ingreso</b></td><td>'.$empleado_fecha_ingreso.'</td>
			</tr>
			<tr align="center" bgcolor="#FFFFFF">
				<td><b>Fecha antiguedad</b></td><td>'.$empleado_fecha_antiguedad.'</td>			
			</tr>
			</table>
		</div>

	';

	$volver = '<a href="#" onClick="cerrarDialogo()">[Cerrar]</a>';

	$tpl->assign('body',' 
	<link rel="stylesheet" href="../css/modal-message.css" type="text/css">

	<link type="text/css" rel="stylesheet" href="css/autocomplete_cliente/estilo.css" />
	<script type="text/javascript" src="../js/calendario.js"></script>
	<script type="text/javascript" src="../js/ajax/ajax.js"></script>
	<script type="text/javascript" src="../js/ajax/ajax-dynamic-content.js"></script>
	<script type="text/javascript" src="../js/ajax/modal-message.js"></script>

	<link type="text/css" rel="stylesheet" href="css/autocomplete_cliente/jquery-ui-1.8.4.custom.css"/>
	<script type="text/javascript" src="js/autocomplete_cliente/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/autocomplete_cliente/jquery-ui-1.8.4.custom.min.js"></script>
	<div>'.$datos.'</div>'.$volver);//<div><br /><center><b>'.'</b></center></div><div><br/>'.$salida_grilla.'</div><div><center><br />'.$volver.'</center></div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Empleado');
	//$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('popUpSinEncabezado.htm');	    
	ob_end_flush();
	exit;
?>