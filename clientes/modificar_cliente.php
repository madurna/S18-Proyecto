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
	
	require_once(AUTHFILE);
	
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	
	$_SESSION['menu_principal'] = 8;
	
	//print_r($_SESSION['usuario']['id']);
	
	//DB_DataObject::debugLevel(5); 
	
	//recupero el id del cliente a modificar
	$cliente_id = $_GET['contenido'];
	
	//recupero el nombre que tenia originalmente en la base
	$do_cliente = DB_DataObject::factory('clientes');
	$do_cliente -> cliente_id = $cliente_id;
	//$do_cliente -> fb_fieldsToRender = array('cliente_apellido, cliente_nombre, cliente_documento');	
	
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
		'cliente_reparticion_id',
		'cliente_estado_id',		
    );
	
	$do_cliente -> find(true);
	
	if (!$do_cliente->find(true)) {
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		exit;
	}
	
	// Genero el formulario
	$fb =& DB_DataObject_Formbuilder::create($do_cliente);
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
		$do_cliente->setFrom($post);
		
		$ape=utf8_decode($post['cliente_apellido']);
		$do_cliente->cliente_apellido=$ape;
		
		$nom=utf8_decode($post['cliente_nombre']);
		$do_cliente->cliente_nombre=$nom;
		
		$dir=utf8_decode($post['cliente_direccion']);
		$do_cliente->cliente_direccion=$dir;
		
		$do_cliente->cliente_usuario_id=$_SESSION['usuario']['id'];
		
		//$this -> fb_preDefElements['cliente_direccion'] = $aux;
		
		$fecha = $post['cliente_fecha_inicio'];
		list($dia,$mes,$anio) = explode("-",$fecha);
		$fecha_db = $anio.'-'.$mes.'-'.$dia;
		$do_cliente->cliente_fecha_inicio = $fecha_db;
		
		$fecha = $post['cliente_fecha_nacimiento'];
		list($dia,$mes,$anio) = explode("-",$fecha);
		$fecha_db = $anio.'-'.$mes.'-'.$dia;
		$do_cliente->cliente_fecha_nacimiento = $fecha_db;
		
		$id = $do_cliente->update();
		
		if ($id){	
			$do_cliente->query('COMMIT');
		}
		else {
			$do_cliente->query('ROLLBACK');
			$error = 'Error en la modificaci&oacute;n del cliente</b></div>';				
		}
		header('Location:index.php');
		exit;
	}		
	
	$tpl = new tpl();
	$titulo_grilla = 'Modificar cliente';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Modificar cliente');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>