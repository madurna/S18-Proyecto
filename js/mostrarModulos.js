/*function mostrarModulos(id,app_id){
    $("#tipoacceso p").html('');
    $("#roles p").html('Cargando...');
    $("#roles p").load("getPermisos.php?contenido=Roles&id="+id+"&mod_id="+id+"&app_id="+app_id);
    $("#resumen p").load("setPermisos.php?tabla=modulo&id="+id);
}*/

function mostrarModulos(id,app_id,rol_id){
    $("#tipoAcceso p").html('');
    $("#tipoAcceso p").html('Cargando...');
    $("#tipoAcceso p").load("getPermisos.php?contenido=TipoAcceso&id="+id+"&mod_id="+id+"&app_id="+app_id+"&rol_id="+rol_id);
    $("#resumen p").load("setPermisos.php?tabla=modulo&id="+id);
}