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
	
	//recupero el id de la aplicacion a modificar
	$app_id = $_GET['contenido'];
	
	//recupero el nombre que tenia originalmente en la base
	$do_aplicacion = DB_DataObject::factory('aplicacion');
	$do_aplicacion -> app_id = $app_id;
	$do_aplicacion -> fb_fieldsToRender = array('app_nombre','app_baja');
	$do_aplicacion -> find(true);
	
	if (!$do_aplicacion->find(true)) {
		$paginaOriginante = 'index.php';
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		exit;
	}
	
	// Genero el formulario
	$fb =& DB_DataObject_Formbuilder::create($do_aplicacion);
	$frm = $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setRequiredNote(FRM_NOTA);
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php';"));
	$botones[] = $frm->createElement('reset','restaurar','Restaurar');
	$frm->addGroup($botones);
	
	// Si el formulado fue enviado y validado realizo la modificacion
	if($frm->validate()){
		
		//restauro los modulos asociados a la aplicacion
		$do_modulo = DB_DataObject::factory('modulo');
		$do_modulo -> mod_app_id = $app_id;
		$do_modulo -> find();
		while ($do_modulo -> fetch()){
			$do_modulo  -> mod_baja = 0;
			$do_modulo -> update();
		}
		
		$post = $frm->exportValues();
		$do_aplicacion->setFrom($post);
		$id = $do_aplicacion->update();
		
		if ($id){	
			$do_aplicacion->query('COMMIT');
		}
		else {
			$do_aplicacion->query('ROLLBACK');
			$error = 'Error en la modificaci&oacute;n de la aplicaci&oacute;n</b></div>';				
		}
		header('location:index.php');
		ob_end_flush();
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Modificar aplicaci&oacute;n';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_eco_reciclar.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Alta aplicaci&oacute;n');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
	exit;