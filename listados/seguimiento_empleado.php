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

	$do_puesto = DB_DataObject::factory('puesto');
	$v_puesto = $do_puesto -> get_puesto_todos();

	$do_ubicacion_laboral = DB_DataObject::factory('ubicacion_laboral');
	$v_ubicacion_laboral = $do_ubicacion_laboral -> get_ubicacion_todos();

	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	
	//nombre 	
	$frm ->addElement('select','empresa','Empresa: ',$v_empresa,array('id' => 'empresa'));

	//nombre 	
	$frm ->addElement('select','conveno','Convenio: ',$v_convenio,array('id' => 'convenio'));

	// 	
	//$frm ->addElement('select','categoria','Categoria: ',null,array('id' => 'categoria'));

	//periodo desde
	$group = array();
	$group[1] = $frm->createElement('select','mes_desde','Mes',meses());
	$group[2] = $frm->createElement('select','anio_desde','A&ntilde;o',anios());
	$frm->addGroup($group,'mes_anio_desde','Mes/A&ntilde;o');

	////$group[1] -> setSelected(array(4));
	$frm -> setDefaults(array('mes_anio_desde' => array('mes_desde'=>date('m'),'anio_desde'=>date('Y'))));

	$frm ->addElement('html','<tr><td align="center"><b>Contra</b></td><td></td></tr>');

	//periodo hasta
	$group = array();
	$group[1] = $frm->createElement('select','mes_hasta','Mes',meses());
	$group[2] = $frm->createElement('select','anio_hasta','A&ntilde;o',anios());
	$frm->addGroup($group,'mes_anio_hasta','Mes/A&ntilde;o');
		
	$frm -> setDefaults(array('mes_anio_hasta' => array('mes_hasta'=>date('m'),'anio_hasta'=>date('Y'))));
	//aceptar y limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Filtrar');
	$botones[] = $frm->createElement('reset','restaurar','Limpiar busqueda',array('onClick'=> "javascript: window.location.href='acumulado_concepto.php';"));
	$frm->addGroup($botones);
	
	//traigo datos del form
	$empresa = $_GET['empresa'];
	$convenio = $_GET['convenio'];
	$mes_anio_hasta = $_GET['mes_anio_hasta'];
	$mes_anio_desde = $_GET['mes_anio_desde'];
	$aceptar = $_GET['aceptar'];
	//
	if($aceptar == 'Filtrar'){	
	//armo consulta con los datos del filtro
	$do_view_detalle_liquidacion= DB_DataObject::factory('view_detalle_liquidacion');

	$do_view_detalle_liquidacion -> whereAdd("detalle_liquidacion_concepto_id = 408");

	//empresa
	if ($empresa != 0)
		$do_view_detalle_liquidacion -> empresa_id = $empresa;

	if($convenio != 'Todas')
		$do_view_detalle_liquidacion -> convenio_empresa_convenio_id = $convenio;

	$do_view_detalle_liquidacion2 = clone($do_view_detalle_liquidacion);

	if ($mes_anio_hasta)
		$do_view_detalle_liquidacion -> whereAdd("liquidacion_mes = $mes_anio_hasta[mes_hasta] and liquidacion_anio = $mes_anio_hasta[anio_hasta]");

	///ARREGLO CON BRUTOS ANTERIORES
	if ($mes_anio_desde)
		$do_view_detalle_liquidacion2 -> whereAdd("liquidacion_mes = $mes_anio_desde[mes_desde] and liquidacion_anio = $mes_anio_desde[anio_desde]");
	
	$do_view_detalle_liquidacion2 -> find();

	while ( $do_view_detalle_liquidacion2 -> fetch())
	{
		$v_bruto_anterior[$do_view_detalle_liquidacion2 -> empleado_id] = $do_view_detalle_liquidacion2 -> detalle_liquidacion_monto;
	}
	///FIN ARREGLO BRUTO ANTERIOR

	/*print_r($mes_anio_hasta);
	print_r($mes_anio_desde);*/

	$do_view_detalle_liquidacion -> groupBy("empleado_id");
	$do_view_detalle_liquidacion -> orderBy("empleado_id");
	$do_view_detalle_liquidacion -> find();

	//armo grilla	
	$columnas = array();
	$columnas[1] = '<font size="1px" color="#FFFFFF">Empresa</font>';
	$columnas[2] = '<font size="1px" color="#FFFFFF">Legajo</font>';
	$columnas[3] = '<font size="1px" color="#FFFFFF">Apellido y Nombre</font>';
	$columnas[4] = '<font size="1px" color="#FFFFFF">Ubicaci&oacute;n laboral</font>';
	$columnas[5] = '<font size="1px" color="#FFFFFF">Puesto</font>';
	$columnas[6] = '<font size="1px" color="#FFFFFF">Convenio</font>';
	$columnas[7] = '<font size="1px" color="#FFFFFF">Categoria actual</font>';
	$columnas[8] = '<font size="1px" color="#FFFFFF">Bruto('.$mes_anio_desde[mes_desde].'/'.$mes_anio_desde[anio_desde].')</font>';
	$columnas[9] = '<font size="1px" color="#FFFFFF">Bruto('.$mes_anio_hasta[mes_hasta].'/'.$mes_anio_hasta[anio_hasta].')</font>';
	$columnas[10] = '<font size="1px" color="#FFFFFF">Variaci&oacute;n(%)</font>';
	$columnas[11] = '<font size="1px" color="#FFFFFF">Detalle</font>';

	$i = -1;
	
	//print_r($do_acumulado_concepto);

	
		while ( $do_view_detalle_liquidacion -> fetch()){
				$i++;
				$monto_anterior = $v_bruto_anterior[$do_view_detalle_liquidacion -> empleado_id];//hacer funcion que traiga bruto anterior
				$monto_actual = $do_view_detalle_liquidacion -> detalle_liquidacion_monto;
				if ($monto_anterior != $monto_actual){
					$matriz[$i][1] = '<center>'.$do_view_detalle_liquidacion -> empresa_nombre.'</center>';
					$matriz[$i][2] = '<center>'.$do_view_detalle_liquidacion -> empleado_legajo.'</center>';
					$matriz[$i][3] = '<center>'.$do_view_detalle_liquidacion -> empleado_apellido.'&nbsp;'.$do_view_detalle_liquidacion -> empleado_nombre.'</center>';
					$matriz[$i][4] = '<center>'.$v_ubicacion_laboral[$do_view_detalle_liquidacion -> empleado_ubicacion_laboral_id].'</center>';
					$matriz[$i][5] = '<center>'.$v_puesto[$do_view_detalle_liquidacion -> empleado_puesto_id].'</center>';
					$matriz[$i][6] = '<center>'.$v_convenio[$do_view_detalle_liquidacion -> convenio_empresa_convenio_id].'</center>';
					$matriz[$i][7] = '<center>'.$do_view_detalle_liquidacion -> empleado_categoria_id.'</center>';
					$matriz[$i][8] = '<center>'.monedaConPesos($monto_anterior).'</center>';
					$matriz[$i][9] = '<center>'.monedaConPesos($do_view_detalle_liquidacion -> detalle_liquidacion_monto).'</center>';
					$monto_absoluto = ($monto_actual-$monto_anterior)*100;
					$matriz[$i][10] = '<center><b>'.round($monto_absoluto/$monto_anterior,2).'%</b></center>';
					$matriz[$i][11] = '<a target="_blank" href="seguimiento_concepto.php?empleado_id='.$do_view_detalle_liquidacion -> empleado_id.'&mes_desde='.$mes_anio_desde[mes_desde].'&anio_desde='.$mes_anio_desde[anio_desde].'&mes_hasta='.$mes_anio_hasta[mes_hasta].'&anio_hasta='.$mes_anio_hasta[anio_hasta].'"><img src="../img/spirit20_icons/magnify.png"></a>';
				}
		}

		$cantidad = $i;

		$cantidadColumnas = array();
		for ($i=0; $i <= 10; $i++) 
		$cantidadColumnas[$i] = $i;
		$dg = new grilla(60);
		$dg -> setRendererOption ('convertEntities',false);
		$dg -> generateColumns($columnas); // Genero las columnas en la grilla utilizando el array que acabo de crear
		$dg -> bind($matriz,array(),'Array'); // Hago el Bind con la matriz, el 1er y 2do parámetro siempre son iguales
		// Oculto los links en los encabezados para que el usuario no pueda desordenar el contenido de la grilla
		$dg -> setRendererOption('hideColumnLinks', $cantidadColumnas);
	
	    //armo template
		
		if ($dg->getRecordCount() > 0 ) {		
			$salida_grilla=$dg->getOutput();
			$dg->setRenderer('Pager');
			$salida_grilla.=$dg->getOutput();
			$dg->setRendererOption('onMove', 'updateGrid', true);
			$mostrar_cantidad = 'Cantidad: '.$do_view_detalle_liquidacion -> N;
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

	<link type="text/css" rel="stylesheet" href="css/autocomplete_cliente/jquery-ui-1.8.4.custom.css"/>
	<script type="text/javascript" src="js/autocomplete_cliente/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/autocomplete_cliente/jquery-ui-1.8.4.custom.min.js"></script>
	<div align=center><b>Seguimiento Empleados</b></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><div><center><b>'.$mostrar_cantidad.'</b></center></div><div><br/>'.$salida_grilla.'</div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Seguimiento empleado');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');	    
	ob_end_flush();
	exit;
?>