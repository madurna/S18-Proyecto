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
	
	//recupero el id de la pagina a modificar
	$modpag_mod_id = $_GET['contenido'];
	
	//recupero el nombre que tenia originalmente en la base
	$do_modpagina = DB_DataObject::factory('modulo_paginas');
	$do_modpagina -> modpag_id = $modpag_mod_id;
	$do_modpagina -> find(true);
	$modulo_id = $do_modpagina -> modpag_mod_id;
	
	/*
	if (!$do_modpagina->find(true)) {
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		exit;
	}
	*/
	
	// Genero el formulario
	$fb =& DB_DataObject_Formbuilder::create($do_modpagina);
	$frm = $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setRequiredNote(FRM_NOTA);
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	//valido que no existe la pagina ingresada
	$frm->addFormRule('validarPagina');	
	$frm->freeze('modpag_mod_id');
	
	
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php?contenido=$modulo_id'"));
	$botones[] = $frm->createElement('reset','restaurar','Restaurar');
	$frm->addGroup($botones);
	
	
	// Si el formulado fue enviado y validado realizo la modificacion
	if($frm->validate()){
		$post = $frm->exportValues();
		$do_modpagina->setFrom($post);
		$id = $do_modpagina->update();
		
		if ($id){	
			$do_modpagina->query('COMMIT');
		}
		else {
			$do_modpagina->query('ROLLBACK');
		}
		header("location:index.php?contenido=$modulo_id");
		ob_end_flush();
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Modificar P&aacute;gina';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Modificar P&aacute;gina');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
	exit;