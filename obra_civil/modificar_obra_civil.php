<?php
    ob_start();
    require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('../obra_civil/obra_civil.config');
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
	
	//recupero el id de la obra_civil a modificar
	$obra_civil_id = $_GET['contenido'];
	
	//recupero el nombre que tenia originalmente en la base
	$do_obra_civil = DB_DataObject::factory('obra_civil');
	$do_obra_civil -> obra_civil_id = $obra_civil_id;
	$do_obra_civil -> fb_fieldsToRender = array('obra_civil_descripcion','obra_civil_direccion','obra_civil_valor_compra','obra_civil_dimensiones_terreno','obra_civil_fecha_inicio','obra_civil_fecha_fin','obra_civil_cantidad_pisos','obra_civil_estado_id','obra_civil_localidad_id');
	$do_obra_civil -> find(true);
	
	if (!$do_obra_civil->find(true)) {
		$paginaOriginante = 'index.php';
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		exit;
	}
	
	// Genero el formulario
	$fb =& DB_DataObject_Formbuilder::create($do_obra_civil);
	$frm = $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setRequiredNote(FRM_NOTA);
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php';"));
	$botones[] = $frm->createElement('reset','restaurar','Restaurar');
	$frm->addGroup($botones);
	
	// Si el formulado fue enviado y validado realizo la modificacion
	if($frm->validate()){
		
		$post = $frm->exportValues();
		$do_obra_civil->setFrom($post);
		$fecha_fin = fechaISO($post['obra_civil_fecha_fin']);
		$fecha_inicio = fechaISO($post['obra_civil_fecha_inicio']);
		$do_obra_civil-> obra_civil_fecha_fin = $fecha_fin;
		$do_obra_civil-> obra_civil_fecha_inicio = $fecha_inicio; 
		$id = $do_obra_civil->update();
		
		if ($id){	
			$do_obra_civil->query('COMMIT');
		}
		else {
			$do_obra_civil->query('ROLLBACK');
			$error = 'Error en la modificaci&oacute;n de la Obra Civil</b></div>';				
		}
		header('location:index.php');
		ob_end_flush();
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Modificar Obra Civil';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
	exit;