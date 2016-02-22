<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');
	//require_once(AUTHFILE);
	$_SESSION['menu_principal'] = 7;
	$adjunto_id = $_GET["contenido"];
	
	$do_adjuntos = DB_DataObject::factory('adjuntos_empleado');
	$do_adjuntos -> adjuntos_empleado_id = $adjunto_id;
	if ($do_adjuntos -> find(true)){;
		$direccion = $do_adjuntos -> adjuntos_empleado_direccion;
		$nombre = $do_adjuntos -> adjuntos_empleado_nombre;
	
		header ("Content-Disposition: attachment; filename=".$nombre);
		//header ("Content-Type: application/octet-stream");
		header("Content-type: application/force-download");
		header("Content-Transfer-Encoding: binary");  
		header ("Content-Length: ".filesize($direccion));
		readfile($direccion);
	}
	ob_flush();
?>