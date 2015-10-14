<?php
    ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	//require_once('../seguridad/seguridad.config');
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
	$do_unidad_funcional = DB_DataObject::factory('unidad_funcional');
	$do_unidad_funcional ->fb_fieldsToRender = array(        
		'unidad_funcional_piso',
        'unidad_funcional_departamento',
        'unidad_funcional_cantidad_ambientes',
        'unidad_funcional_coeficiente',
        'unidad_funcional_dimensiones',
        'unidad_funcional_monto',
        'unidad_funcional_observacion',
        'unidad_funcional_estado_uf_id'
		);
	
	//Creo el formulario en base a la solicitud
	$fb =& DB_DataObject_FormBuilder::create($do_unidad_funcional);
	$frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->insertElementBefore($frm-> createElement('hidden','unidad_funcional_obra_civil_id',$_GET['contenido']));
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	$frm->setRequiredNote(FRM_NOTA);

	//$frm->addFormRule('encuentraunidad_funcional');
	
	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: cerrarDialogo()"));
	$botones[] = $frm->createElement('reset','restaurar','Limpiar');
	$frm->addGroup($botones);
	
	$error = '';
	if($frm->validate()) {
		$post = $frm->exportValues();
		$do_unidad_funcional->setFrom($post);
		$do_unidad_funcional->query('BEGIN');
		$id = $do_unidad_funcional->insert(); 
		
		// si se inserto se redirije a index.php, de lo contrario se muestra el error
		if ($id){
			$do_unidad_funcional->query('COMMIT');	
		}
		else{
			$do_unidad_funcional->query('ROLLBACK');			
			$error = 'Error en la generaci&oacute;n de los datos</b></div>';				
		}
		header('location:../obra_civil/index.php');
		ob_end_flush();
		exit;
	}		

	$tpl = new tpl();
	$titulo_grilla = 'Alta unidad funcional';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    //$tpl->assign('menu','popUpSinEncabezado.htm');
	//$tpl->assign('webTitulo', WEB_TITULO);
	//$tpl->assign('secTitulo', WEB_SECCION . ' - Alta unidad funcional');
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('popUpSinEncabezado.htm');
	ob_end_flush();
?>