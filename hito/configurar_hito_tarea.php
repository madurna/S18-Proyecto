<?php
    ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	//require_once('../seguridad/seguridad.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	
	//DB_DataObject::debugLevel(5); 

	$_SESSION['menu_principal'] = 6;

	$hito_id = $_GET['contenido'];

	$do_tarea_hito = DB_DataObject::factory('tarea_hito');
	$do_tarea_hito -> whereAdd("tarea_hito_hito_id = $hito_id");
	$do_tarea_hito -> find();
	$i = 0;
	while ( $do_tarea_hito -> fetch())
		{
			$i++;
			$tareas_dentro_hito[$i] = $do_tarea_hito -> tarea_hito_tarea_id;
		}
	//print_r($tareas_dentro_hito);
	$do_hito = DB_DataObject::factory('hito');
	$do_hito -> whereAdd("hito_id = $hito_id");
	$do_hito -> find(true);
	$datos='Nombre del hito : <b>'.$do_hito -> hito_nombre.'</b><br / > Plazo estimado: '.$do_hito -> hito_plazo_estimado_dias;					

	//$do_tarea_hito -> joinAdd($do_hito);

	$do_tarea = DB_DataObject::factory('tarea');
	//$do_tarea_hito -> joinAdd($do_tarea,'RIGHT');
	
	//$do_tarea_hito -> whereAdd("tarea_hito_tarea_id IS NULL");
	
	$do_tarea -> find();

	$tpl = new tpl();
	$titulo_grilla = 'Agregar tareas';
	//$llave = 1;
	while ( $do_tarea -> fetch())
		{
			$llave = 0;
			for($i=0;$i<=count($tareas_dentro_hito);$i++)
			{
				if( $tareas_dentro_hito[$i] == $do_tarea -> tarea_id)
				{
					$llave = 1;
				}
			}
			if($llave == 0){
				$tareas_mostrar.='<tr>
						<td border="0" align="right" valign="top"><b>'.$do_tarea -> tarea_descripcion.'</b></td>
						<td border="0" valign="top" align="left" style="width:3px">	<input name="tarea[]" type="checkbox" value="'.$do_tarea -> tarea_id.'"/></td>
					  </tr>';
			}
			
		}

	$body =
           '<br /><div id="contenido"><h3>'.$titulo_grilla.'</h3></div><br />
          	<div id="contenido"><p>'.$datos.'</p></div>	
            <div id="contenido"><p>
            	<form action="index.php" border="0" method="post">
            		<table border="0">
						'.$tareas_mostrar.'
						<tr border="0">
							<td align="right" valign="top"><input name="agregar" value="Agregar" type="submit" /></td>
							<td valign="top" align="left"><input name="cerrar" value="Cerrar" type="button" onclick="cerrarDialogo()" /></td>
							<input name="hito" value="'.$hito_id.'" type="hidden" />
						</tr>
					</table>
            	</form>
            </p></div>';

	$tpl->assign('body', $body);
    //$tpl->assign('menu','popUpSinEncabezado.htm');
	//$tpl->assign('webTitulo', WEB_TITULO);
	//$tpl->assign('secTitulo', WEB_SECCION . ' - Alta unidad funcional');
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('popUpSinEncabezado.htm');
	ob_end_flush();
?>