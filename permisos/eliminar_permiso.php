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
	//DB_DataObject::debugLevel(5);
	$_SESSION['menu_principal'] = 4;
	
	//recupero las id de aplicacion, rol y modulo
	$app_id = $_POST['app_id'];
	$rol_id = $_POST['rol_id'];
	$mod_id = $_POST['mod_id'];
	
	//EL ORDEN DE LOS TIPOS DE ACCESO ES : ACCESO = 4 ; ALTA = 1 ; BAJA = 3 ; MODIFICACION = 2
	
	//recupero los valores orignales y los actuales de los checkbox	(VO -> valor original ; VA -> valor actual)
	$vo_tp4 = $_POST['vo_tp4'];
	$va_tp4 = $_POST['va_tp4'];
	//print($vo_tp4);print($va_tp4);print("--");
	
	$vo_tp1 = $_POST['vo_tp1'];
	$va_tp1 = $_POST['va_tp1'];
	//print($vo_tp1);print($va_tp1);print("--");

	$vo_tp3 = $_POST['vo_tp3'];
	$va_tp3 = $_POST['va_tp3'];
	//print($vo_tp3);print($va_tp3);print("--");
	
	$vo_tp2 = $_POST['vo_tp2'];
	$va_tp2 = $_POST['va_tp2'];
	//print($vo_tp2);print($va_tp2);print("--");

	//calculo cuantas modificaciones tengo que hacer para luego comparar que se hayan hecho todas
	$modificaciones = 0;
	$acciones = 0;
	
	//pregunto si hay diferencia entre el valor original y el valor actual de ACCESO
	if ($vo_tp4 != $va_tp4){
		$modificaciones++;
		$id = 0;
		//creo el objeto PERMISO y le asigno a cada atribulo los valores pasados por post
		$do_permiso = DB_DataObject::factory('permiso');
		$do_permiso -> permiso_rol_id = $rol_id;
		$do_permiso -> permiso_mod_id = $mod_id;
		$do_permiso -> permiso_tipoacc_id = '4';
		
		if ($vo_tp4 == '1'){
			//elimino permiso
			if ($do_permiso -> find(true)){
				$id = $do_permiso -> delete();
			}
		}
		else{
			//agrego permiso
			$id = $do_permiso -> insert();
		}
		
		if ($id != 0){
			$acciones++;
		}
	}

	//pregunto si hay diferencia entre el valor original y el valor actual de ALTA
	if ($vo_tp1 != $va_tp1){
		$modificaciones++;
		$id = 0;
		//creo el objeto PERMISO y le asigno a cada atribulo los valores pasados por post
		$do_permiso = DB_DataObject::factory('permiso');
		$do_permiso -> permiso_rol_id = $rol_id;
		$do_permiso -> permiso_mod_id = $mod_id;
		$do_permiso -> permiso_tipoacc_id = '1';
		
		if ($vo_tp1 == '1'){
			//elimino permiso
			if ($do_permiso -> find(true)){
				$id = $do_permiso -> delete();
			}
		}
		else{
			//agrego permiso
			$id = $do_permiso -> insert();
		}
		if ($id != 0){
			$acciones++;
		}
	}
	
	//pregunto si hay diferencia entre el valor original y el valor actual de BAJA
	if ($vo_tp3 != $va_tp3){
		$modificaciones++;
		//creo el objeto PERMISO y le asigno a cada atribulo los valores pasados por post
		$do_permiso = DB_DataObject::factory('permiso');
		$do_permiso -> permiso_rol_id = $rol_id;
		$do_permiso -> permiso_mod_id = $mod_id;
		$do_permiso -> permiso_tipoacc_id = '3';
		
		if ($vo_tp3 == '1'){
			//elimino permiso
			if ($do_permiso -> find(true)){
				$id = $do_permiso -> delete();
			}
		}
		else{
			//agrego permiso
			$id = $do_permiso -> insert();
		}
		if ($id != 0){
			$acciones++;
		}
	}
	
	//pregunto si hay diferencia entre el valor original y el valor actual de MODIFICACION
	if ($vo_tp2 != $va_tp2){
		$modificaciones++;
		//creo el objeto PERMISO y le asigno a cada atribulo los valores pasados por post
		$do_permiso = DB_DataObject::factory('permiso');
		$do_permiso -> permiso_rol_id = $rol_id;
		$do_permiso -> permiso_mod_id = $mod_id;
		$do_permiso -> permiso_tipoacc_id = '2';
		
		if ($vo_tp2 == '1'){
			//elimino permiso
			if ($do_permiso -> find(true)){
				$id = $do_permiso -> delete();
			}
		}
		else{
			//agrego permiso
			$id = $do_permiso -> insert();
		}
		if ($id != 0){
			$acciones++;
		}
	}

	if ($modificaciones == $acciones){
		$mensaje = 'Modificacion exitosa';
	}
	else{
		$mensaje = 'Error en la modificacion';
	}
	echo $mensaje;
    ob_end_flush();
?>