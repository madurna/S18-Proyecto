<?php
    ob_start();
    require_once('../config/web.config');
    require_once(CFG_PATH.'/smarty.config');
    session_start();
	if(!isset($_SESSION['usuario'])) {
		session_destroy();
		session_start();			
		$_SESSION['pagina_originante'] = $_SERVER['REQUEST_URI'];
		header('Location: ../'.PGN_LOGIN);
		exit;
	}	
    $acceso_mensaje = "No tiene permiso para acceder a ".$_SESSION['no_autorizado'];

    //Llamo a la template
    $tpl = new tpl();
    //Mensaje de error o exito
    $tpl->assign('acceso_mensaje',$acceso_mensaje);

    //Header
    $tpl->assign('webTitulo', WEB_TITULO);
    $tpl->assign('secTitulo', WEB_SECCION);


    //Template del archivo
    $tpl->assign('menu','menu_denegado.tpl');
    $tpl->assign('usuario', $_SESSION['usuario']['nombre']);
    $tpl->assign('include_file','denegado.tpl');

    //Mostrar en
    $tpl->display('index.htm');
    ob_end_flush();
