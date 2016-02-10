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

	//traido id del modulo pasado por GET
	$cliente_id = $_GET['contenido']; 

	//armo consulta con el id del modulo
	$do_contrato = DB_DataObject::factory('contrato');
	$do_contrato-> whereAdd("contrato_cliente_id = '$cliente_id'");
	
	$do_contrato-> orderBy('contrato_fecha');
	//$do_contrato->find();

	//creo grilla
	$dg = new grilla(20);
	$dg -> bind($do_contrato);
	//$titulo = '<div><p>Paginas del modulo: </p></div>';
	
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Fecha Contrato</span>','contrato_id',null,array('width' => '20px', 'align' => "center"),null,'get_contrato_fecha()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Bibliorato</span>','contrato_bibliorato',null,array('width' => '330px%', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">N&uacute;mero Caja</span>','contrato_caja_numero',null,array('width' => '330px%', 'align' => "center")));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Planta</span>','',null,array('width' => '330px', 'align' => "center" ),null,'get_editar_pagina',array('id' => 'modpag_id')));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla"></span>','',null,array('width' => '330px', 'align' => "center" ),null));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Fecha Alta Planta</span>','contrato_id',null,array('width' => '20px', 'align' => "center"),null,'get_contrato_alta_planta()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Planta</span>','',null,array('width' => '330px', 'align' => "center" ),null,'get_editar_pagina',array('id' => 'modpag_id')));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla"></span>',null,null,array('width' => '5%', 'align' => "center"),null,'get_eliminar_pagina',array('id' => 'modpag_id')));
		
	//link para agregar
    //$agregar = '<br><a href="alta_pagina.php?contenido='.$modulo_contenido.'">[Agregar]</a>';
	
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
		$tpl->assign('msg', 'No hay p&aacute;ginas para mostrar.');
	}
	
	$tpl->assign('body', '<h2>Contratos y Plantas</h2><div><br/>'.$salida_grilla.'</div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - P&aacute;ginas');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
    exit;