<?php
ob_start();
require_once('../config/web.config');
require_once(CFG_PATH.'/smarty.config');
require_once(CFG_PATH.'/data.config');
// links
require_once('../planta/planta.config');
// PEAR
require_once ('DB.php');
require_once('DB/DataObject/FormBuilder.php');
require_once('HTML/QuickForm.php');
// Librerias propias
require_once(INC_PATH.'/comun.php');
require_once(INC_PATH.'/rutinas.php');
require_once(INC_PATH.'/grilla.php');
require_once(AUTHFILE);
$_SESSION['menu_principal'] = 2;

//traido id del modulo pasado por GET
$planta_id = $_GET['contenido'];
$contrato_id = $_GET['contrato'];

//DB_DataObject::debugLevel(5);
$do_planta = DB_DataObject::factory('planta');
$do_planta -> planta_id = $planta_id;

$do_planta -> find(true);

if (!$do_planta->find(true)) {
    $tpl->assign('include_file','error.tpl');
    $tpl->assign('error_msg','Error: Registro Inexistente');
    $tpl->assign('error_volver','Volver');
    $tpl->assign('error_volver_href',$paginaOriginante);
    $tpl->display('index.htm');
    exit;
}else{
    $do_planta ->planta_contrato_id = $contrato_id;
    $do_planta->query('BEGIN');
    $id = $do_planta->update();
}

    // si se actualizo se redirije a contrato.php, de lo contrario se muestra el error
if ($id){
    $do_planta->query('COMMIT');
    header('location:../contratos/contrato.php?contenido='.$do_planta->planta_cliente_id);
    ob_end_flush();
    exit;
    }
    else{
        $do_planta->query('ROLLBACK');
        $error = 'Error en la generaci&oacute;n de los datos</b></div>';
    }


$tpl = new tpl();
$titulo_grilla = 'Modificar de Planta';
$body =
    '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>';
$tpl->assign('body', $body);
$tpl->assign('menu','menu_eco_reciclar.htm');
$tpl->assign('webTitulo', WEB_TITULO);
$tpl->assign('secTitulo', WEB_SECCION);
//$tpl->assign('links',$links1);
$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
$tpl->display('index.htm');
ob_end_flush();
?>