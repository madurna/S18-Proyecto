<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('cinta_transportadora.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once ('HTTP/Upload.php');
	require_once(AUTHFILE);
	$_SESSION['menu_principal'] = 2;
	
	$planta_id = $_GET['contenido'];
	
	//DB_DataObject::debugLevel(5); 

	$frm = new HTML_QuickForm('fileuploadexample','POST', null,null,array("enctype" => "multipart/form-data"));

	$frm ->addElement('text','motor','Motor (HP):', array('id' => 'motor', 'value'=>''));
	$frm ->addElement('text','largo','Largo (mts):', array('id' => 'largo', 'value'=>''));
	$frm ->addElement('text','ancho','Ancho (mts):', array('id' => 'ancho', 'value'=>''));	
	$frm ->addElement('text','material','Material a Transportar:', array('id' => 'material', 'value'=>''));
	$frm ->addElement('text','tipo','Tipo de Cinta:', array('id' => 'tipo', 'value'=>''));	

	$frm ->addElement('hidden','hidden_planta', $planta_id, array('id' => 'hidden_planta'));
	
	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.history.back();"));
	$botones[] = $frm->createElement('reset','restaurar','Limpiar');
	$frm->addGroup($botones);
	
	// Datos POST Formulario
	$planta_post_id = $_POST['hidden_planta'];
	
	$motor_post = $_POST['motor'];
	$largo_post = $_POST['largo'];
	$ancho_post = $_POST['ancho'];
	$material_post = $_POST['material'];
	$tipo_post = $_POST['tipo'];
	
	$aceptar = $_POST['aceptar'];
	
	if ($aceptar == 'Guardar')
	{
		$do_cinta = DB_DataObject::factory('cinta_transportadora');
				
		$do_cinta -> cinta_transportadora_motor = $motor_post;
		$do_cinta -> cinta_transportadora_largo = $largo_post;
		$do_cinta -> cinta_transportadora_material = $material_post;
		$do_cinta -> cinta_transportadora_ancho = $ancho_post;
		$do_cinta -> cinta_transportadora_tipo_cinta = $tipo_post;
		$do_cinta -> id_planta = $planta_post_id;
		$do_cinta -> cinta_transportadora_estado_id = '1';
				
		$id_cinta = $do_cinta -> insert();

		if ($id_cinta){
			$do_cinta->query('COMMIT');	
		}
		else
		{
			$do_cinta->query('ROLLBACK');			
			$error = 'Error en la generaci&oacute;n de los datos</b></div>';				
		}
		header('location:../planta/planta_pieza.php?contenido='.$planta_post_id);
		ob_end_flush();
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Alta Cinta Transportadora';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>
            ';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_eco_reciclar.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Alta Cinta Transportadora');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>