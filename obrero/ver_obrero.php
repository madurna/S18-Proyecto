<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	
	require_once('obrero.config');
	
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	
	require_once(AUTHFILE);
	
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	
	$_SESSION['menu_principal'] = 7;
	
	//print_r($_SESSION['usuario']['id']);
	
	//DB_DataObject::debugLevel(5); 
	
	//recupero el id del obrero a modificar
	$obrero_id = $_GET['contenido'];
	
	//recupero el nombre que tenia originalmente en la base
	$do_obrero = DB_DataObject::factory('obrero');
	$do_obrero -> obrero_id = $obrero_id;
	//$do_obrero -> fb_fieldsToRender = array('obrero_apellido, obrero_nombre, obrero_documento');	
	
	$do_obrero -> fb_fieldsToRender = array (
    	'obrero_apellido',
		'obrero_nombre',
		'obrero_tipo_doc_id',
		'obrero_nro_doc',
		'obrero_fecha_nacimiento',
		'obrero_direccion',
		'obrero_localidad_id',
		'obrero_CP',
		'obrero_CUIL',
		'obrero_cuenta_bancaria',
		'obrero_CBU',
		'obrero_fecha_inicio',
		'obrero_telefono',
		'obrero_tel_fijo_celular',
		'obrero_tel_laboral1',
		'obrero_tel_laboral2',
		'obrero_referido1',
		'obrero_referido2',
		'obrero_reparticion_id',
		'obrero_estado_id',		
    );
	
	$do_obrero -> find(true);
	
	if (!$do_obrero->find(true)) {
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		exit;
	}
	
	// Genero el formulario
	$fb =& DB_DataObject_Formbuilder::create($do_obrero);
	$frm = $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setRequiredNote(FRM_NOTA);
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	
	$frm->updateAttributes(array('accept-charset'=>'UTF-8'));
	
	$botones = array();
	//$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','volver','Volver',array('onClick'=> "javascript: window.location.href='index.php';"));
	//$botones[] = $frm->createElement('reset','restaurar','Restaurar');
	$frm->addGroup($botones);
	
	$frm->freeze();
	
	// Si el formulado fue enviado y validado realizo la modificacion
	/*if($frm->validate()){
		$post = $frm->exportValues();
		$do_obrero->setFrom($post);
		
		$ape=utf8_decode($post['obrero_apellido']);
		$do_obrero->obrero_apellido=$ape;
		
		$nom=utf8_decode($post['obrero_nombre']);
		$do_obrero->obrero_nombre=$nom;
		
		$dir=utf8_decode($post['obrero_direccion']);
		$do_obrero->obrero_direccion=$dir;
		
		$do_obrero->obrero_usuario_id=$_SESSION['usuario']['id'];
		
		//$this -> fb_preDefElements['obrero_direccion'] = $aux;
		
		$fecha = $post['obrero_fecha_inicio'];
		list($dia,$mes,$anio) = explode("-",$fecha);
		$fecha_db = $anio.'-'.$mes.'-'.$dia;
		$do_obrero->obrero_fecha_inicio = $fecha_db;
		
		$fecha = $post['obrero_fecha_nacimiento'];
		list($dia,$mes,$anio) = explode("-",$fecha);
		$fecha_db = $anio.'-'.$mes.'-'.$dia;
		$do_obrero->obrero_fecha_nacimiento = $fecha_db;
		
		$id = $do_obrero->update();
		
		if ($id){	
			$do_obrero->query('COMMIT');
		}
		else {
			$do_obrero->query('ROLLBACK');
			$error = 'Error en la modificaci&oacute;n del obrero</b></div>';				
		}
		header('Location:index.php');
		exit;
	}*/		
	
	$tpl = new tpl();
	$titulo_grilla = 'Ver obrero';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Ver obrero');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>