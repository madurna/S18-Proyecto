<?php
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// Links
	require_once('clientes.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerías propias
	require_once(INC_PATH.'/comun.php');
	require_once(INC_PATH.'/rutinas.php');
	require_once(INC_PATH.'/grilla.php');
	require_once(AUTHFILE);
	
	//arreglos
	//DB_DataObject::debugLevel(5);
	$_SESSION['menu_principal'] = 8;
	
	//GET
	$cliente_id =  $_GET['contenido'];

	if (!empty($_GET)) {	
	
		// $columnas es un array que será cargado con los nombres que queremos que aparezcan en las columnas de la grilla 
		$columnas = array();
				
		//DB_DataObject::debugLevel(5); 
		//obtengo nombre
		$do_cliente_2 = DB_DataObject::factory('clientes');
		$do_cliente_2 -> cliente_id = $cliente_id;
		$do_cliente_2 -> find(true);
		$apellido_nombre = $do_cliente_2 -> cliente_apellido.' '.$do_cliente_2 -> cliente_nombre;
		//
		
		$do_cliente = DB_DataObject::factory('clientes');
		$do_cliente -> cliente_id = $cliente_id;
		$do_adjuntos_cliente = DB_DataObject::factory('adjuntos_cliente');
		$do_tipo_adjunto = DB_DataObject::factory('tipo_adjunto');
		$do_adjuntos_cliente -> joinAdd($do_cliente);
		$do_adjuntos_cliente -> joinAdd($do_tipo_adjunto);
		$do_adjuntos_cliente -> find();
		
		$columnas[1] = '<font size="1.5px" color="#FFFFFF">&nbsp;&nbsp;Tipo Adjunto&nbsp;&nbsp;</font>';
		$columnas[2] = '<font size="1.5px" color="#FFFFFF">&nbsp;&nbsp;Descripci&oacute;n&nbsp;&nbsp;</font>';
		$columnas[3] = '<font size="1.5px" color="#FFFFFF">&nbsp;&nbsp;Acci&oacute;n&nbsp;&nbsp;</font>';
		
		$i=0;
		
		$do_tipo_adjunto_todos = DB_DataObject::factory('tipo_adjunto');
		
		while ($do_adjuntos_cliente -> fetch()) {
		$i++;
	
			$matriz[$i][1] = $do_adjuntos_cliente -> tipo_adjunto_nombre;
			$matriz[$i][2] = $do_adjuntos_cliente-> adjuntos_cliente_descripcion;
			$matriz[$i][3] = '<a href=descargar_adjunto.php?contenido='.$do_adjuntos_cliente-> adjuntos_cliente_id.'>[Descargar]</a>' ;
		}

		// Creo la grilla a ser mostrada
		// Creo un array que va desde 0 hasta cantidad de columnas -1
		// Este array sirve para ocultar los links de las columnas
		// Será utilizado en la sentencia $dg -> setRendererOption('hideColumnLinks', $cantidadColumnas);
		$cantidadColumnas = array();
		for ($i=0; $i <= 3; $i++) $cantidadColumnas[$i] = $i;
		$dg = new grilla(50);
		$dg -> setRendererOption ('convertEntities',false);
		$dg -> generateColumns($columnas); // Genero las columnas en la grilla utilizando el array que acabo de crear
		$dg -> bind($matriz,array(),'Array'); // Hago el Bind con la matriz, el 1er y 2do parámetro siempre son iguales
		// Oculto los links en los encabezados para que el usuario no pueda desordenar el contenido de la grilla
		$dg -> setRendererOption('hideColumnLinks', $cantidadColumnas);
		$table = new HTML_Table('cellpadding=5 walign=center border=0');
		$dg -> fill($table);
		// FIN Creo la grilla a ser mostrada
	
		$tpl = new tpl();	
		// Si la grilla trae resultados de la consulta a la BD, la vuelco a $salida_grilla
		if ($dg -> getRecordCount() > 0 ) {
			$salida_grilla=$dg->getOutput();
			$dg->setRenderer('Pager');
			$salida_grilla.=$dg->getOutput();
			$dg->setRendererOption('onMove', 'updateGrid', true);
		}else{
			$tpl->assign('include_file', 'cartel.htm');
			$tpl->assign('imagen', 'informacion.jpg');
			$mensaje = 'No existen archivos adjuntados.';
			$tpl->assign('msg', $mensaje);
		}
		// FIN Si la grilla trae resultados de la consulta a la BD, la vuelco a $salida_grilla
	}

	// Instancio el template
	$agregar = '<br><a href="subir_adjuntos_cliente.php?contenido='.$cliente_id.'">[Agregar adjunto]</a>';
	$volver = '<br><a href="index.php">[Volver]</a>';
	$titulo_grilla = '<font size="2px">Adjuntos de: <u>'.$apellido_nombre.'</u></font><br /><br />';
	$body='<div align=center><b>'.$titulo_grilla.'</b></div><div><br/>'.$agregar.'</div><div><br/></div><div><br/>'.$salida_grilla.'</b></div><div><br/>'.$volver.'</div></div>';
	$tpl->assign('body', $body);
	$tpl->assign('menu','menu_eco_reciclar.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Adjuntos cliente');
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
?>