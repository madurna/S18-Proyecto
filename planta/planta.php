<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('planta.config');
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
	//DB_DataObject::debugLevel(5); 

	//creo template
	$tpl = new tpl();
	
	$id_cliente = $_GET['contenido'];

	$do_localidad = DB_DataObject::factory('localidad');
	$v_localidad = $do_localidad -> get_localidades_todas();

	$do_planta= DB_DataObject::factory('planta');
	$do_planta -> whereAdd("planta_cliente_id = '$id_cliente'");
	$do_planta -> find();
	
	//armo grilla	
	$columnas = array();
	$columnas[0] = '<font size="1px" color="#FFFFFF">N&uacute;mero</font>';
	$columnas[1] = '<font size="1px" color="#FFFFFF">Nombre de Planta</font>';
	$columnas[2] = '<font size="1px" color="#FFFFFF">Localidad</font>';
	$columnas[3] = '<font size="1px" color="#FFFFFF">Domicilio</font>';
	$columnas[4] = '<font size="1px" color="#FFFFFF">Fecha inicio</font>';
	$columnas[5] = '<font size="1px" color="#FFFFFF">Fecha fin</font>';
	$columnas[6] = '<font size="1px" color="#FFFFFF">Valor Planta</font>';
	//$columnas[7] = '<font size="1px" color="#FFFFFF">Dimensiones</font>';
	$columnas[8] = '<font size="1px" color="#FFFFFF">Estado</font>';
	$columnas[9] = '<font size="1px" color="#FFFFFF">Avance</font>';
	//$columnas[10] = '<font size="1px" color="#FFFFFF">Unidades<br />Funcionales</font>';
	//$columnas[10] = '<font size="1px" color="#FFFFFF">Cuotas</font>';
	//$columnas[11] = '<font size="1px" color="#FFFFFF">Ajustes</font>';
	//$columnas[12] = '<font size="1px" color="#FFFFFF">Obreros</font>';
	//$columnas[13] = '<font size="1px" color="#FFFFFF">Cliente</font>';
	$columnas[13] = '<font size="1px" color="#FFFFFF">Acci&oacute;n</font>';
	$i = -1;
	
	//print_r($do_acumulado_concepto);

		
	while ( $do_planta -> fetch())
	{
		$i++;
		
		$matriz[$i][0] = '<center>'.$do_planta -> planta_id.'</center>';
		$matriz[$i][1] = '<center>'.$do_planta -> planta_descripcion.'</center>';
		$matriz[$i][2] = '<center>'.$v_localidad[$do_planta -> planta_localidad_id].'</center>';
		$matriz[$i][3] = '<center>'.$do_planta -> planta_direccion.'</center>';
		$matriz[$i][4] = '<center>'.fechaAntiISO($do_planta -> planta_fecha_inicio).'</center>';
		$matriz[$i][5] = '<center>'.fechaAntiISO($do_planta -> planta_fecha_fin).'</center>';
		$matriz[$i][6] = '<center>'.monedaConPesos($do_planta -> planta_precio_estimado).'</center>';
		//$matriz[$i][7] = '<center>'.$do_planta -> obra_civil_dimensiones_terreno.'</center>';
		if ($do_planta -> planta_estado_id == 1)
			$estado_mostrar='<img title="En proceso" src="../img/spirit20_icons/system-tick-alt-02.png">';
		$matriz[$i][8] = '<center>'.$estado_mostrar.'</center>';
		$onClick = "javascript: mostrarDialogo('finalizar_tarea.php?contenido=".$do_planta -> planta_id."',750,550)";
		$onClick_hito = "javascript: mostrarDialogo('configurar_hitos.php?contenido=".$do_planta -> planta_id."',380,450)";
		$matriz[$i][9] = '
		<center><b>'.$do_planta -> calcularPorcentaje($do_planta->planta_id).'</b>&nbsp;
			<a href="#" onClick="'.$onClick.'"><i title="Ver Avances" class="fa fa-search text-bg text-danger"></i>
			&nbsp;&nbsp;
			<a href="#" onClick="'.$onClick_hito.'"><i title="Configurar hitos" class="fa fa-cogs text-bg text-danger"></i>
		</center>';
		
		//$onClick = "javascript: mostrarDialogo('../unidad_funcional/index.php?contenido=".$do_planta -> planta_id."',750,570)";
		//$matriz[$i][10] = '<center><a href="#" onClick="'.$onClick.'"><i title="Ver Unidades" class="fa fa-search-plus text-bg text-danger"></i></center>';
		//$matriz[$i][10] = '<center><a href="#"><i title="Ver Cuotas" class="fa fa-search-plus text-bg text-danger"></i></center>';
		//$matriz[$i][11] = '<center><a href="#"><i title="Ver Ajustes" class="fa fa-search text-bg text-danger"></i></center>';
		//$matriz[$i][12] = '<center><a href="#"><i title=" Ver obreros asigandos" class="fa fa-search text-bg text-danger"></i></a></center>';		
		$matriz[$i][13] = '
							<center>
								<a href="modificar_obra_civil.php?contenido='.$do_planta -> planta_id.'"><i title="Modificar" class="fa fa-edit text-bg text-danger"></i>
								<a href="eliminar_obra_civil.php?contenido='.$do_planta -> planta_id.'"><i title="Eliminar" class="fa fa-trash-o text-bg text-danger"></i>
							</center>';							
	}

	$cantidadColumnas = array();
	for ($i=0; $i <= 10; $i++) 
	$cantidadColumnas[$i] = $i;
	$dg = new grilla(20);
	$dg -> setRendererOption ('convertEntities',false);
	$dg -> generateColumns($columnas); // Genero las columnas en la grilla utilizando el array que acabo de crear
	$dg -> bind($matriz,array(),'Array'); // Hago el Bind con la matriz, el 1er y 2do parámetro siempre son iguales
	// Oculto los links en los encabezados para que el usuario no pueda desordenar el contenido de la grilla
	$dg -> setRendererOption('hideColumnLinks', $cantidadColumnas);

    //armo template
	
	if ($dg->getRecordCount() > 0 ) {	
		$excel = '<p>Exportar a: <a href="#"> EXCEL </a></p>';
		$salida_grilla=$dg->getOutput();
		$dg->setRenderer('Pager');
		$salida_grilla.=$dg->getOutput();
		$dg->setRendererOption('onMove', 'updateGrid', true);
	}
	
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
	<script type="text/javascript" src="js/autocomplete_cliente/jquery-ui-1.8.4.custom.min.js"></script>
	<div align=center><h2><b>Plantas</b></h2></div>
	<div align="center"><div><center>'.$excel.'</center></div><div><br/>'.$salida_grilla.'<br /></div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');	    
	ob_end_flush();
	exit;
?>