<?php
ob_start();
require_once('../config/web.config');
require_once(CFG_PATH.'/smarty.config');
require_once(CFG_PATH.'/data.config');
// PEAR
require_once(INC_PATH.'/pear.inc');
//Funciones
require_once(INC_PATH.'/rules.php');
require_once('../seguridad/seguridad.config');

	$_SESSION['menu_principal'] = 4;

 //DB_DataObject::debugLevel(5);
 $reset_mensaje = "";
 session_start();

 //Creo el form para solicitar el mail
 $form = new HTML_QuickForm('NuevaClave','post',$_SERVER['REQUEST_URI']);
 $form->addElement('header', null, 'Introduzca su nueva clave.');
 $form->addElement('hidden', 'usua_id',$_GET['id']);

 $form->addElement('password', 'usua_pwd', 'Contrase&ntilde;a', array('size'=> 30), 'required');
 $form->setRequiredNote('* Campos requeridos');
 $form->setJsWarnings('Error', 'Por favor corrija estos campos');
 $form->addElement('submit', 'enviar', 'Enviar');

 //Reglas
 $form->applyFilter('usua_pwd', 'trim');
 $form->applyFilter('usua_pwd', 'strip_tags');
 $form->addRule('usua_pwd', 'Debe ingresar una nueva clave', 'required', null, 'client');

//Si es usuarios y tiene identificacion
//var_dump($_SESSION['usuario']);

//Tomo los datos del post
$data = array();
$ok = 0;
if($form->validate()) {
	$data = $form->exportValues();   
	if( ($data['usua_pwd']) and ($data['usua_id'])) {
		 
		//Busco el mail en la base
		$do = DB_DataObject::factory('usuario');
		$do->usua_id = $data['usua_id'];
		
		if($do->find(true)) {
		//Le genero una clave al usuario y la mando por mail
			$do->usua_pwd = md5($data['usua_pwd']);
		 
			if($do->update()) {
				 $reset_mensaje = "<b>Se cambio la clave con exito.</b>";
				 $ok = 1;
				 
			}
			else {

				$reset_mensaje = "<b>La clave no ha cambiado.</b>";
			}

			//$form->removeElement('enviar');
			//$form->freeze();
		}
		else {
		//El mail no esta, mensaje de error
			$reset_mensaje = "<b>No existe el usuario en nuestros registros.</b>";
		}
	}
	else {
		$reset_mensaje = "<b>Ha ocurrido un error en el cambio de clave.</b>";
	}
}


//Llamo a la template
$tpl = new tpl();
//Mensaje de error o exito
$tpl->assign('reset_mensaje',$reset_mensaje);

if(!$ok)
    $tpl->assign('form',$form->toHtml());
$tpl->assign('volver','../usuarios/modificar_usuario.php?contenido='.$_GET['id']);
//Header
$tpl->assign('webTitulo', WEB_TITULO);
$tpl->assign('secTitulo', WEB_SECCION);

$tpl->assign('menu','menu_oceba.tpl');
    //$tpl->assign('links', $links);
//Template del archivo
$tpl->assign('include_file','cambiar-clave.tpl');

//Mostrar en
$tpl->display('index.htm');
ob_end_flush();
?>