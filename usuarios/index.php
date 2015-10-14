<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('../seguridad/seguridad.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	//elegimos que sublink se va a marcar
	$_SESSION['menu_principal'] = 4;
	
	//traido id del rol pasado por GET
	$rol_contenido = $_GET['contenido'];
	$area_contenido = $_GET['contenido_area'];

	//creo formulario
	$frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');
	//nombre	
	$frm ->addElement('text','usua_nombre','Nombre: ',array('id' => 'usua_nombre', 'value'=>''));
	$estado_form = array('Todos'=>'Todos','0'=>'Alta','1'=>'Baja');
	//estado
	$frm ->addElement('select', 'usua_baja', 'Estado: ', $estado_form, array('id' => 'usua_baja'));
	
	//areas
	$areas = array();
	$do_areas = DB_DataObject::factory('area');

	if ($area_contenido != ''){
		$areas = $do_areas -> get_areas_inicializado($area_contenido);
	}
	else{
		$areas = $do_areas -> get_areas_todas();
	}
	$frm -> addElement('select','select_areas','&Aacute;rea: ',$areas,array('id' => 'select_areas'));
	
	//roles
	$roles = array();
	$do_roles = DB_DataObject::factory('rol');
	if ($rol_contenido != ''){
		$roles = $do_roles -> get_roles_inicializado($rol_contenido);
	}
	else{
		$roles = $do_roles -> get_roles_todos();
	}
	$frm -> addElement('select','select_roles','Rol: ',$roles,array('id' => 'select_roles'));
	
	//aceptar
	$frm ->addElement('submit','aceptar','Filtrar',null);
	
	//traigo datos del form
	$nombre = $_GET['usua_nombre'];
	$area = $_GET['select_areas'];
	$estado = $_GET['usua_baja'];
	$rol = $_GET['select_roles'];
	$aceptar = $_GET['aceptar'];
	
	//armo consulta con los datos del filtro
	$do_usuario = DB_DataObject::factory('usuario');
	if ($aceptar == 'Filtrar'){
		//DB_DataObject::debugLevel(5); 
		if ($nombre != '')
			$do_usuario -> whereAdd("usua_nombre like '%$nombre%'");
		if ($estado != 'Todos')
			$do_usuario -> usua_baja = $estado;
		//AGREGAR DEMAS CAMPOS DEL FILTRO
		//filtro por rol
		if ($rol != 'Todos'){
			$do_rol = DB_DataObject::factory('rol');
			$do_rol -> rol_id = $rol;
			
			$do_usuario_rol = DB_DataObject::factory('usuario_rol');
			$do_usuario_rol -> joinAdd($do_rol);
			
			$do_usuario -> joinAdd($do_usuario_rol);
		}
		//filtro por area
		if ($area != 'Todas'){
			//DB_DataObject::debugLevel(5); 
			$do_area = DB_DataObject::factory('area');
			$do_area -> area_id = $area;
			
			$do_usuario_area = DB_DataObject::factory('usuario_area');
			$do_usuario_area -> joinAdd($do_area);
			
			$do_usuario -> joinAdd($do_usuario_area);
		}
		
	}
	
	//SI LLEGO DESDE "VER USUARIOS"
	//filtro por rol
	if ($rol_contenido != ''){
		$do_rol = DB_DataObject::factory('rol');
		$do_rol -> rol_id = $rol_contenido;
			
		$do_usuario_rol = DB_DataObject::factory('usuario_rol');
		$do_usuario_rol -> joinAdd($do_rol);
		
		$do_usuario -> joinAdd($do_usuario_rol);
	}
	//filtro por area
	if ($area_contenido != ''){
		//DB_DataObject::debugLevel(5); 
		$do_area = DB_DataObject::factory('area');
		$do_area -> area_id = $area_contenido;
		
		$do_usuario_area = DB_DataObject::factory('usuario_area');
		$do_usuario_area -> joinAdd($do_area);
		
		$do_usuario -> joinAdd($do_usuario_area);
	}
	
	$do_usuario -> orderBy('usua_id desc');
		
	//creo grilla
	$dg = new grilla(20);
	$dg->bind($do_usuario);
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Nombre</span>','usua_nombre',null,array('width' => '330px', 'align' => "center")));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Estado</span>',null,null,array('width' => '20%', 'align' => "center"),null,'get_estado_usuario',array('id' => 'usua_id')));
	//$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">&Aacute;reas</span>',null,null,array('width' => '20%', 'align' => "center"),null,'get_areas_usuarios',array('id' => 'usua_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Roles</span>',null,null,array('width' => '20%', 'align' => "center"),null,'get_roles_usuarios',array('id' => 'usua_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla">Acci&oacute;n</span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_modificar_usuario',array('id' => 'usua_id')));
	$dg->addColumn(new Structures_DataGrid_Column('<span class="tituloGrilla"></span>',null,null,array('width' => '5%', 'align' => "left"),null,'get_eliminar_usuario',array('id' => 'usua_id')));
		
	//link para agregar una actividad
    $agregar = '<br><a href="alta_usuario.php">[Agregar Usuario]</a>';
	
    //armo template
	$tpl = new tpl();
	if ($dg->getRecordCount() > 0 ) {		
		$salida_grilla=$dg->getOutput();
		$dg->setRenderer('Pager');
		$salida_grilla.=$dg->getOutput();
		$dg->setRendererOption('onMove', 'updateGrid', true);
	}
	else{
		if (($aceptar == 'Filtrar') or ($area_contenido != "") or ($rol_contenido != "")) {
			$tpl->assign('include_file', 'cartel.htm'); 
			$tpl->assign('imagen', 'informacion.jpg');
			$tpl->assign('msg', 'No hay usuarios para mostrar.');
			$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
		}
	}
	$tpl->assign('body', '<div align=center><b>Usuarios</b></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><div><br/>'.$agregar.'</div><div><br/>'.$salida_grilla.'</div>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Usuarios');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
    exit;