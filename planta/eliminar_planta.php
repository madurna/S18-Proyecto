<?php
    ob_start();
    require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('planta.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	$_SESSION['menu_principal'] = 2;
		
	//DB_DataObject::debugLevel(5); 
	
	//recupero el id de la planta a dar de baja
	$planta_id = $_GET['contenido'];
	
	//recupero el nombre que tiene originalmente en la base
	$do_planta = DB_DataObject::factory('planta');
	$do_planta -> planta_id = $planta_id;
	//$do_tarea -> fb_fieldsToRender = array('tarea_descripcion');
	//
	//
    $do_planta -> fb_fieldsToRender = array (
        'planta_direccion',
        'planta_fecha_inicio',
        'planta_fecha_fin',
        'planta_precio_estimado',
        'planta_color',
        'planta_estado_id',
        'planta_localidad_id',
        'planta_descripcion'
    );

	if($do_planta->find(true)){
		$fb =& DB_DataObject_FormBuilder::create($do_planta);
        $frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
		$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
		$frm->setRequiredNote(FRM_NOTA);
		$frm->freeze();
		//botones de aceptar , cancelar , limpiar
		$botones = array();
		$botones[] = $frm->createElement('submit','aceptar','Eliminar');
		$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php';"));
		$frm->addGroup($botones);
	}else{
		$paginaOriginante = 'index.php';
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		ob_end_flush();
		exit;
	}
	
	if($frm->validate()){
		$do_planta = DB_DataObject::factory('planta');
		$do_planta -> planta_id = $planta_id;
        $fecha_fin = $post['planta_fecha_fin']; //print_r($fecha_fin);exit;
        $fecha_inicio =$post['planta_fecha_inicio'];
        $do_planta-> planta_fecha_fin = setFecha($fecha_fin);
        $do_planta-> planta_fecha_inicio = setFecha($fecha_inicio);
		$do_planta -> planta_estado_id = 3;
		$update = $do_planta -> update();
		
		if ($update){
			$do_planta->query('COMMIT;');
		} 
		else {
			$do_planta->query('ROLLBACK');
			$error = 'Error en la eliminaci&oacute;n de la Planta</b></div>';				
		}
		header('location:index.php');
		ob_end_flush();
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Eliminar Planta';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_eco_reciclar.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
	exit;