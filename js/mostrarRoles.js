/*function mostrarRoles(id,mod_id,app_id){
    //$("#tipoacceso p").hide();
    $("#tipoAcceso p").html("Cargando...");
    $("#tipoAcceso p").load("getPermisos.php?contenido=TipoAcceso&id="+id+"&mod_id="+mod_id+"&rol_id="+id+"&app_id="+app_id);
    $("#resumen p").load("setPermisos.php?tabla=rol&id="+id);
}*/

function mostrarRoles(id,app_id){
    //$("#tipoacceso p").hide();
    $("#tipoacceso p").html('');
    $("#roles p").html("Cargando...");
    $("#roles p").load("getPermisos.php?contenido=Permisos&id="+id+"&rol_id="+id+"&app_id="+app_id);
    $("#resumen p").load("setPermisos.php?tabla=rol&id="+id);
}