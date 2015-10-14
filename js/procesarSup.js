function procesarSup(ct_id,obj){
 	//Usando JQUERY, obtengo el value del option seleccionado de la lista paises.
    var check = obj.checked;
    if(check){
        check = 1;
        $("#table-selected-el_"+ ct_id).attr('checked', false);
        $("#table-selected-el_"+ ct_id).attr('disabled', true);
 
    }
    else{
        check = 0;
        $("#table-selected-el_"+ ct_id).attr('disabled', false);
    }

	$.ajax(
		{
		dataType: "html",
		type: "POST",

		// ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
		url: "proc_sorteo_manual_sup.php?ct_id=" + ct_id + "&check=" + check,

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