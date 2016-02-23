<?php
    ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('servicio_tecnico.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	$_SESSION['menu_principal'] = 3;

	//traido id del modulo pasado por GET
	$servicio_tecnico_id = $_GET['contenido'];
	//$cliente_get = $_GET['cliente'];
		
	//DB_DataObject::debugLevel(5); 
	$do_servicio_tecnico = DB_DataObject::factory('servicio_tecnico');
	$do_servicio_tecnico -> servicio_tecnico_id = $servicio_tecnico_id;

	/*$do_trommel -> fb_fieldsToRender = array (
    	'trommel_diametro',
        'trommel_largo',
        'trommel_motor',
        'trommel_plano',
        'trommel_relacion_engranaje'
    );*/

    $do_servicio_tecnico -> find(true);
	
	if (!$do_servicio_tecnico->find(true)) {
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		exit;
	}
	
	//Creo el formulario en base a la solicitud
	$fb =& DB_DataObject_FormBuilder::create($do_servicio_tecnico);
	$frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	$frm->setRequiredNote(FRM_NOTA);

	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('button','cancelar','Volver',array('onClick'=> "javascript: window.history.back();"));
	$frm->addGroup($botones);
	
	$frm->freeze();	

	$tpl = new tpl();
	$titulo_grilla = 'Ver Servicio T&eacute;cnico';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>