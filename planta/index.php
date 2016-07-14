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
	
	//arreglos
	$do_localidad = DB_DataObject::factory('localidad');
	$v_localidad = $do_localidad -> get_localidades_todas();

	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	
	//nombre 	
	$frm ->addElement('text','planta_nombre','Nombre: ',array('id' => 'obra_nombre'));

	//localidad 	
	$frm ->addElement('select','localidad','Localidad: ',$v_localidad,array('id' => 'localidad'));

	//domicilio 	
	$frm ->addElement('text','domicilio','Domicilio: ',array('id' => 'domicilio'));
	
	//aceptar y limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Filtrar');
	$botones[] = $frm->createElement('reset','restaurar','Limpiar busqueda',array('onClick'=> "javascript: window.location.href='index.php';"));
	$frm->addGroup($botones);
	
	//traigo datos del form
	$planta_nombre = $_GET['planta_nombre'];
	$localidad = $_GET['localidad'];
	$domicilio = $_GET['domicilio'];
	$aceptar = $_GET['aceptar'];

	if ($aceptar == 'Filtrar')
	{
		$do_planta = DB_DataObject::factory('planta');

		if ($planta_nombre)
			$do_planta -> whereAdd(' planta_descripcion like "%'.$planta_nombre.'%"');

		if ($localidad != 'Todas')
			$do_planta -> whereAdd(' planta_localidad_id like "%'.$localidad.'%"');
		
		if ($domicilio)
			$do_planta -> whereAdd(' planta_direccion like "%'.$domicilio.'%"');
		
		$do_planta -> find();

		$cantidad = $do_planta -> N;
	}else{
		$do_planta = DB_DataObject::factory('planta');
		$do_planta -> find();
		$cantidad = $do_planta -> N;
	}


	//armo grilla	
	$columnas = array();
	$columnas[0] = '<font size="1px" color="#FFFFFF">N&uacute;mero</font>';
	$columnas[1] = '<font size="1px" color="#FFFFFF">Nombre</font>';
	$columnas[2] = '<font size="1px" color="#FFFFFF">Localidad</font>';
	$columnas[3] = '<font size="1px" color="#FFFFFF">Domicilio</font>';
	$columnas[4] = '<font size="1px" color="#FFFFFF">Fecha inicio</font>';
	$columnas[5] = '<font size="1px" color="#FFFFFF">Fecha fin</font>';
	$columnas[6] = '<font size="1px" color="#FFFFFF">Valor Planta</font>';
	$columnas[7] = '<font size="1px" color="#FFFFFF">Estado</font>';
	$columnas[8] = '<font size="1px" color="#FFFFFF">Piezas</font>';
	$columnas[11] = '<font size="1px" color="#FFFFFF">Empleados</font>';
	$columnas[12] = '<font size="1px" color="#FFFFFF">Acci&oacute;n</font>';
	$i = -1;
	
	//if($aceptar == 'Filtrar'){	
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
		if ($do_planta -> planta_estado_id == 1)
			$estado_mostrar='<img title="En proceso" src="../img/spirit20_icons/system-tick-alt-02.png">';
		$matriz[$i][7] = '<center>'.$estado_mostrar.'</center>';
		$matriz[$i][8] = '
			<center><a href="planta_pieza.php?contenido='.$do_planta -> planta_id.'"><i title="Ver" class="fa fa-cogs text-bg text-danger"></i>
			&nbsp;&nbsp</center>';			
		$matriz[$i][11] = '<center><a href="#"><i title=" Ver empleados asigandos" class="fa fa-search text-bg text-danger"></i></a></center>';		
		$matriz[$i][12] = '<center>
								<a href="modificar_planta.php?contenido='.$do_planta -> planta_id.'"><i title="Modificar" class="fa fa-edit text-bg text-danger"></i>
								<a href="eliminar_planta.php?contenido='.$do_planta -> planta_id.'"><i title="Eliminar" class="fa fa-trash-o text-bg text-danger"></i>
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
	

	$tpl->assign('body',' 
	<link rel="stylesheet" href="../css/modal-message.css" type="text/css">

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
	<link type="text/css" rel="stylesheet" href="../js/jqueryui/jquery-ui.css"/>
	<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="../js/jqueryui/js/jquery-ui-1.8.11.custom.min.js"></script>
	<div align=center><b>Plantas</b></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><br/><div><center>'.$excel.'</center></div><div><br/>'.$salida_grilla.'<br /><b>'.$mostrar_cantidad.'</b></div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	$tpl->assign('menu', "menu_eco_reciclar.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');	    
	ob_end_flush();
	exit;
?>