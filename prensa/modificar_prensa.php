<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	
	require_once('prensa.config');
	
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
	
	//traido id del modulo pasado por GET
	$planta_id = $_GET['contenido'];
	//$cliente_get = $_GET['cliente'];
		
	//DB_DataObject::debugLevel(5); 
	$do_prensa = DB_DataObject::factory('prensa');
	$do_prensa -> id_planta = $planta_id;

	$do_prensa -> fb_fieldsToRender = array (
    	'prensa_alto',
        'prensa_ancho',
        'prensa_motor',
        'prensa_bomba',
        'prensa_cilindro',
        'prensa_comando',
        'prensa_fondo',
        'prensa_kilajeMax',
        'prensa_plano'
    );

    $do_prensa -> find(true);
	
	if (!$do_prensa->find(true)) {
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		exit;
	}
	
	// Genero el formulario
	$fb =& DB_DataObject_Formbuilder::create($do_prensa);
	$frm = $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setRequiredNote(FRM_NOTA);
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	
	$frm->updateAttributes(array('accept-charset'=>'UTF-8'));
	
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php';"));
	$botones[] = $frm->createElement('reset','restaurar','Restaurar');
	$frm->addGroup($botones);
	
	
	// Si el formulado fue enviado y validado realizo la modificacion
	if($frm->validate()){
		$post = $frm->exportValues();
		$do_prensa->setFrom($post);
				
		$id = $do_prensa->update();
		
		if ($id){	
			$do_prensa->query('COMMIT');
		}
		else {
			$do_prensa->query('ROLLBACK');
			$error = 'Error en la modificaci&oacute;n de la Prensa</b></div>';				
		}
		header('Location:index.php');
		exit;
	}		
	
	$tpl = new tpl();
	$titulo_grilla = 'Modificar Prensa';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_eco_reciclar.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Modificar Prensa');
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>