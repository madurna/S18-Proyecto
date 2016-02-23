<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// Links
	require_once('contrato.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');
	//require_once(AUTHFILE);
	$_SESSION['menu_principal'] = 8;
	$adjunto_id = $_GET["contenido"];
	
	$do_contrato = DB_DataObject::factory('contrato');
	$do_contrato -> contrato_id = $adjunto_id;
	if ($do_contrato -> find(true)){;
		$direccion = $do_contrato -> contrato_path;
		$nombre = $do_contrato -> contrato_adjunto_nombre;
	
		header ("Content-Disposition: attachment; filename=".$nombre);
		//header ("Content-Type: application/octet-stream");
		header("Content-type: application/force-download");
		header("Content-Transfer-Encoding: binary");  
		header ("Content-Length: ".filesize($direccion));
		readfile($direccion);
	}
	ob_flush();
?>