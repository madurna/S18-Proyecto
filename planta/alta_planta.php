<?php
    ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('../planta/planta.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	$_SESSION['menu_principal'] = 2;

	//traido id del modulo pasado por GET
	$contrato_get = $_GET['contenido'];
	$cliente_get = $_GET['cliente'];
		
	//DB_DataObject::debugLevel(5); 
	$do_planta = DB_DataObject::factory('planta');

	$do_planta -> fb_fieldsToRender = array (
    	'planta_direccion',
        'planta_fecha_inicio',
        'planta_fecha_fin',
        'planta_precio_estimado',
        'planta_color',
        'planta_estado_id',
        'planta_localidad_id',
        'planta_descripcion'		
    );
	
	//Creo el formulario en base a la solicitud
	$fb =& DB_DataObject_FormBuilder::create($do_planta);
	$frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	$frm->setRequiredNote(FRM_NOTA);

	
	$do_cliente = DB_DataObject::factory('clientes');
	$do_cliente -> orderBy('cliente_apellido');
	$do_cliente -> find();

	$clientes_v = [];
 	while($do_cliente -> fetch()){
 		$clientes_v[ $do_cliente->cliente_id ] = utf8_encode($do_cliente -> cliente_apellido).' '. utf8_encode($do_cliente -> cliente_nombre);
	}

	if($cliente_get == ''){
		$frm -> addElement('select', 'cliente', 'Cliente: ',$clientes_v, array('id' => 'cliente'));
	}else{
		$frm -> addElement('text', 'cliente', 'Cliente: ',array('id'=>'cliente','size'=>'30','value'=>$clientes_v[ $cliente_get ],'readonly'=>'readonly'));
	}
	
	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php';"));
	$botones[] = $frm->createElement('reset','restaurar','Limpiar');
	$frm->addGroup($botones);
	
	$error = '';
	if($frm->validate()) {
		$post = $frm->exportValues();
		$do_planta->setFrom($post);
		$fecha_fin = $post['planta_fecha_fin'];
		$fecha_inicio =$post['planta_fecha_inicio']; //print_r($fecha_inicio);exit;
		$do_planta-> planta_fecha_fin = setFecha($fecha_fin);
		$do_planta-> planta_fecha_inicio = setFecha($fecha_inicio);
        if($cliente_get == ''){
            $cliente_get = $post['cliente'];
        }
		$do_planta-> planta_contrato_id = $contrato_get;
		$do_planta-> planta_cliente_id = $cliente_get; 
		$do_planta->query('BEGIN');
		$id = $do_planta->insert(); 
		
		// si se inserto se redirije a index.php, de lo contrario se muestra el error
		if ($id){
			$do_planta->query('COMMIT');
			header('location:planta_pieza.php?contenido='.$contrato_get.'&cliente='.$cliente_get);
			ob_end_flush();
			exit;	
		}
		else{
			$do_planta->query('ROLLBACK');			
			$error = 'Error en la generaci&oacute;n de los datos</b></div>';				
		}
	}		

	$tpl = new tpl();
	$titulo_grilla = 'Alta de Planta';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_eco_reciclar.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>