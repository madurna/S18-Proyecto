<?php
	ob_start();
    require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('../seguridad/seguridad.config');
	// PEAR
	define(PERMISOS, 'Acceso,Modificacion,Baja');
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
		
	//DB_DataObject::debugLevel(5); 
		$_SESSION['menu_principal'] = 4;

	//recupero el id de la actividad a modificar
	$usuario_id = $_GET['contenido'];
	
	//recupero el nombre que tenia originalmente en la base
	$do_usuario = DB_DataObject::factory('usuario');
	$do_usuario -> usua_id = $usuario_id;
	$do_usuario -> fb_fieldsToRender = array('usua_usrid','usua_nombre','usua_pwd','usua_email','usua_tel1','usua_tel2','usua_baja');
	$do_usuario -> find(true);
	
	if (!$do_usuario->find(true)) {
		$paginaOriginante = 'index.php';
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		exit;
	}
	
	// Genero el formulario
	$fb =& DB_DataObject_Formbuilder::create($do_usuario);
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
		$post = $frm->exportValues();
		$do_usuario->setFrom($post);
		$id = $do_usuario->update();
		if ($id){	
			$do_usuario->query('COMMIT');
		}
		else {
			$do_usuario->query('ROLLBACK');
			$error = 'Error en la modificaci&oacute;n de la actividad</b></div>';				
		}
		header('location:index.php');
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Modificar usuario';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Modificar Usuario');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
	exit;