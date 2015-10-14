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
	
	//obtengo el id del pais a dar de baja
	$pais_id = $_GET['contenido'];
	
	//creo el objeto de "pais" y recupero el nombre que tenia originalmente en la base
	$do_pais = DB_DataObject::factory('pais');
	$do_pais -> pais_id = $pais_id;
	$do_pais -> fb_fieldsToRender = array('pais_nombre');

	//Creo template
	$tpl = new tpl();
	$titulo_grilla = 'Eliminar pa&iacute;s';	
	$error = '';
	//
	
	//verifico que exista el pais
	if (!$do_pais -> find(true)) {
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
	$fb =& DB_DataObject_Formbuilder::create($do_pais);
	$frm = $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setRequiredNote(FRM_NOTA);
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	$frm->freeze();
	//
	
	//botones de eliminar y cancelar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Eliminar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php';"));
	$frm->addGroup($botones);
	//
	
	// Si el formulado fue enviado y validado realizo la eliminacion (campo baja en 1)
	if($frm -> validate()){
		$do_pais -> pais_baja = '1';
		$id = $do_pais -> update();
		
		if ($id){	
			$do_pais -> query('COMMIT');
			header('location:index.php');
			ob_end_flush();
			exit;
		}
		else {
			$do_pais-> query('ROLLBACK');
			$error = 'Error en la eliminaci&oacute;n del pa&iacute;s</b></div>';
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
	$tpl->assign('secTitulo', WEB_SECCION . ' - Eliminar pa&iacute;s');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
	exit;