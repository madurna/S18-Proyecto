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
$_SESSION['menu_principal'] = 8;

//traido id del modulo pasado por GET
$contrato_id = $_GET['contenido'];

//armo consulta con el id del modulo
$do_planta = DB_DataObject::factory('planta');
$do_planta-> whereAdd("planta_contrato_id = '$contrato_id'");
$do_planta-> find();

$do_contrato = DB_DataObject::factory('contrato');
$do_contrato-> whereAdd("contrato_id = '$contrato_id'");
$do_contrato->find(true);
$fecha = fechaAntiISODatepicker($do_contrato->contrato_fecha);
$bibliorato = $do_contrato->contrato_bibliorato;


//armo grilla
$columnas = array();
$columnas[0] = '<font size="1px" color="#FFFFFF">N&uacute;mero</font>';
$columnas[1] = '<font size="1px" color="#FFFFFF">Descripci&oacute;n</font>';
$columnas[2] = '<font size="1px" color="#FFFFFF">Localidad</font>';
$columnas[3] = '<font size="1px" color="#FFFFFF">Domicilio</font>';
$columnas[4] = '<font size="1px" color="#FFFFFF">Estado</font>';
$columnas[5] = '<font size="1px" color="#FFFFFF">Acci&oacute;n</font>';
$i = -1;

//if($aceptar == 'Filtrar'){
while ( $do_planta -> fetch())
{
    $i++;

    $matriz[$i][0] = '<center>'.$do_planta -> planta_id.'</center>';
    $matriz[$i][1] = '<center>'.$do_planta -> planta_descripcion.'</center>';
    $matriz[$i][2] = '<center>'.$v_localidad[$do_planta -> planta_localidad_id].'</center>';
    $matriz[$i][3] = '<center>'.$do_planta -> planta_direccion.'</center>';
    if ($do_planta -> planta_estado_id == 1)
        $estado_mostrar='<img title="En proceso" src="../img/spirit20_icons/system-tick-alt-02.png">';
    $matriz[$i][4] = '<center>'.$estado_mostrar.'</center>';
    $matriz[$i][5] = '<center>
								<a href="ver_planta.php?ver=true&contenido='.$do_planta -> planta_id.'"><i title="Ver" class="fa fa-search text-bg "></i>
                    </center>';
}

$cantidadColumnas = array();
for ($i=0; $i <= 10; $i++)
    $cantidadColumnas[$i] = $i;
$dg = new grilla(50);
$dg -> setRendererOption ('convertEntities',false);
$dg -> generateColumns($columnas); // Genero las columnas en la grilla utilizando el array que acabo de crear
$dg -> bind($matriz,array(),'Array'); // Hago el Bind con la matriz, el 1er y 2do parámetro siempre son iguales
// Oculto los links en los encabezados para que el usuario no pueda desordenar el contenido de la grilla
$dg -> setRendererOption('hideColumnLinks', $cantidadColumnas);

//armo template
$tpl = new tpl();

if ($dg->getRecordCount() > 0 ) {
    $excel = '<p>Exportar a: <a href="#"> EXCEL </a></p>';
    $salida_grilla=$dg->getOutput();
    $dg->setRenderer('Pager');
    $salida_grilla.=$dg->getOutput();
    $dg->setRendererOption('onMove', 'updateGrid', true);
    $mostrar_cantidad = 'Cantidad de registros: '.$cantidad;
}
else{
    if ($aceptar == 'Filtrar') {
        $tpl->assign('include_file', 'cartel.htm');
        $tpl->assign('imagen', 'informacion.jpg');
        $tpl->assign('msg', 'No hay registros para mostrar.');
        $tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
    }
}
//link para volver a la lista de clientes
$agregar = '<br><a href="javascript: window.history.back()">[ VOLVER ]</a>';


$tpl->assign('body', '<h2>Plantas de Contrato ('.$fecha.' - Bibliorato: '.$bibliorato.' )</h2><div><br/>'.$agregar.'</div><div><br/>'.$salida_grilla.'</div>');
$tpl->assign('webTitulo', WEB_TITULO);
$tpl->assign('secTitulo', 'Cliente - ' .WEB_SECCION);
$tpl->assign('menu', "menu_eco_reciclar.htm");

$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
$tpl->display('index.htm');
ob_end_flush();
exit;
?>