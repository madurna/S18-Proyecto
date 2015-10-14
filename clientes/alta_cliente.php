<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	
	require_once('clientes.config');
	
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	$_SESSION['menu_principal'] = 8;
		
	//DB_DataObject::debugLevel(5); 
	$do_cliente = DB_DataObject::factory('clientes');
	
	$do_cliente -> fb_fieldsToRender = array (
    	'cliente_apellido',
		'cliente_nombre',
		'cliente_tipo_doc_id',
		'cliente_nro_doc',
		'cliente_fecha_nacimiento',
		'cliente_direccion',
		'cliente_localidad_id',
		'cliente_CP',
		'cliente_CUIL',
		'cliente_cuenta_bancaria',
		'cliente_CBU',
		'cliente_fecha_inicio',
		'cliente_telefono',
		'cliente_tel_fijo_celular',
		'cliente_tel_laboral1',
		'cliente_tel_laboral2',
		'cliente_referido1',
		'cliente_referido2',
		'cliente_estado_id',		
    );
	
	//Creo el formulario en base a la solicitud
	$fb =& DB_DataObject_FormBuilder::create($do_cliente);
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
		$do_cliente->setFrom($post);
		
		$ape=utf8_decode($post['cliente_apellido']);
		$do_cliente->cliente_apellido=$ape;
		
		$nom=utf8_decode($post['cliente_nombre']);
		$do_cliente->cliente_nombre=$nom;
		
		$dir=utf8_decode($post['cliente_direccion']);
		$do_cliente->cliente_direccion=$dir;
		
		$do_cliente->cliente_usuario_id=$_SESSION['usuario']['id'];
		
		$fecha = $post['cliente_fecha_inicio'];
		list($dia,$mes,$anio) = explode("-",$fecha);
		$fecha_db = $anio.'-'.$mes.'-'.$dia;
		$do_cliente->cliente_fecha_inicio = $fecha_db;
		
		$fecha = $post['cliente_fecha_nacimiento'];
		list($dia,$mes,$anio) = explode("-",$fecha);
		$fecha_db = $anio.'-'.$mes.'-'.$dia;
		$do_cliente->cliente_fecha_nacimiento = $fecha_db;
		
		$do_cliente->query('BEGIN');
		$id = $do_cliente->insert(); 
		
		//print_r($post);
		// si se inserto se redirije a index.php, de lo contrario se muestra el error
		if ($id){
			$do_cliente->query('COMMIT');	
		}
		else{
			$do_cliente->query('ROLLBACK');			
			$error = 'Error en la generaci&oacute;n de los datos</b></div>';				
		}
		header('location:index.php');
		exit;
	}		

	$tpl = new tpl();
	$titulo_grilla = 'Alta Cliente';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>
            ';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Alta Cliente');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>