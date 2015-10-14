<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('listados.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	//require_once(AUTHFILE);
	$_SESSION['menu_principal'] = 5;
	//DB_DataObject::debugLevel(5); 

	//creo template
	$tpl = new tpl();
	//
	
	//arreglos
	$do_empresa = DB_DataObject::factory('empresa');
	$v_empresa = $do_empresa -> get_empresa_todas();

	$do_convenio = DB_DataObject::factory('convenio');
	$v_convenio = $do_convenio -> get_convenio_todos();

	$do_ubicacion = DB_DataObject::factory('ubicacion_laboral');
	$v_ubicacion = $do_ubicacion -> get_ubicacion_todos();

	$do_puesto = DB_DataObject::factory('puesto');
	$v_puesto = $do_puesto -> get_puesto_todos();

	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	
	//nombre 	
	$frm ->addElement('select','empresa','Empresa: ',$v_empresa,array('id' => 'empresa'));

	//nombre 	
	$frm ->addElement('select','convenio','Convenio: ',$v_convenio,array('id' => 'convenio'));

	//nombre 	
	$frm ->addElement('text','legajo','Legajo: ',array('id' => 'legajo','size'=>'30'));

	//nombre 	
	$frm ->addElement('text','empleado','Empleado: ',array('id' => 'empleado','size'=>'30'));

	//categoria
	$frm ->addElement('text','categoria','Categoria: ',array('id' => 'categoria','size'=>'30'));

	//puesto laboral
	$frm ->addElement('select','puesto_laboral','Puesto laboral: ',$v_puesto,array('id' => 'puesto_laboral'));

	//ubicacion laboral
	$frm ->addElement('select','ubicacion_laboral','Ubicaci&oacute;n: ',$v_ubicacion,array('id' => 'ubicacion_laboral'));

	//Fecha de ingreso
	$frm -> addElement('text', 'fecha_desde', 'Fecha de ingreso desde: ', array('id' => 'fecha_desde', 'readonly' => 'readonly', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD-MM-AAAA'));
	$frm -> addElement('text', 'fecha_hasta', 'Fecha de ingreso hasta: ', array('id' => 'fecha_hasta', 'readonly' => 'readonly', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD-MM-AAAA'));

	//aceptar y limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Filtrar');
	$botones[] = $frm->createElement('reset','restaurar','Limpiar busqueda',array('onClick'=> "javascript: window.location.href='acumulado_concepto.php';"));
	$frm->addGroup($botones);
	
	//traigo datos del form
	$empresa = $_GET['empresa'];
	$empleado = $_GET['empleado'];
	$legajo = $_GET['legajo'];
	$convenio = $_GET['convenio'];
	$categoria = $_GET['categoria'];
	$puesto_laboral = $_GET['puesto_laboral'];
	$ubicacion_laboral = $_GET['ubicacion_laboral'];
	$fecha_desde = $_GET['fecha_desde'];
	$fecha_hasta = $_GET['fecha_hasta'];
	$aceptar = $_GET['aceptar'];
	
	//traigo datos
	//print_r($convenio);
	if ($aceptar == 'Filtrar')
	{
		$do_view_log_categoria_empleado = DB_DataObject::factory('view_empleado');

		if ($convenio != 'Todas')
			$do_view_log_categoria_empleado -> whereAdd("convenio_empresa_convenio_id = $convenio");

		if ($legajo)
			$do_view_log_categoria_empleado -> whereAdd(" empleado_legajo = $legajo");

		if ($empleado)
			$do_view_log_categoria_empleado -> whereAdd(" empleado_nombre like '%'.$empleado.'%'");

		if ($empresa != 'Todas')
			$do_view_log_categoria_empleado -> whereAdd(" empleado_empresa_id = $empresa");

		if ($categoria)
			$do_view_log_categoria_empleado -> whereAdd(" empleado_categoria_id like '%'.$categoria.'%'");
	
		if ($puesto_laboral != 'Todas')
			$do_view_log_categoria_empleado -> whereAdd(" empleado_puesto_id = $puesto_laboral");

		if ($ubicacion_laboral != 'Todas')
			$do_view_log_categoria_empleado -> whereAdd(" empleado_ubicacion_laboral_id = $ubicacion_laboral");

		//seteo fechas
		list($dia_desde,$mes_desde,$anio_desde) = explode("-",$fecha_desde);
		$fecha_desde_db = $anio_desde.'-'.$mes_desde.'-'.$dia_desde;
		list($dia_hasta,$mes_hasta,$anio_hasta) = explode("-",$fecha_hasta);
		$fecha_hasta_db = $anio_hasta.'-'.$mes_hasta.'-'.$dia_hasta;
		//fin seteo fechas

		if (($fecha_desde) and ($fecha_hasta))
    	{
    		//print($fecha_desde_db.' ** '.$fecha_hasta_db);
    		$do_view_log_categoria_empleado -> whereAdd("empleado_fecha_ingreso>='$fecha_desde_db'");
    		$do_view_log_categoria_empleado -> whereAdd("empleado_fecha_ingreso<='$fecha_hasta_db'");
		}

		$do_view_log_categoria_empleado -> find();

		$cantidad = $do_view_log_categoria_empleado -> N;
	}


	//armo grilla	
	$columnas = array();
	$columnas[0] = '<font size="1px" color="#FFFFFF">Empresa</font>';
	$columnas[1] = '<font size="1px" color="#FFFFFF">Convenio</font>';
	$columnas[2] = '<font size="1px" color="#FFFFFF">Legajo</font>';
	$columnas[3] = '<font size="1px" color="#FFFFFF">Apellido y Nombre</font>';
	$columnas[4] = '<font size="1px" color="#FFFFFF">Categoria</font>';
	$columnas[5] = '<font size="1px" color="#FFFFFF">Puesto</font>';
	$columnas[6] = '<font size="1px" color="#FFFFFF">Ubicaci&oacute;n</font>';
	$columnas[7] = '<font size="1px" color="#FFFFFF">Nacionalidad</font>';
	//$columnas[8] = '<font size="1px" color="#FFFFFF">CUIL</font>';
	$columnas[8] = '<font size="1px" color="#FFFFFF">Estudio</font>';
	$columnas[9] = '<font size="1px" color="#FFFFFF">Estado civil</font>';
	$columnas[10] = '<font size="1px" color="#FFFFFF">Fecha de antiguedad</font>';
	$columnas[11] = '<font size="1px" color="#FFFFFF">Ingreso</font>';
	$columnas[12] = '<font size="1px" color="#FFFFFF">Detalle</font>';


	$i = -1;
	
	//print_r($do_acumulado_concepto);

	if($aceptar == 'Filtrar'){	
		while ( $do_view_log_categoria_empleado -> fetch()){
				$i++;
				
				$matriz[$i][0] = '<center>'.$v_empresa[$do_view_log_categoria_empleado -> empleado_empresa_id].'</center>';
				$matriz[$i][1] = '<center>'.$v_convenio[$do_view_log_categoria_empleado -> convenio_empresa_convenio_id].'</center>';
				$matriz[$i][2] = '<cente>'.$do_view_log_categoria_empleado -> empleado_legajo.'</center>';
				$matriz[$i][3] = '<center>'.$do_view_log_categoria_empleado -> empleado_apellido.' '.$do_view_log_categoria_empleado -> empleado_nombre.'</center>';
				//ver esto!!!
				$matriz[$i][4] = '<center>'.$do_view_log_categoria_empleado -> empleado_categoria_id.'</center>';
				$matriz[$i][5] = '<center>'.$do_view_log_categoria_empleado -> puesto_nombre.'</center>';
				$matriz[$i][6] = '<center>'.$do_view_log_categoria_empleado -> ubicacion_laboral_nombre.'</center>';
				$matriz[$i][7] = '<center>'.$do_view_log_categoria_empleado -> nacionalidad_nombre.'</center>';
				//$matriz[$i][8] = '<center>'.$do_view_log_categoria_empleado -> empleado_cuil.'</center>';
				$matriz[$i][8] = '<center>'.$do_view_log_categoria_empleado -> estudio_nombre.'</center>';
				$matriz[$i][9] = '<center>'.$do_view_log_categoria_empleado -> estado_civil_nombre.'</center>';
				$matriz[$i][10] = '<center>'.fechaAntiISO($do_view_log_categoria_empleado -> empleado_fecha_antiguedad).'</center>';
				$matriz[$i][11] = '<center>'.fechaAntiISO($do_view_log_categoria_empleado -> empleado_fecha_ingreso).'</center>';
				$onClick = "javascript: mostrarDialogo('detalle_empleado.php?contenido=".$do_view_log_categoria_empleado -> empleado_id."',400,600)";
				//print($onClick);
				$matriz[$i][12] = '<a href="#" onClick="'.$onClick.'"><img src="../img/spirit20_icons/magnify.png"></a>';
				//ver esto		
		}

		$cantidadColumnas = array();
		for ($i=0; $i <= 10; $i++) 
		$cantidadColumnas[$i] = $i;
		$dg = new grilla(40);
		$dg -> setRendererOption ('convertEntities',false);
		$dg -> generateColumns($columnas); // Genero las columnas en la grilla utilizando el array que acabo de crear
		$dg -> bind($matriz,array(),'Array'); // Hago el Bind con la matriz, el 1er y 2do parámetro siempre son iguales
		// Oculto los links en los encabezados para que el usuario no pueda desordenar el contenido de la grilla
		$dg -> setRendererOption('hideColumnLinks', $cantidadColumnas);
	
	    //armo template
		
		if ($dg->getRecordCount() > 0 ) {	
			//$excel = '<p>Exportar a: <a href="categoria_exportar.php?empresa='.$empresa.'&empleado='.$empleado.'&convenio='.$convenio.'&periodo[mes_1]='.$periodo['mes_1'].'&periodo[anio_1]='.$periodo['anio_1'].'&periodo[mes_2]='.$periodo['mes_2'].'&periodo[anio_2]='.$periodo['anio_2'].'&aceptar=Filtrar"> EXCEL </a></p>';
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
	<div align=center><h3>Empleados</h3></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><div><center>'.$excel.'<br /><b>'.$mostrar_cantidad.'</b></center></div><div><br/>'.$salida_grilla.'</div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Empleados');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');	    
	ob_end_flush();
	exit;
?>