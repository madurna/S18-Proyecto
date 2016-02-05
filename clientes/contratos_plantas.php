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
	/*$ejecutar = $_GET['ejecutar'];
		
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
	}*/
	
	/*//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	//id cliente 	
	$frm ->addElement('text','id_cliente','N&uacute;mero Cliente: ',array('id' => 'id_cliente', 'value'=>''));
	//Razon Social
	$frm ->addElement('text','cliente_razon_social','Razon Social: ',array('id' => 'cliente_razon_social', 'value'=>''));
	//nombre 	
	$frm -> addElement('text', 'cliente_nombre', 'Nombre: ', array('id' => 'cliente_nombre', 'value'=>''));
	//apellido
	$frm -> addElement('text', 'cliente_apellido', 'Apellido: ', array('id' => 'cliente_apellido', 'value'=>''));
	//documento
	$frm ->addElement('text','cliente_nro_doc','Documento: ',array('id' => 'cliente_nro_doc', 'value'=>''));
	
	//arreglos estados
	$do_estado = DB_DataObject::factory('estado');
	$v_estado = $do_estado -> get_estados_todos();

	//estados
	$frm ->addElement('select','estado','Estado: ',$v_estado,array('id' => 'estado'));

	$frm ->addElement('submit','aceptar','Filtrar',null);
	
	//traigo datos del form
	$id_cliente = $_GET['id_cliente'];
	$nombre = $_GET['cliente_nombre'];
	$apellido = utf8_decode($_GET['cliente_apellido']);
	$documento = $_GET['cliente_nro_doc'];
	$r_social = $_GET['cliente_razon_social'];
	
	$estado = $_GET['estado'];
	
	$aceptar = $_GET['aceptar'];*/
	
	//armo consulta con los datos del filtro
	$do_contrato= DB_DataObject::factory('contrato');
	$do_planta= DB_DataObject::factory('planta');
	if($aceptar == 'Filtrar'){
		if ($id_cliente != '')
			$do_cliente -> whereAdd("cliente_id = '$id_cliente'"); 	
		if ($documento != '')
			$do_cliente -> whereAdd("cliente_nro_doc like '%$documento%'"); 	
		if ($apellido != '')
			$do_cliente -> whereAdd("cliente_apellido like '%$apellido%'");
		if ($nombre != '')
			$do_cliente -> whereAdd("cliente_nombre like '%$nombre%'");
		if ($r_social != '')
			$do_cliente -> whereAdd("cliente_razon_social like '%$r_social%'");
		if ($estado != 'Todos')
			$do_cliente -> whereAdd("cliente_estado_id like '%$estado%'");
			
	}	
	$do_cliente -> orderBy('cliente_apellido, cliente_nombre');
			
	//creo grilla
	$dg = new grilla(20);
	$dg->bind($do_cliente);
	
	/*$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">N&uacute;mero</span>','cliente_id',null,array('width' => '10px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">&nbsp;&nbsp;&nbsp;Apellido&nbsp;&nbsp;&nbsp;</span>','cliente_apellido',null,array('width' => '30px', 'align' => "center"), null, 'get_ape()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">&nbsp;&nbsp;&nbsp;Nombre&nbsp;&nbsp;&nbsp;</span>','cliente_nombre',null,array('width' => '60px', 'align' => "center"), null, 'get_nom()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Localidad</span>','cliente_localidad_id',null,array('width' => '20px', 'align' => "center"),null,'get_loca()'));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Estado</span>','cliente_estado_id',null,array('width' => '20px', 'align' => "center"),null,'get_estado_cliente',array('id' => 'cliente_id')));
	*///FALTAN FECHAS!!
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Porcentaje</span>','comercializador_porcentaje',null,array('width' => '20px', 'align' => "center")));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Valor cuota</span>','comercializador_valor_cuota',null,array('width' => '20px', 'align' => "center")));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '5%', 'align' => "center"),null,'get_modificar_cliente',array('id' => 'cliente_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">&nbsp;&nbsp;Acci&oacute;n&nbsp;&nbsp;</span>',null,null,array('width' => '20px', 'align' => "center"),null,'get_ejecutar_cliente',array('id' => 'cliente_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Planta</span>',null,null,array('width' => '20px', 'align' => "center"),null,'<get_plantas_cliente></get_plantas_cliente>',array('id' => 'cliente_id')));
	
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
	/*$tpl->assign('body', '<div align=center><b>Clientes</b></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><div><br/>'.$salida_grilla.'</div><br/><b>Se encontraron '.$dg->getRecordCount().' Clientes<b/><br/><br/>');
	*/$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo','Clientes');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');	    
    exit;
?>