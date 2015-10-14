<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	//require_once('unidad_funcional.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	//$_SESSION['menu_principal'] = 2;
	//DB_DataObject::debugLevel(5); 

	//creo template
	$tpl = new tpl();
	//
	$obra_civil_id = $_GET['contenido'];

	//arreglos
	$do_localidad = DB_DataObject::factory('localidad');
	$v_localidad = $do_localidad -> get_localidades_todas();

	/*$do_convenio = DB_DataObject::factory('convenio');
	$v_convenio = $do_convenio -> get_convenio_todos();

	$do_categoria_convenio_empresa = DB_DataObject::factory('categoria_convenio_empresa');
	$v_categoria_convenio_empresa = $do_categoria_convenio_empresa -> get_categoria_todas();*/

	//creo formulario
	
	$_SESSION['menu_principal'] = 2;
	//aceptar y limpiar

	
	//traigo datos del form
		
	//traigo datos
	//print_r($convenio);
	
		$do_unidad_funcional = DB_DataObject::factory('unidad_funcional');
		$do_unidad_funcional -> whereAdd("unidad_funcional_obra_civil_id = $obra_civil_id");
		//print_r($_GET);

		/*if ($convenio != 'Todas')
			$do_view_log_categoria_empleado ->convenio_empresa_convenio_id = $convenio;

		if ($empleado){
			$do_view_log_categoria_empleado -> whereAdd(' empleado_nombre like "%'.$empleado.'%"');
		}
		if ($legajo)
			$do_view_log_categoria_empleado -> whereAdd(' empleado_legajo like "%'.$legajo.'%"');

		if ($empresa != 'Todas')
			$do_view_log_categoria_empleado -> empleado_empresa_id = $empresa;

    	if ($periodo)
    	{
	    	$do_view_log_categoria_empleado -> whereAdd('log_categoria_empleado_mes>='.$periodo["mes_1"].' and log_categoria_empleado_anio>='.$periodo["anio_1"].' ');
			$do_view_log_categoria_empleado -> whereAdd('log_categoria_empleado_mes<='.$periodo["mes_2"].' and log_categoria_empleado_anio<='.$periodo["anio_2"].' ');
		}*/
		$do_estado_uf = DB_DataObject::factory('estado_uf');
		$do_unidad_funcional -> joinAdd($do_estado_uf);
		$do_unidad_funcional -> find();

		$cantidad = $do_unidad_funcional -> N;

/*
        'unidad_funcional_piso' => 'Pisos: ',
        'unidad_funcional_departamento' => 'Depto: ',
        'unidad_funcional_cantidad_ambientes' => 'Ambientes: ',
        'unidad_funcional_coeficiente' => 'Coeficiente: ',
        'unidad_funcional_dimensiones' => 'Dimensiones: ',
        'unidad_funcional_monto' => 'Valor: ',
        'unidad_funcional_observacion' => 'Observaci&oacute;n: ',
        'unidad_funcional_estado' => 'Estado: ',
*/
	//armo grilla	
	$columnas = array();
	//$columnas[0] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;N&uacute;mero&nbsp;&nbsp;</font>';
	$columnas[1] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;Pisos&nbsp;&nbsp;</font>';
	$columnas[2] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;Depto&nbsp;&nbsp;</font>';
	//$columnas[3] = '<font size="1px" color="#FFFFFF">Domicilio</font>';
	$columnas[4] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;Ambientes&nbsp;&nbsp;</font>';
	$columnas[5] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;Coeficiente&nbsp;&nbsp;</font>';
	$columnas[6] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;Dimensiones&nbsp;&nbsp;</font>';
	$columnas[7] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;Valor&nbsp;&nbsp;</font>';
	$columnas[9] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;Observaci&oacute;n&nbsp;&nbsp;</font>';
	//$columnas[10] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;Cuotas&nbsp;&nbsp;</font>';
	$columnas[11] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;Estado&nbsp;&nbsp;</font>';
	$columnas[12] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;Cliente&nbsp;&nbsp;</font>';
	$columnas[13] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;Acci&oacute;n&nbsp;&nbsp;</font>';
	$i = -1;
		
		while ( $do_unidad_funcional -> fetch())
		{
			$i++;
			
			//$matriz[$i][0] = '<center>'.$do_unidad_funcional -> unidad_funcional_id.'</center>';
			$matriz[$i][1] = '<center>'.$do_unidad_funcional -> unidad_funcional_piso.'</center>';
			$matriz[$i][2] = '<center>'.$do_unidad_funcional -> unidad_funcional_departamento.'</center>';
			$matriz[$i][4] = '<center>'.$do_unidad_funcional -> unidad_funcional_cantidad_ambientes.'</center>';
			$matriz[$i][5] = '<center>'.$do_unidad_funcional -> unidad_funcional_coeficiente.'</center>';
			$matriz[$i][6] = '<center>'.$do_unidad_funcional -> unidad_funcional_dimensiones.'</center>';
			$matriz[$i][7] = '<center>'.monedaConPesos($do_unidad_funcional -> unidad_funcional_monto).'</center>';	
			//$matriz[$i][8] = '<center>'.monedaConPesos($do_unidad_funcional -> valorDeCompra).'</center>';	
			//$matriz[$i][8] = '<center><b>33 % </b><a href="#"><i title="Ver Avances" class="fa fa-search text-bg text-danger"></i></center>';			
			$matriz[$i][9] = '<center>'.utf8_encode($do_unidad_funcional -> unidad_funcional_observacion).'</center>';
			//$matriz[$i][10] = '<center><a href="#"><i title="Ver Cuotas" class="fa fa-search text-bg text-danger"></i></center>';
			$matriz[$i][11] = '<center>'.utf8_encode($do_unidad_funcional -> estado_uf_descripcion).'</center>';
			if ($do_unidad_funcional -> unidad_funcional_cliente_id){
				$onClick="javascript: cerrarDialogo();mostrarDialogo('../clientes/ver_cliente.php?obra_civil=".$obra_civil_id."&ver=v&contenido=".$do_unidad_funcional -> unidad_funcional_cliente_id."',450,500)";
				$matriz[$i][12] = '<center><a href="#" onClick="'.$onClick.'"><i title=" Ver cliente asigandos" class="fa fa-search text-bg text-danger"></i></a></center>';		
			}
			else{
				$onClick="javascript: cerrarDialogo();mostrarDialogo('../unidad_funcional/modificar_unidad_funcional.php?contenido=".$do_unidad_funcional -> unidad_funcional_id."',500,400)";
				$matriz[$i][12] = '<center><a href="#"><i title=" Agregar cliente" class="fa fa-plus-square-o text-bg text-danger"></i></a></center>';		
			}
			
			$onClick_modificar = "javascript: cerrarDialogo();mostrarDialogo('../unidad_funcional/modificar_unidad_funcional.php?contenido=".$do_unidad_funcional -> unidad_funcional_id."',500,400)";
			$onClick_eliminar = "javascript: cerrarDialogo();mostrarDialogo('../unidad_funcional/eliminar_unidad_funcional.php?contenido=".$do_unidad_funcional -> unidad_funcional_id."',500,400)";

			$matriz[$i][13] = '
								<center>
									<a href="#" onClick="'.$onClick_modificar.'"><i title="Modificar" class="fa fa-edit text-bg text-danger"></i>
									<a href="#" onClick="'.$onClick_eliminar.'"><i title="Eliminar" class="fa fa-trash-o text-bg text-danger"></i>
								</center>';							
		}

		$cantidadColumnas = array();
		for ($i=0; $i <= 10; $i++) 
		$cantidadColumnas[$i] = $i;
		$dg = new grilla();
		$dg -> setRendererOption ('convertEntities',false);
		$dg -> generateColumns($columnas); // Genero las columnas en la grilla utilizando el array que acabo de crear
		$dg -> bind($matriz,array(),'Array'); // Hago el Bind con la matriz, el 1er y 2do parámetro siempre son iguales
		// Oculto los links en los encabezados para que el usuario no pueda desordenar el contenido de la grilla
		$dg -> setRendererOption('hideColumnLinks', $cantidadColumnas);
	
	    //armo template
		
		if ($dg->getRecordCount() > 0 ) {	
			//$excel = '<p>Exportar a: <a href="#"> EXCEL </a></p>';
			$salida_grilla=$dg->getOutput();
			$dg->setRenderer('Pager');
			$salida_grilla.=$dg->getOutput();
			$dg->setRendererOption('onMove', 'updateGrid', true);
			$mostrar_cantidad = 'Cantidad de registros: '.$cantidad;
		}
		else{
			
			$salida_grilla='
				<table class="login" width="350" height="80" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr> 
				    <td width="76" height="80" align="center" valign="middle">
				    <img src="../img/informacion.jpg" width="48" height="48" border="1"></td>
				    <td width="324" align="left" valign="middle"><div align="justify">No hay unidades funcionales para mostrar.</div></td>
				  </tr>
				</table>
			';

		}
	
	$onClick_add = "javascript: cerrarDialogo();mostrarDialogo('../unidad_funcional/alta_unidad_funcional.php?contenido=".$obra_civil_id."',500,400)";

	$agregar='<a href="#" onClick="'.$onClick_add.'"> [Agregar]</a>';

	$do_obra_civil = DB_DataObject::factory('obra_civil');
	$do_obra_civil -> obra_civil_id = $obra_civil_id;
	$do_obra_civil -> find(true);

	$descripcion=$do_obra_civil -> obra_civil_descripcion;

	$tpl->assign('body',' 
	<link rel="stylesheet" href="../css/modal-message.css" type="text/css">

	<link type="text/css" rel="stylesheet" href="css/autocomplete_cliente/estilo.css" />
	<script type="text/javascript" src="../js/calendario.js"></script>
	<script type="text/javascript" src="../js/ajax/ajax.js"></script>
	<script type="text/javascript" src="../js/ajax/ajax-dynamic-content.js"></script>
	<script type="text/javascript" src="../js/ajax/modal-message.js"></script>

	<link type="text/css" rel="stylesheet" href="css/autocomplete_cliente/jquery-ui-1.8.4.custom.css"/>
	<script type="text/javascript" src="js/autocomplete_cliente/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/autocomplete_cliente/jquery-ui-1.8.4.custom.min.js"></script><br />
	<div align=center><h3>'.$descripcion.'</h3></div>
	<div align=center><h3>Unidades funcionales</h3></div>
	<br/><div><center>'.$agregar.'</center></div><br/><div><center>'.$excel.'</center></div><div><br/>'.$salida_grilla.'<br /><b>'.$mostrar_cantidad.'</b></div><div align="center"><br/><button onClick="cerrarDialogo()">Cerrar</button></div>');
	/*$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );*/
	$tpl->display('popUpSinEncabezado.htm');	    
	ob_end_flush();
	exit;
?>