<?php
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	
	require_once('empleado.config');
	
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
	
	$_SESSION['menu_principal'] = 7;
	//DB_DataObject::debugLevel(5); 
		
	//Ejecutar obrero
	$empleado_id = $_GET['contenido'];
	
	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	//id obrero 	
	$frm ->addElement('text','id_empleado','N&uacute;mero empleado: ',array('id' => 'id_empleado', 'value'=>''));
	//nombre 	
	$frm -> addElement('text', 'empleado_nombre', 'Nombre: ', array('id' => 'buscar_empleado', 'value'=>''));
	//apellido
	$frm -> addElement('text', 'empleado_apellido', 'Apellido: ', array('id' => 'buscar_empleado_apellido', 'value'=>''));
	//documento
	$frm ->addElement('text','empleado_nro_doc','Documento: ',array('id' => 'empleado_nro_doc', 'value'=>''));
	//CUIL
	$frm ->addElement('text','empleado_CUIL','CUIL: ',array('id' => 'empleado_CUIL', 'value'=>''));
	
	//provincia y localidad
	//$frm ->addElement('text','comercializador_nombre','Provincia/Localidad: ',array('id' => 'comercializador_prov_loc', 'value'=>''));
	/*//estado
	$element = HTML_QuickForm::createElement('select', 'estado','Estado: ');
	$frm->addElement($element);
	$do_estado = DB_DataObject::factory('estado');

	$element->addOption ( "Todos" , null);
	$do_estado->orderBy('estado_descripcion');
	$do_estado->find();
	$res=$do_estado->getDatabaseResult();

	$element->loadDbResult($res,'estado_descripcion','estado_id');
*/	
	//$frm ->addElement('select','obrero_estado_id','Estado: ',$estados,array('id' => 'obrero_estado_id', 'value'=>''));
	//fecha inicio
	//$frm ->addElement('text','comercializador_estado','Estado: ',array('id' => 'comercializador_estado', 'value'=>''));
	//aceptar
	$frm ->addElement('submit','aceptar','Filtrar',null);
	

	//traigo datos del form
	$id_empleado = $_GET['id_empleado'];
	$nombre = $_GET['empleado_nombre'];
	$apellido = utf8_decode($_GET['empleado_apellido']);
	$documento = $_GET['empleado_nro_doc'];
	$cuil = $_GET['empleado_CUIL'];
	$cuenta = $_GET['empleado_cuenta_bancaria'];
	$reparticion = $_GET['reparticion'];
	//$prov_loc = $_GET['obrero_prov_loc'];
	$estado = $_GET['estado'];

	
	$aceptar = $_GET['aceptar'];
	
	//armo consulta con los datos del filtro
	$do_empleado= DB_DataObject::factory('empleado');
	if($aceptar == 'Filtrar'){
		if ($id_empleado != '')
			$do_empleado -> whereAdd("empleado_id = '$id_empleado'"); 	
		if ($documento != '')
			$do_empleado -> whereAdd("empleado_nro_doc like '%$documento%'"); 	
		if ($apellido != '')
			$do_empleado -> whereAdd("empleado_apellido like '%$apellido%'");
		if ($nombre != '')
			$do_empleado -> whereAdd("empleado_nombre like '%$nombre%'");
		if ($cuil != '')
			$do_empleado -> whereAdd("empleado_CUIL like '%$cuil%'");
		if ($cuenta != '')
			$do_empleado -> whereAdd("empleado_cuenta_bancaria like '%$cuenta%'"); 
		/*if ($prov_loc[0] != '')
			$do_obrero -> whereAdd("obrero_provincia like '%$prov_loc[0]%'"); 	
		if ($prov_loc[1] != '')
			$do_obrero -> whereAdd("obrero_localidad like '%$prov_loc[1]%'"); */
		if ($estado != '')
			$do_empleado -> whereAdd("empleado_estado_id like '%$estado%'");
			
	}	
	
	$do_empleado -> orderBy('empleado_apellido, empleado_nombre');
			
	//creo grilla
	$dg = new grilla(20);
	$dg->bind($do_empleado);
	
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">N&uacute;mero</span>','empleado_id',null,array('width' => '10px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Apellido</span>','empleado_apellido',null,array('width' => '30px', 'align' => "center"), null, 'get_ape_empleado()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Nombre</span>','empleado_nombre',null,array('width' => '60px', 'align' => "center"), null, 'get_nom_empleado()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">CUIL</span>','empleado_CUIL',null,array('width' => '20px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Documento</span>','empleado_nro_doc',null,array('width' => '20px', 'align' => "center"),null,'get_doc_empleado()'));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Provincia</span>','empleado_provincia',null,array('width' => '20px', 'align' => "center"), null, 'get_prov_empleado()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Localidad</span>','empleado_localidad_id',null,array('width' => '20px', 'align' => "center"),null,'get_loca_empleado()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Direcci&oacute;n</span>','empleado_direccion',null,array('width' => '20px', 'align' => "center"), null, 'get_dire_empleadoo()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Estado</span>','empleado_estado_id',null,array('width' => '20px', 'align' => "center"),null,'get_estado_empleado',array('id' => 'empleado_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Adjuntos</span>',null,null,array('width' => '5%', 'align' => "center"),null,'get_adjuntos_empleado',array('id' => 'empleado_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '5%', 'align' => "center"),null,'get_modificar_empleado',array('id' => 'empleado_id')));	
	//link para agregar una actividad
    $agregar = '<br><a href="alta_empleado.php">[Agregar empleado]</a>';
	
    //armo template
	$tpl = new tpl();
	if ($dg->getRecordCount() > 0 ) {		
		$salida_grilla=$dg->getOutput();
		$dg->setRenderer('Pager');
		$salida_grilla.=$dg->getOutput();
		$dg->setRendererOption('onMove', 'updateGrid', true);
	}
	else{
		if ($aceptar == 'Filtrar') {
			$tpl->assign('include_file', 'cartel.htm'); 
			$tpl->assign('imagen', 'informacion.jpg');
			$tpl->assign('msg', 'No hay empleados para mostrar.');
			$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
		}
	}
	$tpl->assign('body', '<div align=center><b>Empleados</b></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><div><br/>'.$agregar.'</div><div><br/>'.$salida_grilla.'</div><br/><b>Se encontraron '.$dg->getRecordCount().' obreros<b/><br/><br/>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	$tpl->assign('menu', "menu_oceba.htm");	
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');	    
    exit;
?>