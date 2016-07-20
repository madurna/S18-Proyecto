<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	
	require_once('trommel.config');
	
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	
	require_once(AUTHFILE);
	
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	
	$_SESSION['menu_principal'] = 2;
	
	//DB_DataObject::debugLevel(5); 
	
	$id_trommel = $_GET['contenido'];

	$do_trommel = DB_DataObject::factory('trommel');
	$do_trommel -> trommel_id = $id_trommel;

	$do_trommel -> fb_fieldsToRender = array (
    	'trommel_diametro',
        'trommel_largo',
        'trommel_motor',
        'trommel_plano',
        'trommel_relacion_engranaje'
    );

    $do_trommel -> find(true);
	
	if (!$do_trommel->find(true)) {
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		exit;
	}
	
	// Genero el formulario
	$fb =& DB_DataObject_Formbuilder::create($do_trommel);
	$frm = $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setRequiredNote(FRM_NOTA);
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	
	$frm->updateAttributes(array('accept-charset'=>'UTF-8'));
	
	$botones = array();
	//$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Volver',array('onClick'=> "javascript: window.history.back();"));
	//$botones[] = $frm->createElement('reset','restaurar','Restaurar');
	$frm->addGroup($botones);
	
	// Si el formulado fue enviado y validado realizo la modificacion
	if($frm->validate()){
		$post = $frm->exportValues();
		$do_trommel->setFrom($post);
				
		$id = $do_trommel->update();
		
		if ($id){	
			$do_trommel->query('COMMIT');
		}
		else {
			$do_trommel->query('ROLLBACK');
			$error = 'Error en la modificaci&oacute;n del Trommel</b></div>';				
		}
		header('Location:index.php');
		exit;
	}		
	
	$tpl = new tpl();
	$titulo_grilla = 'Modificar Trommel';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_eco_reciclar.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Modificar Trommel');
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>