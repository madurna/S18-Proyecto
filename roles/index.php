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
	$_SESSION['menu_principal'] = 4;
	//DB_DataObject::debugLevel(5); 
	
	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	//nombre	
	$frm ->addElement('text','rol_nombre','Nombre: ',array('id' => 'rol_nombre', 'value'=>''));
	$estado_form = array('Todos'=>'Todos','0'=>'Alta','1'=>'Baja');
	$frm ->addElement('select', 'rol_baja', 'Estado: ', $estado_form, array('id' => 'rol_baja'));
	//aceptar
	$frm ->addElement('submit','aceptar','Filtrar',null);
	
	//traigo datos del form
	$nombre = $_GET['rol_nombre'];
	$estado = $_GET['rol_baja'];
	$aceptar = $_GET['aceptar'];
	
	//armo consulta con los datos del filtro
	$do_rol= DB_DataObject::factory('rol');
	if($aceptar == 'Filtrar'){
		if ($nombre != '')
			$do_rol -> whereAdd("rol_nombre like '%$nombre%'"); 
		if ($estado != 'Todos')
			$do_rol -> rol_baja = $estado;	
	}	
	$do_rol -> orderBy('rol_nombre');
			
	//creo grilla
	$dg = new grilla(20);
	$dg->bind($do_rol);

	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Nombre</span>','rol_nombre',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Estado</span>',null,null,array('width' => '20%', 'align' => "center"),null,'get_estado_rol',array('id' => 'rol_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Usuarios</span>',null,null,array('width' => '20%', 'align' => "center"),null,'get_usuarios_rol',array('id' => 'rol_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_modificar_rol',array('id' => 'rol_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla"></span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_eliminar_rol',array('id' => 'rol_id')));
		
	//link para agregar una actividad
    $agregar = '<br><a href="alta_rol.php">[Agregar rol]</a>';
	
    //armo template
	$tpl = new tpl();
	if ($dg->getRecordCount() > 0 ) {		
		$salida_grilla=$dg->getOutput();
		$dg->setRenderer('Pager');
		$salida_grilla.=$dg->getOutput();
		$dg->setRendererOption('onMove', 'updateGrid', true);
	}
	else{
		if ($aceptar == 'Filtrar') {
			$tpl->assign('include_file', 'cartel.htm'); 
			$tpl->assign('imagen', 'informacion.jpg');
			$tpl->assign('msg', 'No hay roles para mostrar.');
			$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
		}
	}
	$tpl->assign('body', '<div align=center><b>Roles</b></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><div><br/>'.$agregar.'</div><div><br/>'.$salida_grilla.'</div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Roles');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');	    
    ob_end_flush();
    exit;