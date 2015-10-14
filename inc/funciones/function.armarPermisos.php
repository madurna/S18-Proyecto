<?php

function armarPermisos($do_usuario = null)
{
    $usuarios = array();
    
    while($do_usuario->fetch()){

		$usuarios['usuario']['id'] = $do_usuario->usua_id;
        $usuarios['usuario']['app_id'] = APP_ID;
        $usuarios['usuario']['nombre'] = $do_usuario->usua_usrid;
        $usuarios['usuario']['usua_email'] = $do_usuario->usua_email;
		$usuarios['usuario']['permisos'][$do_usuario->mod_nombre][$do_usuario->tipoacc_id] = $do_usuario->tipoacc_nombre;
        $usuarios['usuario']['permisos'][$do_usuario->modpag_scriptname][$do_usuario->tipoacc_id] = $do_usuario->tipoacc_nombre;

    }
    //Fecha de acceso
    $usuarios['usuario']['fecha_acceso'] = date("Y-m-d H:i:s");
    $usuarios['usuario']['minutos_control'] = 10;
    //print_r($usuarios);exit;
    return $usuarios;
}
?>