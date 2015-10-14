function mostrarTipoAcceso(obj){
    if(obj.checked){
        $("#resumen p").load("setPermisos.php?tabla=tipoacceso&id="+obj.value+"&check=1");
    }
    else{
        $("#resumen p").load("setPermisos.php?tabla=tipoacceso&id="+obj.value+"&check=0");
    }
}