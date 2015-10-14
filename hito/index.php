<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('hito.config');
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

	if($_POST)
	{
		foreach ($_POST['tarea'] as $value)
		{
			$do_tarea_hito = DB_DataObject::factory('tarea_hito');
			$do_tarea_hito -> tarea_hito_tarea_id =$value;
			$do_tarea_hito -> tarea_hito_hito_id = $_POST['hito'];
			$do_tarea_hito -> tarea_hito_fecha = date('Y-m-d');
			$do_tarea_hito -> insert();
		}
	}


	//creo template
	$tpl = new tpl();
	//

	$_SESSION['menu_principal'] = 6;
	//aceptar y limpiar
	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	
	//nombre 	
	$frm ->addElement('text','nombre','Nombre: ',$v_empresa,array('id' => 'nombre'));

	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Filtrar');
	$frm->addGroup($botones);		
	
	$do_hito = DB_DataObject::factory('hito');
	if ($_GET['nombre'])
		$do_hito -> whereAdd('hito_nombre like "%'.$_GET['nombre'].'%"');
		
	$do_hito -> find();
	$cantidad = $do_hito -> N;

	//armo grilla	
	$columnas = array();
	//$columnas[0] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;N&uacute;mero&nbsp;&nbsp;</font>';
	$columnas[0] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;Nombre&nbsp;&nbsp;</font>';
	$columnas[1] = '<font size="1px" color="#FFFFFF">Plazo estimado</font>';
	//$columnas[2] = '<font size="1px" color="#FFFFFF">Peso</font>';
	$columnas[3] = '<font size="1px" color="#FFFFFF">Tareas</font>';
	$columnas[4] = '<font size="1px" color="#FFFFFF">Estado</font>';
	$columnas[5] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;Acci&oacute;n&nbsp;&nbsp;</font>';
	$i = -1;
		
		while ( $do_hito -> fetch())
		{
			$i++;
			
			//$matriz[$i][0] = '<center>'.$do_hito -> hito_id.'</center>';
			$matriz[$i][0] = '<center>'.$do_hito -> hito_nombre.'</center>';
			$matriz[$i][1] = '<center>'.$do_hito -> hito_plazo_estimado_dias.' dias</center>';
			//$matriz[$i][2] = '<center>'.$do_hito -> hito_peso.'</center>';
			$onClick_configurar = "javascript: mostrarDialogo('../hito/configurar_hito_tarea.php?contenido=".$do_hito -> hito_id."',400,450)";
			$onClick = "javascript: mostrarDialogo('../hito/hito_tarea.php?contenido=".$do_hito -> hito_id."',400,450)";
			$matriz[$i][3] = '
			<center>
				<a href="#" onClick="'.$onClick_configurar.'"><i title="Agregar tareas asociadas" class="fa  fa-plus-square-o text-bg text-danger"></i>
				&nbsp
				<a href="#" onClick="'.$onClick.'"><i title="Ver tareas asociadas" class="fa fa-search text-bg text-danger"></i>
			</center>';
	

			if(!($do_hito -> hito_baja))
				$matriz[$i][4] = '<img title="Hito no eliminado" src="../img/spirit20_icons/system-tick-alt-02.png">';
			else 
				$matriz[$i][4] = '<img title="Hito eliminado" src="../img/spirit20_icons/system-red.png">';

			$matriz[$i][5] = '
								<center>
									<a href="modificar_hito.php?contenido='.$do_hito -> hito_id.'"><i title="Modificar" class="fa fa-edit text-bg text-danger"></i>
									&nbsp';
								
			if(!($do_hito -> hito_baja)){				
				$matriz[$i][5] .= '	
										<a href="eliminar_hito.php?contenido='.$do_hito -> hito_id.'"><i title="Eliminar" class="fa fa-trash-o text-bg text-danger"></i>
									</center>';
			}
						
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

	$agregar='<a href="alta_hito.php"> [Agregar]</a>';

	$tpl->assign('body',' 
	<link rel="stylesheet" href="../css/modal-message.css" type="text/css">

	<link type="text/css" rel="stylesheet" href="css/autocomplete_cliente/estilo.css" />
	<script type="text/javascript" src="../js/calendario.js"></script>
	<script type="text/javascript" src="../js/ajax/ajax.js"></script>
	<script type="text/javascript" src="../js/ajax/ajax-dynamic-content.js"></script>
	<script type="text/javascript" src="../js/ajax/modal-message.js"></script>
	<link rel="stylesheet" href="../css/modal-message.css" type="text/css">
		<script>
			messageObj = new DHTML_modalMessage();
			function mostrarDialogo(url,ancho,alto) {
				messageObj.setSource(url);
				messageObj.setCssClassMessageBox(false);
				messageObj.setSize(ancho,alto);
				messageObj.setShadowDivVisible(true);	// Enable shadow for these boxes
				messageObj.display();
			}
		
			function cerrarDialogo() {
				messageObj.close();
			}

		</script>
	<link type="text/css" rel="stylesheet" href="css/autocomplete_cliente/jquery-ui-1.8.4.custom.css"/>
	<script type="text/javascript" src="js/autocomplete_cliente/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/autocomplete_cliente/jquery-ui-1.8.4.custom.min.js"></script><br />
	<div align=center><h3>Hito</h3></div>
	<div><center>'.$frm -> toHTML().'</center></div><div><center>'.$agregar.'</center></div><br/><div><br/>'.$salida_grilla.'<br /><b>'.$mostrar_cantidad.'</b></div><div align="center"><br/></div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');	    
	ob_end_flush();
	exit;
?>