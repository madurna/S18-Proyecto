<?php
    ob_start();
    require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('trommel.config');
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
	$do_trommel = DB_DataObject::factory('trommel');
	$do_trommel -> id_planta = $planta_id;

	$do_trommel -> fb_fieldsToRender = array (
    	'trommel_diametro',
        'trommel_largo',
        'trommel_motor',
        'trommel_plano',
        'trommel_relacion_engranaje'
    );

	if($do_trommel->find(true)){
		$fb =& DB_DataObject_FormBuilder::create($do_trommel);
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
		$do_trommel = DB_DataObject::factory('trommel');
		$do_trommel -> id_planta = $planta_id;
		$do_trommel -> trommel_estado_id = 0;
		$update = $do_trommel -> update();
		
		if ($update){
			$do_trommel->query('COMMIT;');
		} 
		else {
			$do_trommel->query('ROLLBACK');
			$error = 'Error en la eliminaci&oacute;n del Trommel</b></div>';				
		}
		header('location:../planta/planta_pieza.php?contenido='.$planta_id);
		ob_end_flush();
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Eliminar Trommel';
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