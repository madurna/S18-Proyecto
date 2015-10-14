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

	//traido id de la aplicacion pasado por GET
	$aplicacion_contenido = $_GET['contenido']; 
	$estado = $_GET['mod_baja'];
	$nombre = $_GET['mod_nombre'];
	
	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	//filtro para seleccionar el estado
	$frm ->addElement('text','mod_nombre','Nombre: ',array('id' => 'mod_nombre', 'value'=>''));
	$estado_form = array('Todos'=>'Todos','0'=>'Alta','1'=>'Baja');
	$frm ->addElement('select', 'mod_baja', 'Estado: ', $estado_form, array('id' => 'mod_baja'));
	
	//aplicaciones
	$aplicaciones = array();
	$do = DB_DataObject::factory('aplicacion');
	if ($aplicacion_contenido != ''){
		$aplicaciones = $do -> get_aplicaciones_inicializado($aplicacion_contenido);
	}
	else{
		$aplicaciones = $do -> get_aplicaciones_todas();
	}
	$frm -> addElement('select','select_aplicaciones','Aplicaciones: ',$aplicaciones,array('id' => 'select_aplicaciones'));
	//aceptar
	$frm ->addElement('submit','aceptar','Filtrar',null);
	
	//traigo datos del form
	$aplicacion = $_GET['select_aplicaciones'];
	$aceptar = $_GET['aceptar'];
	
	//link para agregar un modulo
   	$agregar = '<br><a href="alta_modulo.php">[Agregar m&oacute;dulo]</a>';
	
	//armo consulta con los datos del filtro
	$do_modulo= DB_DataObject::factory('modulo');
	$do_modulo ->orderBy('mod_nombre');
	if ($aceptar == 'Filtrar'){
        if ($nombre != '')
        	$do_modulo -> whereAdd("mod_nombre like '%$nombre%'");  
		if($aplicacion != 'Todas'){
			$do_app = DB_DataObject::factory('aplicacion');
        	$do_modulo-> joinAdd($do_app);
            $do_modulo-> mod_app_id = $aplicacion;
		}
		if ($estado != 'Todos'){
			$do_modulo -> mod_baja = $estado;
		}
		//link para agregar un modulo
   		$agregar = '<br><a href="alta_modulo.php?app='.$aplicacion.'">[Agregar m&oacute;dulo]</a>';
	}
	
	//si llego desde "VER MODULOS"
	if ($aplicacion_contenido != ''){
			$do_app = DB_DataObject::factory('aplicacion');
        	$do_modulo-> joinAdd($do_app);
            $do_modulo-> mod_app_id = $aplicacion_contenido;
            //link para agregar un modulo
    		$agregar = '<br><a href="alta_modulo.php?app='.$aplicacion_contenido.'">[Agregar m&oacute;dulo]</a>';            
	}
			
	//creo grilla
	$dg = new grilla(20);
	$dg -> bind($do_modulo);
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Nombre</span>','mod_nombre',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Aplicaci&oacute;n</span>',null,null,array('width' => '25%', 'align' => "center" ),null,'get_app_modulo',array('id' => 'mod_app_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Estado</span>',null,null,array('width' => '10%', 'align' => "center"),null,'get_estado_modulo',array('id' => 'mod_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">P&aacute;ginas</span>',null,null,array('width' => '25%', 'align' => "center" ),null, 'get_paginas_modulos',array('mod_id' => 'mod_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>','',null,array('width' => '5%', 'align' => "left" ),null,'get_editar_modulo',array('id' => 'mod_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla"></span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_eliminar_modulo',array('id' => 'mod_id')));
	
    //armo template
	$tpl = new tpl();
	if ($dg->getRecordCount() > 0 ) {		
		$salida_grilla=$dg->getOutput();
		$dg->setRenderer('Pager');
		$salida_grilla.=$dg->getOutput();
		$dg->setRendererOption('onMove', 'updateGrid', true);
	}
	else{
		//if ($aceptar == 'Filtrar') {
		if (($aceptar == 'Filtrar') or ($aplicacion_contenido != '')) {
			$tpl->assign('include_file', 'cartel.htm'); 
			$tpl->assign('imagen', 'informacion.jpg');
			$tpl->assign('msg', 'No hay modulos para mostrar.');
			$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
		}
	}
	$tpl->assign('body', '<div align=center><b>M&oacute;dulos</b></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><div><br/>'.$agregar.'</div><div><br/>'.$salida_grilla.'</div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - M&oacute;dulos');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
    exit;