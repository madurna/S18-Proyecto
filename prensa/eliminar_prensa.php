<?php
    ob_start();
    require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('prensa.config');
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
	$id_prensa = $_GET['contenido'];
	
	//recupero el nombre que tiene originalmente en la base
	$do_prensa = DB_DataObject::factory('prensa');
	$do_prensa -> prensa_id = $id_prensa;

	if($do_prensa->find(true)){
		$fb =& DB_DataObject_FormBuilder::create($do_prensa);
        $frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
		$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
		$frm->setRequiredNote(FRM_NOTA);
		$frm->freeze();
		//botones de aceptar , cancelar , limpiar
		$botones = array();
		$botones[] = $frm->createElement('submit','aceptar','Eliminar');
		$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.history.back();"));
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
		$do_prensa = DB_DataObject::factory('prensa');
		$do_prensa -> prensa_id = $id_prensa;
		$do_prensa -> prensa_estado_id = 0;
		$update = $do_prensa -> update();
		
		if ($update){
			$do_prensa->query('COMMIT;');
		} 
		else {
			$do_prensa->query('ROLLBACK');
			$error = 'Error en la eliminaci&oacute;n de la Prensa</b></div>';				
		}
		header('location:../planta/planta_pieza.php?contenido='.$planta_id);
		ob_end_flush();
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Eliminar Prensa';
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