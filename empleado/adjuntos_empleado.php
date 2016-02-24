<?php
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// Links
	require_once('empleado.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerías propias
	require_once(INC_PATH.'/comun.php');
	require_once(INC_PATH.'/rutinas.php');
	require_once(INC_PATH.'/grilla.php');
	require_once(AUTHFILE);
	//require_once ('HTTP/Upload.php');
	//arreglos
	//DB_DataObject::debugLevel(5);
	$_SESSION['menu_principal'] = 7;
	
	//GET
	$empleado_id =  $_GET['contenido'];

	if (!empty($_GET)) {	
	
		//$planObra = DB_DataObject::factory('m2po_plan_de_obra');
		
		
		// $columnas es un array que será cargado con los nombres que queremos que aparezcan en las columnas de la grilla 
		$columnas = array();
				
			//DB_DataObject::debugLevel(5); 
			//obtengo nombre
			$do_empleado_2 = DB_DataObject::factory('empleado');
			$do_empleado_2 -> empleado_id = $empleado_id;
			$do_empleado_2 -> find(true);
			$apellido_nombre = $do_empleado_2 -> empleado_apellido.' '.$do_empleado_2 -> empleado_nombre;
			//
			
			$do_empleado = DB_DataObject::factory('empleado');
			$do_empleado -> empleado_id = $empleado_id;
			$do_adjuntos_empleado = DB_DataObject::factory('adjuntos_empleado');
			$do_tipo_adjunto = DB_DataObject::factory('tipo_adjunto');
			$do_adjuntos_empleado -> joinAdd($do_tipo_adjunto);
			$do_adjuntos_empleado -> joinAdd($do_empleado);
			$do_adjuntos_empleado -> find();
			
			$columnas[1] = '<font size="1px" color="#FFFFFF">Tipo Adjunto</font>';
			$columnas[2] = '<font size="1px" color="#FFFFFF">Descripci&oacute;n</font>';
			$columnas[3] = '<font size="1px" color="#FFFFFF">Acci&oacute;n</font>';
			
			$i=0;
			
			$do_tipo_adjunto_todos = DB_DataObject::factory('tipo_adjunto');
			//$tipos_adjuntos = $do_tipo_adjunto_todos -> get_tipo_adjunto();		
			
			while ($do_adjuntos_empleado -> fetch()) {
			$i++;
		
				$matriz[$i][1] = $do_adjuntos_empleado -> tipo_adjunto_nombre;
				$matriz[$i][2] = $do_adjuntos_empleado-> adjuntos_empleado_descripcion;
				//$matriz[$i][3] = '<a href='.$do_adjuntos_cliente-> adjuntos_cliente_direccion.'>[Descargar]</a>' ;
				$matriz[$i][3] = '<a href=empleado/descargar_adjunto.php?contenido='.$do_adjuntos_empleado-> adjuntos_empleado_id.'>[Descargar]</a>' ;

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
		
	}
	else 
	{
		$tpl->assign('include_file', 'cartel.htm');
		$tpl->assign('imagen', 'informacion.jpg');
		$mensaje = 'No existen archivos adjuntados.';
		$tpl->assign('msg', $mensaje);
		//	$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
						
	}
	// FIN Si la grilla trae resultados de la consulta a la BD, la vuelco a $salida_grilla
	
}
	// Instancio el template
		$agregar = '<br><a href="subir_adjuntos_empleado.php?contenido='.$empleado_id.'">[Agregar adjunto]</a>';
		$titulo_grilla = '<font size="2px">Adjuntos de: <u>'.$apellido_nombre.'</u></font><br /><br />';
		$body='<div align=center><b>'.$titulo_grilla.'</b></div><div><br/>'.$agregar.'</div><div><br/></div><div><br/>'.$salida_grilla.'</div></div>';
		//$body='<div align=center><b><u>'.$titulo_grilla.'</u></b></div><div><br/>'.$frm->toHTML().'</div>';
		$tpl->assign('body', $body);
   		$tpl->assign('menu','menu_eco_reciclar.htm');
		$tpl->assign('webTitulo', WEB_TITULO);
		$tpl->assign('secTitulo', WEB_SECCION . ' - Adjuntos empleado');
		$tpl->assign('links',$links1);
		$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
		$tpl->display('index.htm');

	
?>