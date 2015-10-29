<?php
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	
	require_once('clientes.config');
	
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
	
	$_SESSION['menu_principal'] = 8;
	//DB_DataObject::debugLevel(5); 
		
	//Ejecutar cliente
	$cliente_id = $_GET['contenido'];
	$ejecutar = $_GET['ejecutar'];
		
	if ($ejecutar) {
		$do_cliente = DB_DataObject::factory('clientes');
		$do_cliente -> query('BEGIN');
		$do_cliente -> cliente_id = $cliente_id;
		if ($do_cliente -> find(true)) {
			$do_cliente -> cliente_estado_id = '3';
			$result = $do_cliente -> update();
			// Si no hubo errores realizo el COMMIT, sino hago ROLLBACK
			if ($result) {
				$do_cliente -> query('COMMIT');
			} else {
				$do_cliente -> query('ROLLBACK');
			}
		}
	}
	
	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	//id cliente 	
	$frm ->addElement('text','id_cliente','N&uacute;mero Cliente: ',array('id' => 'id_cliente', 'value'=>''));
	//nombre 	
	$frm -> addElement('text', 'cliente_nombre', 'Nombre: ', array('id' => 'cliente_nombre', 'value'=>''));
	//apellido
	$frm -> addElement('text', 'cliente_apellido', 'Apellido: ', array('id' => 'cliente_apellido', 'value'=>''));
	//documento
	$frm ->addElement('text','cliente_nro_doc','Documento: ',array('id' => 'cliente_nro_doc', 'value'=>''));
	//CUIL
	$frm ->addElement('text','cliente_CUIL','CUIL: ',array('id' => 'cliente_CUIL', 'value'=>''));
	//Cuenta Bancaria
	$frm ->addElement('text','cliente_cuenta_bancaria','Cuenta Bancaria: ',array('id' => 'cliente_cuenta_bancaria', 'value'=>''));
	
	//provincia y localidad
	//$frm ->addElement('text','comercializador_nombre','Provincia/Localidad: ',array('id' => 'comercializador_prov_loc', 'value'=>''));
	//estado
	$element = HTML_QuickForm::createElement('select', 'estado','Estado: ');
	$frm->addElement($element);
	$do_estado = DB_DataObject::factory('estado');

	$element->addOption ( "Todos" , null);
	$do_estado->orderBy('descripcion');
	$do_estado->find();
	$res=$do_estado->getDatabaseResult();

	$element->loadDbResult($res,'descripcion','id');
	
	//$frm ->addElement('select','cliente_estado_id','Estado: ',$estados,array('id' => 'cliente_estado_id', 'value'=>''));
	//fecha inicio
	//$frm ->addElement('text','comercializador_estado','Estado: ',array('id' => 'comercializador_estado', 'value'=>''));
	//aceptar
	$frm ->addElement('submit','aceptar','Filtrar',null);
	
	//traigo datos del form
	$id_cliente = $_GET['id_cliente'];
	$nombre = $_GET['cliente_nombre'];
	$apellido = utf8_decode($_GET['cliente_apellido']);
	$documento = $_GET['cliente_nro_doc'];
	$cuil = $_GET['cliente_CUIL'];
	$cuenta = $_GET['cliente_cuenta_bancaria'];
	$reparticion = $_GET['reparticion'];
	//$prov_loc = $_GET['cliente_prov_loc'];
	$estado = $_GET['estado'];

	
	$aceptar = $_GET['aceptar'];
	
	//armo consulta con los datos del filtro
	$do_cliente= DB_DataObject::factory('clientes');
	if($aceptar == 'Filtrar'){
		if ($id_cliente != '')
			$do_cliente -> whereAdd("cliente_id = '$id_cliente'"); 	
		if ($documento != '')
			$do_cliente -> whereAdd("cliente_nro_doc like '%$documento%'"); 	
		if ($apellido != '')
			$do_cliente -> whereAdd("cliente_apellido like '%$apellido%'");
		if ($nombre != '')
			$do_cliente -> whereAdd("cliente_nombre like '%$nombre%'");
		if ($cuil != '')
			$do_cliente -> whereAdd("cliente_CUIL like '%$cuil%'");
		if ($cuenta != '')
			$do_cliente -> whereAdd("cliente_cuenta_bancaria like '%$cuenta%'"); 
		/*if ($prov_loc[0] != '')
			$do_cliente -> whereAdd("cliente_provincia like '%$prov_loc[0]%'"); 	
		if ($prov_loc[1] != '')
			$do_cliente -> whereAdd("cliente_localidad like '%$prov_loc[1]%'"); */
		if ($estado != '')
			$do_cliente -> whereAdd("cliente_estado_id like '%$estado%'");
		if ($reparticion != '')
			$do_cliente -> whereAdd("cliente_reparticion_id like '%$reparticion%'"); 
			
	}	
	$do_cliente -> orderBy('cliente_apellido, cliente_nombre');
			
	//creo grilla
	$dg = new grilla(20);
	$dg->bind($do_cliente);
	
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">N&uacute;mero</span>','cliente_id',null,array('width' => '10px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Apellido</span>','cliente_apellido',null,array('width' => '30px', 'align' => "center"), null, 'get_ape()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Nombre</span>','cliente_nombre',null,array('width' => '60px', 'align' => "center"), null, 'get_nom()'));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">DNI</span>','cliente_doc_nro',null,array('width' => '20px', 'align' => "center")));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Provincia</span>','cliente_provincia',null,array('width' => '20px', 'align' => "center")));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Direcci&oacute;n</span>','cliente_direccion',null,array('width' => '20px', 'align' => "center"), null, 'get_dire()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Localidad</span>','cliente_localidad_id',null,array('width' => '20px', 'align' => "center"),null,'get_loca()'));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Documento</span>','cliente_nro_doc',null,array('width' => '20px', 'align' => "center"),null,'get_doc()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">CUIL</span>','cliente_CUIL',null,array('width' => '20px', 'align' => "center")));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Estado</span>','cliente_estado_id',null,array('width' => '20px', 'align' => "center"),null,'get_estado()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Estado</span>','cliente_estado_id',null,array('width' => '20px', 'align' => "center"),null,'get_estado_cliente',array('id' => 'cliente_id')));
	//FALTAN FECHAS!!
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Porcentaje</span>','comercializador_porcentaje',null,array('width' => '20px', 'align' => "center")));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Valor cuota</span>','comercializador_valor_cuota',null,array('width' => '20px', 'align' => "center")));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '5%', 'align' => "center"),null,'get_modificar_cliente',array('id' => 'cliente_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '20px', 'align' => "center"),null,'get_ejecutar_cliente',array('id' => 'cliente_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Adjuntos</span>',null,null,array('width' => '20px', 'align' => "center"),null,'get_adjuntos_cliente',array('id' => 'cliente_id')));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla"></span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_eliminar_comercializador',array('id' => 'comercializador_id')));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla"></span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_modificar_cliente',array('id' => 'cliente_id')));	
	//link para agregar una actividad
    $agregar = '<br><a href="alta_cliente.php">[Agregar cliente]</a>';
	
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
			$tpl->assign('msg', 'No hay clientes para mostrar.');
			$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
		}
	}
	$tpl->assign('body', '<div align=center><b>Clientes</b></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><div><br/>'.$agregar.'</div><div><br/>'.$salida_grilla.'</div><br/><b>Se encontraron '.$dg->getRecordCount().' Clientes<b/><br/><br/>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo','Clientes');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');	    
    exit;
?>