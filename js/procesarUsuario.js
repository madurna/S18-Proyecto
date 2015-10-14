function procesarUsuario(cli_id,tipo,obj){
 	//Usando JQUERY, obtengo el value del option seleccionado de la lista paises.
    var check = obj.checked;
    if(check){
        check = 1;
        
        $("#table-selected-sup_"+ cli_id).attr('disabled', false);

    }
    else{
        check = 0;
        //Usando JQUERY,        
        $("#table-selected-sup_"+ cli_id).attr('checked', false);
        $("#table-selected-sup_"+ cli_id).attr('disabled', true);

    }

	$.ajax(
		{
		dataType: "html",
		type: "POST",

		// ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
		url: "proc_sorteo_manual_usuario.php?cli_id=" + cli_id + "&check=" + check + "&tipo=" + tipo,
            
 		error: function(requestData, strError, strTipoError){
			alert("Error " + strTipoError +': ' + strError); //En caso de error mostraremos un alert
			},

		//fin de la llamada ajax.
		complete: function(requestData, exito){
			// En caso de usar una gif (cargando...) aqui quitas la imagen
			}
		}
	);
}