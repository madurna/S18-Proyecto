<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('../seguridad/seguridad.config');
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
	$do_usuario = DB_DataObject::factory('usuario');
	$do_usuario_rol = DB_DataObject::factory('usuario_rol');
	//$do_actividad ->fb_fieldsToRender = array('actividad_nombre');
	//$do_actividad->find(true);
	
	//Creo el formulario en base a la solicitud
	$fb =& DB_DataObject_FormBuilder::create($do_usuario);
	$frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	$frm->setRequiredNote(FRM_NOTA);
	
	$fb_usuario =& DB_DataObject_FormBuilder::create($do_usuario_rol);
	$fb_usuario->useForm($frm);
	$fb_usuario->fb_clientRules = true;
	$frm =& $fb_usuario->getForm(); 
	$frm->removeElement('usrrol_usua_id');
	$frm->addFormRule('checkUserId');
	$frm->addFormRule('encuentraUsuario');
	//$frm->registerRule('checkmail', 'callback', 'checkEmail');
	$frm->addRule('usua_email', 'El mail es incorrecto', 'checkmail', true);		
	//$do_usuario_empresa->fb_selectAddEmpty = array('usremp_emp_id');
	//$fb_usuario2 =& DB_DataObject_FormBuilder::create($do_usuario_empresa);
	//$fb_usuario2->useForm($frm);
	//$frm =& $fb_usuario2->getForm();
	
	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php';"));
	$botones[] = $frm->createElement('reset','restaurar','Limpiar');
	$frm->addGroup($botones);
	
	$error = '';
	if($frm->validate()) {
		$post = $frm->exportValues();
		$do_usuario->setFrom($post);
		$do_usuario->query('BEGIN');
		$id = $do_usuario->insert(); 
		
		// si se inserto se redirije a index.php, de lo contrario se muestra el error
		if ($id){	
			$do_usuario_rol->usrrol_usua_id = $do_usuario->usua_id;
			$do_usuario_rol->usrrol_rol_id = $post['usrrol_rol_id'];
			$do_usuario_rol->usrrol_app_id = $post['usrrol_app_id'];
			$id = $do_usuario_rol->insert();

			$do_usuario->query('COMMIT');
		}		
			/*if ($id){
				if ($post['usremp_emp_id']) {
						$do_usuario_empresa ->usremp_emp_id = $post['usremp_emp_id'];
						$do_usuario_empresa ->usremp_usua_id = $do->usua_id;
						$id = $do_usuario_empresa->insert();						
						if(!$id) {							
							$do->query('ROLLBACK');
							$error = 'Error en la asignaci&oacute;n de la empresa al usuario</b></div>';				
							exit;
						}
					}
					$do->query('COMMIT');
					header('location:index.php?contenido='.$_GET['contenido'].'&id='.$_GET['id']);
					exit;
				}
				else {
					$do->query('ROLLBACK');
					$error = 'Error en la generaci&oacute;n del rol del usuario</b></div>';				
					exit;
				}						
			
		}*/
		else{
			$do_usuario->query('ROLLBACK');			
			$error = 'Error en la generaci&oacute;n de los datos</b></div>';				
		}
		header('location:index.php');
		ob_end_flush();
		exit;		
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Alta usuario';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Alta usuario');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>