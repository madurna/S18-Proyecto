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
	$nombre = $_GET['pais_nombre'];
	$estado = $_GET['pais_estado'];
	$aceptar = $_GET['aceptar'];
		
	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	
	//nombre	
	$frm ->addElement('text','pais_nombre','Nombre: ',array('id' => 'pais_nombre', 'value'=>''));
	
	//estado
	$estado_form = array('Todos'=>'Todos','0'=>'Alta','1'=>'Baja');
	$frm ->addElement('select', 'pais_estado', 'Estado: ', $estado_form, array('id' => 'pais_estado'));
	//
	
	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Filtrar');
	$botones[] = $frm->createElement('button','cancelar','Limpiar Busqueda',array('onClick'=> "javascript: window.location.href='index.php'"));
	$frm->addGroup($botones);
	//
	
	//armo consulta con los datos del filtro
	$do_pais = DB_DataObject::factory('pais');
	if ($aceptar == 'Filtrar'){
		if ($nombre != ''){
			$do_pais -> whereAdd("pais_nombre like '%$nombre%'"); 
		}
		
		if ($estado != 'Todos'){
			$do_pais -> pais_baja = $estado;
		}
	}
	$do_pais -> orderBy('pais_nombre');
	//
	
	//creo grilla
	$dg = new grilla(20);
	$dg->bind($do_pais);
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Nombre</span>','pais_nombre',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Estado</span>',null,null,array('width' => '20%', 'align' => "center"),null,'get_estado_pais',array('id' => 'pais_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_modificar_pais',array('id' => 'pais_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla"></span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_eliminar_pais',array('id' => 'pais_id')));
	//
	
	//link para agregar un Pa&iacute;s
    $agregar = '<br><a href="alta_pais.php">[Agregar Pa&iacute;s]</a>';
	
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
			$tpl->assign('msg', 'No hay Paises para mostrar.');
			$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
		}
	}
	
	$tpl->assign('body', '
		<div align=center><b>Paises</b></div>
		<div align="center"><br/>'.$frm->toHTML().'</div>
		<div><br/>'.$agregar.'</div>
		<div><br/>'.$salida_grilla.'</div>
	');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Paises');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
    exit;