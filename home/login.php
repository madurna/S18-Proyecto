<?php	
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
    require_once(INC_PATH.'/AccesoOceba.class.php');	
	// librerias PEAR
	require_once('HTML/QuickForm.php');
	//DB_DataObject::debugLevel(5);	
		
	if (AccesoOceba::usuarioRegistrado(APP_ID)) {
		header('Location: ../'.PGN_INDEX);
		exit;
	}
	
	$frm = new HTML_QuickForm('login','post',$_SERVER['REQUEST_URI']);	
	$frm->addElement('html', 'Acceso al sistema');
	$frm->addElement('text', 'usuario', 'Usuario: ', array('size' => 20, 'maxlength' => 20));
	$frm->addElement('password', 'clave', 'Clave: ', array('size' => 20, 'maxlength' => 255));
	//$frm->addElement('html','<tr><td></td><td align="center"><a href="../home/recuperar-clave.php">[Recuperar Constrase&ntilde;a]</a><br/><br/></td></tr>');
	
	$frm->addElement('submit', 'B1', 'Entrar', array('class' => 'button'));
	$frm->applyFilter('usuario', 'trim');	
	$frm->addRule('usuario', 'Usuario requerido', 'required', null, 'client');
	$frm->addRule('clave', 'Clave requerida', 'required', null, 'client');
	$frm->setRequiredNote(FRM_NOTA);
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	$frm->addFormRule('esUsuario');
	if ($frm->validate()) {	
		if (isset($_SESSION['pagina_originante']))
			header('Location: '.$_SESSION['pagina_originante']);
	   	else 
	    header('Location: ../'.PGN_INDEX);
	    	exit;
	}
	
	$tpl = new tpl();
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', 'Ingreso al Sistema');
	$tpl->assign('header','
		<script type="text/javascript">
		    $(document).ready(function(){
		        $("input[type=\'text\']:enabled:first").focus();
		    });
	    </script>');
	$tpl->assign('body', $frm->toHtml());
	$tpl->display('index.htm');
	exit;
	
	function esUsuario($post) {		
		$encontrado = AccesoOceba::registrarUsuario($post['usuario'],$post['clave'],APP_ID);
		if ($encontrado === true) {			
			return true;
		}
        elseif ($encontrado == '-1'){
			return array('usuario' => 'Error: Falla en acceso al sistema');
		}
		else {
			return array('usuario' => 'Usuario o clave no v&aacute;lida');
        }
	}
	ob_end_flush();
?>
