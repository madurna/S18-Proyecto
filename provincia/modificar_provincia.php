<?php
    ob_start();
    require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('../configuraciones/configuraciones.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	
	$_SESSION['menu_principal'] = 5;
	
	//obtengo el id del Provincia a modificar
	$provincia_id = $_GET['contenido'];
	
	//creo el objeto de "provincia" y recupero el nombre que tenia originalmente en la base
	$do_provincia = DB_DataObject::factory('provincia');
	$do_provincia -> provincia_id = $provincia_id;

	//Creo template
	$tpl = new tpl();
	$titulo_grilla = 'Modificar Provincia';	
	$error = '';
	//
	
	//verifico que exista el Provincia
	if (!$do_provincia -> find(true)) {
		$paginaOriginante = 'index.php';
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		exit;
	}
	//
	
	// Genero el formulario
	$fb =& DB_DataObject_Formbuilder::create($do_provincia);
	$frm = $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setRequiredNote(FRM_NOTA);
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
//$frm->addFormRule('encuentraTipoConceptoMod');
	//
	
	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php';"));
	$botones[] = $frm->createElement('reset','restaurar','Restaurar');
	$frm->addGroup($botones);
	//
	
	// Si el formulado fue enviado y validado realizo la modificacion
	if($frm -> validate()){
		$post = $frm->exportValues();
		$do_provincia->setFrom($post);
		$id = $do_provincia->update();
		
		if ($id){	
			$do_provincia -> query('COMMIT');
			header('location:index.php');
			ob_end_flush();
			exit;
		}
		else {
			$do_provincia-> query('ROLLBACK');
			$error = 'Error en la modificaci&oacute;n del Provincia</b></div>';
			$tpl->assign('include_file', 'cartel.htm'); 
			$tpl->assign('imagen', 'informacion.jpg');
			$tpl->assign('msg', $error);			
		}
	}
	//

	//asigno el body
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Modificar Provincia');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
	exit;