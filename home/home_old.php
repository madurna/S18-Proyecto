<?php
	ob_start();
	require_once('../config/web.config');
	require_once(AUTHFILE);
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('home.config');
	// PEAR
	require_once(INC_PATH.'/pear.inc');
	require_once(INC_PATH.'/comun.php');
	require_once(INC_PATH.'/grilla.php');
	//require_once('../ver_archivos_importacion/grilla_importacion.inc.php');
    
	// Librerias propias
	$_SESSION['menu_principal'] = 1;
	$_SESSION['cuadro_generado'] = null;	
	
	
	//$salida = armarGrillaImportacionHome();
  		
	$tpl = new tpl();
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	$tpl->assign('menu', "menu_oceba.htm");
	$tpl->assign('links', $links2);
	$tpl->assign('body', '<div align="center"><br><b>Seleccione los datos que desea ver.</b></div>');
	//$tpl->assign('include_file','grilla_index.tpl');
	//$tpl->assign('dg', $salida);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre']);
	$tpl->display('index.htm');
	ob_end_flush();
	exit;
	
	
?>
