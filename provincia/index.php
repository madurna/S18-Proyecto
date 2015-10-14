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
	$nombre = $_GET['provincia_nombre'];
	$pais = $_GET['pais'];
	$estado = $_GET['provincia_estado'];
	$aceptar = $_GET['aceptar'];
		
	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	
	//nombre	
	$frm ->addElement('text','provincia_nombre','Nombre: ',array('id' => 'provincia_nombre', 'value'=>''));
	
	//paises
	$do_pais = DB_DataObject::factory('pais');
	$pais_form = $do_pais -> get_pais_todos();
	$frm ->addElement('select', 'pais', 'Pa&iacute;s: ', $pais_form, array('id' => 'pais'));
	
	//estado
	$estado_form = array('Todos'=>'Todos','0'=>'Alta','1'=>'Baja');
	$frm ->addElement('select', 'provincia_estado', 'Estado: ', $estado_form, array('id' => 'provincia_estado'));
	//
	
	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Filtrar');
	$botones[] = $frm->createElement('button','cancelar','Limpiar Busqueda',array('onClick'=> "javascript: window.location.href='index.php'"));
	$frm->addGroup($botones);
	//
	
	//armo consulta con los datos del filtro
	$do_provincia = DB_DataObject::factory('provincia');
	$do_pais = DB_DataObject::factory('pais');
	$do_provincia -> joinAdd($do_pais);
	if ($aceptar == 'Filtrar'){
		if ($nombre != ''){
			$do_provincia -> whereAdd("provincia_nombre like '%$nombre%'"); 
		}
		
		if ($estado != 'Todos'){
			$do_provincia -> provincia_baja = $estado;
		}
		
		if ($pais != 'Todos'){
			$do_provincia -> provincia_pais_id = $pais;
		}
	}
	$do_provincia -> orderBy('provincia_nombre');
	//
	
	//creo grilla
	$dg = new grilla(20);
	$dg->bind($do_provincia);
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Nombre</span>','provincia_nombre',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Pa&iacute;s</span>','pais_nombre',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Estado</span>',null,null,array('width' => '20%', 'align' => "center"),null,'get_estado_provincia',array('id' => 'provincia_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_modificar_provincia',array('id' => 'provincia_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla"></span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_eliminar_provincia',array('id' => 'provincia_id')));
	//
	
	//link para agregar un Provincia
    $agregar = '<br><a href="alta_provincia.php">[Agregar Provincia]</a>';
	
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
			$tpl->assign('msg', 'No hay Provincias para mostrar.');
			$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
		}
	}
	
	$tpl->assign('body', '
		<div align=center><b>Provincias</b></div>
		<div align="center"><br/>'.$frm->toHTML().'</div>
		<div><br/>'.$agregar.'</div>
		<div><br/>'.$salida_grilla.'</div>
	');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Provincias');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
    exit;