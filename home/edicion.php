<?php
	ob_start();
	/*
	* Genera un formulario y modifica un registro en base a los datos solicitados por GET
	*	$_GET['contenido']: (string) Referencia a la tabla origen de datos.
	*	$_GET['identificacion']: (int) Id de registro.
	*    
	*/	
	require_once('../config/web.config');
	require_once(AUTHFILE);
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	require_once('home.config');
	// links
	//require_once('home.config');
	// PEAR
	require_once(INC_PATH.'/pear.inc');
	// Librerias propias
	
	//DB_DataObject::debugLevel(5);
	$id= $_SESSION['usuario']['id'];
	$do = DB_DataObject::factory('usuario');
	$do->usua_id = $id;
	$do->cambiar_datos = true;
		$_SESSION['menu_principal'] = 12;

	
	$tpl = new tpl();
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Perfil');	
	$tpl->assign('menu', "menu_oceba.htm");		
	$tpl->assign('usuario',$_SESSION['usuario']['nombre']);
	
	if ($do->find(true)) {
		$do->usua_pwd = null;
		
		// Genero el formulario
		$fb =& DB_DataObject_Formbuilder::create($do);
		$frm = $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
		$frm->setRequiredNote(FRM_NOTA);
		$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
		
		$frm->addFormRule('buscaUsuario');	
		$frm->addFormRule('buscaEmailUsuario');	
		$frm->addRule('usua_email', 'El mail es incorrecto', 'checkmail', true);
		
		// Si el formulado fue enviado y validado realizo la modificacion
		if($frm->validate()) {
			$post = $frm->exportValues();
			$do->setFrom($post);
			if ($do->update() !== null){
				$tpl->assign('body','<div id="contenido"><p><b>Los datos han sido actualizados</b></p></div><a href="home.php">[Volver]</a>');
				$tpl->display('index.htm');
				exit;
			}
			else {
				$tpl->assign('body',
					'<div id="contenido"><p><b>No se han actualizado los datos</b></p></div><a href="home.php">[Volver]</a>');
					$tpl->display('index.htm');
					exit;
			}
		}		
		$tpl->assign('body','<h2>Perfil</h2>
		<script type="text/javascript">
			$(document).ready(function(){
				$("input[type=\'text\']:enabled:first").focus();
			});
			</script>
			<div id="contenido"><p>'.$frm->toHtml().'</p></div>
			<a href="javascript:document.frm.submit();">[Guardar]</a>&nbsp;
			<a href="../index.php">[Volver]</a>');
		$tpl->display('index.htm');
		exit;
	} 
	else {
		$tpl = new tpl();
		$tpl->assign('webTitulo', WEB_TITULO);
		$tpl->assign('secTitulo', WEB_SECCION . ' - Perfil');		
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Parametro Incorrecto'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		exit;
	} 
	ob_end_flush();	
?>
