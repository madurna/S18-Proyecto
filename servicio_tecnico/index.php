<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('servicio_tecnico.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);

	$_SESSION['menu_principal'] = 3;
	//DB_DataObject::debugLevel(5); 

	//creo template
	$tpl = new tpl();
	
	$do_planta = DB_DataObject::factory('planta');
	$v_planta = $do_planta -> get_plantas_todas();

	$v_estado = array( 'Todos', 'En Proceso', 'Pendiente', 'Resuelto');
	
	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	
	//numero 	
	$frm ->addElement('text','servicio_tecnico_numero','N&uacute;mero: ',array('id' => 'servicio_tecnico_numero','size'=>'30'));

	//planta 	
	$frm ->addElement('select','planta','Planta: ',$v_planta,array('id' => 'planta'));

	//estados 	
	$frm ->addElement('select','estado','Estado: ',$v_estado,array('id' => 'estado'));

	//aceptar y limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Filtrar');
	$botones[] = $frm->createElement('reset','restaurar','Limpiar busqueda',array('onClick'=> "javascript: window.location.href='index.php';"));
	$frm->addGroup($botones);
	
	//traigo datos del form
	$servicio_tecnico_numero = $_GET['servicio_tecnico_numero'];
	$planta = $_GET['planta'];
	$estado = $_GET['estado'];
	$aceptar = $_GET['aceptar'];
	
	$do_servicio_tecnico = DB_DataObject::factory('servicio_tecnico');

	//traigo datos
	if ($aceptar == 'Filtrar'){
		if ($servicio_tecnico_numero != '')
			$do_servicio_tecnico -> whereAdd("servicio_tecnico_id = '$servicio_tecnico_numero'"); 	
		if ($planta != 'Todas')
			$do_servicio_tecnico -> whereAdd("id_planta_cliente like '%$planta%'");
		if ($estado != 0)
			$do_servicio_tecnico -> whereAdd("servicio_tecnico_estado_id = '$estado'");
	}

	$do_servicio_tecnico -> orderBy('servicio_tecnico_estado_id ASC');

	$do_servicio_tecnico -> find();

	$cantidad = $do_servicio_tecnico -> N;

	//armo grilla	
	$columnas = array();
	$columnas[0] = '<font size="1px" color="#FFFFFF">N&uacute;mero</font>';
	$columnas[1] = '<font size="1px" color="#FFFFFF">Nombre</font>';
	$columnas[2] = '<font size="1px" color="#FFFFFF">Fecha de inicio</font>';
	$columnas[3] = '<font size="1px" color="#FFFFFF">Precio Estimado</font>';
	$columnas[4] = '<font size="1px" color="#FFFFFF">Estado</font>';
	$columnas[5] = '<font size="1px" color="#FFFFFF">Acci&oacute;n</font>';
	
	$i = -1;
	
	while ( $do_servicio_tecnico -> fetch()){
		$i++;
		
		$matriz[$i][0] = '<center>'.$do_servicio_tecnico -> servicio_tecnico_id.'</center>';
		$matriz[$i][1] = '<center>'.$v_planta[$do_servicio_tecnico -> id_planta_cliente].'</center>';
		$matriz[$i][2] = '<center>'.fechaAntiISO($do_servicio_tecnico -> servicio_tecnico_fecha_estimada_inicio).'</center>';
		$matriz[$i][3] = '<center>'.monedaConPesos($do_servicio_tecnico -> servicio_tecnico_precio_estimado).'</center>';
		if ($do_servicio_tecnico -> servicio_tecnico_estado_id == 1){
			$estado_mostrar='<i title="En Proceso" class="fa fa-spinner text-bg text-success"></i>';
		}elseif($do_servicio_tecnico -> servicio_tecnico_estado_id == 2){
			$estado_mostrar='<i title="Pendiente" class="fa fa-clock-o text-bg text-success"></i>';
		}else{
			$estado_mostrar='<i title="Resuelto" class="fa fa-check-square-o text-bg text-success"></i>';
		}
		$matriz[$i][4] = '<center>'.$estado_mostrar.'</center>';
		$matriz[$i][5] = '<center>
								<a href="ver_servicio_tecnico.php?contenido='.$do_servicio_tecnico -> servicio_tecnico_id.'"><i title="Ver" class="fa fa-search text-bg text-danger"></i>
								<a href="modificar_servicio_tecnico.php?contenido='.$do_servicio_tecnico -> servicio_tecnico_id.'"><i title="Modificar" class="fa fa-edit text-bg text-danger"></i>
								<a href="eliminar_servicio_tecnico.php?contenido='.$do_servicio_tecnico -> servicio_tecnico_id.'"><i title="Eliminar" class="fa fa-trash-o text-bg text-danger"></i>
							</center>';					
	}

	$cantidadColumnas = array();
	for ($i=0; $i <= 10; $i++) 
	$cantidadColumnas[$i] = $i;
	$dg = new grilla(50);
	$dg -> setRendererOption ('convertEntities',false);
	$dg -> generateColumns($columnas); // Genero las columnas en la grilla utilizando el array que acabo de crear
	$dg -> bind($matriz,array(),'Array'); // Hago el Bind con la matriz, el 1er y 2do parámetro siempre son iguales
	// Oculto los links en los encabezados para que el usuario no pueda desordenar el contenido de la grilla
	$dg -> setRendererOption('hideColumnLinks', $cantidadColumnas);

    //armo template
	
	if ($dg->getRecordCount() > 0 ) {	
		$excel = '<p>Exportar a: <a href="#"> EXCEL </a></p>';
		$salida_grilla=$dg->getOutput();
		$dg->setRenderer('Pager');
		$salida_grilla.=$dg->getOutput();
		$dg->setRendererOption('onMove', 'updateGrid', true);
		$mostrar_cantidad = 'Cantidad de registros: '.$cantidad;
	}
	else{
		if ($aceptar == 'Filtrar') {
			$tpl->assign('include_file', 'cartel.htm'); 
			$tpl->assign('imagen', 'informacion.jpg');
			$tpl->assign('msg', 'No hay registros para mostrar.');
			$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
		}
	}
	
	$agregar='<a href="alta_servicio_tecnico.php">[Agregar]</a>';

	$tpl->assign('body','<div align=center><b>Servicio T&eacute;cnico</b></div><div align="center"><br/>'.$frm->toHTML().'</div><br/><div><center>'.$agregar.'</center></div><br/><div><center>'.$excel.'</center></div><div><br/>'.$salida_grilla.'<br /><b>'.$mostrar_cantidad.'</b></div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	$tpl->assign('menu', "menu_eco_reciclar.htm");	
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');	    
	ob_end_flush();
	exit;
?>