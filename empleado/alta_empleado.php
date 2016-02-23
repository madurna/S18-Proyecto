<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	
	require_once('empleado.config');
	
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	$_SESSION['menu_principal'] = 7;
		
	//DB_DataObject::debugLevel(5); 
	$do_obrero = DB_DataObject::factory('obrero');
	
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
	
	//Creo el formulario en base a la solicitud
	$fb =& DB_DataObject_FormBuilder::create($do_obrero);
	$frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	$frm->setRequiredNote(FRM_NOTA);

	//$frm->addFormRule('encuentraRol');
	//
	
	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php';"));
	$botones[] = $frm->createElement('reset','restaurar','Limpiar');
	$frm->addGroup($botones);
	
	$error = '';
	if($frm->validate()) {
		$post = $frm->exportValues();
		$do_obrero->setFrom($post);
		
		$ape=utf8_decode($post['obrero_apellido']);
		$do_obrero->obrero_apellido=$ape;
		
		$nom=utf8_decode($post['obrero_nombre']);
		$do_obrero->obrero_nombre=$nom;
		
		$dir=utf8_decode($post['obrero_direccion']);
		$do_obrero->obrero_direccion=$dir;
		
		$do_obrero->obrero_usuario_id=$_SESSION['usuario']['id'];
		
		$fecha = $post['obrero_fecha_inicio'];
		list($dia,$mes,$anio) = explode("-",$fecha);
		$fecha_db = $anio.'-'.$mes.'-'.$dia;
		$do_obrero->obrero_fecha_inicio = $fecha_db;
		
		$fecha = $post['obrero_fecha_nacimiento'];
		list($dia,$mes,$anio) = explode("-",$fecha);
		$fecha_db = $anio.'-'.$mes.'-'.$dia;
		$do_obrero->obrero_fecha_nacimiento = $fecha_db;
		
		$do_obrero->query('BEGIN');
		$id = $do_obrero->insert(); 
		
		//print_r($post);
		// si se inserto se redirije a index.php, de lo contrario se muestra el error
		if ($id){
			$do_obrero->query('COMMIT');	
		}
		else{
			$do_obrero->query('ROLLBACK');			
			$error = 'Error en la generaci&oacute;n de los datos</b></div>';				
		}
		header('location:index.php');
		exit;
	}		

	$tpl = new tpl();
	$titulo_grilla = 'Alta obrero';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>
            ';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Alta obrero');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>