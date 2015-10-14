function procesarCT(ct_id,obj){
 	//Usando JQUERY, obtengo el value del option seleccionado de la lista paises.
    var check = obj.checked;
    if(check){
        check = 1;
    }
    else{
        check = 0;
    }

	$.ajax(
		{
		dataType: "html",
		type: "POST",

		// ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
		url: "proc_sorteo_manual_ct.php?ct_id=" + ct_id + "&check=" + check,
            
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