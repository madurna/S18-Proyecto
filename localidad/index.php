<?php
    ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('../configuraciones/configuraciones.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	
	$_SESSION['menu_principal'] = 5;

	//traigo datos del form
	$nombre = $_GET['localidad_nombre'];
	$codigo = $_GET['localidad_codigo_postal'];
	$provincia = $_GET['localidad_provincia_id'];
	$estado = $_GET['localidad_estado'];
	$aceptar = $_GET['aceptar'];
	//
		
	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	
	//nombre
	$frm ->addElement('text','localidad_nombre','Nombre: ',array('id' => 'localidad_nombre', 'value'=>''));
	
	//codigo postal
	$frm ->addElement('text','localidad_codigo_postal','C&oacute;digo Postal: ',array('id' => 'localidad_codigo_postal', 'value'=>''));
	
	//obtengo las provincias
	$do_provincia = DB_DataObject::factory('provincia');
	$provincias_select = $do_provincia -> get_provincias_todas();
	$frm ->addElement('select', 'localidad_provincia_id', 'Provincia: ', $provincias_select, array('id' => 'localidad_provincia_id'));
	//
	
	//estado
	$estado_form = array('Todos'=>'Todos','0'=>'Alta','1'=>'Baja');
	$frm ->addElement('select', 'localidad_estado', 'Estado: ', $estado_form, array('id' => 'localidad_estado'));
	//
	
	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Filtrar');
	$botones[] = $frm->createElement('button','cancelar','Limpiar Busqueda',array('onClick'=> "javascript: window.location.href='index.php'"));
	$frm->addGroup($botones);
	//
	
	//armo consulta con los datos del filtro
	$do_localidad = DB_DataObject::factory('localidad');
	$do_provincia = DB_DataObject::factory('provincia');
	$do_localidad -> joinAdd($do_provincia);
	
	if ($aceptar == 'Filtrar'){
		if ($nombre != ''){
			$do_localidad -> whereAdd("localidad_nombre like '%$nombre%'"); 
		}

		if ($codigo != ''){
			$do_localidad -> whereAdd("localidad_codigo_postal = '$codigo'"); 
		}
		
		if ($provincia != 'Todas'){
			$do_localidad -> whereAdd("localidad_provincia_id = '$provincia'"); 
		}
		
		if ($estado != 'Todos'){
			$do_localidad -> localidad_baja = $estado;
		}
	}
	$do_localidad -> orderBy('localidad_nombre');
	//
	
	//creo grilla
	$dg = new grilla(20);
	$dg->bind($do_localidad);
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Nombre</span>','localidad_nombre',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">C&oacute;digo Postal</span>','localidad_codigo_postal',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Provincia</span>','provincia_nombre',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Estado</span>',null,null,array('width' => '20%', 'align' => "center"),null,'get_estado_localidad',array('id' => 'localidad_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_modificar_localidad',array('id' => 'localidad_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla"></span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_eliminar_localidad',array('id' => 'localidad_id')));
	//
	
	//link para agregar un Localidad
    $agregar = '<br><a href="alta_localidad.php">[Agregar Localidad]</a>';
	
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
			$tpl->assign('msg', 'No hay localidades para mostrar.');
			$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
		}
	}
	
	$tpl->assign('body', '
		<div align=center><b>Localidades</b></div>
		<div align="center"><br/>'.$frm->toHTML().'</div>
		<div><br/>'.$agregar.'</div>
		<div><br/>'.$salida_grilla.'</div>
	');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Localidades');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
    exit;