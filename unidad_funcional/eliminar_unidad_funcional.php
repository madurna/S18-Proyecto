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
	
	//recupero el id de la actividad a dar de baja
	$unidad_funcional_id = $_GET['contenido'];
	
	//recupero el nombre que tiene originalmente en la base
	$do_unidad_funcional = DB_DataObject::factory('unidad_funcional');
	$do_unidad_funcional -> unidad_funcional_id = $unidad_funcional_id;
	$do_unidad_funcional -> fb_fieldsToRender = array(
		'unidad_funcional_piso',
        'unidad_funcional_departamento',
        'unidad_funcional_cantidad_ambientes',
        'unidad_funcional_coeficiente',
        'unidad_funcional_dimensiones',
        'unidad_funcional_monto',
        'unidad_funcional_observacion',
        'unidad_funcional_estado'
	);
		
	if($do_unidad_funcional->find(true))
		{	
		$fb =& DB_DataObject_FormBuilder::create($do_unidad_funcional);
        $frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
		$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
		$frm->setRequiredNote(FRM_NOTA);
		$frm->freeze();
		//botones de aceptar , cancelar , limpiar
		$botones = array();
		$botones[] = $frm->createElement('submit','aceptar','Eliminar');
		$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: cerrarDialogo()"));
		$frm->addGroup($botones);
		}
	else 
		{
		$paginaOriginante = 'index.php';
		$tpl->assign('include_file','error.tpl');
		$tpl->assign('error_msg','Error: Registro Inexistente'); 
		$tpl->assign('error_volver','Volver'); 	
		$tpl->assign('error_volver_href',$paginaOriginante); 	
		$tpl->display('index.htm');
		ob_end_flush();
		exit;
		}
	
	if($frm->validate()){
		$do_unidad_funcional = DB_DataObject::factory('unidad_funcional');
		$do_unidad_funcional -> unidad_funcional_id = $unidad_funcional_id; 
		$delete = $do_unidad_funcional -> delete();
		
		if ($delete){
			$do_unidad_funcional->query('COMMIT;');
		} 
		else {
			$do_unidad_funcional->query('ROLLBACK');
			$error = 'Error en la eliminaci&oacute;n de la aplicaci&oacute;n</b></div>';				
		}
		header('location:../obra_civil/index.php');
		ob_end_flush();
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Eliminar unidad funcional';
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
	exit;