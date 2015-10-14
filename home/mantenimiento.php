<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	
	// links
	//require_once('home.config');
	
	$tpl = new tpl();
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', 'Sitio en mantenimiento');
	$tpl->assign('body', '
		<div align="center"><img src="../img/adv48.png" /><h2 color="#666666"><b>El sitio se encuentra actualmente en mantenimiento</b></h2><br/></div>');
	$tpl->display('index.tpl');
	ob_end_flush();
	exit;
?>
