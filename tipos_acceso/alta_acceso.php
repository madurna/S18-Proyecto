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
	$do_acceso = DB_DataObject::factory('tipo_acceso');
	//$do_acceso -> fb_fieldsToRender = array('tipoacc_nombre');
	
	//Creo el formulario en base a la solicitud
	$fb =& DB_DataObject_FormBuilder::create($do_acceso);
	$frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	$frm->setRequiredNote(FRM_NOTA);

	//$frm->addFormRule('encuentraTipoAcceso');
	
	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php';"));
	$botones[] = $frm->createElement('reset','restaurar','Limpiar');
	$frm->addGroup($botones);
	
	$error = '';
	if($frm->validate()) {
		$post = $frm->exportValues();
		$do_acceso->setFrom($post);
		$do_acceso->query('BEGIN');
		$id = $do_acceso->insert(); 
		
		// si se inserto se redirije a index.php, de lo contrario se muestra el error
		if ($id){
			$do_acceso->query('COMMIT');	
		}
		else{
			$do_acceso->query('ROLLBACK');			
			$error = 'Error en la generaci&oacute;n de los datos</b></div>';				
		}
		header('location:index.php');
		ob_end_flush();
		exit;
	}		

	$tpl = new tpl();
	$titulo_grilla = 'Alta tipo acceso';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Alta tipo acceso');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>