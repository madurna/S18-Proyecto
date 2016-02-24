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
	
	//DB_DataObject::debugLevel(5); 
	
	//recupero el id del cliente a modificar
	$cliente_id = $_GET['contenido'];
	
	//recupero el nombre que tenia originalmente en la base
	$do_cliente = DB_DataObject::factory('clientes');
	$do_cliente -> cliente_id = $cliente_id;
		
	$do_cliente -> fb_fieldsToRender = array (
    	'cliente_apellido',
		'cliente_nombre',
		'cliente_razon_social',
		'cliente_tipo_doc_id',
		'cliente_nro_doc',
		'cliente_fecha_nacimiento',
		'cliente_direccion',
		'cliente_localidad_id',
		'cliente_cuenta_corriente',
		'cliente_fecha_inicio',
		'cliente_telefono',
		'cliente_estado_id',
		'cliente_observacion'		
    );
	
	$do_cliente -> find();	

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
	$botones[] = $frm->createElement('button','volver','Volver',array('onClick'=> "javascript: window.location.href='index.php';"));
	$frm->addGroup($botones);
	
	$frm->freeze();
	
	$tpl = new tpl();
	$titulo_grilla = 'Ver cliente';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
   if(!($_GET['servicio_tecnico']))
   {
	    $tpl->assign('menu','menu_eco_reciclar.htm');
		$tpl->assign('webTitulo', WEB_TITULO);
		$tpl->assign('secTitulo', WEB_SECCION . ' - Ver cliente');
		//$tpl->assign('links',$links1);
		$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
		$tpl->display('index.htm');
	}else{
		$tpl->display('popUpSinEncabezado.htm');
	}
	ob_end_flush();
?>