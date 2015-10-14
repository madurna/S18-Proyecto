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
	$ur_id = $_GET['contenido'];
	
	//recupero el nombre que tiene originalmente en la base
	$do = DB_DataObject::factory('usuario_rol');
	$do-> usrrol_id = $ur_id;
    $do->joinAdd(DB_DataObject::factory('usuario'));
    $do->joinAdd(DB_DataObject::factory('rol'));
    $do->joinAdd(DB_DataObject::factory('aplicacion'));
	$do -> fb_fieldsToRender = array('usrrol_usua_id','usrrol_rol_id','usrrol_app_id');	
		
	if($do->find(true))
		{
		//recupero id del usuario
		$id_usuario = $do -> usrrol_usua_id;
		//
		$fb =& DB_DataObject_FormBuilder::create($do);
        $frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
		$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
		$frm->setRequiredNote(FRM_NOTA);
		$frm->freeze();
		//botones de aceptar , cancelar , limpiar
		$botones = array();
		$botones[] = $frm->createElement('submit','aceptar','Eliminar');
		$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php?contenido=$id_usuario';"));
		$frm->addGroup($botones);
		}
	else 
		{
		$paginaOriginante = "'index.php?contenido='$id_usuario";
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		ob_end_flush();
		exit;
		}
	
	if($frm->validate()){
		$do = DB_DataObject::factory('usuario_rol');
		$do -> usrrol_id = $ur_id; 
		$delete = $do -> delete();
		
		if ($delete){
			$do->query('COMMIT;');
		} 
		else {
			$do->query('ROLLBACK');
			$error = 'Error en la eliminaci&oacute;n del usuario rol</b></div>';				
		}
		header('location:index.php?contenido='.$id_usuario);
		ob_end_flush();
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Eliminar usuario rol';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Eliminar usuario rol');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
	exit;