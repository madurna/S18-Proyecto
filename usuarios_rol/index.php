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
	require_once(AUTHFILE);
	//elegimos que sublink se va a marcar
	$_SESSION['menu_principal'] = 4;
	
	$id_usuario = $_GET['contenido'];
	
	//armo consulta con los datos del filtro
	$do = DB_DataObject::factory('usuario_rol');
    $do->joinAdd(DB_DataObject::factory('usuario'));
    $do->joinAdd(DB_DataObject::factory('rol'));
    $do->joinAdd(DB_DataObject::factory('aplicacion'));
    $do->usrrol_usua_id = $_GET['contenido'];
    $do->orderBy('usrrol_rol_id, usrrol_app_id');
	
    $agregar = '<br><a href="agregar.php?id_usuario='.$id_usuario.'">[Agregar Rol]</a>';
    
	//creo grilla
	$dg = new grilla(20);
	$dg->bind($do);
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Usuario</span>','usua_nombre',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Rol</span>','rol_nombre',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Aplicaci&oacute;n</span>','app_nombre',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '5%', 'align' => "center"),null,'get_eliminar_usuario_rol',array('id' => 'usrrol_id')));
		
	//armo template
	$tpl = new tpl();
	if ($dg->getRecordCount() > 0 ) {		
		$salida_grilla=$dg->getOutput();
		$dg->setRenderer('Pager');
		$salida_grilla.=$dg->getOutput();
		$dg->setRendererOption('onMove', 'updateGrid', true);
	}
	else{
		$tpl->assign('include_file', 'cartel.htm'); 
		$tpl->assign('imagen', 'informacion.jpg');
		$tpl->assign('msg', 'No hay usuarios para mostrar.');
	}
	
	$tpl->assign('body', '<h2>Administraci&oacute;n de Seguridad</h2><div align=center><b>Usuarios por rol</b></div>
	<div><br/>'.$agregar.'</div><div align="center"><br/>'.$salida_grilla.'</div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Usuarios por rol');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();	    
    exit;