<?php
require_once("DB/DataObject.php");
/**
 * Modulo Actividades
 * 
 * recibe id de una actividad y retorna un link al script para modificarla
 *
 * @param integer -> id de una actividad 
 * @return string -> link al script para modificar una actividad
 */
function getModificarActividad($vals,$args){
	extract($vals);
	extract($args);

	return "<a href=modificar_actividad.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";

}
/**
 * Modulo Actividades
 * 
 * recibe id de una actividad y retorna un link al script para modificarla
 *
 * @param integer -> id de una actividad 
 * @return string -> link al script para modificar una actividad
 */
function getEliminarActividad($vals,$args){
	extract($vals);
	extract($args);
	
	$do_actividad = DB_DataObject::factory('actividad');
	$do_actividad -> actividad_id = $record[$id];
	if ($do_actividad -> find(true)){
		$estado = $do_actividad -> actividad_baja;
	}
	
	if ($estado == '0'){
		return "<a href=eliminar_actividad.php?contenido={$record[$id]}&accion=e><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
	/*
	else{
		return "<i class='fa fa-trash-o text-bg text-danger'></i>";
	}
	*/

}

/**
 * Modulo Actividades
 * 
 * recibe id de una actividad y retorna un si esta dado de baja o sino
 *
 * @param integer -> id de una actividad 
 * @return string -> link al script para modificar una actividad
 */
function getEstadoActividad($vals,$args){
	extract($vals);
	extract($args);
	$do_actividad = DB_DataObject::factory('actividad');
	$do_actividad -> actividad_id = $record[$id];
	$do_actividad -> actividad_baja = '0';
	if($do_actividad -> find(true))
		return '<img title="Actividad no eliminada" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Actividad eliminada" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Usuarios
 * 
 * recibe id de un usuario y retorna un si esta dado de baja o sino
 *
 * @param integer -> id de un usuario 
 * @return string -> link al script para modificar un usuario
 */
function get_estado_usuario($vals,$args){
	extract($vals);
	extract($args);
	$do_usuario = DB_DataObject::factory('usuario');
	$do_usuario -> usua_id = $record[$id];
	$do_usuario -> usua_baja = '0';
	if($do_usuario -> find(true))
		return '<img title="Usuario no eliminado" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Usuario eliminado" src="../img/spirit20_icons/system-red.png">';
}
	
/**
 * Modulo Usuarios
 * 
 * recibe id de un usuario y retorna un link al script para modificarla
 *
 * @param integer -> id de un usuario 
 * @return string -> link al script para modificar un usuario
 */
function get_modificar_usuario($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_usuario.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Usuarios
 * 
 * recibe id de un usuario y retorna un link al script para eliminarla
 *
 * @param integer -> id de un usuario
 * @return string -> link al script para eliminar un usuario
 */
function get_eliminar_usuario($vals,$args){
	extract($vals);
	extract($args);
	
	$do_usuario = DB_DataObject::factory('usuario');
	$do_usuario -> usua_id = $record[$id];
	if ($do_usuario -> find(true)){
		$estado = $do_usuario -> usua_baja;
	}
	if ($estado == '0'){
		return "<a href=eliminar_usuario.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo Roles
 * 
 * recibe id de un rol y retorna un link al script para modificarla
 *
 * @param integer -> id de un usuario
 * @return string -> link al script para modificar un usuario
 */
function get_modificar_rol($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_rol.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Roles
 * 
 * recibe id de un rol y retorna un link al script para eliminarla
 *
 * @param integer -> id de un usuario
 * @return string -> link al script para modificar un usuario
 */
function get_eliminar_rol($vals,$args){
	extract($vals);
	extract($args);
	
	$do_rol = DB_DataObject::factory('rol');
	$do_rol -> rol_id = $record[$id];
	$do_rol -> rol_baja = '0';
	if ($do_rol -> find(true)){
		return "<a href=eliminar_rol.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo Aplicaciones
 * 
 * recibe id de una app y retorna un link al script para modificarla
 *
 * @param integer -> id de una app
 * @return string -> link al script para modificar una app
 */
function get_modificar_app($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_aplicacion.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Aplicaciones
 * 
 * recibe id de una app y retorna un link al script para eliminarla
 *
 * @param integer -> id de una app
 * @return string -> link al script para modificar una app
 */
function get_eliminar_app($vals,$args){
	extract($vals);
	extract($args);
	
	$do_app = DB_DataObject::factory('aplicacion');
	$do_app -> app_id = $record[$id];
	$do_app -> app_baja = '0';
	if ($do_app -> find(true)){
		return "<a href=eliminar_aplicacion.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo Aplicaciones
 * 
 * recibe id de una app y retorna un link al script para ver los modulos de la app
 *
 * @param integer -> id de una app
 * @return string -> link al script para ver los modulos de la app
 */
function get_modulos_app($vals) {
		extract($vals);
		return "<a href=../modulos/index.php?contenido={$record['app_id']}><i class='fa fa-search text-bg text-danger'></i></a>";
}

/**
 * Modulo Roles
 * 
 * recibe id de un rol y retorna un link al script para ver los usuarios del rol
 *
 * @param integer -> id de una rol
 * @return string -> link al script para ver los usuarios del rol
 */
function get_usuarios_rol($vals,$args) {
	extract($vals);
	extract($args);
	return "<a href=../usuarios/index.php?contenido={$record['rol_id']}><i class='fa fa-search text-bg text-danger'></i></a>";
}

/**
 * Modulo Aplicaciones
 * 
 * recibe id de una aplicacion y retorna un icono de activo/inactivo
 *
 * @param integer -> id de una aplicacion
 * @return string -> icono de activo/inactivo
 */
function get_estado_app($vals,$args){
	extract($vals);
	extract($args);
	$do_aplicacion = DB_DataObject::factory('aplicacion');
	$do_aplicacion -> app_id = $record['app_id'];
	$do_aplicacion -> app_baja = '0';
	if($do_aplicacion -> find(true))
		return '<img title="Aplicación no eliminada" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Aplicación eliminada" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Roles
 * 
 * recibe id de un rol y retorna un icono de activo/inactivo
 *
 * @param integer -> id de un rol
 * @return string -> icono de activo/inactivo
 */
function get_estado_rol($vals,$args){
	extract($vals);
	extract($args);
	$do_rol = DB_DataObject::factory('rol');
	$do_rol -> rol_id = $record['rol_id'];
	$do_rol -> rol_baja = '0';
	if($do_rol -> find(true))
		return '<img title="Rol no eliminado" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Rol eliminado" src="../img/spirit20_icons/system-red.png">';
}

/** 
* Modulo Modulos
* 
* recibe la id de una aplicacion y retorna su nombre
*
* @return string nombre de la aplicacion
* @param array $vals registro de la grilla y string con el campo de id de aplicacion
*/
function get_app_modulo($vals,$args){
	extract($vals);
	extract($args);
	
	$do_aplicaciones = DB_DataObject::factory('aplicacion');
	$do_aplicaciones -> app_id = $record['mod_app_id'];
	if ($do_aplicaciones -> find(true)){
		return $do_aplicaciones -> app_nombre;
	}
	else{
		return '';
	}
}

/**
* Modulo Modulos 
* 
* recibe el id de un modulo y retorna un link para ver las p?ginas asociadas
* 
* @param integer -> id de un modulo
* @return string -> link al script para ver las paginas asociadas
*/
function get_paginas_modulos($vals){
	extract($vals);
	return "<a href=../paginas/index.php?contenido={$record['mod_id']}><i class='fa fa-search text-bg text-danger'></i></a>";
}

/**
 * Modulo Modulos
 * 
 * recibe id de una modulo y retorna un link al script para modificarlo
 *
 * @param integer -> id de un modulo
 * @return string -> link al script para modificar un modulo
 */
function get_editar_modulo($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_modulo.php?contenido={$record['mod_id']}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Modulos
 * 
 * recibe id de un modulo y retorna un link al script para eliminarlo
 *
 * @param integer -> id de un modulo
 * @return string -> link al script para modificar un modulo
 */
function get_eliminar_modulo($vals,$args){
	extract($vals);
	extract($args);
	
	$do_modulo = DB_DataObject::factory('modulo');
	$do_modulo -> mod_id = $record[$id];
	$do_modulo -> mod_baja = '0';
	if ($do_modulo -> find(true)){
		return "<a href=eliminar_modulo.php?contenido={$record['mod_id']}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo usuarios_rol
 * 
 * recibe id de un usuario y retorna un link al script para ver los roles de ese usuario
 *
 * @param integer -> id de un usuario
 * @return string -> link al script para ver los roles de ese usuario
 */
function get_roles_usuarios($vals,$args) {
	extract($vals);
	extract($args);
	return "<a href=../usuarios_rol/index.php?contenido={$record['usua_id']}><i class='fa fa-search text-bg text-danger'></i></a>";
}

/**
 * Modulo usuarios_rol
 * 
 * recibe id de un usuario y retorna un link al script para eliminar el rol de ese usuario
 *
 * @param integer -> id de un usuario
 * @return string -> link al script para ver los roles de ese usuario
 */
function get_eliminar_usuario_rol($vals,$args) {
	extract($vals);
	extract($args);
	return "<a href=../usuarios_rol/eliminar.php?contenido={$record['usrrol_id']}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
}

/**
 * Modulo modulos
 *  
 * recibe id de un modulo y retorna un link al script para ver el estado del modulo
 *
 * @param integer -> id de un modulo
 * @return string -> link al script para ver el estado del modulo
 */
function get_estado_modulo($vals,$args){
	extract($vals);
	extract($args);
	$do_modulo = DB_DataObject::factory('modulo');
	$do_modulo -> mod_id = $record['mod_id'];
	$do_modulo -> mod_baja = '0';
	if($do_modulo -> find(true))
		return '<img title="Modulo no eliminado" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Modulo eliminado" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Area
 * 
 * recibe id de una area y retorna un link al script para modificarla
 *
 * @param integer -> id de una area
 * @return string -> link al script para modificar una area
 */
function get_modificar_area($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_area.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Area
 * 
 * recibe id de una area y retorna un link al script para eliminarla
 *
 * @param integer -> id de una area
 * @return string -> link al script para modificar una area
 */
function get_eliminar_area($vals,$args){
	extract($vals);
	extract($args);
	
	$do_area = DB_DataObject::factory('area');
	$do_area -> area_id = $record[$id];
	$do_area -> area_baja = '0';
	if ($do_area -> find(true)){
		return "<a href=eliminar_area.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo Area
 * 
 * recibe id de una area y retorna un icono de activo/inactivo
 *
 * @param integer -> id de una area
 * @return string -> icono de activo/inactivo
 */
function get_estado_area($vals,$args){
	extract($vals);
	extract($args);
	$do_aplicacion = DB_DataObject::factory('area');
	$do_aplicacion -> area_id = $record['area_id'];
	$do_aplicacion -> area_baja = '0';
	if($do_aplicacion -> find(true))
		return '<img title="Area no eliminada" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Area eliminada" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Paginas
 * 
 * recibe id de un modulo_pagina y retorna un link al script para modificarla
 *
 * @param integer -> id de un modulo_pagina 
 * @return string -> link al script para modificar un modulo_pagina
 */
function get_editar_pagina($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_pagina.php?contenido={$record['modpag_id']}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Paginas
 * 
 * recibe id de un modulo_pagina y retorna un link al script para eliminarla
 *
 * @param integer -> id de un modulo_pagina
 * @return string -> link al script para eliminar un modulo_pagina
 */
function get_eliminar_pagina($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=eliminar_pagina.php?contenido={$record['modpag_id']}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
}

/**
 * Modulo Paginas
 * 
 * recibe id de un modulo_pagina y retorna el nombre del modulo
 *
 * @param integer -> id de un modulo_pagina
 * @return string -> nombre del modulo
 */
function get_nombre_pagina($vals,$args){
	extract($vals);
	extract($args);
	
	$do_paginas = DB_DataObject::factory('modulo_paginas');
	$do_paginas -> modpag_id = $record['modpag_id'];
	if ($do_paginas -> find(true)){
		$modulo_id = $do_paginas -> modpag_mod_id;
		
		$do_modulo = DB_DataObject::factory('modulo');
		$do_modulo -> mod_id = $modulo_id;
		if ($do_modulo -> find(true)){
			$nombre = $do_modulo -> mod_nombre;
		}
	}	
	return $nombre;
}

/**
 * Modulo Tipos Acceso
 * 
 * recibe id de un tipo de acceso y retorna un link al script para modificarlo
 *
 * @param integer -> id de un tipo de acceso
 * @return string -> link al script para modificar un tipo de acceso
 */
function get_modificar_tipoacc($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_acceso.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Tipo Acceso
 * 
 * recibe id de un tipo de acceso y retorna un link al script para eliminarlo
 *
 * @param integer -> id de un tipo de acceso
 * @return string -> link al script para eliminar un tipo de acceso
 */
function get_eliminar_tipoacc($vals,$args){
	extract($vals);
	extract($args);
	
	$do_acceso = DB_DataObject::factory('tipo_acceso');
	$do_acceso -> tipoacc_id = $record[$id];
	$do_acceso -> tipoacc_baja = '0';
	if ($do_acceso -> find(true)){
		return "<a href=eliminar_acceso.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";	
	}
}

/**
 * Modulo Tipo Acceso
 * 
 * recibe id de un tipo de acceso y retorna un icono de activo/inactivo
 *
 * @param integer -> id de un tipo de acceso
 * @return string -> icono de activo/inactivo
 */
function get_estado_tipoacc($vals,$args){
	extract($vals);
	extract($args);
	$do_acceso = DB_DataObject::factory('tipo_acceso');
	$do_acceso -> tipoacc_id = $record['tipoacc_id'];
	$do_acceso -> tipoacc_baja = '0';
	if($do_acceso -> find(true))
		return '<img title="Tipo Acceso no eliminado" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Tipo Acceso eliminado" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Permisos
 * 
 * recibe id de aplicacion, modulo, rol y tipo de acceso y retorna un checkbox tildado o no y un elemento oculto con el valor 1 o 0
 *
 * @param integer -> id de aplicacion, modulo , rol y tipo de acceso
 * @return string -> icono de activo/inactivo y un elemento oculto
 */
function get_estado_permiso($vals,$args){
	extract($vals);
	extract($args);

	//id del modulo = $record['mod_id']
	//id del rol = $args['rol_id']
	//tipo de acceso = $args['tipoacc_id']
	//id de la aplicacion = $args['app_id']
	$modulo_id = $record['mod_id'];
	$rol_id = $args['rol_id'];
	$tipoacc_id = $args['tipoacc_id'];
	$app_id = $args['app_id'];
	
	//DB_DataObject::debugLevel(5);
	$do_permiso = DB_DataObject::factory('permiso');
	$do_permiso -> permiso_rol_id = $rol_id;
	$do_permiso -> permiso_mod_id = $modulo_id;
	$do_permiso -> permiso_tipoacc_id = $tipoacc_id;
	
	//la funcion del onclick esta desarrollada en /js/cambiar_estado.js
	if ($do_permiso -> find(true)){
		return "<input type='checkbox' id='estado[$modulo_id][$tipoacc_id]' name='estado[$modulo_id][$tipoacc_id]' value='1' title='Tiene permiso' checked='checked' ONCLICK='cambiar_estado($app_id,$rol_id,$modulo_id,$tipoacc_id,\"mostrar\")'>
				<input type='hidden' id ='estado_original[$modulo_id][$tipoacc_id]' name='estado_original[$modulo_id][$tipoacc_id]' value='1'>";
	}
	else{ 
		return "<input type='checkbox' id='estado[$modulo_id][$tipoacc_id]' name='estado[$modulo_id][$tipoacc_id]' value='0' title='No tiene permiso' ONCLICK='cambiar_estado($app_id,$rol_id,$modulo_id,$tipoacc_id,\"mostrar\")'>
				<input type='hidden' id ='estado_original[$modulo_id][$tipoacc_id]' name='estado_orignal[$modulo_id][$tipoacc_id]' value='0'>";
	}
}

/**
 * Modulo Area
 * 
 * recibe id de un area y retorna un link al script para ver los usuarios del area
 *
 * @param integer -> id de un area
 * @return string -> link al script para ver los usuarios dl area
 */
function get_usuarios_area($vals,$args) {
	extract($vals);
	extract($args);
	return "<a href=../usuarios/index.php?contenido_area={$record['area_id']}><i class='fa fa-search text-bg text-danger'></i></a>";
}

/**
 * Modulo usuarios_area
 * 
 * recibe id de un usuario y retorna un link al script para ver las areas de ese usuario
 *
 * @param integer -> id de un usuario
 * @return string -> link al script para ver las areas de ese usuario
 */
function get_areas_usuarios($vals,$args) {
	extract($vals);
	extract($args);
	return "<a href=../usuarios_area/index.php?contenido={$record['usua_id']}><i class='fa fa-search text-bg text-danger'></i></a>";
}

/**
 * Modulo usuarios_area
 * 
 * recibe id de un usuario y retorna un link al script para eliminar el area de ese usuario
 *
 * @param integer -> id de un usuario
 * @return string -> link al script para eliminar las areas de ese usuario
 */
function get_eliminar_usuario_area($vals,$args) {
	extract($vals);
	extract($args);
	return "<a href=../usuarios_area/eliminar.php?contenido={$record['usarea_id']}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
}

/**
 * Modulo Permisos
 * 
 * recibe id de aplicacion, modulo y rol y retorna un elemento oculto para ser utilizado cuando se detecta un cambio en los checkbox de tipos de acceso
 *
 * @param integer -> id de modulo
 * @return string -> elemento oculto
 */
function get_modificar_permisos($vals,$args){
	extract($vals);
	extract($args);

	//id del modulo = $record['mod_id']
	//id del rol = $args['rol_id']
	//id de la aplicacion = $args['app_id']
	$modulo_id = $record['mod_id'];
	$rol_id = $args['rol_id'];
	$app_id = $args['app_id'];
	
	//onclick='window.location.href=\"index.php\"'
	
	//la funcion del onclick esta desarrollada en /js/cambiar_estado.js
	return "<input type='hidden' id ='modificar_permiso[$modulo_id]' name='modificar_permiso[$modulo_id]' value='Guardar' onclick='cambiar_estado($app_id,$rol_id,$modulo_id,\"0\",\"eliminar\")'>";
}

/**
 * Modulo Permisos
 *
 * recibe id de aplicacion, modulo y rol y retorna un checkbox para tildar o destildar todos los checkbox del modulo
 *
 * @param integer -> id de modulo, rol y aplicacion
 * @return string -> checkbox
 */
function get_tildar_todos($vals,$args){
	extract($vals);
	extract($args);

	//id del modulo = $record['mod_id']
	//id del rol = $args['rol_id']
	//id de la aplicacion = $args['app_id']
	$modulo_id = $record['mod_id'];
	$rol_id = $args['rol_id'];
	$app_id = $args['app_id'];

	//verifico si el modulo tiene habilitado todos los tipos de accesos para ese rol
	$seguir = true;
	$do_tipoacc = DB_DataObject::factory('tipo_acceso');
	$do_tipoacc -> find();
	while ( ($do_tipoacc -> fetch()) and ($seguir) ){
		//DB_DataObject::debugLevel(5);
		$do_permiso = DB_DataObject::factory('permiso');
		$do_permiso -> permiso_rol_id = $rol_id;
		$do_permiso -> permiso_mod_id = $modulo_id;
		$do_permiso -> permiso_tipoacc_id = $do_tipoacc -> tipoacc_id;
		
		if (!$do_permiso -> find(true)){
			$seguir = false;
		}
	}

	//la funcion del onclick esta desarrollada en /js/cambiar_estado.js
	if ($seguir){
		return "<input type='checkbox' id='tildar[$modulo_id]' name='tildar[$modulo_id]' value='1' title='Todos los permisos' checked='checked' ONCLICK='cambiar_estado($app_id,$rol_id,$modulo_id,\"0\",\"tildar\")'>";
	}
	else{
		return "<input type='checkbox' id='tildar[$modulo_id]' name='tildar[$modulo_id]' value='0' title='Ningun permiso' ONCLICK='cambiar_estado($app_id,$rol_id,$modulo_id,\"0\",\"tildar\")'>";
	}
}

/**
 * Modulo Proceso
 * 
 * recibe id de un proceso y retorna un link al script para modificarlo
 *
 * @param integer -> id de un proceso 
 * @return string -> link al script para modificar un proceso
 */
function getModificarProceso($vals,$args){
	extract($vals);
	extract($args);

	return "<a href=modificar_proceso.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";

}

/**
 * Modulo Operacion
 * 
 * recibe id de una operacion y retorna un si esta dado de baja o sino
 *
 * @param integer -> id de una operacion 
 * @return string -> link al script para modificar una operacion
 */
function getEstadoOperacion($vals,$args){
	extract($vals);
	extract($args);
	$do_operacion = DB_DataObject::factory('operacion');
	$do_operacion -> operacion_id = $record[$id];
	$do_operacion -> operacion_baja = '0';
	if($do_operacion -> find(true))
		return '<img title="Operacion no eliminada" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Operacion eliminada" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Operacion
 * 
 * recibe id de una operacion y retorna un link al script para modificarla
 *
 * @param integer -> id de una operacion 
 * @return string -> link al script para modificar una operacion
 */
function getModificarOperacion($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_operacion.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Operacion
 * 
 * recibe id de una operacion y retorna un link al script para modificarla
 *
 * @param integer -> id de una operacion
 * @return string -> link al script para modificar una operacion
 */
function getEliminarOperacion($vals,$args){
	extract($vals);
	extract($args);
	
	$do_operacion = DB_DataObject::factory('operacion');
	$do_operacion -> operacion_id = $record[$id];
	if ($do_operacion -> find(true))
		$estado = $do_operacion -> operacion_baja;
	if ($estado == '0')
		return "<a href=eliminar_operacion.php?contenido={$record[$id]}&accion=e><i class='fa fa-trash-o text-bg text-danger'></i></a>";
}

/**
 * Devuelve un array de a?os para el form
 *
 * @param 
 * @return array
 */
function get_anio_form(){
		$array = array(Anio=>'Año',get_anio(-5)=>get_anio(-5),get_anio(-4)=>get_anio(-4),get_anio(-3)=>get_anio(-3),get_anio(-2)=>get_anio(-2),get_anio(-1)=>get_anio(-1),get_anio(0)=>get_anio(0),get_anio(1)=>get_anio(1),get_anio(2)=>get_anio(2),get_anio(3)=>get_anio(3),get_anio(4)=>get_anio(4),get_anio(5)=>get_anio(5));
		return $array;
}
	
/**
 * Devuelve la diferencia del a?o actual - valor
 *
 * @param valor
 * @return entero
 */
function get_anio($valor){
		$anio_actual = date('Y');
		$anio = $anio_actual + $valor;
		return $anio;
}

/**
 * Modulo Proceso
 * Devuelve links agregar actividad / configurar actividad
 * 
 * @param actividad_nro actividad_id
 * @return string -> link al script para agregar actividad / configurar actividad
 */
function get_proceso_accion($vals,$args){
	extract($vals);
	extract($args);
	$actividad_nro = $record['actividad_nro'];
	$actividad_id = $record['actividad_id'];
	if($actividad_id == '0')
		return "<a href='#' title='Agregar Actividad' onClick='configurarActividad(\"../procesos/actividad_proceso.php?actividad_nro=$actividad_nro\")'>[Agregar]</a>";
	else 
		return "<a href='#' title='Configurar Actividad' onClick='configurarActividad(\"../procesos/configurar_actividad_proceso.php?actividad_nro=$actividad_nro\")'>[Configurar]</a>";
}

/**
 * Modulo Proceso
 * Devuelve links ver operaciones
 * 
 * @param 
 * @return string -> link al script para ver operaciones
 */
function get_proceso_operaciones($vals,$args){
	extract($vals);
	extract($args);
	$actividad_nro = $record['actividad_nro'];
	$actividad_id = $record['actividad_id'];
	if($actividad_id == '0')
		return '-';
	else
		return "<a href='#' title='Ver Operaciones' onClick='configurarOperacion(\"../procesos/ver_operaciones.php?actividad_id=$actividad_id&actividad_nro=$actividad_nro\")'><i class='fa fa-search text-bg text-danger'></i></a>";
}

/**
 * Modulo Proceso
 * Devuelve el area de una actividad de un proceso
 * 
 * @param id de area
 * @return string -> nombre de area
 */
function get_proceso_area($vals,$args){
	extract($vals);
	extract($args);
	$do_area = DB_DataObject::factory('area');
	$do_area -> area_id = $record['area_id'];
	if($do_area -> find(true))
		return $do_area -> area_nombre;
	else
		return '-';
}

/**
 * Modulo Proceso
 * Devuelve el nombre de una actividad de un proceso
 * 
 * @param id de actividad
 * @return string -> nombre de actividad
 */
function get_proceso_actividad($vals,$args){
	extract($vals);
	extract($args);
	$do_actividad = DB_DataObject::factory('actividad');
	$do_actividad -> actividad_id = $record['actividad_id'];
	if($do_actividad -> find(true))
		return $do_actividad -> actividad_nombre;
	else 
		return "Crear nueva actividad..";
}

/**
 * Modulo Proceso
 * Devuelve el nombre de una actividad de un proceso
 * 
 * @param id de actividad
 * @return string -> nombre de actividad
 */
function get_proceso_actividad_ste($vals,$args){
	extract($vals);
	extract($args);
	$do_actividad = DB_DataObject::factory('actividad');
	$do_actividad -> actividad_id = $record['actividad_ste'];
	if($do_actividad -> find(true))
		return $do_actividad -> actividad_nombre;
	else 
		return "Sin asignar";
}

/**
 * Modulo Sucursales
 * 
 * recibe id de un sucursal y retorna un link al script para modificarla
 *
 * @param integer -> id de un usuario
 * @return string -> link al script para modificar un usuario
 */
function get_modificar_sucursal($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_sucursal.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}
/** Modulo Sucursales
 * recibe id de una sucursal y retorna un si esta dado de baja o sino
 *
 * @param integer -> id de un sucursal
 * @return string -> link al script para modificar un sucursal
 */
function get_estado_sucursal($vals,$args){
	extract($vals);
	extract($args);
	$do_sucursal = DB_DataObject::factory('sucursal');
	$do_sucursal -> sucursal_id = $record[$id];
	$do_sucursal -> sucursal_baja = '0';
	if($do_sucursal -> find(true))
		return '<img title="Sucursal no eliminada" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Sucursal eliminada" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Sucursales
 * 
 * recibe id de un sucursal y retorna un link al script para eliminarla
 *
 * @param integer -> id de un usuario
 * @return string -> link al script para modificar un usuario
 */
function get_eliminar_sucursal($vals,$args){
	extract($vals);
	extract($args);
	
	$do_sucursal = DB_DataObject::factory('sucursal');
	$do_sucursal -> sucursal_id = $record[$id];
	if ($do_sucursal -> find(true)){
		return "<a href=eliminar_sucursal.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo comercializadores
 * 
 * recibe id de un comercializador y retorna un link al script para modificarla
 *
 * @param integer -> id de un usuario
 * @return string -> link al script para modificar un usuario
 */
function get_modificar_comercializador($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_comercializador.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo comercializadores
 * 
 * recibe id de un comercializador y retorna un link al script para eliminarla
 *
 * @param integer -> id de un usuario
 * @return string -> link al script para modificar un usuario
 */
function get_eliminar_comercializador($vals,$args){
	extract($vals);
	extract($args);
	
	$do_comercializador = DB_DataObject::factory('comercializador');
	$do_comercializador -> comercializador_id = $record[$id];
	if ($do_comercializador -> find(true)){
		return "<a href=eliminar_comercializador.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

function get_adjuntos_comercializador($vals,$args){
	extract($vals);
	extract($args);
	
	return "<a href=adjuntos_comercializador.php?contenido={$record[$id]}><i class='fa fa-paperclip text-bg text-danger'></i></a>";
	
}
/** Modulo comercializadores
 * recibe id de una comercializador y retorna un si esta dado de baja o sino
 *
 * @param integer -> id de un comercializador
 * @return string -> link al script para modificar un comercializador
 */
function get_estado_comercializador($vals,$args){
	extract($vals);
	extract($args);
	$do_comercializador = DB_DataObject::factory('comercializador');
	$do_comercializador -> comercializador_id = $record[$id];
	$do_comercializador -> comercializador_baja = '0';
	if($do_comercializador -> find(true))
		return '<img title="Comercializador no eliminada" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Comercializador eliminada" src="../img/spirit20_icons/system-red.png">';
}
/**
 * Modulo reparticiones
 * 
 * recibe id de un reparticion y retorna un link al script para modificarla
 *
 * @param integer -> id de un usuario
 * @return string -> link al script para modificar un usuario
 */
function get_modificar_reparticion($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_reparticion.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo reparticiones
 * 
 * recibe id de un reparticion y retorna un link al script para eliminarla
 *
 * @param integer -> id de un usuario
 * @return string -> link al script para modificar un usuario
 */
function get_eliminar_reparticion($vals,$args){
	extract($vals);
	extract($args);
	
	$do_reparticion = DB_DataObject::factory('reparticion');
	$do_reparticion -> reparticion_id = $record[$id];
	if ($do_reparticion -> find(true)){
		return "<a href=eliminar_reparticion.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}
/** Modulo reparticiones
 * recibe id de una sucursal y retorna un si esta dado de baja o sino
 *
 * @param integer -> id de un sucursal
 * @return string -> link al script para modificar un sucursal
 */
function get_estado_reparticion($vals,$args){
	extract($vals);
	extract($args);
	$do_reparticion = DB_DataObject::factory('reparticion');
	$do_reparticion -> reparticion_id = $record[$id];
	$do_reparticion -> reparticion_baja = '0';
	if($do_reparticion -> find(true))
		return '<img title="Repartición no eliminada" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Repartición eliminada" src="../img/spirit20_icons/system-red.png">';
}

function get_areas($vals,$args) {
	extract($vals);
	extract($args);
	$onClick='mostrarDialogo("../reparticion/verAreas.php?contenido='.$record[$id].'",500,300)';
	return '<a href="#" title="Agregar" onClick='.$onClick.'><img src="../img/spirit20_icons/magnify.png"></a>';
}

/**
 * Modulo clientes
 * 
 * recibe id de un cliente y retorna un link al script para modificarla
 *
 * @param integer -> id de un cliente
 * @return string -> link al script para modificar un cliente
 */
function get_modificar_cliente($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_cliente.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

function get_ejecutar_cliente($vals,$args){
	extract($vals);
	extract($args);
	
	//ver adjuntos
	$mostrar = "<a title='Adjuntar' href=adjuntos_cliente.php?contenido={$record[$id]}><i class='fa fa-paperclip text-bg'></i></a>";
	//
	
	//ver
	$mostrar = $mostrar."&nbsp;&nbsp;<a title='Ver Cliente' href=ver_cliente.php?contenido={$record[$id]}&ver=v><i class='fa fa-search text-bg'></i></a>";
	//
	
	//modificar
	$mostrar = $mostrar."&nbsp;&nbsp;<a title='Modificar Cliente' href=modificar_cliente.php?contenido={$record[$id]}&accion=m><i class='fa fa-pencil text-bg'></i></a>";
	//
	
	return $mostrar;
}

function get_adjuntos_cliente($vals,$args){
	extract($vals);
	extract($args);
	
	return "<a href=#><i class='fa fa-paperclip text-bg text-danger'></i></a>";
	
}

function get_contratos_cliente($vals,$args){
	extract($vals);
	extract($args);
	
	return "<a href=../contratos/contrato.php?contenido={$record[$id]}><i class='fa fa-edit text-bg'></i></a>";
	
}

function get_plantas_cliente($vals,$args){
	extract($vals);
	extract($args);
	
	return "<a href=../planta/planta.php?contenido={$record[$id]}><i class='fa fa-industry text-bg'></i></a>";
	
}
/**
 * Retorna el estado del cliente con iconos, indicando si esta activo o no
 * @param integer -> id de un cliente
 * 
 */
function get_estado_cliente($vals,$args){
	extract($vals);
	extract($args);
	$do_clientes = DB_DataObject::factory('clientes');
	$do_clientes -> cliente_id = $record[$id];
	//$do_clientes -> cliente_estado_id = '3';
	$do_clientes -> find(true);
	
	if ($do_clientes -> cliente_estado_id == '3'){
		return '<img title="Cliente Ejecutado" src="../img/spirit20_icons/system-delete-alt-03.png">';	
	}
	elseif ($do_clientes -> cliente_estado_id == '1'){ 
		return '<img title="Cliente Activo" src="../img/spirit20_icons/system-tick-alt-02.png">';
	}
	else{
		return '<img title="Cliente Inactivo" src="../img/spirit20_icons/system-info-alt-02.png">';
	}
}


/**
 * Modulo obrero
 * 
 * recibe id de un obrero y retorna un link al script para modificarla
 *
 * @param integer -> id de un obrero
 * @return string -> link al script para modificar un obrero
 */
function get_modificar_obrero($vals,$args){
	extract($vals);
	extract($args);

	$funciones= "<a href=ver_obrero.php?contenido={$record[$id]}&accion=m> <i class='fa fa-search text-bg text-danger'></i> </a>";
	$funciones.= "<a href=modificar_obrero.php?contenido={$record[$id]}&accion=m> <i class='fa fa-edit text-bg text-danger'></i> </a>";

	return $funciones;
}


function get_adjuntos_obrero($vals,$args){
	extract($vals);
	extract($args);
	
	return "<a href=#><i class='fa fa-paperclip text-bg text-danger'></i></a>";
	
}

/**
 * Retorna el estado del obrero con iconos, indicando si esta activo o no
 * @param integer -> id de un obrero
 * 
 */
function get_estado_obrero($vals,$args){
	extract($vals);
	extract($args);
	
	$do_obrero = DB_DataObject::factory('obrero');
	$do_obrero -> obrero_id = $record[$id];
	
	$do_obrero -> find(true);
	
	if ($do_obrero -> obrero_estado_id == '3'){
		return '<img title="Obrero Ejecutado" src="../img/spirit20_icons/system-delete-alt-03.png">';	
	}
	elseif ($do_obrero -> obrero_estado_id == '1'){ 
		return '<img title="Obrero Activo" src="../img/spirit20_icons/system-tick-alt-02.png">';
	}
	else{
		return '<img title="Obrero Inactivo" src="../img/spirit20_icons/system-info-alt-02.png">';
	}
}



// Recibe una cantidad num?rica y la retorna en formato n?mero real espa?ol
// P/e: numeroReal(1234.56) Retornar?: 1.234,56
function numeroReal($cantidad) {
	return number_format(round($cantidad,2),2,',','.');
}

// Recibe una cantidad numérica y la retorna en formato moneda
// P/e: monedaConPesos(1234.56) Retornará: $ 1.234,56
function monedaConPesos($cantidad) {

	if ($cantidad<0) {
		return '- $ ' . str_replace('-', '', numeroReal($cantidad));
	} else {
		return '$ ' . numeroReal($cantidad);
	}

}

function getArrayFecha($fecha = null, $formato = 'a-m-d') {
		if(is_null($fecha)) return false;
		switch ($formato) {
			case 'd/m/a':
				$separador = '/';
				$dma = array('d' => 0, 'm' => 1, 'a' => 2);
				break;
			default:
				$separador = '-';
				$dma = array('d' => 2, 'm' => 1, 'a' => 0);
		}		
		if (count($fechabits=explode($separador, $fecha)) != 3) return false;			
		return array(
			'd'	=> $fechabits[$dma['d']],// intval($fechabits[$dma['d']]),
			'm'	=> $fechabits[$dma['m']],// intval($fechabits[$dma['m']]),
			'a'	=> $fechabits[$dma['a']] // intval($fechabits[$dma['a']])
		);		
	}

function setFecha($fecha) {	
		if(!($date = getArrayFecha($fecha, 'd/m/a'))) return false;
    	return "{$date['a']}-{$date['m']}-{$date['d']}";	// pasa a formato ISO de BD
	}

function fb_Date2Array($date) {
    		if ($date == null || !strlen($date))
	        	return array();
	    	else {
	        	//return DB_DataObject_FormBuilder::_date2array($date);
	        	$date2 = DB_DataObject_FormBuilder::_date2array($date);
	        	if (strlen($date2['d']) == 1) $date2['d'] = '0'.$date2['d'];
	        	if (strlen($date2['m']) == 1) $date2['m'] = '0'.$date2['m'];
	        	return "{$date2['d']}-{$date2['m']}-{$date2['Y']}";
	    	}
}


/**
 * Modulo Prestamos
 * 
 * recibe id de tipo documento y devuelve el tipo de documento
 *
 * @param integer -> id de tipo documento
 * @return string -> tipo documento
 */
function get_tipo_documento($vals,$args){
	extract($vals);
	extract($args);
	//habria que ver si hay do de tipo de documento
	$do_tipo_documento = DB_DataObject::factory('tipo_documento');
	$do_tipo_documento -> tipo_doc_id = $record[$id];
	if($do_tipo_documento -> find(true))
		return $do_tipo_documento -> tipo_doc_descripcion;
}	

/**
 * Modulo todos
 * 
 * recibe una fecha aaaa-mm-dd y devuelve dd-mm-aaaa
 *
 * @param date -> fecha aaaa-mm-dd
 * @return date -> fecha dd-mm-aaaa
 */
function get_fecha_a_ddmmaaaa($vals,$args){
	extract($vals);
	extract($args);
	
	if($args['fecha'] == 'inicio')
		$fecha = $record['prestamo_fecha_inicio'];
	elseif($args['fecha'] == 'fin')
		$fecha = $record['prestamo_fecha_fin'];
	else
		$fecha = $record['prestamo_fecha_primer_cobro'];
	
	list($anio,$mes,$dia) = explode("-",$fecha);
	return $dia.'-'.$mes.'-'.$anio;
}

/**
 * Modulo Prestamos
 *
 * recibe id de cuota y prestamo y retorna el valor de la cuota
 *
 * @param integer -> id de cuota y prestamo
 * @return string -> monto de la cuota
 */
function getValorCuota($vals,$args){
	extract($vals);
	extract($args);
	
	$do_cuota = DB_DataObject::factory('cuota');
	$do_cuota -> cuota_id = $record[$id];
	if ($do_cuota -> find(true)){
		$valor_cuota = $do_cuota -> cuota_valor_real;
		if ($do_cuota -> cuota_pago_cuota_id != '0'){
			$do_punitorio_prestamos = DB_DataObject::factory('punitorio_prestamo');
			$do_punitorio_prestamos -> punitorio_prestamo_cuota_id = $do_cuota -> cuota_id;
			if ($do_punitorio_prestamos -> find(true)){
				$valor_cuota = $valor_cuota + $do_punitorio_prestamos -> punitorio_prestamo_monto;
			}
		}
		else{
			$fecha_hoy = date('Y-m-d');
			$dias_vencidos = dias_transcurridos($fecha_hoy, $do_cuota -> cuota_fecha_vencimiento);
			if ($dias_vencidos > 0){
				$coeficiente = '1';
				$valor_cuota = $valor_cuota + ($dias_vencidos * $coeficiente);
			}
		}
		
		$do_punitorio_prestamo = DB_DataObject::factory('punitorio_prestamo');
		$do_punitorio_prestamo -> punitorio_prestamo_prestamo_id = cuota_prestamo_id;
	}
	return $valor_cuota;
}

/**
 * Modulo Prestamos
 *
 * recibe id de pago_cuota y devuelve el monto pagado
 *
 * @param integer -> id de pago_cuota
 * @return string -> monto pagado
 */
function getMontoPagos($vals,$args){
	extract($vals);
	extract($args);

	$do_pago_cuota= DB_DataObject::factory('pago_cuota');
	$do_pago_cuota -> pago_cuota_id = $record[$id];
	if ($do_pago_cuota -> find(true)){
		return $do_pago_cuota -> pago_cuota_monto;
	}
	else{
		return '';
	}
}

// Dada una fecha en formato ISO AAAAMMDD, la retorna en formato DD-MM-AAAA
function fechaAntiISO($date) {
	if ($date == null || !strlen($date))
	return array();
	else {
		$date2 = DB_DataObject_FormBuilder::_date2array($date);
		if (strlen($date2['d']) == 1) $date2['d'] = '0'.$date2['d'];
		if (strlen($date2['m']) == 1) $date2['m'] = '0'.$date2['m'];
		if ($date2['d'])
			return "{$date2['d']}-{$date2['m']}-{$date2['Y']}";
		else
			return array();
	}
}


/**
 * Modulo Liquidacion
 *
 * Detalle Liquidacion
 *
 * Funciones para la Grilla de Archivos
 */

function get_ver_errores($vals,$args){
	extract($vals);
	extract($args);
	return '<a href=descargar_log.php?contenido='.$record['archivo_id'].'>Descargar Informe</a>';
}
	
function get_fecha_subida($vals,$args){
	extract($vals);
	extract($args);
	return fechaAntiISO($record['archivo_imp_fecha']);
}

function get_usuario_subida($vals,$args){
	extract($vals);
	extract($args);
	$do_usuario = DB_DataObject::factory('usuario');
	$do_usuario -> usua_id = $record['archivo_imp_usuario_id'];
	if ($do_usuario -> find(true)){
		return $do_usuario -> usua_nombre;
	}
	else{
		return '-';
	}
}

function meses(){

	$meses = array();
	for ($i=1;$i<=12;$i++)
	{
		$meses[$i]=$i;
		if ( $i<10 ) $meses[$i]= "0".$i;
	}
	return $meses;

}

function anios(){

	$anios = array();
	$anio = date('Y');
	$anio = $anio - 7;
	$tope = date('Y');
	for ($i=$anio;$i<=$tope;$i++)
	{
		$anios[$i]=$i;
	}
	return $anios;
}
	

/**
 * Modulo Tipo de Concepto
 * 
 * recibe id de un tipo de concepto y retorna un link al script para modificarlo
 *
 * @param integer -> id de un tipo de concepto
 * @return string -> link al script para modificar un tipo de concepto
 */
function get_modificar_tipo_concepto($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_tipo_concepto.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Tipo de Concepto
 * 
 * recibe id de un tipo de concepto y retorna un link al script para eliminarlo
 *
 * @param integer -> id de un tipo de concepto
 * @return string -> link al script para modificar un tipo de concepto
 */
function get_eliminar_tipo_concepto($vals,$args){
	extract($vals);
	extract($args);
	
	$do_tipo_concepto = DB_DataObject::factory('tipo_concepto');
	$do_tipo_concepto -> tipo_concepto_id = $record[$id];
	$do_tipo_concepto -> tipo_concepto_baja = '0';
	if ($do_tipo_concepto -> find(true)){
		return "<a href=eliminar_tipo_concepto.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo Tipo de Concepto
 * 
 * recibe id de un tipo de concepto y retorna un icono de activo/inactivo
 *
 * @param integer -> id de un tipo de concepto
 * @return string -> icono de activo/inactivo
 */
function get_estado_tipo_concepto($vals,$args){
	extract($vals);
	extract($args);
	$do_tipo_concepto = DB_DataObject::factory('tipo_concepto');
	$do_tipo_concepto -> tipo_concepto_id = $record['tipo_concepto_id'];
	$do_tipo_concepto -> tipo_concepto_baja = '0';
	if($do_tipo_concepto -> find(true))
		return '<img title="Tipo de Concepto no eliminado" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Tipo de Concepto eliminado" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Concepto
 * 
 * recibe id de un concepto y retorna un link al script para modificarlo
 *
 * @param integer -> id de un concepto
 * @return string -> link al script para modificar un concepto
 */
function get_modificar_concepto($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=alta_concepto.php?contenido={$record[$id]}&m=si><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Concepto
 * 
 * recibe id de un concepto y retorna un icono de activo/inactivo
 *
 * @param integer -> id de concepto
 * @return string -> icono de activo/inactivo
 */
function get_estado_concepto($vals,$args){
	extract($vals);
	extract($args);
	$do_concepto = DB_DataObject::factory('concepto');
	$do_concepto -> concepto_id = $record['concepto_id'];
	$do_concepto -> concepto_baja = '0';
	if($do_concepto -> find(true))
		return '<img title="Concepto no eliminado" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Concepto eliminado" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Concepto
 * 
 * recibe id de un concepto y retorna un link para ver las empresas
 *
 * @param integer -> id de concepto
 * @return string -> link para ver las empresas
 */
function get_empresas_concepto($vals,$args){
	extract($vals);
	extract($args);

	return "<a href='#' title='Ver Empresas' onClick='verEmpresas(\"../concepto/ver_empresas.php?contenido=$record[$id]\",\"500\",\"300\")'><i class='fa fa-search text-bg text-danger'></i></a>";
}

/**
 * Modulo Concepto
 * 
 * recibe id de un concepto y retorna un link al script para eliminarlo
 *
 * @param integer -> id de un concepto
 * @return string -> link al script para eliminar un concepto
 */
function get_eliminar_concepto($vals,$args){
	extract($vals);
	extract($args);

	$do_concepto = DB_DataObject::factory('concepto');
	$do_concepto -> concepto_id = $record['concepto_id'];
	$do_concepto -> concepto_baja = '0';
	if($do_concepto -> find(true)){
		return "<a href=alta_concepto.php?contenido={$record[$id]}&e=si><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo Maestro Conpceto
 * 
 * recibe id de un concepto y id de una empresa y retorna el codigo y nombre del concepto utilizado por la empresa
 *
 * @param integer -> id de un concepto y id de una empresa
 * @return string -> codigo y nombre del concepto utilizado por la empresa
 */
function get_concepto_empresa($vals,$args){
	extract($vals);
	extract($args);

	$do_maestro_concepto = DB_DataObject::factory('maestro_concepto');
	$do_maestro_concepto -> maestro_concepto_concepto_id = $record[$concepto_id];
	$do_maestro_concepto -> maestro_concepto_empresa_id = $args['empresa_id'];
	$do_maestro_concepto -> maestro_concepto_vigencia = 1;
	$do_maestro_concepto -> find(true);
	return $do_maestro_concepto -> maestro_concepto_codigo.' - '.$do_maestro_concepto -> maestro_concepto_nombre;	
}

/**
 * Modulo Empresa
 * 
 * recibe id de una empresa y retorna un link al script para modificarla
 *
 * @param integer -> id de una empresa
 * @return string -> link al script para modificar una empresa
 */
function get_modificar_empresa($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_empresa.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Empresa
 * 
 * recibe id de una empresa y retorna un link al script para eliminarla
 *
 * @param integer -> id de una empresa
 * @return string -> link al script para modificar una empresa
 */
function get_eliminar_empresa($vals,$args){
	extract($vals);
	extract($args);
	
	$do_empresa = DB_DataObject::factory('empresa');
	$do_empresa -> empresa_id = $record[$id];
	$do_empresa -> empresa_baja = '0';
	if ($do_empresa -> find(true)){
		return "<a href=eliminar_empresa.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo Empresa
 * 
 * recibe id de una empresa y retorna un icono de activo/inactivo
 *
 * @param integer -> id de una empreas
 * @return string -> icono de activo/inactivo
 */
function get_estado_empresa($vals,$args){
	extract($vals);
	extract($args);
	$do_empresa = DB_DataObject::factory('empresa');
	$do_empresa -> empresa_id = $record['empresa_id'];
	$do_empresa -> empresa_baja = '0';
	if($do_empresa -> find(true))
		return '<img title="Empresa no eliminaa" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Empresa eliminada" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo convenio
 * 
 * recibe id de una convenio y retorna un link al script para modificarlo
 *
 * @param integer -> id de una convenio
 * @return string -> link al script para modificar una convenio
 */
function get_modificar_convenio($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_convenio.php?contenido={$record[$id]}><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo convenio
 * 
 * recibe id de una convenio y retorna un link al script para eliminarlo
 *
 * @param integer -> id de una convenio
 * @return string -> link al script para modificar un convenio
 */
function get_eliminar_convenio($vals,$args){
	extract($vals);
	extract($args);
	
	$do_convenio = DB_DataObject::factory('convenio');
	$do_convenio -> convenio_id = $record[$id];
	$do_convenio -> convenio_baja = '0';
	if ($do_convenio -> find(true)){
		return "<a href=eliminar_convenio.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo convenio
 * 
 * recibe id de una convenio y retorna un icono de activo/inactivo
 *
 * @param integer -> id de una empreas
 * @return string -> icono de activo/inactivo
 */
function get_estado_convenio($vals,$args){
	extract($vals);
	extract($args);
	$do_convenio = DB_DataObject::factory('convenio');
	$do_convenio -> convenio_id = $record['convenio_id'];
	$do_convenio -> convenio_baja = '0';
	if($do_convenio -> find(true))
		return '<img title="Convenio no eliminado" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Convenio eliminado" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Convenio
 * 
 * recibe id de un convenio y retorna un link para ver las empresas
 *
 * @param integer -> id de convenio
 * @return string -> link para ver las empresas
 */
function get_empresas_convenio($vals,$args){
	extract($vals);
	extract($args);

	return "<a href='#' title='Ver Empresas' onClick='verEmpresas(\"../convenio/ver_empresas.php?contenido=$record[$id]\",\"500\",\"300\")'><i class='fa fa-search text-bg text-danger'></i></a>";
}

/**
 * Modulo Puesto
 * 
 * recibe id de un Puesto y retorna un link al script para modificarlo
 *
 * @param integer -> id de un Puesto
 * @return string -> link al script para modificar un Puesto
 */
function get_modificar_puesto($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_puesto.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Puesto
 * 
 * recibe id de un Puesto y retorna un link al script para eliminarlo
 *
 * @param integer -> id de un Puesto
 * @return string -> link al script para modificar un Puesto
 */
function get_eliminar_puesto($vals,$args){
	extract($vals);
	extract($args);
	
	$do_puesto = DB_DataObject::factory('puesto');
	$do_puesto -> puesto_id = $record[$id];
	$do_puesto -> puesto_baja = '0';
	if ($do_puesto -> find(true)){
		return "<a href=eliminar_puesto.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo Puesto
 * 
 * recibe id de un Puesto y retorna un icono de activo/inactivo
 *
 * @param integer -> id de un Puesto
 * @return string -> icono de activo/inactivo
 */
function get_estado_puesto($vals,$args){
	extract($vals);
	extract($args);
	$do_puesto = DB_DataObject::factory('puesto');
	$do_puesto -> puesto_id = $record['puesto_id'];
	$do_puesto -> puesto_baja = '0';
	if($do_puesto -> find(true))
		return '<img title="Puesto no eliminado" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Puesto eliminado" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Pais
 * 
 * recibe id de un Pais y retorna un link al script para modificarlo
 *
 * @param integer -> id de un Pais
 * @return string -> link al script para modificar un Pais
 */
function get_modificar_pais($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_pais.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Pais
 * 
 * recibe id de un Pais y retorna un link al script para eliminarlo
 *
 * @param integer -> id de un Pais
 * @return string -> link al script para modificar un Pais
 */
function get_eliminar_pais($vals,$args){
	extract($vals);
	extract($args);
	
	$do_pais = DB_DataObject::factory('pais');
	$do_pais -> pais_id = $record[$id];
	$do_pais -> pais_baja = '0';
	if ($do_pais -> find(true)){
		return "<a href=eliminar_pais.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo Pais
 * 
 * recibe id de un Pais y retorna un icono de activo/inactivo
 *
 * @param integer -> id de un Pa&iacute;s
 * @return string -> icono de activo/inactivo
 */
function get_estado_pais($vals,$args){
	extract($vals);
	extract($args);
	$do_pais = DB_DataObject::factory('pais');
	$do_pais -> pais_id = $record['pais_id'];
	$do_pais -> pais_baja = '0';
	if($do_pais -> find(true))
		return '<img title="Pa&iacute;s no eliminado" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Pa&iacute;s eliminado" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Provincia
 * 
 * recibe id de un Provincia y retorna un link al script para modificarlo
 *
 * @param integer -> id de un Provincia
 * @return string -> link al script para modificar un Provincia
 */
function get_modificar_provincia($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_provincia.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Provincia
 * 
 * recibe id de un Provincia y retorna un link al script para eliminarlo
 *
 * @param integer -> id de un Provincia
 * @return string -> link al script para modificar un Provincia
 */
function get_eliminar_provincia($vals,$args){
	extract($vals);
	extract($args);
	
	$do_provincia = DB_DataObject::factory('provincia');
	$do_provincia -> provincia_id = $record[$id];
	$do_provincia -> provincia_baja = '0';
	if ($do_provincia -> find(true)){
		return "<a href=eliminar_provincia.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo Provincia
 * 
 * recibe id de un Provincia y retorna un icono de activo/inactivo
 *
 * @param integer -> id de un Provincia
 * @return string -> icono de activo/inactivo
 */
function get_estado_provincia($vals,$args){
	extract($vals);
	extract($args);
	$do_provincia = DB_DataObject::factory('provincia');
	$do_provincia -> provincia_id = $record['provincia_id'];
	$do_provincia -> provincia_baja = '0';
	if($do_provincia -> find(true))
		return '<img title="Provincia no eliminada" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Provincia eliminada" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Tipo de Archivo
 * 
 * recibe id de un Tipo de Archivo y retorna un link al script para modificarlo
 *
 * @param integer -> id de un Tipo de Archivo
 * @return string -> link al script para modificar un Tipo de Archivo
 */
function get_modificar_tipo_archivo($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_tipo_archivo.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Tipo de Archivo
 * 
 * recibe id de un Tipo de Archivo y retorna un link al script para eliminarlo
 *
 * @param integer -> id de un Tipo de Archivo
 * @return string -> link al script para modificar un Tipo de Archivo
 */
function get_eliminar_tipo_archivo($vals,$args){
	extract($vals);
	extract($args);
	
	$do_tipo_archivo = DB_DataObject::factory('tipo_archivo');
	$do_tipo_archivo -> tipo_archivo_id = $record[$id];
	$do_tipo_archivo -> tipo_archivo_baja = '0';
	if ($do_tipo_archivo -> find(true)){
		return "<a href=eliminar_tipo_archivo.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo Tipo de Archivo
 * 
 * recibe id de un Tipo de Archivo y retorna un icono de activo/inactivo
 *
 * @param integer -> id de un Tipo de Archivo
 * @return string -> icono de activo/inactivo
 */
function get_estado_tipo_archivo($vals,$args){
	extract($vals);
	extract($args);
	$do_tipo_archivo = DB_DataObject::factory('tipo_archivo');
	$do_tipo_archivo -> tipo_archivo_id = $record['tipo_archivo_id'];
	$do_tipo_archivo -> tipo_archivo_baja = '0';
	if($do_tipo_archivo -> find(true))
		return '<img title="Tipo de Archivo no eliminado" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Tipo de Archivo eliminado" src="../img/spirit20_icons/system-red.png">';

}

/**
 * Modulo Categoria
 * 
 * recibe id de un Categoria y retorna un link al script para modificarlo
 *
 * @param integer -> id de un Categoria
 * @return string -> link al script para modificar un Categoria
 */
function get_modificar_categoria($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_categoria.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Categoria
 * 
 * recibe id de un Categoria y retorna un link al script para eliminarlo
 *
 * @param integer -> id de un Categoria
 * @return string -> link al script para modificar un Categoria
 */
function get_eliminar_categoria($vals,$args){
	extract($vals);
	extract($args);
	
	$do_categoria = DB_DataObject::factory('categoria_convenio_empresa');
	$do_categoria -> categoria_id = $record[$id];
	$do_categoria -> categoria_baja = '0';
	if ($do_categoria -> find(true)){
		return "<a href=eliminar_categoria.php?contenido={$record[$id]}&accion=e><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo Categoria
 * 
 * recibe id de un Categoria y retorna un icono de activo/inactivo
 *
 * @param integer -> id de un Categoria
 * @return string -> icono de activo/inactivo
 */
function get_estado_categoria($vals,$args){
	extract($vals);
	extract($args);
	$do_categoria = DB_DataObject::factory('categoria_convenio_empresa');
	$do_categoria -> categoria_id = $record['categoria_id'];
	$do_categoria -> categoria_baja = '0';
	if ($do_categoria -> find(true))
		return '<img title="Categor&iacute;a no eliminada" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Categor&iacute;a eliminada" src="../img/spirit20_icons/system-red.png">';
}

/**
 * Modulo Localidad
 * 
 * recibe id de un Localidad y retorna un link al script para modificarlo
 *
 * @param integer -> id de un Localidad
 * @return string -> link al script para modificar un Localidad
 */
function get_modificar_localidad($vals,$args){
	extract($vals);
	extract($args);
	return "<a href=modificar_localidad.php?contenido={$record[$id]}&accion=m><i class='fa fa-edit text-bg text-danger'></i></a>";
}

/**
 * Modulo Localidad
 * 
 * recibe id de un Localidad y retorna un link al script para eliminarlo
 *
 * @param integer -> id de un Localidad
 * @return string -> link al script para modificar un Localidad
 */
function get_eliminar_localidad($vals,$args){
	extract($vals);
	extract($args);
	
	$do_localidad = DB_DataObject::factory('localidad');
	$do_localidad -> localidad_id = $record[$id];
	$do_localidad -> localidad_baja = '0';
	if ($do_localidad -> find(true)){
		return "<a href=eliminar_localidad.php?contenido={$record[$id]}><i class='fa fa-trash-o text-bg text-danger'></i></a>";
	}
}

/**
 * Modulo Localidad
 * 
 * recibe id de un Localidad y retorna un icono de activo/inactivo
 *
 * @param integer -> id de un Localidad
 * @return string -> icono de activo/inactivo
 */
function get_estado_localidad($vals,$args){
	extract($vals);
	extract($args);
	$do_localidad = DB_DataObject::factory('localidad');
	$do_localidad -> localidad_id = $record['localidad_id'];
	$do_localidad -> localidad_baja = '0';
	if($do_localidad -> find(true))
		return '<img title="Localidad no eliminada" src="../img/spirit20_icons/system-tick-alt-02.png">';
	else 
		return '<img title="Localidad eliminada" src="../img/spirit20_icons/system-red.png">';
}

// Dada una fecha en formato DD/MM/AAAA ó DD-MM-AAAA, la retorna en formato ISO AAAAMMDD
function fechaISO ($fecha,$separador) {
	list($dia, $mes, $anio) = split('[/,-]', $fecha);
	return $anio.$separador.$mes.$separador.$dia;
}

function get_contrato_fecha($vals,$args){
	extract($vals);
	extract($args);
	
	$do_contrato = DB_DataObject::factory('contrato');
	$do_contrato->get($record['contrato_id']);
	if ($record['contrato_id']!=null){
		$fecha = $do_contrato -> contrato_fecha;
		list($dia, $mes, $anio) = split('[/,-]', $fecha);
		return $anio.'/'.$mes.'/'.$dia;
		
	}else{
		return '-';
	}	
}

function get_fecha_alta_planta($vals,$args){
	extract($vals);
	extract($args);
	
	$do_planta = DB_DataObject::factory('planta');
	$do_planta->get($record['contrato_id']);
	if ($record['contrato_id']!=null){
		$fecha = $do_planta -> planta_fecha_alta;
		list($dia, $mes, $anio) = split('[/,-]', $fecha);
		if($dia != ''){
			return $anio.'/'.$mes.'/'.$dia;
		}
		
	}else{
		return '-';
	}	
}

function redireccion_planta($vals,$args){
	extract($vals);
	extract($args);
	
	$do_planta = DB_DataObject::factory('planta');
	$prue = $do_planta->get($record['contrato_id']);
	//print($prue); exit;
	return "<a href=../planta/alta_planta.php?contenido={$record['contrato_cliente_id']}&contenido1={$record['contrato_id']}&accion=a><i class='fa fa-edit text-bg text-danger'></i></a>";
}

?>