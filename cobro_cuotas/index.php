<?php
	require_once('../config/web.config');
	require_once(AUTHFILE);
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// Links
	require_once('cobro_cuotas.config');
	// PEAR
	require_once ('DB.php');
	require_once('HTML/QuickForm.php');
	// Librer�as propias
	//require_once(INC_PATH.'/comun.php');	
	//require_once(INC_PATH.'/rutinas.php');
	//require_once(INC_PATH.'/grilla.php');	
	

	$_SESSION['menu_principal'] = 9;

	$tpl = new tpl();
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	$tpl->assign('body', '<h2>Cobro de cuotas</h2><div align="center"><br><b>Seleccione los datos que desea ver.</b></div>');
	$tpl->assign('usuario', $_SESSION['usuario']['nombre']);
    $tpl->assign('menu','menu_eco_reciclar.htm');
    $tpl->assign('links', $links1);
	$tpl->display('index.htm');
?>