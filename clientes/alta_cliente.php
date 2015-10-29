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

	//POST
	$razon_social = $_POST[razon_social];
	$nombre = $_POST[nombre];
	$apellido = $_POST[apellido];
	$domicilio = $_POST[calle].' '.$_POST[numero];
	$localidad = $_POST[localidad];
	$dni = $_POST[dni];
	$telefono = $_POST[telefono];
	$email = $_POST[email];
	$observacion = $_POST[observacion];

	
	
    $frm = new HTML_QuickForm('frm','post',$_SERVER['REQUEST_URI'],'');
    $frm -> addElement('text', 'razon_social', 'Raz&oacute;n Social: ',array('size' => '50', 'style' => 'resize:none;'));
	$frm -> addElement('text', 'nombre', 'Nombre: ',array('size' => '30', 'style' => 'resize:none;'));
	$frm -> addElement('text', 'apellido', 'Apellido: ',array('size' => '30', 'style' => 'resize:none;'));
	
	// Direccion
	$groupNum[1] =& HTML_QuickForm::createElement('text', 'calle', 'Calle: ',array('id'=>'Calle','onblur'=>'$(this).val($.trim($(this).val()))','size'=>'15','placeholder'=>utf8_encode('Calle'),'title'=>utf8_encode('Calle'), 'class' => 'soloLetras', 'maxlength' => '25'));
	$groupNum[2] =& HTML_QuickForm::createElement('static','',null,'-');
	$groupNum[3] =& HTML_QuickForm::createElement('text', 'numero', 'N&uacute;mero: ',array('id'=>'numero','onblur'=>'$(this).val($.trim($(this).val()))','size'=>'6','placeholder'=>'Número','title'=>'Número', 'class' => 'soloNumeros', 'maxlength' => '6'));
	$frm -> addGroup($groupNum, 'domicilio', 'Domicilio: ', ' ',false);
	// FIN Direccion
print_r($domicilio);
	//Localidad
	$do_localidad = DB_DataObject::factory('localidad');
	$v_localidad = $do_localidad -> get_localidades_todas();
	$frm ->addElement('select','localidad','Localidad: ',$v_localidad,array('id' => 'localidad'));
	
	$frm -> addElement('text', 'dni', 'DNI o Cuil: ',array('size' => '24', 'style' => 'resize:none;'));
	$frm -> addElement('text', 'telefono', 'Telefono: ',array('size' => '24', 'style' => 'resize:none;'));
	$frm -> addElement('text', 'email', 'Correo Electr&oacute;nico: ',array('size' => '30', 'style' => 'resize:none;','maxlength' => '50'));
	$frm -> addElement('textarea','observacion','Observacion: ',array('cols'=>'50','rows'=>'5','style'=>'resize:none;' ));
	
	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Cargar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php';"));
	$botones[] = $frm->createElement('reset','restaurar','Limpiar');
	$frm->addGroup($botones);
	
	$error = '';
	if($frm->validate()) {
		$do_cliente->cliente_razon_social=$razon_social;
		$do_cliente->cliente_nombre=$nombre;
		$do_cliente->cliente_apellido=$apellido;
		$do_cliente->cliente_domicilio=$domicilio;
		$do_cliente->cliente_localidad=$localidad;
		$do_cliente->cliente_dni=$dni;
		$do_cliente->cliente_telefono=$telefono;
		$do_cliente->cliente_email=$email;
		$do_cliente->cliente_observacion=$observacion;

		$do_cliente->query('BEGIN');
		//$id = $do_cliente->insert(); 
		
		// si se inserto se redirije a index.php, de lo contrario se muestra el error
		if ($id){
			$do_cliente->query('COMMIT');	
		}
		else{
			$do_cliente->query('ROLLBACK');			
			$error = 'Error en la generaci&oacute;n de los datos</b></div>';				
		}
		//header('location:index.php');
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