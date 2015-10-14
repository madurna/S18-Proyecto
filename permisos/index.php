<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('../seguridad/seguridad.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	//require_once(AUTHFILE);
	$_SESSION['menu_principal'] = 4;

	//traigo datos del form
	$aplicacion = $_GET['select_aplicaciones'];
	$rol = $_GET['select_roles'];
	$aceptar = $_GET['aceptar'];
		
	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');

	//aplicaciones
	$aplicaciones = array();
	$do = DB_DataObject::factory('aplicacion');
	$aplicaciones = $do -> get_aplicaciones();
	$frm -> addElement('select','select_aplicaciones','Aplicaciones: ',$aplicaciones,array('id' => 'select_aplicaciones'));
	
	//roles
	$roles = array();
	$do = DB_DataObject::factory('rol');
	$roles = $do -> get_roles();
	$frm -> addElement('select','select_roles','Rol: ',$roles,array('id' => 'select_roles'));
	
	//aceptar
	$frm ->addElement('submit','aceptar','Filtrar',null);
	
	//armo consulta con los datos del filtro
	//DB_DataObject::debugLevel(5);
	
	//obtengo los modulos relacionados a la aplicacion seleccionada
	$do_modulo = DB_DataObject::factory('modulo');
	$do_modulo -> mod_app_id = $aplicacion;
	$do_modulo -> orderBy('mod_nombre');
	$do_modulo -> find();
	
	//obtengo los tipos de acceso
	$do_tipoacc = DB_DataObject::factory('tipo_acceso');
	$do_tipoacc -> orderBy('tipoacc_nombre');
	$do_tipoacc -> find();
	
	//obtengo la cantidad de modulo
	$do_tipoacc_cant = DB_DataObject::factory('modulo');
	$do_tipoacc_cant -> mod_app_id = $aplicacion;
	$do_tipoacc_cant -> find();
	$cantidad = 0;
	while ($do_tipoacc_cant -> fetch()){
		$cantidad++;
	}
	
	//creo grilla
	$dg = new grilla(20);
	$dg->bind($do_modulo);
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">M&oacute;dulos</span>','mod_nombre',null,array('width' => '330px', 'align' => "center")));
	//creo una columna por cada tipo de acceso
	while ($do_tipoacc -> fetch()){
		$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">'.$do_tipoacc -> tipoacc_nombre.'</span>',null,null,array('width' => '20%', 'align' => "center"),null,'get_estado_permiso',array('app_id' => $aplicacion, 'mod_id' => 'mod_id', 'rol_id' => $rol, 'tipoacc_id' => $do_tipoacc -> tipoacc_id)));
	}
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Tildar todos</span>',null,null,array('width' => '20%', 'align' => "center"),null,'get_tildar_todos',array('app_id' => $aplicacion, 'mod_id' => 'mod_id', 'rol_id' => $rol)));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_modificar_permisos',array('app_id' => $aplicacion, 'mod_id' => 'mod_id', 'rol_id' => $rol)));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_modificar_permisos',array('app_id' => $aplicacion, 'mod_id' => 'mod_id', 'rol_id' => $rol)));
	
	//creo una variable concatenando la aplicacion y rol escogido
	//$titulo = 'Permisos para el rol '.$rol.' en la aplicaci&oacute;n '.$aplicacion;
	
    //armo template
	$tpl = new tpl();
	if (($dg->getRecordCount() > 0 ) and ($aceptar == 'Filtrar')) {		
		$salida_grilla=$dg->getOutput();
		$dg->setRenderer('Pager');
		$salida_grilla.=$dg->getOutput();
		$dg->setRendererOption('onMove', 'updateGrid', true);
	}
	else{
		if ($aceptar == 'Filtrar') {
			$tpl->assign('include_file', 'cartel.htm'); 
			$tpl->assign('imagen', 'informacion.jpg');
			$tpl->assign('msg', 'No hay m&oacute;dulos para mostrar.');
			$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
		}
	}

	$tpl->assign('body', '<div align=center><b>Permisos</b></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><div><br/>'.$salida_grilla.'</div>
	<script type="text/javascript" src="../js/cambiar_estado.js"></script>
	<script type="text/javascript" src="../js/jquery.min.js"></script>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Permisos');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
    ob_end_flush();	    
    exit;