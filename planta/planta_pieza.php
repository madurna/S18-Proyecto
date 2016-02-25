<?php
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');	
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');
	require_once(INC_PATH.'/comun_dg.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	
	$_SESSION['menu_principal'] = 2;
	//DB_DataObject::debugLevel(5); 
		
	//Ejecutar cliente
	$planta_id = $_GET['contenido'];
	
	$do_trommel = DB_DataObject::factory('trommel');
	$do_trommel -> whereAdd("id_planta = '$planta_id'");
	$do_trommel -> find(true);
	$do_prensa = DB_DataObject::factory('prensa');
	$do_prensa -> whereAdd("id_planta = '$planta_id'");
	$do_prensa -> find(true);
	$do_cinta_transportadora = DB_DataObject::factory('cinta_transportadora');
	$do_cinta_transportadora -> whereAdd("id_planta = '$planta_id'");
	$do_cinta_transportadora -> find(true);

	$columnas = array();
	$columnas[0] = '<font size="2px" color="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trommel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>';
	$columnas[1] = '<font size="2px" color="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prensa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>';
	$columnas[2] = '<font size="2px" color="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;Cinta Transportadora&nbsp;&nbsp;&nbsp;&nbsp;</font>';

	if($do_trommel->trommel_id && $do_trommel->trommel_estado_id != '0'){
		$matriz[0][0]= "<b><center><i class='fa fa-check-circle text-bg text-success'></i>&nbsp;
			<a href=../trommel/ver_trommel.php?contenido=$planta_id><i title='Ver' class='fa fa-search text-bg text-success'></i></a>&nbsp;
			<a href=../trommel/modificar_trommel.php?contenido=$planta_id><i title='Editar' class='fa fa-pencil text-bg text-success'></i></a>&nbsp;
			<a href=../trommel/eliminar_trommel.php?contenido=$planta_id><i title='Eliminar' class='fa fa-close text-bg text-success'></i></a></center></b>";
	}else{
		$matriz[0][0]= "<b><center><a href=../trommel/alta_trommel.php?contenido=$planta_id><i title='Crear' class='fa fa-check-circle text-bg text-danger'></i></a>&nbsp;
			<i class='fa fa-search text-bg text-muted'></i>&nbsp;
			<i class='fa fa-pencil text-bg text-muted'></i>&nbsp;
			<i class='fa fa-close text-bg text-muted'></i></center></b>";
	}

	if($do_prensa->prensa_id && $do_prensa->prensa_estado_id != '0'){
		$matriz[0][1]= "<b><center><i class='fa fa-check-circle text-bg text-success'></i>&nbsp;
			<a href=../prensa/ver_prensa.php?contenido=$planta_id><i title='Ver' class='fa fa-search text-bg text-success'></i></a>&nbsp;
			<a href=../prensa/modificar_prensa.php?contenido=$planta_id><i title='Editar' class='fa fa-pencil text-bg text-success'></i></a>&nbsp;
			<a href=../prensa/eliminar_prensa.php?contenido=$planta_id><i title='Eliminar' class='fa fa-close text-bg text-success'></i></a></center></b>";
	}else{
		$matriz[0][1]= "<b><center><a href=../prensa/alta_prensa.php?contenido=$planta_id><i title='Crear' class='fa fa-check-circle text-bg text-danger'></i></a>&nbsp;
			<i class='fa fa-search text-bg text-muted'></i>&nbsp;
			<i class='fa fa-pencil text-bg text-muted'></i>&nbsp;
			<i class='fa fa-close text-bg text-muted'></i></center></b>";
	}

	if($do_cinta_transportadora->cinta_transportadora_id && $do_cinta_transportadora->cinta_transportadora_estado_id != '0'){
		$matriz[0][2]= "<b><center><i class='fa fa-check-circle text-bg text-success'></i>&nbsp;
			<a href=../cinta_transportadora/ver_cinta_transportadora.php?contenido=$planta_id><i title='Ver' class='fa fa-search text-bg text-success'></i></a>&nbsp;
			<a href=../cinta_transportadora/modificar_cinta_transportadora.php?contenido=$planta_id><i title='Editar' class='fa fa-pencil text-bg text-success'></i></a>&nbsp;
			<a href=../cinta_transportadora/eliminar_cinta_transportadora.php?contenido=$planta_id><i title='Eliminar' class='fa fa-close text-bg text-success'></i></a></center></b>";
	}else{
		$matriz[0][2]= "<b><center><a href=../cinta_transportadora/alta_cinta_transportadora.php?contenido=$planta_id><i title='Crear' class='fa fa-check-circle text-bg text-danger'></i></a>&nbsp;
			<i class='fa fa-search text-bg text-muted'></i>&nbsp;
			<i class='fa fa-pencil text-bg text-muted'></i>&nbsp;
			<i class='fa fa-close text-bg text-muted'></i></center></b>";
	}
			
	//armo grilla
	$cantidadColumnas = array();
	for ($i=0; $i <= 4; $i++) $cantidadColumnas[$i] = $i;
	$dg = new grilla(7);
	$dg -> setRendererOption ('convertEntities',false);
	$dg -> generateColumns($columnas); // Genero las columnas en la grilla utilizando el array que acabo de crear
	$dg -> bind($matriz,array(),'Array'); // Hago el Bind con la matriz, el 1er y 2do parámetro siempre son iguales
	// Oculto los links en los encabezados para que el usuario no pueda desordenar el contenido de la grilla
	$dg -> setRendererOption('hideColumnLinks', $cantidadColumnas);
	$table = new HTML_Table('cellpadding=5 walign=center border=0');
	$dg -> fill($table);

	$volver = '<a href="index.php">[Volver]</a>';

	//armo template
	$tpl = new tpl();
	if ($dg->getRecordCount() > 0 ) {		
	$salida_grilla=$dg->getOutput();
	$dg->setRenderer('Pager');
	$salida_grilla.=$dg->getOutput();
	$dg->setRendererOption('onMove', 'updateGrid', true);
	}	

	$tpl->assign('body', '<div align=center><b><h2>Piezas</h2></b></div>
	<div align="center"><br/>'.$salida_grilla.'<br />'.$volver.'</center>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo','Piezas');
	$tpl->assign('menu', "menu_eco_reciclar.htm");	
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');	    
    exit;
?>