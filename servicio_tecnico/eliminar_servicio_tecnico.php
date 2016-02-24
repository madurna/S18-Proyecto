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
		
	//DB_DataObject::debugLevel(5); 
	
	//recupero el id del servicio tecnico a dar de baja
	$id_servicio_tecnico = $_GET['contenido'];
	
	//recupero el nombre que tiene originalmente en la base
	$do_servicio_tecnico = DB_DataObject::factory('servicio_tecnico');
	$do_servicio_tecnico -> servicio_tecnico_id = $id_servicio_tecnico;
		
	if($do_servicio_tecnico->find(true))
		{	
		$fb =& DB_DataObject_FormBuilder::create($do_servicio_tecnico);
        $frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
		$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
		$frm->setRequiredNote(FRM_NOTA);
		$frm->freeze();
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
		$post = $frm->exportValues();
		$do_servicio_tecnico->setFrom($post);
		
		$do_servicio_tecnico -> servicio_tecnico_estado_id = 3;		
		$do_servicio_tecnico->query('BEGIN');
		$delete = $do_servicio_tecnico -> update(); 
				
		if ($delete){
			$do_servicio_tecnico->query('COMMIT;');
		} 
		else {
			$do_servicio_tecnico->query('ROLLBACK');
			$error = 'Error en la eliminaci&oacute;n del Servicio T&eacute;cnico</b></div>';				
		}
		header('location:index.php');
		ob_end_flush();
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Eliminar Servicio T&eacute;cnico';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_eco_reciclar.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Eliminar Servicio T&eacute;cnico');
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
	exit;