<?php
	ob_start();
	require_once('../config/web.config');
	require_once(AUTHFILE);
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('estadistico.config');
	// PEAR
	require_once(INC_PATH.'/pear.inc');
	require_once(INC_PATH.'/comun.php');
	require_once(INC_PATH.'/grilla.php');
    
	// Librerias propias
	$_SESSION['menu_principal'] = 9;
  		
	$tpl = new tpl();
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	$tpl->assign('menu', "menu_oceba.htm");
	$tpl->assign('links', $links1);
	$tpl->assign('body', '<h2>Estadistico</h2><br><b></b>');
	$tpl->assign('usuario',$_SESSION['usuario']['nombre']);
	$tpl->display('index.htm');
	ob_end_flush();
	exit;
?>