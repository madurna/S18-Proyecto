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

	//traigo datos del form
	$nombre = $_GET['app_nombre'];
	$estado = $_GET['app_baja'];
	$aceptar = $_GET['aceptar'];
		
	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	//nombre	
	$frm ->addElement('text','app_nombre','Nombre: ',array('id' => 'app_nombre', 'value'=>''));
	$estado_form = array('Todos'=>'Todos','0'=>'Alta','1'=>'Baja');
	$frm ->addElement('select', 'app_baja', 'Estado: ', $estado_form, array('id' => 'app_baja'));
	//aceptar
	$frm ->addElement('submit','aceptar','Filtrar',null);
	
	//armo consulta con los datos del filtro
	$do_app= DB_DataObject::factory('aplicacion');
	if($aceptar == 'Filtrar'){
		if ($nombre != '')
			$do_app -> whereAdd("app_nombre like '%$nombre%'"); 
		if ($estado != 'Todos')
			$do_app -> app_baja = $estado;
	}  
	$do_app -> orderBy('app_nombre');
	
	//creo grilla
	$dg = new grilla(20);
	$dg->bind($do_app);
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Nombre</span>','app_nombre',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Estado</span>',null,null,array('width' => '20%', 'align' => "center"),null,'get_estado_app',array('id' => 'app_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">M&oacute;dulos</span>',null,null,array('width' => '20%', 'align' => "center"),null,'get_modulos_app',array('id' => 'app_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_modificar_app',array('id' => 'app_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla"></span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_eliminar_app',array('id' => 'app_id')));
		
	//link para agregar una actividad
    $agregar = '<br><a href="alta_aplicacion.php">[Agregar aplicaci&oacute;n]</a>';
	
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
			$tpl->assign('msg', 'No hay aplicaciones para mostrar.');
			$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
		}
	}
	$tpl->assign('body', '<div align=center><b>Aplicaciones</b></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><div><br/>'.$agregar.'</div><div><br/>'.$salida_grilla.'</div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Aplicaciones');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
    exit;