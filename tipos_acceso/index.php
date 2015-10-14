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
	$nombre = $_GET['acceso_nombre'];
	$estado = $_GET['acceso_baja'];
	$aceptar = $_GET['aceptar'];
		
	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	//nombre	
	$frm ->addElement('text','acceso_nombre','Nombre: ',array('id' => 'acceso_nombre', 'value'=>''));
	$estado_form = array('Todos'=>'Todos','0'=>'Alta','1'=>'Baja');
	$frm ->addElement('select', 'acceso_baja', 'Estado: ', $estado_form, array('id' => 'acceso_baja'));
	//aceptar
	$frm ->addElement('submit','aceptar','Filtrar',null);
	
	//armo consulta con los datos del filtro
	$do_acceso= DB_DataObject::factory('tipo_acceso');
	if($aceptar == 'Filtrar'){
		if ($nombre != '')
			$do_acceso -> whereAdd("tipoacc_nombre like '%$nombre%'"); 
		if ($estado != 'Todos')
			$do_acceso -> tipoacc_baja = $estado;
	}  
	$do_acceso -> orderBy('tipoacc_nombre');
	
	//creo grilla
	$dg = new grilla(20);
	$dg->bind($do_acceso);
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Nombre</span>','tipoacc_nombre',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Estado</span>',null,null,array('width' => '20%', 'align' => "center"),null,'get_estado_tipoacc',array('id' => 'tipoacc_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_modificar_tipoacc',array('id' => 'tipoacc_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla"></span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_eliminar_tipoacc',array('id' => 'tipoacc_id')));
		
	//link para agregar un tipo de acceso
    $agregar = '<br><a href="alta_acceso.php">[Agregar tipo acceso]</a>';
	
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
			$tpl->assign('msg', 'No hay tipos de acceso para mostrar.');
			$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
		}
	}
	$tpl->assign('body', '<div align=center><b>Tipos Acceso</b></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><div><br/>'.$agregar.'</div><div><br/>'.$salida_grilla.'</div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Tipos Acceso');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();	    
    exit;