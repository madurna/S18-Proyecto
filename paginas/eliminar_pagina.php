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
	
	//recupero el id de la actividad a dar de baja
	$modpag_mod_id = $_GET['contenido'];
	
	//recupero el nombre que tiene originalmente en la base
	$do_eliminar = DB_DataObject::factory('modulo_paginas');
	$do_eliminar -> modpag_id = $modpag_mod_id;
	$do_eliminar -> fb_fieldsToRender = array('modpag_scriptname');	
		
	if($do_eliminar->find(true))
		{
		$modulo_id = $do_eliminar -> modpag_mod_id;		
		$fb =& DB_DataObject_FormBuilder::create($do_eliminar);
        $frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
		$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
		$frm->setRequiredNote(FRM_NOTA);
		$frm->freeze();
		//botones de aceptar , cancelar , limpiar
		$botones = array();
		$botones[] = $frm->createElement('submit','aceptar','Eliminar');
		$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php?contenido=$modulo_id'"));
		$frm->addGroup($botones);
		}
	else 
		{
		$paginaOriginante = "'index.php?contenido='.$modulo_id";
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		ob_end_flush();
		exit;
		}
	
	if($frm->validate()){
		$do_eliminar = DB_DataObject::factory('modulo_paginas');
		$do_eliminar -> modpag_id = $modpag_mod_id; 
		if($do_eliminar->find(true))
			$delete = $do_eliminar -> delete();
		
		if ($delete){
			$do_eliminar->query('COMMIT;');
		} 
		else {
			$do_eliminar->query('ROLLBACK');
			$error = 'Error en la eliminaci&oacute;n de la P&aacute;gina</b></div>';				
		}
		header("location:index.php?contenido=$modulo_id");
		ob_end_flush();
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Eliminar P&aacute;gina';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_eco_reciclar.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Eliminar P&aacute;gina');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
    ob_end_flush();
	exit;