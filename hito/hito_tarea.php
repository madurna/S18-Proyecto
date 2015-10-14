<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	//require_once('unidad_funcional.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	//$_SESSION['menu_principal'] = 2;
	//DB_DataObject::debugLevel(5); 

	//creo template
	$tpl = new tpl();
	//
	$hito_id = $_GET['contenido'];

	$_SESSION['menu_principal'] = 6;
	
	//aceptar y limpiar
	$do_tarea_hito = DB_DataObject::factory('tarea_hito');

	$do_hito = DB_DataObject::factory('hito');
	$do_hito -> whereAdd("hito_id = $hito_id");
	$do_tarea_hito -> joinAdd($do_hito);

	$do_tarea = DB_DataObject::factory('tarea');
	$do_tarea_hito -> joinAdd($do_tarea);
	
	$do_tarea_hito -> find();

	$cantidad = $do_tarea_hito -> N;

	//armo grilla	
	$columnas = array();
	//$columnas[0] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;N&uacute;mero&nbsp;&nbsp;</font>';
	$columnas[0] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;&nbsp;Num&nbsp;&nbsp;&nbsp;</font>';
	$columnas[1] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;&nbsp;Tarea&nbsp;&nbsp;&nbsp;</font>';
	$columnas[2] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;</font>';
	$columnas[3] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;&nbsp;Quitar&nbsp;&nbsp;&nbsp;</font>';
	$i = 0;
		
		while ( $do_tarea_hito -> fetch())
		{
			$i++;
			
			//$matriz[$i][0] = '<center>'.$do_unidad_funcional -> unidad_funcional_id.'</center>';
			$matriz[$i][0] = '<center>&nbsp;&nbsp;'.$i.'&nbsp;&nbsp;</center>';
			$matriz[$i][1] = '<center>&nbsp;&nbsp;'.$do_tarea_hito -> tarea_descripcion.'&nbsp;&nbsp;</center>';
			$matriz[$i][2] = '<center>&nbsp;&nbsp;'.$do_tarea_hito -> tarea_hito_fecha.'&nbsp;&nbsp;</center>';
			$matriz[$i][3] = '
								<center>
									<a href="#" onClick="'.$onClick_eliminar.'"c><i title="Eliminar" class="fa fa-trash-o text-bg text-danger"></i>
								</center>';	
			$datos='Nombre del hito : '.$do_tarea_hito -> hito_nombre.'<br / > Plazo estimado: '.$do_tarea_hito -> hito_plazo_estimado_dias;					
		}

		$cantidadColumnas = array();
		for ($i=0; $i <= 10; $i++) 
		$cantidadColumnas[$i] = $i;
		$dg = new grilla();
		$dg -> setRendererOption ('convertEntities',false);
		$dg -> generateColumns($columnas); // Genero las columnas en la grilla utilizando el array que acabo de crear
		$dg -> bind($matriz,array(),'Array'); // Hago el Bind con la matriz, el 1er y 2do parámetro siempre son iguales
		// Oculto los links en los encabezados para que el usuario no pueda desordenar el contenido de la grilla
		$dg -> setRendererOption('hideColumnLinks', $cantidadColumnas);
	
	    //armo template
		
		if ($dg->getRecordCount() > 0 ) {	
			//$excel = '<p>Exportar a: <a href="#"> EXCEL </a></p>';
			$salida_grilla=$dg->getOutput();
			$dg->setRenderer('Pager');
			$salida_grilla.=$dg->getOutput();
			$dg->setRendererOption('onMove', 'updateGrid', true);
			$mostrar_cantidad = 'Cantidad de registros: '.$cantidad;
		}
		else{
			
			$salida_grilla='
				<table class="login" width="350" height="80" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr> 
				    <td width="76" height="80" align="center" valign="middle">
				    <img src="../img/informacion.jpg" width="48" height="48" border="1"></td>
				    <td width="324" align="left" valign="middle"><div align="justify">No hay unidades funcionales para mostrar.</div></td>
				  </tr>
				</table>
			';

		}
	
	$tpl->assign('body',' 
	<link rel="stylesheet" href="../css/modal-message.css" type="text/css">

	<link type="text/css" rel="stylesheet" href="css/autocomplete_cliente/estilo.css" />
	<script type="text/javascript" src="../js/calendario.js"></script>
	<script type="text/javascript" src="../js/ajax/ajax.js"></script>
	<script type="text/javascript" src="../js/ajax/ajax-dynamic-content.js"></script>
	<script type="text/javascript" src="../js/ajax/modal-message.js"></script>

	<link type="text/css" rel="stylesheet" href="css/autocomplete_cliente/jquery-ui-1.8.4.custom.css"/>
	<script type="text/javascript" src="js/autocomplete_cliente/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/autocomplete_cliente/jquery-ui-1.8.4.custom.min.js"></script><br />
	<br/><div><center><h3>'.$datos.'</h3></center></div><br/><div><center></center></div><div><br/>'.$salida_grilla.'<br /><b>'.$mostrar_cantidad.'</b></div><div align="center"><br/><button onClick="cerrarDialogo()">Cerrar</button></div>');
	/*$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );*/
	$tpl->display('popUpSinEncabezado.htm');	    
	ob_end_flush();
	exit;
?>