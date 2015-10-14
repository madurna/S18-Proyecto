<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('obra_yeseria.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	$_SESSION['menu_principal'] = 3;
	//DB_DataObject::debugLevel(5); 

	//creo template
	$tpl = new tpl();
	//
	
	//arreglos
	$do_localidad = DB_DataObject::factory('localidad');
	$v_localidad = $do_localidad -> get_localidades_todas();

	/*$do_convenio = DB_DataObject::factory('convenio');
	$v_convenio = $do_convenio -> get_convenio_todos();

	$do_categoria_convenio_empresa = DB_DataObject::factory('categoria_convenio_empresa');
	$v_categoria_convenio_empresa = $do_categoria_convenio_empresa -> get_categoria_todas();*/

	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	
	//numero 	
	$frm ->addElement('text','obra_yeseria_numero','N&uacute;mero: ',array('id' => 'obra_yeseria_numero','size'=>'30'));

	//nombre 	
	$frm ->addElement('text','obra_yeseria_nombre','Nombre: ',array('id' => 'obra_nombre'));

	//localidad 	
	$frm ->addElement('select','localidad','Localidad: ',$v_localidad,array('id' => 'localidad'));

	//domicilio 	
	$frm ->addElement('text','domicilio','Domicilio: ',array('id' => 'domicilio'));
	$_SESSION['menu_principal'] = 3;
	//aceptar y limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Filtrar');
	$botones[] = $frm->createElement('reset','restaurar','Limpiar busqueda',array('onClick'=> "javascript: window.location.href='acumulado_concepto.php';"));
	$frm->addGroup($botones);
	
	//traigo datos del form
	$obra_yeseria_numero = $_GET['obra_yeseria_numero'];
	$obra_yeseria_nombre = $_GET['obra_yeseria_nombre'];
	$localidad = $_GET['localidad'];
	$domicilio = $_GET['domicilio'];
	//$legajo = $_GET['legajo'];
	$aceptar = $_GET['aceptar'];
	
	//traigo datos
	//print_r($convenio);
	if ($aceptar == 'Filtrar')
	{
		$do_obra_yeseria = DB_DataObject::factory('obra_yeseria');

		//print_r($_GET);

		/*if ($convenio != 'Todas')
			$do_view_log_categoria_empleado ->convenio_empresa_convenio_id = $convenio;

		if ($empleado){
			$do_view_log_categoria_empleado -> whereAdd(' empleado_nombre like "%'.$empleado.'%"');
		}
		if ($legajo)
			$do_view_log_categoria_empleado -> whereAdd(' empleado_legajo like "%'.$legajo.'%"');

		if ($empresa != 'Todas')
			$do_view_log_categoria_empleado -> empleado_empresa_id = $empresa;

    	if ($periodo)
    	{
	    	$do_view_log_categoria_empleado -> whereAdd('log_categoria_empleado_mes>='.$periodo["mes_1"].' and log_categoria_empleado_anio>='.$periodo["anio_1"].' ');
			$do_view_log_categoria_empleado -> whereAdd('log_categoria_empleado_mes<='.$periodo["mes_2"].' and log_categoria_empleado_anio<='.$periodo["anio_2"].' ');
		}*/
		
		$do_obra_yeseria -> find();

		$cantidad = $do_obra_yeseria -> N;
	}


	//armo grilla	
	$columnas = array();
	$columnas[0] = '<font size="1px" color="#FFFFFF">N&uacute;mero</font>';
	$columnas[1] = '<font size="1px" color="#FFFFFF">Nombre</font>';
	$columnas[2] = '<font size="1px" color="#FFFFFF">Localidad</font>';
	$columnas[3] = '<font size="1px" color="#FFFFFF">Domicilio</font>';
	$columnas[4] = '<font size="1px" color="#FFFFFF">Fecha inicio</font>';
	$columnas[5] = '<font size="1px" color="#FFFFFF">Fecha fin</font>';
	$columnas[6] = '<font size="1px" color="#FFFFFF">Monto</font>';
	$columnas[7] = '<font size="1px" color="#FFFFFF">Estado</font>';
	$columnas[8] = '<font size="1px" color="#FFFFFF">Obreros</font>';
	$columnas[9] = '<font size="1px" color="#FFFFFF">Cliente</font>';
	$columnas[10] = '<font size="1px" color="#FFFFFF">Acci&oacute;n</font>';
	$i = -1;
	
	//print_r($do_acumulado_concepto);

	if($aceptar == 'Filtrar'){	
		while ( $do_obra_yeseria -> fetch())
		{
			$i++;
			
			$matriz[$i][0] = '<center>'.$do_obra_yeseria -> id.'</center>';
			$matriz[$i][1] = '<center>'.$do_obra_yeseria -> descripcion.'</center>';
			$matriz[$i][2] = '<center>'.$v_localidad[$do_obra_yeseria -> localidad].'</center>';
			$matriz[$i][3] = '<center>'.$do_obra_yeseria -> domicilio.'</center>';
			$matriz[$i][4] = '<center>'.fechaAntiISO($do_obra_yeseria -> fecha_inicio).'</center>';
			$matriz[$i][5] = '<center>'.fechaAntiISO($do_obra_yeseria -> fecha_fin).'</center>';
			$matriz[$i][6] = '<center>'.monedaConPesos($do_obra_yeseria -> monto).'</center>';	
			if ($do_obra_yeseria -> estado == 1)
				$estado_mostrar='<img title="En proceso" src="../img/spirit20_icons/system-tick-alt-02.png">';
			$matriz[$i][7] = '<center>'.$estado_mostrar.'</center>';		
			$matriz[$i][8] = '<center><a href="#"><i title=" Ver obreros asigandos" class="fa fa-search text-bg text-danger"></i></a></center>';		
			$matriz[$i][9] = '<center><a href="#"><i title="Ver cliente" class="fa fa-search text-bg text-danger"></i></center>';
			$matriz[$i][10] = '
								<center>
									<a href="#"><i title="Ver" class="fa fa-search text-bg text-danger"></i>
									<a href="#"><i title="Modificar" class="fa fa-edit text-bg text-danger"></i>
									<a href="#"><i title="Eliminar" class="fa fa-trash-o text-bg text-danger"></i>
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
	}
	
	$agregar='<a href=""> [Agregar]</a>';

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
	<div align=center><b>Obras de yeser&iacute;a</b></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><br/><div><center>'.$agregar.'</center></div><br/><div><center>'.$excel.'</center></div><div><br/>'.$salida_grilla.'<br /><b>'.$mostrar_cantidad.'</b></div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');	    
	ob_end_flush();
	exit;
?>