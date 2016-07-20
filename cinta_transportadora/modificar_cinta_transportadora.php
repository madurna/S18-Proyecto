<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	
	require_once('cinta_transportadora.config');
	
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
	
	//recupero el id del cliente a modificar
	$id_cinta_transportadora = $_GET['contenido'];
	
	$do_cinta_transportadora = DB_DataObject::factory('cinta_transportadora');
	$do_cinta_transportadora -> cinta_transportadora_id = $id_cinta_transportadora;

	$do_cinta_transportadora -> fb_fieldsToRender = array (
    	'cinta_transportadora_motor',
        'cinta_transportadora_largo',
        'cinta_transportadora_ancho',
        'cinta_transportadora_material',
        'cinta_transportadora_tipo_cinta'
    );

    $do_cinta_transportadora -> find(true);
	
	if (!$do_cinta_transportadora->find(true)) {
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		exit;
	}
	
	// Genero el formulario
	$fb =& DB_DataObject_Formbuilder::create($do_cinta_transportadora);
	$frm = $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setRequiredNote(FRM_NOTA);
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	
	$frm->updateAttributes(array('accept-charset'=>'UTF-8'));
	
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.history.back();"));
	//$botones[] = $frm->createElement('reset','restaurar','Restaurar');
	$frm->addGroup($botones);
	
	
	// Si el formulado fue enviado y validado realizo la modificacion
	if($frm->validate()){
		$post = $frm->exportValues();
		$do_cinta_transportadora->setFrom($post);
				
		$id = $do_cinta_transportadora->update();
		
		if ($id){	
			$do_cinta_transportadora->query('COMMIT');
		}
		else {
			$do_cinta_transportadora->query('ROLLBACK');
			$error = 'Error en la modificaci&oacute;n de la Cinta Transportadora</b></div>';				
		}
		header('Location:index.php');
		exit;
	}		
	
	$tpl = new tpl();
	$titulo_grilla = 'Modificar Cinta Transportadora';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_eco_reciclar.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Modificar Cinta Transportadora');
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>