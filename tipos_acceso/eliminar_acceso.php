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
	$acceso_id = $_GET['contenido'];
	
	//recupero el nombre que tiene originalmente en la base
	$do_acceso = DB_DataObject::factory('tipo_acceso');
	$do_acceso -> tipoacc_id = $acceso_id;
	$do_acceso -> fb_fieldsToRender = array('tipoacc_nombre');	
		
	if($do_acceso->find(true))
		{	
		$fb =& DB_DataObject_FormBuilder::create($do_acceso);
        $frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
		$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
		$frm->setRequiredNote(FRM_NOTA);
		$frm->freeze();
		//valido que no haya algun permiso que utilice este tipo de acceso
		$frm->addFormRule('validarTipoAcceso');		
		//botones de aceptar , cancelar , limpiar
		$botones = array();
		$botones[] = $frm->createElement('submit','aceptar','Eliminar');
		$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php';"));
		$frm->addGroup($botones);
		}
	else 
		{
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
		$do_acceso = DB_DataObject::factory('tipo_acceso');
		$do_acceso -> tipoacc_id = $acceso_id;
		if ($do_acceso -> find(true)){
			$do_acceso -> tipoacc_baja = '1';
			$update = $do_acceso -> update();
		} 
			
		if ($update){
			$do_acceso->query('COMMIT;');
		} 
		else {
			$do_acceso->query('ROLLBACK');
			$error = 'Error en la eliminaci&oacute;n del tipo acceso</b></div>';				
		}
		header('location:index.php');
		ob_end_flush();
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Eliminar tipo acceso';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Eliminar tipo acceso');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
	exit;