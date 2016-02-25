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
	$do_empleado = DB_DataObject::factory('empleado');
	
	$do_empleado -> fb_fieldsToRender = array (
    	'empleado_apellido',
        'empleado_nombre',
        'empleado_tipo_doc_id',
        'empleado_nro_doc',
        'empleado_CUIL',
        'empleado_fecha_nacimiento',
        'empleado_direccion',
        'empleado_localidad_id',
        'empleado_CP',
        'empleado_CBU',
        'empleado_fecha_inicio',
        'empleado_telefono',
        'empleado_sector_id',
        'empleado_tarea_id',
        'empleado_estado',
        'empleado_capacitacion',
        'empleado_sexo_id',
        'empleado_estado_civil_id'		
    );
	
	//Creo el formulario en base a la solicitud
	$fb =& DB_DataObject_FormBuilder::create($do_empleado);
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
		$do_empleado->setFrom($post);
		
		$ape=utf8_decode($post['empleado_apellido']);
		$do_empleado->empleado_apellido=$ape;
		
		$nom=utf8_decode($post['empleado_nombre']);
		$do_empleado->empleado_nombre=$nom;
		
		$dir=utf8_decode($post['empleado_direccion']);
		$do_empleado->empleado_direccion=$dir;
		
		$fecha = $post['empleado_fecha_inicio'];
		list($dia,$mes,$anio) = explode("-",$fecha);
		$fecha_db = $anio.'-'.$mes.'-'.$dia;
		$do_empleado->empleado_fecha_inicio = $fecha_db;
		
		$fecha = $post['empleado_fecha_nacimiento'];
		list($dia,$mes,$anio) = explode("-",$fecha);
		$fecha_db = $anio.'-'.$mes.'-'.$dia;
		$do_empleado->empleado_fecha_nacimiento = $fecha_db;
		
		$do_empleado->query('BEGIN');
		$id = $do_empleado->insert(); 
		
		//print_r($post);
		// si se inserto se redirije a index.php, de lo contrario se muestra el error
		if ($id){
			$do_empleado->query('COMMIT');	
		}
		else{
			$do_empleado->query('ROLLBACK');			
			$error = 'Error en la generaci&oacute;n de los datos</b></div>';				
		}
		header('location:index.php');
		exit;
	}		

	$tpl = new tpl();
	$titulo_grilla = 'Alta Empleado';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>
            ';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_eco_reciclar.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Alta Empleado');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>